<?php

namespace backend\controllers;

use backend\components\BlockModal\BlockModalWidget;
use backend\components\LayoutWidget\LayoutWidget;
use backend\models\Block;
use backend\models\search\GlobalSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * WordController implements the CRUD actions for Word model.
 */
abstract class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ]
        ];
    }


    public function init()
    {
        parent::init();

        $change_portal = Yii::$app->request->get('change-portal');

        if(!empty($change_portal)){
            Yii::$app->session->set('portal_id', $change_portal);
        }
    }

    /**
     * Returns the result of the global search as JSON.
     * 
     * @param $q string the query to search by
     * @return array
     */
    public function actionGlobalSearchResults($q){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return (new GlobalSearch)->search($q);
    }

    /**
     * Action neccessary for LayoutWidget - appending one section at the end of the list.
     * @param type $type
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendSection()
    {
        $type = Yii::$app->request->post('type');
        $portalId = Yii::$app->request->post('portalId');
        $pageId = Yii::$app->request->post('pageId');
        
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

    public function actionBlock($id)
    {
        $block = Block::findOne(['id' => $id]);

        return (new BlockModalWidget())->appendModal($block);
    }
}
