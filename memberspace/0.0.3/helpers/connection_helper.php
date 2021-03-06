<?php 
if (!function_exists('is_connected')) {

	function is_connected($user_id = null) {
		$CI =& get_instance();
		$CI->load->library('memberspace/loginManager');
		return $CI->loginmanager->isConnected($user_id);
	}

}

if (!function_exists('require_login')) {

	function require_login() {
		$CI =& get_instance();
		$CI->load->library('memberspace/loginManager');
		return $CI->loginmanager->requireLogin();
	}

}


if (!function_exists('user_id')) {

	function user_id() {
		$CI =& get_instance();
		$CI->load->library('memberspace/loginManager');
		return $CI->loginmanager->getUser()->id;
	}

}

if (!function_exists('user')) {

	function user() {
		$CI =& get_instance();
		$CI->load->library('memberspace/loginManager');
		return $CI->loginmanager->getUser();
	}

}