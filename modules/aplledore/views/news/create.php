<?php 
	use app\components\IdevFunctions;
	use yii\widgets\ActiveForm;
?>	
<div class="content">
<?php $form = ActiveForm::begin(['id'=>'createNews']); ?>
  <div class="row">
		<div class="col-lg-9">
			<div class="panel panel-flat">
				<ul class="nav nav-tabs nav-tabs-highlight mb-0"><? $i = 0;?>
					<?php foreach (Yii::$app->params['langs'] as $key => $value): ?>
						<li <?=$i==0?'class="active"':''; $i++;?>><a href="#post_<?=$value['code']?>"  data-toggle="tab"><?=$value['title']?></a></li>
					<?php endforeach ?>
				</ul>
				<div class="tab-content"><?$i = 0;?>
					<?php foreach (Yii::$app->params['langs'] as $key => $value): ?>
						<div class="tab-pane py-10 fade <?=$i==0?'in active':''?><?$i++;?>" id="post_<?=$value['code']?>">
							<div class="form-group">
								<label for="post_title"><?=Yii::t('idev','Name')?></label>
								<input type="text" name="Post[<?=$key?>][name]" class="form-control">
							</div>
							<div class="form-group">
								<label><?=Yii::t('idev','Content')?></label>
								<textarea class="form-control" name="Post[<?=$key?>][content]" rows="10"></textarea>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>

		<div class="col-lg-3 pl-0">
			<div class="panel panel-flat">
				<div class="form-group">
					<label><?=Yii::t('idev','Category')?></label>
					<select class="form-control" name="Post[category]">
						<option value="0"><?=Yii::t('idev','No')?></option>
					</select>
				</div>
			</div>
			<div class="panel panel-flat tagBlock">
				<h4 class="mt-0 mb-5"><?=Yii::t('idev','Tags')?></h4>
        <div class="w-100 o-h tagList">
        </div>
        <input type="hidden" name="Post[tagoldlist]" id="oldTags">
        <input type="hidden" name="Post[tagnewlist]" id="newTags">
        <div class="d-block">
          <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="active"><a href="#tagOldList" data-toggle="tab"><?=Yii::t('idev','Search')?></a></li>
            <li><a href="#tagCreateNew" data-toggle="tab"><?=Yii::t('idev','Create new')?></a></li>
          </ul>
          <div class="tab-content pt-5 w-100" id="tagListTab">
            <div class="tab-pane fade in active" id="tagOldList">
              <div class="form-group mb-0">
                <input type="text" class="form-control tagOldListInput" placeholder="<?=Yii::t('idev','Search')?>...">
              </div>
            </div>
            <div class="tab-pane o-h fade" id="tagCreateNew">
              <div class="form-inline">
                <div class="form-group m-0 col-sm-8 p-0">
                  <input type="text" ondragenter="alert($(this).val());return false;" class="form-control w-100" id="newTagInput" placeholder="<?=Yii::t('idev','Create new')?>">
                </div>
                <div class="form-group m-0 col-sm-2 p-0">
                  <select class="form-control p-0">
                    <?php foreach (Yii::$app->params['langs'] as $key => $value): ?>
                      <option value="<?=$key?>"><?=$value['code']?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <button class="btn btn-primary col-sm-2 p-5" id="createNewTag"><i class="icon-plus"></i></button>
              </div>
            </div>
          </div>
        </div>
			</div>
			<div class="panel panel-flat">
				<button class="btn btn-primary" type="submit"><?=Yii::t('idev','Create')?></button>
			</div>
		</div>
	</div>
<?php ActiveForm::end(); ?>
</div>