<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Page;

/**
 * PageSearch represents the model behind the search form about `app\models\Page`.
 */
class PageSearch extends Page
{
    public $globalSearch;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'portal_id', 'active', 'in_menu', 'parent_id', 'order', 'product_id', 'sidebar_size', 'last_edit_user'], 'integer'],
            [['globalSearch', 'name', 'identifier', 'title', 'description', 'keywords', 'color_scheme', 'sidebar_side', 'last_edit'], 'safe'],
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
     * @param array $params, $byPortal indicates if returned dataProvider is bound to current Portal
     *
     * @return ActiveDataProvider
     */
    public function search($params, $byPortal = null)
    {
        $query = Page::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if ($byPortal) {
            $portalID = Yii::$app->session->get('portal_id');
            $query->andWhere(['portal_id' => $portalID]);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->orFilterWhere(['like', 'name', $this->globalSearch])
            ->orFilterWhere(['like', 'identifier', $this->globalSearch]);

        return $dataProvider;
    }
}
