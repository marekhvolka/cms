<?php

namespace backend\components\VarManager2;

use yii\base\Component;
use yii\base\Widget;
use yii\captcha\Captcha;

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
    
    public $form;
    
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
            'form' => $this->form,
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
