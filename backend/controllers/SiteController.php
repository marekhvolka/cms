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
use yii\web\Cookie;

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

        $defaultPortal = Portal::find()->where([
            'domain' => str_replace('www.', '', $_SERVER['HTTP_HOST'])
        ])
            ->one();

        if ($defaultPortal) {
            $model->portal_id = $defaultPortal->id;
        }

        $portals = Portal::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $this->changeCurrentPortal($model->portal_id);

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
