<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "section".
 *
 * @property integer $id
 * @property string $page_id
 * @property integer $portal_id
 * @property string $options
 * @property string $type
 * @property string css_class
 * @property string css_id
 * @property string css_style
 *
 * @property Row[] $rows
 * @property Page $page
 * @property Portal $portal
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['id'], 'unique'],
            [['page_id', 'portal_id'], 'integer'],
            [['options', 'css_class', 'css_style', 'css_id'], 'string'],
            [['type'], 'string', 'max' => 10],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['portal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['portal_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'portal_id' => 'Portal ID',
            'options' => 'Options',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRows()
    {
        return $this->hasMany(Row::className(), ['section_id' => 'id']);
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
}
