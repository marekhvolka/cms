<?php
namespace backend\components\AceEditor;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * ACE Widget
 */
class AceEditorWidget extends InputWidget
{
    /** @var string */
    public $varNameAceEditor = 'aceEditor';
    /** @var string */
    public $mode = 'php';
    /** @var string */
    public $theme = 'github';
    /** @var bool Static syntax highlight */
    public $editable = true;
    /** @var bool */
    public $autocompletion = false;
    /** @var array */
    public $extensions = [];
    /** @var array */
    public $aceOptions = [
        "maxLines" => 100,
        "minLines" => 5,
    ];

    /**
     * @return string
     */
    public function run()
    {
        if (!$this->editable) {
            $this->extensions[] = 'static_highlight';
        }
        if ($this->autocompletion) {
            $this->extensions[] = 'language_tools';
        }
        AceEditorAsset::register($this->view, $this->extensions);
        return $this->editable ? $this->editable() : $this->readable();
    }

    protected function editable()
    {
        $id = $this->id;
        $autocompletion = $this->autocompletion ? 'true' : 'false';
        if ($this->autocompletion) {
            $this->aceOptions['enableBasicAutocompletion'] = true;
            $this->aceOptions['enableSnippets'] = true;
            $this->aceOptions['enableLiveAutocompletion'] = false;
        }
        $aceOptions = Json::encode($this->aceOptions);
        $js = <<<JS
(function(){
    var aceEditorAutocompletion = {$autocompletion};
    if (aceEditorAutocompletion) {
        ace.require("ace/ext/language_tools");
    }
    {$this->varNameAceEditor} = ace.edit("{$id}");
    {$this->varNameAceEditor}.setTheme("ace/theme/{$this->theme}");
    {$this->varNameAceEditor}.getSession().setMode("ace/mode/{$this->mode}");
    {$this->varNameAceEditor}.setOptions({$aceOptions});
})();
JS;
        $view = $this->getView();
        $view->registerJs("\nvar {$this->varNameAceEditor} = {};\n", $view::POS_HEAD);
        $view->registerJs($js);
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, $this->options);
        }
        return Html::textarea($this->name, $this->value, $this->options);
    }

    /**
     * @return string
     */
    protected function readable()
    {
        $this->options['id'] = $this->id;
        $this->view->registerJs(
            <<<JS
(function(){
    var _highlight = ace.require("ace/ext/static_highlight");
    _highlight(\$('#{$this->id}')[0], {
        mode: "ace/mode/{$this->mode}",
        theme: "ace/theme/{$this->theme}",
        startLineNumber: 1,
        showGutter: true,
        trim: true
    });
})();
JS
        );
        return Html::tag('pre', htmlspecialchars($this->value), $this->options);
    }
}