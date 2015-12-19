<?php 
if (!function_exists('is_connected')) {

	function is_connected($user_id = null) {
		$CI =& get_instance();
		return isset($CI->user) && $CI->user->isConnected($user_id);
	}

}

if (!function_exists('require_login')) {

	function require_login() {
		$CI =& get_instance();
		$CI->load->library('loginManager');
		return $CI->loginManager->requireLogin();
	}

}