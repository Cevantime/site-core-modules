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
		$this->checkIfUserCan('see', 'users');
		$this->load->model('memberspace/user');
		$id_pagination = 'list-users';
		$users = $this->mypagination->paginate($id_pagination, $this->user, $limit, 10);
		$this->layout->assign('users', $users);
		$this->layout->assign('id_pagination_users_list', $id_pagination);
		$this->layout->view('bo/users/all');
	}

}

?>
