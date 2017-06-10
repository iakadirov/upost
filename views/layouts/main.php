<?php
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://fonts.googleapis.com/css?family=Istok+Web:400,700&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&amp;subset=cyrillic" rel="stylesheet">
  </head>
<body>
<?php $this->beginBody() ?>
  <header class="fixed-top header hide-from-print" id="header" role="banner">
    <div class="container">
      <nav class="top-nav">
        <a class="logo" href="#">
          <img src="img/logo.png">
        </a>
        <ul class="menu">                                                  
          <li class="menu-li"><a href="#"><i class="icon"><?=$this->svg['feed']?></i> Tasma</a></li>
          <li class="menu-li"><a href="#">Siyosat</a></li>
          <li class="menu-li"><a href="#">Jamiyat</a></li>
          <li class="menu-li"><a href="#">Iqtisod</a></li>
          <li class="menu-li"><a href="#">Dunyo</a></li>
          <li class="menu-li"><a href="#">Sport</a></li>
          <li class="menu-li"><a href="#">Voqealar</a></li>
        </ul>
        <button class="btn btn-primary btn-sm float-right">Kirish</button>
        <button class="btn btn-default btn-sm float-right" id="userSettings"><?=$this->svg['gear']?>
          <div class="settings" style="display:none;">
            <ul>
              <li>
                <?=$this->svg['globe']?>
                <span>Xabarlar tili<br/>va matni</span>
                <a href="#" class="float-right">Кирилица</a>
              </li>
              <li>
                <?=$this->svg['smile']?>
                <span>Faqat yaxshi<br/>xabarlar</span>
                <a href="#" class="float-right">Кирилица</a>
              </li>
              <li>
                <?=$this->svg['letter-a']?>
                <span>Xabarlar matni<br/>foni rangi</span>
                <a href="#" class="float-right">Кирилица</a>
              </li>
            </ul>
          </div>
        </button>
        <form class="form-inline float-right">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Izlang...">
            <span class="input-group-btn">
              <button class="btn btn-secondary" type="submit"></button>
            </span>
          </div>
        </form>
      </nav>
    </div>
  </header>
  <section class="container">
    <main class="col-12 main">
      <div class="row m-0">
        <?=$content?>
      </div>
    </main>
    <footer class="col-12">
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <h2 class="logo"><img src="img/logo.png"></h2>
          <p class="about">O’zbekiston va jahonda yuz berayotgan voqea, hodisalar haqida tezkor xabarlar.</p>
          <ul class="social socialIcons">
            <li class="facebook"><a href="#" title=""></a></li>
            <li class="twitter"><a href="#" title=""></a></li>
            <li class="linkedin"><a href="#" title=""></a></li>
            <li class="rss"><a href="#" title=""></a></li>
            <li class="youtube"><a href="#" title=""></a></li>
          </ul>
        </div>
        <div class="col-md-9 col-sm-12 right-panel mb-2 pl-0">
          <div class="float-left d-block pl-4">
            <h4>Asosiy</h4>
            <ul class="footer-menu p-0">
              <a href="#">Loyiha haqida</a>
              <a href="#">Bizda ish o’rinlari <span class="label">Yangi</span></a>
              <a href="#">Foydalanish shartlari</a>
              <a href="#">Bog’lanish</a>
            </ul>
          </div>
          <div class="float-left d-block pl-4">
            <h4>Asosiy</h4>
            <ul class="footer-menu p-0">
              <a href="#">Loyiha haqida</a>
              <a href="#">Ish o’rinlari</a>
              <a href="#">Foydalanish shartlari</a>
              <a href="#">Bog’lanish</a>
            </ul>
          </div>
          <div class="n-block ml-4">
            <h4>Yangilik bormi? Maqola yozasizmi?</h4>
            <p>Sizda muxim yoki qiziqarli xabar bo'lsa <a href="#">bizga yuboring!</a></p>
            <p>Siz maqolalar yozsangiz va tarjima qilsangiz <a href="#">biz bilan boglaning!</a></p>
          </div>
          <div class="apps ml-4">
            <h4>Upost mobil ilovasi</h4>
            <a href="#"><img src="img/google-play.png"></a>
            <a href="#"><img src="img/app-store.png"></a>
            <div class="clearfix"></div>
            <h5>Mobil sayt</h5>
            <a href="#" class="btn btn-default">m.upost.uz</a>
          </div>
        </div>
      </div>
      <p class="bottom"><span class="float-left">© 2016-2017  Upost. Barcha huquqlar himoyalangan.</span> <span class="float-right"><img src="img/heart.png"> bilan yaratilgan. Credo</span></p>
    </footer>
  </section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
