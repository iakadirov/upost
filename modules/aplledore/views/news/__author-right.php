<?php 
	use app\components\IdevFunctions;
	use yii\widgets\ActiveForm;
 ?>
<h1 class="m-0 pb-10"><?=Yii::t('idev','Right user',['name'=>$content['user']['first_name'].' '.$content['user']['last_name']])?> <span class="closeModal pull-right" onclick="$('#mediumModal').modal('hide')"></span></h1>
<?php $form = ActiveForm::begin(['id'=>'authorRights']); ?>
	<div class="col-sm-12 p-0">
		<!-- <#?=debug($content)?> -->
		<input type="hidden" name="Role[user_id]" value="<?=$content['user']['id']?>">
		<?php foreach ($content['roles'] as $key => $value): ?>
			<div class="checkbox">
			  <label><input type="checkbox" name="Role[list][<?=$key?>]" <?=in_array($key,$content['user_rols'])?'checked':''?> value="<?=$key?>"><?=$value['description']?></label>
			</div>
		<?php endforeach ?>
	</div>
	<div class="col-xs-12 p-0 pt-10">
		<button class="btn btn-default btn-sm pull-right" onclick="$('#mediumModal').modal('hide')"><?=Yii::t('idev','Cencel')?></button>
		<button class="btn btn-success btn-sm pull-right" type="submit"><?=Yii::t('idev','Save')?></button>
	</div>
<?php ActiveForm::end(); ?>