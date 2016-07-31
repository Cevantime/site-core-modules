<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Connection extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function basic($userModel = 'memberspace/user') {
		$this->tryLogin($userModel);
		$this->load->view('memberspace/connection/basic');
	}

	public function bootstrap($userModel = 'memberspace/user') {
		$this->tryLogin($userModel);
		$this->load->view('memberspace/connection/bootstrap');
	}
	
	public function bootstrapFull($userModel = 'memberspace/user') {
		$this->tryLogin($userModel);
		$this->load->view('memberspace/connection/bootstrap-full');
	}

	public function tryLogin($userModel = 'memberspace/user') {
		$this->load->library('memberspace/loginManager', $userModel);
		$this->loginmanager->connectUserFromPost();
	}
}
