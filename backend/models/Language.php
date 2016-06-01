<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $name
 * @property string $currency
 * @property string $identifier
 * @property integer $active
 *
 * @property Portal[] $portals
 * @property Product[] $products
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

        public function init()
    {
        $this->active = 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'currency', 'identifier', 'active'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 5],
            [['identifier'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Názov',
            'currency' => 'Mena',
            'identifier' => 'Identifikátor',
            'active' => 'Aktívny',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortals()
    {
        return $this->hasMany(Portal::className(), ['language_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['language_id' => 'id'])
            ->orderBy('parent_id');
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre dany jazyk
     * @return string
     */
    public function getCacheDirectory()
    {
        $path = Yii::$app->cacheEngine->cacheDirectory . $this->identifier . '/';

        /*if (!file_exists($path))
        {
            mkdir($path, 0777, true);
            mkdir($path . 'portals', 0777, true); //vytvori priecinok pre portaly
        }*/

        return $path;
    }

    /** Vrati cestu k suboru, v ktorom su nacachovane data zo slovnika
     * @return string
     */
    public function getDictionaryCacheFile()
    {
        $path = $this->getCacheDirectory() . 'dictionary.php';

        if (!file_exists($path))
        {
            $buffer = '<?php ' . PHP_EOL . '$slovnik = ';

            $query = 'SELECT identifier, translation FROM word
          JOIN word_translation ON (word.id = word_id)
          WHERE language_id = :language_id';

            $words = (object)ArrayHelper::map(Yii::$app->db->createCommand($query,
                [':language_id' => $this['id']])
                ->queryAll(), 'identifier', 'translation');

            $buffer .= var_export($words, true) . '; ?>';

            $buffer = str_replace("stdClass::__set_state", "(object)", $buffer);

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre produkty daneho jazyka
     * @return string
     */
    public function getProductsCacheDirectory()
    {
        $path = $this->getCacheDirectory() . 'products/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true); //vytvori priecinok pre produkty
        }

        return $path;
    }

    /** Vrati cestu k hlavnemu suboru, v ktorom su includnute vsetky nacachovane subory pre produkty daneho jazyka
     * @return string
     */
    public function getProductsMainCacheFile()
    {
        $path = $this->getCacheDirectory() . 'products.php';

        if (!file_exists($path))
        {
            $buffer = '<?php ' . PHP_EOL;

            $buffer .= 'require_once(\''. Yii::$app->cacheEngine->getObjectBridgeClassPath() . '\');' . PHP_EOL;
            $buffer .= 'require_once(\''. Yii::$app->cacheEngine->getExceptionHandlerClassPath() . '\');' . PHP_EOL;
            //$buffer .= 'set_exception_handler(array(\'ExceptionHandler\', \'handleException\'));' . PHP_EOL;

            foreach ($this->products as $product)
            {
                $productPath = $product->getMainFile();

                $buffer .= 'include "' . $productPath . '";' . PHP_EOL;
            }

            $buffer .= ' ?>';

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }
}
