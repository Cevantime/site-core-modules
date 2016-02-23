<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author thibault
 */

require_once APPPATH.'/modules/memberspace/models/Post.php';

class Blogpost extends Post {
	
	public static $TABLE_NAME = 'posts_blog';

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function update($datas = null, $where = null) {
		$this->unlink('image');
		parent::update($datas, $where);
	}
	
	public function getListWithAuthors($limit = 0, $offset = 10) {
		$this->load->model('memberspace/user');
		$usersTableName = $this->user->getTableName();
		$this->join($usersTableName, $usersTableName.'.id=user_id');
		$this->db->select($this->db->dbprefix('users').'.login as author');
		return $this->getList($limit, $offset);
	}
	
	public function getByIdWithAuthor($id){
		$this->load->model('memberspace/user');
		$usersTableName = $this->user->getTableName();
		$this->join($usersTableName, $usersTableName.'.id=user_id');
		$this->db->select('users.login as author');
		return $this->getId($id);
	}
	
}
