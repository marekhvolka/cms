<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'actualPortal', 'role', 'isLog'], 'integer'],
            [['name', 'surname', 'email', 'pass', 'datum_vytvorenia', 'allowPortal', 'cookie_hash', 'lastLog'], 'safe'],
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
        $query = User::find();

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
            'datum_vytvorenia' => $this->datum_vytvorenia,
            'active' => $this->active,
            'actualPortal' => $this->actualPortal,
            'role' => $this->role,
            'isLog' => $this->isLog,
            'lastLog' => $this->lastLog,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'pass', $this->pass])
            ->andFilterWhere(['like', 'allowPortal', $this->allowPortal])
            ->andFilterWhere(['like', 'cookie_hash', $this->cookie_hash]);

        return $dataProvider;
    }
}
