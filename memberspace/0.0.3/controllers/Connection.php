<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Connection extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function basic() {
		$this->tryLogin();
		$this->load->view('memberspace/connection/basic');
	}

	public function bootstrap() {
		$this->tryLogin();
		$this->load->view('memberspace/connection/bootstrap');
	}
	
	public function bootstrapFull() {
		$this->tryLogin();
		$this->load->view('memberspace/connection/bootstrap-full');
	}

	public function tryLogin() {
		$this->load->library('memberspace/loginManager');
		$this->loginmanager->connectUserFromPost();
	}
}
