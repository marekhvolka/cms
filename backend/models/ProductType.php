<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $active
 * @property integer $last_edit_user
 * @property string $last_edit
 *
 * @property Product[] $products
 * @property User $lastEditUser
 * @property SnippetProductValue[] $snippetProductValues
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_type';
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
            [['name', 'active'], 'required'],
            [['active', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'active' => 'Active',
            'last_edit_user' => 'Last Edit User',
            'last_edit' => 'Last Edit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['type_id' => 'id']);
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
    public function getSnippetProductValues()
    {
        return $this->hasMany(SnippetProductValue::className(), ['product_type_id' => 'id']);
    }
}
