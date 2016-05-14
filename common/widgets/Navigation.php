<?php

namespace common\widgets;

use Yii;
use \backend\models\root\Menu;
use \yii\helpers\Url;
use \yii\helpers\Html;
use \yii\base\Widget;


class Navigation extends Widget
{
    public $items;

    /**
     * Inicializácia vstupných argumentov
     */
    public function init()
    {
        parent::init();

        if ($this->items === null) {
            $this->items = [];
        }
    }

    private function isAnyChildrenActive($children)
    {
        foreach ($children as $child) {
            if (Yii::$app->controller->id == $child['controller'])
                return true;
        }

        return false;
    }

    /**
     * Generovanie widgetu
     * @return string
     */
    public function run()
    {
        $menu = Html::beginTag('ul', ['class' => 'nav navbar-nav side-nav metismenu']);

        foreach ($this->items as $data) {
            $has_children = !empty($data['children']);

            $is_active = (isset($data['controller']) && Yii::$app->controller->id == $data['controller']) ||
                ($has_children && $this->isAnyChildrenActive($data['children']));

            $menu .= Html::beginTag('li', $is_active ? ['class' => 'active'] : []);

            $menu .= $this->getMenuLink($data, $is_active);

            if (!empty($data['children'])) {
                $menu .= Html::beginTag('ul', ['class' => 'nav nav-second-level collapse' . (isset($data['active']) &&
                    $data['active']) ? ' in' : '']);

                foreach ($data['children'] as $submenu) {
                    $menu .= $this->getSubmenuLink($submenu);
                }

                $menu .= Html::endTag('ul');
            }

            $menu .= Html::endTag('li');
        }

        $menu .= Html::endTag('ul');

        return $menu;
    }

    public function getSubmenuLink($submenu)
    {
        $result = Html::beginTag('li');
        $result .= Html::a($submenu['title'], Url::to([$submenu['controller'] . '/' . $submenu['action']]), [
            'class' => (Yii::$app->controller->id == $submenu['controller']) ? 'active-menu-link' : ''
        ]);

        $result .= Html::endTag('li');

        return $result;
    }

    public function getMenuLink($data, $is_active)
    {
        $icon = Html::tag('span', '', ['class' => 'fa fa-fw fa-' . $data['icon'], 'style' => 'margin-right: 10px;']);
        $title = Html::tag('span', $data['title'], ['class' => 'nav-label']);
        $arrow = !empty($data['children']) ? Html::tag('span', '', ['class' => 'fa toggle '. (($is_active) ?
            'fa-angle-up' : 'fa-angle-down')]) : '';

        return Html::a($icon . $title . $arrow, !empty($data['children']) ? 'javascript: void(0);' : Url::to
        ([$data['controller'] . '/' . $data['action']]));
    }
}

?>
