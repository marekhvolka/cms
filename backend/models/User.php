<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $pass
 * @property string $datum_vytvorenia
 * @property integer $active
 * @property string $allowPortal
 * @property integer $actualPortal
 * @property integer $role
 * @property integer $isLog
 * @property string $cookie_hash
 * @property string $lastLog
 *
 * @property Dictionary[] $dictionaries
 * @property LockTable[] $lockTables
 * @property Page[] $pages
 * @property PortalGlobal[] $portalGlobals
 * @property PortalVar[] $portalVars
 * @property Product[] $products
 * @property ProductTag[] $productTags
 * @property ProductTagMaster[] $productTagMasters
 * @property ProductType[] $productTypes
 * @property ProductVar[] $productVars
 * @property SOpravnenieTyp[] $sOpravnenieTyps
 * @property Snippet[] $snippets
 * @property Template[] $templates
 * @property TrackingCode[] $trackingCodes
 * @property UserActivity[] $userActivities
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
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
            [['name', 'surname', 'email', 'pass', 'active', 'allowPortal', 'actualPortal', 'role', 'isLog', 'cookie_hash'], 'required'],
            [['datum_vytvorenia', 'lastLog'], 'safe'],
            [['active', 'actualPortal', 'role', 'isLog'], 'integer'],
            [['name', 'surname', 'email', 'pass'], 'string', 'max' => 40],
            [['allowPortal', 'cookie_hash'], 'string', 'max' => 50],
            [['email'], 'unique']
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
            'surname' => 'Surname',
            'email' => 'Email',
            'pass' => 'Pass',
            'datum_vytvorenia' => 'Datum Vytvorenia',
            'active' => 'Active',
            'allowPortal' => 'Allow Portal',
            'actualPortal' => 'Actual Portal',
            'role' => 'Role',
            'isLog' => 'Is Log',
            'cookie_hash' => 'Cookie Hash',
            'lastLog' => 'Last Log',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictionaries()
    {
        return $this->hasMany(Dictionary::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLockTables()
    {
        return $this->hasMany(LockTable::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalGlobals()
    {
        return $this->hasMany(PortalGlobal::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalVars()
    {
        return $this->hasMany(PortalVar::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTags()
    {
        return $this->hasMany(ProductTag::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTagMasters()
    {
        return $this->hasMany(ProductTagMaster::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductVars()
    {
        return $this->hasMany(ProductVar::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOpravnenieTyps()
    {
        return $this->hasMany(SOpravnenieTyp::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippets()
    {
        return $this->hasMany(Snippet::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrackingCodes()
    {
        return $this->hasMany(TrackingCode::className(), ['last_edit_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserActivities()
    {
        return $this->hasMany(UserActivity::className(), ['user_id' => 'id']);
    }
}
