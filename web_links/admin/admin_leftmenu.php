<?php
if (!defined('e107_INIT')) { exit; }

require_once("../../../class2.php");


e107::lan("web_links" , "lang_admin");

//load constants for front+admin
require_once(e_PLUGIN.'web_links/web_links_defines.php');


class leftmenu_adminArea extends e_admin_dispatcher
{
 
	protected $modes = array( 	

		'main'	=> array(
			'controller' 	=> 'links_prefs_ui',
			'path' 			=> null,
			'ui' 			=> 'links_prefs_form_ui',
			'uipath' 		=> null
		),

	);

	protected $adminMenu = array( 
		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P'),	
	);      
	
	protected $adminMenuAliases = array( 			
	);	
	
	protected $menuTitle = _WEBLINKS;
 
}