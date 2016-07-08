<?php

namespace backend\models\search;

use backend\controllers\BaseController;
use backend\models\TrackingCode;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TrackingCodeSearch represents the model behind the search form about `backend\models\TrackingCode`.
 */
class TrackingCodeSearch extends TrackingCode
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'place_id', 'portal_id', 'active', 'last_edit_user'], 'integer'],
            [['name', 'code', 'last_edit'], 'safe'],
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
        $query = TrackingCode::find();

        $query->where(['portal_id' => BaseController::$portal->id]);

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
            'place_id' => $this->place_id,
            'portal_id' => $this->portal_id,
            'active' => $this->active,
            'last_edit' => $this->last_edit,
            'last_edit_user' => $this->last_edit_user,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
