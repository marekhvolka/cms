<?php

namespace backend\models\search;

use backend\models\Snippet;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
            [['id', 'last_edit_user'], 'integer'],
            [
                [
                    'globalSearch',
                    'name',
                    'description',
                    'last_edit'
                ],
                'safe'
            ],
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
            'query' => Yii::$app->user->identity->portal->getSnippets(),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->orFilterWhere(['like', 'name', $this->globalSearch])
            ->orFilterWhere(['like', 'description', $this->globalSearch]);

        return $dataProvider;
    }
}
