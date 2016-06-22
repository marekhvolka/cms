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
