<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_var".
 * @property string $name
 * @property string $product_type
 */
class ProductVar extends Variable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_var';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            ['name' => 'Názov premennej']
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAllThatDoesntBelongToProduct($product_id)
    {
        $query = "variable.id not in (select variable_id from product_var_value where product_id = $product_id)";
        return ProductVar::find()->where($query);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAllThatBelongToProduct($product_id)
    {
        $query = "variable.id in (select variable_id from product_var_value where product_id = $product_id)";
        return ProductVar::find()->where($query);
    }
}
