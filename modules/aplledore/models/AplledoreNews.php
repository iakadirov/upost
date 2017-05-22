<?php
namespace app\modules\aplledore\models;

use Yii;
use app\models\Post;
use app\models\PostContent;
use app\models\Seo;
use app\models\PostTag;
use app\models\Tag;
use app\models\ThemaContent;
use app\models\Category;

class AplledoreNews extends \yii\db\ActiveRecord{
	public static function getPostList($limit, $offset=NULL){
		if (Yii::$app->session->has('sort_'.Yii::$app->controller->id)) {
			$session = Yii::$app->session;
			$post = Post::find();
			if ( $session['sort_'.Yii::$app->controller->id]['data_from'] > 0 ) {
				$post->where(['>=','date',$session['sort_'.Yii::$app->controller->id]['data_from']]);
			}else{
				$post->where(['>=','date',0]);
			}
			if ( $session['sort_'.Yii::$app->controller->id]['data_to'] > 0 ) {
				$post->andWhere(['<=','date',$session['sort_'.Yii::$app->controller->id]['data_to']]);
			}
			if( $session['sort_'.Yii::$app->controller->id]['status'] == 'active' ){
				$post->andWhere(['status'=>1]);
			}elseif( $session['sort_'.Yii::$app->controller->id]['status'] == 'deactive' ){
				$post->andWhere(['status'=>1]);
			}
			if ($session['sort_'.Yii::$app->controller->id]['category'] > 0) {
				$cats = PostCategory::find()->where(['category_id'=>$session['sort_'.Yii::$app->controller->id]['category']])->asArray()->all();
				if (!empty($cats)) {
					$arr = [];
					foreach ($cats as $item) {
						$arr[] = $item['post_id'];
					}
					$post->andWhere(['in','id',$arr]);
				}else{
					return 0;
				}
			}
			$count = clone($post);
			$res['count'] = $count->count();
			if ($offset) {
				$res['content'] = $post->with('content','postCategory')->limit($limit)->offset($offset)->asArray()->all();
			}else{
				$res['content'] = $post->with('content','postCategory')->limit($limit)->asArray()->all();
			}
		}else{
			$res['count'] = Post::find()->count();
			if ($offset) {
				$res['content'] = Post::find()->with('content','postCategory')->limit($limit)->offset($offset)->asArray()->all();
			}else{
				$res['content'] = Post::find()->with('content','postCategory')->limit($limit)->asArray()->all();
			}
		}
		return $res;
	}

	public static function getContent($id){
		return Post::find()->with('contents','categorys','tags')->where(['id'=>$id])->asArray()->one();
	}

	public static function getContentByIds($ids){
		if (is_array($ids) && count($ids) > 0) {
			$content = Post::find()->select('id')->with('content')->where(['in','id',$ids])->asArray()->all();
			/* нужно проверить права доступ */
			return json_encode(['res'=>'success','text'=>Yii::t('idev','confirm delete'),'button'=>Yii::t('idev','delete')]);
		}else{
			return json_encode(['res'=>'info','text'=>Yii::t('idev','checked posts'),'button'=>Yii::t('idev','close')]);
		}
	}

	public static function getSearchTagList($name,$ids=NULL){
		if ($ids && count(json_decode($ids)) > 0) {
			$ids = json_decode($ids);
			$content = Tag::find()->where(['not in','id',$ids])->andWhere(['like','name',$name])->asArray()->limit(10)->all();
		}else{
			$content = Tag::find()->where(['like','name',$name])->asArray()->limit(10)->all();
		}
		$arr = [];
		if (!empty($content)) {
			foreach ($content as $tag) {
				$arr[] = ["id"=>$tag['id'],"name"=>$tag['name']." (".Yii::$app->params['langs'][$tag['language']]['code'].")"];
			}
		}
		return json_encode($arr);
	}

	public static function getSearchThemaList($name,$ids=NULL){
		$content = ThemaContent::find()->where(['like','name',$name])->asArray()->limit(10)->all();
		$arr = [];
		if (!empty($content)) {
			foreach ($content as $tag) {
				$arr[] = ["id"=>$tag['thema_id'],"name"=>$tag['name']];
			}
		}
		return json_encode($arr);
	}

	public static function getSortContent(){
		$content['categorys'] = Category::find()->select('category.id')->with('contentName')->asArray()->all();
		return $content;
	}

	public static function contentLoad($post){
		if(!empty($post)){
			if(isset($post['id'])){
				return self::editPost($post);
			}else{
				return self::createPost($post);
			}
		}else{
			return false;
		}
	}

