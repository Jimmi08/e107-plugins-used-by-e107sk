<?php
if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
/* Notes for future re-using
   Always use prefs as first option, it saves time
*/ 
 
class jmmetatag_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'ajax' => array(
			'controller' => 'metatag_admin_ajax_ui',
		),
		'main' => array(
			'controller' => 'metatag_admin_ui',
			'path'       => null,
			'ui'         => 'metatag_admin_form_ui',
			'uipath'     => null
		),

		'metatag'	=> array(
			'controller' 	=> 'jmmetatag_ui',
			'path' 			=> null,
			'ui' 			=> 'jmmetatag_form_ui',
			'uipath' 		=> null
		),
	);	

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
	
	protected $menuTitle = LAN_PLUGIN_METATAG_NAME;
 
}