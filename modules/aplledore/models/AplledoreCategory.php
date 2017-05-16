<?php
namespace app\modules\aplledore\models;

use Yii;
use app\models\Category;
use app\models\CategoryContent;
use app\models\Seo;
use app\components\IdevFunctions;

class AplledoreCategory extends \yii\db\ActiveRecord{
	public static function getCategory($id,$ids=NULL){
		$content = Category::find()->with('contents')->where(['id'=>$id])->asArray()->one();
		if($content['parent_id'] != 0){
			$parent = CategoryContent::find()->select('name')->where(['category_id'=>$content['parent_id'], 'language'=>Yii::$app->params['admin_lang']])->asArray()->one();
			$content['parent'] = $parent['name'];
		}else{
			$content['parent'] = 'Нет';
		}
		if (isset($ids) && is_array($ids)) {
			$menu = Category::find()->where(['not in','category.id',$ids])->asArray()->indexBy('id')->with('content')->all();
			$content['menu_list'] = MenuWidget::widget(['attr'=>['class'=>'dsSelectList'], 'data'=>$menu]);
		}
		return $content;
	}

	public static function getCategoryList(){
		return Category::find()->with('content')->asArray()->all();
	}

	public static function contentLoad($content){
		$content = self::addCryl($content);
		// if (isset($content['id'])) {
		// 	return self::editCategory($content);
		// }else{
		// 	return self::createCategory($content);
		// }
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
		$res = [];
		if (empty($content[Yii::$app->params['admin_lang']]['name'])) {
			foreach (Yii::$app->params['langs'] as $key => $value) {
				if (!empty($content[$key]['name'])) {
					$name = $content[$key]['name'];
					break;
				}
			}
			if (!isset($name)) {
				$res['content']['all'] = 'empty';
				return $res;
			}
		}else{
			$name = $content[Yii::$app->params['admin_lang']]['name'];
		}
		$category = new Category();
		$category->parent_id = $content['parent'];
		if (isset($content[Yii::$app->params['admin_lang']]['position'])) {
			$category->position = $content[Yii::$app->params['admin_lang']]['position'];
		}else{
			$category->position = 0;
		}
		if($category->save()){
			$res['category'] = 'success';
			foreach (Yii::$app->params['langs'] as $key => $value) {
				$categoryContent = new CategoryContent();
				$categoryContent->category_id = $category->id;
				$categoryContent->language = $key;
				if (!empty($content[$key]['name'])) {
					$categoryContent->name = $content[$key]['name'];
				}else{
					$categoryContent->name = $name;
				}
				$categoryContent->content = $content[$key]['content'];
				$categoryContent->image = $content['image'];
				if($categoryContent->save()){
					$res['content'][$key] = 'success';
				}else{
					$res['content'][$key] = 'error';
				}
				$categorySeo = new CategorySeo();
				$categorySeo->category_id = $category->id;
				$categorySeo->language = $key;
				$categorySeo->title = $categoryContent->name;
				$categorySeo->keywords = $categoryContent->name;
				$categorySeo->description = $categoryContent->name;
				if($categorySeo->save()){
					$res['seo'][$key] = 'success';
				}else{
					$res['seo'][$key] = 'error';
				}
			}
		}else{
			$res['category'] = 'error';
		}
		return $res;
	}

	protected function editCategory($content){
		$res = [];
		$isEmpty = true;
		foreach (Yii::$app->params['langs'] as $key => $value) {
			if (!empty($content[$key]['name'])) {
				$isEmpty = false;
			}
		}
		if ($isEmpty) {
			$res['content']['all'] = 'empty';
		}else{
			$category = Category::findOne($content['id']);
			$category->parent_id = $content['parent'];
			if($category->save()){
				$res['category'] = 'success';
				foreach (Yii::$app->params['langs'] as $key => $value) {
					$categoryContent = CategoryContent::find()->where(['category_id'=>$category->id, 'language'=>$key])->one();
					if (!empty($content[$key]['name'])) {
						$categoryContent->name = $content[$key]['name'];
					}
					$categoryContent->content = $content[$key]['content'];
					$categoryContent->image = $content['image'];
					if($categoryContent->save()){
						$res['content'][$key] = 'success';
					}else{
						$res['content'][$key] = 'error';
					}

					$categorySeo = CategorySeo::find()->where(['category_id'=>$category->id, 'language'=>$key])->one();
					if (!empty($content[$key]['name'])) {
						$categorySeo->title = $content[$key]['name'];
						if($categorySeo->save()){
							$res['seo'][$key] = 'success';
						}else{
							$res['seo'][$key] = 'error';
						}
					}else{
						$res['seo'][$key] = 'empty';
					}
				}
			}else{
				$res['category'] = 'error';
			}
		}
		return $res;
	}
}