	public static function deleteContent($arr){
		if(is_array($arr) && count($arr) > 0){
			if( Post::deleteAll(['in','id',$arr]) && PostContent::deleteAll(['in','post_id',$arr]) && Seo::deleteAll(['and',['in','parent_id',$arr],['type'=>'post']]) ) {
				PostCategory::deleteAll(['in','post_id',$arr]);
				PostTag::deleteAll(['in','post_id',$arr]);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public static function checkStatus($action,$id){
		$post = Post::findOne($id);
		if ($action == 'active') {
			$post->status = 1;
		}elseif($action == 'deactive'){
			$post->status = 0;
		}elseif($action == 'delete'){
			$post->status = -1;
		}
		if($post->save()){
			return true;
		}else{
			return false;
		}
	}

	protected function createPost($post){
		if (!empty($post[Yii::$app->params['default_lang']]['name'])) {
			$content = new Post;
			$content->date = time();
			$content->update = time();
			$content->status = 1;
			if ($content->save()) {
				foreach (Yii::$app->params['langs'] as $key => $value) {
					$post_content = new PostContent;
					$post_content->post_id = $content->id;
					$post_content->language = $key;
					if (empty($post[$key]['name'])) {
						$post_content->name = $post[Yii::$app->params['default_lang']]['name'];
					}else{
						$post_content->name = $post[$key]['name'];
					}
					$post_content->excerpt = $post[$key]['excerpt'];
					$post_content->content = $post[$key]['content'];
					$post_content->image = $post['image'];
					$post_content->save();
					$post_seo = new Seo;
					$post_seo->parent_id = $content->id;
					$post_seo->type = 'post';
					$post_seo->language = $key;
					if (empty($post[$key]['name'])) {
						$post_seo->title = $post[Yii::$app->params['default_lang']]['name'];
					}else{
						$post_seo->title = $post[$key]['name'];
					}
					$post_seo->keywords = $post[$key]['name'];
					$post_seo->description = $post[$key]['name'];
					$post_seo->save();
				}
				$cats = json_decode($post['category'],true);
				if (count($cats) > 0) {
					// PostCategory::deleteAll(['post_id'=>$content->id]);
					$ids = [];
					foreach ($cats as $key => $value) {
						$ids[] = [$content->id, $value];
					}
					Yii::$app->db->createCommand()->batchInsert('post_category', ['post_id', 'category_id'], $ids)->execute();
				}else{
					PostCategory::deleteAll(['post_id'=>$content->id]);
				}
				$tagOld = json_decode($post['tagoldlist'],true);
				$tagNew = json_decode($post['tagnewlist'],true);
				$tag = [];
				if(count($tagOld) > 0){
					foreach ($tagOld as $key => $value) {
						$tag[] = [$content->id, $key];
					}
				}else{
					PostTag::deleteAll(['post_id'=>$content->id]);
				}
				if(count($tagNew) > 0){
					$res = self::createTags($tagNew);
					foreach ($res as $key => $value) {
						$tag[] = [$content->id, $value];
					}
				}
				if (count($tag) > 0) {
					Yii::$app->db->createCommand()->batchInsert('post_tag', ['post_id', 'tag_id'], $tag)->execute();
				}
				return true;
			}else{
				return false;
			}
		}
		return false;
	}

	protected function editPost($post){
		if (!empty($post[Yii::$app->params['default_lang']]['name'])) {
			$content = Post::findOne($post['id']);
			$content->update = time();
			// $content->status = 1;
			if ($content->save()) {
				foreach (Yii::$app->params['langs'] as $key => $value) {
					$post_content = PostContent::find()->where(['post_id'=>$content->id,'language'=>$key])->one();
					if (empty($post[$key]['name'])) {
						$post_content->name = $post[Yii::$app->params['default_lang']]['name'];
					}else{
						$post_content->name = $post[$key]['name'];
					}
					$post_content->excerpt = $post[$key]['excerpt'];
					$post_content->content = $post[$key]['content'];
					$post_content->image = $post['image'];
					$post_content->save();
				}
				$cats = json_decode($post['category'],true);
				if (count($cats) != 0) {
					PostCategory::deleteAll(['post_id'=>$content->id]);
					$ids = [];
					foreach ($cats as $key => $value) {
						$ids[] = [$content->id, $value];
					}
					Yii::$app->db->createCommand()->batchInsert('post_category', ['post_id', 'category_id'], $ids)->execute();
				}else{
				}
				$tagOld = json_decode($post['tagoldlist'],true);
				$tagNew = json_decode($post['tagnewlist'],true);
				if (is_array($tagOld) && is_array($tagNew)) {
					$tag = [];
					PostTag::deleteAll(['post_id'=>$content->id]);
					if(count($tagOld > 0)){
						foreach ($tagOld as $key => $value) {
							$tag[] = [$content->id, $key];
						}
					}else{
					}
					if(count($tagNew > 0)){
						$res = self::createTags($tagNew);
						foreach ($res as $key => $value) {
							$tag[] = [$content->id, $value];
						}
					}
					if (count($tag) > 0) {
						Yii::$app->db->createCommand()->batchInsert('post_tag', ['post_id', 'tag_id'], $tag)->execute();
					}
				}
				return true;
			}else{
				return false;
			}
		}
		return false;
	}

	protected function createTags($tags){
		$ids = [];
		foreach ($tags as $tag) {
			$create = new Tag();
			$create->name = $tag['name'];
			$create->language = $tag['lang'];
			if ($create->save()) {
				$ids[] = $create->id;
			}
		}
		return $ids;
	}
}