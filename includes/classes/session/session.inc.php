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


class session {
	protected $id = '';
	protected $alive = true;
	protected $sessiontable = 'sessions';

	function __construct() {
		$this->sessiontable = 'sessionsdata';

		$result = CSA::getInstance()->sqli->query("SHOW TABLES LIKE '{$this->sessiontable}';");
		//if ($result->num_rows > 0) {
		//	session_set_save_handler(
		//		array($this, 'openSession'), 
		//		array($this, 'closeSession'), 
		//		array($this, 'readSession'), 
		//		array($this, 'writeSession'), 
		//		array($this, 'destroySession'), 
		//		array($this, 'cleanSession')
		//	);
		//}
		//@session_write_close();
		register_shutdown_function('session_write_close');
		@session_start();
	}
	function __destruct() {
		if ($this->alive == true) {
			session_write_close();
			$this->alive = false;
		}
	}
	function delete() {
		if (ini_get('session.use_cookies')) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
		}
		destroySession();
		$this->alive = false;
	}
	function openSession() {
		return true;
	}
	function closeSession() {
		return true;
	}
	function readSession($sid) {
		$this->id = $sid;
		$query =  CSA::getInstance()->sqli->query("SELECT `data` FROM `'".$this->sessiontable."'` WHERE `id`='".CSA::getInstance()->sqli->real_escape_string($sid)."' LIMIT 1");
		if ($query->num_rows == 1) {
			$fields = $query->fetch_assoc();
			return $fields['data'];
		}
		return '';
	}
	function writeSession($sid, $data) {
		CSA::getInstance()->sqli->query("REPLACE INTO `'".$this->sessiontable."'` (`id`, `data`) VALUES ('".CSA::getInstance()->sqli->real_escape_string($sid)."', '".CSA::getInstance()->sqli->real_escape_string($data)."')");
		return CSA::getInstance()->sqli->affected_rows;
	}
	function destroySession($sid) {
		CSA::getInstance()->sqli->query("DELETE FROM `'".$this->sessiontable."'` WHERE `id`='". CSA::getInstance()->sqli->real_escape_string($sid)."'");
		$_SESSION = array();
		return CSA::getInstance()->sqli->affected_rows;
	}
	function cleanSession($expire) {
		CSA::getInstance()->sqli->query("DELETE FROM `'".$this->sessiontable."'` WHERE DATE_ADD(`last_accessed`, INTERVAL '".(int)$expire."' SECOND) < NOW()");
		return CSA::getInstance()->sqli->affected_rows;
	}
}
