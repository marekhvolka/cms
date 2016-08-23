<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "snippet_code".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $snippet_id
 * @property bool $outdated
 * @property bool $dynamic
 * @property string $section_id
 * @property string $section_class
 * @property string $section_style
 * @property string $column_id
 * @property string $column_class
 * @property string $column_style
 *
 * @property Block[] $blocks
 * @property string $url
 * @property Snippet $snippet
 */
class SnippetCode extends CustomModel
{
    /**
     * @inheritdoc
     */
    public static function tableName() { return 'snippet_code'; }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'snippet_id'], 'required'],
            [['code', 'description'], 'string'],
            [['dynamic'], 'boolean'],
            [['snippet_id'], 'integer'],
            [
                [
                    'name',
                    'section_id',
                    'section_class',
                    'section_style',
                    'column_id',
                    'column_class',
                    'column_style'
                ],
                'string',
            ],
            [
                ['name', 'snippet_id'],
                'unique',
                'targetAttribute' => ['name', 'snippet_id'],
                'message' => 'The combination of Name and Snippet ID has already been taken.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Meno',
            'code' => 'Kód',
            'description' => 'Popis',
            'snippet_id' => 'ID snippetu',
            'blocks' => 'Bloky',
            'dynamic' => 'Dynamický',
            'section_id' => 'Sekcia ID',
            'section_class' => 'Sekcia Class',
            'section_style' => 'Sekcia Style',
            'column_id' => 'ID stĺpca',
            'column_class' => 'CSS trieda stĺpca',
            'column_style' => 'Štýly stĺpca',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippet()
    {
        return $this->hasOne(Snippet::className(), ['id' => 'snippet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['snippet_code_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::to(
            [
                '/snippet/edit/',
                'id' => $this->snippet_id,
                '#' => 'code' . $this->id
            ]);
    }

    public function resetAfterUpdate()
    {
        $this->setOutdated();

        foreach ($this->blocks as $block) {
            $block->resetAfterUpdate();
        }
    }
}
