<?php 
use app\components\IdevFunctions;
use yii\widgets\ActiveForm;
 ?>
<div class="content">
  <div class="panel panel-flat">
    <div class="row">
    	<div class="col-md-6">
    		<h2><?=$data['title']?></h2>
    		<?php $form = ActiveForm::begin(['id'=>'createThema']); ?>
    			<div class="tabbable">
						<ul class="nav nav-tabs nav-tabs-highlight mb-0"><? $i = 0;?>
						<?php foreach (Yii::$app->params['langs'] as $key => $value): ?>
							<li <?=$i==0?'class="active"':''; $i++;?>><a href="#thema_<?=$value['code']?>"  data-toggle="tab"><?=$value['title']?></a></li>
						<?php endforeach ?>
						</ul>

						<div class="tab-content"><?$i = 0;?>
						<?php foreach (Yii::$app->params['langs'] as $key => $value): ?>
							<div class="tab-pane py-10 fade <?=$i==0?'in active':''?><?$i++;?>" id="thema_<?=$value['code']?>">
								<div class="form-group mb-10">
			            <label class="mb-0"><?=Yii::t('idev','thema name')?></label>
			            <input type="text" value="<?=$data['thema']['contents'][$key]['name']?>" name="Thema[<?=$key?>][name]" class="form-control">
			          </div>
							</div>
						<?php endforeach ?>
						</div>
					</div>
	    			<div class="btn-group my-10 pull-right">
					<?php if (isset($data['thema']['id'])): ?>
	    				<button class="btn btn-success btn-sm" type="submit"><?=Yii::t('idev','save')?></button>
	    				<button class="btn btn-default btn-sm ml-10" onclick="window.location.href='<?=IdevFunctions::to('/thema')?>';" type="button"><?=Yii::t('idev','cencel')?></button>
	    		<?php else: ?>
	    				<button class="btn btn-success btn-sm" type="submit"><?=Yii::t('idev','create')?></button>
					<?php endif ?>
	    			</div>
    		<?php ActiveForm::end(); ?>
    	</div>
    	<div class="col-md-6">
    		<h2><?=Yii::t('idev','thema list')?></h2>
    		<div id="themaList">
    			<table class="table table-bordered table-hover">
	    			<tbody>
	    			<?php foreach ($data['content'] as $item): ?>
	    				<tr>
	    					<td style="width:35px;text-align:center;"><?=$item['id']?></td>
	    					<td><?=$item['content']['name']?></td>
	    					<td width="25%">
	    						<?=date("Y-m-d H:i", (int)$item['date'])?><br/>
	    						<?=date("Y-m-d H:i", (int)$item['update'])?>
	    					</td>
	    					<td width="15%">
	    						<a href="<?=IdevFunctions::to('/thema/'.$item['id'])?>"><?=Yii::t('idev','Edit')?></a><br/>
	    						<a href="<?=IdevFunctions::to('/thema/delete/'.$item['id'])?>" data-action="delete" data-text="<?=Yii::t('idev','Delete is thema {name}?',['name'=>$item['content']['name']]);?>"><?=Yii::t('idev','Delete')?></a>
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