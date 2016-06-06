<?php

namespace backend\controllers;

use backend\components\BlockModal\BlockModalWidget;
use backend\components\GlobalSearch\GlobalSearchWidget;
use backend\components\LayoutWidget\LayoutWidget;
use backend\models\Block;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

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

        $this->view->params['globalSearchModel'] = new GlobalSearchWidget();
    }

    public function actionChangeCurrentPortal($id)
    {
        $session = Yii::$app->session;
        $session->set('portal_id', $id);
        return $this->goBack();
    }

    /**
     * Action neccessary for LayoutWidget - appending one section at the end of the list.
     * @param type $type
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendSection($type)
    {
        return (new LayoutWidget())->appendSection($type);
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
