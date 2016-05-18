<?php

namespace backend\controllers;

use backend\components\GlobalSearch\GlobalSearchWidget;
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

      //  $this->cacheEngine = new CacheEngine();

        $this->view->params['globalSearchModel'] = new GlobalSearchWidget();
    }
}
