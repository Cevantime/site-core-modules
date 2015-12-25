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
class See extends BLOG_Controller {

	public function index($type='start',$limit=0) {
		$this->basic($type, $limit);
	}
	
	public function basic($id = null) {
		$this->load->view('blog/see/basic',array('blogpost'=> $this->getId($id)));
	}
	
	public function bo($id = null) {
		$this->load->view('blog/see/bo',array('blogpost'=> $this->getId($id)));
	}
	
	public function front($id = null) {
		$this->load->view('blog/see/front',array('blogpost'=> $this->getId($id)));
	}

	public function delete($id = null){
		if(!$id){
			show_404();
		}
		$this->load->model('blog/blogpost');
		$this->blogpost->deleteId($id);
		$this->addSuccess('Le post a bien été supprimé');
		$this->load->view('blog/see/delete');
	}
	
	public function getId($id = null){
		if(!$id){
			show_404();
		}
		$this->load->model('blog/blogpost');
		$blog_post =  $this->blogpost->getByIdWithAuthor($id);
		if(!$blog_post){
			show_404();
		}
		return $blog_post;
	}

}
