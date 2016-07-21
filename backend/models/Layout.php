<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "layout".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $portal_id
 * @property integer $parent_id
 *
 * @property Area[] $areas
 * @property Block[] $blocks
 * @property Column[] $columns
 * @property Portal $portal
 * @property Layout $parent
 * @property Layout[] $layouts
 * @property Page[] $pages
 * @property Post[] $posts
 * @property Row[] $rows
 * @property Section[] $sections
 */
class Layout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'layout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'portal_id'], 'required'],
            [['description'], 'string'],
            [['portal_id', 'parent_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['portal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['portal_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Layout::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'description' => 'Description',
            'portal_id' => 'Portal ID',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['layout_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['layout_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumns()
    {
        return $this->hasMany(Column::className(), ['layout_id' => 'id']);
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
    public function getParent()
    {
        return $this->hasOne(Layout::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLayouts()
    {
        return $this->hasMany(Layout::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['layout_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['layout_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRows()
    {
        return $this->hasMany(Row::className(), ['layout_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['layout_id' => 'id']);
    }
}
