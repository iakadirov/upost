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
          <?php if (isset($data['content']['id'])): ?>
            <input type="hidden" required name="Author[id]" value="<?=$data['content']['id']?>">
          <?php endif ?>
    			<div class="form-group">
    				<label><?=Yii::t('idev','Username')?></label>
    				<input type="text" class="form-control" required name="Author[username]" value="<?=$data['content']['username']?>">
    			</div>
    			<div class="form-group">
    				<label><?=Yii::t('idev','E-mail')?></label>
    				<input type="email" class="form-control" required name="Author[email]" value="<?=$data['content']['email']?>">
    			</div>
    			<div class="form-group">
    				<label><?=Yii::t('idev','Password')?></label>
    				<input type="text" class="form-control" required name="Author[password]" value="<?=$data['content']['view_password']?>">
    			</div>
          <div class="form-group col-sm-6 pl-0">
            <label><?=Yii::t('idev','First name')?></label>
            <input type="text" required name="Author[first_name]" class="form-control" value="<?=$data['content']['first_name']?>">
          </div>
          <div class="form-group col-sm-6 pl-0 pr-0">
            <label><?=Yii::t('idev','Last name')?></label>
            <input type="text" required name="Author[last_name]" class="form-control" value="<?=$data['content']['last_name']?>">
          </div>
          <div class="form-group col-sm-6 pl-0">
            <label><?=Yii::t('idev','Status')?></label>
            <select class="form-control" name="Author[status]">
              <option value="1" <?=$data['content']['status']==1?'selected':''?>><?=Yii::t('idev','Active')?></option>
              <option value="0" <?=$data['content']['status']==0?'selected':''?>><?=Yii::t('idev','Deactive')?></option>
            </select>
          </div>
          <div class="clearfix"></div>
	    		<div class="btn-group my-10 pull-right">
						<?php if (isset($data['content']['id'])): ?>
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
	    				<tr <?=$item['status']==0?'class="danger"':''?>>
	    					<td style="width:35px;text-align:center;"><?=$item['id']?></td>
	    					<td><?='<b>'.$item['username'].'</b> ('.$item['email'].')'?><br/><?=$item['first_name'].' '.$item['last_name']?></td>
                <td width="10%">
                  <button class="btn btn-primary" data-id="<?=$item['id']?>" id="createRightUser"><i class="icon-list"></i></button>
                </td>
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