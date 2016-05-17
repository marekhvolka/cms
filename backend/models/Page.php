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
 * @property integer $order
 * @property integer $product_id
 * @property string $title
 * @property string $description
 * @property string $keywords
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
 * @property Section[] $sections
 * @property Product $product
 *
 * @property Section[] $headerSections
 * @property Section[] $footerSections
 * @property Section $contentSection
 * @property Section $sidebarSection
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
            [['portal_id', 'active', 'in_menu', 'parent_id', 'order', 'product_id', 'sidebar_active', 'sidebar_size', 'footer_active', 'header_active', 'last_edit_user'], 'integer'],
            [['description'], 'string'],
            [['last_edit'], 'safe'],
            [['name', 'identifier', 'color_scheme'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 150],
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
            'order' => 'Poradie',
            'product_id' => 'Produkt',
            'presmerovanie' => 'Presmerovanie',
            'utm' => 'Utm',
            'presmerovanie_aktivne' => 'Presmerovanie Aktivne',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'color_scheme' => 'Farebná schéma',
            'sidebar_active' => 'Sidebar',
            'sidebar_side' => 'Sidebar Side',
            'sidebar_size' => 'Sidebar Size',
            'footer_active' => 'Footer',
            'header_active' => 'Header',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User'
        ];
    }

    /** Metoda na vyskladanie URL pre podstranku
     * @return string
     */
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
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        $product = $this->hasOne(Product::className(), ['id' => 'product_id']);

        if (!isset($product) && (isset($this->parent)))
            return $this->parent->product;
        return $product;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderSections()
    {
        return Section::findAll([
            'page_id' => $this->id,
            'type' => 'header'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFooterSections()
    {
        return Section::findAll([
            'page_id' => $this->id,
            'type' => 'footer'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentSection()
    {
        return Section::findOne([
            'page_id' => $this->id,
            'type' => 'content'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSidebarSection()
    {
        return Section::findOne([
            'page_id' => $this->id,
            'type' => 'sidebar'
        ]);
    }
}
