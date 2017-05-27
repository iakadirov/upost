<?php
namespace app\assets;

use yii\web\AssetBundle;

class AplledoreAsset extends AssetBundle{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'web/aplledore/css/icomoon/styles.css',
    'web/aplledore/css/bootstrap.css',
    'web/aplledore/css/core.css',
    'web/aplledore/css/components.css',
    'web/aplledore/css/colors.css',
    'web/aplledore/css/jquery.typeahead.css',
    'web/aplledore/css/dropzone.css',
    'web/aplledore/css/style.css',
  ];
  public $js = [
    'web/aplledore/plugins/tinymce/tinymce.min.js',
    'web/aplledore/js/bootstrap.min.js',
    'web/aplledore/js/blockui.min.js',
    'web/aplledore/js/bootstrap-typeahead.js',
    'web/aplledore/plugins/switch/switch.min.js',
    'web/aplledore/js/dropzone.js',
    'web/aplledore/js/app.js',
  ];
  public $depends = [
    'yii\web\YiiAsset',
  ];
}
