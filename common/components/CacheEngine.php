<?php

namespace common\components;


use backend\models\Language;
use backend\models\Page;
use backend\models\Portal;
use backend\models\Product;
use backend\models\PageBlock;
use backend\models\SnippetVarValue;
use Latte\Loaders\FileLoader;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

use Latte\Engine;
use Latte\Loaders\StringLoader;

class CacheEngine extends Component
{
    /**
     * @var string adresar, v ktorom sa nachadza cache
     */
    public $cacheDirectory = '';

    /**
     * @var Engine
     */
    public $latteRenderer;

    public function init()
    {
        $this->cacheDirectory = Yii::getAlias('@publicDirectory') . '/cache/';

        $this->latteRenderer = new Engine();

        $this->latteRenderer->setLoader(new FileLoader());

        $this->latteRenderer->setTempDirectory(__DIR__.'/tmp');
    }

    public function compilePage(Page $page)
    {
        $prefix = '<?php ' . PHP_EOL;

        $prefix .= 'include "' . $this->getDictionaryCacheFile($page->portal->language) . '";' . PHP_EOL;
        $prefix .= 'include "' . $this->getProductsCacheFile($page->portal->language) . '";' . PHP_EOL;
        $prefix .= 'include "' . $this->getPortalCacheFile($page->portal) . '";' . PHP_EOL;
        $prefix .= 'include "' . $this->getPageCacheFile($page) . '";' . PHP_EOL;
        $prefix .= '?>' . PHP_EOL;

        foreach($page->sections as $section)
        {
            foreach($section->rows as $row)
            {
                foreach ($row->columns as $column)
                {
                    VarDumper::dump('dasd');

                    foreach($column->pageBlocks as $pageBlock)
                    {
                        $this->compileBlock($pageBlock, $prefix);
                    }
                }
            }
        }
    }

    public function compileBlock(PageBlock $pageBlock, $includeHead)
    {
        $buffer = $includeHead;

        switch($pageBlock->type)
        {
            case 'snippet' :

                $blockData = $this->compileSnippet($pageBlock);

                break;

            default:

                $blockData = $pageBlock->data;
        }

        $buffer .= $blockData;

        $path = $this->cacheDirectory . '/block_cache.latte';

        $this->writeToFile($path, 'w+', $buffer);

        $result = $this->latteRenderer->renderToString($path, array());

        $pageBlock->compiled_data = $result;

        $pageBlock->save();

        VarDumper::dump($result);
    }

    private function compileSnippet(PageBlock $pageBlock)
    {
        $buffer = '<?php ' . PHP_EOL;

        $snippetDefaultValues = $pageBlock->snippetCode->snippet->snippetVars;

        foreach($snippetDefaultValues as $snippetVar)
        {
            $buffer .= '$' . $snippetVar->identifier . ' = \'' . $snippetVar->default_value . '\';' . PHP_EOL;
        }

        $snippetVarValues = $pageBlock->snippetVarValues;

        /* @var $snippetVarValue SnippetVarValue */
        foreach($snippetVarValues as $snippetVarValue)
        {
            $buffer .= '$' . $snippetVarValue->var->identifier . ' = \'' . $snippetVarValue->value_text . '\';' . PHP_EOL;
        }

        $buffer .= '?>' . PHP_EOL;

        $buffer .= $pageBlock->snippetCode->code;

        return $buffer;
    }

    private function createTemplate()
    {
        $fileName = '';

        $stringTemplate = '<?php $nadpis = "asddasd"; ?><h1>{$nadpis}</h1>';

        return $fileName;
    }

    private function renderTemplate($fileName)
    {
        $this->latteRenderer->setLoader(new StringLoader());

        $string = '<?php $nadpis = "asddasd"; ?><h1>{$nadpis}</h1>';

        $renderedString = $this->latteRenderer->renderToString($string, array());

        return $renderedString;
    }

