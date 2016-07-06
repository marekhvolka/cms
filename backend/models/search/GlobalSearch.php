<?php

namespace backend\models\search;

use backend\models\Model;
use backend\models\Page;
use backend\models\Portal;
use backend\models\Product;
use backend\models\SnippetCode;
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

        /** @var SnippetCode[] $snippet_codes */
        $snippet_codes = SnippetCode::find()
            ->filterWhere(['like', 'name', $searchTerm])
            ->limit(10)
            ->all();

        foreach ($snippet_codes as $snippet_code) {
            $results['snippet_code'][] = [
                    'link' => Url::to([
                        '/snippet/edit',
                        'id' => $snippet_code['snippet_id'],
                        '#' => 'code' . $snippet_code['id'],
                    ])
                ] + [
                    'name' => $snippet_code->getSnippet()->one()->name . ' >> ' . $snippet_code->name,
                    'id' => $snippet_code->id
                ];
        }

        // PAGES

        $pages = Page::find()->filterWhere([
            'or',
            ['like', 'name', $searchTerm],
            ['like', 'identifier', $searchTerm],
            ['like', 'title', $searchTerm],
        ])
            ->andWhere([
                'portal_id' => Yii::$app->session->get('portal_id')
            ])
            ->limit(10)
            ->all();

        foreach ($pages as $page) {
            $results['page'][] = ['link' => Url::to(['/page/edit', 'id' => $page['id']])] + [
                    'id' => $page->id,
                    'name' => $page->breadcrumbs
                ];
        }

        // PRODUCTS
        $portal = Portal::findOne(Yii::$app->session->get('portal_id'));

        $products = Product::find()
            ->filterWhere(['like', 'name', $searchTerm])
            ->andWhere([
                'language_id' => $portal->language_id
            ])
            ->limit(10)
            ->all();

        foreach ($products as $product) {
            $results['product'][] = [
                    'link' => Url::to([
                        '/product/edit',
                        'id' => $product['id']
                    ])
                ] + ['name' => $product->breadcrumbs, 'id' => $product->id];
        }

        return $results;
    }
}