<?php

namespace backend\controllers;


use backend\components\FileEditor\FileEditorWidget;
use Yii;

class ThanksController extends BaseController
{
    public function actionIndex()
    {
        /** @var FileEditorWidget $file_editor */
        $file_editor = Yii::createObject([
            'class' => FileEditorWidget::className(),
            'directory' => Yii::$app->dataEngine->getThanksDirectory(),
            'generatedUrlPrefix' => '{$portal->url|escapeUrl}' . urlencode('/thanks/'),
            'extraCompileBy' => array(Yii::$app->dataEngine, 'compileThanksFile')
        ]);

        $state = $file_editor->performActions();

        if($state === false){
            return $this->render('index', ['fileEditor' => $file_editor]);
        } else {
            return $state;
        }
    }
}