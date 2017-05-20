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
			            <input type="text" value="<?=$data['category']['contents'][$key]['name']?>" name="Category[<?=$key?>][name]" class="form-control">
			          </div>
			          <div class="form-group mb-10">
			            <label class="mb-0"><?=Yii::t('idev','category parent')?></label>
			            <select name="Category[<?=$key?>][parent]" class="form-control">
			            	<option value="0" <?=$data['category']['id']==0?'selected':''?>><?=Yii::t('idev','no')?></option>
			            	<?php foreach ($data['content'] as $item): ?>
			            		<?php if ($item['parent_id']==0): ?>
			            			<option value="<?=$item['id']?>" <?=$item['id']==$data['category']['parent_id']?'selected':''?>><?=$item['content']['name']?></option>
			            			<?php foreach ($data['content'] as $child): ?>
			            				<?php if ($item['id']==$child['parent_id']): ?>
			            					<option value="<?=$child['id']?>" <?=$child['id']==$data['category']['parent_id']?'selected':''?>> - <?=$child['content']['name']?></option>
			            				<?php endif ?>
			            			<?php endforeach ?>
			            		<?php endif ?>
			            	<?php endforeach ?>
			            </select>
			          </div>
			          <div class="form-group mb-10">
			            <label class="mb-0"><?=Yii::t('idev','category content')?></label>
			            <textarea name="Category[<?=$key?>][content]" class="form-control"><?=$data['category']['contents'][$key]['content']?></textarea>
			          </div>
							</div>
						<?php endforeach ?>
						</div>
					</div>
	    			<div class="btn-group my-10 pull-right">
					<?php if (isset($data['category']['id'])): ?>
	    				<button class="btn btn-success btn-sm" type="submit"><?=Yii::t('idev','save')?></button>
	    				<button class="btn btn-default btn-sm ml-10" onclick="window.location.href='<?=IdevFunctions::to('/category')?>';" type="button"><?=Yii::t('idev','cencel')?></button>
	    		<?php else: ?>
	    				<button class="btn btn-success btn-sm" type="submit"><?=Yii::t('idev','create')?></button>
					<?php endif ?>
	    			</div>
    		<?php ActiveForm::end(); ?>
    	</div>
    	<div class="col-md-6">
    		<h2><?=Yii::t('idev','category list')?></h2>
    		<div id="categoryList">
    			<table class="table table-bordered table-hover">
	    			<tbody>
	    			<?php foreach ($data['content'] as $item): ?>
		    			<?php if ($item['parent_id']==0): ?>
		    				<tr>
		    					<td style="width:35px;text-align:center;"><?=$item['id']?></td>
		    					<td><?=$item['content']['name']?></td>
		    					<td width="25%">
		    						<?=date("Y-m-d H:i", (int)$item['date'])?><br/>
		    						<?=date("Y-m-d H:i", (int)$item['update'])?>
		    					</td>
		    					<td width="15%">
		    						<a href="<?=IdevFunctions::to('/category/'.$item['id'])?>"><?=Yii::t('idev','Edit')?></a><br/>
		    						<a href="<?=IdevFunctions::to('/category/delete/'.$item['id'])?>" data-action="delete" data-text="<?=Yii::t('idev','Delete is category {name}?',['name'=>$item['content']['name']]);?>"><?=Yii::t('idev','Delete')?></a>
		    					</td>
		    				</tr>
		    				<?php foreach ($data['content'] as $child): ?>
				    			<?php if ($child['parent_id']==$item['id']): ?>
				    				<tr>
				    					<td style="width:35px;text-align:center;"><?=$child['id']?></td>
				    					<td> - <?=$child['content']['name']?></td>
				    					<td width="25%">
				    						<?=date("Y-m-d H:i", (int)$child['date'])?><br/>
				    						<?=date("Y-m-d H:i", (int)$child['update'])?>
				    					</td>
				    					<td width="15%">
				    						<a href="<?=IdevFunctions::to('/category/'.$child['id'])?>"><?=Yii::t('idev','Edit')?></a><br/>
				    						<a href="<?=IdevFunctions::to('/category/delete/'.$child['id'])?>"><?=Yii::t('idev','Delete')?></a>
				    					</td>
				    				</tr>
				    			<?php endif ?>
			    			<?php endforeach ?>
		    			<?php endif ?>
	    			<?php endforeach ?>
	    			</tbody>
	    		</table>
    		</div>
    	</div>
    </div>
  </div>
</div>