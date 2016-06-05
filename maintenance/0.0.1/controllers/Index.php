<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Index extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index($redirect = null) {
		$this->load->model('configuration');
		$maintenance = $this->configuration->getValue('maintenance');
		if($maintenance) {
			$this->load->library('memberspace/loginManager','bo/admin');
			if(!$this->admin->isConnected()) {
				if(!$redirect) {
					$redirect = current_url();
				}
				$this->session->set_userdata('login_redirect_url', $redirect);
				redirect('maintenance/index/login');
			}
		}
	}
	
	public function login() {
		$this->load->helper('form');
		$this->load->library('layout/layout');
		$this->layout->setLayout('maintenance/layout/maintenance');
		$this->load->library('memberspace/loginManager','bo/admin');
		$this->loginmanager->connectUserFromPost();
		$this->layout->view('maintenance/login');
	}
	
	
}