    //region ========================  CACHE SEKCIA  =================================
    /** Metoda na cachovanie slovnika
     * @param Language $language
     */
    public function cacheDictionary(Language $language)
    {
        $buffer = '<?php ' . PHP_EOL . '$slovnik = ';

        $query = 'SELECT identifier, translation FROM dictionary
          JOIN dictionary_translation ON (dictionary.id = word_id)
          WHERE language_id = :language_id';

        $words = (object)ArrayHelper::map(Yii::$app->db->createCommand($query,
            [':language_id' => $language['id']])
            ->queryAll(), 'identifier', 'translation');

        $buffer .= var_export($words, true) . '; ?>';

        $directoryPath = $this->cacheDirectory . '/' . $language->identifier;

        if (!file_exists($directoryPath))
            $this->createLanguageCacheDirectory($language);

        $buffer = str_replace("stdClass::__set_state", "(object)", $buffer);

        $this->writeToFile($this->getDictionaryCacheFile(), 'w+', $buffer);
    }

    /** Metoda na cachovanie vsetkych produktov pre dany jazyk
     * @param Product $product
     */
    public function cacheProduct(Product $product)
    {
        $buffer = '<?php ' . PHP_EOL;

        $query = 'SELECT identifier, value FROM product_var
          JOIN product_var_value ON (product_var.id = var_id)
          WHERE product_id = :product_id';

        $productVars = ArrayHelper::map(Yii::$app->db->createCommand($query,
            [':product_id' => $product['id']])
            ->queryAll(), 'identifier', 'value');

        if (isset($product->parent)) // ak ma produkt rodica
        {
            $buffer .= '$' . $product->identifier . ' = array_merge($' . $product->parent->identifier . '
                , ' . var_export($productVars, true) . '); ?>';
        }
        else
        {
            $buffer .= '$' . $product->identifier . '= ' .var_export($productVars, true) . '; ?>';
        }

        $directoryPath = $this->getProductsCacheDirectory($product->language);

