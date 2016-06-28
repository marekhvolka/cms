<?php

namespace backend\models;

use Exception;
use Yii;

/**
 * This is the model class for table "column".
 *
 * @property integer $id
 * @property integer $row_id
 * @property integer $order
 * @property integer $width
 * @property string $css_id
 * @property string $css_style
 * @property string $css_class
 *
 * @property Row $row
 * @property Block[] $blocks
 */
class Column extends CustomModel implements IDuplicable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'column';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['row_id', 'order', 'width'], 'integer'],
            [['css_style', 'css_class', 'css_id'], 'string'],
            [['row_id'], 'exist', 'skipOnError' => true, 'targetClass' => Row::className(), 'targetAttribute' => ['row_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'row_id' => 'Row ID',
            'order' => 'Order',
            'width' => 'Width',
            'css_id' => 'ID stĺpca',
            'css_class' => 'Class stĺpca',
            'css_style' => 'Štýly stĺpca'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRow()
    {
        return $this->hasOne(Row::className(), ['id' => 'row_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        if (!isset($this->blocks))
            $this->blocks = $this->hasMany(Block::className(), ['column_id' => 'id'])
                ->orderBy(['order' => SORT_ASC])
                ->all();

        return $this->blocks;
    }

    public function setBlocks($value)
    {
        $this->blocks = $value;
    }

    public function getPrefix()
    {
        $settings = $this->getChildCssSettings();

        $cssClasses = trim('col-md-' . $this->width . ' ' . $this->css_class . ' ' . $settings['classes']);
        $cssIds = trim($this->css_id . ' ' . $settings['ids']);
        $cssStyles = trim($this->css_style . ' ' . $settings['styles']);

        $result = '<div';

        $result .= $cssClasses != '' ? ' class="' . $cssClasses . '"' : '';
        $result .= $cssIds != '' ? ' id="' . $cssIds . '"' : '';
        $result .= $cssStyles != '' ? ' style="' . $cssStyles . '"' : '';

        $result .= '>' . PHP_EOL;

        $result .= '<div class="box">' . PHP_EOL;

        return $result;
    }

    /** Vrati pole, v ktorom su css nastavenia, zdedene z jednotlivych snippetov
     * @return array
     */
    private function getChildCssSettings()
    {
        $settings = array();

        $settings['classes'] = '';
        $settings['ids'] = ''; //'col' . $this->id;
        $settings['styles'] = '';

        foreach ($this->blocks as $block) {
            if (isset($block->snippetCode)) {
                $settings['classes'] .= $block->snippetCode->snippet->column_class . ' ';
                $settings['ids'] .= $block->snippetCode->snippet->column_id . ' ';
                $settings['styles'] .= $block->snippetCode->snippet->column_style . ' ';
            }
        }

        return $settings;
    }

    public function getPostfix()
    {
        $result = '</div> <!-- box end -->' . PHP_EOL;
        $result .= '</div> <!-- col end -->' . PHP_EOL;

        return $result;
    }

    public function getContent($reload = false)
    {
        $result = $this->getPrefix();

        foreach ($this->blocks as $block) {
            if ($block->active) {

                $result .= '<?php' . PHP_EOL;

                $result .= 'include("' . $block->getMainCacheFile($reload) . '");' . PHP_EOL;

                $result .= '?>' . PHP_EOL;
            }
        }

        $result .= $this->getPostfix();

        return $result;
    }

    public function prepareToDuplicate()
    {
        foreach ($this->blocks as $block) {
            $block->prepareToDuplicate();
        }

        $this->id = null;
        $this->row_id = null;
    }
}
