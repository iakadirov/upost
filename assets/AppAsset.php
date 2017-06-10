<?php
namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/bootstrap.css',
    'css/style.css',
  ];
  public $js = [
    'js/jquery.min.js',
    'js/tether.min.js',
    'js/bootstrap.min.js',
    'js/headroom.js',
    'js/jQuery.headroom.js',
    'js/script.js',
  ];
  public $depends = [
    'yii\web\YiiAsset',
  ];
}
