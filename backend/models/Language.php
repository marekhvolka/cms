<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property integer $active
 *
 * @property Portal[] $portals
 * @property Product[] $products
 */
class Language extends CustomModel
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
            [['name', 'identifier', 'active'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 50],
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

    /** Vrati cestu k suboru, v ktorom su nacachovane data zo slovnika
     * @return string
     */
    public function getDictionaryCacheFile()
    {
        $path = Yii::$app->dataEngine->getCommonDirectory() . $this->identifier . '_dictionary.php';

        if (!file_exists($path)) {
            $buffer = '<?php ' . PHP_EOL;

            $buffer .= 'include("' . Yii::$app->dataEngine->getCommonCacheFile() . '");' . PHP_EOL;

            $buffer .= '$tempObject = ';

            $query = 'SELECT identifier, translation FROM word
                  JOIN word_translation ON (word.id = word_id)
                  WHERE language_id = :language_id';

            $words = (object)ArrayHelper::map(Yii::$app->db->createCommand($query,
                [':language_id' => $this['id']])
                ->queryAll(), 'identifier', 'translation');

            $buffer .= var_export($words, true) . ';';

            $buffer = str_replace("stdClass::__set_state", "(object)", $buffer);

            $buffer .= '$slovnik = new ObjectBridge($tempObject, \'slovnik\'); ' . PHP_EOL;

            $buffer .= '$tags = (object) array(' . PHP_EOL;

            foreach (Tag::find()->all() as $tag) {
                $buffer .= '\'' . $tag->identifier . '\' => ' . $tag->value . ',' . PHP_EOL;
            }

            $buffer .= ');' . PHP_EOL;

            Yii::$app->dataEngine->writeToFile($path, 'w+', $buffer);
        }
        return $path;
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre produkty daneho jazyka
     * @return string
     */
    public function getProductsDirectory()
    {
        $path = Yii::$app->dataEngine->getProductsDirectory() . $this->identifier . '/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true); //vytvori priecinok pre produkty
        }

        return $path;
    }

    /** Vrati cestu k hlavnemu suboru, v ktorom su includnute vsetky nacachovane subory pre produkty daneho jazyka
     * @return string
     */
    public function getProductsMainCacheFile()
    {
        $path = $this->getProductsDirectory() . 'products.php';

        if (!file_exists($path)) {
            $buffer = '<?php ' . PHP_EOL;

            foreach ($this->products as $product) {
                $productPath = $product->getMainCacheFile();

                $buffer .= 'include("' . $productPath . '");' . PHP_EOL;
            }

            $buffer .= ' ?>';

            Yii::$app->dataEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    public function getIncludePrefix()
    {
        $prefix = '<?php' . PHP_EOL;

        $prefix .= 'include("' . $this->getDictionaryCacheFile() . '");' . PHP_EOL;
        $prefix .= 'include("' . $this->getProductsMainCacheFile() . '");' . PHP_EOL;

        $prefix .= '?>' . PHP_EOL;

        return $prefix;
    }
}
