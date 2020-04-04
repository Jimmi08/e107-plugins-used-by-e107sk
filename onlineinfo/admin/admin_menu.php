<?php
if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
/* Notes for future re-using
   Always use prefs as first option, it saves time
*/ 
 
$plugPref =  e107::pref('onlineinfo');
 
class onlineinfomenu_adminArea extends e_admin_dispatcher
{
            
	protected $adminMenu = array(
  
     'main/prefs' 		=> array('caption'=> ONLINEINFO_LOGIN_MENU_A71, 'perm' => 'P', 'url'=>'admin_config.php'),
     'usercols/settings' 		=> array('caption'=> ONLINEINFO_LOGIN_MENU_A101, 'perm' => 'P', 'url'=>'admin_config_usercols.php'),  
     'who/settings' 		=> array('caption'=> ONLINEINFO_LOGIN_MENU_A72, 'perm' => 'P', 'url'=>'admin_config_who.php'), 
     'latestchanges/settings' 		=> array('caption'=> ONLINEINFO_LOGIN_MENU_A76, 'perm' => 'P', 'url'=>'admin_config_late.php'), 
     'extra/settings' 		=> array('caption'=> ONLINEINFO_LOGIN_MENU_A73, 'perm' => 'P', 'url'=>'admin_config_extra.php'),     
     'sections/settings' 		=> array('caption'=> ONLINEINFO_LOGIN_MENU_A36, 'perm' => 'P', 'url'=>'admin_config_order.php'),       
     'suspend/settings' 		=> array('caption'=> ONLINEINFO_LOGIN_MENU_A127, 'perm' => 'P', 'url'=>'admin_suspend.php'),      
     'help/helpinfo' 		=> array('caption'=> ONLINEINFO_HELP_14, 'perm' => 'P', 'url'=>'admin_help.php'),     
	);      
	
	protected $adminMenuAliases = array(
   			
	);	
	
	protected $menuTitle = ONLINEINFO_LOGIN_MENU_A77;
 
}