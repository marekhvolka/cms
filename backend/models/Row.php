<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "row".
 *
 * @property integer $id
 * @property integer $section_id
 * @property integer $order
 * @property string $options
 *
 * @property Column[] $columns
 * @property Section $section
 */
class Row extends \yii\db\ActiveRecord
{
    private $existing;  //Indicates if model allready exists.
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'row';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'order'], 'integer'],
            [['options'], 'string'],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'Section ID',
            'order' => 'Order',
            'options' => 'Options',
        ];
    }
    
    public function beforeDelete()
    {
        $this->unlinkAll('columns', true);
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
    public function getColumns()
    {
        return $this->hasMany(Column::className(), ['row_id' => 'id'])
            ->orderBy('order');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    public function getPrefix()
    {
        return '<div class="row" id="row$this->id">' . PHP_EOL;
    }

    public function getPostfix()
    {
        return '</div> <!-- row end -->' . PHP_EOL;
    }
    
    /** Returns array of newly created models from given data.
     * @param $data
     * @return array
     */
    public static function createMultipleFromData($data)
    {
        $rows = [];

        foreach ($data as $i => $dataItem) {
            if ($dataItem['existing'] == 'true') {
                $row = Row::findOne($dataItem['id']);
            } else {
                $row = new Row();
                $row->section_id = $dataItem['section_id'];
            }

            $row->existing = $dataItem['existing'];
            $rows[$i] = $row;
        }

        return $rows;
    }

    public function getContent()
    {
        $result = $this->getPrefix();

        foreach($this->columns as $column)
        {
            $result .= $column->getContent();
        }

        $result .= $this->getPostfix();

        return $result;
    }
}
