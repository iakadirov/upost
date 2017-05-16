<?php

namespace app\controllers;

use Yii;
use app\models\Signup;
use app\models\Login;
use app\models\User;
use yii\filters\AccessControl;

class SiteController extends DsController{
  public function actionIndex(){
    // добавить роль пользователя
    // $role = Yii::$app->authManager->createRole('User');
    // $role->description = 'Пользователь';
    // Yii::$app->authManager->add($role);

    // добавит роль к пользоветаями по ID
    // $userRole = Yii::$app->authManager->getRole('Developer');
    // Yii::$app->authManager->assign($userRole, Yii::$app->user->identity->id)

    return $this->render('index');
  }

  public function actionSignup(){
    $this->userGoHome();
    $model = new Signup();
    if (Yii::$app->request->post('Signup')) {
      $model->attributes = Yii::$app->request->post('Signup');
      if ($model->validate() && $id = $model->signup()){
        $userRole = Yii::$app->authManager->getRole('User');
        Yii::$app->authManager->assign($userRole, $id);
        return $this->goHome();
      }
    }
    return $this->render('signup', ['model'=>$model]);
  }

  public function actionLogin(){
    $this->userGoHome();
    $model = new Login();
    if (Yii::$app->request->post('Login')) {
      $model->attributes = Yii::$app->request->post('Login');
      if ($model->validate()) {
        Yii::$app->user->login($model->getUser());
        if (User::isAdmin() || User::isModer()) {
          return $this->redirect('/aplledore');
        }else{
          return $this->goHome();
        }
      }
    }
    return $this->render('login', ['model'=>$model]);
  }

  public function actionLogout(){
    if (!Yii::$app->user->isGuest) {
      Yii::$app->user->logout();
      return $this->redirect(['login']);
    }else{
      return $this->goHome();
    }
  }
}