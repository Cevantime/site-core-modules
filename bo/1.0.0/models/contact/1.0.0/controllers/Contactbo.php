<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


/**
 * Description of Contact Form
 *
 * @author Alex
 */
class Contactbo extends BO_Controller {//Attention si on extends BO_controller au lieu de MY_Controller...on a des dépendances 

	public function index() {
		$this->seeInfos();
	}
	/**** pour le back ***/
	//layout est forcément chargé car dépendant !!
	public function seeInfos(){
		$this->load->model('configuration');		
		$values = $this->configuration->getValues();
		echo 'voici la table '.var_dump($values);
		echo '<br/> une valeur '.$values["contact_city"];		
		
		$this->layout->assign('values', $values);		
		$this->layout->view('contact/saveContact');		
	}
	
	public function save(){
		$this->load->model('configuration');		
		
		//var_dump($_POST);
		$this->configuration->setValues($_POST);
		
		$mapEncode = $_POST['contact_name'].' '.$_POST['contact_street'].' '.$_POST['contact_city'];
		//$mapEncode = str_replace('%20',' ', $mapEncode);
		$mapEncode = preg_replace('/\s+/', '%20', $mapEncode);
		
		$mapAdress = array('contact_map_adress'=>$mapEncode);
		
		//echo 'adress '.var_dump($mapEncode);die();
		$this->configuration->setValues($mapAdress);
		
		redirect('contact/contactbo/seeInfos');
		
		//Cars%20Logistics%20296%20Route%20Minervoise%2011100%20Carcassonne
		/*296 Route Minervoise
		11100 Carcassonne*/
	}
	
}

?>
