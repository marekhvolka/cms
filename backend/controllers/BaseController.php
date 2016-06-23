<?php

namespace backend\controllers;

use backend\components\BlockModal\BlockModalWidget;
use backend\components\LayoutWidget\LayoutWidget;
use backend\models\Block;
use backend\models\Column;
use backend\models\Page;
use backend\models\Portal;
use backend\models\Row;
use backend\models\search\GlobalSearch;
use backend\models\Section;
use Yii;
use yii\db\Query;
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

        $prefix = Yii::$app->request->post('prefix');

        $section = new Section();
        $section->type = $type;
        $section->portal_id = $portalId;
        $section->page_id = $pageId;

        $indexSection = rand(1000, 10000000);
        
        return (new LayoutWidget())->appendSection($section, $prefix, $indexSection);
    }

    /**
     * Action necessary for LayoutWidget - appending one row at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendRow()
    {
        $prefix = Yii::$app->request->post('prefix');

        $row = new Row();

        $indexRow = rand(1000, 10000000);

        return (new LayoutWidget())->appendRow($row, $prefix, $indexRow);
    }

    public function actionAppendColumns()
    {
        $width = Yii::$app->request->post('width');

        $prefix = Yii::$app->request->post('prefix');

        $columnsData = array();

        for($i = 0; $i < sizeof($width); $i++) {

            $column = new Column();
            $column->order = $i+1;
            $column->width = $width[$i];

            $indexColumn = rand(1000, 10000000);

            $columnsData[] = (new LayoutWidget())->appendColumn($column, $prefix, $indexColumn);
        }

        return json_encode($columnsData);
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

    public function actionCacheFromBuffer($limit = 20)
    {
        $query = 'SELECT * FROM cache_page ORDER BY priority DESC, added_at ASC LIMIT :limit';

        $command = Yii::$app->db->createCommand($query);
        $command->bindValue(':limit', $limit);

        $results = $command->queryAll();

        foreach($results as $row) {
            $page = Page::find()->where(['id' => $row['page_id']])->one();

            $page->getMainCacheFile(true);

            $removeQuery = 'DELETE FROM cache_page WHERE id = :id';

            $removeCommand = Yii::$app->db->createCommand($removeQuery);
            $removeCommand->bindValue(':id', $row['id']);

            $removeCommand->execute();
        }
    }
}
