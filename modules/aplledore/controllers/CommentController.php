<?php
namespace app\modules\aplledore\controllers;
use Yii;
use app\modules\aplledore\models\AplledoreComment;
use app\components\IdevFunctions;
use yii\data\ActiveDataProvider;

class CommentController extends DevController{
  public function actionIndex() {
  	$this->view->title = Yii::t('idev','Comment');
    $content = AplledoreComment::getContentList();
    debug($content); die;
    $this->data['dataProvider'] = new ActiveDataProvider([
      'query' => $content,
      'pagination' => [
          'defaultPageSize' => 15,
      ],
    ]);
    return $this->template('index');
  }

  public function actionDelete($id) {
    if (AplledoreComment::deleteThema($id)) {
      Yii::$app->session->setFlash('success',Yii::t('idev','thema is deleted'));
    }else{
      Yii::$app->session->setFlash('error',Yii::t('idev','thema is no deleted'));
    }
    $this->redirect(['index']);
  }
}
