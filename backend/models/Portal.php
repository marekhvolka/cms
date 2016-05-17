<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "portal".
 *
 * @property integer $id
 * @property string $name
 * @property integer $language_id
 * @property string $domain
 * @property integer $template_id
 * @property string $color_scheme
 * @property integer $active
 * @property integer $published
 * @property integer $cached
 *
 * @property Page[] $pages
 * @property Language $language
 * @property Template $template
 * @property Block[] $portalSnippets
 * @property SnippetVarValue[] $portalVarValues
 */
class Portal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'portal';
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
            [['name', 'language_id', 'domain', 'template_id', 'color_scheme', 'active', 'published', 'cached'], 'required'],
            [['language_id', 'template_id', 'active', 'published', 'cached'], 'integer'],
            [['color_scheme'], 'string'],
            [['name', 'domain'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Názov',
            'language_id' => 'Krajina',
            'domain' => 'Doména',
            'template_id' => 'Šablóna',
            'color_scheme' => 'Farebná schéma',
            'active' => 'Active',
            'published' => 'Publikovaný',
            'cached' => 'Cache',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['portal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalSnippets()
    {
        return $this->hasMany(Block::className(), ['portal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalVarValues()
    {
        return $this->hasMany(PortalVarValue::className(), ['portal_id' => 'id']);
    }
}
