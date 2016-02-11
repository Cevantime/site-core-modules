<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of configuration
 *
 * @author thibault
 */
class File extends DATA_Model {
	
	const TABLE_NAME = 'translator_files';
	
	public function getTableName() {
		return self::TABLE_NAME;
	}
	
	public function getFileByPath($path) {
		$path = realpath($path);
		return $this->getRow(array('absolute_path'=>$path));
	}
	
	public function getFileTradByPath($path,$lang) {
		$this->load->model('traductions/linkfiletraduction');
		$this->load->model('traductions/traduction');
		$file = $this->getFileByPath($path);
		if(!$file) return file_get_contents ($path);
		$trads = $this->traduction->getThrough(LinkFileTraduction::TABLE_NAME, 'file', $file->id);
		if(!$trads) return file_get_contents ($path);
		foreach ($trads as $trad){
			if($trad->lang == $lang){
				return $trad->content;
			}
		}
		return file_get_contents ($path);
	}
}

?>
