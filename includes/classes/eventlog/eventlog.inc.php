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


class Eventlog {
	function Log($type = '', $uid = '', $byuid = '') {
		global $lang;
		$event = array();
		switch($type) {
			case "login":
			{
				if (CSA::getInstance()->settings['eventlog_login'] != '1') {
					return null;
				}
				$event['message'] = $lang['eventvars']['login'];
				$event['uid'] = $uid;
				$event['runby'] = $byuid;
				$event['type'] = 'login';

				break;
			}
			case "addadministrator":
			{
				if (CSA::getInstance()->settings['eventlog_addadministrator'] != '1') {
					return null;
				}
				$event['message'] = $lang['eventvars']['addedadmin'];
				$event['uid'] = $uid;
				$event['runby'] = $byuid;
				$event['type'] = 'usermgmt';
				break;
			}
			case "deleteadministrator":
			{
				if (CSA::getInstance()->settings['eventlog_deleteadministrator'] != '1') {
					return null;
				}
				$event['message'] = $lang['eventvars']['deleteadmin'];
				$event['uid'] = $uid;
				$event['runby'] = $byuid;
				$event['type'] = 'usermgmt';
				break;
			}
			case "editadministrator":
			{
				if (CSA::getInstance()->settings['eventlog_editadministrator'] != '1') {
					return null;
				}
				$event['message'] = $lang['eventvars']['editedadmin'];
				$event['uid'] = $uid;
				$event['runby'] = $byuid;
				$event['type'] = 'usermgmt';
				break;
			}
			case "adduser":
			{
				if (CSA::getInstance()->settings['eventlog_adduser'] != '1') {
					return null;
				}
				$event['message'] = $lang['eventvars']['addeduser'];
				$event['uid'] = $uid;
				$event['runby'] = $byuid;
				$event['type'] = 'usermgmt';
				break;
			}
			case "edituser":
			{
				if (CSA::getInstance()->settings['eventlog_edituser'] != '1') {
					return null;
				}
				$event['message'] = $lang['eventvars']['editeduser'];
				$event['uid'] = $uid;
				$event['runby'] = $byuid;
				$event['type'] = 'usermgmt';
				break;
			}
			case "deleteuser":
			{
				if (CSA::getInstance()->settings['eventlog_deleteuser'] != '1') {
					return null;
				}
				$event['message'] = $lang['eventvars']['deleteuser'];
				$event['uid'] = $uid;
				$event['runby'] = $byuid;
				$event['type'] = 'usermgmt';
				break;
			}
			case "approveuser":
			{
				if (CSA::getInstance()->settings['eventlog_approveuser'] != '1') {
					return null;
				}
				$event['message'] = $lang['eventvars']['approveuser'];
				$event['uid'] = $uid;
				$event['runby'] = $byuid;
				$event['type'] = 'usermgmt';
				break;
			}
		}
		if (!empty($event)) {
			self::Add($event);
		}
	}
	function Add($data) {
		if (!empty($data['message'])) {
			$query = CSA::getInstance()->sqli->query("SELECT `email` FROM `users` WHERE `uid`='{$data['uid']}' LIMIT 1;");
			if ($query->num_rows == 1) {
				$data['message'] = str_replace('{username}', $row['email'], $data['message']);
			}
			$data['message'] = CSA::getInstance()->sqli->real_escape_string($data['message']);
			if (!isset($data['uid'])) {
				$data['uid'] = '';
			}
			if (!isset($data['runby'])) {
				$data['runby'] = '';
			}
			if (!isset($data['type'])) {
				$data['type'] = '';
			}
			$time = time();
			CSA::getInstance()->sqli->query("INSERT INTO `events` SET `message`='{$data['message']}', `userid`='{$data['uid']}', `runbyid`='{$data['runby']}', `type`='{$data['type']}', `time`='{$time}';");
		}
	}
}