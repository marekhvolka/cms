<?php

namespace backend\components\VarManager;

use backend\models\SnippetVarValue;
use yii\base\Widget;

class VarManagerWidget extends Widget
{
    /** All variables assigned before.
     * @var
     */
    public $assignedVariableValues;

    /** List of all variables.
     * @var
     */
    public $allVariables;

    public $model;
    
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
            'appendVarValueUrl' => $this->appendVarValueUrl,
            'model' => $this->model,
            'prefix' => 'Var'
        ]);
    }

    /** Renders view for one appended variable.
     * @param $varValue
     * @param $prefix
     * @param $indexVar
     * @param $model
     * @return string
     */
    public function appendVariableValue($varValue, $prefix, $indexVar, $model)
    {
        return $this->render('_variableValue', [
            'varValue' => $varValue,
            'prefix' => $prefix . "[$indexVar]",
            'model' => $model,
            'renderModal' => true,
        ]);
    }
}
