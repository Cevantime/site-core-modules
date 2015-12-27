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

	public function getUserRights($user) {
		$userId = $user->id;
		$this->load->model('memberspace/linkuserright');
		$this->load->model('memberspace/linkgroupright');
		$this->load->model('memberspace/user');
		$userGroups = $this->user->getGroups($userId);
		$groupIds = array();
		foreach ($userGroups as $group) {
			$groupIds[] = $group->id;
		}
		$rights = array_merge($this->getThrough(Linkuserright::$TABLE_NAME, 'user', $userId), $this->getThrough(Linkgroupright::$TABLE_NAME, 'group', $groupIds));
		return $rights;
	}

	public function getGroupRights($groupId) {
		$this->load->model('memberspace/linkgroupright');
		return $this->getThrough(Linkgroupright::$TABLE_NAME, 'group', $groupId);
	}

	public function checkInRights($rights, $type, $value) {
		foreach ($rights as $right) {
			$rightValue = explode(',', $right->$type);
			if (in_array('*', $rightValue) || in_array($value, $rightValue)) {
				return true;
			}
		}
		return false;
	}

	public function allowUserTo($userId, $action, $type = '*', $value = '*') {
		$right_id = $this->createAndSaveRight($action, $type, $value);
		$this->load->model('memberspace/linkuserright');
		$this->linkuserright->link($userId, $right_id);
	}

	private function createAndSaveRight($action, $type = '*', $value = '*') {
		$right = $this->getRow(array('name' => $action, 'type' => $type, 'object_key' => $value));
		if (!$right) {
			return $this->insert(array('name' => $action, 'type' => $type, 'object_key' => $value));
		}

		return $right->id;
	}

	public function allowGroupTo($groupId, $action, $type = '*', $value = '*') {
		$rightId = $this->createAndSaveRight($action, $type, $value);
		$this->load->model('memberspace/linkgroupright');
		$this->linkgroupright->link($groupId, $rightId);
		
	}

	public function userCan($user, $action, $type = '*', $value = '*') {
		$rights = $this->getUserRights($user);
		if (!$rights) {
			return false;
		}
		$this->load->model('memberspace/right');
		return $this->checkInRights($rights, 'name', $action) &&
				$this->checkInRights($rights, 'type', $type) &&
				$this->checkValues($user, $rights, $value);
	}

	public function rightsAllowsTo($rights, $action, $type = '*', $value = '*') {
		return $this->checkInRights($rights, 'name', $action) &&
				$this->checkInRights($rights, 'type', $type) &&
				$this->checkInRights($rights, 'object_key', $value);
	}

	public function checkValues($user, $rights, $value = '*') {
		if ($value == '*' || ctype_digit($value)) {
			return $this->checkInRights($rights, 'object_key', $value);
		}
		foreach ($rights as $right) {
			if ($this->checkValue($user, $right->object_key, $value)) {
				return true;
			}
		}
		return false;
	}

	private function checkValue($user, $object_key, $value) {
		$varreg = '([0-9a-zA-Z]+)';
		$regex = '#^' . $varreg . '?\[' . $varreg . '\]::' . $varreg . '\((.*?)\)$#';
		if (preg_match($regex, $object_key, $matches)) {
			$type = $matches[1];
			$class = $matches[2];
			$method = $matches[3];
			$args = explode(',', $matches[4]);
			foreach ($args as $k => $v) {
				if ($v === '{object}') {
					$args[$k] = $value;
				} else if ($v === '{user}') {
					$args[$k] = $user;
				}
			}
			$this->load->$type($class);
			$exploded = explode('/', $class);
			$classRad = end($exploded);
			$obj = $this->$classRad;
			if (call_user_func_array(array($obj, $method), $args) === TRUE) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public function groupCan($groupId, $action, $type = '*', $value = '*') {
		$rights = $this->getGroupRights($groupId);
		if (!$rights) {
			return false;
		}
		$this->load->model('memberspace/right');
		return $this->rightsAllowsTo($rights, $action, $type, $value);
	}

}
