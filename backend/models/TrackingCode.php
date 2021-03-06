<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tracking_code".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $place_id
 * @property integer $portal_id
 * @property integer $active
 * @property string $last_edit
 * @property integer $last_edit_user
 * @property bool $changed
 *
 * @property Portal $portal
 * @property User $lastEditUser
 * @property string $place
 */
class TrackingCode extends CustomModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tracking_code';
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
            [['name', 'place_id', 'portal_id', 'active'], 'required'],
            [['code'], 'string'],
            [['place_id', 'portal_id', 'active', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name'], 'string', 'max' => 40],
            [
                ['name', 'portal_id'],
                'unique',
                'targetAttribute' => ['name', 'portal_id'],
                'message' => 'The combination of Name and Portal ID has already been taken.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Meno',
            'code' => 'Kód',
            'place_id' => 'Umiestnenie',
            'portal_id' => 'ID portálu',
            'active' => 'Aktívny',
            'last_edit' => 'Posledná zmena',
            'last_edit_user' => 'Naposledy editoval',
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
    public function getPlace()
    {
        return (new Query())
            ->select(['id', 'name'])
            ->from('tracking_code_place')
            ->where(['id' => $this->place_id])
            ->one();
    }

    public static function getPlaces()
    {
        return (new Query())
            ->select(['id', 'name'])
            ->from('tracking_code_place')
            ->all();
    }

    public function resetAfterUpdate()
    {
        $this->setOutdated();
        $this->portal->resetAfterUpdate();
        $this->portal->compileThanksFiles();
    }
}
