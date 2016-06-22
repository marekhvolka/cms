<?php

namespace backend\models;

use Exception;
use Yii;
use yii\helpers\ArrayHelper;

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
class Row extends CustomModel
{

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
        return '<div class="row">' . PHP_EOL;
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
                $row->id = $dataItem['id'];
            }

            $row->existing = $dataItem['existing'];
            $rows[$i] = $row;
        }

        return $rows;
    }

    /**
     * Saves multiple models to database.
     * @param Row $rows
     * @param Column $columns
     * @return bool
     * @throws Exception
     */
    public static function saveMultiple($rows, $columns)
    {
        foreach ($rows as $row) {
            $formerId = $row->id;

            if ($row->existing == 'false') {
                $row->id = null;
                if (!$row->save()) {
                    throw new Exception;    // If error occurred, exception is thrown
                }

                // row_id of every column with id set to former id of row 
                // (newly created row with random generated id) is set to current
                // id of saved row
                foreach ($columns as $column) {
                    if ($column->row_id == $formerId) {
                        $column->row_id = $row->id;
                    }
                }
            }
        }
        return true;
    }

    public function getContent($reload = false)
    {
        $result = $this->getPrefix();

        foreach ($this->columns as $column) {
            $result .= $column->getContent($reload);
        }

        $result .= $this->getPostfix();

        return $result;
    }

}
