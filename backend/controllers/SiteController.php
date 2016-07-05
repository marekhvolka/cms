<?php
namespace backend\controllers;

use backend\models\Portal;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

use backend\components\IdentifierComponent;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'generate-identifier'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'generate-identifier'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->redirect(Url::to(['page/index']));
    }

    public function actionLogin()
    {
        $this->layout = 'login';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $portals = Portal::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            Yii::$app->session->set('portal_id', $model->portal_id);
            Yii::$app->params['portal'] = Portal::find()->where(['id' => $model->portal_id])->one();

            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
                'portals' => $portals
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
}
