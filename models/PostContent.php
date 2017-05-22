<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_content".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $language
 * @property string $name
 * @property string $excerpt
 * @property string $content
 * @property integer $image
 */
class PostContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'language', 'image'], 'integer'],
            [['excerpt', 'content'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'language' => 'Language',
            'name' => 'Name',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'image' => 'Image',
        ];
    }
}
