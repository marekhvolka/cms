<?php
namespace frontend\controllers;

use backend\models\Block;
use backend\models\Page;
use backend\models\Product;
use common\components\ParseEngine;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
        $parseEngine = new ParseEngine();

        $products = Product::find()->all();

        foreach($products as $product)
        {
            if ($product->parsed == 0)
            {
                $transaction = Yii::$app->db->beginTransaction();

                $parseEngine->parseProductSnippet($product);

                $product->parsed = 1;

                $product->save();

                $transaction->commit();
            }
        }

        $identifiers = explode("/", $url);

        $pages = Page::find()
            ->where([
            'parent_id' => null
        ])->all();

        $page = $this->findPage($pages, $identifiers, 0);

        if (!isset($page))
            $page = Page::find()
                ->where(['identifier' => '404'])->one();

        if ($page->portal->parsed == 0)
        {
            $transaction = Yii::$app->db->beginTransaction();

            $this->parsePortal($page->portal);

            $page->portal->parsed = 1;

            $page->portal->save();

            $transaction->commit();
        }

        if ($page->parsed == 0)
        {
            $transaction = Yii::$app->db->beginTransaction();

            $this->parsePage($page);

            $page->parsed = 1;
            $page->save();

            $transaction->commit();
        }

        if (isset($page))
            $path = $page->getMainCacheFile();

        if (isset($path))
            echo file_get_contents($path);
    }

    private function parsePortal($portal)
    {
        $parseEngine = new ParseEngine();

        $rows = $command = (new Query())
            ->select('*')
            ->from('portal_global')
            ->where(['portal_id' => $portal->id])
            ->createCommand()
            ->queryAll();

        foreach($rows as $row)
        {
            $parseEngine->parsePageGlobalSection('portal', $row);
        }

        foreach($portal->headerSections as $section)
        {
            foreach($section->rows as $row)
            {
                foreach($row->columns as $column)
                {
                    foreach($column->blocks as $block)
                    {
                        $block->data = $parseEngine->convertMacrosToLatteStyle($block->data);
                        $block->save();

                        $parseEngine->parseSnippetVarValues($block);
                    }
                }
            }
        }

        foreach($portal->footerSections as $section)
        {
            foreach($section->rows as $row)
            {
                foreach($row->columns as $column)
                {
                    foreach($column->blocks as $block)
                    {
                        $block->data = $parseEngine->convertMacrosToLatteStyle($block->data);
                        $block->save();

                        $parseEngine->parseSnippetVarValues($block);
                    }
                }
            }
        }

        $parseEngine->parsePortalSnippet($portal);
    }

    private function parsePage($page)
    {
        $parseEngine = new ParseEngine();

        $pageId = $page->id;

        $row = (new Query())
            ->select('*')
            ->from('page_sidebar')
            ->where(['page_id' => $pageId])
            ->createCommand()
            ->queryOne();

        $parseEngine->parseSidebar($row);

        $row = (new Query())
            ->select('*')
            ->from('page_footer')
            ->where(['page_id' => $pageId])
            ->createCommand()
            ->queryOne();

        $parseEngine->parsePageGlobalSection('page', $row);

        $row = (new Query())
            ->select('*')
            ->from('page_header')
            ->where(['page_id' => $pageId])
            ->createCommand()
            ->queryOne();

        $parseEngine->parsePageGlobalSection('page', $row);

        $row = $command = (new Query())
            ->select('*')
            ->from('page')
            ->where(['id' => $pageId])
            ->createCommand()
            ->queryOne();

        $parseEngine->parseMasterContent($row);

        /* @var $page Page */
        $page = Page::find()->where(['id' => $pageId])->one();

        $page->description = $parseEngine->convertMacrosToLatteStyle($page->description);
        $page->save();

        foreach($page->sections as $section)
        {
            foreach($section->rows as $row)
            {
                foreach($row->columns as $column)
                {
                    foreach($column->blocks as $block)
                    {
                        $block->data = $parseEngine->convertMacrosToLatteStyle($block->data);
                        $block->save();
                        $parseEngine->parseSnippetVarValues($block);
                    }
                }
            }
        }
    }

    private function findPage($pages, $identifiers, $index)
    {
        foreach($pages as $page)
        {
            if ($page->identifier == $identifiers[$index])
            {
                if ((sizeof($identifiers) > $index + 1 && $identifiers[$index+1] != ''))
                    return $this->findPage($page->pages, $identifiers, $index + 1);
                else
                    return $page;
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
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
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
}
