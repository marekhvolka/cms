<?php

namespace backend\models\search;

use backend\controllers\BaseController;
use backend\models\Redirect;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RedirectSearch represents the model behind the search form about `backend\models\Redirect`.
 */
class RedirectSearch extends Redirect
{
    public $globalSearch;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'redirect_type'], 'integer'],
            [['globalSearch', 'source_url', 'target_url'], 'safe'],
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

        $query->where(['portal_id' => Yii::$app->user->identity->portal_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->globalSearch)) {
            $query->andFilterWhere(['like', 'source_url', $this->globalSearch])
                ->andFilterWhere(['like', 'target_url', $this->globalSearch]);
        }
        return $dataProvider;
    }
}
