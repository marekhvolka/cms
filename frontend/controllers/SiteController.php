<?php
namespace frontend\controllers;

use backend\models\Page;
use backend\models\Portal;
use backend\models\Redirect;
use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($url = null)
    {
        if ($url[strlen($url) - 1] != '/')
            return $this->redirect($url . '/', '301');

        $identifiers = explode("/", strtolower($url));

        $portal = Portal::find()->where([
            'domain' => str_replace('www.', '', $_SERVER['HTTP_HOST'])
        ])
            ->one();

        if (!$portal) {
            if (Yii::$app->user->isGuest) {
                return '';
            } else {
                $portal = Yii::$app->user->identity->portal;
            }
        }

        if ($identifiers[0] == '') { //homepage
            $page = Page::find()->where([
                'parent_id' => null,
                'portal_id' => $portal->id,
                'identifier' => 'homepage'
            ])
                ->one();
        } else {
            $redirect = Redirect::find()
                ->where([
                    'portal_id' => $portal->id,
                    'source_url' => '/' . $url
                ])
                ->one();

            if ($redirect) {
                return $this->redirect($redirect->target_url, $redirect->redirect_type);
            }

            $pages = Page::find()
                ->where([
                    'parent_id' => null,
                    'portal_id' => $portal->id
                ])->all();

            $page = $this->findPage($pages, $identifiers, 0);
        }
        if (!isset($page)) {
            $page = Page::find()
                ->where([
                    'identifier' => '404',
                    'portal_id' => $portal->id
                ])->one();

            http_response_code(404);
        }

        if (isset($page)) {
            $reload = $page->isOutdated() && !Yii::$app->user->isGuest;;
            $path = $page->getMainCacheFile($reload);
        }

        if (isset($path)) {
            //echo file_get_contents($path);

            ob_start();
            include $path;
            $html = ob_get_contents();
            if (!Yii::$app->user->getIsGuest()) {
                $html = str_replace('</head>',
                    '<link rel="stylesheet" href="' . Url::to(['css/top-bar.css']) . '"></head>', $html);
                $html = str_replace('<body>',
                    '<body>' . $this->renderPartial('_top-bar', ['page' => $page, 'portal' => $portal]), $html);
            }
            ob_end_clean();
            echo $html;
        }
    }

    private function findPage($pages, $identifiers, $index)
    {
        foreach ($pages as $page) {
            if ($page->identifier == $identifiers[$index]) {
                if ((sizeof($identifiers) > $index + 1 && $identifiers[$index + 1] != '')) {
                    return $this->findPage($page->pages, $identifiers, $index + 1);
                } else {
                    return $page;
                }
            }
        }
        return null;
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionOldIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success',
                    'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionCacheFromBuffer($limit = 10, $portalId = null)
    {
        $query = Page::find()->where(['outdated' => 1]);

        if ($portalId) {
            $query->andWhere(['portal_id' => $portalId]);
        }

        $pages = $query->limit($limit)
            ->all();

        foreach ($pages as $page) {
            $page->getMainCacheFile(true);
        }
    }
}
