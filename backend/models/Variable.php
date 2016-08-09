<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "variable".
 *
 * @property string $id
 * @property string $identifier
 * @property string $description
 * @property integer $type_id
 * @property VarType $type
 * @property string $product_type
 * @property integer $last_edit_user
 * @property User $lastEditUser
 */
abstract class Variable extends CustomModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identifier', 'type_id'], 'required'],
            [['type_id', 'description'], 'string'],
            [['identifier'], 'string', 'max' => 50],
            [
                ['identifier'],
                'match',
                'pattern' => '/^[_a-zA-Z][a-zA-Z0-9_]*$/i',
                'message' => 'Identifikátor musí začínať znakom alebo _, pokračovať smie len znakom, číslom alebo _.'
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
            'identifier' => 'Identifikátor',
            'description' => 'Popis',
            'type_id' => 'Typ premennej',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(VarType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /** Vrati true, ak je premenna typu portalovy/produktovy snippet
     * @return bool
     */
    public function isSnippet()
    {
        return ($this->type->identifier == 'product_snippet' || $this->type->identifier == 'portal_snippet');
    }
}
