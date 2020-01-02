<?php
if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
/* Notes for future re-using
   Always use prefs as first option, it saves time
*/ 
e107::lan('jm_canonical', true);
 
class canonical_adminArea extends e_admin_dispatcher
{
            
	protected $adminMenu = array(
  
		'main/prefs' 				=> array('caption'=> LAN_JM_CANONICAL_02, 'perm' => 'P', 'url'=>'admin_config.php'),
		'canonical_urls/list'		=> array('caption'=> 'Overview Canonical URLs', 'perm' => 'P', 	'uri'=>"admin_canonical_urls.php?mode=canonical_urls&action=list"),
	
		'request_urls/list'			=> array('caption'=> 'Manual combinations', 'perm' => 'P', 'uri'=>"admin_request_urls.php?mode=request_urls&action=list"),
	
		'main/list'			=> array('caption'=> 'Related URLs', 'perm' => 'P', 'url'=>'admin_config.php'),
	
		'divider2'            => array('divider'=>true),
		'main/opt1' => array('header'=>"Available tables"),
 
	);      
 
  
	protected $adminMenuAliases = array(
		'canonical_urls/edit'	=> 'canonical_urls/list',	
		'request_urls/edit'	=> 'request_urls/list'    			
	);	
	
	protected $menuTitle = LAN_JM_CANONICAL_01;

	function init() {

		$pluginPrefs = e107::getPlugPref('jm_canonical');
 

		if($pluginPrefs['news_auto']== "none")  {
			$this->adminMenu['page/list'] = 
			array('caption'=> 'News ', 'perm' => 'P', 'uri'=>'admin_canonical.php?mode=news&action=list');
			$this->adminMenu['newscategory/list'] = 
			array('caption'=> 'News Categories ', 'perm' => 'P', 'uri'=>'admin_canonical.php?mode=newscategory&action=list');
		}

		if($pluginPrefs['page_auto']== "none")  {
			$this->adminMenu['news/list'] = 
			array('caption'=> 'Pages ', 'perm' => 'P', 'uri'=>'admin_canonical.php?mode=page&action=list');
		}		

		$forum_installed = e107::isInstalled('forum');
		if($forum_installed && $pluginPrefs['forum_thread_auto']== "none")  {
			$this->adminMenu['forumthread/list'] = 
			array('caption'=> 'Forum Topics ', 'perm' => 'P', 'uri'=>'admin_canonical.php?mode=forumthread&action=list');
		}

		$pcontent_installed = e107::isInstalled('content');
		if($pcontent_installed)  {
			$this->adminMenu['pcontent/list'] = 
			array('caption'=> 'Content ', 'perm' => 'P', 'uri'=>'admin_canonical.php?mode=pcontent&action=list');
		}

		$download_installed = e107::isInstalled('download');
		if($download_installed  && $pluginPrefs['download_auto']== "none")  {
			$this->adminMenu['download/list'] = 
			array('caption'=> 'Downloads ', 'perm' => 'P', 'uri'=>'admin_canonical.php?mode=download&action=list');
			$this->adminMenu['downloadcategory/list'] =
			array('caption'=> 'Download Categories', 'perm' => 'P', 'uri'=>'admin_canonical.php?mode=download-category&action=list');
		}


	}
 
}