<?php

namespace backend\controllers;

use Yii;
use backend\components\LayoutWidget\LayoutWidget;
use yii\filters\VerbFilter;


class LayoutController extends BaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'append-row' => ['post'],
                ],
            ],
        ]);
    }
    
    /**
     * Action neccessary for LayoutWidget - appending one section at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendSection()
    {
        return (new LayoutWidget())->appendSection();
    }
    
    /**
     * Action neccessary for LayoutWidget - appending one row at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendRow()
    {
        $columnsWidth = Yii::$app->request->post('columns');
        $sectionId = Yii::$app->request->post('sectionId');
        
        return (new LayoutWidget())->appendRow($columnsWidth, $sectionId);
    }
}
