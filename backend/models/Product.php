<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $type_id
 * @property string $identifier
 * @property string $popis
 * @property integer $language_id
 * @property integer $active
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property Page[] $pages
 * @property User $lastEditUser
 * @property Language $language
 * @property Product $parent
 * @property Product[] $products
 * @property ProductSnippet[] $productSnippets
 * @property Tag[] $tags
 * @property VariableValue[] $variableValues
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
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
            [['name', 'type_id', 'identifier', 'language_id', 'active'], 'required'],
            [['parent_id', 'type_id', 'language_id', 'active', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name', 'identifier'], 'string', 'max' => 50],
            [['name', 'language_id'], 'unique', 'targetAttribute' => ['name', 'language_id'], 'message' => 'The combination of Name and Language ID has already been taken.'],
            [['identifier', 'language_id'], 'unique', 'targetAttribute' => ['identifier', 'language_id'], 'message' => 'The combination of Identifier and Language ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Názov',
            'parent_id' => 'Rodič',
            'type_id' => 'Typ produktu',
            'identifier' => 'Identifikátor',
            'popis' => 'Popis',
            'language_id' => 'Krajina',
            'active' => 'Active',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Naposledy editoval',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Product::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSnippets()
    {
        return $this->hasMany(PageBlock::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariableValues()
    {
        return $this->hasMany(VariableValue::className(), ['product_id' => 'id']);
    }

    public function relations()
    {
        return array(
            'product_vars' => array(self::HAS_MANY, 'Variables', 'product_var_value(product_id, var_id)'),
            'product_vars_value' => array(self::MANY_MANY, 'ProductVar', 'product_var_value(product_id, var_id)'),
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }
}
