<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Update extends BO_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('configuration');
	}
	
	public function index() {
		if(user_can('update', 'site')) {
			$this->configuration->setValue('maintenance', true);
			$rep = shell_exec('php tools/fullupdate');
			$this->configuration->setValue('maintenance', false);
			die($rep);
			
		} else {
			show_404();
		}
	}
	
}