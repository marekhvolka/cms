<?php

namespace backend\models;

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
class Column extends \yii\db\ActiveRecord
{
    private $existing;  //Indicates if model allready exists.
    
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
    
    public function beforeDelete()
    {
        $this->unlinkAll('blocks', true);
        return parent::beforeDelete();
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
    public function getRow()
    {
        return $this->hasOne(Row::className(), ['id' => 'row_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['column_id' => 'id'])
            ->orderBy(['order' => SORT_ASC]);
    }
    
    /** Returns array of newly created models from given data.
     * @param $data
     * @return array
     */
    public static function createMultipleFromData($data)
    {
        $columns = [];

        foreach ($data as $i => $dataItem) {
            if ($dataItem['existing'] == 'true') {
                $column = Column::findOne($dataItem['id']);
            } else {
                $column = new Column();
                $column->id = $dataItem['id'];
                $column->row_id = $dataItem['row_id'];
            }

            $column->existing = $dataItem['existing'];
            $columns[$i] = $column;
        }

        return $columns;
    }

    public function getPrefix()
    {
        $settings = $this->getChildCssSettings();

        $cssClasses = trim("col-md-$this->width $this->css_class " . $settings['classes']);
        $cssIds = trim("$this->css_id " . $settings['ids']);
        $cssStyles = trim("$this->css_style " . $settings['styles']);

        $result = "<div";

        $result .= $cssClasses != '' ? " class='$cssClasses'" : "";
        $result .= $cssIds != '' ? " id='$cssIds'" : "";
        $result .= $cssClasses != '' ? " style='$cssStyles'" : "";

        $result .= ">" . PHP_EOL;

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
        $settings['ids'] = '';
        $settings['styles'] = '';

        foreach($this->blocks as $block)
        {
            if (isset($block->snippetCode))
            {
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

    public function getContent()
    {
        $result = $this->getPrefix();

        foreach ($this->blocks as $block)
        {
            $result .= $block->getContent();
        }

        $result .= $this->getPostfix();

        return $result;
    }
}
