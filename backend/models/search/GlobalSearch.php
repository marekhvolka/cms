<?php

namespace backend\models\search;

use backend\models\Model;
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
            ->limit(3)->all();

        foreach ($snippets as $snippet) {
            $results['snippet'][] = ['link' => Url::to(['/snippet/update', 'id' => $snippet['id']])] + $snippet;
        }

        // SNIPPET CODES / ALTERNATIVES

        $snippet_codes = (new Query())->select("id, name, snippet_id")
            ->from("snippet_code")
            ->filterWhere(['like', 'name', $searchTerm])
            ->limit(3)
            ->all();

        foreach ($snippet_codes as $snippet_code) {
            $results['snippet_code'][] = ['link' => Url::to([
                    '/snippet/update',
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
            ->limit(3)->all();

        foreach ($pages as $page) {
            $results['page'][] = ['link' => Url::to(['/page/update', 'id' => $page['id']])] + $page;
        }

        // PRODUCTS

        $products = (new Query())->select("id, name")->from("product")->filterWhere(['like', 'name', $searchTerm])
            ->limit(3)->all();

        foreach ($products as $product) {
            $results['product'][] = ['link' => Url::to(['/product/update', 'id' => $product['id']])] + $product;
        }
        
        return $results;
    }
}