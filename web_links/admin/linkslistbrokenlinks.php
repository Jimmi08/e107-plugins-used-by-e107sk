<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
*/

/**
  * UNITED-NUKE CMS: Just Manage!
  * http://united-nuke.openland.cz/
  * http://united-nuke.openland.cz/forums/
  *
  * 2002 - 2005, (c) Jiri Stavinoha
  * http://united-nuke.openland.cz/weblog/
  *
  * Portions of this software are based on PHP-Nuke
  * http://phpnuke.org - 2002, (c) Francisco Burzi
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
**/

require_once('../../../class2.php');
if (!getperms('P')) {
	e107::redirect('admin');
	exit;
}
 
require_once("admin_leftmenu.php");

new leftmenu_adminArea();
require_once(e_ADMIN."header.php"); 

$ns = e107::getRender();
$tp = e107::getParser();
$frm = e107::getForm();
$sql = e107::getDb();


$ns->tablerender($caption, $text);

require_once(e_ADMIN."footer.php");
exit;

?>