<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $type
 * @property integer $language
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'language'], 'integer'],
            [['type'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['keywords'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 170],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'type' => 'Type',
            'language' => 'Language',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
        ];
    }
}
