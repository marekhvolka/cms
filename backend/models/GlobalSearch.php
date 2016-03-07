<?php

use Yii;

class GlobalSearch
{
    public $globalSearch;

    public function search($params)
    {
        $results = array();

        $results['snippet'] = Yii::$app->db
            ->createCommand('SELECT * FROM snippet WHERE name LIKE %?% OR popis LIKE %?%',
                $this->globalSearch, $this->globalSearch);

        $results['page'] = Yii::$app->db
            ->createCommand('SELECT * FROM page WHERE name LIKE %?% OR url LIKE %?%',
                $this->globalSearch, $this->globalSearch);

        $results['product'] = Yii::$app->db
            ->createCommand('SELECT * FROM product WHERE name LIKE %?% OR identifier LIKE %?%',
                $this->globalSearch, $this->globalSearch);
        return $results;
    }

}