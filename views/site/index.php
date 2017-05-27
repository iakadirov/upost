<?php 
use app\models\User;
 ?>
<h1>Мы на главное странице!</h1>

<div class="help">
	<h1><?= Yii::$app->user->loginUrl[0]; ?></h1>
	<h3>Ваш роль: <?= $this->context->getRolUser();?></h3>
</div>

<div class="col-12">

	<!-- <#?=debug(app\models\Category::find()->with('postCount')->asArray()->all())?> -->
	<!-- <#?=debug(User::findBySql('SELECT u.*,ut.name AS type FROM `user` `u` LEFT JOIN `user_type` `ut` ON `u`.`type`=`ut`.`id` WHERE u.id=1')->asArray()->one());?> -->
</div>