<?php

namespace backend\models;

use common\models\User;
use Yii;

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
class SnippetVar extends Variable
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
            [['description'], 'string'],
            [['identifier'], 'string', 'max' => 50],
            [['snippet_id', 'parent_id', 'id'], 'integer'],
            [
                ['identifier', 'snippet_id', 'parent_id'],
                'unique',
                'targetAttribute' => ['identifier', 'snippet_id', 'parent_id'],
                'message' => 'The combination of Identifier, Snippet ID and Parent ID has already been taken.'
            ],
            [['identifier'], 'match', 'pattern' => '/^[_a-zA-Z][a-zA-Z0-9_]*$/i', 'message' => 'Identifikátor musí začínať znakom alebo _, pokračovať smie len znakom, číslom alebo _.'],
            //[['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => SnippetVar::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [
                ['snippet_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Snippet::className(),
                'targetAttribute' => ['snippet_id' => 'id']
            ],
            [
                'identifier',
                function ($attribute, $params) {
                    if ($this->$attribute == 'active') {
                        $this->addError($attribute, 'Zvoľ iný identifikátor');
                    }
                }
            ],
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
            'snippet_id' => 'ID snippetu',
            'parent_id' => 'ID rodiča',
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
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultValues()
    {
        if (!isset($this->defaultValues)) {
            $this->defaultValues = [];
            $default = $this->hasMany(SnippetVarDefaultValue::className(),
                ['snippet_var_id' => 'id'])->where(['product_type_id' => null])->one();

            if($default == null){
                $default = new SnippetVarDefaultValue();
                $default->snippet_var_id = $this->id;
            }

            $this->defaultValues[] = $default;

            $this->defaultValues = array_merge($this->defaultValues, $this->hasMany(SnippetVarDefaultValue::className(),
                ['snippet_var_id' => 'id'])->orderBy('product_type_id')->all());
        }

        return $this->defaultValues;
    }

    public function setDefaultValues($value)
    {
        $this->defaultValues = $value;
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
        return $this->hasMany(ProductType::className(), ['id' => 'product_type_id'])->viaTable('snippet_product_value',
            ['variable_id' => 'id']);
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
        if (!isset($this->children)) {
            $this->children = $this->hasMany(SnippetVar::className(), ['parent_id' => 'id'])->all();
        }

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
     * @param null $productType
     * @return string
     */
    public function getDefaultValueAsString($productType = null)
    {
        $cacheEngine = Yii::$app->dataEngine;

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
            case 'product_tag' :
                $value = 'NULL';

                break;
            case 'bool' :
                $value = 'false';

                break;
            case 'dropdown' :

                $productTypeDefaultValue = $this->getDefaultValue($productType);

                if (isset($productTypeDefaultValue) && isset($productTypeDefaultValue->valueDropdown)) {
                    $value = '\'' . $cacheEngine->normalizeString($productTypeDefaultValue->valueDropdown->value) . '\'';
                }

                break;
            default:

                $productTypeDefaultValue = $this->getDefaultValue($productType);

                if ($productTypeDefaultValue) {
                    $value = '\'' . $cacheEngine->normalizeString($productTypeDefaultValue->value_text) . '\'';
                }
        }

        return $value;
    }

    /** Vrati default hodnotu podla typu produktu
     * @param $productType
     * @return mixed|string
     */
    public function getDefaultValue($productType = null)
    {
        if ($productType) {
            $defaultValue = SnippetVarDefaultValue::find()
                ->andWhere([
                    'snippet_var_id' => $this->id,
                    'product_type_id' => $productType->id
                ])
                ->one();
        }
        if (!isset($defaultValue)) {
            $defaultValue = SnippetVarDefaultValue::find()
                ->andWhere([
                    'snippet_var_id' => $this->id,
                    'product_type_id' => null
                ])
                ->one();
        }

        return $defaultValue;
    }

    public function createNewListItem()
    {
        $listItem = new ListItem();
        $listItem->active = true;
        $listItem->snippetVarValues = array();

        foreach ($this->children as $childVar) {
            $childVarValue = new SnippetVarValue();
            $childVarValue->var_id = $childVar->id;

            $listItem->snippetVarValues[] = $childVarValue;
        }

        return $listItem;
    }

    /** Metoda na nacitanie potomkovskych poloziek - obsahuje rekurziu
     * @param $propertyIdentifier
     * @param $data
     */
    public function loadChildren($propertyIdentifier, $data)
    {
        foreach ($data as $index => $item) {
            $this->loadFromData($propertyIdentifier, $item, $index,
                SnippetVar::className());

            if (key_exists('SnippetVarDefaultValue', $item)) {
                foreach ($item['SnippetVarDefaultValue'] as $indexDefaultValue => $defaultValue) {
                    $this->{$propertyIdentifier}[$index]->loadFromData('defaultValues', $defaultValue,
                        $indexDefaultValue, SnippetVarDefaultValue::className());
                }
            }

            if (key_exists('Children', $item)) {
                $this->{$propertyIdentifier}[$index]->loadChildren('children', $item['Children']);
            }
        }
    }

    /**
     * Metoda na ulozenie potomkovskych poloziek - rekurzia v pripade ze potomok ma dalsich potomkov
     * @param $propertyIdentifier - identifikator zoznamu, ktory obsahuje potomkov
     * @param $globalParentPropertyIdentifier - identifikator globalneho rodicovskeho atributu (block_id, portal_id)
     * @throws \yii\base\Exception
     */
    public function saveChildren($propertyIdentifier, $globalParentPropertyIdentifier)
    {
        foreach ($this->{$propertyIdentifier} as $childModel) {
            $childModel->parent_id = $this->id;

            $childModel->{$globalParentPropertyIdentifier} = $this->{$globalParentPropertyIdentifier};

            if ($childModel->removed) {
                $childModel->delete();
                continue;
            }

            if (!($childModel->validate() && $childModel->save())) {
                throw new \yii\base\Exception;
            }

            foreach ($childModel->defaultValues as $defaultValue) {
                $defaultValue->snippet_var_id = $childModel->id;

                if (!($defaultValue->validate() && $defaultValue->save())) {
                    throw new \yii\base\Exception;
                }
            }

            $childModel->saveChildren('children', $globalParentPropertyIdentifier);
        }
    }

    public function hasChanged()
    {
        if (!empty($this->dirtyAttributes)) {
            return true;
        }

        foreach ($this->children as $childVar) {
            if ($childVar->hasChanged()) {
                return true;
            }
        }

        foreach ($this->defaultValues as $defaultValue) {
            if ($defaultValue->hasChanged()) {
                return true;
            }
        }

        foreach ($this->dropdownValues as $dropdown) {
            if ($dropdown->hasChanged()) {
                return true;
            }
        }

        return false;
    }
}
