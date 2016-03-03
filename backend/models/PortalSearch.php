<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Portal;

/**
 * PortalSearch represents the model behind the search form about `app\models\Portal`.
 */
class PortalSearch extends Portal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language_id', 'template_id', 'active', 'publikovana', 'cache'], 'integer'],
            [['name', 'domain', 'template_settings'], 'safe'],
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
        $query = Portal::find();

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
            'language_id' => $this->language_id,
            'template_id' => $this->template_id,
            'active' => $this->active,
            'publikovana' => $this->publikovana,
            'cache' => $this->cache,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'template_settings', $this->template_settings]);

        return $dataProvider;
    }
}
