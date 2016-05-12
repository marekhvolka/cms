<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "snippet_var_value".
 *
 * @property integer $id
 * @property integer $var_id
 * @property string $value_text
 * @property int $value_page_id
 * @property int $value_product_id
 * @property int $value_tag_id
 * @property int $value_product_var_id
 * @property int $page_block_id
 * @property int $value_list_id
 *
 * @property PageBlock $pageBlock
 * @property SnippetVar $var
 */
class SnippetVarValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet_var_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['var_id'], 'required'],
            [['page_block_id', 'var_id', 'value_page_id', 'value_tag_id', 'value_product_var_id', 'value_product_id'], 'integer'],
            [['value_text'], 'string'],
            [['var_id', 'page_block_id', 'list_item_id'], 'unique', 'targetAttribute' => ['var_id', 'page_block_id', 'list_item_id'], 'message' => 'The combination of Page Block ID, ListItemID and Var ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_block_id' => 'Page Block ID',
            'var_id' => 'Var ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageBlock()
    {
        return $this->hasOne(PageBlock::className(), ['id' => 'page_block_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVar()
    {
        return $this->hasOne(SnippetVar::className(), ['id' => 'var_id']);
    }
}
