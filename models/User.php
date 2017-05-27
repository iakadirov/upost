<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface{
  const TYPE_ADMIN = 1;
  const TYPE_MODER = 2;
  public $rols = [];
  public function setPassword($password){
    $this->password = sha1($password);
  }

  public function validatePassword($password){
    return $this->password === sha1($password);
  }

  /* IdentityInterface functions */
  public static function findIdentity($id){
    $user = self::findOne($id);
    $query = 'SELECT * FROM `user_role` AS `ur` INNER JOIN `roles`AS`r` ON `ur`.`role_id`=`r`.`id` WHERE `ur`.`user_id`='.$id.' ';
    $rols = UserRole::findBySql($query)->asArray()->all();
    foreach ($rols as $rol) {
      $user->rols[$rol['controller']][] = $rol['action'];
    }
    return $user;
  }

  public function getId(){
    return $this->id;
  }

  public static function isAdmin(){
    if(Yii::$app->user->identity->type == self::TYPE_ADMIN){
      return true;
    }else{
      return false;
    }
  }

  public static function isModer(){
    if(Yii::$app->user->identity->type == self::TYPE_MODER){
      return true;
    }else{
      return false;
    }
  }

  public static function getAllUsers(){
    return self::find()->select('id,username,type')->asArray()->all();
  }

  public static function findIdentityByAccessToken($token, $type = null){

  }

  public function getAuthKey(){
    
  }

  public function validateAuthKey($authKey){
    
  }
}