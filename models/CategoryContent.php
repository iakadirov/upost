<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_content".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $language
 * @property string $name
 * @property string $content
 * @property integer $image
 */
class CategoryContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'language', 'image'], 'integer'],
            [['content'], 'string'],
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
            'category_id' => 'Category ID',
            'language' => 'Language',
            'name' => 'Name',
            'content' => 'Content',
            'image' => 'Image',
        ];
    }
}
