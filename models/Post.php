<?php
namespace app\models;
use Yii;

class Post extends \yii\db\ActiveRecord{
  const POST_TYPE_NEWS = 1;
  const POST_COMMENT_DATA_DAY = 86400;
  const POST_COMMENT_DATA_WEEK = 604800;
  const POST_COMMENT_DATA_MONTH = 2678400;
  const POST_COMMENT_DATA_YEAR = 31536000;

  public function rules(){
    return [
      [['category_id','thema_id','author_id', 'type', 'date', 'update', 'update_author_id', 'comment_end_date','pr_end_date','character', 'subscribe', 'priority', 'pr', 'funny', 'status', 'comment'], 'integer'],
    ];
  }

  public static function getCommentEndDate($num){
    if($num==1) return time()+self::POST_COMMENT_DATA_DAY;
    if($num==2) return time()+self::POST_COMMENT_DATA_WEEK;
    if($num==3) return time()+self::POST_COMMENT_DATA_MONTH;
    if($num==4) return time()+self::POST_COMMENT_DATA_YEAR;
    return 0;
  }

  public function getContent(){
    return $this->hasOne(PostContent::classname(),['post_id' => 'id'])
                ->select(['post_content.name','post_content.post_id','post_content.language'])
                ->where(['post_content.language'=>Yii::$app->params['admin_lang']]);
  }

  public function getContents(){
    return $this->hasOne(PostContent::classname(),['post_id' => 'id']);
  }

  public function getTags(){
    return $this->hasMany(PostTag::classname(),['post_id' => 'id'])->with('tags');
  }

  public function getCategory(){
    return $this->hasOne(CategoryContent::classname(),['category_id' => 'category_id'])
                ->select(['category_content.name','category_content.category_id','category_content.language'])
                ->where(['category_content.language'=>Yii::$app->params['admin_lang']]);
  }

  public function getCreator(){
    return $this->hasOne(User::classname(),['id' => 'author_id'])
                ->select(['user.username','user.id','user.type']);
  }

  public function getEditor(){
    return $this->hasOne(User::classname(),['id' => 'update_author_id'])
                ->select(['user.username','user.id','user.type']);
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
