<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "snippet_value".
 *
 * @property integer $id
 * @property string $snippet_code_id
 * @property string $product_id
 * @property integer $portal_id
 * @property integer $column_id
 * @property integer $portal_var_id
 * @property integer $product_var_id
 * @property integer $parent_id
 * @property integer $order
 * @property string $data
 * @property string $compiled_data
 * @property string $type
 * @property boolean $active
 *
 *
 * @property PortalVarValue $portalVarValue
 * @property ProductVarValue $productVarValue
 * @property string $name
 * @property Column $column
 * @property Block $parent
 * @property Block[] $pageBlocks
 * @property SnippetCode $snippetCode
 * @property SnippetVarValue[] $snippetVarValues
 */
class Block extends \yii\db\ActiveRecord
{
    private $existing;  //Indicates if model allready exists.

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
            [['snippet_code_id', 'column_id', 'parent_id', 'order'], 'integer'],
            [['data', 'type', 'compiled_data'], 'string'],
            [['type'], 'required'],
            [['column_id'], 'exist', 'skipOnError' => true, 'targetClass' => Column::className(), 'targetAttribute' => ['column_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Block::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['snippet_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => SnippetCode::className(), 'targetAttribute' => ['snippet_code_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'snippet_id' => 'Snippet ID',
            'column_id' => 'Column ID',
            'portal_var_id' => 'Portal Var ID',
            'product_var_id' => 'Product Var ID',
            'parent_id' => 'Parent ID',
            'order' => 'Order',
            'data' => 'Data',
            'type' => 'Typ bloku',
            'active' => 'Aktívny'
        ];
    }

    /*
     * Getter for $existing property which indicates if model allready exists.
     */
    public function getExisting()
    {
        return $this->existing;
    }

    /**
     * Setter for $existing property which indicates if model allready exists.
     * @param string $newExisting new property value.
     */
    public function setExisting($newExisting)
    {
        $this->existing = $newExisting;
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
    public function getPageBlocks()
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
    public function getPortalVarValue()
    {
        return $this->hasOne(PortalVarValue::className(), ['id' => 'portal_var_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductVarValue()
    {
        return $this->hasOne(ProductVarValue::className(), ['id' => 'product_var_id']);
    }

    /**
     * @return SnippetVarValue[]
     */
    public function getSnippetVarValues()
    {
        return $this->hasMany(SnippetVarValue::className(), ['block_id' => 'id']);
    }

    /** Returns array of newly created models from given data.
     * @param $data
     * @return array
     */
    public static function createMultipleFromData($data)
    {
        $blocks = [];

        foreach ($data as $i => $dataItem) {
            if ($dataItem['existing'] == 'true') {
                $block = Block::findOne($dataItem['id']);
            } else {
                $block = new Block();
                $block->column_id = $dataItem['column_id'];
            }

            $block->existing = $dataItem['existing'];
            $blocks[$i] = $block;
        }

        return $blocks;
    }
    
    // TODO - this is also in column, block, row, .... should be put into behavior or baseclass
    public static function deleteMultiple($existingModels, $models)
    {
        $oldIDs = ArrayHelper::map($existingModels, 'id', 'id');
        $newIDs = ArrayHelper::map($models, 'id', 'id');
        $IDsToDelete = array_diff($oldIDs, $newIDs);

        foreach ($IDsToDelete as $id) {
            $modelsToDelete = self::findOne($id);
            if ($modelsToDelete) {
                $modelsToDelete->delete();
            }
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        switch ($this->type)
        {
            case 'html':
                $name = 'HTML';
                break;
            case 'snippet':
                //TODO: fix with valid database
                if ($this->snippetCode) {
                    $name = $this->snippetCode->snippet->name;
                } else {
                    $name = 'Zmazaný kód snippetu';
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

    public function getMainFile()
    {
        $path = '';
        $buffer = '';

        if (isset($this->portalVarValue)) //portalovy snippet
        {
            $buffer = $this->portalVarValue->portal->getIncludePrefix();
            $path = $this->portalVarValue->portal->getPortalSnippetCacheDirectory();
        }
        else if (isset($this->productVarValue)) //produktovy snippet
        {
            $buffer = '<?php include "' . $this->productVarValue->product->language->getDictionaryCacheFile() . '"; ?>';
            $path = $this->productVarValue->product->getMainDirectory();
        }
        else if (isset($this->column->row->section->page)) //block podstranky
        {
            $buffer = $this->column->row->section->page->getIncludePrefix();
            $path = $this->column->row->section->page->getPageBlocksMainCacheDirectory();
        }
        else if (isset($this->column->row->section->portal)) //block portalu
        {
            $buffer = $this->column->row->section->portal->getIncludePrefix();
            $path = $this->column->row->section->portal->getBlocksMainCacheDirectory();
        }

        switch ($this->type)
        {
            case 'snippet' :

                $blockData = $this->prepareSnippetData();

                $path .= 'snippet_cache' . $this->id . '';

                break;
            case 'portal_snippet' :

                $blockData = $this->prepareSnippetData();

                $path .= 'portal_snippet_cache' . $this->id . '';

                break;
            case 'product_snippet' :

                $blockData = $this->prepareSnippetData();

                $path .= 'product_snippet_cache' . $this->id . '';

                break;
            default:

                $path .= 'block_cache' . $this->id . '';

                $blockData = $this->data;
        }

        $buffer .= $blockData;

        if (!file_exists($path . '.php'))
        {
            Yii::$app->cacheEngine->writeToFile($path . '.latte', 'w+', $buffer);
            $result = stripcslashes(html_entity_decode(Yii::$app->cacheEngine->latteRenderer->renderToString($path . '.latte', array())));

            Yii::$app->cacheEngine->writeToFile($path . '.php', 'w+', $result);

        }

        return $path . '.php';
    }

    private function prepareSnippetData()
    {
        $buffer = '<?php ' . PHP_EOL;
        /* @var $snippetVarValue SnippetVarValue */
        $snippetCode = null;

        if (isset($this->parent))
        {
            $buffer .= 'include "' . $this->parent->snippetCode->snippet->getMainFile() . '";' . PHP_EOL;
            $snippetCode = $this->parent->snippetCode;
        }
        else
        {
            $buffer .= 'include "' . $this->snippetCode->snippet->getMainFile() . '";' . PHP_EOL;
            $snippetCode = $this->snippetCode;
        }

        $buffer .= '/* Snippet values */' . PHP_EOL;

        if (isset($this->column) && isset($this->column->row->section->page) && isset($this->column->row->section->page->product))
        {
            $buffer .= '/* Product type default var values  */' . PHP_EOL;

            foreach($this->snippetVarValues as $snippetVarValue)
            {
                $defaultValue = $snippetVarValue->getDefaultValue($this->column->row->section->page->product->productType);
                $buffer .= '$snippet->' . $snippetVarValue->var->identifier . ' = ' . $defaultValue . ';' . PHP_EOL;
            }
        }

        if (($this->type == 'portal_snippet' || $this->type == 'product_snippet') && isset($this->parent)) //pripravime hodnoty pre port/prod. snippet
        {
            $buffer .= '/* Portal/Product var values  */' . PHP_EOL;

            foreach ($this->parent->snippetVarValues as $snippetVarValue)
            {
                if (isset($snippetVarValue->value) && $snippetVarValue->value != '\'\'')
                {
                    $buffer .= '$snippet->' . $snippetVarValue->var->identifier . ' = ' . $snippetVarValue->value . ';' . PHP_EOL;
                }
            }
        }

        $buffer .= '/* Var values  */' . PHP_EOL;

        foreach($this->snippetVarValues as $snippetVarValue)
        {
            if (isset($snippetVarValue->value) && $snippetVarValue->value != '\'\'')
            {
                $buffer .= '$snippet->' . $snippetVarValue->var->identifier . ' = ' . $snippetVarValue->value . ';' . PHP_EOL;
            }
        }

        $buffer .= '?>' . PHP_EOL;

        $buffer .= file_get_contents($snippetCode->getMainFile());

        return $buffer;
    }
}
