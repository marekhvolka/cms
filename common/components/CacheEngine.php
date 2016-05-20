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

    /**
     * @var Engine
     */
    public $latteRenderer;

    public function init()
    {
        $this->cacheDirectory = Yii::getAlias('@frontend') . '/web/cache/';

        
        $this->latteRenderer = new Engine();

        $this->latteRenderer->setLoader(new FileLoader());

        $this->latteRenderer->setTempDirectory(__DIR__.'/tmp');
    }


    //region ========================  GET SEKCIA  =================================*/

    /** vrati cestu k hlavnemu adresaru, kde su ulozene informacie k snippetom
     * @return string
     */
    public function getSnippetsMainDirectory()
    {
        $path = $this->cacheDirectory . 'snippets/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
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

        $string = addslashes($string);

        foreach ($matches[0] as $match )
        {
            $newString = str_replace("{", "' . ", $match);
            $newString = str_replace("}", " . '", $newString);

            //echo $newString;

            $string = str_replace($match, $newString, $string);
        }

        return $string;
    }
}