<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Snippet;

/**
 * SnippetSearch represents the model behind the search form about `app\models\Snippet`.
 */
class SnippetSearch extends Snippet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'default_code_id', 'typ_snippet', 'last_edit_user'], 'integer'],
            [['name', 'popis', 'sekcia_id', 'sekcia_class', 'sekcia_style', 'block_id', 'block_class', 'block_style', 'last_edit'], 'safe'],
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
        $query = Snippet::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'default_code_id' => $this->default_code_id,
            'typ_snippet' => $this->typ_snippet,
            'last_edit' => $this->last_edit,
            'last_edit_user' => $this->last_edit_user,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'popis', $this->popis])
            ->andFilterWhere(['like', 'sekcia_id', $this->sekcia_id])
            ->andFilterWhere(['like', 'sekcia_class', $this->sekcia_class])
            ->andFilterWhere(['like', 'sekcia_style', $this->sekcia_style])
            ->andFilterWhere(['like', 'block_id', $this->block_id])
            ->andFilterWhere(['like', 'block_class', $this->block_class])
            ->andFilterWhere(['like', 'block_style', $this->block_style]);

        return $dataProvider;
    }
}
