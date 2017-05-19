<?php
namespace app\modules\aplledore\models;

use Yii;
use app\models\Category;
use app\models\CategoryContent;
use app\models\Seo;
use app\components\IdevFunctions;

class AplledoreCategory extends \yii\db\ActiveRecord{
	public static function getCategory($id){
		$content = Category::find()->with('contents')->where(['id'=>$id])->asArray()->one();
		if(!empty($content)){
			if($content['parent_id'] != 0){
				$parent = CategoryContent::find()->select('name')->where(['category_id'=>$content['parent_id'], 'language'=>Yii::$app->params['admin_lang']])->asArray()->one();
				$content['parent'] = $parent['name'];
			}else{
				$content['parent'] = 'Нет';
			}
		}
		return $content;
	}

	public static function getContentList(){
		return Category::find()->with('content')->asArray()->all();
	}

	public static function contentLoad($content){
		if (isset($content['id'])) {
			return self::editCategory($content);
		}else{
			$content = self::addCryl($content);
			return self::createCategory($content);
		}
		return $content;
	}

	public static function deleteCategory($id){
		if (is_array($id) && count($id) > 1) {
			if( Category::deleteAll(['in','id',$id]) && CategoryContent::deleteAll(['in','category_id',$id]) && CategorySeo::deleteAll(['in','category_id',$id]) ) {
				$res['res'] = true;
			}else{
				$res['res'] = false;
			}
		}elseif(count($id) == 1){
			$res['res'] = self::__deleteOne($id);
		}elseif(is_numeric($id)){
			$res['res'] = self::__deleteOne($id);
		}

		if ($res['res'] === TRUE) {
			$res['res'] = 'success';
			$res['text'] = 'Готова!';
			return json_encode($res);
		}else{
			$res['res'] = 'error';
			$res['text'] = 'Упс! Что-то пошла не так!';
			return json_encode($res);
		}
	}

	public static function editBeforeDelete($data){
		if( isset($data['delete_id']) && isset($data['new_parent']) ){
			$res = Yii::$app->db->createCommand()->update('Category', ['parent_id' => (int)$data['new_parent']], 'parent_id = '.(int)$data['delete_id'])->execute();
			if ($res && self::__deleteOne((int)$data['delete_id'])) {
				return json_encode([
					'res'=>'success',
					'text'=>'Готова!',
				]);
			}else{
				return json_encode([
					'res'=>'error',
					'content'=>'Упс! Что-то пошла не так!',
				]);
			}
		}
	}

	protected function addCryl($content){
		$content[2]['name'] = IdevFunctions::translit($content[1]['name']);
		$content[2]['parent'] = $content[1]['parent'];
		$content[2]['content'] = IdevFunctions::translit($content[1]['content']);
		return $content;
	}

	protected function __deleteOne($id){
		$category = Category::findOne($id);
		if (!empty($category) && $category->delete()) {
			CategoryContent::deleteAll(['category_id'=>$id]);
			CategorySeo::deleteAll(['category_id'=>$id]);
			return true;
		}else{
			return false;
		}
	}

	protected function createCategory($content){
		$category = new Category();
		$category->parent_id = $content[1]['parent'];
		$category->date = time();
		$category->update = time();
		if($category->save()){
			foreach (Yii::$app->params['langs'] as $key => $value) {
				$categoryContent = new CategoryContent();
				$categoryContent->category_id = $category->id;
				$categoryContent->language = $key;
				$categoryContent->name = $content[$key]['name'];
				$categoryContent->content = $content[$key]['content'];
				$categoryContent->save();
				$categorySeo = new Seo();
				$categorySeo->parent_id = $category->id;
				$categorySeo->type = 'category';
				$categorySeo->language = $key;
				$categorySeo->title = $categoryContent->name;
				$categorySeo->keywords = $categoryContent->name;
				$categorySeo->description = $categoryContent->name;
				$categorySeo->save();
			}
			return true;
		}else{
			return false;
		}
	}

	protected function editCategory($content){
		$category = Category::findOne($content['id']);
		$category->parent_id = $content[1]['parent'];
		$category->update = time();
		if($category->save()){
			foreach (Yii::$app->params['langs'] as $key => $value) {
				$categoryContent = CategoryContent::find()->where(['category_id'=>$category->id, 'language'=>$key])->one();
				$categoryContent->name = $content[$key]['name'];
				$categoryContent->content = $content[$key]['content'];
				$categoryContent->save();
			}
			return true;
		}
		return false;
	}
}