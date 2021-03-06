<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Right
 *
 * @author thibault
 */
class Group extends DATA_Model {
	
	public static $TABLE_NAME = 'groups';
	
	protected $rights = array();

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function saveGroup($name) {
		$group = $this->getByName($name);
		if(!$group){
			$this->insert(array('name'=>$name));
		}
	}
	
	public function getByName($name = NULL){
		if(!$name) {
			$name = $this->getData('name');
		}
		
		return $this->getRow(array('name'=>$name));
	}
	
	public function removeByName($name = NULL) {
		if(!$name) {
			$name = $this->getData('name');
		}
		return $this->delete(array('name'=>$name));
	}
	
	public function loadByName($name = NULL) {
		if(!$name) {
			$name = $this->getData('name');
		}
		
		return $this->loadRow(array('name'=>$name));
	}
	
	public function getUsers($groupId = NULL) {
		if(!$groupId){
			$groupId = $this->getData('id');
		}
		$this->load->model('memberspace/linkusergroup');
		$this->load->model('memberspace/user');
		return $this->user->getTrough(Linkusergroup::$TABLE_NAME, 'group', $groupId);
	}
	
	public function addUser($userId, $groupId = NULL) {
		if(!$groupId){
			$groupId = $this->getData('id');
		}
		$this->load->model('memberspace/linkusergroup');
		$ret = $this->linkusergroup->link($userId, $groupId);
		
		$groupRights = $this->getGroupRights($groupId);
		
		$this->load->model('memberspace/right');
		if($groupRights){
			foreach ($groupRights as $right) {
				$this->right->allowUserTo($userId, $right->name, $right->type, $right->object_key, $groupId);
			}
		}
				
		return $ret;
	}
	
	public function removeUser($userId, $groupId = NULL) {
		if(!$groupId){
			$groupId = $this->getData('id');
		}
		$this->load->model('memberspace/linkusergroup');
		$ret = $this->linkusergroup->delete(array('user_id'=>$userId, 'groupId'=>$groupId));
		
		$this->load->model('memberspace/right');
		$this->right->delete(array('user_id'=>$userId,'group_id'=>$groupId));
		
		return $ret;
	}
	
	public function getGroupRights($groupId){
		$this->load->model('memberspace/right');
		return $this->right->getGroupRights($groupId);
	}
	
	public function can($action, $type='*', $value='*'){
		$this->loadRights();
		$rights = $this->rights;
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
				$this->load->model('right');
				$this->rights = $this->right->getGroupRights($this->id);
			}
		}
	}
	
	public function allowTo($action, $type='*', $value='*'){
		if(!$this->getData('id')){
			return false;
		}
		
		$this->load->model('memberspace/right');
		$ret = $this->right->allowGroupTo($this->getData('id'), $action, $type, $value);
		
		$this->loadRights(true);
		
		return $ret;
	}
}
