<?php

namespace backend\models;

use backend\models\ICacheable;
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
 * @property PortalVarValue[] $portalSnippets
 * @property Section[] $headerSections
 * @property Section[] $footerSections
 * @property PortalVarValue[] $portalVarValues
 */
class Portal extends CustomModel implements ICacheable
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

    public function afterDelete()
    {
        parent::afterDelete();

        MultimediaCategory::removeSubcategory($this->id);
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

    /** Vrati zoznam hodnot premennych - portalovych snippetov
     * @return PortalVarValue[]
     */
    public function getPortalSnippets()
    {
        $array = array();

        foreach($this->portalVarValues as $portalVarValue)
        {
            if ($portalVarValue->var->isSnippet())
                $array[] = $portalVarValue;
        }

        return $array;
    }

    /** Vrati zoznam hodnot premennych - portalovych vlastnosti
     * @return \yii\db\ActiveQuery
     */
    public function getPortalProperties()
    {
        $array = array();

        foreach($this->portalVarValues as $index => $portalVarValue)
        {
            if (!$portalVarValue->var->isSnippet())
                $array[$index] = $portalVarValue;
        }

        return $array;
    }

    /**
     * @return Section[]
     */
    public function getHeaderSections()
    {
        if (!isset($this->headerSections))
            $this->headerSections = $this->hasMany(Section::className(), [
                'portal_id' => 'id'
            ])
                ->where(['type' => 'header'])
                ->all();

        return $this->headerSections;
    }

    public function setHeaderSections($value)
    {
        $this->headerSections = $value;
    }

    /**
     * @return Section[]
     */
    public function getFooterSections()
    {
        if (!isset($this->footerSections))
            $this->footerSections = $this->hasMany(Section::className(), [
                'portal_id' => 'id'
            ])
                ->where(['type' => 'footer'])
                ->all();

        return $this->footerSections;
    }

    public function setFooterSections($value)
    {
        $this->footerSections = $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalVarValues()
    {
        if (!isset($this->portalVarValues))
            $this->portalVarValues = $this->hasMany(PortalVarValue::className(), ['portal_id' => 'id'])->all();

        return $this->portalVarValues;
    }

    public function setPortalVarValues($value)
    {
        $this->portalVarValues = $value;
    }

    /** Vrati retazec, v ktorom su kody z daneho umiestnenia
     * @param string $placeName - mozne hodnoty head, head_end, body, body_end
     * @return string
     */
    public function getTrackingCodesAsString($placeName)
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
     * @param bool $reload - ak true, tak sa subor nanovo vytvori
     * @return string
     */
    public function getPortalVarsFile($reload = false)
    {
        $path = $this->getCacheDirectory() . 'portal_var.php';

        if (!file_exists($path) || $reload)
        {
            $cacheEngine = Yii::$app->cacheEngine;

            $buffer = '<?php ' . PHP_EOL;

            foreach($this->pages as $page)
            {
                $buffer .= $page->getHead();
            }

            $buffer .= '$tempObject = (object) array(' . PHP_EOL;

            $buffer .= '\'domain\' => \'' . $cacheEngine->normalizeString($this->domain) . '\',' . PHP_EOL;
            $buffer .= '\'url\' => \'' . $cacheEngine->normalizeString('http://www.' . $this->domain) . '\',' . PHP_EOL;
            $buffer .= '\'name\' => \'' . $cacheEngine->normalizeString($this->name) . '\',' . PHP_EOL;
            $buffer .= '\'lang\' => \'' . $cacheEngine->normalizeString($this->language->identifier) . '\',' . PHP_EOL;
            $buffer .= '\'currency\' => \'' . $cacheEngine->normalizeString($this->language->currency) . '\',' . PHP_EOL;
            $buffer .= '\'template\' => \'' . $this->getTemplatePath() . '\',' . PHP_EOL;
            $buffer .= '\'color_scheme\' => \'' . $this->getColorSchemePath() . '\',' . PHP_EOL;

            $buffer .= '/* Portal pages */' . PHP_EOL;

            $buffer .= '\'pages\' => (object) array(' . PHP_EOL;

            foreach($this->pages as $page)
            {
                $buffer .= '\'page' . $page->id . '\' => new ObjectBridge($tempPage' . $page->id . ', \'page' . $page->id . '\'),' . PHP_EOL;
            }

            $buffer .= '),' . PHP_EOL;

            $buffer .= ');' . PHP_EOL;

            $buffer .= '$portal = new ObjectBridge($tempObject, \'' . $this->domain . '\');' . PHP_EOL;

            /*foreach($this->pages as $page)
            {
                $buffer .= '$page' . $page->id . ' = $portal->pages[\'page' . $page->id . '\'];' . PHP_EOL;
            }*/

            $buffer .= '/* Portal vars */' . PHP_EOL;

            foreach ($this->portalVarValues as $portalVarValue)
            {
                if (!$portalVarValue->var->isSnippet())
                    $buffer .= '$portal->' . $portalVarValue->var->identifier . ' = ' . $portalVarValue->getValue() . ';' . PHP_EOL;
            }

            $buffer .= '$include_head = stripcslashes(\'' . $this->getTrackingCodesAsString('head') . '\');' . PHP_EOL;
            $buffer .= '$include_head_end = stripcslashes(\'' . $this->getTrackingCodesAsString('head_end') . '\');' . PHP_EOL;
            $buffer .= '$include_body = stripcslashes(\'' . $this->getTrackingCodesAsString('body') . '\');' . PHP_EOL;
            $buffer .= '$include_body_end = stripcslashes(\'' . $this->getTrackingCodesAsString('body_end') . '\');' . PHP_EOL;

            $buffer .= '?>';

            $cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    public function getMainCacheFile($reload = false)
    {
        $path = $this->getCacheDirectory() . 'main_file.php';

        if (!file_exists($path) || $reload)
        {
            $buffer = '<?php' . PHP_EOL;

            $buffer .= 'include \'' . $this->getPortalVarsFile() . '\';' . PHP_EOL;

            foreach($this->portalSnippets as $portalSnippet)
            {
                $buffer .= '$portal->' . $portalSnippet->var->identifier . ' = file_get_contents(\'' . $portalSnippet->valueBlock->getMainCacheFile() . '\');' . PHP_EOL;
            }

            $buffer .= '?>';

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $buffer);
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

    public function getIncludePrefix()
    {
        $prefix = $this->language->getIncludePrefix();

        $prefix .= '<?php' . PHP_EOL;

        $prefix .= 'include "' . $this->getMainCacheFile() . '";' . PHP_EOL;

        $prefix .= '?>' . PHP_EOL;

        return $prefix;
    }

    public function getPortalLayout()
    {
        $prefix = '<?php' . PHP_EOL;

        $prefix .= '$global_header = file_get_contents(\'' . $this->getLayoutCacheFile('header') . '\');' . PHP_EOL;
        $prefix .= '$global_footer = file_get_contents(\'' . $this->getLayoutCacheFile('footer') . '\');' . PHP_EOL;

        $prefix .= '?>' . PHP_EOL;

        return $prefix;
    }

    public function resetAfterUpdate()
    {
        $this->getPortalVarsFile(true);

        foreach($this->pages as $page)
        {
            $page->addToCacheBuffer();
        }

        foreach($this->portalSnippets as $portalSnippet)
        {
            $portalSnippet->block->resetAfterUpdate();
        }
    }
}
