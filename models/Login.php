<?php 

namespace app\models;
use yii\base\Model;

class Login extends Model{
	public $email;
	public $password;

	public function rules(){
		return [
			[['email', 'password'], 'required'],
			['email', 'email'],
			['password', 'validatePassword'] /* validatePassword - функция для проверка пароля */
		];
	}

	public function validatePassword($attribute, $params){
		if (!$this->hasErrors()) { /* Если нет не какой ошибка */
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password)) {
				/* если пользователь не существует или логин/парол не правильно */
				$this->addError($attribute, 'error password');
			}
		}
	}

	public function getUser(){
		return User::findOne(['email'=>$this->email]);
	}
}