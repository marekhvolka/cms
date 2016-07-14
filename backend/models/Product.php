<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Exception;
use yii\db\Query;

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
 * @property bool $outdated
 *
 * @property ProductType $productType
 * @property string $productTypeName
 * @property Page[] $pages
 * @property User $lastEditUser
 * @property Language $language
 * @property Product $parent
 * @property Product[] $products
 * @property Block[] $productSnippets
 * @property ProductVarValue[] $productProperties
 * @property Tag[] $tags
 * @property ProductVarValue[] $productVarValues
 * @property SnippetVarValue[] $snippedVarValues
 */
class Product extends CustomModel implements ICacheable, IDuplicable
{
    public $_tags;

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
            [
                ['name', 'language_id'],
                'unique',
                'targetAttribute' => ['name', 'language_id'],
                'message' => 'Produkt s daným názvom pre krajinu už existuje.'
            ],
            [
                ['identifier', 'language_id'],
                'unique',
                'targetAttribute' => ['identifier', 'language_id'],
                'message' => 'Produkt s daným názvom pre krajinu už existuje.'
            ]
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
            'active' => 'Aktívny',
            'last_edit' => 'Posledná zmena',
            'last_edit_user' => 'Naposledy editoval',
        ];
    }

    public function resetAfterUpdate()
    {
        $this->setOutdated();
        $this->getProductVarsFile();

        foreach ($this->pages as $page) {
            $page->setOutdated();
        }

        /* @var $productSnippet SnippetVarValue */
        foreach ($this->productSnippets as $productSnippet) {
            $productSnippet->resetAfterUpdate();
        }

        foreach ($this->snippetVarValues as $snippetVarValue) {
            $snippetVarValue->resetAfterUpdate();
        }
    }

    /** Vrati cestu k suboru, v ktorom je nacachovany produkt
     * @return string
     */
    public function getProductVarsFile()
    {
        $path = $this->getMainDirectory() . 'product_var.php';

        if (!file_exists($path) || $this->outdated) {

            try {
                $buffer = '<?php ' . PHP_EOL;

                if (isset($this->parent)) {
                    $buffer .= 'include("' . $this->parent->getProductVarsFile() . '");' . PHP_EOL;
                }

                $buffer .= '$tempObject = (object) ';

                if (isset($this->parent)) { // ak ma produkt rodica
                    $buffer .= 'array_merge((array) $' . $this->parent->identifier . '->obj' . ', ' . PHP_EOL;
                }

                $buffer .= 'array(' . PHP_EOL;

                $buffer .= '\'id\' => ' . $this->id . ',' . PHP_EOL;
                $buffer .= '\'name\' => \'' . addslashes($this->name) . '\',' . PHP_EOL;

                foreach ($this->productProperties as $productVarValue) {
                    $buffer .= '\'' . $productVarValue->var->identifier . '\' => ' . $productVarValue->value . ',' . PHP_EOL;
                }

                $buffer .= '\'tags\' => array(' . PHP_EOL;

                foreach ($this->tags as $tag) {
                    $buffer .= '\'' . $tag->identifier . '\' => $tags->' . $tag->identifier . ',' . PHP_EOL;
                }

                $buffer .= '),' . PHP_EOL;

                $buffer .= '\'tagsAsString\' => \'';

                if (sizeof($this->tags) > 0) {
                    foreach ($this->tags as $tag) {
                        $buffer .= $tag->identifier . ',';
                    }

                    $buffer = substr($buffer, 0, strlen($buffer) - 1);
                }

                $buffer .= '\',' . PHP_EOL;

                if (isset($this->parent)) // ak ma produkt rodica
                {
                    $buffer .= ')';
                }

                $buffer .= ');' . PHP_EOL;

                $buffer .= '$' . $this->identifier . ' = new ObjectBridge($tempObject, \'' . $this->identifier . '\'); ' . PHP_EOL;

                $buffer .= '?>' . PHP_EOL;

                Yii::$app->dataEngine->writeToFile($path, 'w+', $buffer);
            } catch (Exception $exception) {
                $this->logException($exception, 'product_var');
            }
        }

        return $path;
    }

    public function getMainDirectory()
    {
        $path = $this->language->getProductsDirectory() . 'product' . $this->id . '/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductVarValues()
    {
        if (!isset($this->productVarValues)) {
            $this->productVarValues = $this->hasMany(ProductVarValue::className(), ['product_id' => 'id'])->all();
        }

        return $this->productVarValues;
    }

    public function setProductVarValues($value)
    {
        $this->productVarValues = $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        $allPages = array();

        $directPages = $this->hasMany(Page::className(), ['product_id' => 'id'])->all();

        foreach ($directPages as $page) {
            $allPages[] = $page;

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
            foreach ($this->productVarValues as $index => $productVarValue) {
                if ($productVarValue->var->isSnippet()) {
                    $this->productSnippets[$index] = $productVarValue->valueBlock;
                }
            }
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
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('product_tag', ['product_id' => 'id']);
    }

    public function updateTags()
    {
        $productId = $this->id;
        $tags = Yii::$app->request->post(Product::className());

        if (!isset($tags['_tags'])) {
            $tags = [];
        } else {
            $tags = $tags['_tags'];
        }

        $saved_tags = $this->getTags()->select('id')->asArray()->column();

        $to_remove = array_filter($saved_tags, function ($item) use ($tags) {
            return !in_array($item, $tags);
        });

        $to_add = array_map(function ($id) use ($productId) {
            return [
                'product_id' => $productId,
                'tag_id' => $id,
                'last_edit_user' => Yii::$app->user->getId()
            ];
        }, array_filter($tags, function ($item) use ($saved_tags) {
            return !in_array($item, $saved_tags);
        }));

        if (count($to_remove) > 0) {
            (new Query())->createCommand()->delete('product_tag', ['product_id' => $this->id, 'tag_id' => $to_remove])->execute();
        }

        if (count($to_add) > 0) {
            (new Query())->createCommand()->batchInsert('product_tag', ['product_id', 'tag_id', 'last_edit_user'], $to_add)->execute();
        }
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

    public function getMainCacheFile()
    {
        $path = $this->getMainDirectory() . 'main_file.php';

        if (!file_exists($path) || $this->outdated) {

            try {
                $buffer = '<?php' . PHP_EOL;

                $buffer .= 'include("' . $this->getProductVarsFile() . '");' . PHP_EOL;

                foreach ($this->productSnippets as $productVarValue) {
                    $buffer .= '$' . $this->identifier . '->' . $productVarValue->productVarValue->var->identifier .
                        ' = file_get_contents("' . $productVarValue->getMainCacheFile() . '");' . PHP_EOL;
                }

                $buffer .= '?>';

                Yii::$app->dataEngine->writeToFile($path, 'w+', $buffer);
                $this->setActual();
            } catch (Exception $exception) {
                $this->logException($exception, 'product_main_file');
            }
        }

        return $path;
    }

    /** Metoda na vyskladanie URL pre podstranku
     * @return string
     */
    public function getBreadcrumbs()
    {
        $breadcrumbs = '';

        if (isset($this->parent)) {
            $breadcrumbs = $this->parent->breadcrumbs . ' -> ';
        }

        return $breadcrumbs . $this->name;
    }

    public function prepareToDuplicate()
    {
        foreach ($this->productVarValues as $productVarValue) {
            $productVarValue->prepareToDuplicate();
        }

        foreach ($this->tags as $tag) {
            $tag->prepareToDuplicate();
        }

        unset($this->id);
    }
}
