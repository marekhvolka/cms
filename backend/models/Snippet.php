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
 * @property string $section_id
 * @property string $section_class
 * @property string $section_style
 * @property string $column_id
 * @property string $column_class
 * @property string $column_style
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property SnippetCode $defaultCode
 * @property User $lastEditUser
 * @property SnippetCode[] $snippetCodes
 * @property SnippetVar[] $snippetVariables
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
            [['name', 'snippet_type'], 'required'],
            [['default_code_id', 'snippet_type', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string'],
            [['section_id', 'section_class', 'section_style', 'column_id', 'column_class', 'column_style'], 'string', 'max' => 30],
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
            'name' => 'Názov',
            'description' => 'Popis snippetu',
            'default_code_id' => 'Default Code ID',
            'snippet_type' => 'Typ',
            'section_id' => 'Sekcia ID',
            'section_class' => 'Sekcia Class',
            'section_style' => 'Sekcia Style',
            'column_id' => 'Column ID',
            'column_class' => 'Column Class',
            'column_style' => 'Column Style',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User',
        ];
    }
    
    /**
     * Event fired before save model. User id is set as last user who edits model.
     * @param type $insert true if save is insert type, false if update.
     */
    public function beforeSave($insert)
    {
        $userId = Yii::$app->user->identity->id;
        $this->last_edit_user = $userId;
        
        return parent::beforeSave($insert);
    }
    
    /**
     * Event fired before deleting model. All models relations are unlinked.
     */
    public function beforeDelete()
    {
        $this->unlinkAll('snippetVariables', true);
        $this->unlinkAll('snippetCodes', true);
        return parent::beforeDelete();
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
    public function getSnippetVariables()
    {
        return $this->hasMany(SnippetVar::className(), ['snippet_id' => 'id']);
    }
    
    /**
     * SnippetVars with no parents (first level - not nested).
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetFirstLevelVars()
    {
        return $this->getSnippetVariables()->where(['parent_id' => null]);
    }

    /** Vrati cestu k adresaru, kde su ulozene nacachovane veci k snippetu
     * @return string
     */
    public function getDirectory()
    {
        $path = Yii::$app->cacheEngine->getSnippetsMainDirectory() . 'snippet' . $this->id . '/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /** Metoda na vratenie cesty k hlavnemu suboru pre dany snippet (obsahuje premenne snippetu
     * s default hodnotami a nastavenia snippetu)
     * @return string
     */
    public function getMainFile()
    {
        $path = $this->getDirectory() . 'snippet.php';

        if (!file_exists($path))
        {
            $cacheEngine = Yii::$app->cacheEngine;

            $buffer = '<?php ' . PHP_EOL;

            $buffer .= '$tempObject = (object) array(' . PHP_EOL;

            foreach($this->snippetVariables as $snippetVar)
            {
                $buffer .= '\'' . $snippetVar->identifier . '\' => ' . $snippetVar->getDefaultValue() . ',' . PHP_EOL;
            }

            $buffer .= ');' . PHP_EOL;

            $buffer .= '$snippet = new ObjectBridge($tempObject);' . PHP_EOL;

            $buffer .= '?>' . PHP_EOL;

            $cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }
}
