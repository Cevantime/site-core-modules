<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Update extends BO_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		if(user_can('update', 'site')) {
			die(shell_exec('php tools/fullupdate'));
			
		} else {
			show_404();
		}
	}
	
}