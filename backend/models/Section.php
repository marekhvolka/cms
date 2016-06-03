<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "section".
 *
 * @property integer $id
 * @property string $page_id
 * @property integer $portal_id
 * @property string $type
 * @property string css_class
 * @property string css_id
 * @property string css_style
 *
 * @property Row[] $rows
 * @property Page $page
 * @property Portal $portal
 */
class Section extends \yii\db\ActiveRecord
{

    private $existing;  //Indicates if model allready exists.

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['id'], 'unique'],
            [['page_id', 'portal_id'], 'integer'],
            [['css_class', 'css_style', 'css_id'], 'string'],
            [['type'], 'string', 'max' => 10],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['portal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['portal_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'portal_id' => 'Portal ID',
            'type' => 'Type',
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
    public function getRows()
    {
        return $this->hasMany(Row::className(), ['section_id' => 'id'])
                        ->orderBy('order');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortal()
    {
        return $this->hasOne(Portal::className(), ['id' => 'portal_id']);
    }

    /** Returns array of newly created models from given data.
     * @param $data
     * @return array
     */
    public static function createMultipleFromData($data)
    {
        $sections = [];

        foreach ($data as $i => $dataItem) {
            if ($dataItem['existing'] == 'true') {
                $section = Section::findOne($dataItem['id']);
            } else {
                $section = new Section();
            }

            $section->existing = $dataItem['existing'];
            $sections[$i] = $section;
        }


        return $sections;
    }

    public function getPrefix()
    {
        $settings = $this->getChildCssSettings();

        $cssClasses = trim("wrapper $this->css_class " . $settings['classes']);
        $cssIds = trim("$this->css_id " . $settings['ids']);
        $cssStyles = trim("$this->css_style " . $settings['styles']);

        $result = "<div class='$cssClasses'";

        $result .= $cssIds != '' ? " id='$cssIds'" : "";
        $result .= $cssClasses != '' ? " style='$cssStyles'" : "";

        $result .= ">" . PHP_EOL;

        $result .= '<div class="container">' . PHP_EOL;

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

        foreach ($this->rows as $row) {
            foreach ($row->columns as $column) {
                foreach ($column->blocks as $block) {
                    if (isset($block->snippetCode)) {
                        $settings['classes'] .= $block->snippetCode->snippet->section_class . ' ';
                        $settings['ids'] .= $block->snippetCode->snippet->section_id . ' ';
                        $settings['styles'] .= $block->snippetCode->snippet->section_style . ' ';
                    }
                }
            }
        }

        return $settings;
    }

    public function getPostfix()
    {
        return '</div> <!-- container end --> ' . PHP_EOL .
                '</div> <!-- section end -->' . PHP_EOL;
    }

    public function getContent()
    {
        $result = $this->getPrefix();

        foreach ($this->rows as $row) {
            $result .= $row->getContent();
        }

        $result .= $this->getPostfix();

        return $result;
    }

}
