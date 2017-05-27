<?php
namespace app\modules\aplledore\controllers;
use Yii;
use app\modules\aplledore\models\AplledoreCategory;
use app\components\IdevFunctions;

class CategoryController extends DevController{
  public function beforeAction($action){
    $arr = ['index'=>['index'],
            'create'=>['index'],
            'edit'=>['index'],
            'delete'=>['delete']];
    if(!$this->__hasRoleUser($arr,$action)){
      $this->redirect(['/aplledore/default/error']);
      return false;
    };
    return parent::beforeAction($action);
  }
  public function actionIndex($id=NULL) {
  	$this->view->title = 'Категории';
    $this->data['content'] = AplledoreCategory::getContentList();
    if ($this->post['Category']) {
      $category = $this->post['Category'];
      if ($id) {
        $category['id'] = $id;
      }
      if (AplledoreCategory::contentLoad($category)) {
        if($id){
          IdevFunctions::setSuccessFlash(Yii::t('idev','category is saved'));
        }else{
          IdevFunctions::setSuccessFlash(Yii::t('idev','category is created'));
        }
        return $this->redirect(['index']);
      }else{
        if($id){
          IdevFunctions::setErrorFlash(Yii::t('idev','category is no saved'));
        }else{
          IdevFunctions::setErrorFlash(Yii::t('idev','category is no created'));
        }
      }
    }
    if ($id) {
      $this->data['title'] = Yii::t('idev','category edit');
      $this->data['category'] = AplledoreCategory::getCategory($id);
    }else{
      $this->data['title'] = Yii::t('idev','category create');
      // $this->data['category'] = [];
    }
    // debug($this->data); die;
    return $this->template('index');
  }
  public function actionDelete($id) {
  	$this->view->title = 'Удалить';
    if (AplledoreCategory::deleteCategory($id)) {
      Yii::$app->session->setFlash('success',Yii::t('idev','category is deleted'));
    }else{
      Yii::$app->session->setFlash('error',Yii::t('idev','category is no deleted'));
    }
    $this->redirect(['index']);
  }
}
