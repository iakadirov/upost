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
  public function actionIndex() {
  	$this->view->title = 'Список посты';
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
}
