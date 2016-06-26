<?php

namespace backend\components\SnippetManager;

use backend\models\SnippetVarValue;
use yii\base\Widget;

class SnippetManagerWidget extends Widget
{
    /** All variables assigned before.
     * @var
     */
    public $assignedVariableValues;

    /** List of all variables.
     * @var
     */
    public $allVariables;

    /**
     * Url of controller, which is using whis widget for dynamic
     * append of new row (variable).
     * @var string
     */
    public $appendVarValueUrl;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        AssetBundle::register($this->getView());

        return $this->render('variableWidget', [
            'assignedVariableValues' => $this->assignedVariableValues,
            'allVariables' => $this->allVariables,
            'appendVarValueUrl' => $this->appendVarValueUrl
        ]);
    }

    /** Renders view for one appended variable.
     * @param $varValue
     * @return string
     */
    public function appendVariableValue($varValue)
    {
        return $this->render('_variableValue', ['varValue' => $varValue]);
    }

}
