<?php

namespace common\components;


use backend\models\Language;
use backend\models\Page;
use backend\models\Portal;
use backend\models\Product;
use backend\models\Block;
use backend\models\Snippet;
use backend\models\SnippetCode;
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

    public $index = 0;

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
        $this->index = 0;

        $prefix = '<?php ' . PHP_EOL;

        $prefix .= 'include "' . $this->getDictionaryCacheFile($page->portal->language) . '";' . PHP_EOL;
        $prefix .= 'include "' . $this->getProductsMainCacheFile($page->portal->language) . '";' . PHP_EOL;
        $prefix .= 'include "' . $this->getPortalCacheFile($page->portal) . '";' . PHP_EOL;
        $prefix .= 'include "' . $this->getPageCacheFile($page) . '";' . PHP_EOL;
        $prefix .= '?>' . PHP_EOL;

        foreach($page->headerSections as $section)
        {
            foreach($section->rows as $row)
            {
                foreach ($row->columns as $column)
                {
                    foreach($column->pageBlocks as $pageBlock)
                    {
                        $this->compileBlock($pageBlock, $prefix);
                    }
                }
            }
        }

        foreach($page->contentSection->rows as $row)
        {
            foreach ($row->columns as $column)
            {
                foreach($column->pageBlocks as $pageBlock)
                {
                    $this->compileBlock($pageBlock, $prefix);
                }
            }
        }

        foreach($page->sidebarSection->rows as $row)
        {
            foreach ($row->columns as $column)
            {
                foreach($column->pageBlocks as $pageBlock)
                {
                    $this->compileBlock($pageBlock, $prefix);
                }
            }
        }

        foreach($page->footerSections as $section)
        {
            foreach($section->rows as $row)
            {
                foreach ($row->columns as $column)
                {
                    foreach($column->pageBlocks as $pageBlock)
                    {
                        $this->compileBlock($pageBlock, $prefix);
                    }
                }
            }
        }

        array_map('unlink', glob(__DIR__ . '/tmp/*'));
    }

    public function compileBlock(Block $pageBlock, $includeHead)
    {
        $buffer = $includeHead;

        $result = '';

        switch($pageBlock->type)
        {
            case 'snippet' :

                $blockData = $this->compileSnippet($pageBlock);

                $path = $this->getPageBlockCacheDirectory($pageBlock) . 'snippet_cache' . $pageBlock->id . '.latte';

                break;

            default:

                $path = $this->getPageBlockCacheDirectory($pageBlock) . 'block_cache' . $pageBlock->id . '.latte';

                $blockData = $pageBlock->data;
        }

        $buffer .= $blockData;

        $this->writeToFile($path, 'w+', $buffer);

        $result = $this->latteRenderer->renderToString($path, array());

        $pageBlock->compiled_data = $result;

        $pageBlock->save();

        VarDumper::dump($result);

        $this->index++;
    }

    private function compileSnippet(Block $pageBlock)
    {
        $buffer = '<?php ' . PHP_EOL;

        $buffer .= 'include "' . $this->getSnippetMainFile($pageBlock->snippetCode->snippet) . '";' . PHP_EOL;

        $snippetVarValues = $pageBlock->snippetVarValues;

        /* @var $snippetVarValue SnippetVarValue */
        foreach($snippetVarValues as $snippetVarValue)
        {
            $buffer .= '$' . $snippetVarValue->var->identifier . ' = ' . $snippetVarValue->value . ';' . PHP_EOL;
        }

        $buffer .= '?>' . PHP_EOL;

        $buffer .= file_get_contents($this->getSnippetCodeFile($pageBlock->snippetCode));

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

        $this->writeToFile($this->getDictionaryCacheFile($language), 'w+', $buffer);
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
            $buffer .= '$' . $product->identifier . ' = ' . var_export($productVars, true) . '; ?>';
        }

        $this->writeToFile($this->getProductCacheFile($product), 'w+', $buffer);
    }

    public function cachePortal(Portal $portal)
    {
        $directoryPath = $this->getPortalCacheDirectory($portal);

        if (!file_exists($directoryPath))
        {
            $this->createPortalCacheDirectory($portal);
        }

        $buffer = '<?php ' . PHP_EOL;

        $buffer .= '$domain = \'' . $this->normalizeString($portal->domain) . '\';' . PHP_EOL;
        $buffer .= '$name = \'' . $this->normalizeString($portal->name) . '\';' . PHP_EOL;
        $buffer .= '$lang = \'' . $this->normalizeString($portal->language->identifier) . '\';' . PHP_EOL;
        $buffer .= '$currency = \'' . $this->normalizeString($portal->language->currency) . '\';' . PHP_EOL;
        $buffer .= '$template = \'' . $this->normalizeString($portal->template->identifier) . '\';' . PHP_EOL;
        $buffer .= '$color_scheme = \'' . $this->normalizeString($portal->color_scheme) . '\';' . PHP_EOL;

        //TODO: doplnit dalsie premenne pre podstranku

        $buffer .= '?>';

        $this->writeToFile($this->getPortalCacheFile($portal), 'w+', $buffer);
    }

    public function cachePageVars(Page $page)
    {
        $directoryPath = $this->getPageMainCacheDirectory($page);

        if (!file_exists($directoryPath))
        {
            $this->createPageCacheDirectory($page);
        }

        $buffer = '<?php ' . PHP_EOL;

        $buffer .= '$url = \'' . $this->normalizeString($page->url) . '\';' . PHP_EOL;
        $buffer .= '$name = \'' . $this->normalizeString($page->name) . '\';' . PHP_EOL;
        $buffer .= '$title = \'' . $this->normalizeString($page->title) . '\';' . PHP_EOL;
        $buffer .= '$description = \'' . $this->normalizeString($page->description) . '\';' . PHP_EOL;
        $buffer .= '$keywords = \'' . $this->normalizeString($page->keywords) . '\';' . PHP_EOL;

        $buffer .= '$color_scheme = \'' . $this->normalizeString($page->color_scheme) . '\';' . PHP_EOL;

        $buffer .= '/* Product Variables */' . PHP_EOL;

        if (isset($page->product))
        {
            foreach ($page->product->productVarValues as $productVarValue)
            {
                $buffer .= '$' . $productVarValue->var->identifier . ' = ' .
                '$' . $page->product->identifier . '->' . $productVarValue->var->identifier . ';' . PHP_EOL;
            }
        }
        $buffer .= '?>';

        $this->writeToFile($directoryPath . 'page_var.php', 'w+', $buffer);
    }

    /** Cachovanie zakladnych informacii o snippete (premenne a default hodnoty)
     * @param Snippet $snippet
     */
    public function cacheSnippet(Snippet $snippet)
    {
        $directoryPath = $this->getSnippetDirectory($snippet);

        if (!file_exists($directoryPath))
        {
            $this->createSnippetDirectory($snippet);
        }

        $buffer = '<?php ' . PHP_EOL;

        foreach($snippet->snippetVariables as $snippetVar)
        {
            if (isset($snippetVar->default_value))
                $buffer .= '$' . $snippetVar->identifier . ' = "' . $this->normalizeString($snippetVar->default_value) . '";' . PHP_EOL;
        }

        $buffer .= '?>' . PHP_EOL;

        $this->writeToFile($this->getSnippetMainFile($snippet), 'w+', $buffer);
    }

    /** Cachovanie zakladnych informacii o kode snippetu (kod)
     * @param SnippetCode $snippetCode
     */
    public function cacheSnippetCode(SnippetCode $snippetCode)
    {
        $directoryPath = $this->getSnippetDirectory($snippetCode->snippet);

        if (!file_exists($directoryPath))
        {
            $this->createSnippetDirectory($snippetCode->snippet);
        }

        $buffer = $snippetCode->code;

        $this->writeToFile($this->getSnippetCodeFile($snippetCode), 'w+', $buffer);
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

            mkdir($directoryPath . 'portals', 0777, true); //vytvori priecinok pre portaly
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
            mkdir($this->getPagesMainCacheDirectory($portal), 0777, true);
        }
    }

    /** Metoda na vytvorenie centralneho suboru, ktory obsahuje cesty ku vsetkym suborom jednotlivych produktov
     * @param Language $language
     */
    public function createProductsMainCacheFile(Language $language)
    {
        $buffer = '<?php ' . PHP_EOL;

        foreach($language->products as $product)
        {
            $buffer .= 'include "' . $this->getProductCacheFile($product) . '";' . PHP_EOL;
        }

        $buffer .= ' ?>';


        $this->writeToFile($this->getProductsMainCacheFile($language), 'w+', $buffer);
    }

    public function createPageCacheDirectory(Page $page)
    {
        $directoryPath = $this->getPageMainCacheDirectory($page);

        mkdir($directoryPath, 0777, true);
    }

    public function createSnippetsMainDirectory()
    {
        $directoryPath = $this->getSnippetsMainDirectory();

        mkdir($directoryPath, 0777, true);
    }

    public function createSnippetDirectory(Snippet $snippet)
    {
        $directoryPath = $this->getSnippetDirectory($snippet);

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
        return $this->getLanguageCacheDirectory($portal->language) . 'portals/' . $portal->domain . '/';
    }

    /** Vrati cestu k suboru, v ktorom nacachovane data k portalu
     * @param Portal $portal
     * @return string
     */
    public function getPortalCacheFile(Portal $portal)
    {
        return $this->getPortalCacheDirectory($portal) . 'portal_var.php';
    }

    /** Vrati cestu k hlavnemu adresaru, v ktorom su ulozene nacachovane podstranky pre dany portal
     * @param Portal $portal
     * @return string
     */
    public function getPagesMainCacheDirectory(Portal $portal)
    {
        return $this->getPortalCacheDirectory($portal) . 'pages/';
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre danu podstranku
     * @param Page $page
     * @return string
     */
    public function getPageMainCacheDirectory(Page $page)
    {
        return $this->getPagesMainCacheDirectory($page->portal) . 'page' . $page->id . '/';
    }

    /** Vrati cestu k suboru, v ktorom su ulozene premenne podstranky
     * @param Page $page
     * @return string
     */
    public function getPageCacheFile(Page $page)
    {
        return $this->getPageMainCacheDirectory($page) . 'page_var.php';
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre produkty daneho jazyka
     * @param Language $language
     * @return string
     */
    public function getProductsCacheDirectory(Language $language)
    {
        return $this->getLanguageCacheDirectory($language) . 'products/';
    }

    /** Vrati cestu k hlavnemu suboru, v ktorom su includnute vsetky nacachovane subory pre produkty daneho jazyka
     * @param Language $language
     * @return string
     */
    public function getProductsMainCacheFile(Language $language)
    {
        return $this->getLanguageCacheDirectory($language) . 'products.php';
    }

    /** Vrati cestu k suboru, v ktorom je nacachovany produkt
     * @param Product $product
     * @return string
     */
    public function getProductCacheFile(Product $product)
    {
        return $this->getProductsCacheDirectory($product->language) . $product->identifier . '.php';
    }

    /** vrati cestu k hlavnemu adresaru, kde su ulozene informacie k snippetom
     * @return string
     */
    public function getSnippetsMainDirectory()
    {
        return $this->cacheDirectory . 'snippets/';
    }

    /** Vrati cestu k adresaru, kde su ulozene nacachovane veci k snippetu
     * @param Snippet $snippet
     * @return string
     */
    public function getSnippetDirectory(Snippet $snippet)
    {
        return $this->getSnippetsMainDirectory() . 'snippet' . $snippet->id . '/';
    }

    /** Metoda na vratenie cesty k hlavnemu suboru pre dany snippet (obsahuje premenne snippetu
     * s default hodnotami a nastavenia snippetu)
     * @param Snippet $snippet
     * @return string
     */
    public function getSnippetMainFile(Snippet $snippet)
    {
        return $this->getSnippetDirectory($snippet) . 'snippet.php';
    }

    /** Vrati cestu k nacachovanemu suboru, kde su ulozene informacie o kode snippetu a jeho premennych
     * @param SnippetCode $snippetCode
     * @return string
     */
    public function getSnippetCodeFile(SnippetCode $snippetCode)
    {
        return $this->getSnippetDirectory($snippetCode->snippet) . 'code' . $snippetCode->id . '.php';
    }

    /** Vrati cestu k adresaru, v ktorom budu sablony jednotlivych snippetov
     * @return string
     */
    public function getPageBlocksMainCacheDirectory()
    {
        return $this->cacheDirectory . 'page_blocks/';
    }

    /** Vrati cestu k adresaru, do ktoreho sa ma cachovat pageblock
     * @param Block $pageBlock
     * @return string
     */
    public function getPageBlockCacheDirectory(Block $pageBlock)
    {
        $path = '';

        if (isset($pageBlock->page))
            $path = $this->getPageMainCacheDirectory($pageBlock->page) . 'cache/';
        else if (isset($pageBlock->portal))
            $path = $this->getPortalCacheDirectory($pageBlock->portal) . 'cache/';

        return $path;
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

    private function normalizeString($string)
    {
        /*$re = '~
			(?P<comment>\\*.*?\\*{\n{0,2})|
			(?P<macro>(?:
				\'(?:\\\\.|[^\'\\\\])*\'|"(?:\\\\.|[^"\\\\])*"|
				\{(?:\'(?:\\\\.|[^\'\\\\])*\'|"(?:\\\\.|[^"\\\\])*"|[^\'"{}])*+\}|
				[^\'"{}]
			)+?)
			}
			(?P<rmargin>[ \t]*(?=\n))?
		~xsiA';

		preg_match($re, $var, $matches);

		foreach ($matches as $match ) {
			$match = str_replace("{", "' . ", $match);
		}*/

        $re = '/{\$[\w->]+}/';

        //$code = str_replace("stdClass::__set_state", "(object)", $code);

        preg_match_all($re, $string, $matches);

        //print_r($matches);

        foreach ($matches[0] as $match )
        {
            $newString = str_replace("{", "' . ", $match);
            $newString = str_replace("}", " . '", $newString);

            //echo $newString;

            $string = str_replace($match, $newString, $string);
        }

        $string = addslashes($string);

        return $string;
    }
}