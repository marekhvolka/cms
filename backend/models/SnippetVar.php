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
 * @property string $product_type
 * @property integer $last_edit_user
 * @property string $snippet_id
 * @property string $parent_id
 *
 * @property VarType $type
 * @property User $lastEditUser
 * @property SnippetVarDefaultValue[] $defaultValues
 * @property SnippetVar $parent
 * @property SnippetVar[] $children
 * @property Snippet $snippet
 */
class SnippetVar extends CustomModel
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
            [['type_id', 'description'], 'string'],
            [['identifier'], 'string', 'max' => 50],
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
            'id'          => 'ID',
            'identifier'  => 'Identifikátor',
            'description' => 'Popis',
            'type_id'     => 'Typ premennej',
            'snippet_id'  => 'Snippet ID',
            'parent_id'   => 'Parent ID',
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
    public function getDefaultValues()
    {
        return $this->hasMany(SnippetVarDefaultValue::className(), ['snippet_var_id' => 'id']);
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
    public static function createMultipleFromData($snippetVarData)  // TODO - may be used only load() method instead of this
    {
        $modelSnippetVars = [];      // Array of created SnippetVars.

        if (!$snippetVarData) {
            return $modelSnippetVars;
        }

        foreach ($snippetVarData as $index => $varData) {
            if (isset($varData['identifier']) && $varData['identifier']) {
                if ($varData['existing'] == 'true') {
                    $snippetVar = SnippetVar::find()->where(['id' => $varData['id']])->one();
                } else {
                    $snippetVar = new SnippetVar();
                    $snippetVar->id = $varData['id'];
                }

                $modelSnippetVars[$index] = $snippetVar;
            }
        }

        return $modelSnippetVars;
    }


    // TODO - this may be extracted to behavior or helper.
    private function handleChild($snippetVars, Snippet $snippet)
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
        $oldVarsIDs = ArrayHelper::map($snippet->snippetVariables, 'id', 'id');
        $newVarsIDs = ArrayHelper::map($snippetVars, 'id', 'id');
        $varsIDsToDelete = array_diff($oldVarsIDs, $newVarsIDs);

        foreach ($varsIDsToDelete as $varID) {
            $snippetVarToDelete = Variable::findOne($varID);
            if ($snippetVarToDelete) {
                $snippetVarToDelete->delete();
            }
        }

        return true;
    }

    /** Metoda, ktora vrati vseobecnu defaultnu hodnotu (nie pre konkretny typ produktov)
     * @return string
     */
    public function getDefaultValue()
    {
        $cacheEngine = Yii::$app->cacheEngine;

        $value = '\'\'';

        switch ($this->type->identifier) {
            case 'list' :

                $value = ' array()';

                break;

            case 'page' :
                $value = 'NULL';

                break;

            case 'product' :
                $value = 'NULL';
                break;

            case 'dropdown' :

                $productTypeDefaultValue = SnippetVarDefaultValue::find()
                    ->andWhere([
                        'snippet_var_id'  => $this->id,
                        'product_type_id' => null
                    ])
                    ->one();

                if (isset($productTypeDefaultValue) && isset($productTypeDefaultValue->valueDropdown))
                    $value = '\'' . $cacheEngine->normalizeString($productTypeDefaultValue->valueDropdown->value) . '\'';

                break;
            default:

                $productTypeDefaultValue = SnippetVarDefaultValue::find()
                    ->andWhere([
                        'snippet_var_id'  => $this->id,
                        'product_type_id' => null
                    ])
                    ->one();

                if (isset($productTypeDefaultValue))
                    $value = '\'' . $cacheEngine->normalizeString($productTypeDefaultValue->value) . '\'';
        }

        return $value;
    }
}
