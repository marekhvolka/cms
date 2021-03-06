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
                'message' => 'The combination of Identifier, Snippet ID and Parent ID has already been taken.',
                'when' => function ($model) {
                    return $model->parent_id != null;
                }
            ],
            [
                ['identifier'],
                'match',
                'pattern' => '/^[_a-zA-Z][a-zA-Z0-9_]*$/i',
                'message' => 'Identifikátor musí začínať znakom alebo _, pokračovať smie len znakom, číslom alebo _.'
            ],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultValues()
    {
        if (!isset($this->defaultValues)) {
            $this->defaultValues = [];
            $default = $this->hasMany(SnippetVarDefaultValue::className(),
                ['snippet_var_id' => 'id'])
                ->where([
                    'product_type_id' => null,
                    'partnership_type_id' => null
                ])->one();

            if ($default == null) {
                $default = new SnippetVarDefaultValue();
                $default->snippet_var_id = $this->id;
            }

            $this->defaultValues[] = $default;

            $this->defaultValues = array_merge($this->defaultValues, $this->hasMany(SnippetVarDefaultValue::className(),
                ['snippet_var_id' => 'id'])->where('product_type_id IS NOT NULL OR partnership_type_id IS NOT NULL')
                ->orderBy('product_type_id')->all());
        }

        return $this->defaultValues;
    }

    public function setDefaultValues($value) { $this->defaultValues = $value; }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropdownValues()
    {
        if (!isset($this->dropdownValues)) {
            $this->dropdownValues = $this->hasMany(SnippetVarDropdown::className(), ['var_id' => 'id'])->all();
        }

        return $this->dropdownValues;
    }

    public function setDropdownValues($value)
    {
        $this->dropdownValues = $value;
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

    public function setChildren($value) { $this->children = $value; }

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

    /** Vrati default hodnotu podla typu produktu
     * @param Product $product
     * @return mixed|string
     */
    public function getDefaultValue(Product $product = null)
    {
        if ($product) {
            $defaultValue = SnippetVarDefaultValue::find()
                ->andWhere([
                    'snippet_var_id' => $this->id,
                    'product_type_id' => $product->type_id,
                    'partnership_type_id' => $product->partnership_type_id
                ])
                ->one();

            if (!isset($defaultValue)) {
                $defaultValue = SnippetVarDefaultValue::find()
                    ->andWhere([
                        'snippet_var_id' => $this->id,
                        'product_type_id' => $product->type_id,
                        'partnership_type_id' => null
                    ])
                    ->one();
            }

            if (!isset($defaultValue)) {
                $defaultValue = SnippetVarDefaultValue::find()
                    ->andWhere([
                        'snippet_var_id' => $this->id,
                        'product_type_id' => null,
                        'partnership_type_id' => $product->partnership_type_id
                    ])
                    ->one();
            }
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

            if (key_exists('SnippetVarDropdownValue', $item)) {
                foreach ($item['SnippetVarDropdownValue'] as $indexDropdown => $dropdown) {
                    $this->{$propertyIdentifier}[$index]->loadFromData('dropdownValues', $dropdown,
                        $indexDropdown, SnippetVarDropdown::className());
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
        /* @var $childModel CustomModel */
        foreach ($this->{$propertyIdentifier} as $childModel) {
            $childModel->parent_id = $this->id;

            $childModel->{$globalParentPropertyIdentifier} = $this->{$globalParentPropertyIdentifier};

            if ($childModel->removed) {
                $childModel->delete();
                continue;
            }

            $childModel->validateAndSave();

            /* @var $defaultValue SnippetVarDefaultValue */
            foreach ($childModel->defaultValues as $defaultValue) {
                $defaultValue->snippet_var_id = $childModel->id;

                if ($defaultValue->removed) {
                    $defaultValue->delete();
                    continue;
                }

                $defaultValue->validateAndSave();
            }

            /* @var $dropdownValue SnippetVarDropdown */
            foreach ($childModel->dropdownValues as $dropdownValue) {
                $dropdownValue->var_id = $childModel->id;

                if ($dropdownValue->removed) {
                    $dropdownValue->delete();
                    continue;
                }

                $dropdownValue->validateAndSave();
            }

            $childModel->saveChildren('children', $globalParentPropertyIdentifier);
        }
    }

    public function supportDefaultValues()
    {
        if ($this->type) {
            switch ($this->type->identifier) {
                case 'textinput':
                case 'textarea':
                case 'color':
                case 'image':
                case 'number':
                    return true;
                default:
                    return false;
            }
        } else {
            return true;
        }
    }

    public function isChanged()
    {
        if (!empty(parent::isChanged())) {
            return true;
        }

        foreach ($this->children as $childVar) {
            if ($childVar->isChanged()) {
                return true;
            }
        }

        foreach ($this->defaultValues as $defaultValue) {
            if ($defaultValue->isChanged()) {
                return true;
            }
        }

        foreach ($this->dropdownValues as $dropdown) {
            if ($dropdown->isChanged()) {
                return true;
            }
        }

        return false;
    }
}
