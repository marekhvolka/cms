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
 * @property Product $product
 * @property Column $column
 * @property Block $parent
 * @property Block[] $pageBlocks
 * @property Portal $portal
 * @property SnippetCode $snippetCode
 * @property SnippetVarValue[] $snippetVarValues
 */
class Block extends \yii\db\ActiveRecord
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
            [['snippet_code_id', 'product_id', 'portal_id', 'column_id', 'parent_id', 'order'], 'integer'],
            [['data', 'type', 'compiled_data'], 'string'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['column_id'], 'exist', 'skipOnError' => true, 'targetClass' => Column::className(), 'targetAttribute' => ['column_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Block::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['portal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['portal_id' => 'id']],
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
            'product_id' => 'Product ID',
            'portal_id' => 'Portal ID',
            'column_id' => 'Column ID',
            'parent_id' => 'Parent ID',
            'order' => 'Order',
            'data' => 'Data',
            'type' => 'Typ bloku',
            'active' => 'Aktívny'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
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
    public function getPortal()
    {
        return $this->hasOne(Portal::className(), ['id' => 'portal_id']);
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
        return $this->hasMany(SnippetVarValue::className(), ['page_block_id' => 'id']);
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

                if ($this->snippetCode)
                    $name = $this->snippetCode->snippet->name;
                else
                    $name = 'Zmazaný kód snippetu';

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

        if (!isset($this->compiled_data))
        {
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
                $path = $this->column->row->section->portal->getBlocksMainCacheDirectory();
            }

            switch ($this->type)
            {
                case 'snippet' :

                    $blockData = $this->compileSnippet();

                    $path .= 'snippet_cache' . $this->id . '.latte';

                    break;

                default:

                    $path .= 'block_cache' . $this->id . '.latte';

                    $blockData = $this->data;
            }

            $buffer .= $blockData;

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $buffer);

            $result = Yii::$app->cacheEngine->latteRenderer->renderToString($path, array());

            $this->compiled_data = $result;

            $this->save();
        }

        return $this->compiled_data;
    }

    private function compileSnippet()
    {
        $buffer = '<?php ' . PHP_EOL;

        $buffer .= 'include "' . $this->snippetCode->snippet->getMainFile() . '";' . PHP_EOL;

        $snippetVarValues = $this->snippetVarValues;

        /* @var $snippetVarValue SnippetVarValue */
        foreach($snippetVarValues as $snippetVarValue)
        {
            $buffer .= '$' . $snippetVarValue->var->identifier . ' = ' . $snippetVarValue->value . ';' . PHP_EOL;
        }

        $buffer .= '?>' . PHP_EOL;

        $buffer .= file_get_contents($this->snippetCode->getMainFile());

        return $buffer;
    }
}
