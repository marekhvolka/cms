<?php


namespace common\widgets;

use \yii\base\Widget;
use \yii\helpers\ArrayHelper;
use \yii\helpers\Html;

/**
 * Generovanie boxíka
 * 
 * ```php
 *
 * <?php use \common\components\widgets\Box; ?>
 * 
 * <?php Box::begin([
 *     'title'        => '',
 *     'titleSize'    => 3,
 *     'show'         => true,
 *     'headerButton' => ''
 *     'options'      => [
 *         'class' => '',
 *         'id'    => '',
 *         'style' => ''
 *     ],
 * ]); ?>
 *
 * <?php Box::end(); ?>
 * ```
 * 
 */

class Box extends Widget
{
    /**
     * Nadpis
     * @var string
     */
    public $title;

    /**
     * Zobrazenie boxíka
     * @var boolean
     */
    public $show;

    /**
     * Tlačidlá v hlavičke
     * @var string
     */
    public $headerButton;

    /**
     * Veľkosť nadpisu
     * @var integer
     */
    public $titleSize = 3;

    /**
     * Užívateľské nastavenia
     * @var array
     */
    public $options = [];

    /**
     * Preddefinované nastavenia
     * @var array
     */
    private $defaultOptions = [
        'class' => 'ibox'
    ];

    /**
     * Inicializácia vstupných argumentov
     */
    public function init()
    {
        parent::init();

        $this->options = $this->prepareStyle($this->defaultOptions, $this->options);
        ob_start();
    }

    /**
     * Generovanie widgetu
     * @return string
     */
    public function run()
    {
        $result = Html::beginTag('div', $this->options);

        if(!empty($this->title))
        {
            $arrow = '';

            if(isset($this->show))
            {
                $class = !empty($this->headerButton) ? '_left' : '';

                $arrow = Html::tag('span', '', [
                    'class'        => 'arrow_toggle'.$class, 
                    'data-element' => $this->show ? 'show' : 'hide',
                    'onclick'      => 'box_toggle($(this))'
                ]);
                    
                $title_options = [
                    'style'        => 'cursor: pointer;',
                    'data-element' => $this->show ? 'show' : 'hide'
                ];
            }

            if(!empty($this->headerButton))
            {
                $header_button = Html::tag('div', $this->headerButton, ['class' => 'ibox-header-btn']);
                $title         = $arrow.Html::tag('h'.$this->titleSize, $this->title, [
                    'style'   => !empty($arrow) ? 'margin-left: 25px;' : '', 
                    'onclick' => 'box_toggle($(this))'
                ]).$header_button;
            }
            else
            {
                $title = Html::tag('h'.$this->titleSize, $this->title, ['onclick' => 'box_toggle($(this))']).$arrow;
            }

            $title_options['class'] = 'ibox-title';

            $result .= Html::tag('div', $title, $title_options);
        }

        $result .= Html::beginTag('div', ['class' => 'ibox-body', 'style' => ['position' => 'relative']]);
        $result .= ob_get_clean();
        $result .= Html::tag('div', '', ['class' => 'clearfix']);
        $result .= Html::endTag('div');
        $result .= Html::endTag('div');

        $view = $this->getView();

        $view->registerCss($this->linkStyle());
        $view->registerJs($this->boxInitJs());
        $view->registerJs($this->boxToggleJs(), $view::POS_END);

        return $result;
    }

