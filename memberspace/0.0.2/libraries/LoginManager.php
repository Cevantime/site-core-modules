<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class LoginManager {
	
	private $_ci;
	private $_cookie;
	private $_user;
	
	public function __construct($userModel = 'memberspace/user') {
		$this->_ci =& get_instance();
		$this->_ci->load->helper('cookie');
		$this->_ci->load->helper('flashmessages/flashmessages');
		$this->load->model($userModel);
		$exp = explode('/', $userModel);
		$modelName = end($exp);
		$this->_user = $this->{$modelName};
		$this->connectUserIfAny();
	}
	
	public function requireLogin() {
		$this->connectUserIfAny();
		if(!is_connected()){
			$this->_ci->session->set_userdata('login_redirect_url', current_url());
			redirect('login');
		}
		return true;
	}
	
	public function connectUserIfAny() {
		if(is_connected()) return;
		$user_id = $this->_ci->session->userdata('user_id');
		if(!$user_id){
			$user_id = get_cookie('user_id');
		}
		if($user_id) {
			$this->_ci->load->model('');
			$this->_user->connect($user_id);
		}
	}
	
	public function getCookie() {
		if(!$this->_cookie){
			$this->_cookie = Modules::load_multiple('login_cookie', 'memberspace', 'config/', 'config');
		}
		return $this->_cookie;
	}
	
	public function disconnect() {
		$cookie = $this->getCookie();
		delete_cookie($cookie);
		session_destroy();
	}
	
	public function connectUserFromPost($post = null) {
		$this->_ci->load->library('form_validation');
		if($post){
			$this->_ci->form_validation->set_data($post);
		}
		$rules = Modules::load_multiple('form_validation', 'memberspace', 'config/','config');
		if(!isset($rules['login'])){
			return;
		}
		$validation_rules = $rules['login'];
		$this->_ci->form_validation->set_rules($validation_rules);
		if(!$this->_ci->form_validation->run()){
			add_error($this->_ci->form_validation->error_string());
			return ;
		}
		
		if(!$post) {
			unset($_POST['login-user']);
			$post = $_POST;
		}
		$this->_ci->load->model('user');
		$user = $this->_user->checkUser($post['login'],$post['password']);
		if(!$user) {
			add_error(translate('Le nom d\'utilisateur entré est invalide (email ou pseudo).'));
			return ;
		}
		
		$this->_user->connect($user->id);
		
		add_success(translate('Vous vous êtes connecté avec succès !'));
		
		if(isset($post['rememberme']) && $post['rememberme']){
			$cookie = $this->getCookie();
			$cookie['value'] = $user->id;
			set_cookie($cookie);
		}
		
		if($this->_ci->session->userdata('login_redirect_url')){
			redirect($this->_ci->session->userdata('login_redirect_url'));
		}
		else {
			redirect(current_url());
		}
	}
}