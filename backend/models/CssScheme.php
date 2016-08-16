<?php

namespace backend\models;

/**
 * Class CssScheme
 * @package backend\models
 *
 * @property Template $template
 *
 */

class CssScheme extends CustomModel
{
    public $name;
    public $template_id;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Meno',
            'template_id' => 'ID šablóny'
        ];
    }

    public function getPath()
    {
        return $this->getTemplate()->getCssSchemeDirectoryPath(true) . $this->name;
    }

    /**
     * @return Template
     */
    public function getTemplate()
    {
        return Template::findOne($this->template_id);
    }
}