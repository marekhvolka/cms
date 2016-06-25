<?php

namespace backend\models;

use backend\models\ICacheable;
use Yii;
use common\models\User;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property integer $portal_id
 * @property integer $active
 * @property integer $in_menu
 * @property integer $parent_id
 * @property integer $order
 * @property integer $product_id
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $color_scheme
 * @property integer $sidebar_active
 * @property string $sidebar_side
 * @property integer $sidebar_size
 * @property integer $footer_active
 * @property integer $header_active
 * @property string $last_edit
 * @property integer $last_edit_user
 * @property integer $parsed
 * @property string $breadcrumbs
 *
 * @property Portal $portal
 * @property User $lastEditUser
 * @property Page $parent
 * @property Page[] $pages
 * @property Section[] $sections
 * @property Product $product
 * @property SnippetVarValue[] $snippetVarValues
 *
 * @property Section[] $headerSections
 * @property Section[] $footerSections
 * @property Section $contentSections
 * @property Section $sidebarSections
 */
class Page extends CustomModel implements ICacheable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
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
            [['name', 'identifier', 'portal_id', 'active', 'in_menu', 'color_scheme', 'sidebar_active', 'sidebar_side', 'footer_active', 'header_active'], 'required'],
            [['portal_id', 'active', 'in_menu', 'parent_id', 'order', 'product_id', 'sidebar_active', 'sidebar_size', 'footer_active', 'header_active', 'last_edit_user'], 'integer'],
            [['description'], 'string'],
            [['last_edit'], 'safe'],
            [['name', 'identifier', 'color_scheme'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 150],
            [['identifier', 'portal_id', 'parent_id'], 'unique', 'targetAttribute' => ['identifier', 'portal_id', 'parent_id'], 'message' => 'The combination of Identifier, Portal ID and Parent ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'identifier' => 'Identifikátor',
            'url' => 'Url',
            'portal_id' => 'Portál',
            'active' => 'Aktívna',
            'in_menu' => 'V Menu',
            'parent_id' => 'Predok',
            'order' => 'Poradie',
            'product_id' => 'Produkt',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'color_scheme' => 'Farebná schéma',
            'sidebar_active' => 'Sidebar',
            'sidebar_side' => 'Sidebar Side',
            'sidebar_size' => 'Sidebar Size',
            'footer_active' => 'Footer',
            'header_active' => 'Header',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User'
        ];
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        $this->getVarCacheFile(true);

        $this->addToCacheBuffer();

        //TODO: id bloku aj pri premennych zo zoznamov
        /*if (isset($changedAttributes['identifier']) || isset($changedAttributes['active'])) {

            foreach($this->snippetVarValues as $snippetVarValue) {
                $snippetVarValue->block->resetAfterUpdate();
            }
        }*/
    }

    /** Metoda na vyskladanie URL pre podstranku
     * @return string
     */
    public function getUrl()
    {
        if (isset($this->parent))
            $url = $this->parent->url;
        else
            $url = '/';

        return  $url . $this->identifier . '/';
    }

    /** Metoda na vyskladanie URL pre podstranku
     * @return string
     */
    public function getBreadcrumbs()
    {
        $url = '';

        if (isset($this->parent))
            $url = $this->parent->name;

        return  $url . ' -> ' . $this->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortal()
    {
        return $this->hasOne(Portal::className(), ['id' => 'portal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Page::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        $product = $this->hasOne(Product::className(), ['id' => 'product_id']);

        if (!$product->exists() && (isset($this->parent)))
            return $this->parent->product;
        return $product;
    }

    public function getSnippetVarValues()
    {
        return $this->hasMany(SnippetVarValue::className(), ['value_page_id' => 'id']);
    }

    /**
     * @return Section[]
     */
    public function getHeaderSections()
    {
        if (!isset($this->headerSections)) {
            $this->headerSections = $this->hasMany(Section::className(), ['page_id' => 'id'])
                ->where(['type' => 'header'])
                ->all();
        }
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
        if (!isset($this->footerSections)) {
            $this->footerSections = $this->hasMany(Section::className(), ['page_id' => 'id'])
                ->where(['type' => 'footer'])
                ->all();
        }
        return $this->footerSections;
    }

    public function setFooterSections($value)
    {
        $this->footerSections = $value;
    }

    /**
     * @return Section[]
     */
    public function getContentSections()
    {
        if (!isset($this->contentSections)) {
            $this->contentSections = $this->hasMany(Section::className(), ['page_id' => 'id'])
                ->where(['type' => 'content'])
                ->all();
        }
        return $this->contentSections;
    }

    public function setContentSections($value)
    {
        $this->contentSections = $value;
    }

    /**
     * @return Section[]
     */
    public function getSidebarSections()
    {
        if (!isset($this->sidebarSections)) {
            $this->sidebarSections = $this->hasMany(Section::className(), ['page_id' => 'id'])
                ->where(['type' => 'sidebar'])
                ->all();
        }
        return $this->sidebarSections;
    }

    public function setSidebarSections($value)
    {
        $this->sidebarSections = $value;
    }

    /** Vrati cestu k farebnej scheme portalu
     * @return string
     */
    public function getColorSchemePath()
    {
        if ($this->color_scheme == 'inherit')
            if (isset($this->parent))
                return $this->parent->getColorSchemePath();
            else
                return $this->portal->getColorSchemePath();
        else if ($this->color_scheme == '')
            return $this->portal->getColorSchemePath();
        else
            return $this->portal->getTemplatePath() . '/css/public/' . $this->color_scheme . '.css';
    }

    public function getHeaderContent($reload = false)
    {
        $result = '<div id="page-header">';

        if ($this->header_active)
            foreach($this->headerSections as $section)
                $result .= $section->getContent($reload);

        $result .= '</div> <!-- PageHeader end -->';

        return $result;
    }

    public function getFooterContent($reload = false)
    {
        $result = '<div id="page-footer">';

        if ($this->footer_active)
            foreach($this->footerSections as $section)
                $result .= $section->getContent($reload);

        $result .= '</div> <!-- PageFooter end -->';

        return $result;
    }

    public function getMainContent($reload = false)
    {
        if (!$this->sidebar_active)
            $width = 12;
        else
            $width = 12 - $this->sidebar_size;

        $result = '<div id="content" class="col-md-' . $width . '">';

        if (isset($this->contentSections))
        {
            foreach($this->contentSections as $section)
                foreach ($section->rows as $row)
                    $result .= $row->getContent($reload);
        }

        $result .= '</div> <!-- Content End -->';

        return $result;
    }

    public function getSidebarContent($reload = false)
    {
        $result = '';

        if ($this->sidebar_active) {
            $result = '<div id="sidebar" class="col-md-' . $this->sidebar_size . '">';

            foreach($this->sidebarSections as $section)
                foreach ($section->rows as $row)
                    $result .= $row->getContent($reload);

            $result .= '</div> <!-- Sidebar End -->';
        }

        return $result;
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre danu podstranku
     * @return string
     */
    public function getCacheDirectory()
    {
        $path = $this->portal->getPagesMainCacheDirectory() . 'page' . $this->id . '/';

        if (!file_exists($path))
            mkdir($path, 0777, true);

        return $path;
    }

    /** Vrati cestu k suboru, v ktorom su ulozene premenne podstranky
     * @param bool $reload
     * @return string
     */
    public function getVarCacheFile($reload = false)
    {
        $path = $this->getCacheDirectory() . 'page_var.php';

        if (!file_exists($path) || $reload) {
            $cacheEngine = Yii::$app->cacheEngine;

            $buffer = '<?php ' . PHP_EOL;

            if (isset($this->product))
                $buffer .= '$product = $' . $this->product->identifier . ';' . PHP_EOL;
            else if (isset($this->parent))
                $buffer .= '$product = $portal->pages->page' . $this->parent->id . '->product' . ';' . PHP_EOL;
            else {
                $buffer .= '$emptyProduct = (object) array();' . PHP_EOL;
                $buffer .= '$product = new ObjectBridge($emptyProduct, \'\');' . PHP_EOL;
            }
            $buffer .= '$tempObject = (object) array(' . PHP_EOL;

            $buffer .= '\'url\' => \'' . $cacheEngine->normalizeString($this->url) . '\',' . PHP_EOL;
            $buffer .= '\'name\' => \'' . $cacheEngine->normalizeString($this->name) . '\',' . PHP_EOL;
            $buffer .= '\'title\' => \'' . $cacheEngine->normalizeString($this->title) . '\',' . PHP_EOL;
            $buffer .= '\'description\' => \'' . $cacheEngine->normalizeString($this->description) . '\',' . PHP_EOL;
            $buffer .= '\'keywords\' => \'' . $cacheEngine->normalizeString($this->keywords) . '\',' . PHP_EOL;
            $buffer .= '\'active\' => ' . $this->active . ',' . PHP_EOL;

            if (isset($this->parent))
                $buffer .= '\'parent\' => $portal->pages->page' . $this->parent->id . ',' . PHP_EOL;

            if (isset($this->product))
                $buffer .= '\'product\' => $product,' . PHP_EOL;

            $buffer .= ');' . PHP_EOL;

            $buffer .= '$page = new ObjectBridge($tempObject, \'page' . $this->id . '\');' . PHP_EOL;

            if (isset($this->color_scheme))
                $buffer .= '$color_scheme = \'' . $this->getColorSchemePath() . '\';' . PHP_EOL;

            $buffer .= '/* Product Variables */' . PHP_EOL;

            $buffer .= '?>';

            $cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    /** Vrati cestu k suboru, v ktorom je ulozeny layout casti podstranky
     * @param string $type - cast - header, footer, sidebar, content
     * @param bool $reload
     * @return string
     */
    public function getLayoutCacheFile($type, $reload = false)
    {
        $path = $this->getCacheDirectory() . 'page_' . $type . '.php';

        if (!file_exists($path) || $reload) {
            $buffer = '';

            switch($type) {
                case 'header':
                    $buffer = $this->getHeaderContent($reload);

                    break;
                case 'footer':
                    $buffer = $this->getFooterContent($reload);

                    break;
                case 'sidebar':
                    $buffer = $this->getSidebarContent($reload);

                    break;
                case 'content':
                    $buffer = $this->getMainContent($reload);

                    break;
            }

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    /** Vrati cestu k adresaru, v ktorom budu sablony jednotlivych blokov podstranky
     * @return string
     */
    public function getPageBlocksMainCacheDirectory()
    {
        $path = $this->getCacheDirectory() . 'blocks/';

        if (!file_exists($path))
            mkdir($path, 0777, true);

        return $path;
    }

    /** Vrati cestu k suboru, kde je ulozeny finalny obsah stranky pred kompilaciou
     * @param bool $reload
     * @return string
     */
    public function getMainPreCacheFile($reload = false)
    {
        $path = $this->getCacheDirectory() . 'page_prepared.latte';

        if (!file_exists($path) || $reload) {
            $prefix = $this->getIncludePrefix();

            $prefix .= '<?php' . PHP_EOL;

            $prefix .= '$global_header = executeScript(\'' . $this->portal->getLayoutCacheFile('header') . '\');' . PHP_EOL;
            $prefix .= '$global_footer = executeScript(\'' . $this->portal->getLayoutCacheFile('footer') . '\');' . PHP_EOL;

            $prefix .= '$page_header = executeScript(\'' . $this->getLayoutCacheFile('header') . '\');' . PHP_EOL;
            $prefix .= '$page_footer = executeScript(\'' . $this->getLayoutCacheFile('footer') . '\');' . PHP_EOL;

            $prefix .= '$page_sidebar = executeScript(\'' . $this->getLayoutCacheFile('sidebar') . '\');' . PHP_EOL;
            $prefix .= '$page_content = executeScript(\'' . $this->getLayoutCacheFile('content') . '\');' . PHP_EOL;

            if ($this->sidebar_side == 'left')
                $prefix .= '$page_master = $page_sidebar . $page_content;' . PHP_EOL;
            else
                $prefix .= '$page_master = $page_content . $page_sidebar;' . PHP_EOL;

            $prefix .= '?>' . PHP_EOL;

            $templateIndex = file_get_contents(Yii::$app->params['templatesDirectory']
                . $this->portal->template->identifier . '/index.php');

            $pageContent = $prefix . $templateIndex;

            $pageContent = html_entity_decode($pageContent);

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $pageContent);
        }

        return $path;
    }

    /** Vrati cestu k suboru, kde je ulozeny finalny obsah stranky po kompilacii
     * @param bool $reload
     * @return string
     */
    public function getMainCacheFile($reload = false)
    {
        $path = $this->getCacheDirectory() . 'page_compiled.html';

        if (!file_exists($path) || $reload) {
            $result = Yii::$app->cacheEngine->latteRenderer->renderToString($this->getMainPreCacheFile(), array());

            $result = html_entity_decode($result, ENT_QUOTES);

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $result);
        }

        return $path;
    }

    /** Vrati hlavicku s includami pre danu podstranku
     * @return string
     */
    public function getIncludePrefix($reload = false)
    {
        $prefix = $this->portal->getIncludePrefix();

        $prefix .= '<?php ' . PHP_EOL;

        $prefix .= 'include "' . $this->getVarCacheFile($reload) . '";' . PHP_EOL;

        $prefix .= '?>' . PHP_EOL;

        return $prefix;
    }

    /**
     * Vrati objekt podstranky spolu so zoznamom zakladnych premennych
     */
    public function getHead()
    {
        $buffer = '$tempPage' . $this->id . ' = (object) array(' . PHP_EOL;

        $buffer .= '\'url\' => \'' . $this->getUrl() . '\', ' . PHP_EOL;
        $buffer .= '\'name\' => \'' . addslashes($this->name) . '\', ' . PHP_EOL;
        $buffer .= '\'active\' => ' . $this->active . ', ' . PHP_EOL;

        $buffer .= ');' . PHP_EOL;

        return $buffer;
    }

    public function resetAfterUpdate()
    {
        //determine which data was updated

        $a = $this->dirtyAttributes;
    }

    /** Metoda na pridanie stranky do buffra na reset cache
     * @param int $priority - priorita resetnutia, defaultne rovna 0 (radi sa podla casu poziadavky)
     * @throws \yii\db\Exception
     */
    public function addToCacheBuffer($priority = 0)
    {
        $sql = 'INSERT INTO cache_page (page_id, priority) VALUES (:page_id, :priority)
                  ON DUPLICATE KEY UPDATE added_at = CURRENT_TIMESTAMP ';

        $command = Yii::$app->db->createCommand($sql);
        $command->bindValue(':page_id', $this->id);
        $command->bindValue(':priority', $priority);

        $command->execute();
    }
}
