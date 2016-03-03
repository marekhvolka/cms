<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $portal_id
 * @property integer $active
 * @property integer $in_menu
 * @property integer $parent_id
 * @property integer $poradie
 * @property integer $product_id
 * @property string $presmerovanie
 * @property string $utm
 * @property integer $presmerovanie_aktivne
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $layout_poradie
 * @property string $layout_poradie_id
 * @property string $layout_element
 * @property string $layout_element_type
 * @property string $layout_element_active
 * @property string $layout_element_time_from
 * @property string $layout_element_time_to
 * @property string $color_scheme
 * @property integer $sidebar
 * @property string $sidebar_side
 * @property integer $sidebar_size
 * @property integer $footer
 * @property integer $header
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property Portal $portal
 * @property User $lastEditUser
 * @property Page $parent
 * @property Page[] $pages
 * @property Product $product
 * @property PageBlockSett[] $pageBlockSetts
 * @property PageFooter[] $pageFooters
 * @property PageFormSett[] $pageFormSetts
 * @property PageHeader[] $pageHeaders
 * @property PageSidebar[] $pageSidebars
 * @property PageSnippet[] $pageSnippets
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
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
            [['name', 'url', 'portal_id', 'active', 'in_menu', 'poradie', 'presmerovanie_aktivne', 'layout_poradie', 'layout_poradie_id', 'layout_element', 'layout_element_type', 'layout_element_active', 'layout_element_time_from', 'layout_element_time_to', 'color_scheme', 'sidebar', 'sidebar_side', 'footer', 'header'], 'required'],
            [['portal_id', 'active', 'in_menu', 'parent_id', 'poradie', 'product_id', 'presmerovanie_aktivne', 'sidebar', 'sidebar_size', 'footer', 'header', 'last_edit_user'], 'integer'],
            [['seo_description', 'layout_element', 'layout_element_type', 'layout_element_active', 'layout_element_time_from', 'layout_element_time_to'], 'string'],
            [['last_edit'], 'safe'],
            [['name', 'url', 'presmerovanie', 'layout_poradie', 'color_scheme'], 'string', 'max' => 50],
            [['utm'], 'string', 'max' => 200],
            [['seo_title'], 'string', 'max' => 150],
            [['layout_poradie_id'], 'string', 'max' => 255],
            [['sidebar_side'], 'string', 'max' => 5],
            [['url', 'portal_id', 'parent_id'], 'unique', 'targetAttribute' => ['url', 'portal_id', 'parent_id'], 'message' => 'The combination of Url, Portal ID and Parent ID has already been taken.']
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
            'url' => 'Url',
            'portal_id' => 'Portál',
            'active' => 'Active',
            'in_menu' => 'In Menu',
            'parent_id' => 'Predok',
            'poradie' => 'Poradie',
            'product_id' => 'Produkt',
            'presmerovanie' => 'Presmerovanie',
            'utm' => 'Utm',
            'presmerovanie_aktivne' => 'Presmerovanie Aktivne',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
            'seo_keywords' => 'Seo Keywords',
            'layout_poradie' => 'Layout Poradie',
            'layout_poradie_id' => 'Layout Poradie ID',
            'layout_element' => 'Layout Element',
            'layout_element_type' => 'Layout Element Type',
            'layout_element_active' => 'Layout Element Active',
            'layout_element_time_from' => 'Layout Element Time From',
            'layout_element_time_to' => 'Layout Element Time To',
            'color_scheme' => 'Farebná schéma',
            'sidebar' => 'Sidebar',
            'sidebar_side' => 'Sidebar Side',
            'sidebar_size' => 'Sidebar Size',
            'footer' => 'Footer',
            'header' => 'Header',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User',
        ];
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
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Page::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'id']);
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
    public function getPageBlockSetts()
    {
        return $this->hasMany(PageBlockSett::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageFooters()
    {
        return $this->hasMany(PageFooter::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageFormSetts()
    {
        return $this->hasMany(PageFormSett::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageHeaders()
    {
        return $this->hasMany(PageHeader::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageSidebars()
    {
        return $this->hasMany(PageSidebar::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageSnippets()
    {
        return $this->hasMany(PageSnippet::className(), ['page_id' => 'id']);
    }
}
