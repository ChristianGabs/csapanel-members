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
	header("Location: index.php");
	exit();
}
// Arata ultimele eventuri.
$events = array();
$x = 0;
$query = CSA::getInstance()->sqli->query("SELECT * FROM `events` WHERE `type`!='login' ORDER BY `time` DESC LIMIT 20");
if($query->num_rows > 0) {
	while($row = $query->fetch_assoc()) {
		$row['user'] = User::UIDToUser($row['userid']);
		$queryuser = CSA::getInstance()->sqli->query("SELECT realname FROM `clients` WHERE `uid`='{$row['userid']}' LIMIT 1;");
		if($queryuser->num_rows == 1) {
			$rowuser = $queryuser->fetch_assoc();
		}
		$queryuser = CSA::getInstance()->sqli->query("SELECT firstname, lastname FROM `users_profile` WHERE `uid`='{$row['runbyid']}' LIMIT 1;");
		if($queryuser->num_rows == 1) {
			$rowrunby = $queryuser->fetch_assoc();
		}
		$row['runby'] = User::UIDToUser($row['runbyid'], "administrator");
		if($rowuser && !empty($rowuser['realname'])) {
			$tempuser = '<strong data-toggle="tooltip" title="'.Strings::filter($rowuser['realname']).'('.Strings::filter($row['user']).')"><i class="fa fa-info-circle"></i></strong>';
		} else {
			$tempuser = '<strong data-toggle="tooltip" title="'.Strings::filter($row['user']).'"><i class="fa fa-info-circle"></i></strong>';
		}
		$row['message'] = str_replace("{user}", $tempuser, $row['message']);
		if($rowrunby && !empty($rowrunby['firstname'])) {
			$tempuser = '<strong data-toggle="tooltip" title="'.Strings::filter($rowrunby['firstname']).' '.Strings::filter($rowrunby['lastname']).'('.Strings::filter($row['runby']).')"><i class="fa fa-info-circle"></i></strong>';
		} else {
			$tempuser = '<strong data-toggle="tooltip" title="'.Strings::filter($row['runby']).'"><i class="fa fa-info-circle"></i></strong>';
		}
		$row['message'] = str_replace("{runby}", $tempuser, $row['message']);
	
		$events[$x] = $row;
		$x++;
	}
}
//-------------- Get Use Trust -------------------
$usertrust = User::ListClients(array("type" => "usertrust"));
if($usertrust['usertrust'] > 0) {
	$display->usertrust = $usertrust['usertrust'];
} else {
	$display->usertrust = "0";
}
//-------------- Get Use Untrustworthy -------------------
$untrustworthy = User::ListClients(array("type" => "untrustworthy"));
if($untrustworthy['untrustworthy'] > 0) {
	$display->untrustworthy = $untrustworthy['untrustworthy'];
} else {
	$display->untrustworthy = "0";
}
//-------------- Get Use Pending -------------------
$userpending = User::ListClients(array("type" => "userpending"));
if($userpending['userpending'] > 0) {
	$display->userpending = $userpending['userpending'];
} else {
	$display->userpending = "0";
}

$display->events = $events;
$display->pagename = $lang['home'];
$display->DisplayType("admin");
$display->Output("admin/index.tpl");