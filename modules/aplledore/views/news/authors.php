<?php 
use app\components\IdevFunctions;
use yii\widgets\ActiveForm;
 ?>
<div class="content">
  <div class="panel panel-flat">
    <div class="row">
    	<div class="col-md-6">
    		<h2><?=$data['title']?></h2>
    		<?php $form = ActiveForm::begin(['id'=>'createCategory']); ?>
    			<div class="form-group">
    				<label><?=Yii::t('idev','Username')?></label>
    				<input type="text" class="form-control" name="Author[username]">
    			</div>
    			<div class="form-group">
    				<label><?=Yii::t('idev','E-mail')?></label>
    				<input type="email" class="form-control" name="Author[email]">
    			</div>
    			<div class="form-group">
    				<label><?=Yii::t('idev','Password')?></label>
    				<input type="text" class="form-control" name="Author[password]">
    			</div>
	    		<div class="btn-group my-10 pull-right">
						<?php if (isset($data['author']['id'])): ?>
		    				<button class="btn btn-success btn-sm" type="submit"><?=Yii::t('idev','save')?></button>
		    				<button class="btn btn-default btn-sm ml-10" onclick="window.location.href='<?=IdevFunctions::to('/news/authors')?>';" type="button"><?=Yii::t('idev','cencel')?></button>
		    		<?php else: ?>
		    				<button class="btn btn-success btn-sm" type="submit"><?=Yii::t('idev','create')?></button>
						<?php endif ?>
	    		</div>
    		<?php ActiveForm::end(); ?>
    	</div>
    	<div class="col-md-6">
    		<h2><?=Yii::t('idev','Authors')?></h2>
    		<div id="categoryList">
    			<table class="table table-bordered table-hover">
	    			<tbody>
	    			<?php foreach ($data['authors'] as $item): ?>
	    				<tr>
	    					<td style="width:35px;text-align:center;"><?=$item['id']?></td>
	    					<td><?=$item['username']?><br/><?=$item['first_name'].' '.$item['last_name']?></td>
	    					<td width="15%">
	    						<a href="<?=IdevFunctions::to('/news/authors/'.$item['id'])?>"><?=Yii::t('idev','Edit')?></a><br/>
	    						<a href="<?=IdevFunctions::to('/news/authors/delete/'.$item['id'])?>" data-action="delete" data-text="<?=Yii::t('idev','Delete is user {name}?',['name'=>$item['username']]);?>"><?=Yii::t('idev','Delete')?></a>
	    					</td>
	    				</tr>
	    			<?php endforeach ?>
	    			</tbody>
	    		</table>
    		</div>
    	</div>
    </div>
  </div>
</div>