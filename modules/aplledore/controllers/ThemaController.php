<?php
namespace app\modules\aplledore\controllers;
use Yii;
use app\modules\aplledore\models\AplledoreThema;
use app\components\IdevFunctions;

class ThemaController extends DevController{
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
  	$this->view->title = Yii::t('idev','Thems');
    $this->data['content'] = AplledoreThema::getContentList();
    if ($this->post['Thema']) {
      $thema = $this->post['Thema'];
      if ($id) {
        $thema['id'] = $id;
      }
      if (AplledoreThema::contentLoad($thema)) {
        if($id){
          Yii::$app->session->setFlash('success',Yii::t('idev','thema is saved'));
        }else{
          Yii::$app->session->setFlash('success',Yii::t('idev','thema is created'));
        }
        return $this->redirect(['index']);
      }else{
        if($id){
          Yii::$app->session->setFlash('error',Yii::t('idev','thema is no saved'));
        }else{
          Yii::$app->session->setFlash('error',Yii::t('idev','thema is no created'));
        }
      }
    }
    if ($id) {
      $this->data['title'] = Yii::t('idev','thema edit');
      $this->data['thema'] = AplledoreThema::getThema($id);
    }else{
      $this->data['title'] = Yii::t('idev','thema create');
      // $this->data['thema'] = [];
    }
    // debug($this->data); die;
    return $this->template('index');
  }

  public function actionDelete($id) {
    if (AplledoreThema::deleteThema($id)) {
      Yii::$app->session->setFlash('success',Yii::t('idev','thema is deleted'));
    }else{
      Yii::$app->session->setFlash('error',Yii::t('idev','thema is no deleted'));
    }
    $this->redirect(['index']);
  }
}
