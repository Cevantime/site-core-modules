<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Register extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('flashmessages');
		$this->load->helper('form');
	}

	public function bootstrap($mailRedirect = 'memberspace/confirmation/confirm', $redirect = null) {
		$datas = $this->save($mailRedirect, $redirect);
		$this->load->view('memberspace/register/bootstrap', array('pop'=>$datas));
	}

	public function save($mailRedirect = 'memberspace/confirmation/confirm', $redirect = null) {
		
		$rules = Modules::load_multiple('form_validation', 'memberspace', 'config/', 'config');
		
		$post = $this->input->post();
		
		if(!$post){
			return array();
		}
		
		$this->load->library('form_validation');
		
		if(!isset($rules['myuser'])) return $post;
		
		$this->form_validation->set_rules($rules['myuser']);
		
		if(!$this->form_validation->run()){
			add_error($this->form_validation->error_string());
			return $post;
		} 
		unset($_POST['save-user']);
		$this->load->model('myuser');
		
		$post = $this->input->post();
		
		if(isset($post['id']) && !user_can('update', 'user', $post['id'])){
			return $post;
		}
		// It's important to make a call to $this->input->post() again
		$userId = $this->myuser->save($post);
		
		if(!isset($post['id'])) {
			$this->sendMailConfirmation($userId, $mailRedirect);
			$this->load->model('memberspace/right');
			$this->right->allowUserTo($userId,'*','user',$userId);
			$this->user->addToGroup('users', $userId);
			add_success('Vous avez bien été inscrit !');
		} else {
			add_success('Vous avez bien mis à jour vos informations');
		}
		
		if($redirect){
			redirect($redirect);
		}
		
		return $post;
	}
	
	private function sendMailConfirmation($userId, $mailRedirect) {
		$this->load->model('myuser');
		$this->load->library('mailManager');
		$this->load->library('configuration');
		$subject = $this->configuration->getValue('mail_confirmation_subject','Confirmation de votre inscription');
		$user = $this->myuser->getId($userId);
		if(!$user) {
			add_error('Le mail de confirmation n\'a pas pu être envoyé car le user est introuvable');
			return;
		}
		$keyConfirm = md5($user->login.'_'.$user->password);

		$message = $this->load->view('memberspace/confirmation/mail/custom', 
				array(
					'login' => $user->login,
					'urlRedirection' => base_url($mailRedirect.'/'.$user->id.'/'.$keyConfirm),
					'nomFrom' => $this->configuration->getValue('mail_confirmation_nom_from', 'Tout l\'&eacutequipe de carslogistics'),
					'title' => 'Confirmation de votre inscription'
				), true);
		$this->mailmanager->sendMail(
			$subject,
			$message,
			$user->email
		); 
	}
}
