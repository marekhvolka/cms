<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property string $identifier
 * @property integer $active
 * @property string $product_type
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property string $value
 * @property Tag[] $products
 * @property User $lastEditUser
 * @property SnippetVarValue[] $snippetVarValues
 */
class Tag extends CustomModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    public function init()
    {
        $this->active = 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'label', 'identifier', 'active', 'product_type'], 'required'],
            [['active', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name', 'label', 'identifier'], 'string', 'max' => 50],
            [['product_type'], 'string', 'max' => 100],
            [['identifier'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Systémový názov',
            'label' => 'Názov',
            'identifier' => 'Identifikátor',
            'active' => 'Aktívny',
            'product_type' => 'Typy produktov',
            'last_edit' => 'Dátum poslednej zmeny',
            'last_edit_user' => 'Naposledy editoval',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        //TODO: fix
        return $this->hasMany(Product::className(), ['tag_id' => 'id']);
    }

    public function getSnippetVarValues()
    {
        return $this->hasMany(SnippetVarValue::className(), ['value_tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /**
     * Vrati objekt podstranky spolu so zoznamom zakladnych premennych
     */
    public function getValue()
    {
        $buffer = '(object) array(' . PHP_EOL;

        $buffer .= '\'label\' => \'' . Yii::$app->dataEngine->normalizeString($this->label) . '\', ' . PHP_EOL;
        $buffer .= '\'id\' => \'' . $this->identifier . '\', ' . PHP_EOL;

        $buffer .= ')';

        return $buffer;
    }

    public function resetAfterUpdate()
    {
        foreach ($this->products as $product) {
            $product->resetAfterUpdate();
        }

        foreach ($this->snippetVarValues as $snippetVarValue) {
            $snippetVarValue->resetAfterUpdate();
        }
    }
}
