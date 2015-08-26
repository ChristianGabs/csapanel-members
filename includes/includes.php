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


function LoadClass($classname) {
	$classname = strtolower($classname);
	if (!class_exists($classname, false)) {
		if (is_dir(DOC_ROOT."/includes/classes/".$classname)) {
			if (file_exists(DOC_ROOT."/includes/classes/".$classname."/".$classname.".inc.php")) {
				include_once(DOC_ROOT."/includes/classes/".$classname."/".$classname.".inc.php");
				$classname = new $classname();
				return true;
			}
			if (file_exists(DOC_ROOT."/includes/classes/".$classname."/includes.inc.php")) {
				include_once(DOC_ROOT."/includes/classes/".$classname."/includes.inc.php");
				return true;
			}
			return false;
		}
		return false;
	}
	return true;
}
function GetTMPPath() {
	if (!empty(CSA::getInstance()->settings['tmppath'])) {
		return CSA::getInstance()->settings['tmppath'];
	}
	return realpath(sys_get_temp_dir());
}
function AutoLoadClass($classname) {
	switch ($classname) {
		case 'Smarty': {
			@require_once(DOC_ROOT .'/includes/classes/interface/smarty/Smarty.class.php');
			break;
		}
	}
	$classname = strtolower($classname);
	if (is_dir(DOC_ROOT."/includes/classes/".$classname)) {
		if (file_exists(DOC_ROOT."/includes/classes/".$classname."/".$classname.".inc.php")) {
			include_once(DOC_ROOT."/includes/classes/".$classname."/".$classname.".inc.php");
		} else {
			if (file_exists(DOC_ROOT."/includes/classes/".$classname."/includes.inc.php")) {
				include_once(DOC_ROOT."/includes/classes/".$classname."/includes.inc.php");

			}
		}
	}
	return;
}
function isCli() {
	if (php_sapi_name() == "cli" && empty($_SERVER["REMOTE_ADDR"])) {
		return true;
	}
	if (php_sapi_name() != "cli" && empty($_SERVER["REMOTE_ADDR"])) {
		return true;
	}
	return false;
}
function getIP() {
	if (getenv("HTTP_CLIENT_IP")) {
		$findip = getenv("HTTP_CLIENT_IP");
	} elseif (getenv("HTTP_X_FORWARDED_FOR")) {
		$findip = getenv("HTTP_X_FORWARDED_FOR");
	} elseif (getenv("REMOTE_ADDR")) {
		$findip =getenv("REMOTE_ADDR");
	} else {
		$findip = "UNKNOWN";
	}
	return $findip;
}

spl_autoload_register("AutoLoadClass", true);