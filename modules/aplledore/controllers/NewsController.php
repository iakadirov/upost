<?php
namespace app\modules\aplledore\controllers;
use Yii;

class NewsController extends DevController{
  public function actionIndex() {
  	$this->view->title = 'Список посты';
    return $this->render('index');
  }

  public function actionCreate() {
  	$this->view->title = 'Создать';
    if($this->post['Post']){
      debug($this->post['Post']);
      die;
    }
    return $this->render('create');
  }

  public function actionEdit($id) {
  	$this->view->title = 'Редактировать';
    return $this->render('edit');
  }

  public function actionDelete($id) {
  	$this->view->title = 'Удалить';
  	if($this->isAjax){
  		echo "is Ajax";
  		die;
  	}
    return $this->render('delete');
  }
}
