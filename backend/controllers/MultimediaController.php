<?php

namespace backend\controllers;

use backend\components\PathHelper;
use backend\models\MultimediaCategory;
use backend\models\MultimediaItem;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * MultimediaController implements the CRUD actions for MultimediaCategory model.
 */
class MultimediaController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * Lists all MultimediaCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels'  => MultimediaCategory::loadAll(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'       => [
                'attributes' => ['name'],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new MultimediaCategory model.
     * If creation is successful, the browser will be redirected to the 'files' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MultimediaCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['files', 'name' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MultimediaCategory model.
     * @param string $name
     * @return mixed
     */
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($name != $model->name) { // if the category's name gets changed
                $model->rename($name);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MultimediaCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name category's name
     * @return mixed
     */
    public function actionDelete($name)
    {
        $this->findModel($name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * List the files of the given category.
     *
     * @param $name string name of the category
     * @param string|null $subcategory the name of the subcategory... defaults to null - show all files of all
     * subcategories
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFiles($name, $subcategory = null)
    {
        $model = $this->findModel($name);
        $upload_file = new MultimediaItem(['scenario' => MultimediaItem::SCENARIO_UPLOAD]);
        $upload_file->categoryName = $name;
        $upload_file->subcategory = $subcategory;

        // uploading new file
        if ($upload_file->load(Yii::$app->request->post())) {
            $upload_file->file = UploadedFile::getInstance($upload_file, 'file');

            if ($upload_file->validate()) {
                $upload_file->upload();
                $upload_file = new MultimediaItem(['scenario' => MultimediaItem::SCENARIO_UPLOAD]);;
                $upload_file->categoryName = $name;
            }
        }

        $request = Yii::$app->request;
        $file_action = $request->get('file-action');

        // deleting an item
        if (!empty($file_action)) {
            if ($file_action == "delete") {
                $item_to_delete = MultimediaItem::find($model->name, $request->get('item-subcategory'), $request->get('item-name'));
                if ($item_to_delete != null) {
                    $item_to_delete->delete();
                }
                $this->redirect(Url::current(['file-action' => null, 'item-name' => null, 'item-subcategory' => null]));
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels'  => $model->getItems($subcategory),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'       => [
                'attributes' => ['name'],
            ]
        ]);

        return $this->render('files', [
            'model'             => $model,
            'dataProvider'      => $dataProvider,
            'uploadFile'        => $upload_file,
            'activeSubcategory' => $subcategory
        ]);
    }

    /**
     * Return the content of a multimedia file.
     *
     * @param $name string the name of the file
     * @param $categoryName string the name of its category
     * @param $subcategory string the name of its subcategory
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFile($name, $categoryName, $subcategory)
    {
        $item = MultimediaItem::find($categoryName, $subcategory, $name);

        if ($item != null) {
            Yii::$app->response->format = Response::FORMAT_RAW;

            if (PathHelper::isImageFile($name)) {
                Yii::$app->response->headers->set('Content-Type', 'image/' . pathinfo($name, PATHINFO_EXTENSION));
                return $item->getContent();
            } else {
                return Yii::$app->response->sendFile($item->getPath());
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the MultimediaCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name
     * @return MultimediaCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = MultimediaCategory::find($name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
