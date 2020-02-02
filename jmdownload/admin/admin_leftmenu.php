<?php
if (!defined('e107_INIT')) { exit; }

require_once("../../../class2.php");
 
e107::lan("jmdownload" , "lan_front");
e107::lan("jmdownload" , "lan_admin");
e107::lan("jmdownload" , "lan_menu");

 
class leftmenu_adminArea extends e_admin_dispatcher
{
		 
	
	protected $modes = array(	
	
		'admin_download'	=> array(
			'controller' 	=> 'download_ui',
			'path' 			=> null,
			'ui' 			=> 'download_form_ui',
			'uipath' 		=> null
		),

		'admin_downloadmenu'	=> array(
			'controller' 	=> 'download_ui',
			'path' 			=> null,
			'ui' 			=> 'download_form_ui',
			'uipath' 		=> null
		),
		

	);

	protected $adminMenu = array(
   		// 'main/prefs' 		=> array('caption'=> 'Additional Prefs', 'perm' => 'P', 'url'=>'admin_config.php'),
    	'admin_download/list' 			=> array('caption'=> 'Download Overview', 'perm' => 'P', 'url'=>"admin_download.php"), 
    	'admin_downloadmenu/prefs' 		=> array('caption'=> LAN_JMD_LATEST_DOWNLOADS_23, 'perm' => 'P', 'url'=>'admin_download_menus.php'),
	);      
	
	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list',
		'admin_download/edit'	=> 'admin_download/list',	
	   			
	);	
	
	protected $menuTitle = 'JM Download';
 
}