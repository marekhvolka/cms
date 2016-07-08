<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "template".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $identifier
 * @property integer $active
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property ColorScheme[] $colorSchemes
 * @property Portal[] $portals
 * @property User $lastEditUser
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template';
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
            [['name', 'identifier', 'active'], 'required'],
            [['active', 'last_edit_user'], 'integer'],
            [['description'], 'string'],
            [['last_edit'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['identifier'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nebi',
            'description' => 'Popis',
            'identifier' => 'Adresár šablóny',
            'active' => 'Aktívna',
            'last_edit' => 'Posledná zmena',
            'last_edit_user' => 'Naposledy editoval',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortals()
    {
        return $this->hasMany(Portal::className(), ['template_id' => 'id']);
    }

    public function getColorSchemes()
    {
        if (!isset($this->colorSchemes)) {

            $this->colorSchemes = array();
            chdir($this->getColorSchemeDirectoryPath());

            foreach (glob('*.scss') as $file) {
                $item = new ColorScheme();
                $item->label = str_replace('.scss', '', $file);
                $item->name = $file;
                $item->template_id = $this->id;

                $this->colorSchemes[] = $item;
            }
        }

        return $this->colorSchemes;
    }

    public function setColorSchemes($value)
    {
        $this->colorSchemes = $value;
    }

    public function getColorSchemeDirectoryPath($forWeb = false)
    {
        return $this->getMainDirectory($forWeb) . 'css/scheme/';
    }

    public function getMainDirectory($forWeb = false)
    {
        return Yii::$app->dataEngine->getTemplatesDirectory($forWeb) . $this->identifier . '/';
    }

    public function getIndexPath($forWeb = false)
    {
        return $this->getMainDirectory($forWeb) . '/index.php';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }
}
