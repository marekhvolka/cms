<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $type_id
 * @property string $identifier
 * @property string $description
 * @property integer $language_id
 * @property integer $active
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property Page[] $pages
 * @property User $lastEditUser
 * @property Language $language
 * @property Product $parent
 * @property Product[] $products
 * @property ProductSnippet[] $productSnippets
 * @property Tag[] $tags
 * @property ProductVarValue[] $productVarValues
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    public function init()
    {
        $this->active = 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id', 'identifier', 'language_id', 'active'], 'required'],
            [['parent_id', 'type_id', 'language_id', 'active', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name', 'identifier'], 'string', 'max' => 50],
            [['name', 'language_id'], 'unique', 'targetAttribute' => ['name', 'language_id'], 'message' => 'The combination of Name and Language ID has already been taken.'],
            [['identifier', 'language_id'], 'unique', 'targetAttribute' => ['identifier', 'language_id'], 'message' => 'The combination of Identifier and Language ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Názov',
            'parent_id' => 'Rodič',
            'type_id' => 'Typ produktu',
            'identifier' => 'Identifikátor',
            'description' => 'Popis',
            'language_id' => 'Krajina',
            'active' => 'Active',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Naposledy editoval',
        ];
    }
    
    public function beforeSave($insert)
    {
        $userId = Yii::$app->user->identity->id;
        $this->last_edit_user = $userId;
        
        return parent::beforeSave($insert);
    }
    
    public function beforeDelete()
    {
        $this->unlinkAll('productVarValues', true);
        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Product::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSnippets()
    {
        return $this->hasMany(Block::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductVarValues()
    {
        return $this->hasMany(ProductVarValue::className(), ['product_id' => 'id']);
    }

    public function relations()
    {
        return array(
            'product_vars' => array(self::HAS_MANY, 'Variables', 'product_var_value(product_id, var_id)'),
            'product_vars_value' => array(self::MANY_MANY, 'ProductVar', 'product_var_value(product_id, var_id)'),
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    /** Vrati cestu k suboru, v ktorom je nacachovany produkt
     * @return string
     */
    public function getMainFile()
    {
        $path = $this->language->getProductsCacheDirectory() . $this->identifier . '.php';

        if (!file_exists($path))
        {
            $buffer = '<?php ' . PHP_EOL;

            $query = 'SELECT identifier, IF(value IS NULL, \'\', value ) value FROM product_var
          LEFT JOIN product_var_value ON (product_var.id = var_id)
          WHERE product_id = :product_id';

            $productVars = ArrayHelper::map(Yii::$app->db->createCommand($query,
                [':product_id' => $this['id']])
                ->queryAll(), 'identifier', 'value');

            if (isset($this->parent)) // ak ma produkt rodica
            {
                $buffer .= '$tempObject = (object) array_merge((array) $' . $this->parent->identifier . '
                , ' . var_export($productVars, true) . '); ' . PHP_EOL;
            }
            else
            {
                $buffer .= '$tempObject  = (object) ' . var_export($productVars, true) . ';' . PHP_EOL;
            }

            $buffer .= '$' . $this->identifier . ' = new ObjectBridge($tempObject); ?>' . PHP_EOL;

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    public function getProductSnippetCacheDirectory()
    {
        $path = $this->language->getProductsCacheDirectory() . 'snippets/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    public function printVariables()
    {
        $buffer = '';

        foreach ($this->productVarValues as $productVarValue)
        {
            $buffer .= '$' . $productVarValue->var->identifier . ' = ' .
                '&$' . $this->identifier . '->' . $productVarValue->var->identifier . ';' . PHP_EOL;
        }

        if (isset($this->parent)) // ak ma produkt rodica
        {
            $buffer .= $this->parent->printVariables();
        }

        return $buffer;
    }
}
