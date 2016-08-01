<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Trieda, reprezentujuca premennu, ktoru je mozne priradit pre portal
 *
 * @property string $product_type
 */
class PortalVar extends Variable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'portal_var';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique', 'message' => 'Zadajte unikátny identifikátor.'],
            [['identifier'], 'unique', 'message' => 'Zadajte unikátny identifikátor.'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return parent::attributeLabels();
    }

    public static function getPortalVarProperties()
    {
        return PortalVar::find()->andWhere('type_id <> 15')->all();
    }

    public static function getPortalVarSnippets()
    {
        return PortalVar::find()->andWhere('type_id = 15')->all();
    }
}
