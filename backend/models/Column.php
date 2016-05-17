<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "column".
 *
 * @property integer $id
 * @property integer $row_id
 * @property integer $order
 * @property integer $width
 * @property string $css_id
 * @property string $css_style
 * @property string $css_class
 *
 * @property Row $row
 * @property Block[] $pageBlocks
 */
class Column extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'column';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['row_id', 'order', 'width'], 'integer'],
            [['css_style', 'css_class', 'css_id'], 'string'],
            [['row_id'], 'exist', 'skipOnError' => true, 'targetClass' => Row::className(), 'targetAttribute' => ['row_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'row_id' => 'Row ID',
            'order' => 'Order',
            'width' => 'Width',
            'css_id' => 'ID stĺpca',
            'css_class' => 'Class stĺpca',
            'css_style' => 'Štýly stĺpca'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRow()
    {
        return $this->hasOne(Row::className(), ['id' => 'row_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageBlocks()
    {
        return $this->hasMany(Block::className(), ['column_id' => 'id'])
            ->orderBy(['order' => SORT_ASC]);
    }
}
