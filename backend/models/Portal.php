<?php

namespace backend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "portal".
 *
 * @property integer $id
 * @property string $name
 * @property integer $language_id
 * @property string $domain
 * @property integer $template_id
 * @property string $color_scheme
 * @property integer $active
 * @property integer $published
 * @property integer $cached
 *
 *
 * @property string $templatePath
 * @property Page[] $pages
 * @property Language $language
 * @property Template $template
 * @property Block[] $portalSnippets
 * @property Section[] $headerSections
 * @property Section[] $footerSections
 * @property SnippetVarValue[] $portalVarValues
 */
class Portal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'portal';
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
            [['name', 'language_id', 'domain', 'template_id', 'color_scheme', 'active', 'published', 'cached'], 'required'],
            [['language_id', 'template_id', 'active', 'published', 'cached'], 'integer'],
            [['color_scheme'], 'string'],
            [['name', 'domain'], 'string', 'max' => 50]
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
            'language_id' => 'Krajina',
            'domain' => 'Doména',
            'template_id' => 'Šablóna',
            'color_scheme' => 'Farebná schéma',
            'active' => 'Active',
            'published' => 'Publikovaný',
            'cached' => 'Cache',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['portal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalSnippets()
    {
        return $this->hasMany(Block::className(), ['portal_id' => 'id']);
    }

    /**
     * @return Section
     */
    public function getHeaderSections()
    {
        return Section::findAll([
            'portal_id' => $this->id,
            'type' => 'header'
        ]);
    }

    /**
     * @return Section
     */
    public function getFooterSections()
    {
        return Section::findAll([
            'portal_id' => $this->id,
            'type' => 'footer'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalVarValues()
    {
        return $this->hasMany(PortalVarValue::className(), ['portal_id' => 'id']);
    }

    /** Vrati retazec, v ktorom su kody z daneho umiestnenia
     * @param string $placeName - mozne hodnoty head, head_end, body, body_end
     * @return string
     */
    public function getTrackingCodesString($placeName)
    {
        $command = (new Query())
            ->select('id')
            ->from('tracking_code_place')
            ->where('name = :name')
            ->createCommand();

        $command->bindValue(':name', $placeName);

        $placeId = $command->queryOne();

        $codes = TrackingCode::findAll([
            'portal_id' => $this->id,
            'place_id' => $placeId
        ]);

        $result = '';

        foreach($codes as $code)
        {
            $result .= '<!-- ' . $code->name . '-->' . PHP_EOL;
            $result .= $code->code . PHP_EOL;
            $result .= '<!-- ' . $code->name . 'END -->' . PHP_EOL;
        }

        return addslashes($result);
    }

    /** Vrati cestu k sablone
     * @return string
     */
    public function getTemplatePath()
    {
        return 'http://www.hyperfinance.cz/template/' . $this->template->identifier;
    }

    /** Vrati cestu k farebnej scheme portalu
     * @return string
     */
    public function getColorSchemePath()
    {
        return $this->getTemplatePath() . '/css/public/' . $this->color_scheme . '.css';
    }

    /** Vrati cestu k suboru, v ktorom je ulozeny layout casti portalu
     * @param string $type - cast - header, footer
     * @return string
     */
    public function getLayoutCacheFile($type)
    {
        $path = $this->getCacheDirectory() . 'portal_' . $type . '.php';

        if (!file_exists($path))
        {
            Yii::$app->cacheEngine->writeToFile($path, 'w+', $this->getLayoutString($type));
        }

        return $path;
    }

    public function getLayoutString($type)
    {
        $result = '';

        switch($type)
        {
            case 'header' :

                $result .= '<header>';

                foreach($this->getHeaderSections() as $section)
                {
                    $result .= $section->getContent();
                }

                $result .= '</header>';

                break;

            case 'footer' :

                $result .= '<footer>';

                foreach($this->getFooterSections() as $section)
                {
                    $result .= $section->getContent();
                }

                $result .= '</footer>';

                break;
        }

        return $result;
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre dany portal
     * @return string
     */
    public function getCacheDirectory()
    {
        $path = $this->language->getCacheDirectory() . 'portals/' . $this->domain . '/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /** Vrati cestu k suboru, v ktorom nacachovane data k portalu
     * @return string
     */
    public function getCacheFile()
    {
        $path = $this->getCacheDirectory() . 'portal_var.php';

        if (!file_exists($path))
        {
            $cacheEngine = Yii::$app->cacheEngine;

            $buffer = '<?php ' . PHP_EOL;

            $buffer .= '$domain = \'' . $cacheEngine->normalizeString($this->domain) . '\';' . PHP_EOL;
            $buffer .= '$name = \'' . $cacheEngine->normalizeString($this->name) . '\';' . PHP_EOL;
            $buffer .= '$lang = \'' . $cacheEngine->normalizeString($this->language->identifier) . '\';' . PHP_EOL;
            $buffer .= '$currency = \'' . $cacheEngine->normalizeString($this->language->currency) . '\';' . PHP_EOL;
            $buffer .= '$color_scheme = \'' . $this->getColorSchemePath() . '\';' . PHP_EOL;

            $buffer .= '$include_head = \'' . $this->getTrackingCodesString('head') . '\';' . PHP_EOL;
            $buffer .= '$include_head_end = \'' . $this->getTrackingCodesString('head_end') . '\';' . PHP_EOL;
            $buffer .= '$include_body = \'' . $this->getTrackingCodesString('body') . '\';' . PHP_EOL;
            $buffer .= '$include_body_end = \'' . $this->getTrackingCodesString('body_end') . '\';' . PHP_EOL;

            $buffer .= '/* Portal pages */' . PHP_EOL;

            foreach($this->pages as $page)
            {
                $buffer .= $page->getHead();
            }

            $buffer .= '?>';

            $cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    /** Vrati cestu k adresaru, v ktorom budu sablony jednotlivych blokov pre portal
     * @return string
     */
    public function getBlocksMainCacheDirectory()
    {
        $path = $this->getCacheDirectory() . 'blocks/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /** Vrati cestu k hlavnemu adresaru, v ktorom su ulozene nacachovane podstranky pre dany portal
     * @return string
     */
    public function getPagesMainCacheDirectory()
    {
        return $this->getCacheDirectory() . 'pages/';
    }

    /** Metoda, vracajuca cestu k adresaru, v ktorom su ulozene portalove snippety
     * @return string
     */
    public function getPortalSnippetCacheDirectory()
    {
        $path = $this->getCacheDirectory() . 'snippets/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
    }
}
