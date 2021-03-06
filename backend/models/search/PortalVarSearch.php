<?php

namespace backend\models\search;

use backend\models\PortalVar;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PortalVarSearch represents the model behind the search form about `backend\models\PortalVar`.
 */
class PortalVarSearch extends PortalVar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'last_edit_user'], 'integer'],
            [['name', 'identifier', 'description', 'last_edit'], 'safe'],
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
        $query = PortalVar::find();

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
            'type_id' => $this->type_id,
            'last_edit' => $this->last_edit,
            'last_edit_user' => $this->last_edit_user,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'identifier', $this->identifier])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
