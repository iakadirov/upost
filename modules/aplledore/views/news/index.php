<?php 
	use app\components\IdevFunctions;
	use yii\widgets\ActiveForm;
?>	
<div class="content">
  <div class="panel panel-flat">
    <div class="panel-heading mb-10 o-h p-0">
      <div class="pull-right o-h">
        <ul class="icons-list m-0">
          <li><a href="#" class="btn btn-primary text-white" data-toggle="modal" data-target="#sortNews"><b> <?=Yii::t('idev','Sort')?></b></a></li>
          <li><a href="<?=IdevFunctions::to('/news/create')?>" class="btn btn-success text-white"><b> <?=Yii::t('idev','Create news')?></b></a></li>
        </ul>
      </div>
    </div>
    <table class="table datatable-basic">
      <thead>
        <tr>
          <th><?=Yii::t('idev','Author')?></th>
          <th><?=Yii::t('idev','Category')?></th>
          <th><?=Yii::t('idev','Title')?></th>
          <th><?=Yii::t('idev','Date')?></th>
          <th><?=Yii::t('idev','Prioritet')?></th>
          <th class="text-center"><?=Yii::t('idev','Status')?></th>
        </tr>
      </thead>
      <tbody id="ajaxPostContent">
      	<?php foreach ($data['content'] as $item): ?>
	        <tr>
	          <td>Thema</td>
	          <td><?=!empty($item['category'])?'<a href='.IdevFunctions::to('/category/'.$item['category']['category_id']).'>'.$item['category']['name'].'</a>':Yii::t('idev','No')?></td>
	          <td><a href="<?=IdevFunctions::to('/news/edit/'.$item['id'])?>"><?=$item['content']['name']?></a></td>
	          <td><?=date('H:i d-m-Y',$item['date'])?></td>
	          <?php if ($item['character'] == 1): ?>
	          	<td><span class="label label-danger">Muhim</span></td>
	          <?php else: ?>
	          	<td><span class="label label-default">Oddiy</span></td>
	          <?php endif ?>
	          <td class="text-center">
	            <span data-action="checkbox" data-id="<?=$item['id']?>"><input type="checkbox" class="checkbox" id="checkbox_post_<?=$item['id'];?>" <?=$item['status']==1?'checked':''?>><label for="checkbox_post_<?=$item['id']?>"></label></span>
	          </td>
	        </tr>
      	<?php endforeach ?>
      </tbody>
    </table>
    <div class="col-12 postPagination">
	    <nav data-action="pagination" id="postPagination" data-limit="11" data-count="634" data-content="#ajaxPostContent" data-url="<?=IdevFunctions::to('/post/get-post-in-ajax');?>" data-preloader="#preloader-post" data-left-content='{}' class='d-table mx-auto'></nav>
	  </div>
  </div>
</div>

<div id="sortNews" class="modal fade">
	<div class="modal-dialog dsModal">
		<div class="modal-content modal-sm">
			<div class="modal-header p-10">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Modal with icons</h5>
			</div>
			<div class="modal-body p-10">
				<?php $form = ActiveForm::begin(['id'=>'newsSort']); ?>
					<div class="form-group mb-10">
						<label class="m-0"><?=Yii::t('idev','Category')?></label>
						<select class="form-control" name="Sort[category]">
							<option value="0"><?=Yii::t('idev','No')?></option>
						</select>
					</div>
					<div class="form-group mb-10">
						<label class="m-0"><?=Yii::t('idev','Author')?></label>
						<select class="form-control" name="Sort[author]">
							<option value="0"><?=Yii::t('idev','No')?></option>
						</select>
					</div>
					<div class="form-group mb-10 col-sm-6 pull-left pl-0 pr-5">
						<label class="m-0"><?=Yii::t('idev','Data from')?></label>
						<input type="date" name="Sort[data_from]" class="form-control">
					</div>
					<div class="form-group mb-10 col-sm-6 pull-left pr-0 pl-5">
						<label class="m-0"><?=Yii::t('idev','Data to')?></label>
						<input type="date" name="Sort[data_to]" class="form-control">
					</div>
				<?php ActiveForm::end(); ?>
			</div>
			<div class="modal-footer p-10">
				<button class="btn btn-sm btn-primary"><i class="icon-sort"></i> <?=Yii::t('idev','Sort')?></button>
				<button class="btn btn-sm btn-danger"><i class="icon-cross"></i> <?=Yii::t('idev','Delete sort')?></button>
			</div>
		</div>
	</div>
</div>