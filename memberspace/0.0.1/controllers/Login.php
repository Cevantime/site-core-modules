<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function basic() {
		
	}
	
	public function processInput($input) {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username');
		$this->form_validation->set_data($input);
		
	}

}
