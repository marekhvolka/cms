<?php

namespace common\components;


use backend\models\Language;
use backend\models\Page;
use backend\models\Portal;
use backend\models\Product;
use backend\models\PageBlock;
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
        $this->cacheDirectory = Yii::getAlias('@publicDirectory') . '/cache';

        $this->latteRenderer = new Engine();

        $this->latteRenderer->setLoader(new FileLoader());

        $this->latteRenderer->setTempDirectory(__DIR__.'/tmp');
    }

    /** Metoda na vytvorenie adresara pri pridani novej krajiny
     * @param Language $language
     */
    public function createLanguageCacheDirectory(Language $language)
    {
        $directoryPath = $this->cacheDirectory . '/' . $language->identifier;

        if (!file_exists($directoryPath))
        {
            mkdir($directoryPath, 0777, true);

            mkdir($directoryPath . '/portal', 0777, true); //vytvori priecinok pre portaly
            mkdir($directoryPath . '/products', 0777, true); //vytvori priecinok pre produkty
        }
    }

    /** Metoda na vytvorenie adresara pri pridavani portalu
     * @param Portal $portal
     */
    public function createPortalCacheDirectory(Portal $portal)
    {
        $directoryPath = $this->cacheDirectory . '/' . $portal->language->identifier . '/portal/';

        $directoryPath .= $portal->domain;

        if (!file_exists($directoryPath))
        {
            mkdir($directoryPath, 0777, true);
        }
    }

    public function createProductFile(Language $language)
    {
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
            $buffer .= 'include "' . $this->cacheDirectory . '/cz/products/' . $product['identifier'] . '.php"; ' . PHP_EOL;
        }

        $buffer .= ' ?>';

        $directoryPath = $this->cacheDirectory . '/' . $language->identifier;

        $file = fopen($directoryPath . '/products.php', 'w+');
        fwrite($file, $buffer);
        fclose($file);
    }

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

        $file = fopen($directoryPath . '/dictionary.php', 'w+');
        fwrite($file, $buffer);
        fclose($file);
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

        $directoryPath = $this->cacheDirectory . '/' . $product->language->identifier;

        if (!file_exists($directoryPath))
            $this->createLanguageCacheDirectory($product->language);

        $file = fopen($directoryPath . '/products/' . $product->identifier . '.php', 'w+');

        fwrite($file, $buffer);

        fclose($file);
    }

    public function cachePortal(Portal $portal)
    {

    }

    public function cachePage(Page $page)
    {

    }

    public function compileBlock(PageBlock $pageBlock)
    {
        $buffer = '<?php ' . PHP_EOL;

        $buffer .= 'include "' . $this->cacheDirectory . '/cz/dictionary.php";' . PHP_EOL;
        $buffer .= 'include "' . $this->cacheDirectory . '/cz/products.php";' . PHP_EOL;

        $buffer .= '?>' . PHP_EOL;

        switch($pageBlock->type)
        {
            case 'snippet' :

                $blockData = $this->compileSnippet($pageBlock);

                break;

            case 'html' :

                $blockData = $pageBlock->data;

                break;
        }

        $buffer .= $blockData;

        $path = $this->cacheDirectory . '/block_cache.latte';

        $file = fopen($path, 'w+');

        fwrite($file, $buffer);

        fclose($file);

        $result = $this->latteRenderer->renderToString($path, array());

        VarDumper::dump($result);
    }

    private function compileSnippet(PageBlock $pageBlock)
    {
        $buffer = '<?php ' . PHP_EOL;

        $snippetVarValues = json_decode($pageBlock->data, true);

        foreach($snippetVarValues as $identifier => $value)
        {
            $buffer .= '$' . $identifier . ' = \'' . $value . '\';' . PHP_EOL;
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

}