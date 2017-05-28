<?php
namespace app\modules\aplledore\controllers;
use Yii;
use app\modules\aplledore\models\AplledoreNews;
use app\modules\aplledore\models\AplledoreCategory;
use app\modules\aplledore\models\AplledoreThema;
use app\components\IdevFunctions;
use yii\data\ActiveDataProvider;
use app\models\Post;

class NewsController extends DevController{
  public function beforeAction($action){
    $arr = ['index'=>['index','new-post-list','load-media-image-content-offset','check-priority'],
            'create'=>['create','get-tag-list','get-thema-list'],
            'edit'=>['edit','get-tag-list','get-thema-list'],
            'delete'=>['delete'],
            'status'=>['check-status']];
    if(!$this->__hasRoleUser($arr,$action)){
      $this->redirect(['/aplledore/default/error']);
      return false;
    };
    return parent::beforeAction($action);
  }

  public function actionIndex() {
  	$this->view->title = 'Список посты';
    if (isset($this->post['Sort']) && !empty($this->post['Sort'])) {
      if(isset($this->post['Sort']['remove_sort'])){
        Yii::$app->session->remove('sort_'.Yii::$app->controller->id);
      }else{
        $session = Yii::$app->session;
        $arr = [];
        $arr['category'] = $this->post['Sort']['category'];
        $arr['author'] = $this->post['Sort']['author'];
        if (!empty($this->post['Sort']['data_from'])) {
          $arr['data_from'] = strtotime($this->post['Sort']['data_from']);
        }else{
          $arr['data_from'] = 0;
        }
        if (!empty($this->post['Sort']['data_to'])) {
          $arr['data_to'] = strtotime($this->post['Sort']['data_to']);
        }else{
          $arr['data_to'] = 0;
        }
        $session['sort_'.Yii::$app->controller->id] = $arr;
      }
      return $this->redirect(['index']);
    }
    $content = AplledoreNews::getPostList();
    $this->data['dataProvider'] = new ActiveDataProvider([
      'query' => $content['content'],
      'pagination' => [
          'defaultPageSize' => 15,
      ],
    ]);
    $this->data['category'] = AplledoreNews::getCategory();
    $this->data['user'] = AplledoreNews::getUsers();
    return $this->template('index');
  }

  public function actionNewPostList() {
    $this->view->title = 'Список новых постов';
    $content = AplledoreNews::getNewPostList();
    $this->data['dataProvider'] = new ActiveDataProvider([
      'query' => $content,
      'pagination' => [
          'defaultPageSize' => 15,
      ],
    ]);
    $this->data['category'] = AplledoreNews::getCategory();
    $this->data['user'] = AplledoreNews::getUsers();
    return $this->template('new-post-list');
  }

  public function actionCreate() {
    $this->view->title = 'Создать';
    if(isset($this->post['Post'])){
      if(AplledoreNews::contentLoad($this->post['Post'])){
        IdevFunctions::setSuccessFlash(Yii::t('idev','Post is created'));
      }else{
        IdevFunctions::setErrorFlash(Yii::t('idev','Post is no created'));
      }
      return $this->redirect(['index']);
    }
    $this->data['category'] = AplledoreCategory::getContentList();
    return $this->template('create');
  }

  public function actionEdit($id) {
  	$this->view->title = 'Редактировать';
    $this->data['content'] = AplledoreNews::getContent($id);
    debug($this->data);
    die;
    return $this->template('edit');
  }

  public function actionDelete($id) {
  	$this->view->title = 'Удалить';
  	if($this->isAjax){
  		echo "is Ajax";
  		die;
  	}
    return $this->template('delete');
  }

  public function actionGetTagList(){
    if ($this->isAjax) {
      return AplledoreNews::getSearchTagList($this->post['name'],$this->post['ids']); 
    }else{
      return $this->goIndex();
    }
  }

  public function actionGetThemaList(){
    if ($this->isAjax) {
      return AplledoreNews::getSearchThemaList($this->post['name']); 
    }else{
      return $this->goIndex();
    }
  }

  public function actionCheckStatus(){
    if($this->isAjax){
      return AplledoreNews::checkStatus($this->post['action'],$this->post['id']);
    }else{
      return $this->goIndex();
    }
  }

  public function actionCheckPriority(){
    if($this->isAjax){
      return AplledoreNews::checkPriority($this->post['action'],$this->post['id']);
    }else{
      return $this->goIndex();
    }
  }

  /* AUTHORS */
  public function actionAuthors($id=NULL){
    $this->view->title = Yii::t('idev','Authors');
    if($this->post['Author']){
      if(AplledoreNews::contentAuthorLoad($this->post['Author'])){
        IdevFunctions::setSuccessFlash(Yii::t('idev','Author is save'));
      }else{
        IdevFunctions::setErrorFlash(Yii::t('idev','Author is no save'));
      }
      return $this->redirect(['authors']);
    }
    $this->data['title'] = Yii::t('idev','Create author');
    if($id){
      $this->data['content'] = AplledoreNews::getAuthor($id);
      $this->data['title'] = Yii::t('idev','Edit author');
    }
    $this->data['authors'] = AplledoreNews::getAuthors();
    // debug($this->data); die;
    return $this->template('authors');
  }

  public function actionDeleteAuthor($id){
    echo $id;
  }

  public function actionGetAuthorRight(){
    if($this->isAjax){
      return json_encode(['content'=>$this->renderPartial('__author-right',['content'=>AplledoreNews::getAuthorRights($this->post['id'])])]);
    }else{
      if(isset($this->post['Role'])){
        if(AplledoreNews::createRight($this->post['Role'])){
          IdevFunctions::setSuccessFlash(Yii::t('idev','Author right is save'));
        }else{
          IdevFunctions::setErrorFlash(Yii::t('idev','Author right is no save'));
        }
        return $this->redirect(['authors']);
      }
      $this->goIndex();
    }
  }
}
