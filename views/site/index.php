<?php 
use app\components\IdevFunctions;
// $svg = IdevFunctions::svg();
// debug($this->svg); die;
 ?>
<div class="col-9 content">
	<div class="alert alert-danger d-flex align-items-center">
		<div class="alert-left">
			Diqqat!
			<small>Muhim xabar</small>
		</div>
		<a href="#"><p>Shavkat Mirziyoyev 14-dekabr kuni O‘zbekiston Prezidenti sifatida qasamyod qilishi kutilmoqda</p></a>
		<span class="close-alert">&times;</span>
	</div>
	<article class="container-block last-news">
		<h1><a href="#">Eng so’nggi yangiliklari</a></h1>
		<div class="row2">
			<div class="col-3 big-block">
				<a href="#"><img src="img/m.jpg" class="img-fluid"></a>
				<h2><a href="#">Isroil va Kuba rahbarlari Shavkat Mirziyoyevni tabrikladi</a></h2>
				<ul>
					<li><i class="icon"><?=$this->svg['clock']?></i> 19:53, Bugun</li>
					<li><i class="icon"><?=$this->svg['layer']?></i> Siyosat</li>
				</ul>
			</div>
			<div class="col-3 big-block">
				<a href="#"><img src="img/m-m2.jpg" class="img-fluid"></a>
				<h2><a href="#">Bosh vazir prezidentni dafn etish bo'yicha tashkil etilgan komissiyaga boshchilik qiladi</a></h2>
				<ul>
					<li><i class="icon"><?=$this->svg['clock']?></i> 19:53, Bugun</li>
					<li><i class="icon"><?=$this->svg['layer']?></i> Siyosat</li>
				</ul>
			</div>
			<div class="col-3 big-block">
				<a href="#"><img src="img/m-m.jpg" class="img-fluid"></a>
				<h2><a href="#">Isroil va Kuba rahbarlari Shavkat Mirziyoyevni tabrikladi</a></h2>
				<ul>
					<li><i class="icon"><?=$this->svg['clock']?></i> 19:53, Bugun</li>
					<li><i class="icon"><?=$this->svg['layer']?></i> Siyosat</li>
				</ul>
			</div>
			<div class="col-3 big-block">
				<a href="#"><img src="img/m-m2.jpg" class="img-fluid"></a>
				<h2><a href="#">Isroil va Kuba rahbarlari Shavkat Mirziyoyevni tabrikladi</a></h2>
				<ul>
					<li><i class="icon"><?=$this->svg['clock']?></i> 19:53, Bugun</li>
					<li><i class="icon"><?=$this->svg['layer']?></i> Siyosat</li>
				</ul>
			</div>
			<div class="col-3 big-block">
				<a href="#"><img src="img/m-m.jpg" class="img-fluid"></a>
				<h2><a href="#">Isroil va Kuba rahbarlari Shavkat Mirziyoyevni tabrikladi</a></h2>
				<ul>
					<li><i class="icon"><?=$this->svg['clock']?></i> 19:53, Bugun</li>
					<li><i class="icon"><?=$this->svg['layer']?></i> Siyosat</li>
				</ul>
			</div>
		</div>
	</article>
	<article class="container-block no-bg">
		<div class="w-100">
			<h1><a href="#">Jamiyat</a></h1>
			<ul class="block-menu">
				<li><a href="#">Donald Tramp</a></li>
				<li><a href="#">Suriya</a></li>
				<li><a href="#">Rossiya elchisi</a></li>
				<li><a href="#">ISHID</a></li>
			</ul>
		</div>
		<div class="row2 block2">
			<div class="col-3 big-block">
				<a href="#" class="img"><img src="img/m.jpg" class="img-fluid"></a>
				<h2><a href="#">Isroil va Kuba rahbarlari Shavkat Mirziyoyevni tabrikladi</a></h2>
			</div>
			<div class="col-3 big-block">
				<a href="#" class="img"><img src="img/m.jpg" class="img-fluid"></a>
				<h2><a href="#">Bosh vazir prezidentni dafn etish bo'yicha tashkil etilgan komissiyaga boshchilik qiladi</a></h2>
			</div>
			<div class="col-3 big-block">
				<a href="#" class="img"><img src="img/m.jpg" class="img-fluid"></a>
				<h2><a href="#">Isroil va Kuba rahbarlari Shavkat Mirziyoyevni tabrikladi</a></h2>
			</div>
			<div class="col-3 big-block">
				<a href="#" class="img"><img src="img/m.jpg" class="img-fluid"></a>
				<h2><a href="#">Isroil va Kuba rahbarlari Shavkat Mirziyoyevni tabrikladi</a></h2>
			</div>
		</div>
	</article>
	<article class="container-block no-bg top-border">
		<div class="w-100">
			<h1><a href="#">Dunyo</a></h1>
			<ul class="block-menu list-tab">
				<li><a href="#">So'nhi</a></li>
				<li><a href="#">Suriya</a></li>
				<li><a href="#">Rossiya elchisi</a></li>
				<li><a href="#">ISHID</a></li>
			</ul>
		</div>
		<div class="col-12"></div>
		<div class="row2 block-list">
			<?php for ($i=0; $i < 10; $i++):?>
				<div class="col-12">
					<a href="#">
						<img src="img/m.jpg" class="img-fluid">
						<span id="favorite" data-toggle="tooltip" data-placement="top" title="Saqlab qo'yish"><?=$this->svg['unfavorite']?></span>
					</a>
					<figure>	
						<h2><a href="#">Isroil va Kuba rahbarlari Shavkat Mirziyoyevni tabrikladi</a></h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat.</p>
						<ul>
							<li><i class="icon"><?=$this->svg['clock'];?></i> 19:53, Bugun</li>
							<li><i class="icon"><?=$this->svg['layer'];?></i> Siyosat</li>
							<li><i class="icon"><?=$this->svg['comment'];?></i> 2 ta izox</li>
						</ul>
					</figure>
				</div>
			<?php endfor; ?>
			<div class="col-12 text-center" id="loadMore">
				<button class="btn btn-primary"><i class="icon"><?=$this->svg['loadmore']?></i> Ko'proq yangilik <i class="icon"><?=$this->svg['loadmore']?></i></button>
			</div>
		</div>
	</article>
