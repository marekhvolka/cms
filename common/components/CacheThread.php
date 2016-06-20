<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 20.06.16
 * Time: 14:56
 */

namespace common\components;

use backend\models\Page;

class CacheThread extends Thread
{
    private $pages;

    public function __construct($_runnable = null)
    {
        parent::__construct($_runnable);

        $this->pages = array();
    }

    public function run()
    {
        /* @var $page Page */
        foreach($this->pages as $page)
        {
            $page->getMainCacheFile();
        }
    }

    /** Metoda na pridanie stranky do zoznamu
     * @param Page $page
     */
    public function addPage(Page $page)
    {
        $this->pages[$page->id] = $page;
    }

}