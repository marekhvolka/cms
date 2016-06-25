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
 * @property SnippetVarDropdown[] $dropdownValues
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
    public function getDropdownValues()
    {
        return $this->hasMany(SnippetVarDropdown::className(), ['var_id' => 'id']);
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
        if (!isset($this->children))
            $this->children = $this->hasMany(SnippetVar::className(), ['parent_id' => 'id'])->all();

        return $this->children;
    }

    public function setChildren($value)
    {
        $this->children = $value;
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
