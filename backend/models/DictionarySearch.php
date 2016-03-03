<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dictionary;

/**
 * DictionarySearch represents the model behind the search form about `backend\models\Dictionary`.
 */
class DictionarySearch extends Dictionary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'last_edit_user'], 'integer'],
            [['word', 'identifier', 'last_edit'], 'safe'],
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
        $query = Dictionary::find();

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
            'last_edit' => $this->last_edit,
            'last_edit_user' => $this->last_edit_user,
        ]);

        $query->andFilterWhere(['like', 'word', $this->word])
            ->andFilterWhere(['like', 'identifier', $this->identifier]);

        return $dataProvider;
    }
}
