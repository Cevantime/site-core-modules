<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Configure extends BO_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('configuration');
	}
	
	public function index() {
		$this->load->view('maintenance/edit');
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
	}
	
	
}
