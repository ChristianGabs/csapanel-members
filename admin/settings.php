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


require_once("../includes/csa-functions.php");
if($_SESSION['mainadmin'] != "1") {
	$_SESSION['errormessage'] = $lang['nopermission'];
	header("Location: dashboard.php");
	exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	switch($_POST['mode']) {
		case "eventlogging" : {
			foreach($_POST['eventlog'] as $key => $value) {
				CSA::getInstance()->sqli->query("INSERT INTO `settings` (`name`,`value`) VALUES ('eventlog_{$key}','{$value}') ON DUPLICATE KEY UPDATE `value`='{$value}';");
			}
			$_SESSION['goodmessage'] = $lang['settingssaved'];
			header("Location: settings.php");
			break;
		}
		case "links" : {
			CSA::getInstance()->sqli->query("UPDATE `settings` SET `value`='{$_POST['linkprofile']}' WHERE `name`='linkprofile';");
			$_SESSION['goodmessage'] = $lang['settingssaved'];
			header("Location: settings.php");
			break;
		}
		default : {
			CSA::getInstance()->sqli->query("UPDATE `settings` SET `value`='{$_POST['defaultlanguage']}' WHERE `name`='language';");
			CSA::getInstance()->sqli->query("UPDATE `settings` SET `value`='{$_POST['title']}' WHERE `name`='title';");
			CSA::getInstance()->sqli->query("UPDATE `settings` SET `value`='{$_POST['template']}' WHERE `name`='template';");
			CSA::getInstance()->sqli->query("UPDATE `settings` SET `value`='{$_POST['debugging']}' WHERE `name`='debugging';");
			CSA::getInstance()->sqli->query("UPDATE `settings` SET `value`='{$_POST['smartydebug']}' WHERE `name`='smartydebug';");
			CSA::getInstance()->sqli->query("UPDATE `settings` SET `value`='{$_POST['redirectlogout']}' WHERE `name`='redirectlogout';");
			CSA::getInstance()->sqli->query("UPDATE `settings` SET `value`='{$_POST['timezone']}' WHERE `name`='timezone';");
			CSA::getInstance()->sqli->query("UPDATE `settings` SET `value`='{$_POST['forcehttps']}' WHERE `name`='forcehttps';");
			//Remove Smarty template cache
			$smarty->clearAllCache();
			$smarty->clearCompiledTemplate();

			
			$_SESSION['goodmessage'] = $lang['settingssaved'];
			header("Location: settings.php");
			break;
		}
	}
}
$display->pagename = $lang['generalsettings'];
$display->DisplayType("admin");

//----------------------- Template -----------------------
$templates = array();
$dir = opendir("../templates/");
while($file = readdir($dir)) {
	if($file != "." && $file != "..") {
		if(is_dir("../templates/".$file)) {
			$templates[] = $file;
		}
	}
}
$display->templates = $templates;

//----------------------- Language -----------------------
$languages = array();
$dir = opendir("../includes/lang/");
while($file = readdir($dir)) {
	if($file != "." && $file != ".." && is_file("../includes/lang/".$file)) {
		$path_info = pathinfo("../includes/lang/".$file);
		if($path_info['extension'] == "php") {
			$languages[] = str_replace(".php", "", $file);
		}
	}
}
$display->languages = $languages;

//----------------------- Time zone -----------------------
$timezoneIdentifiers = DateTimeZone::listIdentifiers();
$gmtTime = new DateTime('now', new DateTimeZone('GMT'));

$tempTimezones = array();
foreach($timezoneIdentifiers as $timezoneIdentifier) {
	$currentTimezone = new DateTimeZone($timezoneIdentifier);
	$tempTimezones[] = array(
		'offset' => (int) $currentTimezone->getOffset($gmtTime),
		'identifier' => $timezoneIdentifier
	);
}

usort($tempTimezones, function($a, $b) {
	return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
});
$timezoneList = array();
foreach($tempTimezones as $time) {
	$sign = ($time['offset'] > 0) ? '+' : '-';
	$offset = gmdate('H:i', abs($time['offset']));
	$timezoneList[$time['identifier']] = '(GMT '.$sign.$offset.') '.$time['identifier'];
}
$display->timezones = $timezoneList;


$display->Output("admin/configuration/settings.tpl");