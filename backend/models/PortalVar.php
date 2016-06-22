<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "snippet_var".
 *
 * @property string $product_type
 */
class PortalVar extends Variable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'portal_var';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [

        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [

        ]);
    }

    public static function getPortalVarProperties()
    {
        return PortalVar::find()->andWhere('type_id <> 15')->all();
    }

    public static function getPortalVarSnippets()
    {
        return PortalVar::find()->andWhere('type_id = 15')->all();
    }
}
