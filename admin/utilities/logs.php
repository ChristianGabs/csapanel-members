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


if($_SESSION['mainadmin'] != "1") {
	$_SESSION['errormessage'] = $lang['nopermission'];
	header("Location: index.php");
	exit();
}
if(isset($_REQUEST['clear']) && $_SESSION['mainadmin'] == "1") {
	$query = CSA::getInstance()->sqli->query("DELETE FROM `events`");
	if(CSA::getInstance()->sqli->affected_rows == 0) {
		$_SESSION['errormessage'] = $lang['eventlogempty'];
		header("Location: utility.php?module=logs");
	} elseif(CSA::getInstance()->sqli->affected_rows > 0) {
		CSA::getInstance()->sqli->query("TRUNCATE TABLE `events`;");
		$_SESSION['goodmessage'] = $lang['eventlogclear'];
		header("Location: utility.php?module=logs");
	} else {
		$_SESSION['errormessage'] = $lang['eventlogerror'];
		header("Location: utility.php?module=logs");
	}
}
switch($_REQUEST['logtype']) {
	case "events" : {
		$limit = 30;
		if(!isset($_REQUEST['page']) || empty($_REQUEST['page'])) {
			$_REQUEST['page'] = 0;
		} else {
			$_REQUEST['page'] = $_REQUEST['page'] - 1;
		}
		$pages['current'] = $_REQUEST['page'] + 1;
		
		if(!empty($_REQUEST['userid'])) {
			$sql = "WHERE `userid`='{$_REQUEST['userid']}'";
		}
		$query = CSA::getInstance()->sqli->query("SELECT COUNT(*) as total FROM `events` {$sql};");
		if($query && $query->num_rows > 0) {
			$info = $query->fetch_assoc();
			$total_rows = $info['total'];
		}
		$pages['totalpage'] = ceil($total_rows / $limit);
		
		$events = array();
		$x = 0;
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `events` {$sql} ORDER BY `time` DESC LIMIT ".($_REQUEST['page'] * $limit).",".$limit);
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
		$display->pages = $pages;
		$display->events = $events;
		$display->DisplayType("ajax");
		if(empty($_REQUEST['mode'])) {
			$display->users = User::ListAdministrators();
			$display->Output("admin/utilities/logs/events-main.tpl");
		} else {
			$display->Output("admin/utilities/logs/events-list.tpl");
		}
		break;
	}
	default : {
		$display->pagename = $lang['eventlogs'];
		$display->DisplayType("admin");
		$display->Output("admin/utilities/logs/logs.tpl");
		break;
	}
}