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

    /**
     * @param $portal_id
     * @return \yii\db\ActiveQuery
     */
    public static function getAllThatDoesntBelongToPortal($portal_id)
    {
        $query = "variable.id NOT IN (SELECT var_id FROM portal_var_value WHERE portal_id = $portal_id)";
        return PortalVar::find()->where($query);
    }

    /**
     * @param $portal_id
     * @return \yii\db\ActiveQuery
     */
    public static function getAllThatBelongToPortal($portal_id)
    {
        $query = "variable.id IN (SELECT var_id FROM portal_var_value WHERE portal_id = $portal_id)";
        return PortalVar::find()->where($query);
    }
}
