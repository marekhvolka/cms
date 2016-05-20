<?php

namespace backend\components\VarManager2;

use yii\base\Widget;

class VarManagerWidget extends Widget
{
    /** Objekt, ktoremu premenne priradujeme (portal, produkt
     * @var
     */
    public $model;

    /** Zoznam priradenych premenných
     * @var
     */
    public $assignedVariableValues;

    /** Zoznam všetkých premenných
     * @var
     */
    public $allVariables;

    /** Nazov triedy (modelu), ktory reprezentuje vyplnenu premennu
     * @var string
     */
    public $variableValueClassName;
    
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
            'model' => $this->model,
            'assignedVariableValues' => $this->assignedVariableValues,
            'allVariables' => $this->allVariables,
            'appendVarValueUrl' => $this->appendVarValueUrl,
            'variableValueClassName' => $this->variableValueClassName,
        ]);
    }

    /** Metoda na vyrendrovanie sablony pre jednu vyplnenu premennu
     * @return string
     */
    public function appendVariableValue($varValue, $type)
    {
        $type = \yii\helpers\StringHelper::basename($type);
        return $this->render('_variableValue', ['varValue' => $varValue, 'type' => $type]);
    }

}
