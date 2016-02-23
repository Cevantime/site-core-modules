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
		
		$this->load->model($model);
		
		$modelName = pathinfo($model)['filename'];
		
		$modelInst = $this->$modelName;
		
		if($id) {
			$pop = $modelInst->getId($id,'array');
		} else {
			$pop = array();
		}
		
		if(!isset($post['save-'.$modelName])) return $pop;
		
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
		
		$datas = $this->input->post();
		
		$datas['user_id'] = user_id();
		
		$this->load->library('form_validation');
		
		$new_id = $modelInst->fromDatas($datas);
		
		if($new_id === false) {
			$this->addError($this->form_validation->error_string());
			return $pop;
		}
		
		$this->user->allowTo('*', $model, $new_id);
		
		$this->addSuccess(translate('Le post a bien été '.(($is_update?'mis à jour':'ajouté'))));  
		
		if ($redirect) {
			redirect($redirect);
		}
		
		return $datas;
	}

}
