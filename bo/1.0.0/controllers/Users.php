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
class Users extends BO_Controller {

	public function index($userModel = 'memberspace/user') {
		$this->all($userModel);
	}
	
	public function all($userModel = 'memberspace/user'){
		$userModel = $this->filterModel($userModel);
		$start = $this->input->get('page_start');
		$this->checkIfUserCan('see',$userModel,'*');
		$this->load->model($userModel);
		$model = pathinfo($userModel)['filename'];
		$id_pagination = 'users-list';
		$users = $this->mypagination->paginate($id_pagination,$this->$model, $start, 10);
		$this->layout->assign('users', $users);
		$this->layout->assign('id_pagination_users_list', $id_pagination);
		$this->layout->view('bo/users/all', array('modelName'=>$userModel));
	}
	
	public function add($userModel = 'memberspace/user') {
		$userModel = $this->filterModel($userModel);
		$datas = $this->save(null,$userModel);
		$this->layout->view('bo/users/save', array('popSaveUser'=> $datas,'modelName'=>$userModel));
	}
	
	public function edit($id,$userModel = 'memberspace/user') {
		$userModel = $this->filterModel($userModel);
		$datas = $this->save($id,$userModel);
		$this->layout->view('bo/users/save', array('popSaveUser'=> $datas, 'isEditUser'=>true,'modelName'=>$userModel));
	}
	
	public function delete($id,$userModel = 'memberspace/user') {
		$userModel = $this->filterModel($userModel);
		$this->load->helper('memberspace/authorization');
		if(user_can('delete',$userModel,$id)){
			$this->load->model($userModel);
			$this->user->deleteId($id);
			add_success(translate('L\'utilisateur a bien été supprimé'));
		} else {
			add_error(translate('Vous n\'avez pas le droit de supprimer cet utilisateur'));
		}
		redirect('bo/users/all/'.  str_replace('/', '-', $userModel));
	}
	
	public function save($id = null,$userModel = 'memberspace/user') {
		$userModel = $this->filterModel($userModel);
		$model = pathinfo($userModel)['filename'];
		$this->load->helper('memberspace/authorization');
		$this->load->helper('flashmessages/flashmessages');
		$this->load->model($userModel);
		$this->load->helper('form');
		$datas = array();
		if(isset($_POST) && isset($_POST['save-user'])) {
			$datas = $_POST;
			unset($_POST['save-user']);
			$is_update = false;
			if(isset($_POST['id']) && $_POST['id']) {
				$is_update = true;
				if(!user_can('update',$userModel, $_POST['id'])){
					add_error(translate('Vous ne pouvez pas modifier cet utilisateur'));
				}
			} else {
				if(!user_can('add',$userModel, $_POST['id'])) {
					add_error(translate('L\'utilisateur a bien été ').($is_update ? translate('mis à jour') : translate('ajouté')));
				}
			}
			if($this->$model->fromPost() !== false) {
				add_success(translate('L\'utilisateur a bien été ajouté'));
				redirect('bo/users/all/'.  str_replace('/', '-', $userModel));
			} else {
				add_error($this->form_validation->error_string());
			}
			
		} else if($id){
			$datas = $this->$model->getId($id,'array');
		}
		return $datas;
	}
	
	private function filterModel($model) {
		
		return str_replace('-', '/', $model);
	}

}

?>
