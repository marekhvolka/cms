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
     * @param type $type
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendSection($type, $portalId = null, $pageId = null)
    {
        return (new LayoutWidget())->appendSection($type, $portalId, $pageId);
    }

    /**
     * Action neccessary for LayoutWidget - appending one row at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendRow()
    {
        $columnsWidth = Yii::$app->request->post('columns');
        $order = Yii::$app->request->post('order');
        $sectionId = Yii::$app->request->post('sectionId');

        return (new LayoutWidget())->appendRow($sectionId, $order, $columnsWidth);
    }

    /**
     * Action neccessary for LayoutWidget - appending one block at the end of the list.
     * @param type $id id of column.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendBlock($id)
    {
        return (new LayoutWidget())->appendBlock($id);
    }
}
