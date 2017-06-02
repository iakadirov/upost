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
    <table class="table table-hover table-bordered">
      <tbody>
        <?php foreach ($data['content'] as $comment): ?>
          <tr class="<?=$comment['status']==0?'danger':''?>">
            <td>
              <p class="mb-0"><b><?=Yii::t('idev','Content').':</b> '.$comment['content']?></p>
              <p class="mb-0"><b><?=Yii::t('idev','Post').':</b> '.$data['post'][$comment['post_id']]['name']?></p>
              <p class="mb-0"><b>
                <?=Yii::t('idev','Author').':</b> '.$data['users'][$comment['user_id']]['username'].' '.Yii::t('idev','in').' '.date('Y-d-m H:i',$comment['date'])?>
                <?=$comment['replay_author_id'] != 0?Yii::t('idev','responded to').' '.$data['users'][$comment['replay_author_id']]['username']:''?>
              </p>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <!-- <#?php debug($data['content']); ?> -->
    <!-- <#?php debug($data['users']) ?> -->
    <!-- <#?php debug($data['post']) ?> -->
    <!-- <#?= debug(app\models\Post::find()->with('content','category')->all())?> -->
    <?php echo LinkPager::widget(['pagination' => $data['pages']]); ?>
  </div>
</div>
