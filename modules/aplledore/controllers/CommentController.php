<?php
namespace app\modules\aplledore\controllers;
use Yii;
use app\modules\aplledore\models\AplledoreComment;
use app\components\IdevFunctions;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\models\Comment;
use app\models\PostContent;
use app\models\User;

class CommentController extends DevController{
  public function actionIndex() {
  	$this->view->title = Yii::t('idev','Comment');
    $query = Comment::find();
    $count = clone $query;
    $pages = new Pagination(['totalCount' => $count->count(), 'pageSize' => 20]);
    $pages->pageSizeParam = false;
    $this->data['pages'] = $pages;
    $this->data['content'] = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();
    $ids = [];
    $post = [];
    foreach ($this->data['content'] as $item) {
      $ids[$item['user_id']] = $item['user_id'];
      $post[$item['post_id']] = $item['post_id'];
    }
    $this->data['users'] = User::find()->select('id,username,first_name,last_name')->where(['in','id', $ids])->indexBy('id')->asArray()->all();
    $this->data['post'] = PostContent::find()->select(['post_id','language','name'])->where(['in','post_id',$post])->indexBy('post_id')->asArray()->all();
    return $this->template('index');
  }

  public function actionDelete($id) {
    if (AplledoreComment::deleteThema($id)) {
      Yii::$app->session->setFlash('success',Yii::t('idev','thema is deleted'));
    }else{
      Yii::$app->session->setFlash('error',Yii::t('idev','thema is no deleted'));
    }
    $this->redirect(['index']);
  }
}
