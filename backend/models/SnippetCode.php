<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
 *
 * @property string $url
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
            [['code', 'description'], 'string'],
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
            'code' => 'Kód',
            'description' => 'Popis',
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
     * @return string
     */
    public function getUrl()
    {
        return Url::to(
                        [
                            '/snippet/update/',
                            'id' => $this->snippet_id,
                            '#' => 'code' . $this->id
        ]);
    }

    /** Returns array of newly created SnippetCodes from given data.
     * @param $snippetCodeData
     * @return array
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
                $snippetCode->description = $codeData['description'];
                $snippetCode->portal = $codeData['portal'];

                $modelSnippetCodes[] = $snippetCode;
            }
        }

        return $modelSnippetCodes;
    }

    /**
     * Saves multiple models to database.
     * @param backend\models\SnippetCode [] $snippetCodes snippetCodes to be saved.
     * @return boolean whether saving of models was unsuccessful
     */
    public static function saveMultiple($snippetCodes, $snippet)
    {
        foreach ($snippetCodes as $snippetCode) {
            $snippetCode->snippet_id = $snippet->id;
            if (!$snippetCode->save()) {
                return false;
            }
        }
        return true;
    }

    public static function deleteMultiple($modelSnippetCodes, $snippet)
    {
        $oldCodesIDs = ArrayHelper::map($snippet->snippetCodes, 'id', 'id');
        $newCodesIDs = ArrayHelper::map($modelSnippetCodes, 'id', 'id');
        $codesIDsToDelete = array_diff($oldCodesIDs, $newCodesIDs);

        foreach ($codesIDsToDelete as $codeID) {
            SnippetCode::findOne($codeID)->delete();
        }
    }

    /** Vrati cestu k nacachovanemu suboru, kde su ulozene informacie o kode snippetu a jeho premennych
     * @return string
     */
    public function getMainFile()
    {
        $path = $this->snippet->getDirectory() . 'code' . $this->id . '.php';

        if (!file_exists($path)) {
            Yii::$app->cacheEngine->writeToFile($path, 'w+', $this->code);
        }

        return $path;
    }

}
