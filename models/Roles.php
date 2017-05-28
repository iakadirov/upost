<?php
namespace app\models;
use Yii;
class Roles extends \yii\db\ActiveRecord{
  public function rules(){
    return [
      [['controller', 'action'], 'string', 'max' => 20],
      [['description'], 'string', 'max' => 255],
    ];
  }

  public function attributeLabels(){
    return [
      'id' => 'ID',
      'controller' => 'Controller',
      'action' => 'Action',
    ];
  }
}
