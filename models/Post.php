<?php
namespace app\models;
use Yii;

class Post extends \yii\db\ActiveRecord{

    public function rules(){
      return [
        [['category_id', 'type', 'date', 'update', 'author'], 'integer'],
        [['character', 'subscribe', 'priority', 'pr', 'funny', 'status', 'comment'], 'string'],
      ];
    }

    public function attributeLabels(){
      return [
        'id' => 'ID',
        'category_id' => 'Category ID',
        'type' => 'Type',
        'character' => 'Character',
        'subscribe' => 'Subscribe',
        'priority' => 'Priority',
        'pr' => 'Pr',
        'funny' => 'Funny',
        'date' => 'Date',
        'update' => 'Update',
        'author' => 'Author',
        'status' => 'Status',
        'comment' => 'Comment',
      ];
    }
}
