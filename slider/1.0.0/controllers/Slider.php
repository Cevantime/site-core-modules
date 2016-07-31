<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


/**
 * Description of Slider controller (front)
 * inspiré de http://responsiveslides.com/
 * @author Alex
 */
class Slider extends MY_Controller {

	public function index() {
		//$datas = 'nulltest';
		//$this->load->view('slider/seeSlider',$datas);
	}
	
	/**** pour le front ***/
	public function see($modelName = 'slide'){
		$this->load->model($modelName);
		$slides = $this->$modelName->get();
		$data['slides']= $slides;		
		$this->load->view('slider/see',$data);
		
		//$this->layout->assign('slides', $slides);	
		//$this->layout->css('css/slider/slider.css');
		//$this->layout->view('slider/seeSlider');	
		
	}
	
}