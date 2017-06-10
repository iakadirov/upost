<?php 

namespace app\components;
use Yii;
use yii\helpers\Url;

class IdevFunctions{
	const MODUL_URL = '/aplledore';
	const MODUL_NAME = 'Aplledore';

	public static function getBreadcrumbs($arr = []){
		if(is_array($arr) && !is_null($arr)){
			$res = '<nav class="breadcrumb">';
			$res .= '<a class="breadcrumb-item" href="'.self::MODUL_URL.'">'.Yii::t('app','Home').'</a>';
			if (!is_array($arr[0])){
				$res .= '<span class="breadcrumb-item active">'.$arr[0].'</span>';
			}else{
				foreach ($arr as $item){
					if (!is_array($item)){
						$res .= '<span class="breadcrumb-item active">'.$item.'</span>';
					}else{
			  		$res .= '<a class="breadcrumb-item" href="'.$item['url'].'">'.$item['label'].'</a>';
					}
				}
			}
			$res .= '</nav>';
		}else{
			$res = " ";
		}
		return $res;
	}

	public static function to($url=''){
		if (is_array($url)){
			$url[0] = self::MODUL_URL.$url[0];
			return $this->toRoute($url);
		}
		return Url::to(self::MODUL_URL.$url);
	}

	public static function toRoute($url){
		return Url::toRoute(self::MODUL_URL.$url);
	}

	public static function isActive($arr,$text){
		if (in_array(Yii::$app->controller->id, $arr)) {
			return $text;
		}else{
			return "";
		}
	}

	public static function isActiveItem($url,$text){
		if(Yii::$app->controller->id.'/'.Yii::$app->controller->action->id == $url){
			return $text;
		}else{
			return "";
		}
	}

	public static function setSuccessFlash($text){
		Yii::$app->session->setFlash('success',$text);
	}

	public static function setErrorFlash($text){
		Yii::$app->session->setFlash('error',$text);
	}

	/* POST */
	public static function getPostCategoryList($arr){
		$str = '';
		foreach ($arr as $post) {
			$str .= $post['category']['name'].", ";
		}
		return $str;
	}

	public static function translit($s){
		$s = trim($s);
		// $s = preg_replace("#(\w)(o')(\w)#", '$1ў$3', $s);
		// $s = preg_replace("#(\w)(O')(\w)#", '$1Ў$3', $s);
		$arr2 = ["ь","Ь","ў", "Ў", " е",  " Е", "ё", "ю", "я", "Ё", "Ю", "Я", "ш", "ч", "Ш", "Ч", "Ш", "Ч"];
		$arr1 = ["","","o'","O'"," ye"," Ye","yo","yu","ya","Yo","Yu","Ya","sh","ch","Sh","Ch","SH","CH"];
		$s = str_replace($arr2, $arr1, $s);
		// $s = preg_replace("#(\w)(')(\w)#", '$1ъ$3', $s);
		$cry = ["а","б","д","э","ф","г","ҳ","и","ж","к","л","м","н","о","п","қ","р","с","т","у","в","х","й","з","ъ","А","Б","Д","Э","Ф","Г","Ҳ","И","Ж","К","Л","М","Н","О","П","Қ","Р","С","Т","У","В","Х","Й","З","Ъ"];
		$lat = ["a","b","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","x","y","z","'","A","B","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","X","Y","Z","'"];
		$s = str_replace($cry, $lat, $s);
		return $s;
	}

	/*public static function translit($s) {
	  $s = (string) $s; // преобразуем в строковое значение
	  $s = strip_tags($s); // убираем HTML-теги
	  $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
	  $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
	  $s = trim($s); // убираем пробелы в начале и конце строки
	  $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
	  $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
	  $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
	  $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
	  return $s; // возвращаем результат
	}*/

	/* FRONTEND */
	public function svg(){
		return include_once('svg.php');
	}

}