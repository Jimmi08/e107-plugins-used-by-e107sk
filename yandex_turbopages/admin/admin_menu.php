<?php
if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
/* Notes for future re-using
   Always use prefs as first option, it saves time
*/ 

e107::css('inline', '
.panel-title {
    font-size: 14px;
}'
);

e107::lan('yandex_turbopages');
 
class yandex_turbopages_adminArea extends e_admin_dispatcher
{
            
	protected $adminMenu = array(
 
		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P', 'uri'=>'admin_config.php?mode=main&action=prefs'), 
 		'main/rss' 		=> array('caption'=> LAN_PLUGIN_YTP_AVAILABLE_FEEDS, 'perm' => 'P', 'uri'=>'admin_config.php?mode=main&action=rss'), 
 	 	'page/list'		=> array('caption'=> LAN_PLUGIN_YTP_PAGES, 'perm' => 'P', 'uri'=>'admin_entites.php?mode=page&action=list'),
 
	);      
 
  
	protected $adminMenuAliases = array(
		'yandex_turbopages_urls/edit'	=> 'yandex_turbopages_urls/list',	
		'request_urls/edit'	=> 'request_urls/list'    			
	);	
	
	protected $menuTitle = LAN_PLUGIN_YTP_NAME;
 
}