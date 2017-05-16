<?php
namespace app\modules\aplledore\controllers;
use Yii;
use app\modules\aplledore\models\AplledoreCategory;

class CategoryController extends DevController{
  public function actionIndex($id=NULL) {
  	$this->view->title = 'Категории';
    if (Yii::$app->request->post('Category')) {
      $category = Yii::$app->request->post('Category');
      if ($id) {
        $category['id'] = $id;
      }
      if (AplledoreCategory::contentLoad($category)) {
        return $this->redirect('index');
      }
    }
    if ($id) {
      $this->data['title'] = Yii::t('idev','category edit');
    }else{
      $this->data['title'] = Yii::t('idev','category create');
    }
    return $this->template('index');
  }

  public function actionDelete($id) {
  	$this->view->title = 'Удалить';
    return $this->template('delete');
  }
}
