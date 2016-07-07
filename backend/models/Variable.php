<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

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
 * @property bool $existing
 *
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
            [['identifier'], 'match', 'pattern' => '/^[_a-zA-Z][a-zA-Z0-9_]*$/i', 'message' => 'Identifikátor musí začínať znakom alebo _, pokračovať smie len znakom, číslom alebo _.']
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

    /** Vrati hodnotu premennej - determinuje, z ktoreho stlpca ju ma tahat
     * @return mixed|string
     */
    public function getValue()
    {
        $value = null;

        switch ($this->var->type->identifier)
        {
            case 'list' :

                $value = $this->valueListVar->value;

                break;

            case 'page' :

                if (isset($this->valuePage))
                    $value = '$portal->pages->page' . $this->valuePage->id;
                else
                    $value = 'NULL';

                break;

            case 'product' :
                if (isset($this->valueProduct))
                    $value = '$' . $this->valueProduct->identifier;
                else
                    $value = 'NULL';

                break;

            case 'product_snippet' :

                $value = $this->valueBlock->compileBlock();
                break;
            default:

                $value = '\''. addslashes(html_entity_decode(Yii::$app->dataEngine->normalizeString(($this->value_text)))) . '\'';
        }

        return $value;
    }
}
