<?php

namespace backend\components\VarManager2;

use yii\base\Component;
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
     * @var
     */
    public $variableValueClassName;
    
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
        ]);
    }

    /** Metoda na vyrendrovanie sablony pre jednu vyplnenu premennu
     * @return string
     */
    public function appendVariableValue($varValue)
    {
        return $this->render('_variableValue', ['varValue' => $varValue]);
    }

}
