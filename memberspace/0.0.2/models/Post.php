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

class Post extends DATA_Model {
	
	public static $TABLE_NAME = 'posts';

	public function getTableName() {
		return self::$TABLE_NAME;
	}
	
	public function insert($datas = null) {
		if ($datas == null) {
			$datas = $this->toArray();
			$this->clear();
		}
		$time = time();
		$datas['creation_time'] = $time;
		$datas['update_time'] = $time;
		return parent::insert($datas);
	}
	
	public function update($datas = null, $where = null){
		if ($datas == null) {
			$datas = $this->toArray();
			$this->clear();
		}
		$time = time();
		$datas['update_time'] = $time;
		return parent::update($datas, $where);
	}
	
}
