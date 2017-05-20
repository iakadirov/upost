<?php

use yii\helpers\Html;
use app\components\IdevFunctions;
use app\components\MenuWidget;
use app\assets\AplledoreAsset;
use app\models\User;

AplledoreAsset::register($this);
?>
<!DOCTYPE html>
<html lang="uz">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><strong>Upost Administrator</strong></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>
		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-bell3"></i>
						<span class="visible-xs-inline-block position-right">Tezkor xabarlar</span>
						<span class="badge bg-warning-400">9</span>
					</a>
					
					<div class="dropdown-menu dropdown-content">
						<div class="dropdown-content-heading">
							Tezkor xabarlar
							<ul class="icons-list">
								<li><a href="#"><i class="icon-sync"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body width-350">
							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-bell2"></i></a>
								</div>

								<div class="media-body">
									<a href="#">Mobil muxbir jo'natgan xabar sarlavhasi mana shu yerga yoziladi.</a>
									<div class="media-annotation">4 minut avval</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-bell2"></i></a>
								</div>

								<div class="media-body">
									<a href="#">Mobil muxbir jo'natgan xabar sarlavhasi mana shu yerga yoziladi.</a>
									<div class="media-annotation">4 minut avval</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-bell2"></i></a>
								</div>

								<div class="media-body">
									<a href="#">Mobil muxbir jo'natgan xabar sarlavhasi mana shu yerga yoziladi.</a>
									<div class="media-annotation">4 minut avval</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-bell2"></i></a>
								</div>

								<div class="media-body">
									<a href="#">Mobil muxbir jo'natgan xabar sarlavhasi mana shu yerga yoziladi.</a>
									<div class="media-annotation">4 minut avval</div>
								</div>
							</li>
						</ul>

						<div class="dropdown-content-footer">
							<a href="#" data-popup="tooltip" title="Barchasi"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="assets/images/placeholder.jpg" alt="">
						<span>Ibragim Kadirov</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#"><i class="icon-user-plus"></i> Profilim</a></li>
						<li><a href="#"><span class="badge bg-teal-400 pull-right">28</span> <i class="icon-comment-discussion"></i> Xabarlarim</a></li>
						<li class="divider"></li>
						<li><a href="#"><i class="icon-switch2"></i> Chiqish</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="page-container">
	  <div class="page-content">
	    <div class="sidebar sidebar-main">
	      <div class="sidebar-content">
	        <div class="sidebar-user">
	          <div class="category-content">
	            <div class="media">
	              <a href="#" class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
	              <div class="media-body">
	                <span class="media-heading text-semibold">Ibragim Kadirov</span>
	                <div class="text-size-mini text-muted">
	                  <i class="icon-user-tie text-size-small"></i> &nbsp;<?=User::isAdmin()?'Administrator':'Moderator'?>
	                </div>
	              </div>
	              <div class="media-right media-middle">
	                <ul class="icons-list">
	                  <li>
	                    <a href="#"><i class="icon-cog3"></i></a>
	                  </li>
	                </ul>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class="sidebar-category sidebar-category-visible">
	          <div class="category-content no-padding">
	            <?=$this->context->renderPartial('/mini_view/__sidebar-menu')?>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="content-wrapper">
	      <div class="page-header page-header-default">
	        <div class="page-header-content">
	          <div class="page-title">
	            <h4><span class="text-semibold"><?=$this->title;?></span></h4>
	          </div>
	        </div>
	      </div>
	      <?php if (Yii::$app->session->hasFlash('error')): ?>
		      <div class="alert alert-error alert-styled-left alert-arrow-left alert-bordered m-10">
						<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
						<span class="text-semibold"><?=Yii::$app->session->getFlash('error')?></span>
			    </div>
	      <?php endif ?>
	      <?php if (Yii::$app->session->hasFlash('success')): ?>
		      <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered m-10">
						<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
						<span class="text-semibold"><?=Yii::$app->session->getFlash('success')?></span>
			    </div>
	      <?php endif ?>
				<?=$content?>
				<div class="footer text-muted col-xs-12">
          &copy; <?=date('Y',time())?>. <a>Upost | Ўзбекистон ва жаҳоннинг энг сўнгги янгиликлари.</a>
        </div>
			</div>
		</div>
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>