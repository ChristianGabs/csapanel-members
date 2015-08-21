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
if(!isset($_REQUEST['module']) || empty($_REQUEST['module'])) {
	$_SESSION['errormessage'] = $lang['noutilspecified'];
	header("Location: index.php");
	exit();
}
if(!file_exists("utilities/".$_REQUEST['module'].".php")) {
	$_SESSION['errormessage'] = $lang['utilnotexist'];
	header("Location: index.php");
	exit();
} else {
	require("utilities/".$_REQUEST['module'].".php");
}