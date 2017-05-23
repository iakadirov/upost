<?php
namespace app\models;
use Yii;

class Images extends \yii\db\ActiveRecord{
  public function rules(){
    return [
      [['date'], 'integer'],
      [['url', 'name'], 'string', 'max' => 255],
    ];
  }

  public function attributeLabels(){
    return [
      'id' => 'ID',
      'url' => 'Url',
      'name' => 'Name',
      'date' => 'Date',
    ];
  }
}
