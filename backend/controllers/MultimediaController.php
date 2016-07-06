<?php

namespace backend\controllers;

use Yii;

/**
 * MultimediaController implements the CRUD actions for MultimediaCategory model.
 */
class MultimediaController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
