<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author thibault
 */
class Save extends BLOG_Controller {

	public function index($id = null, $model = 'blog/blogpost', $redirect = false) {
		$this->basic($id, $model, $redirect);
	}

	public function basic($id = null, $model = 'blog/blogpost', $redirect = false) {
		$datas = $this->doSave($id, $model, $redirect);
		$this->load->view('blog/forms/basic-style', array('blogpost_add_pop' => $datas,'model_name'=> pathinfo($model)['filename']));
	}
	
	public function bootstrap($id = null, $model = 'blog/blogpost', $redirect = false) {
		$datas = $this->doSave($id, $model, $redirect);
		$this->load->view('blog/forms/bo-style', array('blogpost_add_pop' => $datas,'model_name'=> pathinfo($model)['filename']));
	}

	protected function doSave($id = null, $model = 'blog/blogpost', $redirect = false) {
		
		$this->load->helper('memberspace/authorization');
		$this->load->helper('memberspace/connection');
		
		$post = $this->input->post();
		
		$this->load->library('memberspace/postManager',$model);
		
		$rules = Modules::load_multiple('form_validation', 'blog', 'config/', 'config');
		
		if(isset($rules[$model])) {
			$this->postmanager->registerModelRules($model, $rules[$model]);
		}
		
		$upload_path = Modules::load_multiple('upload_paths', 'blog', 'config/', 'config');
		
		if(isset($upload_path[$model])) {
			$this->postmanager->registerModelUploadPath($model, $upload_path[$model]);
		}
		
		$this->postmanager->setCurrentPostModel($model);
		
		if($id) {
			$pop = $this->postmanager->getAPostModelAsArray($id);
		} else {
			$pop = array();
		}
		
		if(!isset($post['save-'.$this->postmanager->getPostModelName()])) return $pop;
		
		$pop = $post;
		
		if(!$post){
			return $pop;
		}
		
		$is_update = isset($post['id']);

		if($is_update && !user_can('update', $model, $post['id'])){
			$this->addError(translate('Vous ne pouvez pas modifier ce post.'));
			return $pop;
		} else if(!user_can('add',$model)){
			$this->addError(translate('Vous ne pouvez pas ajouter de post.'));
			return $pop;
		}
		
		if (!$this->postmanager->validateDatas()) {
			$this->addError($this->postmanager->getLastValidationErrors());
			return $pop;
		}
		
		$datas = $this->input->post();
		
		$datas['user_id'] = user_id();
		
		$new_id = $this->postmanager->saveDatas($datas);
		
		$this->user->allowTo('*', $model, $new_id);
		
		$this->addSuccess(translate('Le post a bien été '.(($is_update?'mis à jour':'ajouté'))));  
		
		if ($redirect) {
			redirect($redirect);
		}
		
		return $datas;
	}

}
