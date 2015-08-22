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


require_once("includes/csa-functions.php");
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	switch($_REQUEST['mode']) {
		case "reportadd" : {
			$return = User::AddClientPending(array(
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
				$_SESSION['errormessage'] = $response;
			}
			header("Location: index.php?mode=reportclient");
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
		$display->DisplayType("interaface");
		$display->Output("interface/clients/ajax-clientlist.tpl");
		break;
	}
	case "langro" : {
		setlocale(LC_ALL, 'ro_RO.UTF-8');
		$_SESSION['language'] = "romanian";
		header("Location: /");
		break;
	}
	case "langeng" : {
		setlocale(LC_ALL, 'en_US.UTF-8');
		$_SESSION['language'] = "english";
		header("Location: /");
		break;
	}
	case "getnotes" : {
		$data = User::GetClient(array("uid" => $_GET['uid']));
		$response = explode(PHP_EOL, $data['details']);
		$display->client = $response;
		$display->DisplayType("ajax");
		$display->Output("interface/clients/notes.tpl");
		exit();
		break;
	}
	case "getproof" : {
		$data = User::GetClient(array("uid" => $_GET['uid']));
		$response = explode(PHP_EOL, $data['proof']);
		$display->client = $response;
		$display->DisplayType("ajax");
		$display->Output("interface/clients/proof.tpl");
		exit();
		break;

	}
	case "getclientlist" : {
		$display->pagename = $lang['clientlist'];
		$display->DisplayType("interface");
		$limit = 30;
		$total_rows = count(User::ListUsers(array("search" => $_REQUEST['search'])));
		$pages['totalpage'] = ceil($total_rows / $limit);
		if(!isset($_REQUEST['page']) || empty($_REQUEST['page'])) {
			$_REQUEST['page'] = 1;
		}
		$pages['current'] = $_REQUEST['page'];
		$display->clients = User::ListUsers(array("search" => $_REQUEST['search'], "limit" => "0,".$limit));
		$display->linkprofil = CSA::getInstance()->settings['linkprofile'];
		$display->pages = $pages;
		$display->Output("interface/clients/clients-list.tpl");
		exit();
		break;
	}
	case "reportclient" : {
		$display->pagename = $lang['addreportclient'];
		$display->DisplayType("interface");
		$display->Output("interface/report/reportadd.tpl");
		exit();
		break;
	}
	default : {
		$display->pagename = $lang['home'];
		$display->linkprofil = CSA::getInstance()->settings['linkprofile'];
		$display->clients = User::GetClient(array());
		$display->DisplayType("interface");
		$display->Output("interface/index.tpl");
		break;
	}
}
