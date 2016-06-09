<?php

namespace backend\controllers;

use Yii;
use backend\components\LayoutWidget\LayoutWidget;
use yii\filters\VerbFilter;


class LayoutController extends BaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'append-row' => ['post'],
                ],
            ],
        ]);
    }
}
