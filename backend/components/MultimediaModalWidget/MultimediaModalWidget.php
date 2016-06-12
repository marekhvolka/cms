<?php

namespace backend\components\MultimediaModalWidget;


use backend\models\MultimediaCategory;
use ReflectionClass;
use Yii;
use yii\base\ViewContextInterface;
use yii\base\Widget;
use yii\web\ServerErrorHttpException;

/**
 * Used for selecting a file from multimedia. To use the class, set the 'successCallJSFunction' to the name of the function to be called after successful selecting a file
 * (it will be called with one argument -> the url address to the file).
 *
 * @package backend\components\MultimediaModalWidget
 */
class MultimediaModalWidget extends Widget implements ViewContextInterface
{
    /**
     * Name of a JS function to be called after successful select (with one argument -> the url adress to the file).
     * @var string
     */
    public $successCallJSFunction;

    /**
     * Show only images?
     *
     * @var bool
     */
    public $onlyImages = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->successCallJSFunction)) {
            throw new ServerErrorHttpException("Argument successCallJSFunction must be first set.");
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $data = [];

        $categories = MultimediaCategory::loadAll();
        $subcategories = MultimediaCategory::getSubcategories(Yii::$app->session->get('portal_id'));

        foreach ($subcategories as $index => $subcategory) {
            /**
             * @var $category MultimediaCategory
             */
            foreach ($categories as $category) {
                $items = $category->getItems($index, $this->onlyImages);

                if (count($items) > 0) {
                    $data[] = [
                        'category' => $category,
                        'subcategory' => $subcategory,
                        'items' => $items
                    ];
                }
            }
        }

        return $this->render('widget', [
            'data' => $data,
            'nameOfFunction' => $this->successCallJSFunction
        ]);
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