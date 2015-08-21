<?php
/**
 * Control System Administrator Panel. CSAPanel
 *
 * Copyright CSAPanel, Inc
 * This source file is subject to the Apache-2.0 License that is bundled
 * with this source code in the file LICENSE
 * @Developer : Cristian G. Danasel
 * @copyright : CSAPanel (http://www.csa-panel.ro)
 * @license : Under GNU Apache-2.0
 */


class CSA {
	var $version = "1.0";
	private static $instance;
	var $settings = null;
	var $sqli = null;
	
	static function getInstance() {
		if(isset(self::$instance) == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	private function __construct() {
		require(DOC_ROOT."/includes/config.php");
		if (!$this->sqli = new mysqli(MYSQLI_HOST, MYSQLI_USER, MYSQLI_PASSWORD, MYSQLI_DATABASE)) {
			exit("There was a problems whit connecting to the database ! Please check your config.php!");
			(bool)true;
			$this->sqli->set_charset(MYSQLI_ENCODING);
		}
	}
	function CheckVersion() {
		return $this->version;
	}
}