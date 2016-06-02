<?php
namespace common\widgets\FileEditor;

use common\widgets\FileEditor\models\EditFileForm;
use common\widgets\FileEditor\models\UploadFileForm;
use DirectoryIterator;
use LogicException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use yii;

class FileEditorWidget extends \yii\bootstrap\Widget
{
    public $directory;
    public $compileScss = false;
    public $compileTo = null;

    public function init()
    {
        parent::init();

        if (empty($this->directory) || !is_dir($this->directory)) {
            throw new \InvalidArgumentException('Given directory does not exist.');
        }

        if (Yii::$app->request->getIsAjax()) {
            $file = Yii::$app->request->get('file');
            Yii::$app->response->content = file_get_contents($this->directory . '/' . $file);
            Yii::$app->response->send();
            die;
        }

        if (!empty(Yii::$app->request->get('file')) && !empty(Yii::$app->request->get('fileAction'))) {
            if (Yii::$app->request->get('fileAction') == 'delete') {
                $realpath = realpath($this->directory . Yii::$app->request->get('file'));
                if (strrpos($realpath, realpath($this->directory), -strlen($realpath)) !== false) {
                    if (is_dir($realpath)) {
                        $it = new RecursiveDirectoryIterator($realpath, RecursiveDirectoryIterator::SKIP_DOTS);
                        $files = new RecursiveIteratorIterator($it,
                            RecursiveIteratorIterator::CHILD_FIRST);
                        foreach ($files as $file) {
                            if ($file->isDir()) {
                                rmdir($file->getRealPath());
                            } else {
                                unlink($file->getRealPath());
                            }
                        }
                        rmdir($realpath);
                    } else {
                        unlink($realpath);
                    }
                }

                Yii::$app->response->redirect(yii\helpers\Url::current(['fileAction' => null, 'file' => null]));
            }
        }
    }

    private function normalizePath($path, $separator = '\\/')
    {
        // Remove any kind of funky unicode whitespace
        $normalized = preg_replace('#\p{C}+|^\./#u', '', $path);

        // Path remove self referring paths ("/./").
        $normalized = preg_replace('#/\.(?=/)|^\./|\./$#', '', $normalized);

        // Regex for resolving relative paths
        $regex = '#\/*[^/\.]+/\.\.#Uu';

        while (preg_match($regex, $normalized)) {
            $normalized = preg_replace($regex, '', $normalized);
        }

        if (preg_match('#/\.{2}|\.{2}/#', $normalized)) {
            throw new LogicException('Path is outside of the defined root, path: [' . $path . '], resolved: [' . $normalized . ']');
        }

        return trim($normalized, $separator);
    }

    public function run()
    {
        $edit_file_form = new EditFileForm();
        $upload_file_form = new UploadFileForm($this->directory);

        if ($edit_file_form->load(Yii::$app->request->post()) && $edit_file_form->validate()) {
            $realpath = '/' . $this->normalizePath(realpath($this->directory) . $edit_file_form->fileName); //realpath cannot
            // be used, since the file may not exist
            if (strrpos($realpath, realpath($this->directory), -strlen($realpath)) !== false) {
                file_put_contents($realpath, $edit_file_form->text);
            }
        }

        if ($upload_file_form->load(Yii::$app->request->post())) {
            $upload_file_form->file = yii\web\UploadedFile::getInstance($upload_file_form, 'file');
            if ($upload_file_form->validate()) {
                $path = $upload_file_form->upload(false);
                $edit_file_form->fileName = $upload_file_form->directory . '/' . $upload_file_form->file->getBaseName
                    () . '.' . $upload_file_form->file->getExtension();
                $edit_file_form->text = file_get_contents($path);
            }

        }

        $fileTree = $this->buildTreeForDirectory($this->directory);

        return $this->render('file-editor', [
            'directory'      => $this->directory,
            'fileTree'       => $fileTree,
            'editFileForm'   => $edit_file_form,
            'uploadFileForm' => $upload_file_form
        ]);
    }

    private function buildTreeForDirectory($directory)
    {
        $tree = [];
        foreach (new DirectoryIterator($directory) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }
            if ($fileInfo->isDir()) {
                $tree[$fileInfo->getFilename()] = $this->buildTreeForDirectory($fileInfo->getRealPath());
                continue;
            };

            $tree[] = $fileInfo->getFilename();
        }

        return $tree;
    }
}
