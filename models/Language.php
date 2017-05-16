<?php

namespace app\models;

use Yii;

class Language extends \yii\db\ActiveRecord{
  public function rules(){
    return [
      [['code'], 'string', 'max' => 3],
      [['code_seo'], 'string', 'max' => 7],
      [['title'], 'string', 'max' => 50],
    ];
  }

  public static function getAllLangs(){
    $all =  self::find()->select('id, code, title')->asArray()->all();
    $arr = [];
    foreach ($all as $lang) {
      $arr[$lang['id']] = ['code'=>$lang['code'],'title'=>$lang['title']];
    }
    return $arr;
  }

  public function attributeLabels(){
    return [
      'id' => 'ID',
      'code' => 'Code',
      'code_seo' => 'Code Seo',
      'title' => 'Title',
    ];
  }
}
