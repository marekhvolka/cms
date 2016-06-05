<?php

namespace backend\models;

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
 *
 * @property Portal $portal
 * @property User $lastEditUser
 * @property Page $parent
 * @property Page[] $pages
 * @property Section[] $sections
 * @property Product $product
 *
 * @property Section[] $headerSections
 * @property Section[] $footerSections
 * @property Section $contentSection
 * @property Section $sidebarSection
 */
class Page extends \yii\db\ActiveRecord
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

        if (!isset($product) && (isset($this->parent)))
            return $this->parent->product;
        return $product;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderSections()
    {
        return Section::findAll([
            'page_id' => $this->id,
            'type' => 'header'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFooterSections()
    {
        return Section::findAll([
            'page_id' => $this->id,
            'type' => 'footer'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentSection()
    {
        return Section::findOne([
            'page_id' => $this->id,
            'type' => 'content'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSidebarSection()
    {
        return Section::findOne([
            'page_id' => $this->id,
            'type' => 'sidebar'
        ]);
    }

    /** Vrati cestu k farebnej scheme portalu
     * @return string
     */
    public function getColorSchemePath()
    {
        if ($this->color_scheme == 'inherit')
        {
            if (isset($this->parent))
                return $this->parent->getColorSchemePath();
            else
                return $this->portal->getColorSchemePath();
        }
        else if ($this->color_scheme == '')
        {
            return $this->portal->getColorSchemePath();
        }
        else
            return $this->portal->getTemplatePath() . '/css/public/' . $this->color_scheme . '.css';
    }

    public function getHeaderContent()
    {
        $result = '<div id="page-header">';

        if ($this->header_active)
        {
            foreach($this->headerSections as $section)
            {
                $result .= $section->getContent();
            }
        }

        $result .= '</div> <!-- PageHeader end -->';

        return $result;
    }

    public function getFooterContent()
    {
        $result = '<div id="page-footer">';

        if ($this->footer_active)
        {
            foreach($this->footerSections as $section)
            {
                $result .= $section->getContent();
            }
        }

        $result .= '</div> <!-- PageFooter end -->';

        return $result;
    }

    public function getMainContent()
    {
        if (!$this->sidebar_active)
        {
            $width = 12;
        }
        else
        {
            $width = 12 - $this->sidebar_size;
        }

        $result = '<div id="content" class="col-md-' . $width . '">';

        foreach($this->contentSection->rows as $row)
        {
            $result .= $row->getContent();
        }

        $result .= '</div> <!-- Content End -->';

        return $result;
    }

    public function getSidebarContent()
    {
        $result = '';

        if ($this->sidebar_active && isset($this->sidebarSection))
        {
            $result = '<div id="sidebar" class="col-md-' . $this->sidebar_size . '">';

            foreach($this->sidebarSection->rows as $row)
            {
                $result .= $row->getContent();
            }

            $result .= '</div> <!-- Sidebar End -->';
        }

        return $result;
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre danu podstranku
     * @return string
     */
    public function getMainCacheDirectory()
    {
        $path = $this->portal->getPagesMainCacheDirectory() . 'page' . $this->id . '/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /** Vrati cestu k suboru, v ktorom su ulozene premenne podstranky
     * @return string
     */
    public function getVarCacheFile()
    {
        $path = $this->getMainCacheDirectory() . 'page_var.php';

        if (!file_exists($path))
        {
            $cacheEngine = Yii::$app->cacheEngine;

            $buffer = '<?php ' . PHP_EOL;

            $buffer .= '$tempObject = (object) array(' . PHP_EOL;

            $buffer .= '\'url\' => \'' . $cacheEngine->normalizeString($this->url) . '\',' . PHP_EOL;
            $buffer .= '\'name\' => \'' . $cacheEngine->normalizeString($this->name) . '\',' . PHP_EOL;
            $buffer .= '\'title\' => \'' . $cacheEngine->normalizeString($this->title) . '\',' . PHP_EOL;
            $buffer .= '\'description\' => \'' . $cacheEngine->normalizeString($this->description) . '\',' . PHP_EOL;
            $buffer .= '\'keywords\' => \'' . $cacheEngine->normalizeString($this->keywords) . '\',' . PHP_EOL;

            $buffer .= ');' . PHP_EOL;

            $buffer .= '$page = new ObjectBridge($tempObject, \'page' . $this->id . '\');' . PHP_EOL;

            if (isset($this->color_scheme))
            {
                $buffer .= '$color_scheme = \'' . $this->getColorSchemePath() . '\';' . PHP_EOL;
            }

            $buffer .= '/* Product Variables */' . PHP_EOL;

            if (isset($this->product))
                $buffer .= '$product = $' . $this->product->identifier . ';' . PHP_EOL;

            $buffer .= '?>';

            $cacheEngine->writeToFile($path, 'w+', $buffer);
        }

        return $path;
    }

    /** Vrati cestu k suboru, v ktorom je ulozeny layout casti podstranky
     * @param string $type - cast - header, footer, sidebar, content
     * @return string
     */
    public function getLayoutCacheFile($type)
    {
        $path = $this->getMainCacheDirectory() . 'page_' . $type . '.php';

        if (!file_exists($path))
        {
            $buffer = '';

            switch($type)
            {
                case 'header':
                    $buffer = $this->getHeaderContent();

                    break;
                case 'footer':
                    $buffer = $this->getFooterContent();

                    break;
                case 'sidebar':
                    $buffer = $this->getSidebarContent();

                    break;
                case 'content':
                    $buffer = $this->getMainContent();

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
        $path = $this->getMainCacheDirectory() . 'blocks/';

        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /** Vrati cestu k suboru, kde je ulozeny finalny obsah stranky pred kompilaciou
     * @return string
     */
    public function getMainPreCacheFile()
    {
        $path = $this->getMainCacheDirectory() . 'page_prepared.latte';

        if (!file_exists($path))
        {
            $prefix = $this->getIncludePrefix();

            $prefix .= '<?' . PHP_EOL;

            $prefix .= '$global_header = addslashes(file_get_contents(\'' . $this->portal->getLayoutCacheFile('header') . '\'));' . PHP_EOL;
            $prefix .= '$global_footer = addslashes(file_get_contents(\'' . $this->portal->getLayoutCacheFile('footer') . '\'));' . PHP_EOL;

            $prefix .= '$page_header = file_get_contents(\'' . $this->getLayoutCacheFile('header') . '\');' . PHP_EOL;
            $prefix .= '$page_footer = file_get_contents(\'' . $this->getLayoutCacheFile('footer') . '\');' . PHP_EOL;
            $prefix .= '$page_sidebar = file_get_contents(\'' . $this->getLayoutCacheFile('sidebar') . '\');' . PHP_EOL;
            $prefix .= '$page_content = file_get_contents(\'' . $this->getLayoutCacheFile('content') . '\');' . PHP_EOL;

            $prefix .= '$bootstrap_css = \'http://www.hyperfinance.cz/css/bootstrap.min.css\';' . PHP_EOL;
            $prefix .= '$bootstrap_js = \'http://www.hyperfinance.cz/js/bootstrap.min.js\';' . PHP_EOL;
            $prefix .= '$jquery = \'//code.jquery.com/jquery-1.10.2.min.js\';' . PHP_EOL;
            $prefix .= '$font_awesome = \'http://www.hyperfinance.cz/fonts/font-awesome-4.3.0/css/font-awesome.min.css\';' . PHP_EOL;

            $prefix .= '?>' . PHP_EOL;

            $pageContent = $prefix . '<!DOCTYPE html>
            <html class="no-js">
            <head>
                <meta charset="utf-8" />
              {$include_head}
              <title>{$page->title}</title>
              <link href=\'{$bootstrap_css}\' rel=\'stylesheet\' type=\'text/css\' />
              <link href=\'http://www.hyperfinance.cz/css/public/global.css\' rel=\'stylesheet\' type=\'text/css\' />

              <meta name="description" content="{$page->description}" />
              <link href=\'{$color_scheme}\' rel=\'stylesheet\' type=\'text/css\' />
              <link href=\'{$font_awesome}\' rel=\'stylesheet\' type=\'text/css\' />
              <meta name="viewport" content="width=device-width, initial-scale=1.0" />
              <meta http-equiv="X-UA-Compatible" content="IE=edge" />
              <link href=\'http://fonts.googleapis.com/css?family=Open+Sans:700&amp;subset=latin,latin-ext\' rel=\'stylesheet\' type=\'text/css\' />

              <script src=\'{$jquery}\'></script>
              <script src=\'{$bootstrap_js}\'></script>

              {$include_head_end}
            </head>
            <body>
              {$include_body}

              {$global_header}

                <main>
              {$page_header}
              <div id="page-content">
                <div class="wrapper"><div class="container"><div class="row">
              {$page_content}

              {$page_sidebar}
                </div> <!-- row end -->
                </div> <!--container end -->
                </div> <!--wrapper end -->
                </div> <!-- page-content-->
              {$page_footer}
                </main>
              {$global_footer}
              {$include_body_end}
            </body>
            </html>';

            $pageContent = html_entity_decode($pageContent);

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $pageContent);
        }

        return $path;
    }

    /** Vrati cestu k suboru, kde je ulozeny finalny obsah stranky po kompilacii
     * @return string
     */
    public function getMainCacheFile()
    {
        $path = $this->getMainCacheDirectory() . 'page_compiled.html';

        if (!file_exists($path))
        {
            $result = html_entity_decode(stripcslashes(Yii::$app->cacheEngine->latteRenderer->renderToString($this->getMainPreCacheFile(), array())));

            Yii::$app->cacheEngine->writeToFile($path, 'w+', $result);
        }

        return $path;
    }

    /** Vrati hlavicku s includami pre danu podstranku
     * @return string
     */
    public function getIncludePrefix()
    {
        $prefix = $this->portal->getIncludePrefix();

        $prefix .= '<?php ' . PHP_EOL;

        $prefix .= 'include "' . $this->getVarCacheFile() . '";' . PHP_EOL;

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

        $buffer .= ');' . PHP_EOL;

        return $buffer;
    }
}
