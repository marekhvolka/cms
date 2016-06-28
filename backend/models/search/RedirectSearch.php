<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Redirect;

/**
 * RedirectSearch represents the model behind the search form about `backend\models\Redirect`.
 */
class RedirectSearch extends Redirect
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'redirect_type'], 'integer'],
            [['source_url', 'target_url'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Redirect::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'redirect_type' => $this->redirect_type,
        ]);

        $query->andFilterWhere(['like', 'source_url', $this->source_url])
            ->andFilterWhere(['like', 'target_url', $this->target_url]);

        return $dataProvider;
    }
}
