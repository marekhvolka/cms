<?php

namespace backend\models;

use Yii;
use common\models\User;
use yii\helpers\VarDumper;

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
            'name' => 'Názov',
            'description' => 'Popis snippetu',
            'default_code_id' => 'Default Code ID',
            'snippet_type' => 'Typ',
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

            foreach($this->snippetVariables as $snippetVar)
            {
                if (isset($snippetVar->default_value))
                    $buffer .= '$' . $snippetVar->identifier . ' = \'' . $cacheEngine->normalizeString($snippetVar->default_value) . '\';' . PHP_EOL;
            }

            $buffer .= '?>' . PHP_EOL;

            $cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }
}
