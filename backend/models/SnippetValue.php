<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "snippet_value".
 *
 * @property integer $id
 * @property string $snippet_id
 * @property string $product_id
 * @property integer $portal_id
 * @property integer $column_id
 * @property integer $parent_id
 * @property integer $order
 * @property string $data
 *
 * @property Product $product
 * @property Column $column
 * @property SnippetValue $parent
 * @property SnippetValue[] $snippetValues
 * @property Portal $portal
 * @property Snippet $snippet
 */
class SnippetValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['snippet_id', 'product_id', 'portal_id', 'column_id', 'parent_id', 'order'], 'integer'],
            [['data'], 'string'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['column_id'], 'exist', 'skipOnError' => true, 'targetClass' => Column::className(), 'targetAttribute' => ['column_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => SnippetValue::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['portal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['portal_id' => 'id']],
            [['snippet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Snippet::className(), 'targetAttribute' => ['snippet_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'snippet_id' => 'Snippet ID',
            'product_id' => 'Product ID',
            'portal_id' => 'Portal ID',
            'column_id' => 'Column ID',
            'parent_id' => 'Parent ID',
            'order' => 'Order',
            'data' => 'Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumn()
    {
        return $this->hasOne(Column::className(), ['id' => 'column_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(SnippetValue::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetValues()
    {
        return $this->hasMany(SnippetValue::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortal()
    {
        return $this->hasOne(Portal::className(), ['id' => 'portal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippet()
    {
        return $this->hasOne(Snippet::className(), ['id' => 'snippet_id']);
    }
}