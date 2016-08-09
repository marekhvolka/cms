<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 02.08.16
 * Time: 17:17
 */

namespace backend\models;

use Yii;

abstract class VariableValue extends CustomModel
{
    /** Vrati hodnotu premennej - determinuje, z ktoreho stlpca ju ma tahat
     * @param Product $product
     * @return mixed|string
     */
    public function getValue($product = null)
    {
        $value = null;

        switch ($this->var->type->identifier) {
            case 'list' :
                $value = 'array(';
                $index = 0;

                foreach ($this->listItems as $listItem) {
                    if ($listItem->active) {
                        $value .= '\'' . $index++ . '\' => ' . $listItem->getValue($product) . ', ' . PHP_EOL;
                    }
                }

                $value .= ')';

                break;

            case 'bool' :
                $value = $this->value_text == 1 ? 'true' : 'false';

                break;
            case 'page' :
                $value = isset($this->valuePage) ? '$portal->pages->page' . $this->valuePage->id : 'NULL';
                break;

            case 'product' :
                $value = isset($this->valueProduct) ? '$' . $this->valueProduct->identifier : 'NULL';
                break;

            case 'product_var' :
                $value = isset($this->valueProductVar) ? '\'' . $this->valueProductVar->identifier . '\'' : 'NULL';
                break;

            case 'product_tag' :
                $value = $this->valueTag ? '$tags->' . $this->valueTag->identifier : 'NULL';
                break;

            case 'dropdown' :
                if (!isset($this->valueDropdown)) {
                    $this->value_dropdown_id = $this->var->defaultValue->valueDropdown->id;
                    $this->save();

                    $value = '\'' . $this->var->defaultValue->valueDropdown->value . '\'';
                } else {
                    $value = '\'' . $this->valueDropdown->value . '\'';
                }
                break;

            case 'product_snippet' :
            case 'portal_snippet' :
                $value = $this->valueBlock->compileBlock();
                break;
            case 'number' :
                if (isset($this->value_text) && $this->value_text != '') {
                    $varValue = Yii::$app->dataEngine->normalizeString($this->value_text);
                } else {
                    $defaultValue = $this->var->getDefaultValue($product);
                    $varValue = isset($defaultValue) ? Yii::$app->dataEngine->normalizeString($defaultValue->value) : '';
                }

                $varValue = html_entity_decode($varValue);
                $varValue = str_replace(' ', '&nbsp;', number_format($varValue, strlen(substr(strrchr($varValue, ','), 1)), ',', ' '));
                $value = '\'' . $varValue . '\'';

                break;
            default:
                if (isset($this->value_text) && $this->value_text != '') {
                    $varValue = $this->value_text;
                } else {
                    $defaultValue = $this->var->getDefaultValue($product);
                    $varValue = isset($defaultValue) ? $defaultValue->value : '';
                }

                $value = '\'' . html_entity_decode(Yii::$app->dataEngine->normalizeString(($varValue))) . '\'';
        }

        return $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValuePage()
    {
        return $this->hasOne(Page::className(), ['id' => 'value_page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'value_tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueProductVar()
    {
        return $this->hasOne(ProductVar::className(), ['id' => 'value_product_var_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueDropdown()
    {
        return $this->hasOne(SnippetVarDropdown::className(), ['id' => 'value_dropdown_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'value_product_id']);
    }

    public function setValueBlock($value) { $this->valueBlock = $value; }

    /** Getter for $typeName property
     * @return string
     */
    public function getTypeName() { return $this->var->type->identifier; }
}