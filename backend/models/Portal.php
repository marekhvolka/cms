<?php

namespace backend\models;

use Yii;
use yii\base\Exception;
use yii\db\Query;
use yii\helpers\ArrayHelper;

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
 * @property bool $outdated
 * @property int $blog_main_page_id
 *
 * @property string $templatePath
 * @property Page[] $pages
 * @property Post[] $posts
 * @property Language $language
 * @property Template $template
 * @property Block[] $portalSnippets
 * @property Area $header
 * @property Area $footer
 * @property PortalVarValue[] $portalVarValues
 * @property Redirect[] $redirects
 * @property Snippet[] $snippets
 * @property Page $blogMainPage
 *
 * @property string $blogUrl
 */
class Portal extends CustomModel implements ICacheable
{
    #region BASIC MODEL

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
            [
                ['name', 'language_id', 'domain', 'template_id', 'active'],
                'required'
            ],
            [['language_id', 'template_id', 'active', 'blog_main_page_id'], 'integer'],
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
            'active' => 'Aktívny',
            'blog_main_page_id' => 'Hlavná podstránka blogu (url)'
        ];
    }

    #endregion

    #region GETTERS & SETTERS

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        if (!isset($this->pages)) {
            $this->pages = $this->hasMany(Page::className(), ['portal_id' => 'id'])->all();

            ArrayHelper::multisort($this->pages, ['url'], [SORT_ASC]);
        }

        return $this->pages;
    }

    public function setPages($value) { $this->pages = $value; }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['portal_id' => 'id'])->orderBy('identifier');
    }

    public function getSnippets()
    {
        return $this->hasMany(Snippet::className(), ['id' => 'snippet_id'])
            ->viaTable('snippet_portal', ['portal_id' => 'id']);
    }

    /** Vrati zoznam hodnot premennych - portalovych snippetov
     * @return PortalVarValue[]
     */
    public function getPortalSnippets()
    {
        if (!isset($this->portalSnippets)) {
            $this->portalSnippets = array();

            foreach ($this->portalVarValues as $index => $portalVarValue) {
                if ($portalVarValue->var->isSnippet()) {
                    $this->portalSnippets[$index] = $portalVarValue->valueBlock;
                }
            }
        }

        return $this->portalSnippets;
    }

    public function setPortalSnippets($value) { $this->portalSnippets = $value; }

    /** Vrati zoznam hodnot premennych - portalovych vlastnosti
     * @return \yii\db\ActiveQuery
     */
    public function getPortalProperties()
    {
        $array = array();

        foreach ($this->portalVarValues as $index => $portalVarValue) {
            if (!$portalVarValue->var->isSnippet()) {
                $array[$index] = $portalVarValue;
            }
        }

        return $array;
    }

    /**
     * @return Section[]
     */
    public function getHeader()
    {
        if (!isset($this->header)) {
            $this->header = $this->hasOne(Area::className(), [
                'portal_id' => 'id'
            ])
                ->where(['type' => 'header'])
                ->one();
        }

        return $this->header;
    }

    public function setHeader($value) { $this->header = $value; }

    /**
     * @return Section[]
     */
    public function getFooter()
    {
        if (!isset($this->footer)) {
            $this->footer = $this->hasOne(Area::className(), [
                'portal_id' => 'id'
            ])
                ->where(['type' => 'footer'])
                ->one();
        }

        return $this->footer;
    }

    public function setFooter($value) { $this->footer = $value; }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalVarValues()
    {
        if (!isset($this->portalVarValues)) {
            $this->portalVarValues = $this->hasMany(PortalVarValue::className(), ['portal_id' => 'id'])
                ->all();
        }

        return $this->portalVarValues;
    }

    public function setPortalVarValues($value) { $this->portalVarValues = $value; }

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

        foreach ($codes as $code) {
            $result .= '<!-- ' . $code->name . '-->' . PHP_EOL;
            $result .= $code->code . PHP_EOL;
            $result .= '<!-- ' . $code->name . 'END -->' . PHP_EOL;
        }

        return addslashes($result);
    }

    /** Vrati cestu k farebnej scheme portalu
     * @param bool $forWeb
     * @return string
     */
    public function getColorSchemePath($forWeb = false)
    {
        return $this->template->getCssSchemeDirectoryPath($forWeb) . $this->color_scheme . '.min.css';
    }

    #region AUTOGENERATED

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
    public function getRedirects()
    {
        return $this->hasMany(Redirect::class, ['portal_id' => 'id']);
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
    public function getBlogMainPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'blog_main_page_id']);
    }

    /** Vrati cestu k url blogu
     * @return string
     */
    public function getBlogUrl()
    {
        return '/' . $this->blogMainPage->identifier . '/';
    }

    #endregion

    #endregion

    #region Caching

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre dany portal
     * @param bool $forWeb
     * @return string
     */
    public function getMainDirectory($forWeb = false)
    {
        $path = Yii::$app->dataEngine->getDataDirectory($forWeb) . $this->domain . '/';

        if (!file_exists($path) && !$forWeb) {
            mkdir($path, 0777, true);
            mkdir($this->getMultimediaDirectory(), 0777, true);
            mkdir($this->getThanksDirectory(), 0777, true);
            mkdir($this->getPortalSnippetsDirectory(), 0777, true);
            mkdir($this->getPagesDirectory(), 0777, true);
            mkdir($this->getPostsDirectory(), 0777, true);
        }
        return $path;
    }

    /** Vrati cestu k suboru, v ktorom nacachovane data k portalu
     * @param bool $reload
     * @return string
     * @throws
     */
    public function getPortalVarsFile($reload = false)
    {
        $path = $this->getMainDirectory() . 'portal_var.php';

        if (!file_exists($path) || $this->outdated || $reload) {
            try {
                $dataEngine = Yii::$app->dataEngine;

                $buffer = '<?php ' . PHP_EOL;

                $buffer .= '$portal->id = ' . $this->id . ';' . PHP_EOL;
                $buffer .= '$portal->domain = \'' . $dataEngine->normalizeString($this->domain) . '\';' . PHP_EOL;
                $buffer .= '$portal->url = \'' . $dataEngine->normalizeString('http://www.' . $this->domain) . '\';' . PHP_EOL;
                $buffer .= '$portal->name = \'' . $dataEngine->normalizeString($this->name) . '\';' . PHP_EOL;
                $buffer .= '$portal->lang = \'' . $dataEngine->normalizeString($this->language->identifier) . '\';' . PHP_EOL;
                $buffer .= '$portal->template = \'' . $this->template->getMainDirectory(true) . '\';' . PHP_EOL;
                $buffer .= '$portal->color_scheme = \'' . $this->getColorSchemePath() . '\';' . PHP_EOL;

                $buffer .= '/* Portal vars */' . PHP_EOL;

                foreach ($this->portalVarValues as $portalVarValue) {
                    if (!$portalVarValue->var->isSnippet()) {
                        $buffer .= '$portal->' . $portalVarValue->var->identifier . ' = ' . $portalVarValue->getValue() . ';' . PHP_EOL;
                    }
                }

                $buffer .= '?>';

                $buffer .= $this->getTrackingCodesHead();

                $dataEngine->writeToFile($path, 'w+', $buffer);
                $this->removeException();
            } catch (Exception $exception) {
                $this->logException($exception, 'portal_var');
            }
        }

        return $path;
    }

    public function getPortalPagesFile($reload = false)
    {
        $path = $this->getMainDirectory() . 'portal_pages.php';

        if (!file_exists($path) || $this->outdated || $reload) {
            try {
                $dataEngine = Yii::$app->dataEngine;

                $buffer = '<?php ' . PHP_EOL;

                $buffer .= '/* Portal pages */' . PHP_EOL;

                $buffer .= '$portal->pages = (object) array();' . PHP_EOL;

                foreach ($this->pages as $page) {
                    $buffer .= 'include("' . $page->getVarCacheFile() . '");' . PHP_EOL;
                    $buffer .= '$portal->pages->page' . $page->id . ' = ' . $page->cacheIdentifier . ';' . PHP_EOL;
                }

                $buffer .= '?>';

                $dataEngine->writeToFile($path, 'w+', $buffer);
                $this->removeException();
            } catch (Exception $exception) {
                $this->logException($exception, 'portal_pages');
            }
        }

        return $path;
    }

    public function getPortalPostsFile($reload = false)
    {
        $path = $this->getMainDirectory() . 'portal_posts.php';

        if (!file_exists($path) || $this->outdated || $reload) {
            try {
                $dataEngine = Yii::$app->dataEngine;

                $buffer = '<?php ' . PHP_EOL;

                $buffer .= '/* Portal posts */' . PHP_EOL;

                $buffer .= '$portal->posts = (object) array();' . PHP_EOL;

                if ($this->blogMainPage) {
                    foreach ($this->posts as $post) {
                        $buffer .= 'include("' . $post->getVarCacheFile() . '");' . PHP_EOL;
                        $buffer .= '$portal->posts->post' . $post->id . ' = ' . $post->cacheIdentifier . ';' . PHP_EOL;
                    }
                }

                $buffer .= '?>';

                $dataEngine->writeToFile($path, 'w+', $buffer);
                $this->removeException();
            } catch (Exception $exception) {
                $this->logException($exception, 'portal_posts');
            }
        }

        return $path;
    }

    public function getTrackingCodesHead()
    {
        $buffer = '<?php' . PHP_EOL;

        $buffer .= '$include_head = stripcslashes("' . $this->getTrackingCodesAsString('head') . '");' . PHP_EOL;
        $buffer .= '$include_head_end = stripcslashes("' . $this->getTrackingCodesAsString('head_end') . '");' . PHP_EOL;
        $buffer .= '$include_body = stripcslashes("' . $this->getTrackingCodesAsString('body') . '");' . PHP_EOL;
        $buffer .= '$include_body_end = stripcslashes("' . $this->getTrackingCodesAsString('body_end') . '");' . PHP_EOL;

        $buffer .= '?>' . PHP_EOL;

        return $buffer;
    }

    public function getMainCacheFile($reload = false)
    {
        $path = $this->getMainDirectory() . 'main_file.php';

        if (!file_exists($path) || $this->outdated || $reload) {
            try {
                $buffer = '<?php' . PHP_EOL;

                $buffer .= '$tempObject = (object) array();' . PHP_EOL;

                $buffer .= '$portal = new ObjectBridge($tempObject, \'' . $this->domain . '\');' . PHP_EOL;

                $buffer .= 'include("' . $this->getPortalPagesFile() . '");' . PHP_EOL;
                $buffer .= 'include("' . $this->getPortalPostsFile() .'");' . PHP_EOL;
                $buffer .= 'include("' . $this->getPortalVarsFile($reload) . '");' . PHP_EOL;

                $buffer .= '?>';

                Yii::$app->dataEngine->writeToFile($path, 'w+', $buffer);
                $this->setActual();
            } catch (Exception $exception) {
                $this->logException($exception, 'portal_main_file');
            }
        }

        return $path;
    }

    /** Vrati cestu k hlavnemu adresaru, v ktorom su ulozene nacachovane podstranky pre dany portal
     * @return string
     */
    public function getPagesDirectory() { return $this->getMainDirectory() . 'pages/'; }

    /** Vrati cestu k hlavnemu adresaru, v ktorom su ulozene nacachovane clanky pre dany portal
     * @return string
     */
    public function getPostsDirectory() { return $this->getMainDirectory() . 'posts/'; }

    public function getThanksDirectory($forWeb = false) { return $this->getMainDirectory($forWeb) . 'thanks/'; }

    public function getMultimediaDirectory($forWeb = false) { return $this->getMainDirectory($forWeb) . 'multimedia/'; }

    /** Metoda, vracajuca cestu k adresaru, v ktorom su ulozene portalove snippety
     * @return string
     */
    public function getPortalSnippetsDirectory()
    {
        $path = $this->getMainDirectory() . 'snippets/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    public function getIncludePrefix()
    {
        $prefix = $this->language->getIncludePrefix();

        $prefix .= '<?php' . PHP_EOL;

        $prefix .= 'include("' . $this->getMainCacheFile() . '");' . PHP_EOL;

        $prefix .= '?>' . PHP_EOL;

        return $prefix;
    }

    public function resetAfterUpdate()
    {
        $this->setOutdated();
        $this->getPortalVarsFile();

        foreach ($this->portalSnippets as $portalSnippet) {
            if ($portalSnippet->isChanged()) {
                $portalSnippet->resetAfterUpdate();
            }
        }
    }

    public function isChanged()
    {
        if (parent::isChanged()) {
            return true;
        }

        foreach ($this->portalVarValues as $portalVarValue) {
            if ($portalVarValue->isChanged()) {
                return true;
            }
        }

        return false;
    }

    public function getOutdatedPageCount()
    {
        $query = 'SELECT SUM(outdated) outdated, COUNT(*) count FROM page WHERE portal_id = :portal_id';

        return Yii::$app->db->createCommand($query, [
            'portal_id' => $this->id
        ])
            ->queryOne();
    }

    #endregion

    public function compileThanksFiles()
    {
        $thanksCommonDirectory = Yii::$app->dataEngine->getThanksDirectory();

        chdir($thanksCommonDirectory);

        $files = glob('*.php');

        foreach ($files as $file) {
            Yii::$app->dataEngine->compileThanksFileForPortal($thanksCommonDirectory . $file, $file, $this);
        }
    }

    public function generateSitemap()
    {
        $path = $this->getMainDirectory() . 'sitemap.xml';

        $buffer = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
            xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;

        foreach ($this->pages as $page) {
            if ($page->in_sitemap) {
                $buffer .= '<url>' . PHP_EOL;
                $buffer .= '<loc>http://www.' . $page->portal->domain . $page->getUrl() . '</loc>' . PHP_EOL;
                $buffer .= '</url>' . PHP_EOL;
            }
        }

        if ($this->blogMainPage) {
            foreach ($this->posts as $post) {
                if ($post->in_sitemap) {
                    $buffer .= '<url>' . PHP_EOL;
                    $buffer .= '<loc>http://www.' . $post->portal->domain . $post->getUrl() . '</loc>' . PHP_EOL;
                    $buffer .= '</url>' . PHP_EOL;
                }
            }
        }

        $buffer .= '</urlset>';
        
        Yii::$app->dataEngine->writeToFile($path, 'w+', $buffer);
    }
}
