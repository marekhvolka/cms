<?php

namespace backend\controllers;

use backend\models\Area;
use backend\models\Block;
use backend\models\Portal;
use backend\models\Product;
use backend\models\search\SnippetSearch;
use backend\models\Snippet;
use backend\models\SnippetCode;
use backend\models\SnippetVar;
use backend\models\SnippetVarDefaultValue;
use backend\models\SnippetVarDropdown;
use common\components\Alert;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * SnippetController implements the CRUD actions for Snippet model.
 */
class SnippetController extends BaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * Lists all Snippet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SnippetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Snippet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Snippet();


            $model->portals = array();
            $model->portals[] = Yii::$app->user->identity->portal;

            $defaultSnippetCode = new SnippetCode();
            $defaultSnippetCode->name = 'default';

            $model->snippetCodes = array();
            $model->snippetCodes[] = $defaultSnippetCode;
        }

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && !Yii::$app->request->post('ajaxSubmit')) { // ajax validácia
                return $this->ajaxValidation($model);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->validateAndSave();

                $snippetCodesData = Yii::$app->request->post('SnippetCode');

                if ($snippetCodesData != null) {
                    foreach ($snippetCodesData as $index => $snippetCodeData) {
                        $model->loadFromData('snippetCodes', $snippetCodeData, $index, SnippetCode::className());
                    }
                }

                /* @var $snippetCode SnippetCode */
                foreach ($model->snippetCodes as $indexCode => $snippetCode) {
                    $snippetCode->snippet_id = $model->id;

                    if ($snippetCode->removed) {
                        $snippetCode->delete();
                        unset($model->snippetCodes[$indexCode]);
                        continue;
                    }

                    $snippetCode->validateAndSave();
                }

                $snippetVarsData = Yii::$app->request->post('SnippetVar');

                if ($snippetVarsData != null) {
                    $model->loadChildren('snippetFirstLevelVars', $snippetVarsData);
                }

                $model->saveChildren('snippetFirstLevelVars', 'snippet_id');


                $model->removeAssignedPortals();
                foreach(Yii::$app->request->post('portals') as $portalId) {
                    $model->assignPortal($portalId);
                }

                $transaction->commit();

                $model->resetAfterUpdate();

                return $this->redirectAfterSave($model);
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->redirectAfterFail($model);
            }
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Ajax action for appending one code (HTML in partial view) at the end
     * of codes list.
     * @return string rendered view for one code.
     */
    public function actionAppendCode()
    {
        $snippetCode = new SnippetCode();

        $indexCode = rand(1000, 100000);
        $prefix = "SnippetCode[$indexCode]";

        return $this->renderAjax('_code', [
            'model' => $snippetCode,
            'prefix' => $prefix
        ]);
    }

    /**
     * Ajax action for appending one variable (HTML in partial view) at the end
     * of variable list.
     * @return string rendered view for one variable.
     */
    public function actionAppendVar()
    {
        $snippetVar = new SnippetVar();

        $prefix = Yii::$app->request->post('prefix');

        $indexVar = rand(1000, 1000000);

        return $this->renderAjax('_variable', [
            'model' => $snippetVar,
            'prefix' => $prefix . "[$indexVar]"
        ]);
    }

    /**
     * Ajax action for appending one wrapper of list item types children
     * variables of list type variable (HTML in partial view).
     * is without parent and new SnippetVar is created.
     * @return string rendered view for one wrapper box.
     */
    public function actionAppendListBox()
    {
        $id = Yii::$app->request->post('id');

        $snippetVar = $id == null ? new SnippetVar() : SnippetVar::find()->where(['id' => $id])->one();

        $prefix = Yii::$app->request->post('prefix');

        return $this->renderAjax('_child-var-box', [
            'model' => $snippetVar,
            'prefix' => $prefix
        ]);
    }

    /**
     * Ajax action for appending one wrapper of
     * @return string rendered view for one wrapper box.
     */
    public function actionAppendDefaultValue()
    {
        $indexDefaultValue = rand(1000, 10000);

        $parentPrefix = Yii::$app->request->post('parentPrefix');

        return $this->renderAjax('_variable-default-val', [
            'defaultValue' => new SnippetVarDefaultValue(),
            'parentPrefix' => Yii::$app->request->post('parentPrefix'),
            'prefix' => $parentPrefix . "[SnippetVarDefaultValue][$indexDefaultValue]",
            'forProductType' => true
        ]);
    }

    /**
     * Ajax action for appending one wrapper of
     * @return string rendered view for one wrapper box.
     */
    public function actionAppendDropdownValue()
    {
        $indexDropdownValue = rand(1000, 10000);

        $parentPrefix = Yii::$app->request->post('parentPrefix');

        return $this->renderAjax('_variable-dropdown-val', [
            'model' => new SnippetVarDropdown(),
            'parentPrefix' => Yii::$app->request->post('parentPrefix'),
            'prefix' => $parentPrefix . "[SnippetVarDropdownValue][$indexDropdownValue]",
        ]);
    }

    public function actionHardReset($id)
    {
        Snippet::findOne($id)->getMainCacheFile(true);
    }

    public function actionCodeUsage($id)
    {
        $code = SnippetCode::findOne($id);

        if ($code == null) {
            throw new NotFoundHttpException('Požadovaná stránka neexistuje.');
        } else {
            /** @var Block[] $blocks */
            $pageAreas = [];
            $postAreas = [];
            $portalAreas = [];
            $portals = [];
            $products = [];

            foreach ($code->blocks as $block) {
                $owner = $block->getOwner();
                if ($owner instanceof Portal) {
                    $portals[] = [$owner, $block];
                } else if ($owner instanceof Area) {
                    if ($owner->page) {
                        $pageAreas[] = [$owner, $block, $owner->page];
                    } else if ($owner->portal) {
                        $portalAreas[] = [$owner, $block, $owner->portal];
                    } else if ($owner->post) {
                        $postAreas[] = [$owner, $block, $owner->post];
                    }
                } else if ($owner instanceof Product) {
                    $products[] = [$owner, $block];
                }
            }
            return $this->renderPartial("_code-usage", [
                'pageAreas' => $pageAreas,
                'postAreas' => $postAreas,
                'portalAreas' => $portalAreas,
                'portals' => $portals,
                'products' => $products
            ]);
        }
    }

    /**
     * Finds the Snippet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Snippet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Snippet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Požadovaná stránka neexistuje.');
        }
    }
}
