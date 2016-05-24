<?php
namespace common\widgets\FileEditor;

use common\widgets\FileEditor\models\EditFileForm;
use DirectoryIterator;
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
    }

    public function run()
    {
        $model = new EditFileForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $realpath = realpath($model->fileName);
            if (strrpos($realpath, realpath($this->directory), -strlen($realpath)) !== false) {
                file_put_contents($realpath, $model->text);
            }
        }

        $fileTree = $this->buildTreeForDirectory($this->directory);

        return $this->render('file-editor', [
            'directory' => $this->directory,
            'fileTree'  => $fileTree,
            'model'     => $model
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
