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
    			<div class="tabbable">
						<ul class="nav nav-tabs nav-tabs-highlight mb-0"><? $i = 0;?>
						<?php foreach (Yii::$app->params['langs'] as $key => $value): ?>
							<li <?=$i==0?'class="active"':''; $i++;?>><a href="#category_<?=$value['code']?>"  data-toggle="tab"><?=$value['title']?></a></li>
						<?php endforeach ?>
						</ul>

						<div class="tab-content"><?$i = 0;?>
						<?php foreach (Yii::$app->params['langs'] as $key => $value): ?>
							<div class="tab-pane py-10 fade <?=$i==0?'in active':''?><?$i++;?>" id="category_<?=$value['code']?>">
								<div class="form-group mb-10">
			            <label class="mb-0"><?=Yii::t('idev','category name')?></label>
			            <input type="text" name="Category[<?=$key?>][name]" class="form-control">
			          </div>
			          <div class="form-group mb-10">
			            <label class="mb-0"><?=Yii::t('idev','category parent')?></label>
			            <select name="Category[<?=$key?>][parent]" class="form-control">
			            	<option value="0"><?=Yii::t('idev','no')?></option>
			            </select>
			          </div>
			          <div class="form-group mb-10">
			            <label class="mb-0"><?=Yii::t('idev','category content')?></label>
			            <textarea name="Category[<?=$key?>][content]" class="form-control"></textarea>
			          </div>
							</div>
						<?php endforeach ?>
						</div>
					</div>
    			<div class="btn-group my-10 pull-right">
    				<button class="btn btn-success btn-sm" type="submit"><?=Yii::t('idev','create')?></button>
    				<button class="btn btn-default btn-sm ml-10" onclick="window.location.href='<?=IdevFunctions::to('/category')?>';" type="button"><?=Yii::t('idev','cencel')?></button>
    			</div>
    		<?php ActiveForm::end(); ?>
    	</div>
    	<div class="col-md-6">
    		<h2><?=Yii::t('idev','category list')?></h2>
    		<div id="categoryList">
    			<table class="table table-bordered table-hover">
	    			<tbody>
	    				<tr>
	    					<td>1</td>
	    					<td>Name</td>
	    					<td>date</td>
	    					<td>delete&edit</td>
	    				</tr>
	    			</tbody>
	    		</table>
    		</div>
    	</div>
    </div>
  </div>
</div>