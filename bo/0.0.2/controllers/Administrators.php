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
	
	public function all($type = 'start',$limit=0)  {
		$this->checkIfUserCan('see','admin','*');
		$this->load->model('bo/admin');
		$id_pagination = 'administrators-list';
		$admins = $this->mypagination->paginate($id_pagination,$this->admin, $limit, 10);
		$this->layout->assign('administrators', $admins);
		$this->layout->assign('id_pagination_administrators_list', $id_pagination);
		$this->layout->view('bo/administrators/all');
	}
	
	public function add() {
		$datas = $this->save();
		$this->layout->view('bo/administrators/save', array('popSaveAdmin'=> $datas));
	}
	
	public function edit($id) {
		$datas = $this->save($id);
		$this->layout->view('bo/administrators/save', array('popSaveAdmin'=> $datas, 'isEditAdmin'=>true));
	}
	
	public function delete($id) {
		$this->load->helper('memberspace/authorization');
		if(user_can('delete','admin',$id)){
			$this->load->model('bo/admin');
			$this->admin->deleteId($id);
			add_success(translate('L\'administrateur a bien été supprimé'));
		} else {
			add_error(translate('Vous n\'avez pas le droit de supprimer cet administrateur'));
		}
		redirect('bo/administrators/all');
	}
	
	public function save($id = null) {
		$this->load->helper('memberspace/authorization');
		$this->load->helper('flashmessages/flashmessages');
		$this->load->model('bo/admin');
		$this->load->helper('form');
		$datas = array();
		if(isset($_POST) && isset($_POST['save-admin'])) {
			$datas = $_POST;
			unset($_POST['save-admin']);
			if(isset($_POST['id']) && $_POST['id']) {
				if(!user_can('update','admin', $_POST['id'])){
					add_error(translate('Vous ne pouvez pas modifier cet administrateur'));
				}
			} else {
				if(!user_can('add','admin')) {
					add_error(translate('Vous ne pouvez pas ajouter d\'administrateur'));
				}
			}
			if($this->admin->fromPost() !== false) {
				add_success(translate('L\'administrateur a bien été ajouté'));
				redirect('bo/administrators/all');
			} else {
				add_error($this->form_validation->error_string());
			}
			
		} else if($id){
			$datas = $this->admin->getId($id,'array');
		}
		return $datas;
	}

}

?>
