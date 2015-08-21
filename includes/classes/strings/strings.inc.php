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


class Strings {
	function BaseSetType($type){
		switch($type) {
			case "copyrightadmin" : {
				$string = "<div class='copyright'><i class='fa fa-copyright'></i> %d <a href='http://www.csa-panel.ro/' target='_blank'>CSA-Panel</a> All right reserved.</div>";
				return $string;
				break;
			}
			case "copyrightinterface" : {
				$string = "<p><i class='fa fa-copyright'></i> %d Control System Administrator Panel - <a href='http://www.csa-panel.ro/' target='_blank'>CSA-Panel</a> - All right reserved.</p>";
				return $string;
				break;
			}
			case "pulltop" : {
				$string = "<a class='btn btn-primary btn-flat pull-right' href='#top'><i class='fa fa-arrow-circle-o-up'></i> Top</a>";
				return $string;
				break;
			}
			default : {
				return false;
				break;
			}
		}
	}
	function createRandomPassword() {
		$alphabet = "abcdefghijk!lmnopqrstuwx!yzAB?CDEFGHIJKLMNO!PQRSTUWXYZ012!3456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 13; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	function createRandomChars() {
		$alphabet = "abcdefghijkmnopqrstuvwxyz023456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}	
	function createRandomDatabase() {
		$alphabet = "abcdefghijkmnopqrstuvwxyz";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 6; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	static function filter($var, $type = 'string', $filter = null) {
		if (!extension_loaded('filter')) {
			return $var;
		} elseif ($type == 'string') {
			return filter_var($var, FILTER_SANITIZE_STRING);
		} elseif ($type == 'special') {
			return filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
		} elseif ($type == 'int') {
			return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
		} elseif ($type == 'raw') {
			return filter_var($var, FILTER_UNSAFE_RAW);
		}
	}
}