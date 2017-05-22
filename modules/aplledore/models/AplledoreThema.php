<?php
namespace app\modules\aplledore\models;

use Yii;
use app\models\Thema;
use app\models\ThemaContent;
use app\models\Seo;
use app\components\IdevFunctions;

class AplledoreThema extends \yii\db\ActiveRecord{
	public static function getThema($id){
		$content = Thema::find()->with('contents')->where(['id'=>$id])->asArray()->one();
		return $content;
	}

	public static function getContentList(){
		return Thema::find()->with('content')->asArray()->all();
	}

	public static function contentLoad($content){
		if (isset($content['id'])) {
			return self::editThema($content);
		}else{
			$content = self::addCryl($content);
			return self::createThema($content);
		}
		return $content;
	}

	public static function deleteThema($id){
		$content = Thema::findOne($id);
		if(!empty($content)){
			Yii::$app->db->createCommand()->update('post', ['thema_id' => 0], 'thema_id = '.$id)->execute();
			if($content->delete()){
				ThemaContent::deleteAll(['thema_id'=>$content->id]);
				return true;
			}
		}
		return false;
	}

	protected function addCryl($content){
		$content[2]['name'] = IdevFunctions::translit($content[1]['name']);
		return $content;
	}

	protected function createThema($content){
		$thema = new Thema();
		$thema->date = time();
		$thema->update = time();
		if($thema->save()){
			foreach (Yii::$app->params['langs'] as $key => $value) {
				$themaContent = new ThemaContent();
				$themaContent->thema_id = $thema->id;
				$themaContent->language = $key;
				$themaContent->name = $content[$key]['name'];
				$themaContent->save();
				$themaSeo = new Seo();
				$themaSeo->parent_id = $thema->id;
				$themaSeo->type = 'thema';
				$themaSeo->language = $key;
				$themaSeo->title = $themaContent->name;
				$themaSeo->keywords = $themaContent->name;
				$themaSeo->description = $themaContent->name;
				$themaSeo->save();
			}
			return true;
		}else{
			return false;
		}
	}

	protected function editThema($content){
		$thema = Thema::findOne($content['id']);
		$thema->update = time();
		if($thema->save()){
			foreach (Yii::$app->params['langs'] as $key => $value) {
				$themaContent = ThemaContent::find()->where(['thema_id'=>$thema->id, 'language'=>$key])->one();
				$themaContent->name = $content[$key]['name'];
				$themaContent->save();
			}
			return true;
		}
		return false;
	}
}