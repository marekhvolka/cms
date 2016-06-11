<?php

namespace backend\components\AjaxLoading;

use ReflectionClass;
use yii\base\ViewContextInterface;
use yii\bootstrap\Widget;

/**
 * Show an overlay with loading icon when an ajax request takes more than 200 milliseconds to load.
 * 
 * @package backend\components\AjaxLoading
 */
class AjaxLoadingWidget extends Widget implements ViewContextInterface
{
    /**
     * @return string
     */
    public function run()
    {
        return $this->render("view");
    }

    /**
     * Returns the directory containing the view files for this widget.
     * The default implementation returns the 'views' subdirectory under the directory containing the widget class file.
     * @return string the directory containing the view files for this widget.
     */
    public function getViewPath()
    {
        $class = new ReflectionClass($this);

        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views';
    }
}