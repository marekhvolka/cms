<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property integer $portal_id
 * @property integer $active
 * @property integer $in_menu
 * @property integer $parent_id
 * @property integer $poradie
 * @property integer $product_id
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $color_scheme
 * @property integer $sidebar_active
 * @property string $sidebar_side
 * @property integer $sidebar_size
 * @property integer $footer_active
 * @property integer $header_active
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property Portal $portal
 * @property User $lastEditUser
 * @property Page $parent
 * @property Page[] $pages
 * @property Product $product
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
            [['name', 'identifier', 'portal_id', 'active', 'in_menu', 'color_scheme', 'sidebar_active', 'sidebar_side', 'footer_active', 'header_active'], 'required'],
            [['portal_id', 'active', 'in_menu', 'parent_id', 'poradie', 'product_id', 'sidebar_active', 'sidebar_size', 'footer_active', 'header_active', 'last_edit_user'], 'integer'],
            [['seo_description'], 'string'],
            [['last_edit'], 'safe'],
            [['name', 'identifier', 'color_scheme'], 'string', 'max' => 50],
            [['seo_title'], 'string', 'max' => 150],
            [['identifier', 'portal_id', 'parent_id'], 'unique', 'targetAttribute' => ['identifier', 'portal_id', 'parent_id'], 'message' => 'The combination of Identifier, Portal ID and Parent ID has already been taken.']
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
            'identifier' => 'Identifikátor',
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

    public function getUrl()
    {
        if (isset($this->parent))
            $url = $this->parent->url;
        else
            $url = '/';

        return  $url . $this->identifier . '/';
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
