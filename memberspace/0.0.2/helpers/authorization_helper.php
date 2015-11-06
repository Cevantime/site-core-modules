<?php
if (!function_exists('user_can')) {

	function user_can($action='*',$type='*', $object_key= '*') {
		
		$CI =& get_instance();
		return isset($CI->user) && $CI->user->can($action,$type,$object_key);
	}

}

