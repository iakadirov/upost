<?php
namespace app\models;
use Yii;

class PostTag extends \yii\db\ActiveRecord{
  public function rules(){
    return [
      [['post_id', 'tag_id'], 'integer'],
    ];
  }

  public function getTags(){
    return $this->hasOne(Tag::classname(),['id' => 'tag_id']);
  }

  public function attributeLabels(){
    return [
      'post_id' => 'Post ID',
      'tag_id' => 'Tag ID',
    ];
  }
}