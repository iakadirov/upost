<?php

namespace app\modules\aplledore\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Language;
use app\models\User;
use app\components\IdevFunctions;

class DevController extends Controller{
	public $langs;
	public $data = [];
	public $isAjax = false;
	public $post = [];
	public $user = [];

  public function behaviors(){
	  return [
	    'access' => [
	      'class' => AccessControl::className(),
	      'rules' => [
	        [
	          'allow' => true,
	          'roles' => ['@'],
	        ],
	      ],
	    ],
	  ];
	}

	public function beforeAction($action){
		if(Yii::$app->user->isGuest){
      $this->redirect(['/login']);
      return false;
    }
    if(Yii::$app->request->isAjax){$this->isAjax = true;}
		if(Yii::$app->request->post()){$this->post = Yii::$app->request->post();}
		Yii::$app->params['langs'] = Language::getAllLangs();
		$this->view->user = Yii::$app->user->identity;
		$this->langs = Yii::$app->params['langs'];
		Yii::$app->params['admin_lang'] = 1;
		return parent::beforeAction($action);
	}

	public static function __hasRoleUser($arr, $action){
    if( User::isAdmin()){
      return true;
    }else{
      $role = Yii::$app->user->identity['rols'];
      if( isset($role[Yii::$app->controller->id]) ){
        foreach($arr as $key => $value){
          if(in_array($key, $role[Yii::$app->controller->id]) && in_array($action->id, $value)){
            return true;
          }
        }
      }
    }
    return false;
  }

	public function template($url){
		return $this->render($url, ['data' => $this->data]);
	}


	public function goIndex(){
		return $this->redirect(IdevFunctions::to('/'.Yii::$app->controller->id.'/index'));
	}
}