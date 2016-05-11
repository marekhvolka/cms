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
 * @property string $tbl_type
 *
 * @property Variable[] $variables
 */
class VariableType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variable_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identifier', 'show_snippet', 'show_portal', 'show_product', 'tbl_type'], 'required'],
            [['description'], 'string'],
            [['show_snippet', 'show_portal', 'show_product'], 'integer'],
            [['identifier'], 'string', 'max' => 50],
            [['tbl_type'], 'string', 'max' => 7]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identifier' => 'Názov typu',
            'description' => 'Popis',
            'show_snippet' => 'Show Snippet',
            'show_portal' => 'Show Portal',
            'show_product' => 'Show Product',
            'tbl_type' => 'Tbl Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariables()
    {
        return $this->hasMany(Variable::className(), ['type_id' => 'id']);
    }
}
