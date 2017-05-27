<?php 
	use app\components\IdevFunctions;
	use yii\widgets\ActiveForm;
	use yii\grid\GridView;
	use app\models\User;

if(Yii::$app->session->has('sort_'.Yii::$app->controller->id)){
	$session = Yii::$app->session->get('sort_'.Yii::$app->controller->id);
	// $sortCategory = ['ca']
}
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
    <!-- <#?= debug(app\models\Post::find()->with('content','category')->all())?> -->
    <?= GridView::widget([
		    'dataProvider' => $data['dataProvider'],
        'options'=>['id'=>'newsPostList'],
        'tableOptions' => [
            'class' => 'table datatable-basic',
        ],
        'rowOptions'=>function ($model, $key, $index, $grid){
	        return [
            'data-id'=>$model->id,
	        ];
		    },
		    'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            /*[
	            'attribute'=>'author',
	            'label'=>Yii::t('idev','Author'),
	            'contentOptions' =>function ($model, $key, $index, $column){
	                return ['class' => 'postAuthor'];
	            },
	            'content'=>function($data){
	            		if($data->creator->type==User::TYPE_ADMIN){
	            			return Yii::t('idev','Admin');
	            		}else{
	                	return '<a href="'.IdevFunctions::to('/authors/'.$data->author_id).'">'.$data->creator->username.'</a>';
	            		}
	            }
		        ],*/
            [
	            'label'=>Yii::t('idev','Category'),
	            'contentOptions' =>function ($model, $key, $index, $column){
	                return ['class' => 'postCategory'];
	            },
	            'content'=>function($data){
	            		if(empty($data->category)){
	            			return '<b>'.Yii::t('idev','No').'</b>';
	            		}else{
	                	return '<b><a href="'.IdevFunctions::to('/category/'.$data->category_id).'">'.$data->category->name.'</a></b>';
	            		}
	            }
		        ],
		        [
	            'label'=>Yii::t('idev','Name'),
	            'contentOptions' =>function ($model, $key, $index, $column){
	                return ['class' => 'postName'];
	            },
	            'content'=>function($data){
	            		return '<a href="'.IdevFunctions::to('/news/edit/'.$data->id).'">'.$data->content->name.'</a>';
	            }
		        ],
		        [
	            'label'=>Yii::t('idev','Date'),
	            'contentOptions' =>function ($model, $key, $index, $column){
	                return ['class' => 'postDate'];
	            },
	            'content'=>function($data){
	            		if($data->creator->type==User::TYPE_ADMIN){
	            			$creator = Yii::t('idev','Admin');
	            		}else{
	                	$creator = '<a href="'.IdevFunctions::to('/authors/'.$data->author_id).'">'.$data->creator->username.'</a>';
	            		}
	            		if($data->editor->type==User::TYPE_ADMIN){
	            			$editor = Yii::t('idev','Admin');
	            		}else{
	                	$editor = '<a href="'.IdevFunctions::to('/authors/'.$data->author_id).'">'.$data->editor->username.'</a>';
	            		}
	            		return date('H:i d/m/Y', $data->date).' - <b>'.Yii::t('idev','Author').':</b> '.$creator.'<br/>'.date('H:i d/m/Y', $data->update).' - <b>'.Yii::t('idev','Editor').':</b> '.$editor;
	            }
		        ],
		        [
	            'label'=>Yii::t('idev','Priority'),
	            'contentOptions' =>function ($model, $key, $index, $column){
	                return ['class' => 'postPriority'];
	            },
	            'content'=>function($data){
	            	if($data->priority == 1){
	            		return '<span class="label label-danger">'.Yii::t('idev','Important').'</span>';
	            	}else{
	            		return '<span class="label label-default">'.Yii::t('idev','Plain').'</span>';	            		
	            	}
	            }
		        ],
		        [
	            'label'=>Yii::t('idev','Status'),
	            'contentOptions' =>function ($model, $key, $index, $column){
	                return ['class' => 'postStatus'];
	            },
	            'content'=>function($data){
	            	if($data->status == 1){
	            		return '<span data-action="checkbox" data-id="'.$data->id.'"><input type="checkbox" class="checkbox" id="checkbox_post_'.$data->id.'" checked="checked"><label for="checkbox_post_'.$data->id.'"></label></span>';
	            	}else{
	            		return '<span data-action="checkbox" data-id="'.$data->id.'"><input type="checkbox" class="checkbox" id="checkbox_post_'.$data->id.'"><label for="checkbox_post_'.$data->id.'"></label></span>';
	            	}
	            }
		        ],
        ],
		]);?>
  </div>
</div>

<div id="sortNews" class="modal fade">
	<div class="modal-dialog dsModal">
		<div class="modal-content modal-sm">
			<div class="modal-header p-10">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h5 class="modal-title"><i class="icon-menu7"></i> Modal with icons</h5>
			</div>
			<div class="modal-body p-10">
				<?php $form = ActiveForm::begin(['id'=>'newsSort']); ?>
					<div class="form-group mb-10">
						<label class="m-0"><?=Yii::t('idev','Category')?></label>
						<select class="form-control" name="Sort[category]">
							<option value="0"><?=Yii::t('idev','No')?></option>
							<?php foreach ($data['category'] as $key => $value): ?>
								<option value="<?=$value['id']?>"><?=$value['name']?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group mb-10">
						<label class="m-0"><?=Yii::t('idev','Author')?></label>
						<select class="form-control" name="Sort[author]">
							<option value="0"><?=Yii::t('idev','No')?></option>
							<?php foreach ($data['user'] as $key => $value): ?>
								<option value="<?=$value['id']?>"><?=$value['username']?></option>
							<?php endforeach ?>
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