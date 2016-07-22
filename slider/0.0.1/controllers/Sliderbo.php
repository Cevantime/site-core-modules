<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


/**
 * Description of Sliderbo
 * 
 * ATTENTION => mettre dans Routes 
 * 
 * $route['bo/sliderbo'] = 'slider/sliderbo';
 * $route['bo/sliderbo/editSlide/:any'] = 'slider/sliderBO/editSlide/$1';
 * $route['bo/sliderbo/saveSlide/:any'] = 'slider/sliderBO/saveSlide/$1';
 *
 * @author Alex
 */
class Sliderbo extends BO_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index($modelName = 'slider/slide', $redirect = 'slider/sliderbo') {
		$this->all($modelName);
	}
	
	/**** pour le back ***/
	//layout est forcément chargé car dépendant !!
	public function all($modelName = 'slide'){
		$this->load->model($modelName);
		$model = pathinfo($modelName)['filename'];
		$slides = $this->$model->get();
		$this->layout->assign('slides', $slides);	
		$this->layout->assign('modelName', $modelName);	
		$this->layout->view('slider/admin/all');		
	}
	
	public function edit($id, $modelName = 'slider/slide', $redirect = 'slider/sliderbo'){
		
		$this->layout->title("Édition d'un slide");
		$this->load->model($modelName);
		$model = pathinfo($modelName)['filename'];
		$slide = $this->$model->getId($id);
		$this->layout->view('slider/admin/edit',array('slide'=>$slide,'modelName'=>$modelName));
//		$slideInfos = $this->slide->get(array('id' => $id));
//		$this->layout->assign('slideInfos', $slideInfos);
//			
//		$this->layout->title('Edition d\'un slide');
//		$this->layout->view('slider/saveSlider');	
		
	}
	
	public function add($modelName = 'slider/slide', $redirect = 'slider/sliderbo') {
		$this->layout->title("Ajout d'un slide");
		$this->layout->view('slider/admin/add', array('modelName'=>$modelName));
	}
	
	public function save($id = null,$modelName = 'slider/slide', $redirect = 'slider/sliderbo'){
		
		$this->load->model($modelName);
		$post = $this->input->post();
		$pop = array();
		$this->load->helper('locale');
		$oldLang = locale();
		$lang = $this->input->post_get('lang');
		$modelName = pathinfo($modelName)['filename'];
		if($lang) {
			locale($lang); 
		}
		if(!$post || !isset($post['save-slide']) || !$post['save-slide']) {
			if($id) {
				$pop = $this->$modelName->getId($id,'array');
			}
			locale($oldLang);
			return $this->load->view('includes/save', array('datas'=>$pop, 'lang'=>$lang, 'redirect'=>$redirect));
		}
		$pop = $post;
		$isUpdate = isset($post['id']) && $post['id'];
		if(!user_can($isUpdate ? 'update': 'add', $modelName, $isUpdate ? $post['id'] : '*')){
			add_error(translate('Vous n\'avez pas le droit requis pour ').($isUpdate ? 'mettre à jour': 'ajouter').translate(' ce slide.'));
			redirect($redirect);
		}
		$success = $this->$modelName->fromPost();
		locale($oldLang);
		if($success === false) {
			add_error($this->$modelName->getLastErrorsString());
			return $this->load->view('includes/save', array('datas'=>$pop, 'lang'=>$lang, 'redirect'=>$redirect));
		}
		add_success(translate('Le slide a bien été mis à jour.'));
		
		redirect($redirect);
		
//		$config['upload_path'] = './images/';
//		$config['allowed_types'] = 'gif|jpg|png';
//		$config['max_size']	= '100000';
//		$config['max_width']  = '1024';
//		$config['max_height']  = '768';
//
//		$this->load->library('upload', $config);
//		//var_dump($_FILES['userfile']['name']);
//		if ( ! $this->upload->do_upload())
//		{
//			$error = array('error' => $this->upload->display_errors());
//			 
//			$id = $this->uri->segment(4);
//			$slideInfos = $this->slide->get(array('id' => $id));
//			$this->layout->assign('slideInfos', $slideInfos);
//			
//			$this->addError('<i class="fa fa-chevron-down"></i>  '.  $error['error']);
//
//			//$this->layout->title('Edition d\'un slide');
//			//$this->layout->view('slider/saveSlider/'.$id);
//			redirect('bo/sliderbo/editSlide/'.$id);
//		}
//		else
//		{
//			//$data = array('upload_data' => $this->upload->data());			
//			$id = $this->uri->segment(4);
//			$this->slide->update(array("imageName"=>'images/'.$_FILES['userfile']['name'],"title"=>$_POST['title'],"desc"=>$_POST['desc']),array("slider.id"=>$id));
//			redirect('bo/sliderbo?status=success');
//		}
		
		//$this->slide->update(array("title"=>$_POST['title'],"desc"=>$_POST['desc']),array("slider.id"=>$id));
		//redirect('bo/sliderbo?status=success');
	}
	
	
	
}