<?php

namespace backend\controllers;

use backend\components\GlobalSearch\GlobalSearchWidget;
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
}
