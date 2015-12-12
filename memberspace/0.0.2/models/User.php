<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author thibault
 */
class User extends DATA_Model {
	
	public static $TABLE_NAME = 'users';
	
	protected $rights = array();

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function clear() {
		parent::clear();
		$this->rights = array();
	}


	public function load($id){
		$this->loadRow(array('users.id'=>$id));
	}
	
	public function checkUser($username, $password){
		if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
			return $this->getRow(array('login'=>$username,'password'=>$password));
		} else {
			return $this->getRow(array('email'=>$username,'password'=>$password));
		}
	}

	public function can($action, $type='*', $value='*'){
		$this->loadRights();
		$rights = $this->rights;
		if(!$rights) return false;
		$this->load->model('memberspace/right');
		return $this->right->checkInRights($rights, 'name', $action) &&
		$this->right->checkInRights($rights, 'type', $type) &&
		$this->right->checkInRights($rights, 'object_key', $value);
		
	}

	
	public function loadRights($force = false) {
		if($force || !$this->rights){
			if(!$this->getData('id')) {
				$this->rights = array();
			} else {
				$this->load->model('memberspace/right');
				$this->rights = $this->right->getUserRights($this->id);
			}
		}
	}
	
	public function getRights($userId=null){
		if(!$userId){
			$userId = $this->getData('id');
		}
		$this->load->model('memberspace/right');
		return $this->right->getUserRights($userId);
	}
	
	public function allowTo($action, $type='*', $value='*', $groupId = 0){
		if(!$this->getData('id')){
			return false;
		}
		$this->load->model('memberspace/right');
		$ret = $this->right->allowUserTo($this->getData('id'), $action, $type, $value, $groupId);
		
		$this->loadRights(true);
		
		return $ret;
	}
	
	public function exists($userId = null){
		if(!$userId){
			$userId = $this->getData('id');
		}
		return $this->getId($userId) != false;
	}
	
	public function notExistingLogin($login){
		return !$this->getRow(array('login'=>$login));
	}
	
	public function notExistingEmail($email){
		return !$this->getRow(array('email'=>$email));
	}
	
	public function addToGroup($groupId, $userId = null) {
		if(!$userId){
			$userId = $this->getData('id');
		}
		$this->load->model('group');
		$this->group->addUser($userId,$groupId);
	}
	
	

}
