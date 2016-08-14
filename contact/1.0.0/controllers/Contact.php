<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


/**
 * Description of Contact Form
 *
 * @author Alex
 */
class Contact extends MY_Controller {//Attention si on extends BO_controller au lieu de MY_Controller...on a des dépendances 

	public function index() {
		$this->see();
	}
	
	/**** pour le front ***/
	public function see(){
		
		//$this->layout->view('contact/seeContact');
		//$this->load->view('see/basic',array('blogpost'=> $this->getId($id)));
		$this->load->model('configuration');
		
		$contact_map_adress = $this->configuration->getValue('contact_map_adress');
		$contact_map_zoom = $this->configuration->getValue('contact_map_zoom');
		$contact_mail = $this->configuration->getValue('contact_mail');
		$contact_phone = $this->configuration->getValue('contact_phone');		
		$contact_street = $this->configuration->getValue('contact_street');
		$contact_city = $this->configuration->getValue('contact_city');
		$contact_name = $this->configuration->getValue('contact_name');
		
		/**** décomposition de l'adresse *****/
		//$infos = explode("/", uri_string());
		
		$datas = array('map_adress'=>$contact_map_adress,'zoom'=>$contact_map_zoom,'mail'=>$contact_mail,'phone'=>$contact_phone,'street'=>$contact_street,'city'=>$contact_city,'name'=>$contact_name);
		$this->load->view('contact/seeContact',$datas);
	}
	
	public function sendMessage(){
		
		require_once APPPATH.'/modules/contact/bin/contact_me.php';
	}

}

?>
