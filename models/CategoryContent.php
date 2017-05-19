<?php
namespace app\models;
use Yii;
class CategoryContent extends \yii\db\ActiveRecord{
  public function rules(){
    return [
      [['category_id'], 'required'],
      [['category_id', 'language'], 'integer'],
      [['content'], 'string'],
      [['name'], 'string', 'max' => 255],
    ];
  }

  public function attributeLabels(){
    return [
      'id' => 'ID',
      'category_id' => 'Category ID',
      'language' => 'Language',
      'name' => 'Name',
      'content' => 'Content',
    ];
  }
}