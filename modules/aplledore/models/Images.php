<?php

namespace app\modules\aplledore\models;

use Yii;

class Images extends \yii\db\ActiveRecord{
  public $imageFile;

  public function rules(){
    return [
      [['date'], 'integer'],
      [['url'], 'string', 'max' => 255],
      [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
    ];
  }

  public static function getImagesList($offset=NULL,$limit = 2){
    if($offset){
      $content['content'] = self::find()->offset($offset)->limit($limit)->asArray()->all();
    }else{
      $content['count'] = self::find()->limit($limit)->count();
      $content['content'] = self::find()->limit($limit)->asArray()->all();
    }
    return $content;
  }

  public function attributeLabels(){
    return [
      'id' => 'ID',
      'url' => 'Url',
      'date' => 'Date',
    ];
  }
}