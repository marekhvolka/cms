<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 07/05/16
 * Time: 08:39
 */

namespace common\components;


/**
 * Class used for quickly flashing alerts using session flash.
 * @package app\classes
 * @author Juraj Mlich <jurajmlich@gmail.com>
 */
class Alert
{
    /**
     * @var string The message of the alert.
     */
    public $text;
    /**
     * @var string The type of the alert.
     */
    public $type;

    private function __construct($text, $type)
    {
        $this->text = $text;
        $this->type = $type;
    }

    /**
     * Show an alert with the given text with informative character.
     *
     * @param $text string the message of the alert
     */
    public static function info($text)
    {
        \Yii::$app->getSession()->addFlash('alerts', new Alert($text, 'info'));
    }

    /**
     * Show an alert with the given text informing about something that has been done successfully.
     *
     * @param $text string the message of the alert
     */
    public static function success($text)
    {
        \Yii::$app->getSession()->addFlash('alerts', new Alert($text, 'success'));
    }

    /**
     * Show an alert with the given text informing about something that has gone wrong.
     *
     * @param $text string the message of the alert
     */
    public static function danger($text)
    {
        \Yii::$app->getSession()->addFlash('alerts', new Alert($text, 'danger'));
    }
}