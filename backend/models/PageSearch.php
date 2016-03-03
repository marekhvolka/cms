<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Page;

/**
 * PageSearch represents the model behind the search form about `app\models\Page`.
 */
class PageSearch extends Page
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'portal_id', 'active', 'in_menu', 'parent_id', 'poradie', 'product_id', 'presmerovanie_aktivne', 'sidebar', 'sidebar_size', 'footer', 'header', 'last_edit_user'], 'integer'],
            [['name', 'url', 'presmerovanie', 'utm', 'seo_title', 'seo_description', 'seo_keywords', 'layout_poradie', 'layout_poradie_id', 'layout_element', 'layout_element_type', 'layout_element_active', 'layout_element_time_from', 'layout_element_time_to', 'color_scheme', 'sidebar_side', 'last_edit'], 'safe'],
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
        $query = Page::find();

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
            'portal_id' => $this->portal_id,
            'active' => $this->active,
            'in_menu' => $this->in_menu,
            'parent_id' => $this->parent_id,
            'poradie' => $this->poradie,
            'product_id' => $this->product_id,
            'presmerovanie_aktivne' => $this->presmerovanie_aktivne,
            'sidebar' => $this->sidebar,
            'sidebar_size' => $this->sidebar_size,
            'footer' => $this->footer,
            'header' => $this->header,
            'last_edit' => $this->last_edit,
            'last_edit_user' => $this->last_edit_user,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'presmerovanie', $this->presmerovanie])
            ->andFilterWhere(['like', 'utm', $this->utm])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'layout_poradie', $this->layout_poradie])
            ->andFilterWhere(['like', 'layout_poradie_id', $this->layout_poradie_id])
            ->andFilterWhere(['like', 'layout_element', $this->layout_element])
            ->andFilterWhere(['like', 'layout_element_type', $this->layout_element_type])
            ->andFilterWhere(['like', 'layout_element_active', $this->layout_element_active])
            ->andFilterWhere(['like', 'layout_element_time_from', $this->layout_element_time_from])
            ->andFilterWhere(['like', 'layout_element_time_to', $this->layout_element_time_to])
            ->andFilterWhere(['like', 'color_scheme', $this->color_scheme])
            ->andFilterWhere(['like', 'sidebar_side', $this->sidebar_side]);

        return $dataProvider;
    }
}
