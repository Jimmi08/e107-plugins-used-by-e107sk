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


if (!defined('e107_INIT')) { exit; }
 
 
// use e107 tables
define("UN_TABLENAME_LINKS_CATEGORIES",  "unnuke_links_categories");
define("UN_TABLENAME_LINKS_EDITORIALS",  "unnuke_links_editorials");
define("UN_TABLENAME_LINKS_LINKS", 		 "unnuke_links_links");
define("UN_TABLENAME_LINKS_MODREQUEST",  "unnuke_links_modrequest");
define("UN_TABLENAME_LINKS_NEWLINK", 	 "unnuke_links_newlink");
define("UN_TABLENAME_LINKS_VOTEDATA", 	 "unnuke_links_votedata");

define("UN_TABLENAME_USERS_ALIAS",  "user AS user" );
define("UN_TABLEFIELD_USERNAME",  "user.user_name");   
define("UN_TABLEFIELD_USERNAME_ALIAS",  "user.user_name AS username");   
define("UN_TABLEFIELD_USEREMAIL", "user.user_email");   
define("UN_TTABLEFIELD_USEREMAIL_ALIAS", "user.user_email AS user_email");   
 
define("WEB_LINKS_FOLDER",  	'web_links');
define("WEB_LINKS_APP", 		e_PLUGIN.'web_links/');
define("WEB_LINKS_APP_ABS", 	e_PLUGIN_ABS.'web_links/');
 
$fronturl =  e107::url('web_links', 'main');
define("WEB_LINKS_FRONTFILE",   $fronturl ); 
 
//FIX THIS ! 
//only way how to get correct full path without e_url 
//$plugin_index = "{e_PLUGIN}".WEB_LINKS_FOLDER."/".WEB_LINKS_FRONTFILE;   
//with e_url
$plugin_index = "{e_BASE}".WEB_LINKS_FOLDER."/";
$plugin_index = e107::getParser()->replaceConstants($plugin_index,'full');
define("WEB_LINKS_INDEX",  	$plugin_index);
 
//rename after admin fix 
define("UN_FILENAME_ADMIN", 		e_PLUGIN_ABS.'web_links/admin/index.php');
define("UN_FILENAME_ADMIN_FOLDER",	e_PLUGIN.'web_links/admin/');
 
 