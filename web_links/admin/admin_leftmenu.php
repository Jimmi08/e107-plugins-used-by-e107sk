<?php
if (!defined('e107_INIT')) { exit; }

require_once("../../../class2.php");


e107::lan("web_links" , "lang_admin");
 

//load constants for front+admin
require_once(e_PLUGIN.'web_links/web_links_defines.php');
require_once(e_PLUGIN.'web_links/admin/web_links_admin_functions.php');

class leftmenu_adminArea extends e_admin_dispatcher
{
 
	protected $modes = array( 	

		'main'	=> array(
			'controller' 	=> 'links_prefs_ui',
			'path' 			=> null,
			'ui' 			=> 'links_prefs_form_ui',
			'uipath' 		=> null
		),
		'links_categories'	=> array(
			'controller' 	=> 'web_links_ui',
			'path' 			=> null,
			'ui' 			=> 'web_links_form_ui',
			'uipath' 		=> null
		),
		'links_links'	=> array(
			'controller' 	=> 'web_links_ui',
			'path' 			=> null,
			'ui' 			=> 'web_links_form_ui',
			'uipath' 		=> null
		),			
	
		

	);

      
	
	protected $adminMenuAliases = array( 			
	);	
	
	protected $menuTitle = _WEBLINKS;

	function init()  {

		$db = e107::getDb();

		// get actual data TODO move to e_dashboard ? 
		$num = $db->retrieve("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_NEWLINK);
		$brokenl = $db->retrieve("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE brokenlink='1'");		 
		$modreql = $db->retrieve("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE brokenlink='0'");


		$this->adminMenu = array( 
			'main/prefs' 				=> array(
				'caption'=> LAN_PREFS,
				'perm' => 'P'),	
			'links_links/list'			=> array(
				'caption'=> _WEBLINKS, 
				'perm' => 'P', 
				'url'=>'admin_links_links.php'),
			'links_categories/list'		=> array(
				'caption'=> _ALLCATEGORIES, 
				'perm' => 'P', ),
			'tools/opt1' 				=> array(
				'header' =>  _WAITINGCONT),
                
			'Links'				=> array(
				'caption'=> _WLINKS, 
				'perm' => 'P',  
				'badge'=>array('value'=>$num, 'type'=>'default'),
				'uri'=>'index.php?op=Links'),
                
			'LinksListModRequests'=> array(
				'caption'=> _MODREQLINKS, 
				'perm' => 'P', 
				'uri'=>'index.php?op=LinksListModRequests',
				'badge'=>array('value'=>$modreql, 'type'=>'default'),
			),
			'LinksListBrokenLinks'=> array(
				'caption'=> _BROKENLINKS, 
				'perm' => 'P', 
				'uri'=>'index.php?op=LinksListBrokenLinks',
				'badge'=>array('value'=>$brokenl, 'type'=>'default'),
			),  
            
			'tools/opt2' 				=> array(
				'header' =>  LAN_MAINTENANCE
            ),
                         
 			'LinksLinkCheck'=> array(
				'caption'=> _VALIDATELINKS, 
				'perm' => '0', 
				'uri'=>'index.php?op=LinksLinkCheck',
				 ),
            'LinksCleanVotes'=> array(
				'caption'=> _CLEANLINKSDB, 
				'perm' => '0', 
				'uri'=>'index.php?op=LinksCleanVotes',
		     ),
  	 
		);

		if($num > 0) 
		{
			$this->adminMenu['Links/index']['badge']['type'] = 'danger';
		}

		if($modreql > 0) 
		{
			$this->adminMenu['LinksListModRequests']['badge']['type'] = 'danger';

		}
		if($brokenl > 0) 
		{
			$this->adminMenu['LinksListBrokenLinks']['badge']['type'] = 'danger';

		}

 
	}
 
}