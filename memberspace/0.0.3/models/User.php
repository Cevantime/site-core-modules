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

	public function load($id) {
		$this->loadRow(array($this->db->dbprefix('users').'.id' => $id));
	}

	public function checkUser($username, $password) {
		if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
			return $this->getRow(array('login' => $username, 'password' => $password));
		} else {
			return $this->getRow(array('email' => $username, 'password' => $password));
		}
	}

	public function can($action, $type = '*', $value = '*') {
		if (!$this->isConnected())
			return false;
		$this->load->model('memberspace/right');
		return $this->right->userCan($this, $action, $type, $value);
	}

	public function loadRights($force = false) {
		if ($force || !$this->rights) {
			if (!$this->getData('id')) {
				$this->rights = array();
			} else {
				$this->load->model('memberspace/right');
				$this->rights = $this->right->getUserRights($this->id);
			}
		}
	}

	public function getRights($userId = null) {
		if (!$userId) {
			$userId = $this->getData('id');
			if (!$this->rights) {
				$this->load->model('memberspace/right');
				$this->rights = $this->right->getUserRights($userId);
			}
			return $this->rights;
		}
		return $this->right->getUserRights($userId);
	}
	
	public function getGroups($userId = null) {
		if (!$userId) {
			$userId = $this->getData('id');
		}
		$this->load->model('memberspace/group');
		$this->load->model('memberspace/linkusergroup');
		return $this->group->getThrough(Linkusergroup::$TABLE_NAME, 'user', $userId);
	}

	public function allowTo($action, $type = '*', $value = '*', $groupId = 0) {
		if (!$this->getData('id')) {
			return false;
		}
		$this->load->model('memberspace/right');
		$ret = $this->right->allowUserTo($this->getData('id'), $action, $type, $value, $groupId);

		$this->loadRights(true);

		return $ret;
	}

	public function exists($userId = null) {
		if (!$userId) {
			$userId = $this->getData('id');
		}
		return $this->getId($userId) != false;
	}

	public function notExistingLogin($login) {
		return !$this->getRow(array('login' => $login));
	}

	public function notExistingEmail($email) {
		return !$this->getRow(array('email' => $email));
	}

	public function addToGroup($groupId, $userId = null) {
		if (!$userId) {
			$userId = $this->getData('id');
		}
		$this->load->model('memberspace/group');
		$this->group->addUser($userId, $groupId);
	}

	public function isConnected($id = null) {
		$CI = & get_instance();
		if (!$id) {
			$id = $this->getData('id');
		}
		$user_id_in_session = $CI->session->userdata('user_id');
		return $user_id_in_session && $user_id_in_session == $id && $this->getData('id') == $id;
	}

	public function connect($id = null) {
		$CI = & get_instance();
		if (!$id) {
			$id = $this->getData('id');
		}
		$this->load($id);
		$CI->session->set_userdata('user_id', $id);
	}

	public function validationRulesForInsert($datas) {
		return array(
			array(
				'field' => 'login',
				'label' => translate('Nom d\'utilisateur'),
				'rules' => array(
					'required',
					'trim',
					'min_length[4]',
					array('not_existing_login', array($this, 'notExistingLogin'))
				)
			),
			array(
				'field' => 'email',
				'label' => translate('Email'),
				'rules' => array(
					'required',
					'trim',
					'valid_email',
					'max_length[200]',
					array('not_existing_email', array($this, 'notExistingEmail'))
				)
			),
			array(
				'field' => 'password',
				'label' => translate('Mot de passe'),
				'rules' => 'required|trim|min_length[5]|max_length[50]|md5'
			),
			array(
				'field' => 'passwordconfirm',
				'label' => translate('Mot de passe de confirmation'),
				'rules' => 'required|trim|min_length[5]|max_length[50]|md5|matches[password]'
			)
		);
	}

	public function validationRulesForUpdate($datas) {
		$old = null;
		$model = $this;
		if (isset($datas['id'])) {
			$old = $this->getRow(array($this->db->dbprefix('users').'.id' => $datas['id']));
		}
		return array(
			array(
				'field' => 'id',
				'label' => 'Id',
				'rules' => array(
					'required',
					'numeric',
					array($this, 'exists')
				)
			),
			array(
				'field' => 'login',
				'label' => translate('Nom d\'utilisateur'),
				'rules' => array(
					'trim',
					'min_length[4]',
					array('not_existing_login_for_update', function($r) use($model, $old) {
							if ($old) {
								if ($old->login != $r) {
									return $model->notExistingLogin($r);
								}
							}
							return true;
						})
				)
			),
			array(
				'field' => 'email',
				'label' => translate('Email'),
				'rules' => array(
					'trim',
					'valid_email',
					'max_length[200]',
					array('not_existing_email_for_update', function($r)use($model, $old) {
							if ($old) {
								if ($old->email != $r) {
									return $model->notExistingEmail($r);
								}
							}
							return true;
						})
				)
			),
			array(
				'field' => 'password',
				'label' => translate('Mot de passe'),
				'rules' => 'trim|min_length[5]|max_length[50]|md5'
			),
			array(
				'field' => 'passwordconfirm',
				'label' => translate('Mot de passe de confirmation'),
				'rules' => 'trim|min_length[5]|max_length[50]|md5|matches[password]'
			),
			array(
				'field' => 'oldpassword',
				'label' => translate('Ancien mot de passe'),
				'rules' => array(
					'trim',
					'md5',
					array('valid_old_password', function($r) use($old,$datas) {
						if(!isset($datas['password'])||!$datas['password']) return true;
						return $old->password == $r;
					})
				)
			)
		);
	}

	public function insert($datas = null) {
		$userId = parent::insert($datas);
		$this->load->model('memberspace/right');
		$this->user->addToGroup('users', $userId);
		return $userId;
	}

}
