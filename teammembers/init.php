<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 efiction Plugin
 *
*/

 
//using global path for easier copying later

defined('TM_PLUGIN_PATH') 	? null : define('TM_PLUGIN_PATH', e_PLUGIN.'teammembers/');
defined('TM_INCLUDES_PATH') ? null : define('TM_INCLUDES_PATH', TM_PLUGIN_PATH.'includes/');
defined('TM_CLASSES_PATH') 	? null : define('TM_CLASSES_PATH', TM_PLUGIN_PATH.'classes/');
 
//require_once(INCLUDES_PATH."functions.php");
require_once(TM_INCLUDES_PATH."paginate.php");

if(!class_exists('TeamMembers')) {
	require_once(TM_CLASSES_PATH."teammembers_class.php");
}
 
e107::lan("teammembers");
 
//not needed here, it's for efiction plugin
//require_once("includes/corefunctions.php");


?>