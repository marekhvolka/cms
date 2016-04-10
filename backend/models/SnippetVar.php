<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "snippet_var".
 *
 * @property string $id
 * @property string $identifier
 * @property string $description
 * @property integer $type_id
 * @property string $default_value
 * @property string $snippet_id
 * @property string $parent_id
 * @property integer $page_var
 *
 * @property SnippetDropdown[] $snippetDropdowns
 * @property SnippetProductValue[] $snippetProductValues
 * @property ProductType[] $productTypes
 * @property SnippetVar $parent
 * @property SnippetVar[] $snippetVars
 * @property Snippet $snippet
 * @property VarType $type
 */
class SnippetVar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet_var';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identifier', 'type_id', 'snippet_id', 'page_var'], 'required'],
            [['description', 'default_value'], 'string'],
            [['type_id', 'snippet_id', 'parent_id', 'page_var'], 'integer'],
            [['identifier'], 'string', 'max' => 50],
            [['identifier', 'snippet_id', 'parent_id'], 'unique', 'targetAttribute' => ['identifier', 'snippet_id', 'parent_id'], 'message' => 'The combination of Identifier, Snippet ID and Parent ID has already been taken.'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => SnippetVar::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['snippet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Snippet::className(), 'targetAttribute' => ['snippet_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VarType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identifier' => 'Názov',
            'description' => 'Popis',
            'type_id' => 'Type ID',
            'default_value' => 'Predvolená hodnota',
            'snippet_id' => 'Snippet ID',
            'parent_id' => 'Parent ID',
            'page_var' => 'Page Var',
            'type' => 'Typ premennej',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetDropdowns()
    {
        return $this->hasMany(SnippetDropdown::className(), ['var_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetProductValues()
    {
        return $this->hasMany(SnippetProductValue::className(), ['var_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::className(), ['id' => 'product_type_id'])->viaTable('snippet_product_value', ['var_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(SnippetVar::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVars()
    {
        return $this->hasMany(SnippetVar::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippet()
    {
        return $this->hasOne(Snippet::className(), ['id' => 'snippet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(VarType::className(), ['id' => 'type_id']);
    }
}
