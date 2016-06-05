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
class Blogadmin extends BO_Controller {

	public function index($type = 'start', $limit = 0) {
		$this->checkIfUserCan('see', 'admin');
		$this->load->model('blog/blogpost');
		$this->load->library('mypagination');
		$id_pagination = 'blogadmin_pagination';
		$blogposts = $this->mypagination->paginate($id_pagination, $this->blogpost,$limit,5,'getListWithAuthors');
		$this->layout->view('blog/admin/index', array('model'=>'blog/blogpost','blogposts'=>$blogposts));
	}
	
	public function edit($id) {
		$this->checkIfUserCan('update', 'admin', $id);
		$this->layout->view('blog/admin/edit', array('id'=>$id));
	}
	
	public function delete($id=null){
		$this->checkIfUserCan('delete', 'admin', $id);
		Modules::run('blog/see/delete',$id,'blog/blogpost');
	}

}
