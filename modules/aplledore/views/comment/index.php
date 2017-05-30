<?php 
	use app\components\IdevFunctions;
	use yii\widgets\LinkPager;
	use app\models\User;

/*$sort = Yii::$app->session->get('sort_'.Yii::$app->controller->id);
if (isset($sort['status'])) {
	$status = $sort['status'];
}else{
	$status = 'all';
}*/
?>	
<div class="content">
  <div class="panel panel-flat">
    <!-- <div class="panel-heading mb-10 o-h p-0">
      <div class="pull-right o-h">
        <ul class="icons-list m-0">
          <li><a href="#" class="btn btn-primary text-white" data-toggle="modal" data-target="#sortNews"><b> <#?=Yii::t('idev','Sort')?></b></a></li>
          <li><a href="<#?=IdevFunctions::to('/news/create')?>" class="btn btn-success text-white"><b> <#?=Yii::t('idev','Create news')?></b></a></li>
        </ul>
      </div>
    </div> -->
    <?php debug($data['users']) ?>
    <?php debug($data['post']) ?>
    <!-- <#?= debug(app\models\Post::find()->with('content','category')->all())?> -->
    <?php echo LinkPager::widget(['pagination' => $data['pages']]); ?>
  </div>
</div>
