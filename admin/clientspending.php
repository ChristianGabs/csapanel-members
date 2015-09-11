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
	if(!in_array("addclient", $_SESSION['permissions']) && !in_array("editclient", $_SESSION['permissions']) && !in_array("deleteclient", $_SESSION['permissions']) && !in_array("manageclient", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: index.php");
		exit();
	}
	if($_REQUEST['mode'] == "edit" && !in_array("editclient", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: index.php");
		exit();
	}
	if($_REQUEST['mode'] == "add" && !in_array("addclient", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: index.php");
		exit();
	}
	if($_REQUEST['mode'] == "delete" && !in_array("deleteclient", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: index.php");
		exit();
	}	
	if($_REQUEST['mode'] == "approve" && !in_array("approveclient", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: index.php");
		exit();
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	switch($_REQUEST['mode']) {
		case "edit" : {
			$return = User::EditClient(array(
				'type' => "clientspending",
				'uid' => $_REQUEST['uid'],
				'email' => $_REQUEST['email'],
				'userid' => $_REQUEST['userid'],
				'status' => $_REQUEST['status'],
				'realname' => $_REQUEST['realname'],
				'proof' => $_REQUEST['proof'],
				'phone' => $_REQUEST['phone'],
				'notes' => $_REQUEST['notes']
			));
			switch($return['response']) {
				case "success" : {
					$_SESSION['goodmessage'] = $lang['usersaved'];
					break;
				}
				case "nouserspecified" : {
					$_SESSION['errormessage'] = $lang['nouserspecified'];
					break;
				}
				case "novalidemail" : {
					$_SESSION['errormessage'] = $lang['novalidemail'];
					break;
				}
				case "invalidemail" : {
					$_SESSION['errormessage'] = $lang['invalidemail'];
					continue;
				}
				case "usernotexist" : {
					$_SESSION['errormessage'] = $lang['usernotexist'];
					break;
				}
				default : {
					$_SESSION['errormessage'] = $lang['opssomething'];
					break;
				}
			}
			header("Location: clientspending.php");
			exit();
			break;
		}
		default : {
			$_SESSION['errormessage'] = $lang['opssomething'];
			break;
		}
	}
}

switch($_REQUEST['mode']) {
	case "pagination" : {
		$limit = 30;
		$total_rows = count(User::ListUsersPending(array("search" => $_REQUEST['search'])));
		$pages['totalpage'] = ceil($total_rows / $limit);
		if(!isset($_REQUEST['page']) || empty($_REQUEST['page'])) {
			$_REQUEST['page'] = 0;
		} else {
			$_REQUEST['page'] = $_REQUEST['page'] - 1;
		}
		$pages['current'] = $_REQUEST['page'] + 1;
		$display->clients = User::ListUsersPending(array("search" => $_REQUEST['search'], "limit" => ($_REQUEST['page'] * $limit).",".$limit));
		$display->pages = $pages;
		$display->DisplayType("ajax");
		$display->Output("admin/clientspending/ajax-clientlist.tpl");
		break;
	}
	case "edit" : {
		$display->pagename = $lang['editclient'];
		$info = User::GetClientInfo(array("uid" => $_REQUEST['uid'], "type" => "clientspending"));
		if($info && count($info) != 0) {
			$display->info = $info;
			$display->DisplayType("admin");
			$display->Output("admin/clientspending/clients-edit.tpl");
		} else {
			$_SESSION['errormessage'] = $lang['nouserfound'];
			header("Location: clientspending.php");
		}
		break;
	}
	case "approve" : {
		$results = User::AproveUser(array("uid" => $_REQUEST['uid']));
		switch($results['response']) {
			case "userapprove" : {
				$_SESSION['goodmessage'] = $lang['userapprove'];
				break;
			}
			case "nouserspecified" : {
				$_SESSION['errormessage'] = $lang['nouserspecified'];
				break;
			}
			case "usernotexist" : {
				$_SESSION['errormessage'] = $lang['usernotexist'];
				break;
			}
			default : {
				$_SESSION['errormessage'] = $lang['opssomething'];
				break;
			}
		}
		header("Location: clientspending.php");
		break;
	}
	case "delete" : {
		$results = User::DeleteUser(array("uid" => $_REQUEST['uid'], "type" => "clientpending"));
		switch($results['response']) {
			case "userremoved" : {
				$_SESSION['goodmessage'] = $lang['userremoved'];
				break;
			}
			case "usernotexist" : {
				$_SESSION['errormessage'] = $lang['usernotexist'];
				break;
			}
			default : {
				$_SESSION['errormessage'] = $lang['opssomething'];
				break;
			}
		}
		header("Location: clientspending.php");
		break;
	}
	case "getnotes" : {
		$data = User::GetClient(array("uid" => $_GET['uid'], "type" => "clientspending"));
		$response = explode(PHP_EOL, $data['details']);
		$display->client = $response;
		$display->DisplayType("ajax");
		$display->Output("admin/clientspending/notes.tpl");
		exit();
		break;
	}
	case "getproof" : {
		$data = User::GetClient(array("uid" => $_GET['uid'], "type" => "clientspending"));
		$response = explode(PHP_EOL, $data['proof']);
		$display->client = $response;
		$display->DisplayType("ajax");
		$display->Output("admin/clientspending/proof.tpl");
		exit();
		break;

	}
	default : {
		$display->pagename = $lang['userpending'];
		$display->DisplayType("admin");
		$limit = 30;
		$total_rows = count(User::ListUsersPending(array("search" => $_REQUEST['search'])));
		$pages['totalpage'] = ceil($total_rows / $limit);
		if(!isset($_REQUEST['page']) || empty($_REQUEST['page'])) {
			$_REQUEST['page'] = 1;
		}
		$pages['current'] = $_REQUEST['page'];
		$display->clients = User::ListUsersPending(array("search" => $_REQUEST['search'], "limit" => "0,".$limit));
		$display->pages = $pages;
		$display->Output("admin/clientspending/clients-list.tpl");
		break;
	}
}