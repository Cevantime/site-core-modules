<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Traductor {
	
	private $_trads;
	private $_folder;
	private $_tradFiles;
	private $_jarTranslate;
	
	public function __construct() {
		$CI =& get_instance();
		$CI->load->helper('locale');
		$this->_folder = realpath(APPPATH.'../');
		$this->_jarTranslate = APPPATH.'modules/traductions/third_party/translate.jar';
		$this->_trads = $this->getDico(locale());
	}
	
	public function getFileTrad($filename,$lang) {
		$CI =& get_instance();
		
		$CI->load->model('traductions/file');
		if(!isset($this->_tradFiles[$filename])) {
			$this->_tradFiles[$filename] = $CI->file->getFileTradByPath($filename,$lang);
		}
		return $this->_tradFiles[$filename];
	}
	
	public function getFull() {
		return json_decode(file_get_contents(APPPATH.'../translate/translate.json'),true);
	}
	
	public function setFull($full) {
		file_put_contents(APPPATH.'../translate/translate.json', json_encode($full, JSON_FORCE_OBJECT));
	}
	
	public function getDico($lang) {
		$fullDico = $this->getFull();
		if(!$fullDico) return array();
		foreach ($fullDico as $file) {
			foreach ($file as $idtrad => $trad) {
				$dico[$trad['origin']] = isset($trad['traductions'][$lang]) ? $trad['traductions'][$lang] : $trad['origin'];
			}
		}
		return $dico;
	}
	
	public function export() {
		return $this->jarTranslate('export');
	}
	
	public function cleanup() {
		return $this->jarTranslate('cleanup');
	}
	
	public function merge($jsonFile) {
		$jsonFile = realpath($jsonFile);
		$toMerge = json_decode(file_get_contents($jsonFile), true);
		foreach ($toMerge as $filename => $value) {
			unset($toMerge[$filename]);
			$newfilename = preg_replace('#(.*)application/(.*)#', APPPATH.'application/$2', $filename);
			$toMerge[$newfilename] = $value;
		}
		file_put_contents($jsonFile, json_encode($toMerge, JSON_FORCE_OBJECT));
		return $this->jarTranslate('merge', $jsonFile);
	}
	
	public function translation($lang) {
		$CI =& get_instance();
		$db = $CI->db;
		return $this->jarTranslate('translate', $lang, "$db->hostname,$db->database,$db->username,$db->password");
	}
	
	public function complete($dicoIdLang, $lang) {
		$jsonDico = $this->_folder.'/translate/'.uniqid().'.json';
		file_put_contents($jsonDico, json_encode($dicoIdLang));
		$this->jarTranslate('complete',$lang,$jsonDico);
		unlink($jsonDico);
	}
	
	public function linearize($lang) {
		$jsonLinear = $this->jarTranslate('linearize',$lang);
		$dico = json_decode(file_get_contents($jsonLinear));
		unlink($jsonLinear);
		return $dico;
	}
	
	public function translate($exp){
		return isset($this->_trads[$exp]) && $this->_trads[$exp] ? $this->_trads[$exp] : $exp;
	}
	
	private function jarTranslate() {
		$args = func_get_args();
		if (empty($args)) {
			return '';
		}
		$jarTr = "java -jar $this->_jarTranslate $args[0] $this->_folder";
		
		for ($i = 1; $i < count($args); $i++){
			$arg = $args[$i];
			$jarTr .= ' '.$arg;
		}
		putenv('LANG=fr_FR.UTF-8');
		$output = exec($jarTr, $out);
		return $output;
	}
}