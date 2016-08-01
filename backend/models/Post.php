<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * Trieda reprezentujuca clanok na blogu
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property integer $portal_id
 * @property string $published_at
 * @property string $perex
 * @property string $last_edit
 * @property integer $last_edit_user
 * @property integer $active
 *
 * @property Portal $portal
 * @property User $lastEditUser
 */
class Post extends CustomModel implements ICacheable, IDuplicable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'portal_id', 'layout_id'], 'required'],
            [['portal_id', 'layout_id', 'last_edit_user', 'active'], 'integer'],
            [['published_at', 'last_edit'], 'safe'],
            [['perex'], 'string'],
            [['name', 'identifier'], 'string', 'max' => 255],
            [['portal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['portal_id' => 'id']],
            [['layout_id'], 'exist', 'skipOnError' => true, 'targetClass' => Layout::className(), 'targetAttribute' => ['layout_id' => 'id']],
            [['last_edit_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_edit_user' => 'id']],
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
            'identifier' => 'Url',
            'portal_id' => 'Portal ID',
            'layout_id' => 'Layout ID',
            'published_at' => 'Published At',
            'perex' => 'Perex',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User',
            'active' => 'Active',
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
    public function getLayout()
    {
        return $this->hasOne(Layout::className(), ['id' => 'layout_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    public function getMainCacheFile()
    {
        // TODO: Implement getMainCacheFile() method.
    }

    public function getMainDirectory()
    {
        // TODO: Implement getMainDirectory() method.
    }

    public function resetAfterUpdate()
    {
        // TODO: Implement resetAfterUpdate() method.
    }

    public function prepareToDuplicate()
    {
        // TODO: Implement prepareToDuplicate() method.
    }
}
