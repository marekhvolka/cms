<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property string $type
 * @property integer $page_id
 * @property integer $post_id
 * @property integer $portal_id
 * @property integer $active
 * @property integer $size
 * @property bool $outdated
 *
 * @property Page $page
 * @property Post $post
 * @property Portal $portal
 * @property Section[] $sections
 */
class Area extends CustomModel implements IDuplicable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        $this->active = 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'active'], 'required'],
            [['page_id', 'post_id', 'portal_id', 'active', 'size'], 'integer'],
            [['type'], 'string', 'max' => 10],
            [
                ['type', 'portal_id', 'page_id', 'post_id'],
                'unique',
                'targetAttribute' => ['type', 'portal_id', 'page_id', 'post_id'],
                'message' => 'The combination of Type, Page ID, Post ID and Portal ID has already been taken.'
            ],
            [
                ['page_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Page::className(),
                'targetAttribute' => ['page_id' => 'id']
            ],
            [
                ['post_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Post::className(),
                'targetAttribute' => ['post_id' => 'id']
            ],
            [
                ['portal_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Portal::className(),
                'targetAttribute' => ['portal_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Typ',
            'page_id' => 'Page ID',
            'portal_id' => 'Portal ID',
            'active' => 'Aktívny',
            'size' => 'Veľkosť'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortal()
    {
        return $this->hasOne(Portal::className(), ['id' => 'portal_id']);
    }

    public function getSections()
    {
        if (!isset($this->sections)) {
            $this->sections = $this->hasMany(Section::className(), ['area_id' => 'id'])
                ->orderBy('order')
                ->all();
        }

        return $this->sections;
    }

    public function setSections($value)
    {
        $this->sections = $value;
    }

    public function getContent($reload = false)
    {
        $result = '';

        if ($this->page || $this->post) {

            $layoutOwner = $this->page ? $this->page : $this->post;
            switch ($this->type) {
                case 'header' :
                    $result = '<div id="page-header">';

                    if ($this->active) {
                        foreach ($this->sections as $section) {
                            $result .= $section->getContent($reload);
                        }
                    }

                    $result .= '</div> <!-- PageHeader end -->';

                    break;
                case 'footer' :
                    $result = '<div id="page-footer">';

                    if ($this->active) {
                        foreach ($this->sections as $section) {
                            $result .= $section->getContent($reload);
                        }
                    }

                    $result .= '</div> <!-- PageFooter end -->';
                    break;

                case 'content' :
                    if (!$layoutOwner->sidebar->active) {
                        $width = 12;
                    } else {
                        $width = 12 - $layoutOwner->sidebar->size;
                    }

                    $result = '<div id="content" class="col-md-' . $width . '">';

                    foreach ($this->sections as $section) {
                        foreach ($section->rows as $row) {
                            $result .= $row->getContent($reload);
                        }
                    }

                    $result .= '</div> <!-- Content End -->';
                    break;
                case 'sidebar' :
                    $result = '';

                    if ($this->active) {
                        $result = '<div id="sidebar" class="col-md-' . $this->size . '">';

                        foreach ($this->sections as $section) {
                            foreach ($section->rows as $row) {
                                $result .= $row->getContent($reload);
                            }
                        }

                        $result .= '</div> <!-- Sidebar End -->';
                    }
                    break;
            }

        } else if ($this->portal) {
            switch ($this->type) {
                case 'header' :

                    $result .= '<header>';

                    foreach ($this->sections as $section) {
                        $result .= $section->getContent($reload);
                    }

                    $result .= '</header>';

                    break;

                case 'footer' :

                    $result .= '<footer>';

                    foreach ($this->sections as $section) {
                        $result .= $section->getContent($reload);
                    }

                    $result .= '</footer>';

                    break;
            }
        }
        return $result;
    }

    /** Vrati cestu k suboru, v ktorom je ulozeny layout casti podstranky
     * @param bool $reload
     * @return string
     */
    public function getCacheFile($reload = false)
    {
        $path = '';

        if ($this->page) {
            $path = $this->page->getMainDirectory() . 'page_' . $this->type . '.php';
        } else if ($this->post) {
            $path = $this->post->getMainDirectory() . 'post_' . $this->type . '.php';
        } else if ($this->portal) {
            $path = $this->portal->getMainDirectory() . 'portal_' . $this->type . '.php';
        }

        if (!file_exists($path) || $this->outdated || $reload) {
            $buffer = $this->getContent($reload);

            Yii::$app->dataEngine->writeToFile($path, 'w+', $buffer);
            $this->setActual();
        }

        return $path;
    }

    public function resetAfterUpdate()
    {
        $this->setOutdated();

        if ($this->portal) {
            $this->portal->setOutdated();
        } else if ($this->page) {
            $this->page->setOutdated();
        } else if ($this->post) {
            $this->post->setOutdated();
        }
    }

    /** Vrati cestu k adresaru, v ktorom budu sablony jednotlivych blokov podstranky
     * @return string
     */
    public function getBlocksMainCacheDirectory()
    {
        $path = '';
        if ($this->page) {
            $path = $this->page->getMainDirectory();
        } else if ($this->post) {
            $path = $this->post->getMainDirectory();
        } else if ($this->portal) {
            $path = $this->portal->getMainDirectory();
        }

        $path .= 'blocks_' . $this->type . '/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    public function prepareToDuplicate()
    {
        foreach ($this->sections as $section) {
            $section->prepareToDuplicate();
        }

        unset($this->id);
        unset($this->page_id);
        unset($this->portal_id);
    }
}
