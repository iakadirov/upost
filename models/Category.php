<?php
namespace app\models;
use Yii;
class Category extends \yii\db\ActiveRecord{
  public function rules(){
    return [
      [['parent_id','date','update'], 'integer'],
    ];
  }

  public function getContent(){
    return $this->hasOne(CategoryContent::classname(),['category_id' => 'id'])->where(['category_content.language'=>Yii::$app->params['admin_lang']]);
  }

  public function getContents(){
    return $this->hasMany(CategoryContent::classname(),['category_id' => 'id'])->indexBy('language');
  }

  public function getPosts(){
    return $this->hasMany(Post::classname(),['category_id'=>'id']);
  }

  public function getPostsCount(){
    return  $this->getPosts()
        ->select(['category_id', 'counted' => 'count(*)'])
        ->groupBy('category_id')
        ->asArray(true);
  }

  public function attributeLabels(){
    return [
      'id' => 'ID',
      'parent_id' => 'Parent ID',
    ];
  }
}
