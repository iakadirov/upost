<?php
namespace app\modules\aplledore\models;

use Yii;
use app\models\User;
use app\models\Post;
use app\models\PostContent;
use app\models\Seo;
use app\models\PostTag;
use app\models\Tag;
use app\models\ThemaContent;
use app\models\Category;
use app\models\CategoryContent;
use app\components\IdevFunctions;

class AplledoreNews extends \yii\db\ActiveRecord{
	public static function getPostList(){
		if (Yii::$app->session->has('sort_'.Yii::$app->controller->id)) {
			$session = Yii::$app->session->get('sort_'.Yii::$app->controller->id);
			$post = Post::find();
			if ( $session['data_from'] > 0 ) {
				$post->where(['>=','date',$session['data_from']]);
			}else{
				$post->where(['>=','date',0]);
			}
			if ( $session['data_to'] > 0 ) {
				$post->andWhere(['<=','date',$session['data_to']]);
			}
			if ($session['category'] > 0) {
				$post->andWhere(['category_id'=>$session['category']]);
			}
			if ($session['author'] > 0) {
				$post->andWhere(['author_id'=>$session['author']]);
			}
			$res['content'] = $post->with('content','category','creator','editor');
		}else{
			$res['content'] = Post::find()->with('content','category','creator','editor');
		}
		return $res;
	}

	public static function getNewPostList(){
		return Post::find()->with('content','category','creator','editor')->where(['status'=>'0']);
	}

	public static function getContent($id){
		return Post::find()->with('contents','tags')->where(['id'=>$id])->asArray()->one();
	}

	public static function getCategory(){
		return CategoryContent::find()->select('category_id,name,language')->where(['language'=>Yii::$app->params['admin_lang']])->asArray()->all();
	}

	public static function getUsers(){
		return User::getAllUsers();
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

	/*public static function getSortContent(){
		$content['categorys'] = Category::find()->select('category.id')->with('contentName')->asArray()->all();
		return $content;
	}*/

	public static function contentLoad($post){
		if(!empty($post)){
			if(isset($post['id'])){
				return self::editPost($post);
			}else{
				if(empty($post[2]['name']) && empty($post[2]['content'])){
					$post = self::addCryl($post);
				}
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

	public static function checkStatus($action, $id){
		$post = Post::findOne($id);
		if(!empty($post)){
			if($post->author_id != Yii::$app->user->identity->id && !User::isAdmin()){
				return json_encode(['res'=>'error']);
			}
			if($action == 'active' && User::isAdmin()){
				$post->status = 1;
			}elseif($action == 'deactive' && User::isAdmin()){
				$post->status = 0;
			}elseif($action == 'delete'){
				$post->status = -1;
			}
			if($post->save()){
				return json_encode(['res'=>'success']);
			}
		}
		return json_encode(['res'=>'error']);
	}

	public static function checkPriority($action, $id){
		$post = Post::findOne($id);
		if(!empty($post)){
			if($action == 'important'){
				$post->priority = 1;
				$text = Yii::t('idev','Important');
			}else{
				$post->priority = 0;
				$text = Yii::t('idev','Plain');
			}
			if($post->save()){
				return json_encode(['res'=>'success','text'=>$text]);
			}
		}
		return json_encode(['res'=>'error']);
	}

	protected function createPost($post){
		$content = new Post;
		$content->date = time();
		$content->update = time();
		$content->category_id = $post['category_id'];
		$content->author_id = Yii::$app->user->identity->id;
		$content->thema_id = $post['thema_id'];
		$content->type = Post::POST_TYPE_NEWS;
		if(isset($post['character'])){$content->character = 1;}
		if(isset($post['subscribe'])){$content->subscribe = 1;}
		if(isset($post['priority'])){$content->priority = 1;}
		if(isset($post['funny'])){$content->funny = 1;}
		if(isset($post['pr']) && User::isAdmin()){
			$content->pr = 1;
			$arr = explode(':', $post['pr_time']);
			$prDate = strtotime($post['pr_date'])+($arr[0]*3600)+($arr[1]*60);
			$content->pr_end_date = $prDate;
		}
		if(User::isAdmin()){$content->status = 1;}
		$content->update_author_id = Yii::$app->user->identity->id;
		if(isset($post['comment'])){
			$content->comment = 1;
			$content->comment_end_date = $content->getCommentEndDate($post['comment_end_date']);
		}
		if($content->save()){
			foreach (Yii::$app->params['langs'] as $key => $value) {
				$post_content = new PostContent;
				$post_content->post_id = $content->id;
				$post_content->language = $key;
				$post_content->name = $post[$key]['name'];
				$post_content->excerpt = $post[$key]['excerpt'];
				$post_content->content = $post[$key]['content'];
				$post_content->image = $post['image'];
				$post_content->save();
				$post_seo = new Seo;
				$post_seo->parent_id = $content->id;
				$post_seo->type = 'post';
				$post_seo->language = $key;
				$post_seo->title = $post[$key]['name'];
				$post_seo->keywords = $post[$key]['name'];
				$post_seo->description = $post[$key]['name'];
				$post_seo->save();
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

	protected function addCryl($post){
		$post[2]['name'] = IdevFunctions::translit($post[1]['name']);
		$post[2]['content'] = IdevFunctions::translit($post[1]['content']);
		$post[2]['excerpt'] = IdevFunctions::translit($post[1]['excerpt']);
		return $post;
	}
}