<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Product;
use yii\db\Query;

/**
 * ProductSearch represents the model behind the search form about `app\models\Product`.
 */
class ProductSearch extends Product
{
    public $globalSearch;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'type_id', 'language_id', 'active', 'last_edit_user'], 'integer'],
            [['globalSearch', 'name', 'identifier', 'popis', 'last_edit'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return Query
     */
    public function search($params)
    {
        $query = Product::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $query;
        }

        if (!empty($this->globalSearch)) {
            $query->andFilterWhere(['like', 'name', $this->globalSearch]);
            $query->andFilterWhere(['like', 'identifier', $this->globalSearch]);
            $query->andFilterWhere(['like', 'popis', $this->globalSearch]);
        }

        return $query;
    }
}
