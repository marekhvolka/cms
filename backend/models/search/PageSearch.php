<?php

namespace backend\models\search;

use backend\controllers\BaseController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Page;
use yii\db\Query;

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
            [
                [
                    'id',
                    'portal_id',
                    'active',
                    'parent_id',
                    'product_id',
                    'last_edit_user'
                ],
                'integer'
            ],
            [
                [
                    'globalSearch',
                    'name',
                    'identifier',
                    'title',
                    'description',
                    'keywords',
                    'color_scheme',
                    'sidebar_side',
                    'last_edit',
                    'breadcrumbs',
                    'url'
                ],
                'safe'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ['globalSearch' => 'Vyhľadávať hlavné stránky (ignoruje podstránky)'] + parent::attributeLabels();
    }


    /**
     * Return the query to fetch all pages which satisfy the search term.
     *
     * @param $params array parameters
     * @param bool $byPortal indicates if the returned query is bound to current Portal
     * @return Query
     */
    public function search($params, $byPortal = null)
    {
        $query = Page::find();

        if ($byPortal) {
            $portalID = BaseController::$portal;
            $query->where(['portal_id' => $portalID]);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $query;
        }

        if (!empty($this->globalSearch)) {
            $query->andFilterWhere(['like', 'name', $this->globalSearch]);
        }

        return $query;
    }
}
