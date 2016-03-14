<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "var_type".
 *
 * @property integer $id
 * @property string $type
 * @property string $popis
 * @property integer $show_snippet
 * @property integer $show_portal
 * @property integer $show_product
 * @property string $tbl_type
 *
 * @property PortalVar[] $portalVars
 * @property ProductVar[] $productVars
 * @property SnippetVar[] $snippetVars
 */
class VarType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'var_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'show_snippet', 'show_portal', 'show_product', 'tbl_type'], 'required'],
            [['popis'], 'string'],
            [['show_snippet', 'show_portal', 'show_product'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['tbl_type'], 'string', 'max' => 7]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'popis' => 'Popis',
            'show_snippet' => 'Show Snippet',
            'show_portal' => 'Show Portal',
            'show_product' => 'Show Product',
            'tbl_type' => 'Tbl Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalVars()
    {
        return $this->hasMany(PortalVar::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductVars()
    {
        return $this->hasMany(ProductVar::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVars()
    {
        return $this->hasMany(SnippetVar::className(), ['type_id' => 'id']);
    }
}
