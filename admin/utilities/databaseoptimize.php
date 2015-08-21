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


if($_SESSION['mainadmin'] != "1") {
	if(!in_array("optimizedatabase", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: index.php");
		exit();
	}
	if($_REQUEST['mode'] == "optimize" && !in_array("optimizedatabase", $_SESSION['permissions'])) {
		$_SESSION['errormessage'] = $lang['nopermission'];
		header("Location: index.php");
		exit();
	}

}
switch($_REQUEST['mode']) {
	case "optimize" : {
		$query = CSA::getInstance()->sqli->query("SHOW TABLES;");
		while($data = $query->fetch_assoc()) {
			$arrayvalue = array_values($data);
			$query2 = CSA::getInstance()->sqli->query('OPTIMIZE TABLE '.$arrayvalue[0]);
			$analysis[] = $query2->fetch_assoc();
		}
		unset($query);
		unset($query2);

		$display->analysis = $analysis;
		$_SESSION['goodmessage'] = $lang['optimizedone'];
		header("Location: utility.php?module=databaseoptimize");
		break;
	}
	default : {
		$display->pagename = $lang['optimize'];
		$display->DisplayType("admin");
		$query = CSA::getInstance()->sqli->query("SHOW TABLES;");
		while($data = $query->fetch_assoc()) {
			$arrayvalue = array_values($data);
			$query2 = CSA::getInstance()->sqli->query('ANALYZE TABLE '.$arrayvalue[0]);
			$analysis[] = $query2->fetch_assoc();
		}
		$display->analysis = $analysis;

		$display->Output("admin/utilities/databaseoptimize/optimize.tpl");
		break;
	}
}