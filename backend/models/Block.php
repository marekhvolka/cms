<?php

namespace backend\models;

use Yii;
use yii\helpers\BaseVarDumper;

/**
 * This is the model class for table "snippet_value".
 *
 * @property integer $id
 * @property string $snippet_code_id
 * @property string $product_id
 * @property integer $portal_id
 * @property integer $column_id
 * @property integer $parent_id
 * @property integer $order
 * @property string $data
 * @property string $compiled_data
 * @property string $type
 * @property boolean $active
 *
 *
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
            }

            $block->existing = $dataItem['existing'];
            $blocks[$i] = $block;
        }

        return $blocks;
    }

    /**
     * @return string
     */
    public function getName()
    {
        $name = '';

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

    public function getContent()
    {
        return $this->compileBlock();
    }

    public function compileBlock()
    {
        $path = '';
        $buffer = '';

        if (isset($this->portal)) //portalovy snippet
        {
            $path = $this->portal->getPortalSnippetCacheDirectory();
        }
        else if (isset($this->product)) //produktovy snippet
        {
            $path = $this->product->getProductSnippetCacheDirectory();
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
                $path .= 'snippet_cache' . $this->id . '.latte';
                break;
            default:
                $path .= 'block_cache' . $this->id . '.latte';
                $blockData = $this->data;
        }

        $buffer .= $blockData;

        if (!file_exists($path))
        {
            Yii::$app->cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        $result = html_entity_decode(Yii::$app->cacheEngine->latteRenderer->renderToString($path, array()));

        return $result;
    }

    private function prepareSnippetData()
    {
        $buffer = '<?php ' . PHP_EOL;

        if (!isset($this->snippetCode))
            return '';

        $buffer .= 'include "' . $this->snippetCode->snippet->getMainFile() . '";' . PHP_EOL;

        $snippetVarValues = $this->snippetVarValues;

        $buffer .= '/* Snippet values */' . PHP_EOL;

        /* @var $snippetVarValue SnippetVarValue */
        foreach($snippetVarValues as $snippetVarValue)
        {
            $page = $this->column->row->section->page;

            if (isset($page) && isset($page->product))
            {
                $defaultValue = $snippetVarValue->getDefaultValue($page->product->productType);

                $buffer .= '$snippet->' . $snippetVarValue->var->identifier . ' = ' . $defaultValue . ';' . PHP_EOL;
            }

            if (isset($snippetVarValue->value) && $snippetVarValue->value != '\'\'')
            {
                $buffer .= '$snippet->' . $snippetVarValue->var->identifier . ' = ' . $snippetVarValue->value . ';' . PHP_EOL;
            }

            $buffer .= '$' . $snippetVarValue->var->identifier . ' = $snippet->' . $snippetVarValue->var->identifier . ';' . PHP_EOL;
        }

        $buffer .= '?>' . PHP_EOL;

        $buffer .= file_get_contents($this->snippetCode->getMainFile());

        return $buffer;
    }
}
