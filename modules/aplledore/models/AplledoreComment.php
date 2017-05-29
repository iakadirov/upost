<?php
namespace app\modules\aplledore\models;

use Yii;
use app\models\Comment;
use app\models\User;
use app\components\IdevFunctions;

class AplledoreComment extends \yii\db\ActiveRecord{
	public static function getComment($id){
		$content = Comment::find()->with('contents')->where(['id'=>$id])->asArray()->one();
		return $content;
	}

	public static function getContentList(){
		$content['comments'] = Comment::find()->with('childs')->where(['parent_id'=>0])->asArray()->all();
		$ids = [];
		foreach ($content['comments'] as $item) {
			$ids[$item['user_id']] = $item['user_id'];
			foreach ($item['childs'] as $child) {
				$ids[$child['user_id']] = $child['user_id'];
			}
		}
		$content['users'] = User::find()->select('id,username,first_name,last_name')->where(['in','id', $ids])->indexBy('id')->asArray()->all();
		return $content;
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

	public static function deleteContent($id){
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

	protected function editContent($content){
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