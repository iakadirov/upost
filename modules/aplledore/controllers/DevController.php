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
		Yii::$app->params['langs'] = Language::getAllLangs();
		$this->langs = Yii::$app->params['langs'];
		Yii::$app->params['admin_lang'] = 1;
		if(!$this->__hasRoleUser($action)){
			$this->redirect(['/aplledore/default/error']);
			return false;
		};
		return parent::beforeAction($action);
	}

	protected function __hasRoleUser($action){
		$user_action = $action->controller->id.'/'.$action->id;
		Yii::$app->params['user_action'] = $user_action;
		if (User::isAdmin()) {
			return true;
		}else{
			if (!in_array($user_action, Yii::$app->user->identity['rols']) && $action->controller->id != 'default') {
				return false;
			}else{
				return true;
			}
		}
	}

	public function template($url){
		return $this->render($url, ['data' => $this->data]);
	}


	public function goIndex(){
		return $this->redirect(IdevFunctions::to('/'.Yii::$app->controller->id.'/index'));
	}
}