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


require_once("includes.php");
$start = microtime(true);
	if (!function_exists("LoadClass")) {
		exit("Unable to load CSA-Panel files");
	}
	@define("DOC_ROOT", str_replace(array("/includes/csa-functions.php", "\includes\csa-functions.php"), "", realpath(__FILE__)));
	@header("Cache-Control: must-revalidate");
	@header("Expires: 0");
	@ini_set("magic_quotes_runtime", 0);
	@ini_set("max_execution_time", "90");
	@set_time_limit(90);
	$memlimt = str_replace("M", "", @ini_get("memory_limit"));
	if ($memlimt < "16") {
		@ini_set("memory_limit", "64M");
	}

	$display = Display::getInstance();
	$smarty = Display::getSmartyInstance();
	$session = new session();
	if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) {
		$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
		if ($key = $val = each($process)) {
			foreach ($val as $k => $v) {
				unset( $process[$key][$k] );
				if (is_array( $v )) {
					$process[$key][stripslashes($k)] = $v;
					$process[] = &$process[$key][stripslashes($k)];
					continue;
				}
				$process[$key][stripslashes($k)] = stripslashes($v);
			}
		}
		unset($process);
	}
	CSA::getInstance()->settings = array();
	if (!$query = CSA::getInstance()->sqli->query("SELECT * FROM `settings`;")) {
		echo "Unable to connect database please contact support!";
		(bool)true;
	}
	while ($row = $query->fetch_assoc()) {
		if ($row['name'] == "debugging" && $row['value'] == "2") {
			if (isset($_SESSION['userlevel']) && $_SESSION['userlevel'] == "1") {
				$row['value'] = "1";
			} 
			else {
				$row['value'] = "0";
			}
		}
		CSA::getInstance()->settings[$row['name']] = $row['value'];
	}
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
		$http_mode = "https";
	} else {
		$http_mode = "http";
	}
	if (@CSA::getInstance()->settings['forcehttps'] == '1' && $http_mode != 'https') {
		header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		exit();
	}
	$currentfile = basename($_SERVER['PHP_SELF']);
	if (!(isset(CSA::getInstance()->settings['baseurl'])) || CSA::getInstance()->settings['baseurl'] == "none") {
		CSA::getInstance()->settings['baseurl'] = str_replace($currentfile, "", $_SERVER['PHP_SELF']);
		CSA::getInstance()->settings['baseurl'] = rtrim(CSA::getInstance()->settings['baseurl'], "/");
	}
	$pos = @strpos(str_replace($currentfile, "", $_SERVER['PHP_SELF']), CSA::getInstance()->settings['baseurl']);
	if ($pos !== false) {
		$internalpath = substr_replace(str_replace($currentfile, "", $_SERVER['PHP_SELF']), "", $pos, strlen(CSA::getInstance()->settings['baseurl']));
		$internalpath = ltrim($internalpath, "/");
	} else {
		$internalpath = str_replace($currentfile, "", $_SERVER['PHP_SELF']);
	}
	CSA::getInstance()->settings['http_mode'] = $http_mode;
	CSA::getInstance()->settings['internalpath'] = $internalpath;
	CSA::getInstance()->settings['currentfile'] = $currentfile;
	if (!isCli()) {
		$domain = $_SERVER['HTTP_HOST'];
		if (strlen(strstr($currentfile, "/" ))) {
			if (!empty(CSA::getInstance()->settings['baseurl']) && CSA::getInstance()->settings['baseurl'] != "\\") {
				$webpath = $domain."".CSA::getInstance()->settings['baseurl'];
			} 
			else {
				$webpath = $display;
			}
		} else {
			if (!empty(CSA::getInstance()->settings['baseurl']) && CSA::getInstance()->settings['baseurl'] != "/") {
				$webpath = $domain."".CSA::getInstance()->settings['baseurl'];
			} else {
				$webpath = $domain;
			}
		}
		$webpath =  str_replace('\\', '/', $webpath);
		$webpath = rtrim($webpath, '/');
	}
	if ($internalpath == "/" || $internalpath == "\\") {
		$internalpath = "";
	}
	if (!(iscli())) {
			CSA::getInstance()->settings['webpath'] = $webpath;
	}
	
	$smarty->assign("settings", CSA::getInstance()->settings);
	$template_dir = DOC_ROOT."/templates_c/";
	if (!is_dir($template_dir)) {
		@mkdir($template_dir);
		if (!is_dir($template_dir)) {
			echo "The folder for compiled templates does not exist<br />".$template_dir;
			exit();
		}
	}
	if (!is_writable($template_dir)) {
		@chmod($templates_dir, 510);
		if (!is_writable($template_dir)) {
			echo "The folder for compiled templates directory is not writable!<br/>".$template_dir;
			exit();
		}
	}
	if (CSA::getInstance()->settings['debugging'] == 0) {
		error_reporting(0);
	} else {
		error_reporting(E_ALL ^ E_NOTICE /*^ E_DEPRECATED ^ E_WARNING*/);
	}
	if (!is_dir(DOC_ROOT."/templates/".CSA::getInstance()->settings['template'])) {
		echo "The selected template does not exist, please upload it.";
		exit();
	}
	if (isset($_SESSION['language']) && is_file(DOC_ROOT."/includes/lang/".$_SESSION['language'].".php")) {
		CSA::getInstance()->settings['language'] = $_SESSION['language'];
	}
	if (!isset(CSA::getInstance()->settings['language']) || empty(CSA::getInstance()->settings['language'])) {
		CSA::getInstance()->settings['language'] = "english";
	}
	if (!is_file(DOC_ROOT."/includes/lang/".CSA::getInstance()->settings['language'].".php")) {
		CSA::getInstance()->settings['language'] = 'english';
		if (!is_file( DOC_ROOT."/includes/lang/".CSA::getInstance()->settings['language'].".php")) {
			echo "Default language file not found";
			exit();
		} else {
			include( DOC_ROOT."/includes/lang/".CSA::getInstance()->settings['language'].".php");
			if (!is_array($lang) || count($lang) == 0){
				exit("Error parsing the language file");
			}
		}
	} else {
		include(DOC_ROOT."/includes/lang/".CSA::getInstance()->settings['language'].".php");
		if (!is_array($lang) || count($lang) == 0) {
			exit("Error parsing the language file");
		}
	}
	$smarty->config_dir = DOC_ROOT . "/includes/classes/interface/smarty";
	$smarty->plugins_dir = DOC_ROOT . "/includes/classes/interface/smarty/plugins/";
	$smarty->template_dir = array(DOC_ROOT."/templates/".CSA::getInstance()->settings['template']."/", DOC_ROOT."/templates/csapanel");
	$smarty->compile_dir = DOC_ROOT."/templates_c/";
	$smarty->compile_check = true;
	$smarty->config_booleanize = false;
	$smarty->assign("lang", $lang);
	if (CSA::getInstance()->settings['smartydebug'] == "1") {
		$smarty->debugging = true;
	} else {
		$smarty->debugging = false;
	}
	$smarty->cache_dir = DOC_ROOT."/cache/";
	$smarty->caching = 0;
	$smarty->cache_lifetime = 1800;
	if (CSA::getInstance()->settings['smarty_forcecompile'] == "1") {
		$smarty->force_compile = true;
		$smarty->clearAllCache();
		$smarty->clearCompiledTemplate();
	}
	if (isset($_SESSION['goodmessage']) && !empty($_SESSION['goodmessage'])) {
		$display->getSmartyInstance()->assign("goodmessage", $_SESSION['goodmessage']);
		$_SESSION['goodmessage'] = "";
	}
	if (isset($_SESSION['errormessage']) && !empty($_SESSION['errormessage'])) {
		$display->getSmartyInstance()->assign("errormessage", $_SESSION['errormessage']);
		$_SESSION['errormessage'] = "";
	}
	if (isset($_SESSION['systemmessage']) && !empty($_SESSION['systemmessage'])) {
		$display->getSmartyInstance()->assign("systemmessage", $_SESSION['systemmessage']);
		$_SESSION['systemmessage'] = "";
	}