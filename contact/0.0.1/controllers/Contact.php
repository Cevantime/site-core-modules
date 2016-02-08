<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


/**
 * Description of Contact Form
 *
 * @author Alex
 */
class Contact extends BO_Controller {//Attention si on extends BO_controller au lieu de MY_Controller...on a des dépendances 

	public function index() {
		$this->see();
	}
	
	/**** pour le back ***/
	//layout est forcément chargé car dépendant !!
	public function seeInfos(){
		$this->load->model('configuration');		
		$values = $this->configurations->getValues();
		echo 'voici la table '.var_dump($values);
		echo '<br/> une valeur '.$values["contact_city"];		
		
		$this->layout->assign('values', $values);		
		$this->layout->view('contact/saveContact');		
	}
	
	public function save(){
		$this->load->model('configuration');		
		
		//var_dump($_POST);
		$this->configurations->setValues($_POST);
		
		$mapEncode = $_POST['contact_name'].' '.$_POST['contact_street'].' '.$_POST['contact_city'];
		//$mapEncode = str_replace('%20',' ', $mapEncode);
		$mapEncode = preg_replace('/\s+/', '%20', $mapEncode);
		
		$mapAdress = array('contact_map_adress'=>$mapEncode);
		
		//echo 'adress '.var_dump($mapEncode);die();
		$this->configurations->setValues($mapAdress);
		
		redirect('contact/contact/seeInfos');
		
		//Cars%20Logistics%20296%20Route%20Minervoise%2011100%20Carcassonne
		/*296 Route Minervoise
		11100 Carcassonne*/
	}
	/************** fin du back *******************/
	
	/**** pour le front ***/
	public function see(){
		
		//$this->layout->view('contact/seeContact');
		//$this->load->view('see/basic',array('blogpost'=> $this->getId($id)));
		$this->load->model('configuration');
		
		$contact_map_adress = $this->configurations->getValue('contact_map_adress');
		$contact_map_zoom = $this->configurations->getValue('contact_map_zoom');
		$contact_mail = $this->configurations->getValue('contact_mail');
		$contact_phone = $this->configurations->getValue('contact_phone');		
		$contact_street = $this->configurations->getValue('contact_street');
		$contact_city = $this->configurations->getValue('contact_city');
		$contact_name = $this->configurations->getValue('contact_name');
		
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
