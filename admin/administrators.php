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
	if(!in_array("editadmin", $_SESSION['permissions']) && !in_array("addadmin", $_SESSION['permissions']) && !in_array("deleteadmin", $_SESSION['permissions']) && !in_array("manageclient", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: dashboard.php");
		exit();
	}
	if($_REQUEST['mode'] == "edit" && !in_array("editadmin", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: dashboard.php");
		exit();
	}
	if($_REQUEST['mode'] == "add" && !in_array("addadmin", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: dashboard.php");
		exit();
	}
	if($_REQUEST['mode'] == "delete" && !in_array("deleteadmin", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: dashboard.php");
		exit();
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	switch($_REQUEST['mode']) {
		case "edit" : {
			$return = User::EditAdministrator(array(
				'perms' => $_REQUEST['perm'],
				'mainadmin' => $_REQUEST['mainadmin'],
				'email' => $_REQUEST['email'],
				'password' => $_REQUEST['password'],
				'uid' => $_REQUEST['uid'],
				'perm' => $_REQUEST['perms'],
				'status' => $_REQUEST['status'],
				'allowedips' => $_REQUEST['allowedips']
			));
			switch($return['response']) {
				case "success": {
					$_SESSION['goodmessage'] = $lang['usersaved'];
					break;
				}
				case "emptyuid" : {
					$_SESSION['errormessage'] = $lang['nouserspecified'];
					break;
				}
				case "emptyemail" : {
					$_SESSION['errormessage'] = $lang['novalidemail'];
					break;
				}
				case "mainprivledges" : {
					$_SESSION['errormessage'] = $lang['mainprivledges'];
					break;
				}
				case "invalidemail" : {
					$_SESSION['errormessage'] = $lang['invalidemail'];
					break;
				}
				case "usernotexist" : {
					$_SESSION['errormessage'] = $lang['usernotexist'];
					break;
				}
				default : {
					$_SESSION['errormessage'] = $lang['opssomething'];
				}
			}
			header("Location: administrators.php");
			exit();
			break;
		}
		case "add" : {
			$return = User::AddAdmininistrator(array(
				'perms' => $_REQUEST['perm'],
				'mainadmin' => $_REQUEST['mainadmin'],
				'email' => $_REQUEST['email'],
				'password' => $_REQUEST['password'],
				'perm' => $_REQUEST['perms'],
				'status' => $_REQUEST['status'],
				'allowedips' => $_REQUEST['allowedips']
			));
			switch($return['response']) {
				case "success" : {
					$_SESSION['goodmessage'] = $lang['useradded'];
					break;
				}
				case "novalidemail" : {
					$_SESSION['errormessage'] = $lang['novalidemail'];
					break;
				}
				case "nopassword" : {
					$_SESSION['errormessage'] = $lang['nopassword'];
					break;
				}
				case "invalidemail" : {
					$_SESSION['errormessage'] = $lang['invalidemail'];
					break;
				}
				default : {
					$_SESSION['errormessage'] = $lang['opssomething'];
				}
			}
			header("Location: administrators.php");
			break;
		}
		default : {
			$_SESSION['errormessage'] = $lang['opssomething'];
			break;
		}
	}
}
switch($_REQUEST['mode']) {
	case "edit" : {
		$display->pagename = $lang['editadministrator'];
		$info = User::GetAdministratorInfo($_REQUEST['uid']);
		if($info && count($info) != 0) {
			$display->info = $info;
			$display->DisplayType("admin");
			$display->Output("admin/configuration/administrators-add.tpl");
		} else {
			$_SESSION['errormessage'] = $lang['nouserfound'];
			header("Location: index.php");
		}
		break;
	}
	case "add" : {
		$display->pagename = $lang['addadministrator'];
		$display->DisplayType("admin");
		$display->Output("admin/configuration/administrators-add.tpl");
		break;
	}	
	case "delete" : {
		$results = User::DeleteAdministrator($_REQUEST['uid']);
		switch($results['response']) {
			case "success" : {
				$_SESSION['goodmessage'] = $lang['administratorremoved'];
				break;
			}
			case "nouserdatabase" : {
				$_SESSION['errormessage'] = $lang['nouserdatabase'];
				break;
			}
			case "errormainadmin" : {
				$_SESSION['errormessage'] = $lang['errormainadmin'];
				break;
			}
			default : {
				$_SESSION['errormessage'] = $lang['opssomething'];
				break;
			}
		}
		header("Location: administrators.php");
		exit();
		break;
	}
	default : {
		$display->pagename = $lang['administrators'];
		$display->DisplayType("admin");
		$display->admins = User::ListAdministrators();
		$display->Output("admin/configuration/administrators-list.tpl");
		break;
	}
}