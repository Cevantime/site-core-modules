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
class Administrators extends BO_Controller {

	public function index() {
		$this->all();
	}
	
	public function all($adminModel = 'bo/admin')  {
		$adminModel = $this->filterModel($adminModel);
		$start = $this->input->get('page_start');
		$this->checkIfUserCan('see',$adminModel,'*');
		$this->load->model('bo/admin');
		$model = pathinfo($adminModel)['filename'];
		$id_pagination = 'administrators-list';
		$admins = $this->mypagination->paginate($id_pagination,$this->$model, $start, 10);
		$this->layout->assign('administrators', $admins);
		$this->layout->assign('id_pagination_administrators_list', $id_pagination);
		$this->layout->view('bo/administrators/all');
	}
	
	public function add($adminModel = 'bo/admin') {
		$adminModel = $this->filterModel($adminModel);
		$datas = $this->save(null,$adminModel);
		$this->layout->view('bo/administrators/save', array('popSaveAdmin'=> $datas,'modelName'=>$adminModel));
	}
	
	public function edit($id,$adminModel = 'bo/admin') {
		$adminModel = $this->filterModel($adminModel);
		$datas = $this->save($id,$adminModel);
		$this->layout->view('bo/administrators/save', array('popSaveAdmin'=> $datas, 'isEditAdmin'=>true,'modelName'=>$adminModel));
	}
	
	public function delete($id,$adminModel = 'bo/admin') {
		$adminModel = $this->filterModel($adminModel);
		$this->load->helper('memberspace/authorization');
		if(user_can('delete',$adminModel,$id)){
			$this->load->model($adminModel);
			$this->user->deleteId($id);
			add_success(translate('L\'utilisateur a bien été supprimé'));
		} else {
			add_error(translate('Vous n\'avez pas le droit de supprimer cet utilisateur'));
		}
		redirect('bo/administrators/all/'.  str_replace('/', '-', $adminModel));
	}
	
	public function save($id = null,$adminModel = 'bo/admin') {
		$adminModel = $this->filterModel($adminModel);
		$model = pathinfo($adminModel)['filename'];
		$this->load->helper('memberspace/authorization');
		$this->load->helper('flashmessages/flashmessages');
		$this->load->model($adminModel);
		$this->load->helper('form');
		$datas = array();
		if(isset($_POST) && isset($_POST['save-user'])) {
			$datas = $_POST;
			unset($_POST['save-admin']);
			$is_update = false;
			if(isset($_POST['id']) && $_POST['id']) {
				$is_update = true;
				if(!user_can('update',$adminModel, $_POST['id'])){
					add_error(translate('Vous ne pouvez pas modifier cet administrateur'));
				}
			} else {
				if(!user_can('add',$adminModel, $_POST['id'])) {
					add_error(translate('Vous ne pouvez pas ajouter cet administrateur'));
				}
			}
			if($this->$model->fromPost() !== false) {
				add_success(translate('L\'administrateur a bien été').($is_update ? translate('mis à jour') : translate('ajouté')));
				redirect('bo/users/all/'.  str_replace('/', '-', $adminModel));
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
