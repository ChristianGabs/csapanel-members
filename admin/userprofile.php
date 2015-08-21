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

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if($_REQUEST['mode'] == "save") {
		if($_REQUEST['uid'] != $_SESSION['uid']) {
			$_SESSION['errormessage'] = $lang['notallowedtoeditotherprofiles'];
			header("Location: userprofile.php");
			exit();
		}
		$return = User::EditAdministrator(array(
			'email' => $_REQUEST['email'],
			'password' => $_REQUEST['password'],
			'uid' => $_REQUEST['uid'],
			'phone' => $_REQUEST['phone'],
			'firstname' => $_REQUEST['firstname'],
			'lastname' => $_REQUEST['lastname'],
			'address' => $_REQUEST['address'],
			'city' => $_REQUEST['city'],
			'state' => $_REQUEST['state'],
			'zipcode' => $_REQUEST['zipcode'],
			'country' => $_REQUEST['country'],
			'notes' => $_REQUEST['notes']
		));
		switch($return['response']) {
			case "success": {
				$_SESSION['goodmessage'] = $lang['usersaved'];
				header("Location: userprofile.php");
				exit();
				break;
			}
			case "emptyuid" : {
				$response = $lang['nouserspecified'];
				break;
			}
			case "emptyemail" : {
				$response = $lang['novalidemail'];
				break;
			}
			case "mainprivledges" : {
				$response = $lang['mainprivledges'];
				break;
			}
			case "invalidemail" : {
				$response = $lang['invalidemail'];
				break;
			}
			case "usernotexist" : {
				$response = $lang['usernotexist'];
				break;
			}
		}
		if(!empty($response)) {
			$display->errormessage = $response;
		}
	}
}
$display->pagename = $lang['myprofile'];
$query = CSA::getInstance()->sqli->query("SELECT * FROM `users` JOIN `users_profile` ON `users_profile`.`uid`=`users`.`uid` WHERE `users`.`uid`='{$_SESSION['uid']}' AND `userlevel`='1' LIMIT 1");
if($query->num_rows == 1) {
	$row = $query->fetch_assoc();
	$display->info = $row;
	$display->DisplayType("admin");
	$display->Output("admin/userprofile/userprofile.tpl");
} else {
	$_SESSION['errormessage'] = $lang['profilenotfound'];
	header("Location: index.php");
}