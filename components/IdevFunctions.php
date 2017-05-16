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

	public static function isActiveMenu($urlText){
		$res = "";
		if (isset($_SERVER['REQUEST_URI'])){
			$url = explode('/', $_SERVER['REQUEST_URI']);
			if (isset($url[2])){
				if ($url[2] == $urlText) {
					$res = "active";
				}
			}else{
				if ($urlText == 'dashboard') {
					$res = "active";
				}
			}
		}
		return $res;
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
		$s = preg_replace("#(\w)(o')(\w)#", '$1ў$3', $s);
		$s = preg_replace("#(\w)(O')(\w)#", '$1Ў$3', $s);
		$arr1 = [" o'"," O'","o'","O'"," ye","yo","yu","ya"," Ye","Yo","Yu","Ya","sh","ch","Sh","Ch","SH","CH"];
		$arr2 = [" ў"," Ў","ў","Ў"," йе","ё","ю","я"," Йе","Ё","Ю","Я","ш","ч","Ш","Ч","Ш","Ч"];
		$s = str_replace($arr1, $arr2, $s);
		$s = preg_replace("#(\w)(')(\w)#", '$1ъ$3', $s);
		$lat = ["a","b","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","x","y","z","A","B","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","X","Y","Z"];
		$cry = ["а","б","д","е","ф","г","ҳ","и","ж","к","л","м","н","о","п","қ","р","с","т","у","в","х","й","з","А","Б","Д","Е","Ф","Г","Ҳ","И","Ж","К","Л","М","Н","О","П","Қ","Р","С","Т","У","В","Х","Й","З"];
		$s = str_replace($lat, $cry, $s);
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

}