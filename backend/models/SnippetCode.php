<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "snippet_code".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $popis
 * @property string $portal
 * @property integer $snippet_id
 *
 * @property Snippet[] $snippets
 * @property Snippet $snippet
 */
class SnippetCode extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['code', 'popis'], 'string'],
            [['snippet_id'], 'integer'],
            [['name', 'portal'], 'string', 'max' => 50],
            [['name', 'snippet_id'], 'unique', 'targetAttribute' => ['name', 'snippet_id'], 'message' => 'The combination of Name and Snippet ID has already been taken.']
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
            'code' => 'Code',
            'popis' => 'Popis',
            'portal' => 'Alternatívu je možné použiť na portály',
            'snippet_id' => 'Snippet ID',
        ];
    }

    public function beforeDelete()
    {
        $this->unlinkAll('snippets', false);

        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippets()
    {
        return $this->hasMany(Snippet::className(), ['default_code_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippet()
    {
        return $this->hasOne(Snippet::className(), ['id' => 'snippet_id']);
    }

    /**
     * Returns array of newly created SnippetCodes from given data.
     * @return backend\models\SnippetCode []
     */
    public static function createMultipleFromData($snippetCodeData)
    {
        $modelSnippetCodes = [];
        if (!$snippetCodeData) {
            return $modelSnippetCodes;
        }
        
        foreach ($snippetCodeData as $codeData) {
            if (isset($codeData['name'])) {
                $snippetCode = new SnippetCode();

                $snippetCode->name = $codeData['name'];
                $snippetCode->code = $codeData['code'];
                $snippetCode->popis = $codeData['popis'];
                $snippetCode->portal = $codeData['portal'];

                $modelSnippetCodes[] = $snippetCode;
            }
        }
        
        return $modelSnippetCodes;
    }

}
