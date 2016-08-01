<?php
namespace backend\components\AceEditor;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * ACE Widget
 */
class AceEditorWidget extends InputWidget
{
    public static $lastId = 0;

    /** @var string */
    public $varNameAceEditor;
    /** @var string */
    public $mode = 'php';
    /** @var string */
    public $theme = 'github';
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
        $this->id = AceEditorWidget::$lastId++;
        if ($this->varNameAceEditor == null) {
            $this->varNameAceEditor = 'aceEditor';

            if (AceEditorWidget::$lastId > 1) {
                $this->varNameAceEditor .= AceEditorWidget::$lastId;
            }
        }
        $this->extensions[] = 'static_highlight';
        if ($this->autocompletion) {
            $this->extensions[] = 'language_tools';
        }
        AceEditorAsset::register($this->view, $this->extensions);
        return $this->editable();
    }

    protected function editable()
    {
        $id = 'ace-editor-' . $this->varNameAceEditor;
        $valueId = 'ace-editor-value' . $this->varNameAceEditor;
        $autocompletion = $this->autocompletion ? 'true' : 'false';
        if ($this->autocompletion) {
            $this->aceOptions['enableBasicAutocompletion'] = true;
            $this->aceOptions['enableSnippets'] = true;
            $this->aceOptions['enableLiveAutocompletion'] = false;
        }
        $aceOptions = Json::encode($this->aceOptions);
        $js = <<<JS
(function(){
    aceEditorAutocompletion = {$autocompletion};
    if (aceEditorAutocompletion) {
        ace.require("ace/ext/language_tools");
    }
    {$this->varNameAceEditor} = ace.edit("{$id}");
    {$this->varNameAceEditor}.setTheme("ace/theme/{$this->theme}");
    {$this->varNameAceEditor}.getSession().setMode("ace/mode/{$this->mode}");
    {$this->varNameAceEditor}.setOptions({$aceOptions});

    var textarea = $('#{$valueId}').hide();
        {$this->varNameAceEditor}.getSession().setValue(textarea.val());
        {$this->varNameAceEditor}.getSession().on('change', function(){
        textarea.val({$this->varNameAceEditor}.getSession().getValue());
    });
})();
JS;
        $view = $this->getView();

        $div = Html::beginTag('div', ['id' => $id]) . Html::endTag('div');
        $options = array_merge($this->options, ['id' => $valueId]);

        if ($this->hasModel()) {
            $result = $div . Html::activeTextarea($this->model, $this->attribute, $options);
        } else {
            $result = $div . Html::textarea($this->name, $this->value, $options);
        }

        $code = "\nvar {$this->varNameAceEditor} = {};\n";
        if (Yii::$app->request->isAjax) {
            $result .= '<script type="text/javascript">'. $code . $js . '</script>';
        } else {
            $view->registerJs($code, $view::POS_HEAD);
            $view->registerJs($js);
        }

        return $result;
    }
}