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
 * @property string $description
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

    private $existing;

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
     * Getter for $existing property - indicates whether model allready exists.
     * @return string of property value.
     */
    public function getExisting()
    {
        return $this->existing;
    }

    /**
     * Setter for $existing property.
     * @param type $newExisting new property value.
     */
    public function setExisting($newExisting)
    {
        $this->existing = $newExisting;
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
     * @param $data
     * @return array
     */
    public static function createMultipleFromData($data)
    {
        $snippetCodes = [];
        foreach ($data as $i => $dataItem) {
            $snippetCode = new SnippetCode();
            if ($dataItem['existing'] == 'true') {
                $snippetCode = SnippetCode::find()->where(['id' => $dataItem['id']])->one();
            }
            $snippetCode->existing = $dataItem['existing'];
            $snippetCodes[$i] = $snippetCode;
        }
        return $snippetCodes;
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

    /**
     * Multiple delete of SnippetCode models by given Snippet model (SnippetCode deleted by user).
     * @param \backend\models\SnippetCode $snippetCodes
     * @param \backend\models\Snippet $snippet
     * @return boolean if deleting was successfull.
     */
    public static function deleteMultiple($snippetCodes, $snippet)
    {
        $oldCodesIDs = ArrayHelper::map($snippet->snippetCodes, 'id', 'id');// Former IDs.
        $newCodesIDs = ArrayHelper::map($snippetCodes, 'id', 'id'); // Newly updated IDs.
        $codesIDsToDelete = array_diff($oldCodesIDs, $newCodesIDs);  // SnippetVar models to be deleted.

        foreach ($codesIDsToDelete as $codeID) {
            if ($code = SnippetCode::findOne($codeID)) {   // Delete existing SnippetVar with given ID.
                if (!$code->delete()) {
                    return false;
                }
            }
        }

        return true;
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
