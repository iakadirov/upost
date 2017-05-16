<?php
namespace app\components;
use yii\base\Widget;

class MenuWidget extends Widget{
  public function init(){
    parent::init();
    if (empty($this->data)) {
      $this->data = \app\modules\idev\models\IdevCategory::getCategoryList();
    }
  }

  public function run(){
  }
} 