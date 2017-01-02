<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Configure extends BO_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('configuration');
		$this->layout->css('assets/local/css/modules/loaders.css');
	}
	
	public function index() {
		$this->layout->view('maintenance/edit');
	}

	public function turnOff() {
		$this->turn(false);
	}
	
	public function turnOn() {
		$this->turn(true);
	}

	private function turn($on) {
		if(user_can('edit', 'maintenance')) {
			$this->configuration->setValue('maintenance', $on);
		}
		$this->layout->view('maintenance/edit');
		
	}
	
	
}
