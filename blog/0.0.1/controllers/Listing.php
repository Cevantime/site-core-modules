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

	public function index($model, $type='start',$limit=0) {
		$this->basic($model,$type, $limit);
	}
	
	public function basic($model,$type='start',$limit=0) {
		$model = $this->filterModel($model);
		$blogposts = $this->pagination('pagination-blogposts-basic-list',$model,$type, $limit);
		$this->load->view('listing/basic',array('blogposts'=>$blogposts, 'model'=>$model));
	}
	
	public function bo($model,$type='start',$limit=0) {
		$model = $this->filterModel($model);
		$blogposts = $this->pagination('pagination-blogposts-basic-list',$model,$type, $limit);
		$this->load->view('listing/bo',array('blogposts'=>$blogposts, 'model'=>$model));
	}
	
	public function front($model,$type='start',$limit=0) {
		$model = $this->filterModel($model);
		$blogposts = $this->pagination('pagination-blogposts-basic-list',$model,$type, $limit);
		$this->load->view('listing/basic',array('blogposts'=>$blogposts, 'model'=>$model));
	}

	private function filterModel($model) {
		$explode = explode('-', $model);
		return implode('/', $explode);
	}

	public function pagination($id_pagination, $model,$type='start',$limit=0){
		$start = $limit;
		$offset = 10;
		$this->load->library('mypagination');
		$this->load->helper('pagination');
		$this->load->model('blog/blogpost');
		return $this->mypagination->paginate($id_pagination, $this->blogpost,$start,$offset,'getListWithAuthors');
	}

}
