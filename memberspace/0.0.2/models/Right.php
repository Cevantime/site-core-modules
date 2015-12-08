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

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function getUserRights($userId) {
		$this->load->model('memberspace/linkuserright');
		return $this->getTrough(Linkuserright::$TABLE_NAME, 'user', $userId);
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
	
	public function userCan($userId, $action, $type='*', $value='*'){
		$rights = $this->getUserRights($userId);
		if (!$rights) {
			return false;
		}
		$this->load->model('memberspace/right');
		return $this->rightsAllowsTo($rights, $action, $type, $value);
	}
	
	public function rightsAllowsTo($rights,$action,$type = '*',$value='*'){
		return $this->checkInRights($rights, 'name', $action) &&
		$this->checkInRights($rights, 'type', $type) &&
		$this->checkInRights($rights, 'object_key', $value);
	}
	
	public function checkValues($rights, $type = '*', $value= '*') {
		if ($type == '*' || $value == '*') {
			return $this->checkInRights($rights, $type, $value);
		}
		foreach ($rights as $right) {
			if($this->checkValue($right->object_key, $type, $value)){
				return true;
			}
		}
		return false;
	}
	
	private function checkValue($rightValue, $type, $value){
		
		if(preg_match('#^(.+)->(.+)?\((.*?)\)$#', $value, $matches))
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
