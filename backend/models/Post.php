<?php

namespace backend\models;

use common\models\User;
use Exception;
use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property integer $portal_id
 * @property string $published_at
 * @property string $image
 * @property string $perex
 * @property string $last_edit
 * @property integer $last_edit_user
 * @property integer $active
 *
 * @property Area[] $areas
 * @property User $lastEditUser
 * @property Portal $portal
 * @property PostTag[] $tags
 *
 * @property string $cacheIdentifier
 */
class Post extends LayoutOwner
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'identifier', 'portal_id'], 'required'],
            [['portal_id', 'last_edit_user', 'active'], 'integer'],
            [['published_at', 'last_edit'], 'safe'],
            [['perex', 'image'], 'string'],
            [['name', 'identifier'], 'string', 'max' => 255],
            [['last_edit_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_edit_user' => 'id']],
            [['portal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['portal_id' => 'id']],
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
            'image' => 'Hlavný obrázok',
            'identifier' => 'Identifikátor',
            'portal_id' => 'Portal ID',
            'published_at' => 'Publikovaný dňa',
            'perex' => 'Perex',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User',
            'active' => 'Aktívny',
        ];
    }

    public function getUrl()
    {
        return $this->portal->blogUrl . '/' . $this->identifier . '/';
    }

    public function getTags()
    {
        return $this->hasMany(PostTag::className(), ['id' => 'post_id'])
            ->viaTable('post_post_tag', ['post_tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['post_id' => 'id']);
    }

    /** Metoda vrati identifikator pre potreby cache
     * @return string
     */
    public function getCacheIdentifier() { return '$post' . $this->id; }

    /** Vrati cestu k suboru, v ktorom su ulozene premenne podstranky (hlavicka)
     * @return string
     */
    public function getVarCacheFile()
    {
        $path = $this->getMainDirectory() . 'post_var.php';

        if (!file_exists($path) || $this->outdated || $this->head_outdated) {
            try {
                $dataEngine = Yii::$app->dataEngine;

                $buffer = '<?php ' . PHP_EOL;

                if (isset($this->product)) {
                    $buffer .= '$product = $' . $this->product->identifier . ';' . PHP_EOL;
                } else if (isset($this->parent)) {
                    $buffer .= '$product = $portal->pages->page' . $this->parent->id . '->product' . ';' . PHP_EOL;
                } else {
                    $buffer .= '$emptyProduct = (object) array();' . PHP_EOL;
                    $buffer .= '$product = new ObjectBridge($emptyProduct, \'\');' . PHP_EOL;
                }
                $buffer .= '$tempObject = (object) array(' . PHP_EOL;

                $buffer .= '\'id\' => ' . $this->id . ',' . PHP_EOL;
                $buffer .= '\'url\' => \'' . $dataEngine->normalizeString($this->url) . '\',' . PHP_EOL;
                $buffer .= '\'name\' => \'' . $dataEngine->normalizeString($this->name) . '\',' . PHP_EOL;
                $buffer .= '\'title\' => \'' . $dataEngine->normalizeString($this->title) . '\',' . PHP_EOL;
                $buffer .= '\'description\' => \'' . $dataEngine->normalizeString($this->description) . '\',' . PHP_EOL;
                $buffer .= '\'keywords\' => \'' . $dataEngine->normalizeString($this->keywords) . '\',' . PHP_EOL;
                $buffer .= '\'active\' => ' . $this->active . ',' . PHP_EOL;
                $buffer .= '\'perex\' => \'' . $this->perex . '\',' . PHP_EOL;
                $buffer .= '\'image\' => \'' . $this->image . '\',' . PHP_EOL;
                $buffer .= '\'published_at\' => \'' . $this->published_at . '\',' . PHP_EOL;

                if (isset($this->product)) {
                    $buffer .= '\'product\' => $product,' . PHP_EOL;
                }

                $buffer .= ');' . PHP_EOL;

                $buffer .= $this->cacheIdentifier . ' = new ObjectBridge($tempObject, \'post' . $this->id . '\');' . PHP_EOL;

                $buffer .= '$post = ' . $this->cacheIdentifier . ';' . PHP_EOL;

                $buffer .= '?>';

                $dataEngine->writeToFile($path, 'w+', $buffer);
                $this->head_outdated = 0;
                $this->save();
                $this->removeException();
            } catch (Exception $exception) {
                $this->logException($exception, 'post_var');
            }
        }

        return $path;
    }

    public function resetAfterUpdate()
    {
        // TODO: Implement resetAfterUpdate() method.
    }
}
