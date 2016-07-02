<?php

namespace common\components;


use Latte\Engine;
use Latte\Loaders\FileLoader;
use Yii;
use yii\base\Component;

class DataEngine extends Component
{
    /**
     * @var string adresar, v ktorom sa nachadza cache
     */
    private $dataDirectory = '';

    /**
     * @var Engine
     */
    public $latteRenderer;

    public function init()
    {
        $this->dataDirectory = Yii::getAlias('@frontend') . '/web/data/';

        if (!file_exists($this->dataDirectory)) {
            mkdir($this->dataDirectory, 0777, true);
        }

        $this->latteRenderer = new Engine();

        $this->latteRenderer->setLoader(new FileLoader());

        $this->latteRenderer->setTempDirectory(__DIR__ . '/tmp');
    }

    /** Vrati cestu k triede ObjectBridge.php
     * @return string
     */
    public function getObjectBridgeClassPath()
    {
        return __DIR__ . '/ObjectBridge.php';
    }

    /** Vrati cestu k triede ExceptionHandler.php
     * @return string
     */
    public function getExceptionHandlerClassPath()
    {
        return __DIR__ . '/ExceptionHandler.php';
    }

    public function getDataDirectory()
    {
        return $this->dataDirectory;
    }

    public function getCommonDirectory()
    {
        return $this->dataDirectory . 'common/';
    }

    public function getCommonCacheFile($reload = false)
    {
        $path = $this->getCommonDirectory() . 'common.php';

        if (!file_exists($path) || $reload) {
            $buffer = '<?php' . PHP_EOL;

            $buffer .= 'require_once(\'' . $this->getObjectBridgeClassPath() . '\');' . PHP_EOL;
            $buffer .= 'require_once(\'' . $this->getExceptionHandlerClassPath() . '\');' . PHP_EOL;

            $buffer .= '$bootstrap_css = \'http://www.hyperfinance.cz/css/bootstrap.min.css\';' . PHP_EOL;
            $buffer .= '$bootstrap_js = \'http://www.hyperfinance.cz/js/bootstrap.min.js\';' . PHP_EOL;
            $buffer .= '$jquery = \'//code.jquery.com/jquery-1.10.2.min.js\';' . PHP_EOL;
            $buffer .= '$font_awesome = \'http://www.hyperfinance.cz/fonts/font-awesome-4.3.0/css/font-awesome.min.css\';' . PHP_EOL;

            $this->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }


    //region ========================  GET SEKCIA  =================================*/

    /** vrati cestu k hlavnemu adresaru, kde su ulozene informacie k snippetom
     * @return string
     */
    public function getSnippetsDirectory()
    {
        $path = $this->getCommonDirectory() . 'snippets/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    public function getTemplatesDirectory()
    {
        $path = $this->getCommonDirectory() . 'templates/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    public function getGlobalCssFile()
    {
        return $this->getTemplatesDirectory() . 'global.min.css';
    }

    public function getProductsDirectory()
    {
        $path = $this->getCommonDirectory() . 'products/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    public function getMultimediaDirectory()
    {
        $path = $this->getCommonDirectory() . 'multimedia/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    public function getMultimediaDirectoryForWeb()
    {
        return 'http://hypercms/data/common/multimedia/';
    }

    //endregion

    /** Funkcia na zapis do suboru
     * @param $path - cesta k suboru
     * @param $mode - mod zapisu (napr. w, w+)
     * @param $string - retazec, ktory sa ma zapisat
     */
    public function writeToFile($path, $mode, $string)
    {
        $file = fopen($path, $mode);
        fwrite($file, $string);
        fclose($file);
    }

    public function normalizeString($string)
    {
        if (isset($string)) {
            $re = '/{\$[\w->]+}/';

            preg_match_all($re, $string, $matches);

            foreach ($matches[0] as $match) {
                $newString = str_replace("{", "' . ", $match);
                $newString = str_replace("}", " . '", $newString);

                $string = str_replace($match, $newString, $string);
            }
        }
        return $string;
    }
}