<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "row".
 *
 * @property integer $id
 * @property integer $section_id
 * @property integer $order
 *
 * @property Column[] $columns
 * @property Section $section
 */
class Row extends CustomModel implements IDuplicable
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
            [
                ['section_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Section::className(),
                'targetAttribute' => ['section_id' => 'id']
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
            'section_id' => 'ID sekcies',
            'order' => 'Poradie',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumns()
    {
        if (!isset($this->columns)) {
            $this->columns = $this->hasMany(Column::className(), ['row_id' => 'id'])
                ->orderBy('order')
                ->all();
        }

        return $this->columns;
    }

    public function setColumns($value) { $this->columns = $value; }

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

    public function getContent($reload = false)
    {
        if ($this->getBlocksCount() == 0)
            return '';

        $result = $this->getPrefix();

        foreach ($this->columns as $column) {
            $result .= $column->getContent($reload);
        }

        $result .= $this->getPostfix();

        return $result;
    }

    public function prepareToDuplicate()
    {
        foreach ($this->columns as $column) {
            $column->prepareToDuplicate();
        }

        unset($this->id);
        unset($this->section_id);
    }

    public function getBlocksCount()
    {
        $count = 0;

        foreach ($this->columns as $column) {
            $count += $column->getBlocksCount();
        }

        return $count;
    }
}
