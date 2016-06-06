<?php
namespace backend\components\FileEditor;

use backend\components\FileEditor\models\CreateDirectoryForm;
use backend\components\FileEditor\models\EditFileForm;
use backend\components\FileEditor\models\UploadFileForm;
use DirectoryIterator;
use InvalidArgumentException;
use LogicException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use yii;
use yii\bootstrap\Widget;
use yii\helpers\Url;
use yii\web\UploadedFile;

class FileEditorWidget extends Widget
{
    public $directory;
    public $compileScss = false;
    public $compileTo = null;

    public function init()
    {
        parent::init();

        if (empty($this->directory) || !is_dir($this->directory)) {
            throw new InvalidArgumentException('Given directory does not exist.');
        }

        if (!empty(Yii::$app->request->get('file'))) {
            if (!empty(Yii::$app->request->get('fileAction'))) {
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

                    Yii::$app->response->redirect(Url::current(['fileAction' => null, 'file' => null]));
                }
            } else {
                $file = Yii::$app->request->get('file');
                Yii::$app->response->content = file_get_contents($this->directory . '/' . $file);
                Yii::$app->response->send();
                die;
            }
        }
    }

    public function run()
    {
        $edit_file_form = new EditFileForm();
        $is_image_loaded = false;
        $upload_file_form = new UploadFileForm($this->directory);
        $create_directory_form = new CreateDirectoryForm($this->directory);

        if ($edit_file_form->load(Yii::$app->request->post()) && $edit_file_form->validate()) {
            $realpath = '/' . self::normalizePath($this->directory . $edit_file_form->fileName); //realpath cannot
            // be used, since the file may not exist
            if (strrpos($realpath, realpath($this->directory), -strlen($realpath)) !== false) {
                file_put_contents($realpath, $edit_file_form->text);
            }
        }

        if ($upload_file_form->load(Yii::$app->request->post())) {
            $upload_file_form->file = UploadedFile::getInstance($upload_file_form, 'file');
            if ($upload_file_form->validate()) {
                $path = $upload_file_form->upload(false);
                $edit_file_form->fileName = $upload_file_form->directory . '/' . $upload_file_form->file->getBaseName() . '.' . $upload_file_form->file->getExtension();
                if (!in_array(mb_strtolower(pathinfo($edit_file_form->fileName, PATHINFO_EXTENSION)), ["jpg", "jpeg", "gif", "png"])) {
                    $edit_file_form->text = file_get_contents($path);
                } else {
                    $is_image_loaded = true;
                }
            }
        }

        if ($create_directory_form->load(Yii::$app->request->post()) && $create_directory_form->validate()) {
            $create_directory_form->create(false);
            $create_directory_form = new CreateDirectoryForm($this->directory);
        }

        $fileTree = $this->buildTreeForDirectory($this->directory);

        return $this->render('file-editor', [
            'directory'      => $this->directory,
            'fileTree'       => $fileTree['with-files'],
            'directoryTree'  => array_merge(["/" => "/"], $fileTree['only-directories']),
            'editFileForm'   => $edit_file_form,
            'uploadFileForm' => $upload_file_form,
            'createDirectoryForm' => $create_directory_form,
            'isImageLoaded'  => $is_image_loaded
        ]);
    }

    private function buildTreeForDirectory($directory)
    {
        $directoriesList = [];
        $tree = [];
        foreach (new DirectoryIterator($directory) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }
            if ($fileInfo->isDir()) {
                $built_tree = $this->buildTreeForDirectory($fileInfo->getRealPath());

                $full_path = str_replace(realpath($this->directory), "", $fileInfo->getRealPath());
                $directoriesList[$full_path] = $full_path;

                $directoriesList = array_merge($directoriesList, $built_tree['only-directories']);
                $tree[$fileInfo->getFilename()] = $built_tree["with-files"];
                continue;
            };

            $tree[] = $fileInfo->getFilename();
        }

        return ['with-files' => $tree, 'only-directories' => $directoriesList];
    }

    public static function makePath($path, $moveDeeper = false)
    {
        $dir = $moveDeeper ? pathinfo($path, PATHINFO_DIRNAME) : $path;

        if (is_dir($dir)) {
            return true;
        } else {
            if (self::makePath($dir, true)) {
                if (mkdir($dir)) {
                    chmod($dir, 0777);

                    return true;
                }
            }
        }

        return false;
    }

    public static function normalizePath($path, $separator = '\\/')
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
}
