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
class Listing extends BLOG_Controller {

	public function index($type='start',$limit=0) {
		$this->basic($type, $limit);
	}
	
	public function basic($type='start',$limit=0) {
		$blogposts = $this->pagination('pagination-blogposts-basic-list',$type, $limit);
		$this->load->view('listing/basic',array('blogposts'=>$blogposts));
	}
	
	public function bo($type='start',$limit=0) {
		$blogposts = $this->pagination('pagination-blogposts-basic-list',$type, $limit);
		$this->load->view('listing/bo',array('blogposts'=>$blogposts));
	}


	public function pagination($id_pagination,$type='start',$limit=0){
		$start = $limit;
		$offset = 10;
		$this->load->library('mypagination');
		$this->load->helper('pagination');
		$this->load->model('blog/blogpost');
		return $this->mypagination->paginate($id_pagination, $this->blogpost,$start,$offset,'getListWithAuthors');
	}

}
