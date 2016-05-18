<?php

namespace backend\controllers;

use backend\components\GlobalSearch\GlobalSearchWidget;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * WordController implements the CRUD actions for Word model.
 */
abstract class BaseController extends Controller
{
    public function init()
    {
        parent::init();

      //  $this->cacheEngine = new CacheEngine();

        $this->view->params['globalSearchModel'] = new GlobalSearchWidget();
    }
}
