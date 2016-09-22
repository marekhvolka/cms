<?php

namespace common\components;


use backend\components\PathHelper;
use backend\models\Portal;
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

    public function getDataDirectory($forWeb = false)
    {
        $this->dataDirectory = 'data';

        if ($forWeb) {
            return '/' . $this->dataDirectory . '/';
        } else {
            return Yii::getAlias('@frontend') . '/web/' . $this->dataDirectory . '/';
        }
    }

    public function getCommonDirectory($forWeb = false)
    {
        return $this->getDataDirectory($forWeb) . 'common/';
    }

    public function getCommonCacheFile($reload = false)
    {
        $path = $this->getCommonDirectory() . 'common.php';

        if (!file_exists($path) || $reload) {
            $buffer = '<?php' . PHP_EOL;

            $buffer .= 'require_once("' . $this->getObjectBridgeClassPath() . '");' . PHP_EOL;
            $buffer .= 'require_once("' . $this->getExceptionHandlerClassPath() . '");' . PHP_EOL;

            $buffer .= '$bootstrap_css = "/css/bootstrap.min.css";' . PHP_EOL;
            $buffer .= '$bootstrap_js = "/js/bootstrap.min.js";' . PHP_EOL;
            $buffer .= '$jquery = "//code.jquery.com/jquery-1.10.2.min.js";' . PHP_EOL;
            $buffer .= '$font_awesome = "/fonts/font-awesome-4.6.3/css/font-awesome.min.css";' . PHP_EOL;

            $buffer .= '?>' . PHP_EOL;

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

    public function getTemplatesDirectory($forWeb = false)
    {
        return $this->getCommonDirectory($forWeb) . 'templates/';
    }

    public function getGlobalCssFile($forWeb = false)
    {
        return $this->getTemplatesDirectory($forWeb) . 'global.min.css';
    }

    public function getProductsDirectory()
    {
        $path = $this->getCommonDirectory() . 'products/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    public function getMultimediaDirectory($forWeb = false)
    {
        return $this->getCommonDirectory($forWeb) . 'multimedia/';
    }

    public function getThanksDirectory()
    {
        return $this->getCommonDirectory(false) . 'thanks';
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
            $string = addslashes($string);

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

    public function compileThanksFile($path, $relative_path)
    {
        foreach (Portal::find()->all() as $portal) {
            $this->compileThanksFileForPortal($path, $relative_path, $portal);
        }
    }

    /** Metoda na skompilovanie jednej dakovacky pre jeden portal
     * @param $path
     * @param $relative_path
     * @param Portal $portal
     * @throws \Exception
     * @throws \Throwable
     */
    public function compileThanksFileForPortal($path, $relative_path, Portal $portal)
    {
        $compiled_path = $portal->getThanksDirectory() . $relative_path;

        PathHelper::makePath($compiled_path, true);

        $content = file_get_contents($this->getCommonCacheFile()) . PHP_EOL;
        $content .= $portal->getTrackingCodesHead() . PHP_EOL;
        $content .= file_get_contents($path) . PHP_EOL;

        $this->writeToFile($compiled_path, 'w+', $content);
    }

    public function printCode($source_code, $highlight_line)
    {
        $lines = explode(PHP_EOL, $source_code);
        $output = '';

        $i = 1;

        foreach ($lines as $line) {
            $class = $i == $highlight_line ? 'highlight' : '';

            $output .= '<div class="syntax-highlight-line ' . $class . '">' . sprintf('%02d.', $i) . ' </div>' . PHP_EOL;
            $output .= '<div class="syntax-highlight-code ' . $class . '">' . highlight_string($line, true) . '</div><br />' . PHP_EOL;
            $i++;
        }

        return $output;
    }
}
