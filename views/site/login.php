<?php 

use yii\widgets\ActiveForm;
 ?>
<h1>Авторизация <?=sha1('123')?></h1>

<?php $form = ActiveForm::begin(['class'=>'form-horizontal']); ?>
<!-- <#?= $form->field($model, 'username')->textInput(['autofocus'=>true]) ?> -->
<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="btn-group">
	<button type="submit" class="btn btn-primary">Submit</button>
</div>
<?php ActiveForm::end(); ?>