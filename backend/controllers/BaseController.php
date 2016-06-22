<?php

namespace backend\controllers;

use backend\components\BlockModal\BlockModalWidget;
use backend\components\LayoutWidget\LayoutWidget;
use backend\models\Block;
use backend\models\Column;
use backend\models\Portal;
use backend\models\Row;
use backend\models\search\GlobalSearch;
use backend\models\Section;
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

        if(!empty($change_portal) && Portal::find()->where(['id' => $change_portal])->count() == 1){
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
     * Action necessary for LayoutWidget - appending one section at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     * @internal param string $type
     */
    public function actionAppendSection()
    {
        $type = Yii::$app->request->post('type');
        $portalId = Yii::$app->request->post('portalId');
        $pageId = Yii::$app->request->post('pageId');

        $section = new Section();
        $section->type = $type;
        $section->portal_id = $portalId;
        $section->page_id = $pageId;
        
        return (new LayoutWidget())->appendSection($section);
    }

    /**
     * Action necessary for LayoutWidget - appending one row at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendRow()
    {
        //$order = Yii::$app->request->post('order');
        $sectionId = Yii::$app->request->post('sectionId');

        $indexSection = Yii::$app->request->post('indexSection');

        $row = new Row();
        $row->section_id = $sectionId;

        return (new LayoutWidget())->appendRow($row, $indexSection);
    }

    public function actionAppendColumn()
    {
        $rowId = Yii::$app->request->post('rowId');
        $width = Yii::$app->request->post('width');

        $indexSection = Yii::$app->request->post('indexSection');
        $indexRow = Yii::$app->request->post('indexRow');

        $column = new Column();
        $column->row_id = $rowId;
        $column->width = $width;

        return (new LayoutWidget())->appendColumn($column, $indexSection, $indexRow);
    }

    /**
     * Action necessary for LayoutWidget - appending one block at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendBlock()
    {
        $columnId = Yii::$app->request->post('columnId');

        $indexSection = Yii::$app->request->post('indexSection');
        $indexRow = Yii::$app->request->post('indexRow');
        $indexColumn = Yii::$app->request->post('indexColumn');

        $block = new Block();
        $block->column_id = $columnId;
        $block->data = 'test'; // TODO test data.
        $block->type = 'text'; // TODO test data.

        return (new LayoutWidget())->appendBlock($block, $indexSection, $indexRow, $indexColumn);
    }

    public function actionBlock($id)
    {
        $block = Block::findOne(['id' => $id]);

        return (new BlockModalWidget())->appendModal($block);
    }
}
