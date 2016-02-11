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
class Expression extends DATA_Model {
	
	const TABLE_NAME = 'translator_expressions';
	
	public function getTableName() {
		return self::TABLE_NAME;
	}

}

?>
