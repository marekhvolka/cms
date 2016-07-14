<?php

namespace backend\models\search;

use backend\controllers\BaseController;
use backend\models\Portal;
use backend\models\ProductVar;
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
            [['globalSearch', 'name', 'identifier', 'description', 'last_edit'], 'safe'],
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
     * Return the query to fetch all pages which satisfy the search term.
     *
     * @param $params array parameters
     * @param bool $byLanguage indicates if the returned query is bound to current Language
     * @return Query
     */
    public function search($params, $byLanguage = null)
    {
        $query = Product::find();

        if ($byLanguage) {
            $language_id = Yii::$app->user->identity->portal->language_id;
            $query->where(['language_id' => $language_id]);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $query;
        }

        if (!empty($this->globalSearch)) {
            $query->andFilterWhere(['like', 'name', $this->globalSearch]);
        }

        return $query;
    }
}
