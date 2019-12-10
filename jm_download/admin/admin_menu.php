<?php
if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
/* Notes for future re-using
   Always use prefs as first option, it saves time
*/ 
e107::lan('jm_download');
e107::lan('jm_download');
 
class jm_downloads_adminArea extends e_admin_dispatcher
{
            
	protected $adminMenu = array(
  
    'main/prefs' 		=> array('caption'=> 'Latest Menu Settings', 'perm' => 'P', 'url'=>'admin_config.php'),

    'admin_download/list'			=> array('caption'=> 'Download Overview', 'perm' => 'P', 'uri'=>"admin_download.php?mode=main&action=list"), 
 
	);      
	
	protected $adminMenuAliases = array(
		'admin_download/edit'	=> 'admin_download/list',	
	   			
	);	
	
	protected $menuTitle = 'JM Canonical';
 
}