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
class Index extends BO_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('traductions/traductor');
	}

	public function index() {
		$this->translate();
	}

	public function translate($lang = null) {
		if (!$lang) {
			$lang = locale();
		}
		$this->layout->css('css/traductions/trads.css');
		$this->layout->js('js/homePopup.js');
		$this->load->helper('form');
		$this->traductor->export();
		$fullTrads = $this->traductor->getFull();
		$datas = array('fullTrads' => $fullTrads, 'lang' => $lang);
		$this->layout->view('traductions/index', $datas);
	}

	public function merge() {
		$config = array(
			'upload_path' => './translate/',
			'allowed_types' => '*'
		);
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('translatemerge')) {
			add_error($this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			if($this->_isJson(file_get_contents($data['full_path']))){
				
				$this->traductor->merge($data['full_path']);
				unlink($data['full_path']);
				add_success(translate('le fichier de traduction a bien été ajouté'));
			} else {
				add_error(translate('Le fichier uploadé n\'est pas un json'));
			}
		}
		redirect('traductions/index/translate');
	}

	private function _isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	public function save() {
		$post = $this->input->post();
		if (!$post || !$this->input->post('translate')) {
			add_error(translate('Une erreur est survenue'));
			redirect('traductions/index');
		}

		$issetLang = isset($post['lang']);
		$lang = $issetLang ? $post['lang'] : 'fr';

		if ($issetLang)
			unset($post['lang']);

		unset($post['translate']);

		$fullTrads = $this->traductor->getFull();

		foreach ($fullTrads as $file => $trads) {
			foreach ($trads as $id => $trad) {
				if (isset($post['exclude-' . $id]) && $post['exclude-' . $id]) {
					$fullTrads[$file][$id]['excluded'][$lang] = '1';
				} else {
					$fullTrads[$file][$id]['excluded'][$lang] = '0';
				}
				if (isset($post['ignore-' . $id]) && $post['ignore-' . $id]) {
					$fullTrads[$file][$id]['ignored'][$lang] = '1';
				} else {
					$fullTrads[$file][$id]['ignored'][$lang] = '0';
				}
			}
		}

		$this->traductor->setFull($fullTrads);

		$this->traductor->complete($post, $lang);

		$this->traductor->translation($lang);

		add_success(translate('La traduction a bien été effectuée'));

		redirect('traductions/index');
	}

	public function cleanup() {
		$this->traductor->cleanup();
		redirect('traductions/index');
	}

}

?>
