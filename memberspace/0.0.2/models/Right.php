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
class Right extends DATA_Model {
	
	public static $TABLE_NAME = 'rights';
	
	private $_rights = array();

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function getUserRights($user) {
		$userId = $user->id;
		if(!isset($this->_rights[$userId])){
			$this->load->model('memberspace/linkuserright');
			$this->_rights[$userId] = $this->getTrough(Linkuserright::$TABLE_NAME, 'user', $userId);
		}
	
		return $this->_rights[$userId];
		
	}
	
	public function getGroupRights($groupId) {
		$this->load->model('memberspace/linkgroupright');
		return $this->getTrough(Linkgroupright::$TABLE_NAME, 'group', $groupId);		
	}
	
	public function checkInRights($rights, $type, $value) {
		foreach($rights as $right) {
			$rightValue = explode(',',$right->$type);
			if($rightValue === '*' || in_array($value, $rightValue)) {
				return true;
			}
		}
		return false;
	}
	
	public function allowUserTo($userId, $action, $type='*', $value='*', $groupId = 0) {
		$right_id = $this->createAndSaveRight($action, $type, $value);
		$this->load->model('memberspace/linkuserright');
		$this->linkuserright->link($userId,$right_id,$groupId);
	}
	
	private function createAndSaveRight($action, $type='*', $value='*') {
		$right = $this->getRow(array('name'=>$action,'type'=>$type,'object_key'=>$value));
		if(!$right){
			return $this->insert(array('name'=>$action,'type'=>$type,'object_key'=>$value));
		}
		
		return $right->id;
	}
	
	public function allowGroupTo($groupId, $action, $type='*', $value='*'){
		$rightId = $this->createAndSaveRight($action, $type, $value);
		$this->load->model('memberspace/linkgroupright');
		$this->linkgroupright->link($groupId,$rightId);
		$this->load->model('memberspace/group');
		$users = $this->group->getUsers($groupId);
		if($users) {
			foreach ($users as $user) {
				$this->allowUserTo($user->id, $action, $type, $value, $groupId);
			}
		}
	}
	
	public function userCan($user, $action, $type='*', $value='*'){
		$rights = $this->getUserRights($user);
		if (!$rights) {
			return false;
		}
		$this->load->model('memberspace/right');
		return $this->checkInRights($rights, 'name', $action) &&
		$this->checkInRights($rights, 'type', $type) &&
		$this->checkValues($user, $rights, $value);
	}
	
	public function rightsAllowsTo($rights,$action,$type = '*',$value='*'){
		return $this->checkInRights($rights, 'name', $action) &&
		$this->checkInRights($rights, 'type', $type) &&
		$this->checkInRights($rights, 'object_key', $value);
	}
	
	public function checkValues($user, $rights, $value= '*') {
		if ($value == '*' || ctype_digit($value)) {
			return $this->checkInRights($rights, 'object_key', $value);
		}
		foreach ($rights as $right) {
			if($this->checkValue($user, $right->object_key, $value)){
				return true;
			}
		}
		return false;
	}
	
	private function checkValue($user, $object_key, $value){
		$varreg = '([0-9a-zA-Z]+)';
		$regex = '#^'.$varreg.'?\['.$varreg.'\]::'.$varreg.'\((.*?)\)$#';
		if(preg_match($regex, $object_key, $matches)){
			$type = $matches[1];
			$class = $matches[2];
			$method = $matches[3];
			$args = explode(',', $matches[4]);
			foreach ($args as $k => $v){
				if($v === '{object}'){
					$args[$k] = $value;
				} else if($v === '{user}') {
					$args[$k] = $user;
				}
			}
			$this->load->$type($class);
			$exploded = explode('/', $class);
			$classRad = end($exploded);
			$obj = $this->$classRad;
			if(call_user_func_array(array($obj,$method), $args) === TRUE) {
				return TRUE;
			} 
		}
		return FALSE;
	}
	
	public function groupCan($groupId,  $action, $type='*', $value='*') {
		$rights = $this->getGroupRights($groupId);
		if (!$rights) {
			return false;
		}
		$this->load->model('memberspace/right');
		return $this->rightsAllowsTo($rights, $action, $type, $value);
	}
	
}
