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
    public $globalSearch;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'portal_id', 'active', 'in_menu', 'parent_id', 'poradie', 'product_id', 'presmerovanie_aktivne', 'sidebar', 'sidebar_size', 'footer', 'header', 'last_edit_user'], 'integer'],
            [['globalSearch', 'name', 'url', 'presmerovanie', 'utm', 'seo_title', 'seo_description', 'seo_keywords', 'layout_poradie', 'layout_poradie_id', 'layout_element', 'layout_element_type', 'layout_element_active', 'layout_element_time_from', 'layout_element_time_to', 'color_scheme', 'sidebar_side', 'last_edit'], 'safe'],
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

        $query->orFilterWhere(['like', 'name', $this->globalSearch])
            ->orFilterWhere(['like', 'url', $this->globalSearch]);

        return $dataProvider;
    }
}
