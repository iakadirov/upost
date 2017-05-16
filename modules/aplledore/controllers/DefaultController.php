<?php
namespace app\modules\aplledore\controllers;
use yii\web\Controller;

class DefaultController extends DevController{
  public function actionIndex() {
  	$this->view->title = 'Главный';
  	// \app\models\UserRole::deleteAll(['user_id'=>2,'role_id'=>5]);
    return $this->render('index');
  }

  public function actionError() {
  	$this->view->title = 'доступ запрещен';
    return $this->render('error');
  }
}
