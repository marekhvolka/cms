<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 21.06.16
 * Time: 18:10
 */

namespace backend\models;

/**
 * @property bool $existing Indicates if model already exists.
 * @property bool $removed Indicates if model has to be removed
 * @property bool $outdated
 */

use backend\controllers\BaseController;
use Yii;

class CustomModel extends \yii\db\ActiveRecord
{
    public $removed = true;

    public $myOldAttributes = array();

    public function load($data, $formName = null)
    {
        $this->removed = false;
        $this->myOldAttributes = $this->getAttributes();
        return parent::load($data, $formName); // TODO: Change the autogenerated stub
    }

    /** Metoda, ktora nacita hodnoty atributov polozky $item do pola $arrayProperty na indexe $index
     * ak polozka neexistuje na danom indexe, tak prida do pola novu
     * @param $arrayProperty - identifikator pre pole, do ktoreho pridavame polozky
     * @param $item
     * @param $index
     * @param $modelClassName
     */
    public function loadFromData($arrayProperty, $item, $index, $modelClassName)
    {
        if (empty($this->{$arrayProperty}[$index])) {
            $this->{$arrayProperty}[$index] = new $modelClassName();
        }

        $this->{$arrayProperty}[$index]->load($item, '');
        $this->{$arrayProperty}[$index]->removed = false;
    }

    /** Metoda na nacitanie potomkovskych poloziek - obsahuje rekurziu
     * @param $propertyIdentifier
     * @param $data
     */
    public function loadChildren($propertyIdentifier, $data)
    {
        foreach ($data as $index => $item) {
            $this->loadFromData($propertyIdentifier, $item, $index,
                SnippetVar::className());

            if (key_exists('Children', $item)) {
                $this->{$propertyIdentifier}[$index]->loadChildren('children', $item['Children']);
            }
        }
    }

    /**
     * Metoda na ulozenie potomkovskych poloziek - rekurzia v pripade ze potomok ma dalsich potomkov
     * @param $propertyIdentifier - identifikator zoznamu, ktory obsahuje potomkov
     * @param $globalParentPropertyIdentifier - identifikator globalneho rodicovskeho atributu (block_id, portal_id)
     * @throws \yii\base\Exception
     */
    public function saveChildren($propertyIdentifier, $globalParentPropertyIdentifier)
    {
        foreach ($this->{$propertyIdentifier} as $childModel) {
            $childModel->parent_id = $this->id;

            $childModel->{$globalParentPropertyIdentifier} = $this->{$globalParentPropertyIdentifier};

            if ($childModel->removed) {
                $childModel->delete();
                continue;
            }

            if (!($childModel->validate() && $childModel->save())) {
                throw new \yii\base\Exception;
            }

            $childModel->saveChildren('children', $globalParentPropertyIdentifier);
        }
    }

    public function logException($exception, $type)
    {
        $systemException = new SystemException();
        $systemException->type = $type;

        if (property_exists($exception, 'sourceCode'))
            $systemException->source_code = $exception->sourceCode;
        $systemException->source_name = $exception->getFile();
        $systemException->message = $exception->getMessage();

        switch ($this->className()) {
            case Product::className() :
                $systemException->product_id = $this->id;

                break;

            case Portal::className() :
                $systemException->portal_id = $this->id;

                break;

            case Page::className() :
                $systemException->page_id = $this->id;

                break;

            case Block::className() :
                $systemException->block_id = $this->id;

                break;
        }

        $systemException->save();

        if (BaseController::$develop) {
            throw $exception;
        }
    }

    public function removeException()
    {
        switch ($this->className()) {
            case Product::className() :
                SystemException::deleteAll(['product_id' => $this->id]);

                break;

            case Portal::className() :
                SystemException::deleteAll(['portal_id' => $this->id]);

                break;

            case Page::className() :
                SystemException::deleteAll(['page_id' => $this->id]);

                break;

            case Block::className() :
                SystemException::deleteAll(['block_id' => $this->id]);

                break;
        }
    }

    /**
     * Event fired before save model. User id is set as last user who edits model.
     * @param bool $insert true if save is insert type, false if update.
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (property_exists($this, 'last_edit_user')) {
            $userId = Yii::$app->user->identity->id;
            $this->last_edit_user = $userId;
        }
        return parent::beforeSave($insert);
    }

    public function setOutdated()
    {
        $this->outdated = 1;
        $this->save();
    }

    public function setActual()
    {
        $this->outdated = 0;
        $this->save();
        $this->removeException();
    }

    public function isChanged()
    {
        foreach($this->myOldAttributes as $index => $oldAttribute) {
            if ($oldAttribute != $this->{$index} && $index != 'last_edit' && $index != 'last_edit_user') {
                return true;
            }
        }
        return false;
    }
}