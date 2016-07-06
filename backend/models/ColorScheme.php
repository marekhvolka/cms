<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 29.06.16
 * Time: 17:00
 */

namespace backend\models;


class ColorScheme extends CustomModel
{
    public $label;
    public $name;
    public $template_id;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Popis',
            'name' => 'Meno',
            'template_id' => 'ID šablóny'
        ];
    }
}