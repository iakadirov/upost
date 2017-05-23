<?php 
  use app\components\IdevFunctions;
  use yii\widgets\ActiveForm;
?>  
<div class="content">
<?php $form = ActiveForm::begin(['id'=>'newsCreate']); ?>
  <div class="row">
    <div class="col-lg-9">
      <div class="panel panel-flat">
        <ul class="nav nav-tabs nav-tabs-highlight mb-0"><? $i = 0;?>
          <?php foreach (Yii::$app->params['langs'] as $key => $value): ?>
            <li <?=$i==0?'class="active"':''; $i++;?>><a href="#category_<?=$value['code']?>"  data-toggle="tab"><?=$value['title']?></a></li>
          <?php endforeach ?>
        </ul>
        <div class="tab-content"><?$i = 0;?>
          <?php foreach (Yii::$app->params['langs'] as $key => $value): ?>
            <div class="tab-pane py-10 fade <?=$i==0?'in active':''?><?$i++;?>" id="category_<?=$value['code']?>">
              <div class="form-group">
                <label for="post_title"><?=Yii::t('idev','Name')?></label>
                <input type="text" name="Post[<?=$key?>][name]" class="form-control">
              </div>
              <div class="form-group">
                <label><?=Yii::t('idev','Content')?></label>
                <textarea class="form-control content_edit" name="Post[<?=$key?>][content]" rows="10"></textarea>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>

    <div class="col-lg-3 pl-0">
      <div class="panel panel-flat">
          <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">open</button>
        <div class="form-group">
          <label><?=Yii::t('idev','Category')?></label>
          <select class="form-control" name="Post[category_id]">
            <option value="0"><?=Yii::t('idev','No')?></option>
            <?php foreach ($data['category'] as $item): ?>
              <?php if ($item['parent_id']==0): ?>
                <option value="<?=$item['id']?>" <?=$item['id']==$data['category']['parent_id']?'selected':''?>><?=$item['content']['name']?></option>
                <?php foreach ($data['category'] as $child): ?>
                  <?php if ($item['id']==$child['parent_id']): ?>
                    <option value="<?=$child['id']?>" <?=$child['id']==$data['category']['parent_id']?'selected':''?>> - <?=$child['content']['name']?></option>
                  <?php endif ?>
                <?php endforeach ?>
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label><?=Yii::t('idev','Thema')?></label>
          <input class="form-control" type="text" id="searchThema">
          <input type="hidden" name="Post[thema_id]" value="0">
        </div>
        <div class="form-group o-h">
          <label class="control-label col-lg-4 p-0 text-semibold"><h6 class="text-semibold">Xarakter</h6></label>
          <div class="col-lg-8">
            <div class="checkbox checkbox-switch">
              <label>
                <input type="checkbox" name="Post[character]" data-on-color="danger" data-off-color="default" data-on-text="Negativ" data-off-text="Pozitiv" class="switch">
              </label>
            </div>
          </div>
        </div>
        <div class="form-group o-h">
          <label class="control-label col-lg-4 p-0 text-semibold"><h6 class="text-semibold">Obuna</h6></label>
          <div class="col-lg-8">
            <div class="checkbox checkbox-switch">
              <label>
                <input type="checkbox" name="Post[subscribe]" data-on-color="success" data-off-color="default" data-on-text="Obunali" data-off-text="Oddiy" class="switch">
              </label>
            </div>
          </div>
        </div>
        <div class="form-group o-h mb-0">
          <label class="control-label col-lg-4 p-0 text-semibold"><h6 class="text-semibold">Muhimmi?</h6></label>
          <div class="col-lg-8">
            <div class="checkbox checkbox-switch">
              <label>
                <input type="checkbox" name="Post[priority]" data-on-color="success" data-off-color="default" data-on-text="Muhim" data-off-text="Yo'q" class="switch">
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-flat">
        <label>Реклама</label>
        <div class="form-group o-h mb-0">
          <label class="control-label col-lg-4 p-0 text-semibold"><h6 class="text-semibold">PR</h6></label>
          <div class="col-lg-8">
            <div class="checkbox checkbox-switch">
              <label>
                <input type="checkbox" name="Post[pr]" data-on-color="danger" data-off-color="default" data-on-text="Ha" data-off-text="Yo'q" class="switch">
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-flat tagBlock">
        <label class="mt-0 mb-10"><?=Yii::t('idev','Tags')?></label>
        <div class="w-100 o-h tagList">
        </div>
        <input type="hidden" name="Post[tagoldlist]" id="oldTags">
        <input type="hidden" name="Post[tagnewlist]" id="newTags">
        <div class="d-block">
          <ul class="nav nav-tabs nav-tabs-highlight mb-0">
            <li class="active"><a href="#tagOldList" data-toggle="tab"><?=Yii::t('idev','Search')?></a></li>
            <li><a href="#tagCreateNew" data-toggle="tab"><?=Yii::t('idev','Create new')?></a></li>
          </ul>
          <div class="tab-content pt-10" id="tagListTab">
            <div class="tab-pane fade in active" id="tagOldList">
              <div class="form-group mb-0">
                <input type="text" class="form-control tagOldListInput" placeholder="<?=Yii::t('idev','Search')?>...">
              </div>
            </div>
            <div class="tab-pane o-h fade" id="tagCreateNew">
              <div class="form-inline">
                <div class="form-group m-0 col-xs-8 p-0">
                  <input type="text" ondragenter="alert($(this).val());return false;" class="form-control w-100" id="newTagInput" placeholder="<?=Yii::t('idev','Create new')?>">
                </div>
                <div class="form-group m-0 col-xs-2 p-0">
                  <select class="form-control p-0">
                    <?php foreach ($this->context->langs as $key => $value): ?>
                      <option value="<?=$key?>"><?=$value['code']?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <button class="btn btn-primary col-xs-2 p-5" id="createNewTag"><i class="icon-plus"></i></button>
              </div>
            </div>
          </div>
        </div>  
      </div>
      <div class="panel panel-flat">
        <button type="submit" class="btn btn-primary dropdown-toggle" submit="submit"><i class="icon-paperplane position-left"></i> <?=Yii::t('idev','Create')?></button>
      </div>
    </div>
  </div>
<?php ActiveForm::end(); ?>
</div>