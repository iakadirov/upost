<?php
namespace app\modules\aplledore\controllers;

use Yii;
use \yii\web\Response;
use \yii\web\UploadedFile;
use \app\modules\aplledore\models\Images;
use app\components\IdevFunctions;
use skeeks\imagine\Image;

class MediaController extends DevController{
  public $paginationLimit = 20;

	public function beforeAction($action){
    $isJsonReturn = ['load-media-image-content','load-media-image-content-offset','upload'];
    if(in_array($action->id, $isJsonReturn)){
		  Yii::$app->response->format = Response::FORMAT_JSON;
    }
    $this->enableCsrfValidation = ($action->id !== "upload");
		return parent::beforeAction($action);
	}

  public function actionIndex(){
    // $image = new Image();
    // $imageName = '0a0271a1f95ea51043b2208d62d5e3059926219d.jpg';
    // $image->thumbnail( Yii::getAlias('@webroot').'/uploads/full/'.$imageName , 200, 200)->save(Yii::getAlias('@webroot').'/uploads/medium/'.$imageName, ['quality' => 80]);
    // echo Yii::getAlias('@webroot').'/uploads/medium/'.$imageName;
    // die;
    return $this->render('index');
  }

  public function actionLoadMediaImageContent(){
    $image = new Images();
    $leftcontent = [];
    if (Yii::$app->request->post('input')) {
      $leftcontent['type'] = Yii::$app->request->post('type');
      $leftcontent['input'] = Yii::$app->request->post('input');
    }
    $content['pagination']['id'] = 'ImagesPagination';
    $content['pagination']['limit'] = $this->paginationLimit;
    $content['pagination']['content'] = 'imagesContent';
    $content['pagination']['leftcontent'] = json_encode($leftcontent);
    $content['pagination']['url'] = IdevFunctions::to('/media/load-media-image-content-offset');
    $images = $image->getImagesList(NULL,$content['pagination']['limit']);
    $content['resContent'] = Yii::$app->request->post('input');
  	$content['content'] = $this->renderPartial('load-media-image-content',['images'=>$images,'pagination'=>$content['pagination'], 'leftcontent'=>$leftcontent]);
  	return $content;
  }

  public function actionLoadMediaImageContentOffset(){
    if($this->isAjax){
      $image = new Images();
      $images = $image->getImagesList(Yii::$app->request->post('offset'),$this->paginationLimit);
      if (!empty($images)) {
        $content['content'] = '';
        foreach($images['content'] as $img){
          $imgUrl = $img['url'];
          if (!empty(Yii::$app->request->post('leftcontent'))) {
            $arr = Yii::$app->request->post('leftcontent');
            if (count($arr) > 0) {
              if ($arr['type'] == 'editor') {
                $button = '<a class="btn btn-success" href="#" data-action="image-add" data-type="editor" data-label="'.$arr['input'].'" data-content="'.$imgUrl.'">Вставить</a>';
              }elseif($arr['type'] == 'minyatura'){
                $button = '<a class="btn btn-success" href="#" data-action="image-add" data-type="minyatura" data-label="'.$arr['input'].'" data-content="'.$imgUrl.'" data-image-id="'.$img['id'].'">Вставить</a>';
              }
            }
          }else{
            $button = '';
          }
          $content['content'] .= '<div class="imageBlock"><figure style="background: url('.$imgUrl.') no-repeat 50%;"></figure>'.$button.'</div>';
        }
        $content['res'] = 'success';
        return $content;
      }else{
        $content['res'] = 'error';
        return $content;
      }

    }
  }

  public function actionUpload(){
    if ($this->isAjax) {
      if (!empty($_FILES['file'])) {
        $image = UploadedFile::getInstanceByName('file');
        $formats = ['.jpg','.gif','.png','.jpeg','.bmp'];
        $imageName = sha1("dishastalker ".rand(1000,9999)).'.'.$image->extension;
        if ($image->saveAs(Yii::getAlias('@webroot').'/uploads/full/'.$imageName)){
          $model = new Images();
          $model->url = Yii::getAlias('@web').'/uploads/full/'.$imageName;
          $model->date = time();
          $model->save(false);
          Image::thumbnail( Yii::getAlias('@webroot').'/uploads/full/'.$imageName , 200, 200)->save(Yii::getAlias('@webroot').'/uploads/medium/'.$imageName, ['quality' => 80]);
          return ['res'=>'success'];
        }else{
          return ['res'=>'error'];
        }
      }
    }
  }
}