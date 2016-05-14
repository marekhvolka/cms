<?php

namespace backend\controllers;

use backend\components\GlobalSearchWidget;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * DictionaryController implements the CRUD actions for Dictionary model.
 */
abstract class BaseController extends Controller
{
    public function init()
    {
        parent::init();

        $this->view->params['globalSearchModel'] = new GlobalSearchWidget();
    }
}
