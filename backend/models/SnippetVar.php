<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "snippet_var".
 * @property string $id
 * @property string $identifier
 * @property string $description
 * @property integer $type_id
 * @property VarType $type
 * @property string $product_type
 * @property integer $last_edit_user
 *
 * @property User $lastEditUser
 * @property string $default_value
 * @property string $snippet_id
 * @property string $parent_id
 * @property SnippetDropdown[] $snippetDropdowns
 * @property SnippetProductValue[] $snippetProductValues
 * @property SnippetVar $parent
 * @property SnippetVar[] $children
 * @property Snippet $snippet
 */
class SnippetVar extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    private $existing;
    private $saved;

    public static function tableName()
    {
        return 'snippet_var';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identifier', 'type_id'], 'required'],
            [['type_id', 'description'], 'string'],
            [['identifier'], 'string', 'max' => 50],
            [['default_value'], 'string'],
            [['snippet_id', 'parent_id', 'id'], 'integer'],
            [['identifier', 'snippet_id', 'parent_id'], 'unique', 'targetAttribute' => ['identifier', 'snippet_id', 'parent_id'], 'message' => 'The combination of Identifier, Snippet ID and Parent ID has already been taken.'],
            //[['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => SnippetVar::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['snippet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Snippet::className(), 'targetAttribute' => ['snippet_id' => 'id']],
                //[['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VarType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identifier' => 'Identifikátor',
            'description' => 'Popis',
            'type_id' => 'Typ premennej',
            'default_value' => 'Predvolená hodnota',
            'snippet_id' => 'Snippet ID',
            'parent_id' => 'Parent ID',
        ];
    }

    public function beforeSave($insert)
    {
        if (!$this->parent_id) {
            $this->parent_id = null;
        }
        return parent::beforeSave($insert);
    }

    /**
     * Event fired before deleting model. All models relations are unlinked.
     */
    public function beforeDelete()
    {
        $this->unlinkAll('children', true);
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
    public function getSnippetDropdowns()
    {
        return $this->hasMany(SnippetDropdown::className(), ['variable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetProductValues()
    {
        return $this->hasMany(SnippetProductValue::className(), ['variable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::className(), ['id' => 'product_type_id'])->viaTable('snippet_product_value', ['variable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(SnippetVar::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(SnippetVar::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippet()
    {
        return $this->hasOne(Snippet::className(), ['id' => 'snippet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(VarType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /**
     * Returns array of newly created Variables from given data.
     * @return Variable []
     */
    public static function createMultipleFromData($data)
    {
        $snippetVars = [];

        foreach ($data as $i => $dataItem) {
            $snippetVar = new SnippetVar();
            if ($dataItem['existing'] == 'true') {
                $snippetVar = SnippetVar::find()->where(['id' => $dataItem['id']])->one();
            }
            $snippetVar->existing = $dataItem['existing'];
            $snippetVars[$i] = $snippetVar;
        }

        return $snippetVars;
    }

    // TODO - this may be refactored - saved property maybe ommited.
    private function handleChild($snippetVars, Snippet $snippet)
    {
        if ($this->saved != true) {
            $previousId = $this->id;
            $this->snippet_id = $snippet->id;

            if ($this->existing != 'true') {
                $this->id = null;
            }

            if (!$this->save()) {
                return false;
            }

            $this->saved = true;

            foreach ($snippetVars as $potentialChild) {
                if ($potentialChild->parent_id == $previousId) {
                    $potentialChild->parent_id = $this->id;
                    $saved = $potentialChild->handleChild($snippetVars, $snippet);
                    if (!$saved) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Saves multiple models to database.
     * @param Variable [] $modelSnippetVars snippetVars to be saved.
     * @return boolean whether saving of models was unsuccessful
     */
    public static function saveMultiple($snippetVars, Snippet $snippet)
    {
        foreach ($snippetVars as $var) {
            $saved = $var->handleChild($snippetVars, $snippet);
            if (!$saved) {
                return false;
            }
        }
        return true;
    }

    /**
     * Multiple delete of SnippetVar models by given Snippet model (SnippetVar deleted by user).
     * @param \backend\models\SnippetVar $snippetVars
     * @param \backend\models\Snippet $snippet
     * @return boolean if deleting was successfull.
     */
    public static function deleteMultiple($snippetVars, Snippet $snippet)
    {
        $oldVarsIDs = ArrayHelper::map($snippet->snippetVariables, 'id', 'id'); // Former IDs.
        $newVarsIDs = ArrayHelper::map($snippetVars, 'id', 'id');   // Newly updated IDs.
        $varsIDsToDelete = array_diff($oldVarsIDs, $newVarsIDs);    // SnippetVar models to be deleted.

        foreach ($varsIDsToDelete as $varID) {
            if ($var = SnippetVar::findOne($varID)) {   // Delete existing SnippetVar with given ID.
                if (!$var->delete()) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getDefaultValue()
    {
        $cacheEngine = Yii::$app->cacheEngine;

        $value = '';

        switch ($this->type->identifier) {
            case 'list' :

                $value = '(object) array()';

                break;

            case 'page' :
                $value = 'NULL';

                break;

            case 'product' :
                $value = 'NULL';
                break;

            default:
                $value = '\'' . $cacheEngine->normalizeString($this->default_value) . '\'';
        }

        return $value;
    }

}
