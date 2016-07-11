<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property integer $portal_id
 * @property integer $active
 * @property integer $parent_id
 * @property integer $product_id
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $color_scheme
 * @property string $sidebar_side
 * @property string $last_edit
 * @property integer $last_edit_user
 * @property string $breadcrumbs
 * @property bool $outdated
 * @property bool $head_outdated
 *
 * @property Portal $portal
 * @property User $lastEditUser
 * @property Page $parent
 * @property Page[] $pages
 * @property Section[] $sections
 * @property Product $product
 * @property SnippetVarValue[] $snippetVarValues
 * @property Area $header
 * @property Area $footer
 * @property Area $content
 * @property Area $sidebar
 */
class Page extends CustomModel implements ICacheable, IDuplicable
{
    public $cacheIdentifier;

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
        $this->sidebar_side = 'right';
        $this->color_scheme = 'inherit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'identifier',
                    'portal_id',
                    'active',
                    'color_scheme',
                    'sidebar_side',
                ],
                'required'
            ],
            [
                [
                    'portal_id',
                    'active',
                    'parent_id',
                    'product_id',
                    'last_edit_user'
                ],
                'integer'
            ],
            [['description', 'keywords'], 'string'],
            [['last_edit', 'breadcrumbs', 'url'], 'safe'],
            [['name', 'identifier', 'color_scheme'], 'string', 'max' => 80],
            [['title'], 'string', 'max' => 150],
            [
                ['identifier', 'portal_id', 'parent_id'],
                'unique',
                'targetAttribute' => ['identifier', 'portal_id', 'parent_id'],
                'message' => 'The combination of Identifier, Portal ID and Parent ID has already been taken.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Meno',
            'identifier' => 'Identifikátor',
            'url' => 'Url',
            'portal_id' => 'Portál',
            'active' => 'Aktívna',
            'parent_id' => 'Predok',
            'product_id' => 'Produkt',
            'title' => 'Titulok',
            'description' => 'Popis',
            'keywords' => 'Kľúčové slová',
            'color_scheme' => 'Farebná schéma',
            'sidebar_side' => 'Pozícia sidebaru',
            'last_edit' => 'Posledná zmena',
            'last_edit_user' => 'Naposledy editoval'
        ];
    }

    /** Metoda na vyskladanie URL pre podstranku
     * @return string
     */
    public function getUrl()
    {
        if ($this->identifier == 'homepage' && !$this->parent) {
            return '/';
        }

        if (isset($this->parent)) {
            $url = $this->parent->url;
        } else {
            $url = '/';
        }

        return $url . $this->identifier . '/';
    }

    /** Metoda na vyskladanie URL pre podstranku
     * @return string
     */
    public function getBreadcrumbs()
    {
        $breadcrumbs = '';

        if (isset($this->parent)) {
            $breadcrumbs = $this->parent->breadcrumbs . ' -> ';
        }

        return $breadcrumbs . $this->name;
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

        if (!$product->exists() && (isset($this->parent))) {
            return $this->parent->product;
        }
        return $product;
    }

    public function getSnippetVarValues()
    {
        return $this->hasMany(SnippetVarValue::className(), ['value_page_id' => 'id']);
    }

    /**
     * @return Area
     */
    public function getHeader()
    {
        if (!isset($this->header)) {
            $this->header = $this->hasOne(Area::className(), ['page_id' => 'id'])
                ->andWhere(['type' => 'header'])->one();
        }
        return $this->header;
    }

    public function setHeader($value)
    {
        $this->header = $value;
    }

    /**
     * @return Area
     */
    public function getContent()
    {
        if (!isset($this->content)) {
            $this->content = $this->hasOne(Area::className(), ['page_id' => 'id'])
                ->andWhere(['type' => 'content'])->one();
        }
        return $this->content;
    }

    public function setContent($value)
    {
        $this->content = $value;
    }

    /**
     * @return Area
     */
    public function getSidebar()
    {
        if (!isset($this->sidebar)) {
            $this->sidebar = $this->hasOne(Area::className(), ['page_id' => 'id'])
                ->andWhere(['type' => 'sidebar'])->one();
        }
        return $this->sidebar;
    }

    public function setSidebar($value)
    {
        $this->sidebar = $value;
    }

    /**
     * @return Area
     */
    public function getFooter()
    {
        if (!isset($this->footer)) {
            $this->footer = $this->hasOne(Area::className(), ['page_id' => 'id'])
                ->andWhere(['type' => 'footer'])->one();
        }
        return $this->footer;
    }

    public function setFooter($value)
    {
        $this->footer = $value;
    }

    /** Vrati cestu k farebnej scheme portalu
     * @param bool $forWeb
     * @return string
     */
    public function getColorSchemePath($forWeb = false)
    {
        if ($this->color_scheme == 'inherit') {
            if (isset($this->parent)) {
                return $this->parent->getColorSchemePath($forWeb);
            } else {
                return $this->portal->getColorSchemePath($forWeb);
            }
        } else if ($this->color_scheme == '') {
            return $this->portal->getColorSchemePath($forWeb);
        } else {
            return $this->portal->template->getColorSchemeDirectoryPath($forWeb) . $this->color_scheme . '.min.css';
        }
    }

    /** Vrati cestu k adresaru, kde su ulozene cache subory pre danu podstranku
     * @return string
     */
    public function getMainDirectory()
    {
        $path = $this->portal->getPagesDirectory() . 'page' . $this->id . '/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /** Vrati cestu k suboru, v ktorom su ulozene premenne podstranky
     * @return string
     */
    public function getVarCacheFile()
    {
        $path = $this->getMainDirectory() . 'page_var.php';

        if (!file_exists($path) || $this->outdated || $this->head_outdated) {

            try {
                $dataEngine = Yii::$app->dataEngine;

                $buffer = '<?php ' . PHP_EOL;

                if (isset($this->parent)) {
                    $buffer .= 'include("' . $this->parent->getVarCacheFile() . '");' . PHP_EOL;
                }

                if (isset($this->product)) {
                    $buffer .= '$product = $' . $this->product->identifier . ';' . PHP_EOL;
                } else if (isset($this->parent)) {
                    $buffer .= '$product = $portal->pages->page' . $this->parent->id . '->product' . ';' . PHP_EOL;
                } else {
                    $buffer .= '$emptyProduct = (object) array();' . PHP_EOL;
                    $buffer .= '$product = new ObjectBridge($emptyProduct, \'\');' . PHP_EOL;
                }
                $buffer .= '$tempObject = (object) array(' . PHP_EOL;

                $buffer .= '\'id\' => ' . $this->id . ',' . PHP_EOL;
                $buffer .= '\'url\' => \'' . $dataEngine->normalizeString($this->url) . '\',' . PHP_EOL;
                $buffer .= '\'name\' => \'' . $dataEngine->normalizeString($this->name) . '\',' . PHP_EOL;
                $buffer .= '\'title\' => \'' . $dataEngine->normalizeString($this->title) . '\',' . PHP_EOL;
                $buffer .= '\'description\' => \'' . $dataEngine->normalizeString($this->description) . '\',' . PHP_EOL;
                $buffer .= '\'keywords\' => \'' . $dataEngine->normalizeString($this->keywords) . '\',' . PHP_EOL;
                $buffer .= '\'active\' => ' . $this->active . ',' . PHP_EOL;

                if (isset($this->product)) {
                    $buffer .= '\'product\' => $product,' . PHP_EOL;
                }

                $buffer .= ');' . PHP_EOL;

                if ($this->parent) {
                    $buffer .= '$tempObject->parent = ' . $this->parent->cacheIdentifier . ';' . PHP_EOL;

                    $buffer .= '$tempObject->parents = array_merge_recursive($tempObject->parent->parents,
                    array($tempObject->parent));' . PHP_EOL;
                } else {
                    $buffer .= '$tempObject->parents = array();' . PHP_EOL;
                }

                $buffer .= $this->cacheIdentifier . ' = new ObjectBridge($tempObject, \'page' . $this->id . '\');' . PHP_EOL;

                if (isset($this->color_scheme)) {
                    $buffer .= '$color_scheme = \'' . $this->getColorSchemePath(true) . '\';' . PHP_EOL;
                }

                $buffer .= '$page = ' . $this->cacheIdentifier . ';' . PHP_EOL;

                $buffer .= '?>';

                $dataEngine->writeToFile($path, 'w+', $buffer);
                $this->head_outdated = 0;
                $this->save();
                $this->removeException();
            } catch (Exception $exception) {
                $this->logException($exception, 'page_var');
            }
        }

        return $path;
    }

    /** Vrati cestu k suboru, kde je ulozeny finalny obsah stranky pred kompilaciou
     * @return string
     */
    public function getMainPreCacheFile()
    {
        $reload = false;
        $path = $this->getMainDirectory() . 'page_prepared.latte';

        if (!file_exists($path) || $this->outdated) {
            try {
                $prefix = $this->getIncludePrefix();

                if (($this->product && $this->product->outdated) || $this->portal->outdated ||
                    ($this->parent && $this->parent->head_outdated)) {
                    $reload = true;
                }

                $prefix .= '<?php' . PHP_EOL;

                $prefix .= '$global_header = executeScript("' . $this->portal->header->getCacheFile() . '");' . PHP_EOL;
                $prefix .= '$global_footer = executeScript("' . $this->portal->footer->getCacheFile() . '");' . PHP_EOL;

                $prefix .= '$page_header = executeScript("' . $this->header->getCacheFile($reload) . '");' . PHP_EOL;
                $prefix .= '$page_footer = executeScript("' . $this->footer->getCacheFile($reload) . '");' . PHP_EOL;

                $prefix .= '$page_sidebar = executeScript("' . $this->sidebar->getCacheFile($reload) . '");' . PHP_EOL;
                $prefix .= '$page_content = executeScript("' . $this->content->getCacheFile($reload) . '");' . PHP_EOL;

                if ($this->sidebar_side == 'left') {
                    $prefix .= '$page_master = $page_sidebar . $page_content;' . PHP_EOL;
                } else {
                    $prefix .= '$page_master = $page_content . $page_sidebar;' . PHP_EOL;
                }

                $prefix .= '$global_css = \'' . Yii::$app->dataEngine->getGlobalCssFile(true) . '\';' . PHP_EOL;

                $prefix .= '?>' . PHP_EOL;

                $templateIndex = file_get_contents($this->portal->template->getIndexPath());

                $pageContent = $prefix . $templateIndex;

                $pageContent = html_entity_decode($pageContent);

                Yii::$app->dataEngine->writeToFile($path, 'w+', $pageContent);

            } catch (Exception $exception) {
                $this->logException($exception, 'page_precache');
            }
        }

        return $path;
    }

    /** Vrati cestu k suboru, kde je ulozeny finalny obsah stranky po kompilacii
     * @param bool $reload
     * @return string
     * @throws Exception
     */
    public function getMainCacheFile($reload = false)
    {
        $path = $this->getMainDirectory() . 'page_compiled.html';

        if (!file_exists($path) || $reload) {
            try {
                $result = Yii::$app->dataEngine->latteRenderer->renderToString($this->getMainPreCacheFile(), array());

                $result = html_entity_decode($result, ENT_QUOTES);

                Yii::$app->dataEngine->writeToFile($path, 'w+', $result);

                $this->setActual();
            } catch (Exception $exception) {
                $this->logException($exception, 'page_final');
            }
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

        $prefix .= 'include("' . $this->getVarCacheFile() . '");' . PHP_EOL;

        $prefix .= '?>' . PHP_EOL;

        return $prefix;
    }

    public function resetAfterUpdate($type = 'all')
    {
        $this->setOutdated();

        if ($this->isChanged() && $this->isPageHeadChanged()) {
            foreach ($this->pages as $page) {
                $page->resetAfterUpdate();
            }

            foreach ($this->snippetVarValues as $snippetVarValue) {
                $snippetVarValue->resetAfterUpdate();
            }
        }
    }

    public function prepareToDuplicate()
    {
        $this->header->prepareToDuplicate();
        $this->footer->prepareToDuplicate();
        $this->sidebar->prepareToDuplicate();
        $this->content->prepareToDuplicate();

        unset($this->id);
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub

        $this->cacheIdentifier = '$page' . $this->id;
    }

    public function isPageHeadChanged()
    {
        if ($this->myOldAttributes['name'] != $this->name) {
            return true;
        }
        if ($this->myOldAttributes['identifier'] != $this->identifier) {
            return true;
        }
        if ($this->myOldAttributes['product_id'] != $this->product_id) {
            return true;
        }

        return false;
    }
}
