<?php
namespace app\models;
use Yii;
class Comment extends \yii\db\ActiveRecord{
  public function rules(){
    return [
      [['parent_id', 'replay_id', 'post_id', 'user_id', 'date'], 'integer'],
      [['replay_id', 'post_id', 'user_id', 'content', 'date'], 'required'],
      [['content', 'status'], 'string'],
    ];
  }

  public function getChilds(){
    return $this->hasMany(self::classname(),['parent_id' => 'id']);
  }

  public function attributeLabels(){
    return [
      'id' => 'ID',
      'parent_id' => 'Parent ID',
      'replay_id' => 'Replay ID',
      'post_id' => 'Post ID',
      'user_id' => 'User ID',
      'content' => 'Content',
      'date' => 'Date',
      'status' => 'Status',
    ];
  }
}