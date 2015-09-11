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
if(defined("DEMO")) {
	if($_SERVER['REQUEST_METHOD'] == 'POST' || in_array($_REQUEST['mode'], array("delete", "delsubuser", "loginas"))) {
		$_SESSION['errormessage'] = "This feature is disabled in demo mode";
		header("Location: dashboard.php");
		exit();
	}
}
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
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	switch($_REQUEST['mode']) {
		case "add" : {
			$return = User::AddClient(array(
				'email' => $_REQUEST['email'],
				'userid' => $_REQUEST['userid'],
				'status' => $_REQUEST['status'],
				'realname' => $_REQUEST['realname'],
				'proof' => $_REQUEST['proof'],
				'phone' => $_REQUEST['phone'],
				'notes' => $_REQUEST['notes']
			));
			switch($return['response']) {
				case "useradded" : {
					$_SESSION['goodmessage'] = $lang['useradded'];
					break;
				}
				case "novalidemail" : {
					$response = $lang['novalidemail'];
					break;
				}
				case "invalidemail" : {
					$response = $lang['invalidemail'];
					break;
				}
				case "nouserid" : {
					$response = $lang['nouserid'];
					break;
				}
				case "proofnotdefined" : {
					$response = $lang['proofnotdefined'];
					break;
				}
				default : {
					$response = $lang['opssomething'];
					break;
				}
			}
			if(!empty($response)) {
				$display->info = $_REQUEST;
				$_SESSION['errormessage'] = $response;
			}
			header("Location: clients.php");
			exit();
			break;
		}
		case "edit" : {
			$return = User::EditClient(array(
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
			header("Location: clients.php?mode=summary&uid={$_REQUEST['uid']}");
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
		$total_rows = count(User::ListUsers(array("search" => $_REQUEST['search'])));
		$pages['totalpage'] = ceil($total_rows / $limit);
		if(!isset($_REQUEST['page']) || empty($_REQUEST['page'])) {
			$_REQUEST['page'] = 0;
		} else {
			$_REQUEST['page'] = $_REQUEST['page'] - 1;
		}
		$pages['current'] = $_REQUEST['page'] + 1;
		$display->clients = User::ListUsers(array("search" => $_REQUEST['search'], "limit" => ($_REQUEST['page'] * $limit).",".$limit));
		
		$display->pages = $pages;
		$display->DisplayType("ajax");
		$display->Output("admin/clients/ajax-clientlist.tpl");
		break;
	}
	case "add" : {
		$display->pagename = $lang['addclient'];
		$display->DisplayType("admin");
		$display->Output("admin/clients/clients-add.tpl");
		break;
	}
	case "delete" : {
		$results = User::DeleteUser(array("uid" => $_REQUEST['uid'], "type" => "client"));
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
		header("Location: clients.php");
		break;
	}
	case "getnotes" : {
		$data = User::GetClient(array("uid" => $_GET['uid']));
		$response = explode(PHP_EOL, $data['details']);
		$display->client = $response;
		$display->DisplayType("ajax");
		$display->Output("admin/clients/notes.tpl");
		exit();
		break;
	}
	case "getproof" : {
		$data = User::GetClient(array("uid" => $_GET['uid']));
		$response = explode(PHP_EOL, $data['proof']);
		$display->client = $response;
		$display->DisplayType("ajax");
		$display->Output("admin/clients/proof.tpl");
		exit();
		break;

	}
	case "summary" : {
		$display->pagename = $lang['clientsummary'];
		
		$info = User::GetClientInfo($_REQUEST['uid']);
		if($info && count($info) != 0) {
			$display->DisplayType("admin");
			$display->info = $info;

			$display->Output("admin/clients/clients-summary.tpl");
		} else {
			$_SESSION['errormessage'] = $lang['nouserfound'];
			header("Location: clients.php");
		}
		break;
	}
	default : {
		$display->pagename = $lang['clients'];
		$display->DisplayType("admin");
		$limit = 30;
		$total_rows = count(User::ListUsers(array("search" => $_REQUEST['search'])));
		$pages['totalpage'] = ceil($total_rows / $limit);
		if(!isset($_REQUEST['page']) || empty($_REQUEST['page'])) {
			$_REQUEST['page'] = 1;
		}
		$pages['current'] = $_REQUEST['page'];
		$display->clients = User::ListUsers(array("search" => $_REQUEST['search'], "limit" => "0,".$limit));
		$display->pages = $pages;
		$display->Output("admin/clients/clients-list.tpl");
		break;
	}
}