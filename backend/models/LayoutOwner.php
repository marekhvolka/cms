<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 02.08.16
 * Time: 18:57
 */

namespace backend\models;


use Exception;
use Yii;

/**
 * @property integer $portal_id
 * @property Portal $portal
 *
 * @property Area $header
 * @property Area $content
 * @property Area $sidebar
 * @property Area $footer
 */
abstract class LayoutOwner extends CustomModel implements IDuplicable, ICacheable
{
    public function initializeNew()
    {
        $this->portal_id = Yii::$app->user->identity->portal_id;

        $this->header = new Area();
        $this->header->type = 'header';

        $this->footer = new Area();
        $this->footer->type = 'footer';

        $this->sidebar = new Area();
        $this->sidebar->type = 'sidebar';
        $this->sidebar->size = 4;
        $this->sidebar->sections = array(new Section());

        $this->content = new Area();
        $this->content->type = 'content';
        $this->content->sections = array(new Section());
    }

    public function init()
    {
        parent::init();
        $this->sidebar_side = 'right';
        $this->active = 1;
    }

    public function getParams()
    {
        $params = [];

        if ($this->className() == Page::className()) {
            $params['page_id'] = 'id';
        } else if ($this->className() == Post::className()) {
            $params['post_id'] = 'id';
        }

        return $params;
    }

    /**
     * @return Area
     */
    public function getHeader()
    {
        if (!isset($this->header)) {
            $this->header = $this->hasOne(Area::className(), $this->getParams())
                ->andWhere(['type' => 'header'])->one();
        }
        return $this->header;
    }

    public function setHeader($value) { $this->header = $value; }

    /**
     * @return Area
     */
    public function getContent()
    {
        if (!isset($this->content)) {
            $this->content = $this->hasOne(Area::className(), $this->getParams())
                ->andWhere(['type' => 'content'])->one();
        }
        return $this->content;
    }

    public function setContent($value) { $this->content = $value; }

    /**
     * @return Area
     */
    public function getSidebar()
    {
        if (!isset($this->sidebar)) {
            $this->sidebar = $this->hasOne(Area::className(), $this->getParams())
                ->andWhere(['type' => 'sidebar'])->one();
        }
        return $this->sidebar;
    }

    public function setSidebar($value) { $this->sidebar = $value; }

    /**
     * @return Area
     */
    public function getFooter()
    {
        if (!isset($this->footer)) {
            $this->footer = $this->hasOne(Area::className(), $this->getParams())
                ->andWhere(['type' => 'footer'])->one();
        }
        return $this->footer;
    }

    public function setFooter($value) { $this->footer = $value; }


    /** Vrati cestu k adresaru, kde su ulozene cache subory pre danu podstranku
     * @return string
     */
    public function getMainDirectory()
    {
        $path = '';

        if ($this->className() == Page::className()) {
            $path = $this->portal->getPagesDirectory() . 'page' . $this->id . '/';
        } else if ($this->className() == Post::className()) {
            $path = $this->portal->getPostsDirectory() . 'post' . $this->id . '/';
        }

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /** Vrati cestu k suboru, kde je ulozeny obsah stranky pred kompilaciou
     * @param bool $reload
     * @return string
     * @throws
     */
    public function getMainPreCacheFile($reload = false)
    {
        $hardReload = false;
        $path = $this->getMainDirectory() . 'page_prepared.latte';

        if (!file_exists($path) || (($this->outdated || $this->head_outdated)) && !Yii::$app->user->isGuest) {
            try {
                $prefix = $this->getIncludePrefix();

                if ($this->className() == Page::className()) {
                    if (($this->parent && $this->parent->head_outdated) || $reload) {
                        $hardReload = true;
                    }
                } else if ($this->className() == Post::className()) {
                    $hardReload = $reload;
                }

                $prefix .= '<?php' . PHP_EOL;

                $prefix .= '$global_header = executeScript("' . $this->portal->header->getCacheFile() . '");' . PHP_EOL;
                $prefix .= '$global_footer = executeScript("' . $this->portal->footer->getCacheFile() . '");' . PHP_EOL;

                $prefix .= '$page_header = executeScript("' . $this->header->getCacheFile($hardReload) . '");' . PHP_EOL;
                $prefix .= '$page_footer = executeScript("' . $this->footer->getCacheFile($hardReload) . '");' . PHP_EOL;

                $prefix .= '$page_sidebar = executeScript("' . $this->sidebar->getCacheFile($hardReload) . '");' . PHP_EOL;
                $prefix .= '$page_content = executeScript("' . $this->content->getCacheFile($hardReload) . '");' . PHP_EOL;

                $prefix .= $this->sidebar_side == 'left' ? '$page_master = $page_sidebar . $page_content;' . PHP_EOL :
                    '$page_master = $page_content . $page_sidebar;' . PHP_EOL;

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
        $prefix = '';

        if ($this->className() == Page::className()) {
            $prefix = 'page';
        } else if ($this->className() == Post::className()) {
            $prefix = 'post';
        }

        $path = $this->getMainDirectory() . $prefix . '_compiled.php';

        if (!file_exists($path) || (($this->outdated || $this->soft_outdated || $this->head_outdated) && !Yii::$app->user->isGuest)) {
            try {
                $result = Yii::$app->dataEngine->latteRenderer->renderToString($this->getMainPreCacheFile(),
                    array());

                $result = html_entity_decode($result, ENT_QUOTES);

                Yii::$app->dataEngine->writeToFile($path, 'w+', $result);

                $this->setActual();
            } catch (Exception $exception) {
                $this->logException($exception, $prefix . '_final');
            }
        }

        return $path;
    }

    public abstract function getVarCacheFile();

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

    /**
     * Metoda, pripravujuca podstranku na duplikaciu
     */
    public function prepareToDuplicate()
    {
        $this->header->prepareToDuplicate();
        $this->footer->prepareToDuplicate();
        $this->sidebar->prepareToDuplicate();
        $this->content->prepareToDuplicate();

        unset($this->id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortal()
    {
        return $this->hasOne(Portal::className(), ['id' => 'portal_id']);
    }

    public function isPost()
    {
        return $this->className() == Post::className();
    }

    public function isPage()
    {
        return $this->className() == Page::className();
    }

    public function getType()
    {
        if ($this->isPost()) {
            return 'post';
        } else if ($this->isPage()) {
            return 'page';
        }

        return '';
    }
}