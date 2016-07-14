<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property string $identifier
 * @property integer $active
 * @property string $product_type
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property string $value
 * @property Tag[] $products
 * @property User $lastEditUser
 * @property SnippetVarValue[] $snippetVarValues
 */
class Tag extends CustomModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    public function init()
    {
        $this->active = 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'label', 'identifier', 'active', 'product_type'], 'required'],
            [['active', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name', 'label', 'identifier'], 'string', 'max' => 50],
            [['product_type'], 'string', 'max' => 100],
            [['identifier'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Systémový názov',
            'label' => 'Názov',
            'identifier' => 'Identifikátor',
            'active' => 'Aktívny',
            'product_type' => 'Typy produktov',
            'last_edit' => 'Dátum poslednej zmeny',
            'last_edit_user' => 'Naposledy editoval',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
            ->viaTable('product_tag', ['tag_id' => 'id']);
    }

    public function updateProducts()
    {
        $tagId = $this->id;
        $products = Yii::$app->request->post('Tag');

        if (!isset($products['_products'])) {
            $products = [];
        } else {
            $products = $products['_products'];
        }

        $saved_tags = $this->getProducts()->select('id')->asArray()->column();

        $to_remove = array_filter($saved_tags, function ($item) use ($products) {
            return !in_array($item, $products);
        });

        $to_add = array_map(function ($id) use ($tagId) {
            return [
                'tag_id' => $tagId,
                'product_id' => $id,
                'last_edit_user' => Yii::$app->user->getId()
            ];
        }, array_filter($products, function ($item) use ($saved_tags) {
            return !in_array($item, $saved_tags);
        }));

        if (count($to_remove) > 0) {
            (new Query())->createCommand()->delete('product_tag', ['product_id' => $to_remove, 'tag_id' => $this->id])->execute();
        }
        if (count($to_add) > 0) {
            (new Query())->createCommand()->batchInsert('product_tag', ['tag_id', 'product_id', 'last_edit_user'], $to_add)->execute();
        }
    }

    public function getSnippetVarValues()
    {
        return $this->hasMany(SnippetVarValue::className(), ['value_tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /**
     * Vrati objekt podstranky spolu so zoznamom zakladnych premennych
     */
    public function getValue()
    {
        $buffer = '(object) array(' . PHP_EOL;

        $buffer .= '\'label\' => \'' . Yii::$app->dataEngine->normalizeString($this->label) . '\', ' . PHP_EOL;
        $buffer .= '\'id\' => \'' . $this->identifier . '\', ' . PHP_EOL;

        $buffer .= ')';

        return $buffer;
    }

    public function resetAfterUpdate()
    {
        foreach ($this->products as $product) {
            $product->resetAfterUpdate();
        }

        foreach ($this->snippetVarValues as $snippetVarValue) {
            $snippetVarValue->resetAfterUpdate();
        }
    }
}
