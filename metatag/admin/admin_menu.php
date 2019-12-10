<?php
if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
/* Notes for future re-using
   Always use prefs as first option, it saves time
*/ 
e107::lan('jmcore');
 
class jmcoremenu_adminArea extends e_admin_dispatcher
{
            
	protected $adminMenu = array(
 
		'main/list'  => array(
			'caption' => LAN_METATAG_ADMIN_UI_01,
			'perm'    => 'P',
      'url'=>'admin_config.php'),
 
		'opt1'       => array(
			'divider' => true,
		),
		'main/prefs' => array(
			'caption' => "Cache ". LAN_METATAG_ADMIN_UI_09,
			'perm'    => 'P',
      'url'=>'admin_config.php'),
 
    
	'metatag/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P', 'url'=>'admin_metatags.php'),
  'metatag/core'			=> array('caption'=> "Core Meta Tags",  	'perm' => '0', 'url'=>'admin_metatags.php')
	 
 
	);      
	
	protected $adminMenuAliases = array(
   			
	);	
	
	protected $menuTitle = 'JM Core';
 
}