        $this->writeToFile($directoryPath . $product->identifier . '.php', 'w+', $buffer);
    }

    public function cachePortal(Portal $portal)
    {
        $directoryPath = $this->getPortalCacheDirectory($portal);

        if (!file_exists($directoryPath))
        {
            $this->createPortalCacheDirectory($portal);
        }

        $buffer = '<?php ' . PHP_EOL;

        $buffer .= '$domain = \'' . $portal->domain . '\';' . PHP_EOL;
        $buffer .= '$name = \'' . $portal->name . '\';' . PHP_EOL;
        $buffer .= '$lang = \'' . $portal->language->identifier . '\';' . PHP_EOL;
        $buffer .= '$currency = \'' . $portal->language->currency . '\';' . PHP_EOL;
        $buffer .= '$template = \'' . $portal->template->identifier . '\';' . PHP_EOL;

        //$buffer .= '$color_scheme = \'' . $portal->color_scheme . '\';' . PHP_EOL;

        //TODO: doplnit dalsie premenne pre podstranku

        $buffer .= '?>';

        $this->writeToFile($this->getPortalCacheFile(), 'w+', $buffer);
    }

    public function cachePage(Page $page)
    {
        $directoryPath = $this->getPageCacheDirectory($page);

        if (!file_exists($directoryPath))
        {
            $this->createPageCacheDirectory($page);
        }

        $buffer = '<?php ' . PHP_EOL;

        $buffer .= '$url = \'' . $page->url . '\';' . PHP_EOL;
        $buffer .= '$name = \'' . $page->name . '\';' . PHP_EOL;
        $buffer .= '$title = \'' . $page->title . '\';' . PHP_EOL;
        $buffer .= '$description = \'' . $page->description . '\';' . PHP_EOL;
        $buffer .= '$keywords = \'' . $page->keywords . '\';' . PHP_EOL;

        $buffer .= '$color_scheme = \'' . $page->color_scheme . '\';' . PHP_EOL;

        $buffer .= '/* Product Variables */' . PHP_EOL;

        $pageProduct = isset($page->product) ? $page->product : $page->parent->product;

        foreach($pageProduct->productVarValues as $productVarValue)
        {
            $buffer .= '$' . $productVarValue->var->identifier . ' = "' . $productVarValue->value . '";' . PHP_EOL;
        }

        $buffer .= '?>';

        $this->writeToFile($directoryPath . 'page_var.php', 'w+', $buffer);
    }
    //endregion


    //region ========================  CREATE SEKCIA  =================================
    /** Metoda na vytvorenie adresara pri pridani novej krajiny
     * @param Language $language
     */
    public function createLanguageCacheDirectory(Language $language)
    {
        $directoryPath = $this->getLanguageCacheDirectory($language);

        if (!file_exists($directoryPath))
        {
            mkdir($directoryPath, 0777, true);

            mkdir($directoryPath . 'portal', 0777, true); //vytvori priecinok pre portaly
            mkdir($directoryPath . 'products', 0777, true); //vytvori priecinok pre produkty
        }
    }

    /** Metoda na vytvorenie adresara pri pridavani portalu
     * @param Portal $portal
     */
    public function createPortalCacheDirectory(Portal $portal)
    {
        $directoryPath = $this->getPortalCacheDirectory($portal);

        if (!file_exists($directoryPath))
        {
            mkdir($directoryPath, 0777, true);
        }
    }

    public function createProductFile(Language $language)
    {
        $directoryPath = $this->getLanguageCacheDirectory($language);

        $query = 'SELECT identifier FROM product WHERE language_id = :language_id ORDER BY parent_id';

        $products = Yii::$app->db->createCommand(
                $query,
                [
                    ':language_id' => $language['id']
                ]
            )
            ->queryAll();

        $buffer = '<?php ' . PHP_EOL;

        foreach($products as $key => $product)
        {
            $buffer .= 'include "' . $directoryPath . $product['identifier'] . '.php"; ' . PHP_EOL;
        }

        $buffer .= ' ?>';


        $this->writeToFile($this->getProductsCacheFile(), 'w+', $buffer);
    }

    public function createPageCacheDirectory(Page $page)
    {
        $directoryPath = $this->getPageCacheDirectory($page);

        mkdir($directoryPath, 0777, true);
    }
    //endregion


    //region ========================  GET SEKCIA  =================================*/
    /** Vrati cestu k adresaru, kde su ulozene cache subory pre dany jazyk
     * @param Language $language
     * @return string
     */
    public function getLanguageCacheDirectory(Language $language)
    {
        return $this->cacheDirectory . $language->identifier . '/';
    }

    /** Vrati cestu k suboru, v ktorom su nacachovane data zo slovnika
     * @param Language $language
     * @return string
     */
    public function getDictionaryCacheFile(Language $language)
    {
        return $this->getProductsCacheDirectory($language) . 'dictionary.php';
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre dany portal
     * @param Portal $portal
     * @return string
     */
    public function getPortalCacheDirectory(Portal $portal)
    {
        return $this->getLanguageCacheDirectory($portal->language) . $portal->domain . '/';
    }

    /** Vrati cestu k suboru, v ktorom nacachovane data k portalu
     * @param Portal $portal
     * @return string
     */
    public function getPortalCacheFile(Portal $portal)
    {
        return $this->getPortalCacheDirectory($portal) . 'portal_var.php';
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre danu podstranku
     * @param Page $page
     * @return string
     */
    public function getPageCacheDirectory(Page $page)
    {
        return $this->getPortalCacheDirectory($page->portal) . 'page' . $page->id . '/';
    }

    /** Vrati cestu k suboru, v ktorom su ulozene premenne podstranky
     * @param Page $page
     * @return string
     */
    public function getPageCacheFile(Page $page)
    {
        return $this->getPageCacheDirectory($page) . 'page_var.php';
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre produkty daneho jazyka
     * @param Language $language
     * @return string
     */
    public function getProductsCacheDirectory(Language $language)
    {
        return $this->getLanguageCacheDirectory($language) . 'products/';
    }

    /** Vrati cestu k suboru, v ktorom su includnute vsetky nacachovane subory pre produkty daneho jazyka
     * @param Language $language
     * @return string
     */
    public function getProductsCacheFile(Language $language)
    {
        return $this->getProductsCacheDirectory($language) . 'products.php';
    }
    //endregion

    /** Funkcia na zapis do suboru
     * @param $path - cesta k suboru
     * @param $mode - mod zapisu (napr. w, w+)
     * @param $string - retazec, ktory sa ma zapisat
     */
    private function writeToFile($path, $mode, $string)
    {
        $file = fopen($path, $mode);
        fwrite($file, $string);
        fclose($file);
    }
}