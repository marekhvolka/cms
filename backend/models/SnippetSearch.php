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
    public $globalSearch;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'default_code_id', 'typ_snippet', 'last_edit_user'], 'integer'],
            [['globalSearch', 'name', 'popis', 'sekcia_id', 'sekcia_class', 'sekcia_style', 'block_id', 'block_class', 'block_style', 'last_edit'], 'safe'],
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

        $query->orFilterWhere(['like', 'name', $this->globalSearch])
            ->orFilterWhere(['like', 'popis', $this->globalSearch]);

        return $dataProvider;
    }
}
