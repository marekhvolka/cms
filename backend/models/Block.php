<?php

namespace backend\models;

use Exception;
use Latte\Compiler;
use Latte\Engine;
use Latte\Loaders\FileLoader;
use Latte\Loaders\StringLoader;
use Yii;

/**
 * This is the model class for table "snippet_value".
 *
 * @property integer $id
 * @property string $snippet_code_id
 * @property string $product_id
 * @property integer $portal_id
 * @property integer $column_id
 * @property integer $product_var_value_id
 * @property integer $portal_var_value_id
 * @property integer $parent_id
 * @property integer $order
 * @property string $data
 * @property string $type
 * @property boolean $active
 * @property string $varIdentifier
 * @property bool $outdated
 *
 * @property string $existing
 * @property string $name
 * @property string $mainFile
 * @property Column $column
 * @property Block $parent
 * @property Block[] $childBlocks
 * @property SnippetCode $snippetCode
 * @property SnippetVarValue[] $snippetVarValues
 * @property PortalVarValue $portalVarValue
 * @property ProductVarValue $productVarValue
 * @property SnippetCode $snippetCodes
 */
class Block extends CustomModel implements ICacheable, IDuplicable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['snippet_code_id', 'column_id', 'parent_id', 'order', 'product_var_value_id', 'portal_var_value_id'],
                'integer'
            ],
            [['data', 'type'], 'string'],
            [['type'], 'required'],
            [
                ['column_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Column::className(),
                'targetAttribute' => ['column_id' => 'id']
            ],
            [
                ['parent_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Block::className(),
                'targetAttribute' => ['parent_id' => 'id']
            ],
            [
                ['snippet_code_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => SnippetCode::className(),
                'targetAttribute' => ['snippet_code_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'snippet_id' => 'ID snippetu',
            'column_id' => 'ID stĺpca',
            'portal_var_value_id' => 'ID portálovej premennej',
            'product_var_value_id' => 'ID produktovej premennej',
            'parent_id' => 'ID rodiča',
            'order' => 'Poradie',
            'data' => 'Dáta',
            'type' => 'Typ bloku',
            'active' => 'Aktívny'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumn()
    {
        return $this->hasOne(Column::className(), ['id' => 'column_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Block::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildBlocks()
    {
        return $this->hasMany(Block::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetCode()
    {
        return $this->hasOne(SnippetCode::className(), ['id' => 'snippet_code_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetCodes()
    {
        return $this->getSnippetCode()->one()->snippet->snippetCodes;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalVarValue()
    {
        return $this->hasOne(PortalVarValue::className(), ['id' => 'portal_var_value_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductVarValue()
    {
        return $this->hasOne(ProductVarValue::className(), ['id' => 'product_var_value_id']);
    }

    /**
     * @return SnippetVarValue[]
     */
    public function getSnippetVarValues()
    {
        if (!isset($this->snippetVarValues)) {

            $this->snippetVarValues = array();

            if ($this->snippetCode) {
                $snippetCode = $this->snippetCode;
            } else { //jedna sa o portalovy alebo produktovy snippet
                if ($this->parent) {
                    $snippetCode = $this->parent->snippetCode;
                } else {
                    return $this->snippetVarValues;
                }
            }

            foreach ($snippetCode->snippet->snippetFirstLevelVars as $firstLevelVar) {
                $snippetVarValue = SnippetVarValue::find()->where([
                    'block_id' => $this->id,
                    'var_id' => $firstLevelVar->id
                ])->one();

                if ($snippetVarValue) {
                    $this->snippetVarValues[] = $snippetVarValue;
                } else {
                    $snippetVarValue = new SnippetVarValue();
                    $snippetVarValue->var_id = $firstLevelVar->id;

                    $this->snippetVarValues[] = $snippetVarValue;
                }
            }
        }

        return $this->snippetVarValues;
    }

    public function setSnippetVarValues($value)
    {
        $this->snippetVarValues = $value;
    }

    /** Returns array of newly created models from given data.
     * @param $data
     * @return array
     */

    /**
     * @return string
     */
    public function getName()
    {
        switch ($this->type) {
            case 'html':
                $name = 'HTML';
                break;
            case 'portal_snippet':
            case 'product_snippet':
            case 'snippet':
                if ($this->snippetCode) {
                    $name = $this->snippetCode->snippet->name;
                } else if ($this->parent && $this->parent->snippetCode) {
                    $name = $this->parent->snippetCode->snippet->name;
                } else {
                    $name = 'Neznámy kód snippetu';
                }
                break;
            case 'text':
                $name = 'TEXT';
                break;
            default:
                $name = 'undefined';
        }

        return $name;
    }

    public function getMainCacheFile($reload = false)
    {
        $path = '';
        $buffer = '';

        if (isset($this->portalVarValue)) { //portalovy snippet
            $buffer = $this->portalVarValue->portal->language->getIncludePrefix();
            $buffer .= '<?php include("' . $this->portalVarValue->portal->getPortalVarsFile() . '"); ?>';
            $path = $this->portalVarValue->portal->getPortalSnippetsDirectory();
        } else if (isset($this->productVarValue)) { //produktovy snippet
            $buffer = '<?php include("' . $this->productVarValue->product->language->getDictionaryCacheFile() . '");' . PHP_EOL;
            $buffer .= 'include("' . $this->productVarValue->product->getProductVarsFile() . '");' . PHP_EOL;
            $buffer .= '$product = $' . $this->productVarValue->product->identifier . '; ?>' . PHP_EOL;

            $path = $this->productVarValue->product->getMainDirectory();
        } else if (isset($this->column->row->section->area->page)) { //block podstranky
            $buffer = $this->column->row->section->area->page->getIncludePrefix();
            $path = $this->column->row->section->area->getBlocksMainCacheDirectory();
        } else if (isset($this->column->row->section->area->portal)) { //block portalu
            $buffer = $this->column->row->section->area->portal->getIncludePrefix();
            $path = $this->column->row->section->area->getBlocksMainCacheDirectory();
        }

        switch ($this->type) {
            case 'snippet' :

                $path .= 'snippet_cache' . $this->id . '';

                break;
            case 'portal_snippet' :

                $path .= 'portal_snippet_cache' . $this->id . '';

                break;
            case 'product_snippet' :

                $path .= 'product_snippet_cache' . $this->id . '';

                break;
            default:

                $path .= 'block_cache' . $this->id . '';
        }


        if (!file_exists($path . '.php') || $this->outdated || $reload) {
            try {
                /* @var $latteEngine Engine */
                $latteEngine = Yii::$app->dataEngine->latteRenderer;

                if ($this->isSnippet()) {
                    $blockData = $this->prepareSnippetData();
                } else {
                    $blockData = htmlspecialchars($this->data);
                }
                $buffer .= $blockData;

                Yii::$app->dataEngine->writeToFile($path . '.latte', 'w+', $buffer);

                if ($this->snippetCode && $this->snippetCode->dynamic) {

                    $oldLoader = $latteEngine->getLoader();

                    $latteEngine->setLoader(new StringLoader());

                    $result = $latteEngine->compileWithoutTemplate($buffer);

                    $latteEngine->setLoader($oldLoader);

                } else {
                    $result = stripcslashes(html_entity_decode($latteEngine->renderToString($path . '.latte',
                        array())));
                }

                Yii::$app->dataEngine->writeToFile($path . '.php', 'w+', $result);

                $this->setActual();
            } catch (Exception $exception) {
                $this->logException($exception, 'block');
            }
        }

        return $path . '.php';
    }

    private function prepareSnippetData()
    {
        $productType = null;

        $buffer = '<?php ' . PHP_EOL;
        /* @var $snippetVarValue SnippetVarValue */
        $snippetCode = null;

        if (isset($this->parent)) {
            $buffer .= 'include("' . $this->parent->snippetCode->snippet->getMainCacheFile() . '");' . PHP_EOL;
            $snippetCode = $this->parent->snippetCode;
        } else {
            $buffer .= 'include("' . $this->snippetCode->snippet->getMainCacheFile() . '");' . PHP_EOL;
            $snippetCode = $this->snippetCode;
        }

        $buffer .= '/* Snippet values */' . PHP_EOL;

        if (isset($this->column) && isset($this->column->row->section->area->page) && isset($this->column->row->section->area->page->product)) {
            $buffer .= '/* Product type default var values  */' . PHP_EOL;
            $productType = $this->column->row->section->area->page->product->productType;

            foreach ($this->snippetVarValues as $snippetVarValue) {
                $defaultValue = $snippetVarValue->var->getDefaultValueAsString($productType);

                if (isset($defaultValue)) {
                    $buffer .= '$snippet->' . $snippetVarValue->var->identifier . ' = ' . $defaultValue . ';' . PHP_EOL;
                }
            }
        }

        if (($this->type == 'portal_snippet' || $this->type == 'product_snippet') && isset($this->parent)) { //pripravime hodnoty pre port/prod. snippet
            $buffer .= '/* Portal/Product var values  */' . PHP_EOL;

            foreach ($this->parent->snippetVarValues as $snippetVarValue) {
                if (isset($snippetVarValue->value) && $snippetVarValue->value != '\'\'') {
                    $buffer .= '$snippet->' . $snippetVarValue->var->identifier . ' = ' . $snippetVarValue->value . ';' . PHP_EOL;
                }
            }
        }

        $buffer .= '/* Var values  */' . PHP_EOL;

        foreach ($this->snippetVarValues as $snippetVarValue) {

            $value = $snippetVarValue->getValue($productType);
            if (isset($value) && $value != '\'\'' && $value != 'NULL' && $value != 'array()') {
                $buffer .= '$snippet->' . $snippetVarValue->var->identifier . ' = ' . $value . ';' . PHP_EOL;
            }
        }

        $buffer .= '?>' . PHP_EOL;

        $buffer .= $snippetCode->code;

        return $buffer;
    }

    public function getMainDirectory()
    {
        // TODO: Implement getCacheDirectory() method.
    }

    public function resetAfterUpdate()
    {
        $this->setOutdated();

        if (isset($this->column)) {
            $area = $this->column->row->section->area;

            $area->resetAfterUpdate();
        }
        if (!isset($this->column)) {
            foreach ($this->childBlocks as $childBlock) {
                $childBlock->resetAfterUpdate();
            }
        }
    }

    public function prepareToDuplicate()
    {
        foreach ($this->snippetVarValues as $snippetVarValue) {
            $snippetVarValue->prepareToDuplicate();
        }

        $this->product_var_value_id = null;
        $this->portal_var_value_id = null;
        unset($this->id);
        $this->column_id = null;
    }

    public function isSnippet()
    {
        return $this->type == 'snippet' || $this->type == 'portal_snippet' || $this->type == 'product_snippet';
    }

    public function getVarIdentifier()
    {
        if ($this->productVarValue) {
            return $this->productVarValue->var->name;
        } else if ($this->portalVarValue) {
            return $this->portalVarValue->var->name;
        }
        return '';
    }

    public function getOwner()
    {
        // TODO: rewrite using join
        if ($this->column_id != null) {
            /** @var Column $column */
            $column = $this->getColumn()->one();
            /** @var Row $row */
            $row = $column->getRow()->one();

            if ($row) {
                /** @var Section $section */
                $section = $row->getSection()->one();

                if ($section) {
                    /** @var Area $area */
                    $area = $section->getArea()->one();

                    if ($area) {
                        return $area;
                    }
                }
            }
        } else if ($this->product_var_value_id != null) {
            /** @var ProductVarValue $product_var_value */
            $product_var_value = $this->getProductVarValue()->one();

            $product = $product_var_value->getProduct()->one();

            if ($product) {
                return $product;
            }
        } else if ($this->portal_var_value_id != null) {
            /** @var PortalVarValue $portal_var_value */
            $portal_var_value = $this->getPortalVarValue()->one();

            if ($portal_var_value) {
                $portal = $portal_var_value->getPortal()->one();

                if ($portal) {
                    return $portal;
                }
            }
        }

        return null;
    }

    public function isChanged()
    {
        if (parent::isChanged()) {
            return true;
        }

        foreach ($this->snippetVarValues as $snippetVarValue) {
            if ($snippetVarValue->isChanged()) {
                return true;
            }
        }

        return false;
    }
}
