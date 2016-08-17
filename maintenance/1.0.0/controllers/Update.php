<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Update extends BO_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if (user_can('update', 'site')) {
			if (user_can('edit', 'maintenance')) {
				$this->maintenanceManager->turn(false);
			}
			$output = shell_exec('php tools/fullupdate');
			if (user_can('edit', 'maintenance')) {
				$this->maintenanceManager->turn(true);
			}
			die($output);
		} else {
			show_404();
		}
	}

}
