<?php
use app\models\User;
use app\components\IdevFunctions;

 ?>
<ul class="navigation navigation-main navigation-accordion">
  <li class="active"><a href="<?=IdevFunctions::to('/')?>"><i class="icon-home4"></i> <span>Aplledore</span></a></li>
  <li class="navigation-header"><span>Loyihalar</span> <i class="icon-menu" title="Main pages"></i></li>
  <li>
    <a href="#"><i class="icon-newspaper"></i> <span>Yangiliklar<span class="label bg-danger-400">25</span></span></a>
    <ul>
      <li><a href="<?=IdevFunctions::to('/news/create')?>"><i class="icon-pencil7"></i> Yangilik yozish<span class="label bg-success-400">Yangi</span></a></li>
      <li class="navigation-divider"></li>
      <li><a href="<?=IdevFunctions::to('/news/new-post-list')?>"><i class="icon-magazine"></i><span>Nashr uchun <span class="label bg-danger-400">25</span></span></a></li>
      <li><a href="<?=IdevFunctions::to('/news/')?>"><i class="icon-server"></i> Barcha xabarlar</a></li>
      <li><a href="<?=IdevFunctions::to('/news/authors')?>"><i class="icon-quill4"></i> Mualliflar</a></li>
      <li><a href="<?=IdevFunctions::to('/news/thems')?>"><i class="icon-archive"></i> Mavzular</a></li>
      <li><a href="<?=IdevFunctions::to('/category/')?>"><i class="icon-list"></i> Kategoriyalar</a></li>
    </ul>
  </li>
  <!-- <li>
    <a href="#"><i class="icon-graduation2"></i> <span>Ta'lim</span></a>
    <ul>
      <li><a href="#"><i class="icon-pencil7"></i>Maqola yozish<span class="label bg-success-400">Yangi</span></a></li>
      <li class="navigation-divider"></li>
      <li><a href="#"><i class="icon-stack-text"></i>Qo'llanmalar</a></li>
      <li><a href="#"><i class="icon-bookmark4"></i>Ingliz tili</a></li>
      <li><a href="#"><i class="icon-stack-check"></i>Maslahatlar</a></li>
    </ul>
  </li>
  <li>
    <a href="#"><i class="icon-fan"></i> <span>Ko'ngilochar</span></a>
    <ul>
      <li><a href="#"><i class="icon-pencil7"></i>Maqola yozish<span class="label bg-success-400">Yangi</span></a></li>
      <li class="navigation-divider"></li>
      <li><a href="#"><i class="icon-stack-text"></i>So'rovnomalar</a></li>
      <li><a href="#"><i class="icon-bookmark4"></i>Testlar</a></li>
      <li><a href="#"><i class="icon-stack-check"></i>O'yinlar</a></li>
    </ul>
  </li>
  <li>
      <a href="#"><i class="icon-clapboard-play"></i> <span>Upost TV&Radio</span></a>
      <ul>
          <li><a href="#"><i class="icon-video-camera"></i>Material kiritish<span class="label bg-success-400">Yangi</span></a></li>
          <li class="navigation-divider"></li>
          <li><a href="#"><i class="icon-play"></i>Videolar</a></li>
          <li><a href="#"><i class="icon-album"></i>Audiolar</a></li>
      </ul>
  </li> -->
  <li><a href="<?=IdevFunctions::to('/comment/')?>"><i class="icon-bubbles2"></i> <span>Izohlar<span class="label bg-indigo-400">74</span></span></a></li>
  <?php if (User::isAdmin()): ?>
  <li class="navigation-divider"></li>
  <li class="navigation-header"><span>Auditoriya</span> <i class="icon-menu" title="Main pages"></i>
  <li>
    <a href="#"><i class="icon-users4"></i> <span>Foydalanuvchilar</span></a>
    <ul>
      <li><a href="<?=IdevFunctions::to('/user/')?>"><i class="icon-users"></i>Barcha o'quvchilar</a></li>
      <li class="navigation-divider"></li>
      <li><a href="<?=IdevFunctions::to('/user/')?>"><i class="icon-user-check"></i>O'quvchilar</a></li>
      <li><a href="<?=IdevFunctions::to('/user/')?>"><i class="icon-vcard"></i>Obunachilar</a></li>
    </ul>
  </li>
  <li><a href="<?=IdevFunctions::to('/feedback')?>"><i class="icon-mail-read"></i> <span>Murojaatlar<span class="label bg-teal-400">14</span></span></a></li>
  <li class="navigation-divider"></li>
  <li class="navigation-header"><span>Sozlamalar</span> <i class="icon-menu" title="Main pages"></i>
  <li><a href="#"><i class="icon-equalizer"></i>Bosh sahifa</a></li>
  <li><a href="#"><i class="icon-clipboard5"></i> Loyihalar</a></li>
  <li><a href="#"><i class="icon-pencil6"></i> Jurnalistlar</a></li>
  <li><a href="#"><i class="icon-grid6"></i> Saidbarlar</a></li>
  <li><a href="<?=IdevFunctions::to('/page')?>"><i class="icon-files-empty2"></i> Sahifalar</a></li>
  <li><a href="<?=IdevFunctions::to('/setting')?>"><i class="icon-cog"></i>Shaxsiy sozlamalar</a></li>
  <li class="navigation-divider"></li>
  <li class="navigation-header"><span>Statistika</span> <i class="icon-menu" title="Main pages"></i>
  <li><a href="#"><i class="icon-drawer3"></i>Statistika</a></li>
  <?php endif ?>
</ul>