</div>
<div class="col-3 sidebar">
	<div class="sidebar-block upost">
		<h1>Upost <span>So'ngi yangiliklar<br/>qulay va tez</span></h1>
		<div>
			<h3>Upost yangiliklar portalning barcha imkoniyatlarini bilasizmi?</h3>
			<p>- Yangiliklarni saralash</p>
			<p>- Mualliflarga obuna bo’lish</p>
			<p>- «Keyin o’qish» tizimi</p>
			<p>- «Yaxshi xabarlar» rejimi</p>
			<p>- Reklama bannerlari yo’q. </p>
			<p>  Rostdan shunaqami?</p>
			<a href="#" class="btn btn-primary">Batafsil bilish <?=$this->svg['chevron-right']?></a>
		</div>
	</div>
	<div class="sidebar-block">
		<h3 class="title">Ko’p o’qilgan xabarlar</h3>
		<ul class="sub-lenta">
			<li><a href="#">Lola Yo‘ldosheva: Erkaklar bu ishni to‘lig‘icha tushunib, his eta olmasa kerak</a><img src="img/m-m3.jpg"></li>
			<li><a href="#">Lola Yo‘ldosheva: Erkaklar bu ishni to‘lig‘icha tushunib, his eta olmasa kerak</a><img src="img/m-m3.jpg"></li>
			<li><a href="#">Lola Yo‘ldosheva: Erkaklar bu ishni to‘lig‘icha tushunib, his eta olmasa kerak</a><img src="img/m-m3.jpg"></li>
			<li><a href="#">Lola Yo‘ldosheva: Erkaklar bu ishni to‘lig‘icha tushunib, his eta olmasa kerak</a><img src="img/m-m3.jpg"></li>
			<li><a href="#">Lola Yo‘ldosheva: Erkaklar bu ishni to‘lig‘icha tushunib, his eta olmasa kerak</a><img src="img/m-m3.jpg"></li>
		</ul>
	</div>
</div>