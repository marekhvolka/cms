<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "snippet".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $last_edit
 * @property integer $last_edit_user
 * @property bool $outdated
 *
 * @property User $lastEditUser
 * @property SnippetCode[] $snippetCodes
 * @property SnippetVar[] $snippetFirstLevelVars
 * @property SnippetVar[] $snippetVariables
 * @property Portal[] $portals
 */
class Snippet extends CustomModel implements ICacheable
{
    #region BASIC MODEL

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string'],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Názov',
            'description' => 'Popis snippetu',
            'last_edit' => 'Posledná zmena',
            'last_edit_user' => 'Naposledy editoval',
        ];
    }

    #endregion

    #region GETTERS & SETTERS

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetCodes()
    {
        if (!isset($this->snippetCodes)) {
            $this->snippetCodes = $this->hasMany(SnippetCode::className(), ['snippet_id' => 'id'])->all();
        }

        return $this->snippetCodes;
    }

    public function setSnippetCodes($value) { $this->snippetCodes = $value; }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVariables()
    {
        return $this->hasMany(SnippetVar::className(), ['snippet_id' => 'id']);
    }

    public function getPortals()
    {
        return $this->hasMany(Portal::className(), ['id' => 'portal_id'])
            ->viaTable('snippet_portal', ['snippet_id' => 'id']);
    }

    /**
     * SnippetVars with no parents (first level - not nested).
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetFirstLevelVars()
    {
        if (!isset($this->snippetFirstLevelVars)) {
            $this->snippetFirstLevelVars = $this->getSnippetVariables()->where(['parent_id' => null])->all();
        }

        return $this->snippetFirstLevelVars;
    }

    public function setSnippetFirstLevelVars($value) { $this->snippetFirstLevelVars = $value; }

    #endregion

    #region CACHING

    /** Vrati cestu k adresaru, kde su ulozene nacachovane veci k snippetu
     * @return string
     */
    public function getMainDirectory()
    {
        $path = Yii::$app->dataEngine->getSnippetsDirectory() . 'snippet' . $this->id . '/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /** Metoda na vratenie cesty k hlavnemu suboru pre dany snippet (obsahuje premenne snippetu
     * s default hodnotami a nastavenia snippetu)
     * @param bool $reload
     * @return string
     * @throws
     */
    public function getMainCacheFile($reload = false)
    {
        $path = $this->getMainDirectory() . 'snippet.php';

        if (!file_exists($path) || $this->outdated || $reload) {

            try {
                $dataEngine = Yii::$app->dataEngine;

                $buffer = '<?php ' . PHP_EOL;

                $buffer .= '$tempObject = (object) array(' . PHP_EOL;

                foreach ($this->snippetFirstLevelVars as $snippetVar) {
                    $buffer .= '\'' . $snippetVar->identifier . '\' => ' . $snippetVar->getDefaultValueAsString() . ',' . PHP_EOL;
                }

                $buffer .= ');' . PHP_EOL;

                $buffer .= '$snippet = new ObjectBridge($tempObject, \'snippet' . $this->id . '\');' . PHP_EOL;

                $buffer .= '?>' . PHP_EOL;

                $dataEngine->writeToFile($path, 'w+', $buffer);
                $this->setActual();
            } catch (Exception $exception) {
                $this->logException($exception, 'snippet');
            }
        }

        return $path;
    }

    public function resetAfterUpdate()
    {
        $changed = false;

        if ($this->isChanged() || $this->snippetVarsHasChanged()) {
            $this->setOutdated();
            $this->getMainCacheFile();
            $changed = true;
        }
        /* @var $snippetCode \backend\models\SnippetCode */
        foreach ($this->snippetCodes as $snippetCode) {
            if ($snippetCode->isChanged() || $changed) {
                $snippetCode->resetAfterUpdate();
            }
        }
    }

    public function snippetVarsHasChanged()
    {
        foreach ($this->snippetFirstLevelVars as $snippetVar) {
            if ($snippetVar->isChanged()) {
                return true;
            }
        }

        return false;
    }

    #endregion

    /** Metoda na nacitanie potomkovskych poloziek - obsahuje rekurziu
     * @param $propertyIdentifier
     * @param $data
     */
    public function loadChildren($propertyIdentifier, $data)
    {
        foreach ($data as $index => $item) {
            $this->loadFromData($propertyIdentifier, $item, $index, SnippetVar::className());

            if (key_exists('SnippetVarDefaultValue', $item)) {
                foreach ($item['SnippetVarDefaultValue'] as $indexDefaultValue => $defaultValue) {
                    $this->{$propertyIdentifier}[$index]->loadFromData('defaultValues', $defaultValue,
                        $indexDefaultValue, SnippetVarDefaultValue::className());
                }
            }

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
        /* @var $childModel CustomModel */
        foreach ($this->{$propertyIdentifier} as $childModel) {

            if ($childModel->removed) {
                $childModel->delete();
                continue;
            }

            $childModel->snippet_id = $this->id;

            $childModel->validateAndSave();

            /* @var $defaultValue SnippetVarDefaultValue */
            foreach ($childModel->defaultValues as $defaultValue) {
                $defaultValue->snippet_var_id = $childModel->id;

                if ($defaultValue->removed) {
                    $defaultValue->delete();
                    continue;
                }

                $defaultValue->validateAndSave();
            }

            $childModel->saveChildren('children', $globalParentPropertyIdentifier);
        }
    }

    public function assignPortal($portalId)
    {
        $query = 'INSERT IGNORE INTO snippet_portal (snippet_id, portal_id) VALUES (:snippet_id, :portal_id)';

        $command = Yii::$app->db->createCommand($query);
        $command->bindValue(':portal_id', $portalId);
        $command->bindValue(':snippet_id', $this->id);

        $command->execute();
    }

    /**
     * Metoda na zrusenie priradenia vsetkych portalov UGLY
     */
    public function removeAssignedPortals()
    {
        $query = 'DELETE FROM snippet_portal WHERE snippet_id = :snippet_id';

        $command = Yii::$app->db->createCommand($query);
        $command->bindValue(':snippet_id', $this->id);

        $command->execute();
    }
}
