<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Disconnection extends MY_Controller {
	
	public function basic($redirect = null) {
		$this->doDisconnect($redirect);
		$this->load->view('memberspace/disconnection/basic');
	}
	
	public function bootstrap($redirect = null) {
		$this->doDisconnect($redirect);
		$this->load->view('memberspace/disconnection/bootstrap');
	}
	
	private function doDisconnect($redirect = null) {
		if(isset($_POST['disconnect']) && $_POST['disconnect']){
			$this->load->library('memberspace/loginManager');
			$this->loginmanager->disconnect();
			if($redirect) {
				redirect($redirect);
			} 
			redirect(current_url());
		}
	}
}
