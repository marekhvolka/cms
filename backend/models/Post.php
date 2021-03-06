<?php

namespace backend\models;

use common\models\User;
use Exception;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property string $published_at
 * @property string $image
 * @property string $perex
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $last_edit
 * @property integer $last_edit_user
 * @property integer $active
 * @property integer $post_category_id
 * @property integer $post_type_id
 * @property bool $in_sitemap
 * @property bool $outdated
 * @property bool $soft_outdated
 *
 * @property Area[] $areas
 * @property User $lastEditUser
 * @property PostTag[] $tags
 * @property PostCategory $postCategory
 * @property PostType $postType
 * @property SnippetVarValue[] $snippetVarValues
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
            [['name', 'identifier', 'portal_id', 'post_category_id', 'post_type_id', 'in_sitemap'], 'required'],
            [['portal_id', 'last_edit_user', 'active', 'post_category_id', 'post_type_id', 'in_sitemap'], 'integer'],
            [['published_at', 'last_edit'], 'safe'],
            [['perex', 'image', 'description', 'keywords'], 'string'],
            [['name', 'identifier', 'title'], 'string', 'max' => 255],
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
            'post_category_id' => 'Kategória',
            'post_type_id' => 'Typ',
            'image' => 'Hlavný obrázok',
            'identifier' => 'Identifikátor',
            'portal_id' => 'Portal ID',
            'published_at' => 'Publikovaný dňa',
            'perex' => 'Perex',
            'title' => 'Titulok',
            'description' => 'Popis',
            'keywords' => 'Kľúčové slová',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User',
            'active' => 'Aktívny',
            'in_sitemap' => 'V sitemape'
        ];
    }

    public function init()
    {
        parent::init();
        $this->in_sitemap = 1;
    }

    public function getUrl()
    {
        return $this->portal->blogUrl . $this->identifier . '/';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategory()
    {
        return $this->hasOne(PostCategory::className(), ['id' => 'post_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostType()
    {
        return $this->hasOne(PostType::className(), ['id' => 'post_type_id']);
    }

    public function getTags()
    {
        return $this->hasMany(PostTag::className(), ['id' => 'post_tag_id'])
            ->viaTable('post_post_tag', ['post_id' => 'id']);
    }

    public function getSnippetVarValues()
    {
        return $this->hasMany(SnippetVarValue::className(), ['value_post_id' => 'id']);
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

        if (!file_exists($path) || $this->head_outdated) {
            try {
                $dataEngine = Yii::$app->dataEngine;

                $buffer = '<?php ' . PHP_EOL;

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
                $buffer .= '\'category\' => \'' . $this->postCategory->identifier . '\',' . PHP_EOL;

                if (isset($this->product)) {
                    $buffer .= '\'product\' => $product,' . PHP_EOL;
                }

                $buffer .= ');' . PHP_EOL;

                $buffer .= $this->cacheIdentifier . ' = new ObjectBridge($tempObject, \'post' . $this->id . '\');' . PHP_EOL;

                $buffer .= '$page = ' . $this->cacheIdentifier . ';' . PHP_EOL; //TODO: different identifier?

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

    /** Metoda, resetujuca cache podstranky po zmene
     * @param string $type
     */
    public function resetAfterUpdate($type = 'all')
    {
        $this->setOutdated();

        if ($this->isHeadChanged()) {

            $this->head_outdated = true;
            $this->save();

            $this->portal->generateSitemap();

            foreach ($this->snippetVarValues as $snippetVarValue) {
                $snippetVarValue->resetAfterUpdate();
            }
        }
    }

    /** Metoda, vracajuca, ci sa zmenila hlavicka stranky (ktora ovplyvnuje aj ine stranky - menu a podobne)
     * @return bool
     */
    public function isHeadChanged()
    {
        if (key_exists('name', $this->myOldAttributes) && $this->myOldAttributes['name'] != $this->name) {
            return true;
        }
        if (key_exists('identifier', $this->myOldAttributes) && $this->myOldAttributes['identifier'] != $this->identifier) {
            return true;
        }

        if (key_exists('published_at', $this->myOldAttributes) && $this->myOldAttributes['published_at'] != $this->published_at) {
            return true;
        }

        if (key_exists('in_sitemap', $this->myOldAttributes) && $this->myOldAttributes['in_sitemap'] != $this->in_sitemap) {
            return true;
        }

        if (key_exists('title', $this->myOldAttributes) && $this->myOldAttributes['title'] != $this->title) {
            return true;
        }

        if (key_exists('description', $this->myOldAttributes) && $this->myOldAttributes['description'] != $this->description) {
            return true;
        }

        if (key_exists('image', $this->myOldAttributes) && $this->myOldAttributes['image'] != $this->image) {
            return true;
        }

        return false;
    }

    /** Metoda, ktora vrati, ci bola podstranka zmenena (a je potrebne ju nanovo nacachovat)
     * @return bool
     */
    public function isOutdated()
    {
        return $this->outdated || $this->head_outdated;
    }

    public function updateTags()
    {
        $productId = $this->id;
        $tags = Yii::$app->request->post(Post::className());

        $tags = isset($tags['_tags']) ? $tags['_tags'] : [];

        $saved_tags = $this->getTags()->select('id')->asArray()->column();

        $to_remove = array_filter($saved_tags, function ($item) use ($tags) {
            return !in_array($item, $tags);
        });

        $to_add = array_map(function ($id) use ($productId) {
            return [
                'post_id' => $productId,
                'post_tag_id' => $id,
            ];
        }, array_filter($tags, function ($item) use ($saved_tags) {
            return !in_array($item, $saved_tags);
        }));

        if (count($to_remove) > 0) {
            (new Query())->createCommand()->delete('post_post_tag',
                ['post_id' => $this->id, 'post_tag_id' => $to_remove])->execute();
        }

        if (count($to_add) > 0) {
            (new Query())->createCommand()->batchInsert('post_post_tag', ['post_id', 'post_tag_id'],
                $to_add)->execute();
        }
    }
}
