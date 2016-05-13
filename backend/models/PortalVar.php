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
     * @return \yii\db\ActiveQuery
     */
    public static function getAllThatDoesntBelongToPortal($portal_id)
    {
        $query = "variable.id not in (select var_id from portal_var_value where portal_id = $portal_id)";
        return PortalVar::find()->where($query);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAllThatBelongToPortal($portal_id)
    {
        $query = "variable.id in (select var_id from portal_var_value where portal_id = $portal_id)";
        return PortalVar::find()->where($query);
    }
}
