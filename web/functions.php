<?php 

if (!function_exists('debug')) {
	function debug($arr){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}

