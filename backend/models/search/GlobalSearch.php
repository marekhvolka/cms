<?php

namespace backend\models\search;

use backend\models\Model;
use backend\models\Page;
use backend\models\Portal;
use Yii;
use yii\db\Query;
use yii\helpers\Url;

/**
 * Used for global searching throughout the whole application's data.
 * 
 * @package backend\models\search
 */
class GlobalSearch
{
    /**
     * Searchs for items which satisfy the given search term
     *
     * @param $searchTerm
     * @return array
     */
    public function search($searchTerm)
    {
        $results = array(
            'snippet' => [],
            'snippet_code' => [],
            'page' => [],
            'product' => []
        );

        // SNIPPETS
        $snippets = (new Query())->select("id, name")->from("snippet")->where(['like', 'name', $searchTerm])
            ->limit(10)->all();

        foreach ($snippets as $snippet) {
            $results['snippet'][] = ['link' => Url::to(['/snippet/edit', 'id' => $snippet['id']])] + $snippet;
        }

        // SNIPPET CODES / ALTERNATIVES

        $snippet_codes = (new Query())->select("id, name, snippet_id")
            ->from("snippet_code")
            ->filterWhere(['like', 'name', $searchTerm])
            ->limit(10)
            ->all();

        foreach ($snippet_codes as $snippet_code) {
            $results['snippet_code'][] = ['link' => Url::to([
                    '/snippet/edit',
                    'id' => $snippet_code['snippet_id'],
                    '#' => 'code' . $snippet_code['id'],
                ])] + $snippet_code;
        }

        // PAGES

        $pages = (new Query())->select("id, name")->from("page")->filterWhere([
            'or',
            ['like', 'name', $searchTerm],
            ['like', 'identifier', $searchTerm],
            ['like', 'title', $searchTerm],
            ])
            ->andWhere([
                'portal_id' => Yii::$app->session->get('portal_id')
            ])
            ->limit(10)->all();

        foreach ($pages as $page) {
            $results['page'][] = ['link' => Url::to(['/page/edit', 'id' => $page['id']])] + $page;
        }

        // PRODUCTS
        $portal = Portal::findOne(Yii::$app->session->get('portal_id'));

        $products = (new Query())->select("id, name")->from("product")->filterWhere(['like', 'name', $searchTerm])
            ->andWhere([
                'language_id' => $portal->language_id
            ])
            ->limit(10)->all();

        foreach ($products as $product) {
            $results['product'][] = ['link' => Url::to(['/product/edit', 'id' => $product['id']])] + $product;
        }
        
        return $results;
    }
}