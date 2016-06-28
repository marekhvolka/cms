<?php

namespace backend\controllers;

use backend\models\search\SnippetSearch;
use backend\models\Snippet;
use backend\models\SnippetCode;
use backend\models\SnippetVar;
use backend\models\SnippetVarDefaultValue;
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
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!($model->validate() && $model->save())) {
                    throw new \yii\base\Exception;
                }

                $snippetCodesData = Yii::$app->request->post('SnippetCode');

                if ($snippetCodesData != null) {
                    foreach ($snippetCodesData as $index => $snippetCodeData) {
                        $model->loadFromData('snippetCodes', $snippetCodeData, $index, SnippetCode::className());
                    }

                    foreach ($model->snippetCodes as $snippetCode) {
                        $snippetCode->snippet_id = $model->id;

                        if (!($snippetCode->validate() && $snippetCode->save())) {
                            throw new \yii\base\Exception;
                        }
                    }
                }

                $snippetVarsData = Yii::$app->request->post('SnippetVar');

                if ($snippetVarsData != null) {

                    foreach ($snippetVarsData as $index => $snippetVarData) {
                        $model->loadFromData('snippetFirstLevelVars', $snippetVarsData, $index,
                            SnippetVar::className());

                        if (key_exists('Children', $snippetVarData)) {
                            $model->snippetFirstLevelVars[$index]->loadChildren('children', $snippetVarData['Children']);
                        }
                    }
                    foreach ($model->snippetFirstLevelVars as $snippetVar) {
                        $snippetVar->snippet_id = $model->id;
                        if (!($snippetVar->validate() && $snippetVar->save())) {
                            throw new \yii\base\Exception;
                        }

                        $snippetVar->saveChildren('children');
                    }
                }

                $transaction->commit();

                $model->resetAfterUpdate();

                $continue = Yii::$app->request->post('continue');

                if (isset($continue)) {
                    return $this->redirect(['edit', 'id' => $model->id]);
                } else {
                    return $this->redirect(['index']);
                }

            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->render('edit', [
                    'model' => $model,
                ]);
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
     * @param int $id parents id (list type parent), default null - variable is without parent.
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
     * @param int $id parents id (list type parent), default null - variable
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
        return $this->renderAjax('_variable-default-val', ['defaultValue' => new SnippetVarDefaultValue()]);
    }

    /**
     * Deletes an existing Snippet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
