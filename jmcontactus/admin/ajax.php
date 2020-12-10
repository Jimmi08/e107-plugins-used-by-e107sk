<?php
 
require_once('../../../class2.php');
if (!defined('e107_INIT')) { exit; }
 
e107::lan("jmcontactus" , e_LANGUAGE);
 
 
require_once(e_PLUGIN."jmcontactus/lib/functions.php");
 
if ($_POST['func'] == 'ORDERitems') {	
    
	$items = explode("&listItem[]=", "&".$_POST['itemorder']);
	foreach ($items as $position => $item) {
		if ($position) {
			orderitem($position,$item);
		}
	}
	echo CUP_FORM_REORDERCONF;
	die;
}

if ($_POST['func'] == 'DELETEitem') {
	deleteitem($_POST['sID']);
	echo CUP_FORM_DELETECONF;
	die;
}

if ($_POST['func'] == 'DELETEmessage') {
	deletemessage($_POST['sID']);
	echo CUP_MESSAGE_DELETECONF;
	die;
}
