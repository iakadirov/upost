<div class="content">
  <div class="panel panel-flat">
  <h1><?= date('Y-m-d H:i', 1498393507);?></h1>
    <?=debug(Yii::$app->user->identity)?>
    <?=debug(Yii::$app->params)?>
  </div>
</div>