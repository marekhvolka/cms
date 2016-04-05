<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "snippet".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $default_code_id
 * @property integer $snippet_type
 * @property string $sekcia_id
 * @property string $sekcia_class
 * @property string $sekcia_style
 * @property string $block_id
 * @property string $block_class
 * @property string $block_style
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property PortalSnippet[] $portalSnippets
 * @property ProductSnippet[] $productSnippets
 * @property SnippetCode $defaultCode
 * @property User $lastEditUser
 * @property SnippetCode[] $snippetCodes
 * @property SnippetVar[] $snippetVars
 */
class Snippet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'default_code_id', 'snippet_type'], 'required'],
            [['default_code_id', 'snippet_type', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['sekcia_id', 'sekcia_class', 'sekcia_style', 'block_id', 'block_class', 'block_style'], 'string', 'max' => 30],
            [['name'], 'unique']
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
            'description' => 'Popis',
            'default_code_id' => 'Default Code ID',
            'snippet_type' => 'Typ Snippet',
            'sekcia_id' => 'Sekcia ID',
            'sekcia_class' => 'Sekcia Class',
            'sekcia_style' => 'Sekcia Style',
            'block_id' => 'Block ID',
            'block_class' => 'Block Class',
            'block_style' => 'Block Style',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalSnippets()
    {
        return $this->hasMany(PortalSnippet::className(), ['snippet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSnippets()
    {
        return $this->hasMany(ProductSnippet::className(), ['snippet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultCode()
    {
        return $this->hasOne(SnippetCode::className(), ['id' => 'default_code_id']);
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
    public function getSnippetCodes()
    {
        return $this->hasMany(SnippetCode::className(), ['snippet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVars()
    {
        return $this->hasMany(SnippetVar::className(), ['snippet_id' => 'id']);
    }
}
