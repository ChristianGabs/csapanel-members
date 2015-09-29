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


class Display {
	protected $type = '';
	protected $header = true;
	protected $footer = true;
	protected $display = array();
	protected $_smartyvalues = array();
	private static $_instance = NULL;
	private static $_smarty;

	static public function getInstance(){
		if(self::$_instance == NULL)
			self::$_instance = new self();
		
		return self::$_instance;
	}

	static function getSmartyInstance() {
		if (self::$_smarty == NULL) {
			self::$_smarty = new Smarty();
		}
		return self::$_smarty;
	}
	
	public function &__get($name) {
		return $this->_smartyvalues[$name];
	}

	function __set($name, $value) {
		$this->_smartyvalues[$name] = $value;
	}

	function DisplayType($type) {
		$this->type = $type;
		switch ($this->type) {
			case "login" : {
					$this->DisplayHeader(true);
					$this->DisplayFooter(true);
					break;
				}
			case "interface" : {
					$this->DisplayHeader(true);
					$this->DisplayFooter(true);
					break;
				}
			case "admin" : {
					$this->DisplayHeader(true);
					$this->DisplayFooter(true);
					break;
				}
			case "ajax" : {
					$this->DisplayHeader(false);
					$this->DisplayFooter(false);
					break;
				}
			default: {
					break;
				}
		}
	}

	function DisplayHeader($header) {
		$this->header = $header;
	}

	function DisplayFooter($footer) {
		$this->footer = $footer;
	}

	function AddDisplay($file) {
		if (count($this->display) > 0) {
			$this->display[count($this->display) + 1] = $file;
			return null;
		}
		$this->display[0] = $file;
	}

	function AddVariable($key, $val) {
		$this->_smartyvalues[$key] = $val;
	}

	function Output($template = '') {
		if (is_array($this->_smartyvalues)) {
			foreach ($this->_smartyvalues as $key => $value) {
				$this->getSmartyInstance()->assign($key, $value);
			}
		}
		if ($this->header == true) {
			switch ($this->type) {
				case "login" : {
					$this->getSmartyInstance()->display('login/header.tpl');
					break;
				}
				case "interface" : {
					$this->getSmartyInstance()->display('interface/header.tpl');
					break;
				}
				case "admin" : {
					$this->getSmartyInstance()->display('admin/header.tpl');
					break;
				}
				default : break;
			}
		}
		if (!empty($template)) {
			if (is_array($template) && count($template) > 0){
				foreach ($template as $tpl){
					$this->getSmartyInstance()->display($tpl);
				}
			} else {
				$this->getSmartyInstance()->display($template);
			}
		} else {
			if (is_array($this->display) && count($this->display) > 0) {
				foreach ($this->display as $tpl) {
					$this->getSmartyInstance()->display($tpl);
				}
			}
		}
		if ($this->footer == true) {
			if(date("Y") == "2015") {
				$date = date("Y");
			} else {
				$date = "2015 - ".date("Y");
			}
			if($this->type == "interface") {
				$footerout = "<footer id='footer' class='container'>";
				$footerout .= str_replace("%d", $date, Strings::BaseSetType("copyrightinterface"));
				$footerout .= Strings::BaseSetType("pulltop");
			} else {
				if (isset($_SESSION['userlevel']) == '1') {
					$footerout .= "<span style='font-size:11px;'>Version: <b style='color:#0176A4;'>".CSA::getInstance()->CheckVersion()."</b></span>";
				}
				$footerout = "<footer>";
				$footerout .= str_replace("%d", $date, Strings::BaseSetType("copyrightadmin"));
				
			}
			$footerout .= '</footer>';
			switch ($this->type) {
				case "login" : {
					echo $footerout;
					$this->getSmartyInstance()->display('login/footer.tpl');
					break;
				}
				case "interface": {
					echo $footerout;
					$this->getSmartyInstance()->display('interface/footer.tpl');
					break;
				}
				case "admin": {
					echo $footerout;
					$this->getSmartyInstance()->display('admin/footer.tpl');
					break;
				}
				default: break; 
			}
		}
	}
}
