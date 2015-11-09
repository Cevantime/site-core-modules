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
		$this->load->view('bo/forms/basic-style', array('blogpost_add_pop' => $datas));
	}
	
	public function bootstrap($id = null, $model = 'blog/blogpost', $redirect = false) {
		$datas = $this->doSave($id, $model, $redirect);
		$this->load->view('bo/forms/bo-style', array('blogpost_add_pop' => $datas));
	}

	protected function doSave($id = null, $model = 'blog/blogpost', $redirect = false) {
		
		$this->load->helper('memberspace/authorization');
		
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
		
		if(!isset($post['save-post'])) return $pop;
		
		$pop = $post;
		
		if(!$post){
			return $pop;
		}
		
		$is_update = isset($post['id']);

		if($is_update && !user_can('update', 'post', $post['id'])){
			$this->addError(translate('Vous ne pouvez pas modifier ce post.'));
			return $pop;
		} else if(!user_can('insert','post')){
			$this->addError(translate('Vous ne pouvez pas ajouter de post.'));
			return $pop;
		}
		
		
		if (!$this->postmanager->validateDatas()) {
			$this->addError($this->postmanager->getLastValidationErrors());
			return $pop;
		}
		
		$datas = $this->input->post();
		
		$datas['user_id'] = $this->user->getData('id');
		
		$new_id = $this->postmanager->saveDatas($datas);
		
		$this->user->allowTo('*', 'blogpost', $new_id);
		
		$this->addSuccess(translate('Le post a bien été '.(($is_update?'mis à jour':'ajouté'))));  
		
		if ($redirect) {
			redirect($redirect);
		}
		
		return $datas;
	}

}
