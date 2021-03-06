<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BO_Controller
 *
 * @author thibault
 */
class BO_Controller extends MX_Controller {
	
	protected $userId;

	public function __construct() {
		parent::__construct();
		$this->load->library('layout/layout');
		$this->layout->setLayout('bo/layout/bo');
		$this->load->helper('memberspace/authorization');
		$this->load->model('memberspace/user');
		if($this->session->user_id){
			$this->user->load($this->session->user_id);
			if(!$this->user->can('access','backoffice')){
				redirect('bo/login');
			}
			$this->load->model('bo/admin');
			$this->admin->loadRow('users.id = '.$this->user->id);
		} else {
			redirect('bo/login');
		}
		$this->load->library('mypagination');
		$this->load->helper('pagination');
		$this->layout->assign('user', $this->admin);
		$this->breadcrumb();
	}
	protected function pagination($model, $start, $offset = 10, $methodName = 'getList', $suffix = '') {
		if (is_string($model)) {
			$this->load->model($model);
			$model = $this->{$model};
		}
		$this->load->helper('paginationfront');
		$offset = ($offset !== null) ? $offset : 10;
		$dep = ($start !== null) ? $start * $offset : null;
		$models = $model->$methodName($dep, $offset);
		if (!$models) {
			$models = array();
		}
		//Trying (desperately) to retrieve the query returning the number of 
		//all elements for the corresponding methodName, without limit and offset
		//other methods are likely to offer terrible performances with large datasets
		$lastQuery = $model->db->last_query();
		$endPos = strpos($lastQuery, 'LIMIT ');
		$from = substr($lastQuery, 0, $endPos);
		$queryCount = 'SELECT COUNT(*) as c FROM (' . $from . ') as lastquery';

		//retrieving total number of elements
		$resCount = $model->db->query($queryCount)->result('array');
		if ($resCount) {
			$max = $resCount[0]['c'];
		}

		$datas['start' . $suffix] = $start;
		$datas['max' . $suffix] = isset($max) ? $max : 0;
		$datas['offset' . $suffix] = $offset;
		$this->layout->assign($datas);
		return $models;
	}
	
	protected function breadcrumb($breadcrumb = null) {
		if(!$breadcrumb){
			$breadcrumb = array();
			$segments = $this->uri->segment_array();
			$uri = base_url();
			foreach($segments as $segment) {
				$uri .= $segment.'/';
				$breadcrumb[ucfirst($segment)] = $uri;
			}
			array_shift($breadcrumb);
		}
		
		$this->layout->assign('breadcrumb', $breadcrumb);
	}
	
	private function addMessage($type, $message){
		$this->load->library('flashmessages/flashMessagesManager');
		$this->flashmessagesmanager->pushNewMessage($message,$type);
	}

	protected function addError($message) {
		$this->addMessage('error', $message);
	}

	protected function addSuccess($message) {
		$this->addMessage('succes', $message);
	}

	protected function addWarnings($message) {
		$this->addMessage('warning', $message);
	}
	
	
	protected function checkIfUserCan($action,$object='*',$value='*'){
		if(!$this->user->can($action,$object,$value)){
			redirect('bo/home');
		}
	}
}

?>
