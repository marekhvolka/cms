<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "var_type".
 *
 * @property integer $id
 * @property string $identifier
 * @property string $description
 * @property integer $show_snippet
 * @property integer $show_portal
 * @property integer $show_product
 *
 */
class VarType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'var_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identifier', 'show_snippet', 'show_portal', 'show_product'], 'required'],
            [['description'], 'string'],
            [['show_snippet', 'show_portal', 'show_product'], 'integer'],
            [['identifier', 'name'], 'string', 'max' => 50],
            [['string', 'max' => 7]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identifier' => 'Identifikátor',
            'description' => 'Popis',
            'show_snippet' => 'Ukáž snippet',
            'show_portal' => 'Ukáž portál',
            'show_product' => 'Ukáž produkt'
        ];
    }
}
