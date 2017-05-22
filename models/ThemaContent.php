<?php
namespace app\models;
use Yii;
class ThemaContent extends \yii\db\ActiveRecord{
  public function rules(){
    return [
      [['thema_id'], 'required'],
      [['thema_id', 'language'], 'integer'],
      [['name'], 'string', 'max' => 255],
    ];
  }

  public function attributeLabels(){
    return [
      'id' => 'ID',
      'thema_id' => 'Category ID',
      'language' => 'Language',
      'name' => 'Name',
    ];
  }
}