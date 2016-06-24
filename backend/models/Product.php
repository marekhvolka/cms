<?php

namespace backend\models;

use common\components\CacheThread;
use common\models\User;
use backend\models\ICacheable;
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
 * @property int $parsed
 *
 * @property ProductType $productType
 * @property string $productTypeName
 * @property Page[] $pages
 * @property User $lastEditUser
 * @property Language $language
 * @property Product $parent
 * @property Product[] $products
 * @property ProductVarValue[] $productSnippets
 * @property ProductVarValue[] $productProperties
 * @property Tag[] $tags
 * @property ProductVarValue[] $productVarValues
 * @property SnippetVarValue[] $snippedVarValues
 */
class Product extends CustomModel implements ICacheable
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
        $userIdentity = Yii::$app->user->identity;

        if (isset($userIdentity))
            $this->last_edit_user = $userIdentity->id;

        return parent::beforeSave($insert);
    }
    
    public function beforeDelete()
    {
        $this->unlinkAll('productVarValues', true);
        return parent::beforeDelete();
    }

    public function resetAfterUpdate()
    {
        $this->getProductVarsFile(true); //resetneme hlavny subor

        foreach($this->pages as $page) {
            $page->addToCacheBuffer();
        }

        /* @var $productSnippet SnippetVarValue */
        foreach($this->productSnippets as $productSnippet) {
            $productSnippet->valueBlock->resetAfterUpdate();
        }

        foreach($this->snippedVarValues as $snippetVarValue) {
            $snippetVarValue->block->resetAfterUpdate();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        $allPages = array();

        $directPages = $this->hasMany(Page::className(), ['product_id' => 'id'])->all();

        foreach($directPages as $page)
        {
            $allPages[] =  $page;

            $childPages = Page::find()->where([
                'product_id' => null,
                'parent_id' => $page['id']
            ])->all();

            $allPages = array_merge($allPages, $childPages);
        }

        return $allPages;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVarValues()
    {
        return $this->hasMany(SnippetVarValue::className(), ['value_product_id' => 'id']);
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

    /** Vrati zoznam hodnot premennych - produktovych snippetov
     * @return \yii\db\ActiveQuery
     */
    public function getProductSnippets()
    {
        if (!isset($this->productSnippets)) {
            $this->productSnippets = array();
            foreach ($this->productVarValues as $index => $productVarValue)
                if ($productVarValue->var->isSnippet())
                    $this->productSnippets[$index] = $productVarValue;
        }
        return $this->productSnippets;
    }

    public function setProductSnippets($value)
    {
        $this->productSnippets = $value;
    }

    /** Vrati zoznam hodnot premennych - produktovych vlastnosti
     * @return \yii\db\ActiveQuery
     */
    public function getProductProperties()
    {
        if (!isset($this->productProperties)) {
            $this->productProperties = array();
            foreach ($this->productVarValues as $index => $productVarValue) {
                if (!$productVarValue->var->isSnippet()) {
                    $this->productProperties[$index] = $productVarValue;
                }
            }
        }
        return $this->productProperties;
    }

    public function setProductProperties($value)
    {
        $this->productProperties = $value;
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
        return $this->hasMany(ProductVarValue::className(), [
            'product_id' => 'id',
        ]);
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

    /**
     * @return string
     */
    public function getProductTypeName()
    {
        return $this->productType->name;
    }

    /** Vrati cestu k suboru, v ktorom je nacachovany produkt
     * @param bool $reload - ak je true, subor sa nanovo vytvori (aj ak existuje)
     * @return string
     */
    public function getProductVarsFile($reload = false)
    {
        $path = $this->getCacheDirectory() . 'product_var.php';

        if (!file_exists($path) || $reload)
        {
            $buffer = '<?php ' . PHP_EOL;

            $buffer .= '$tempObject = (object) ';


            if (isset($this->parent)) // ak ma produkt rodica
            {
                $buffer .= 'array_merge((array) $' . $this->parent->identifier . '->obj' . ', ' . PHP_EOL;
            }

            $buffer .= 'array(' . PHP_EOL;

            foreach($this->getProductVarValues()->all() as $productVarValue)
            {
                if (!$productVarValue->var->isSnippet())
                    $buffer .= '\'' . $productVarValue->var->identifier . '\' => ' . $productVarValue->value . ',' . PHP_EOL;
            }

            if (isset($this->parent)) // ak ma produkt rodica
                $buffer .= ')';

            $buffer .= ');' . PHP_EOL;

            $buffer .= '$' . $this->identifier . ' = new ObjectBridge($tempObject, \''. $this->identifier . '\'); ' . PHP_EOL;

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    public function getMainCacheFile($reload = false)
    {
        $path = $this->getCacheDirectory() . 'main_file.php';

        if (!file_exists($path) || $reload)
        {
            $buffer = '<?php' . PHP_EOL;

            $buffer .= 'include \'' . $this->getProductVarsFile() . '\';' . PHP_EOL;

            foreach($this->productSnippets as $productVarValue)
            {
                $buffer .= '$' . $this->identifier . '->' . $productVarValue->var->identifier . ' = file_get_contents(\'' . $productVarValue->valueBlock->getMainCacheFile() . '\');' . PHP_EOL;
            }

            $buffer .= '?>';

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    public function getCacheDirectory()
    {
        $path = $this->language->getProductsCacheDirectory() . $this->identifier . '/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
    }
}
