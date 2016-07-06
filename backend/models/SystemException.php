<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "system_exception".
 *
 * @property integer $id
 * @property string $time
 * @property string $message
 * @property string $source_code
 * @property string $source_name
 * @property int $page_id
 * @property int $portal_id
 * @property int $block_id
 * @property int $product_id
 * @property string $type
 *
 * @property Page $page
 * @property Product $product
 * @property Portal $portal
 * @property Block $block
 */
class SystemException extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_exception';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['portal_id', 'page_id', 'product_id', 'block_id'], 'integer'],
            [['message', 'type'], 'required'],
            [['message', 'type'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Identifier',
            'time' => 'Time',
            'message' => 'Message',
            'type' => 'Typ objektu',
            'page_id' => 'ID stránky',
            'portal_id' => 'ID portálu',
            'block_id' => 'ID bloku',
            'product_id' => 'ID produktu',
            'source_code' => 'Kód chyby',
            'source_name' => 'Súbor'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
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
    public function getBlock()
    {
        return $this->hasOne(Block::className(), ['id' => 'block_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getObject()
    {
        if ($this->page) {
            return $this->page;
        } else if ($this->portal) {
            return $this->portal;
        } else if ($this->block) {
            return $this->block;
        } else if ($this->product) {
            return $this->product;
        }
        return null;
    }
}
