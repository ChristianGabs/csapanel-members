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


class User {
	static function ListAdministrators() {
		$admins = array();
		$x = 0;
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `users` WHERE userlevel='1';");
		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				if ($row['mainadmin'] == "1") {
					$row['permission'] = "*";
				} else {
					$permission = unserialize($row['permission']);
					foreach ($permission as $f) {
						$permissions .= $permission;
					}
					$row['permission'] = $permissions;
				}
				if (empty($row['permission'])) {
					$row['permission'] = $lang['noneset'];
				}
				$admins[$x] = $row;
				$x++;
			}
		}
		return $admins;
	}
	static function GetAdministratorInfo($uid) {
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `users` WHERE `uid`='{$uid}' AND `userlevel`='1' LIMIT 1;");
		if ($query->num_rows == 1) {
			$row = $query->fetch_assoc();
			unset($row['password']);
			unset($row['session']);
			$perms = unserialize($row['permission']);
			if (!is_array($perms)) {
				$perms = array();
			}
			$row['permissions'] = $perms;
			return $row;
		}
		return array();
	}
	public static function AddAdmininistrator($data) {
		if (empty($data['email'])) {
			return array("response" => "novalidemail");
		}
		if (empty($data['password'])) {
			$data['password'] = Strings::createRandomPassword();
		}
		if (self::CheckNewUserValid($data['email']) == false) {
			return array('response' => "invalidemail");
		}
		if ($data['mainadmin'] == "0") {
			$permissions = $data['perm'];
			if (is_array($permissions)) {
				foreach ($permissions as $key) {
					if ($key) {
						$perms[] = $key;
						continue;
					}
				}
			}
			$perms = serialize($data['perm']);
		} else {
			$perms = "";
		}
		$queryadm = CSA::getInstance()->sqli->query("INSERT INTO `users` SET `email`='{$data['email']}', `password`= MD5('{$data['password']})', `mainadmin`='{$data['mainadmin']}', `userlevel`='1', `permission`='{$perms}', `status`='{$data['status']}', `allowedips`='{$data['allowedips']}';");
		$uid = CSA::getInstance()->sqli->insert_id;
		EventLog::Log("addadministrator", $uid, $_SESSION['uid']);
		return array("response" => "success");
	}
	public static function EditAdministrator($data) {
		if (empty($data['uid'])) {
			return array("response" => "emptyuid");
		}
		if (empty($data['email'])) {
			return array("response" => "emptyemail");
		}
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `users` WHERE `uid`='{$data['uid']}' AND `userlevel`='1' LIMIT 1;");
		if ($query->num_rows == 1) {
			$row = $query->fetch_assoc();
			if (!isset($data['mainadmin'])) {
				$data['mainadmin'] = $row['mainadmin'];
			}
			if (!isset($data['perm'])) {
				$data['perm'] = $row['permission'];
			}
			if (!isset($data['status'])) {
				$data['status'] = $row['status'];
			}
			if (!isset($data['allowedips'])) {
				$data['allowedips'] = $row['allowedips'];
			}
			if ($data['mainadmin'] == '0' && $row['mainadmin'] == "1") {
				$querymain = CSA::getInstance()->sqli->query("SELECT `mainadmin` FROM `users` WHERE `mainadmin`='1' AND `uid`!='{$data['uid']}' LIMIT 1;");
				if ($querymain->num_rows == 0) {
					return array("response" => "mainprivledges");
				}
			}
			if ($data['email'] != $row['email']) {
				if (self::CheckNewUserValid($data['email'], $row['email']) == false) {
					return array("response" => "invalidemail");
				}
			}
		} else {
			return array("response" => "usernotexist");
		}
		if ($data['mainadmin'] == "0") {
			$permissions = $data['perm'];
			if (is_array($permissions)) {
				foreach ($permissions as $key) {
					if ($key) {
						$perms[] = $key;
						continue;
					}
				}
			}
			$perms = serialize($data['perm']);
		} else {
			$perms = "";
		}
		if (!empty($data['password'])) {
			$EncPass = ", `password`= MD5('{$data['password']}')";
		}
		CSA::getInstance()->sqli->query("UPDATE `users` SET `email`='{$data['email']}', `mainadmin`='{$data['mainadmin']}', `permission`='{$perms}', `status`='{$data['status']}', `allowedips`='{$data['allowedips']}' {$EncPass} WHERE `uid`='{$data['uid']}' LIMIT 1;");
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `users_profile` WHERE `uid`={$data['uid']};");
		if($query->num_rows == 0) {
			CSA::getInstance()->sqli->query("INSERT INTO `users_profile` SET `uid`='{$data['uid']}', `phone`='{$data['phone']}',`address`='{$data['address']}', `city`='{$data['city']}', `firstname`='{$data['firstname']}', `lastname`='{$data['lastname']}', `state`='{$data['state']}', `zipcode`='{$data['zipcode']}', `country`='{$data['country']}', `notes`='{$data['notes']}';");
		} else {
			CSA::getInstance()->sqli->query("UPDATE `users_profile` SET `phone`='{$data['phone']}', `firstname`='{$data['firstname']}', `lastname`='{$data['lastname']}', `address`='{$data['address']}', `city`='{$data['city']}', `state`='{$data['state']}', `zipcode`='{$data['zipcode']}', `country`='{$data['country']}', `notes`='{$data['notes']}' WHERE `uid`='{$data['uid']}' LIMIT 1;");
		}
		EventLog::Log("editadministrator", $data['uid'], $_SESSION['uid']);
		return array("response" => "success");
	}
	public static function DeleteAdministrator($uid) {
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `users` WHERE `uid`='{$uid}' AND `userlevel`='1' LIMIT 1;");
		if ($query->num_rows == 1) {
			$row = $query->fetch_assoc();
			if ($row['mainadmin'] == "0") {
				return array("response" => "errormainadmin");
			}
			CSA::getInstance()->sqli->query("DELETE FROM `events` WHERE (`userid`='{$uid}' OR `runbyid`='$uid');");
			EventLog::Log("deleteadministrator", $uid, $_SESSION['uid']);
			CSA::getInstance()->sqli->query("DELETE FROM `users` WHERE `uid`='{$uid}' LIMIT 1;");
			return array("response" => "success");
		}
		return array("response" => "nouserdatabase");
	}
	public static function CheckNewUserValid($email, $existing = '') {
		if (!preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email)) {
			return false;
		}
		if (empty($existing)) {
			$query = CSA::getInstance()->sqli->query("SELECT `email` FROM `users` WHERE `email`='{$email}' LIMIT 1;");
		} else {
			$query = CSA::getInstance()->sqli->query("SELECT `email` FROM `users` WHERE `email`='{$email}' AND `email`!='{$existing}' LIMIT 1;");
		}
		if ($query->num_rows == 1) {
			return false;
		}
		return true;
	}
	static function UIDToUser($data, $type = 'user') {
		if (($data == "-1" || $data == "") || $data == 0) {
			return "System";
		}
		if ($type == "user") {
			$query = CSA::getInstance()->sqli->query("SELECT `email` FROM `clients` WHERE `uid`='{$data}' LIMIT 1;");
			if ($query->num_rows == 1) {
				$row = $query->fetch_assoc();
				return $row['email'];
			}
		}
		if($type == 'administrator') {
			$query = CSA::getInstance()->sqli->query("SELECT `email` FROM `users` WHERE `uid`='{$data}' LIMIT 1;");
			if ($query->num_rows == 1) {
				$row = $query->fetch_assoc();
				return $row['email'];
			}
		}
		return "Unknown";
	}
	
	//----------------------- USERS -------------------------------------------
	static function ListUsers($data) {
		if(isset($data['search'])) {
			$search = " AND `email` LIKE '%{$data['search']}%' OR `userid` LIKE '%{$data['search']}%' OR `realname` LIKE '%{$data['search']}%'";
		}
		if(isset($data['limit'])) {
			$limit = " LIMIT {$data['limit']}";
		}
		$clients = array();
		$x = 0;
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients` WHERE `status`!='2'  {$search}{$limit};");
		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$clients[$x] = $row;
				$x++;
			}
		}
		return $clients;
	}
	public static function AddClient($data) {
		if (empty($data['email'])) {
			return array("response" => "novalidemail");
		} elseif(empty($data['userid'])) {
			return array("response" => "nouserid");
		} elseif (empty($data['proof'])) {
			return array("response" => "proofnotdefined");
		}
		if (self::CheckNewUserValid($data['email']) == false) {
			return array("response" => "invalidemail");
		}
		$time = time();
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients` WHERE `email`='{$data['email']}' OR `userid`='{$data['userid']}';");
		if($query->num_rows > 0) {
			return array("response" => "clientexist");
		} else {
			CSA::getInstance()->sqli->query("INSERT INTO `clients` SET `email`='{$data['email']}', `userid`='{$data['userid']}', `realname`='{$data['realname']}', `phone`='{$data['phone']}', `proof`='{$data['proof']}', `details`='{$data['notes']}', `status`='{$data['status']}', `time`='{$time}';");
			$uid = CSA::getInstance()->sqli->insert_id;
		}
		EventLog::Log("adduser", $uid, $_SESSION['uid']);
		return array("response" => "useradded", "uid" => $uid);
	}
	public static function EditClient($data) {
		if (empty($data['uid'])) {
			return array("response" => "nouserspecified");
		}
		if (isset($data['email']) && empty($data['email'])) {
			return array("response" => "novalidemail");
		}
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients` WHERE `uid`='{$data['uid']}' LIMIT 1;");
		if ($query->num_rows == 1) {
			$row = $query->fetch_assoc();
			if (!isset($data['email'])) {
				$data['email'] = $row['email'];
			}
			if (!isset($data['userid'])) {
				$data['userid'] = $row['userid'];
			}
			if (!isset($data['realname'])) {
				$data['realname'] = $row['realname'];
			}
			if (!isset($data['phone'])) {
				$data['phone'] = $row['phone'];
			}
			if (!isset($data['proof'])) {
				$data['proof'] = $row['proof'];
			}
			if (!isset($data['status'])) {
				$data['status'] = $row['status'];
			}
			if (!isset($data['notes'])) {
				$data['notes'] = $row['state'];
			}
			if ($data['email'] != $row['email']) {
				if (self::CheckNewUserValid($data['email'], $row['email']) == false) {
					return array("response" => "invalidemail");
				}
			}
		} else {
			return array("response" => "usernotexist");
		}
		CSA::getInstance()->sqli->query("UPDATE `clients` SET `email`='{$data['email']}', `userid`='{$data['userid']}', `realname`='{$data['realname']}', `phone`='{$data['phone']}', `proof`='{$data['proof']}', `details`='{$data['notes']}', `status`='{$data['status']}' WHERE `uid`='{$data['uid']}' LIMIT 1;");
		EventLog::Log('edituser', $data['uid'], $_SESSION['uid']);
		return array("response" => "success");
	}
	public static function DeleteUser($data) {
		if($data['type'] == "client") {
			$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients` WHERE `uid`='{$data['uid']}' LIMIT 1;");
			if ($query->num_rows == 1) {
				$row = $query->fetch_assoc();
				EventLog::Log("deleteuser", $uid, $_SESSION['uid']);
				CSA::getInstance()->sqli->query("DELETE FROM `clients` WHERE `uid`='{$data['uid']}' LIMIT 1;");
				return array("response" => "userremoved");
			}
		} elseif($data['type'] == "clientpending") {
			$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients_pending` WHERE `uid`='{$data['uid']}' LIMIT 1;");
			if ($query->num_rows == 1) {
				$row = $query->fetch_assoc();
				EventLog::Log("deleteuser", $uid, $_SESSION['uid']);
				CSA::getInstance()->sqli->query("DELETE FROM `clients_pending` WHERE `uid`='{$data['uid']}' LIMIT 1;");
				return array("response" => "userremoved");
			}
		}
		return array("response" => "usernotexist");
	}
	static function ListClients($data) {
		switch($data['type']) {
			case "usertrust" : {
				$query = CSA::getInstance()->sqli->query("SELECT COUNT(*) as `usertrust` FROM `clients` WHERE `status`='0';");
				return $query->fetch_assoc();
				break;
			}
			case "untrustworthy" : {
				$query = CSA::getInstance()->sqli->query("SELECT COUNT(*) as `untrustworthy` FROM `clients` WHERE `status`='1';");
				return $query->fetch_assoc();
				break;
			}
			case "userpending" : {
				$query = CSA::getInstance()->sqli->query("SELECT COUNT(*) as `userpending` FROM `clients_pending`;");
				return $query->fetch_assoc();
				break;
			}
			default : {
				return "0";
				break;
			}
		}
		return false;
	}
	public static function GetClientInfo($uid) {
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients` WHERE `uid`='{$uid}' LIMIT 1;");
		if ($query->num_rows == 1) {
			return $query->fetch_assoc();
			
		}
		return array();
	}
	//----------------------- USERS -------------------------------------------
	
	//----------------------- USERS PENDING -----------------------------------
	static function ListUsersPending($data) {
		if(isset($data['search'])) {
			$search = " AND `email` LIKE '%{$data['search']}%' OR `userid` LIKE '%{$data['search']}%' OR `realname` LIKE '%{$data['search']}%'";
		}
		if(isset($data['limit'])) {
			$limit = " LIMIT {$data['limit']}";
		}
		$clients = array();
		$x = 0;
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients_pending` WHERE `status`!='2'  {$search}{$limit};");
		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$clients[$x] = $row;
				$x++;
			}
		}
		return $clients;
	}
	static function AproveUser($data) {
		if(empty($data['uid'])) {
			return array("response" => "nouserspecified");
		}
		$time = time();
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients_pending` WHERE `uid`='{$data['uid']}' LIMIT 1;");
		if($query->num_rows == 1) {
			$row = $query->fetch_assoc();
			CSA::getInstance()->sqli->query("INSERT INTO `clients` SET `email`='{$row['email']}', `userid`='{$row['userid']}', `realname`='{$row['realname']}', `phone`='{$row['phone']}', `proof`='{$row['proof']}', `details`='{$row['notes']}', `status`='{$row['status']}', `time`='{$time}';");
			$uid = CSA::getInstance()->sqli->insert_id;
			CSA::getInstance()->sqli->query("DELETE FROM `clients_pending` WHERE `uid`='{$data['uid']}' LIMIT 1;");
			EventLog::Log("approveuser", $uid, $_SESSION['uid']);
			return array("response" => "userapprove");
		} else {
			return array("response" => "usernotexist");
		}
	}
	//----------------------- USERS PENDING -----------------------------------
	
	//----------------------- Interface -----------------------------------
	static function GetClient($data) {
		$clients = array();
		if(isset($data['uid'])) {
			$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients` WHERE `uid`='{$data['uid']}' LIMIT 1;");
			$clients = $query->fetch_assoc();
		} else {
			$x = 0;
			$query = CSA::getInstance()->sqli->query("SELECT * FROM `clients` ORDER BY `time` DESC LIMIT 10;");
			if ($query->num_rows > 0) {
				while ($row = $query->fetch_assoc()) {
					$clients[$x] = $row;
					$x++;
				}
			}
		}
		return $clients;
	}
	//----------------------- Interface -----------------------------------
	
	public static function Login($email, $password) {
		$query = CSA::getInstance()->sqli->query("SELECT * FROM `users` WHERE `email`='{$email}' AND `password`=MD5('{$password}') LIMIT 1;");
		if ($query->num_rows == 1) {
			$row = $query->fetch_assoc();
			if ($row['status'] == 0) {
				return array("response" => "accountsuspended");
			}
			$row['allowedips'] = trim($row['allowedips']);
			if (!empty($row['allowedips'])) {
				$row['allowedips'] = explode('', $row['allowedips']);
				if (is_array($row['allowedips']) && count($row['allowedips'])> 0) {
					if (!in_array(getIP(), $row['allowedips'])) {
						return array("response" => "invalidip");
					}
				}
			}
			$_SESSION['loggedin'] = "1";
			$_SESSION['uid'] = $row['uid'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['userlevel'] = $row['userlevel'];
			$_SESSION['billingid'] = $row['billingid'];
			$_SESSION['permissions'] = unserialize($row['permission']);
			$_SESSION['mainadmin'] = $row['mainadmin'];
			if ($_SESSION['mainadmin'] == "1") {
				$_SESSION['permissions'] = array("addclient","editclient","deleteclient","manageclient","optimizedatabase","editadmin","addadmin","deleteadmin","generalsettings");
			}
			$sesionID = md5(session_id());
			CSA::getInstance()->sqli->query("UPDATE `users` SET `session`='{$sesionID}' WHERE `uid`='{$row['uid']}' LIMIT 1");
			CSA::getInstance()->sqli->query("UPDATE `users` SET `lastip`='{$_SERVER['REMOTE_ADDR']}' WHERE `uid`='{$row['uid']}' LIMIT 1;");
			EventLog::Log("login", $email, $_SESSION['uid']);
			return array("response" => "success");
		}
		return array("response" => "invalidlogin");
	}
}