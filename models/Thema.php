<?php
namespace app\models;
use Yii;
class Thema extends \yii\db\ActiveRecord{
  public function rules(){
    return [
      [['date','update'], 'integer'],
    ];
  }

  public function getContent(){
    return $this->hasOne(ThemaContent::classname(),['thema_id' => 'id'])->where(['thema_content.language'=>Yii::$app->params['admin_lang']]);
  }

  public function getContents(){
    return $this->hasMany(ThemaContent::classname(),['thema_id' => 'id'])->indexBy('language');
  }

  public function getPosts(){
    return $this->hasMany(Post::classname(),['thema_id'=>'id']);
  }

  public function getPostsCount(){
    return  $this->getPosts()
        ->select(['thema_id', 'counted' => 'count(*)'])
        ->groupBy('thema_id')
        ->asArray(true);
  }
}
