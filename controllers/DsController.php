<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\User;

class DsController extends Controller
{
  /*public function behaviors(){
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          // [
          //   'allow' => true,
          //   'roles' => ['@'],
          // ],
          // [
          //   'allow' => true,
          //   'actions' => ['login'],
          //   'roles' => ['?'],
          // ],
        ],
      ],
    ];
  }*/


  public function userGoHome(){
    if(!Yii::$app->user->isGuest){
      return $this->goHome();
    }
  }

  public static function getRolUser(){
    if (!Yii::$app->user->isGuest) {
      if (User::isAdmin()) {
        return 'Administrator';
      }elseif(User::isModer()){
        return 'Moderator';
      }else{
        return "User";
      }
    }else{
      return fasle;
    }
    return fasle;
  }


}
