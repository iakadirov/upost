<?php 

namespace app\models;
use yii\base\Model;

class Signup extends Model{
	public $email;
	public $username;
	public $password;

	public function rules(){
		return [
			[['username', 'email', 'password'], 'required'],
			['email', 'email'],
			['email', 'unique','targetClass'=>'app\models\User'],
			// ['username', 'unique','targetClass'=>'app\models\User'],
			['password', 'string', 'min'=>2, 'max'=>12],
			['username', 'string', 'min'=>5, 'max'=>12],
		];
	}

	public function signup(){
		$user = new User();
		$user->email = $this->email;
		$user->username = $this->username;
		$user->setPassword($this->password);
		$user->view_password = $this->password;
		if($user->save()){
			return $user->id;
		}else{
			return false;
		}
	}
}