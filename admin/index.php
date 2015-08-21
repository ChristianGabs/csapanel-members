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
if(isset($_SESSSION['loggedin']) == "1" || isset($_SESSION['mainadmin']) == "1") {
	header("Location: dashboard.php");
}
if(isset($_REQUEST['action']))
	$action = $_REQUEST['action'];
if(isset($_REQUEST['password']))
	$password = $_REQUEST['password'];
if(isset($_REQUEST['email']))
	$email = $_REQUEST['email'];

if(isset($_GET['action']) && $_GET['action'] == "login") {
	$redirect = true;
} else {
	$redirect = false;
}
switch($_REQUEST['action']) {
	case "login" : {
		if(empty($email) || empty($password)) {
			echo '<div id="error">'.$lang['invalidlogin'].'</div>';
			exit();
		} else {
			$logincheck = User::Login($email, $password);
			switch($logincheck['response']) {
				case "accountsuspended" :{
					echo '<div id="error">'.$lang['accountsuspended'].'</div>';
					break;
				}
				case "invalidip" :{
					echo '<div id="error">'.$lang['invalidip'].'</div>';
					break;
				}
				case "invalidlogin" :{
					echo '<div id="error">'.$lang['invalidlogin'].'</div>';
					break;
				}
				case "success" :{
					$_SESSION['language'] = $_REQUEST['language'];
					if($_SESSION['userlevel'] == "1") {
						if($redirect == true) {
							header("Location: dashboard.php");
						}
						echo '<div id="good">dashboard.php</div>';
						exit();
					}
					break;
				}
				default : {
					echo '<div id="error">'.$lang['opssomething'].'</div>';
					break;
				}
			}
		}
		break;
	}
	case "forgotpassword" : {
		if(isset($email)) {
			$query = CSA::getInstance()->sqli->query("SELECT * FROM `users` JOIN `users_profile` ON `users`.`uid`=`users_profile`.`uid` WHERE `email`='{$email}' LIMIT 1;");
			if($query->num_rows == 1) {
				$row = $query->fetch_assoc();
				if($row['status'] != "1") {
					echo '<div id="error">'.$lang['accountsuspended'].'</div>';
					exit();
				} else {
					$results = Emails::SendMail(array("type" => "password", "uid" => $row['uid']));
					if($results['error'] == 0) {
						$_SESSION['goodmessage'] = $lang['recoveryemail'];
						echo '<div id="good">index.php</div>';
						exit();
					} else {
						echo '<div id="error">'.$lang['recoveryemailerror'].'</div>';
						exit();
					}
				}
				header("Location: index.php");
			} else {
				echo '<div id="error">'.$lang['noaccount'].'</div>';
				exit();
			}
		}
		$display->pagename = $lang['forgotpassword'];
		$display->tab = 1;
		$display->DisplayType("login");
		$display->Output("login/login.tpl");
	}
	case "logout" : {
		@session_start();
		$_SESSION = array();
		session_unset();
		session_destroy();
		if($settings['redirectlogout'] != "") {
			header("Location: ".CSA::getInstance()->settings['redirectlogout']);
			exit();
		} else {
			header("Location: index.php");
			exit();
		}
		break;
	}
	default : {
		$display->pagename = $lang['login'];
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
		$display->DisplayType("login");
		$display->Output("login/login.tpl");
		break;
	}
}