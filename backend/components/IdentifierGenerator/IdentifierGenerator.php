<?php

namespace backend\components\IdentifierGenerator;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Widget used for inserting javascript responsible for generating identifiers.
 * Html form inputs must be created in view, which uses this Widget.
 * Inserted javascript also implements events - how is identifier generated on browser.
 * (After blur from source text, etc.)
 */
class IdentifierGenerator extends Widget
{

    public $idTextFrom; // HTML id attribute of input as source of identifier.
    public $idTextTo;   // HTML id attribute of input used as target for generated identifier.
    public $delimiter;  // Delimiter for generating of identifier.

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('identifierGenerator',[
            'idTextFrom' => $this->idTextFrom, 
            'idTextTo' => $this->idTextTo,
            'delimiter' => $this->delimiter,
        ]);
    }

}
