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

	public function index() {
		$this->all();
	}
	
	public function all($type = 'start',$limit=0){
		$this->checkIfUserCan('see','user','*');
		$this->load->model('memberspace/user');
		$id_pagination = 'users-list';
		$users = $this->mypagination->paginate($id_pagination,$this->user, $limit, 10);
		$this->layout->assign('users', $users);
		$this->layout->assign('id_pagination_users_list', $id_pagination);
		$this->layout->view('bo/users/all');
	}
	
	public function add() {
		$datas = $this->save();
		$this->layout->view('bo/users/save', array('popSaveUser'=> $datas));
	}
	
	public function edit($id) {
		$datas = $this->save($id);
		$this->layout->view('bo/users/save', array('popSaveUser'=> $datas, 'isEditUser'=>true));
	}
	
	public function delete($id) {
		$this->load->helper('memberspace/authorization');
		if(user_can('delete','user',$id)){
			$this->load->model('memberspace/user');
			$this->user->deleteId($id);
			add_success(translate('L\'administrateur a bien été supprimé'));
		} else {
			add_error(translate('Vous n\'avez pas le droit de supprimer cet administrateur'));
		}
		redirect('bo/administrators/all');
	}
	
	public function save($id = null) {
		$this->load->helper('memberspace/authorization');
		$this->load->helper('flashmessages/flashmessages');
		$this->load->model('memberspace/user');
		$this->load->helper('form');
		$datas = array();
		if(isset($_POST) && isset($_POST['save-user'])) {
			$datas = $_POST;
			unset($_POST['save-user']);
			if(isset($_POST['id']) && $_POST['id']) {
				if(!user_can('update','user', $_POST['id'])){
					add_error(translate('Vous ne pouvez pas modifier cet utilisateur'));
				}
			} else {
				if(!user_can('add','user', $_POST['id'])) {
					add_error(translate('Vous ne pouvez pas ajouter d\'utilisateur'));
				}
			}
			if($this->user->fromPost() !== false) {
				add_success(translate('L\'utilisateur a bien été ajouté'));
				redirect('bo/users/all');
			} else {
				add_error($this->form_validation->error_string());
			}
			
		} else if($id){
			$datas = $this->user->getId($id,'array');
		}
		return $datas;
	}

}

?>