    /**
     * Generovanie CSS štýlov
     * @return string
     */
    private function linkStyle()
    {
        $style = '
        .btn-ibox-title{
          position: absolute;
          top: 20px;
          right: 30px;
        }

        .ibox-btn-footer{
          position: absolute;
          right: 30px;
          bottom: 25px;
        }

        .page-head-btn-footer{
          position: absolute;
          right: 30px;
          bottom: 0px;
        }

        .ibox-body {
          clear: both;
          position: relative;
        }
        .ibox-heading {
          background-color: #f3f6fb;
          border-bottom: none;
        }
        .ibox-heading h3 {
          font-weight: 200;
          font-size: 24px;
        }
        .ibox-title h5 {
          display: inline-block;
          font-size: 14px;
          margin: 0 0 7px;
          padding: 0;
          text-overflow: ellipsis;
          float: left;
        }
        .ibox-title .label {
          float: left;
          margin-left: 4px;
        }
        .ibox-tools {
          display: inline-block;
          float: right;
          margin-top: 0;
          position: relative;
          padding: 0;
        }
        .ibox-tools a {
          cursor: pointer;
          margin-left: 5px;
          color: #c4c4c4;
        }
        .ibox-tools a.btn-primary {
          color: #fff;
        }
        .ibox-tools .dropdown-menu > li > a {
          padding: 4px 10px;
          font-size: 12px;
        }
        .ibox .open > .dropdown-menu {
          left: auto;
          right: 0;
        }

        .ibox-body h1,
        .ibox-body h2,
        .ibox-body h3,
        .ibox-body h4,
        .ibox-body h5,
        .ibox-title h1,
        .ibox-title h2,
        .ibox-title h3,
        .ibox-title h4,
        .ibox-title h5 {
          margin-top: 5px;
        }
        .ibox {
          clear: both;
          margin-bottom: 25px;
          margin-top: 0;
          padding: 0;
        }
        .ibox.collapsed .ibox-body {
          display: none;
        }
        .ibox.collapsed .fa.fa-chevron-up:before {
          content: "\f078";
        }
        .ibox.collapsed .fa.fa-chevron-down:before {
          content: "\f077";
        }
        .ibox:after,
        .ibox:before {
          display: table;
        }
        .ibox-title {
          -moz-border-bottom-colors: none;
          -moz-border-left-colors: none;
          -moz-border-right-colors: none;
          -moz-border-top-colors: none;
          background-color: #ffffff;
          border-color: #e7eaec;
          border-image: none;
          border-style: solid solid none;
          border-width: 4px 0px 0;
          color: inherit;
          margin-bottom: 0;
          padding: 14px 15px 7px;
          min-height: 48px;
          position: relative;
        }
        .ibox-body {
          background-color: #ffffff;
          color: inherit;
          padding: 15px 20px 20px 20px;
          border-color: #e7eaec;
          border-image: none;
          border-style: solid solid none;
          border-width: 1px 0px;
        }
        .ibox-footer {
          color: inherit;
          border-top: 1px solid #e7eaec;
          font-size: 90%;
          background: #ffffff;
          padding: 10px 15px;
        }
        .arrow_toggle,
        .arrow_toggle_left{
            display: block;
            position: absolute;
            cursor: pointer;
            font-size: 18px;
            color: #c4c4c4;
            top: 0;
            bottom: 0;
            margin: auto;
            height: 20px;
            line-height: 20px;
        }
        .arrow_toggle{
            right: 25px;
        }
        .arrow_toggle_left{
            left: 15px;
        }
        .ibox-header-btn{
            position: absolute;
            right: 15px;            
            top: 0;
            bottom: 0;
            margin: auto;
            height: 22px;
        }';
        
        return $style;
    }

    /**
     * Inicializačná JavaScript
     * @return string
     */
    private function boxInitJs()
    {
        $script = '
        var span_show = $(\'span[data-element="show"]\');
        for(var i = span_show.length - 1; i >= 0; i--)
        {
            $(span_show[i]).html(\'<i class="fa fa-angle-up"></i>\');
        }

        var span_hide = $(\'span[data-element="hide"]\');
        for(var i = span_hide.length - 1; i >= 0; i--)
        {
            $(span_hide[i]).html(\'<i class="fa fa-angle-down"></i>\');
            $(span_hide[i]).parent().next().hide();
        }';

        return $script;
    }

    /**
     * Generovanie JavaScriptu pre minimalizáciu boxíka
     * @return string
     */
    private function boxToggleJs()
    {
        $script = '
        function box_toggle(element)
        {
            $(element).parent().next().slideToggle(120, function()
            {
                if($(element).parent().next().is(":visible"))
                {
                    $(element).parent().find(\'i\').removeClass(\'fa-angle-down\');
                    $(element).parent().find(\'i\').addClass(\'fa-angle-up\');
                }
                else
                {
                    $(element).parent().find(\'i\').removeClass(\'fa-angle-up\');
                    $(element).parent().find(\'i\').addClass(\'fa-angle-down\');
                }
                
            });

        }';

        return $script;
    }

    /**
     * Spojí štýly, triedy a ID do jedneho poľa
     * @param  array $default_settings preddefinované nastavenia
     * @param  array $user_settings    užívateľské nastavenia
     * @return array
     */
    private function prepareStyle($default_settings, $user_settings)
    {
        $default_settings = array_merge_recursive($default_settings, $user_settings);

        if(!empty($default_settings))
        {
            foreach($default_settings as &$option)
            {
                $option = implode(' ', (array)$option);
            }
        }

        return $default_settings;
    }
}

?>
