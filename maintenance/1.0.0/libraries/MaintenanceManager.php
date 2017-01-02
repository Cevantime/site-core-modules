<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');


/**
 * Description of MaintenanceManager
 *
 * @author cevantime
 */
class MaintenanceManager {
	public function turn($mode) {
		$this->configuration->setValue('maintenance', $mode);
	}
}
