<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "post_tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 *
 * @property Post[] $posts
 */
class PostTag extends CustomModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'identifier'], 'required'],
            [['name', 'identifier'], 'string', 'max' => 45],
            [['name'], 'unique'],
            [['identifier'], 'unique'],
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
            'identifier' => 'Identifikátor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['id' => 'post_id'])->viaTable('post_post_tag', ['post_tag_id' => 'id']);
    }
}
