<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "snippet_var".
 *
 * @property string $id
 * @property string $identifier
 * @property string $description
 * @property integer $variable_type_id
 * @property string $default_value
 * @property string $snippet_id
 * @property string $parent_id
 * @property integer $tmp_id
 * @property SnippetDropdown[] $snippetDropdowns
 * @property SnippetProductValue[] $snippetProductValues
 * @property ProductType[] $productTypes
 * @property Variable $parent
 * @property Variable[] $children
 * @property Snippet $snippet
 * @property VariableType $variableType
 * @property string $product_type
 */
class Variable extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identifier', 'variable_type_id'], 'required'],
            [['type_id', 'description', 'default_value', 'parent_id'], 'string'],
            [['snippet_id'], 'integer'],
            [['identifier'], 'string', 'max' => 50],
            [['tmp_id'], 'string', 'max' => 45],
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
            'identifier' => 'Názov',
            'description' => 'Popis',
            'variable_type_id' => 'Typ premennej',
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

    public function beforeDelete()
    {
        $this->unlinkAll('children', true);
        return parent::beforeDelete();
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
        return $this->hasOne(Variable::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Variable::className(), ['parent_id' => 'id']);
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
    public function getVariableType()
    {
        return $this->hasOne(VariableType::className(), ['id' => 'variable_type_id']);
    }

    /**
     * Returns array of newly created Variables from given data.
     * @return Variable []
     */
    public static function createMultipleFromData($snippetVarData)  // TODO - may be used only load() method instead of this
    {
        if (!$snippetVarData) {
            return $modelSnippetVars;
        }
        
        $modelSnippetVars = [];      // Array of created SnippetVars.

        foreach ($snippetVarData as $varData) {
            if (isset($varData['identifier']) && $varData['identifier']) {
                if ($varData['existing'] == 'true') {
                    $snippetVar = Variable::find()->where(['id' => $varData['id']])->one();
                } else {
                    $snippetVar = new Variable();
                    $snippetVar->id = $varData['id'];
                }

                // Set all neccessary attributes.
                $snippetVar->identifier = $varData['identifier'];
                $snippetVar->type_id = $varData['type_id'];
                $snippetVar->default_value = $varData['default_value'];
                $snippetVar->description = $varData['description'];

                // Set parent if SnippetVar is item of list type parent SnippetVar.   
                $snippetVar->parent_id = $varData['parent_id'];

                $modelSnippetVars[] = $snippetVar;
            }
        }

        return $modelSnippetVars;
    }


    // TODO - this may be extracted to behavior or helper.
    private function handleChild($snippetVars, $snippet)
    {
        $previousId = $this->id;

        $this->snippet_id = $snippet->id;
        if (!$this->save(false)) {
            return false;
        }

        foreach ($snippetVars as $potentialChild) {
            if ($potentialChild->parent_id == $previousId) {
                $potentialChild->parent_id = $this->id;
                $saved = $potentialChild->handleChild($snippetVars, $snippet);
                if (!$saved) {
                    return false;
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
    public static function saveMultiple($snippetVars, $snippet)
    {
        foreach ($snippetVars as $var) {
            $saved = $var->handleChild($snippetVars, $snippet);
            if (!$saved) {
                return false;
            }
        }

        return true;
    }

    public static function deleteMultiple($modelSnippetVars, $snippet)
    {
        $oldVarsIDs = ArrayHelper::map($snippet->snippetVars, 'id', 'id');
        $newVarsIDs = ArrayHelper::map($modelSnippetVars, 'id', 'id');
        $varsIDsToDelete = array_diff($oldVarsIDs, $newVarsIDs);

        foreach ($varsIDsToDelete as $varID) {
            $snippetVarToDelete = Variable::findOne($varID);
            if ($snippetVarToDelete) {
                $snippetVarToDelete->delete();
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAllThatDoesntBelongToProduct($product_id)
    {
        $query = "variable.id not in (select variable_id from variable_value where product_id = $product_id)";
        return Variable::find()->where($query);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAllThatBelongToProduct($product_id)
    {
        $query = "variable.id in (select variable_id from variable_value where product_id = $product_id)";
        return Variable::find()->where($query);
    }

}
