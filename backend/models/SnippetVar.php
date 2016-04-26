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
 * @property integer $type_id
 * @property string $default_value
 * @property string $snippet_id
 * @property string $parent_id
 * @property integer $page_var
 * @property integer $tmp_id
 *
 * @property SnippetDropdown[] $snippetDropdowns
 * @property SnippetProductValue[] $snippetProductValues
 * @property ProductType[] $productTypes
 * @property SnippetVar $parent
 * @property SnippetVar[] $children
 * @property Snippet $snippet
 * @property VarType $type
 */
class SnippetVar extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
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
            [['type_id', 'description', 'default_value', 'parent_id'], 'string'],
            [['snippet_id', 'page_var'], 'integer'],
            [['identifier'], 'string', 'max' => 50],
            [['tmp_id'], 'string', 'max' => 45],
            [['identifier', 'snippet_id'], 'unique', 'targetAttribute' => ['identifier', 'snippet_id'], 'message' => 'The combination of Identifier, Snippet ID and Parent ID has already been taken.'],
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
            'type_id' => 'Typ premennej',
            'default_value' => 'Predvolená hodnota',
            'snippet_id' => 'Snippet ID',
            'parent_id' => 'Parent ID',
            'page_var' => 'Page Var',
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
        return $this->hasMany(SnippetDropdown::className(), ['var_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetProductValues()
    {
        return $this->hasMany(SnippetProductValue::className(), ['var_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::className(), ['id' => 'product_type_id'])->viaTable('snippet_product_value', ['var_id' => 'id']);
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
     * Returns array of newly created SnippetVars from given data.
     * @return backend\models\SnippetVar []
     */
    public static function createMultipleFromData($snippetVarData)
    {
        $modelSnippetVars = [];     // Array of created SnippetVars.
        
        if (!$snippetVarData) {
            return $modelSnippetVars;
        }  
        
        foreach ($snippetVarData as $varData) {
            if (isset($varData['identifier']) && $varData['identifier']) {
                if (isset($varData['id']) && $varData['id']) {
                    $snippetVar = SnippetVar::findOne($varData['id']);
                    $snippetVar->id = $varData['id'];
                } else {
                    $snippetVar = new SnippetVar();
                }

                // Set all neccessary attributes.
                $snippetVar->identifier = $varData['identifier'];
                $snippetVar->type_id = $varData['type_id'];
                $snippetVar->default_value = $varData['default_value'];
                $snippetVar->description = $varData['description'];
                $snippetVar->tmp_id = $varData['tmp_id'];

                // Set parent if SnippetVar is item of list type parent SnippetVar.   
                $snippetVar->parent_id = $varData['parent_id'];
                
                $modelSnippetVars[] = $snippetVar;
            }
        }

        return $modelSnippetVars;
    }

    /**
     * Saves multiple models to database.
     * @param backend\models\SnippetVar [] $modelSnippetVars snippetVars to be saved.
     * @return boolean whether saving of models was unsuccessful
     */
    public static function saveMultiple($modelSnippetVars, $snippet)
    {
        foreach ($modelSnippetVars as $var) {
            $var->snippet_id = $snippet->id;

            if (!$var->save(false)) {
                return false;
            }
        }

        // Parent ids change back to id of parent.
        foreach ($modelSnippetVars as $savedVar) {
            
            // Get parent with temporary id.
            $parent = self::find()
                    ->where(['tmp_id' => $savedVar->parent_id])
                    ->andWhere(['not', ['tmp_id' => null]])
                    ->one();
            
            // Change parent_id from temporary parent id to parent id (after parent was saved)
            if ($parent) {
                $savedVar->parent_id = strval($parent->id);
                
                if (!$savedVar->save()) {
                    return false;
                }
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
            $snippetVarToDelete = SnippetVar::findOne($varID);
            if ($snippetVarToDelete) {
                $snippetVarToDelete->delete();
            }
        }
    }

}
