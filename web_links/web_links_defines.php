<?php
if (!defined('e107_INIT')) { exit; }
 
//Way how to use the same database
$prefix = '';
$user_prefix =  '';

if(e107::getPlugConfig('web_links')->getPref('use_unnuke')) {
   $prefix = varset(e107::getPlugConfig('web_links')->getPref('unnuke_prefix'), '');
   $user_prefix = varset(e107::getPlugConfig('web_links')->getPref('unnuke_user_prefix'), '');
}


// example e107_unnuke_links_links  $prefix = unnuke_,  + # = e107 table 
// e107_ has prefix always with _ 

define("UN_TABLENAME_LINKS_CATEGORIES", $prefix."links_categories");
define("UN_TABLENAME_LINKS_CATEGORIES", $prefix."links_categories");
define("UN_TABLENAME_LINKS_EDITORIALS", $prefix."links_editorials");
define("UN_TABLENAME_LINKS_LINKS", 		$prefix."links_links");
define("UN_TABLENAME_LINKS_MODREQUEST", $prefix."links_modrequest");
define("UN_TABLENAME_LINKS_NEWLINK", 	$prefix."links_newlink");
define("UN_TABLENAME_LINKS_VOTEDATA", 	$prefix."links_votedata");

//use e107 users
define("UN_TABLENAME_USERS", 	$user_prefix."user AS user" );

define ("UN_TABLENAME_USERNAME",  "user.user_name");  // Do not change the aliasing (the "author." part)!
define ("UN_TABLENAME_USERNAME_ALIAS",  "user.user_name AS username");  // Do not change the aliasing (the "author." part)!
define ("UN_TABLENAME_USEREMAIL", "user.user_email");  // Do not change the aliasing (the "author." part)!
define ("UN_TABLENAME_USEREMAIL_ALIAS", "user.user_email AS user_email");  // Do not change the aliasing (the "author." part)!

define("WEB_LINKS_APP", 		e_PLUGIN.'web_links/');
define("WEB_LINKS_APP_ABS", 	e_PLUGIN_ABS.'web_links/');

$fronturl =  e107::url('web_links', 'main');
define("WEB_LINKS_FRONTFILE",   $fronturl );         
define("WEB_LINKS_FOLDER",  	'web_links');

//only way how to get correct full path without e_url 
//$plugin_index = "{e_PLUGIN}".WEB_LINKS_FOLDER."/".WEB_LINKS_FRONTFILE;   
//with e_url
$plugin_index = "{e_BASE}".WEB_LINKS_FOLDER."/";
$plugin_index = e107::getParser()->replaceConstants($plugin_index,'full');

define("WEB_LINKS_INDEX",  	$plugin_index);
 
define("UN_FILENAME_ADMIN", 		e_PLUGIN_ABS.'web_links/admin/index.php');
define("UN_FILENAME_ADMIN_FOLDER",	e_PLUGIN.'web_links/admin/');
 
 