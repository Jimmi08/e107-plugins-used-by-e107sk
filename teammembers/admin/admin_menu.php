<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

 e107::lan('teammembers', true );


class teammembers_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'team_members_ui',
			'path' 			=> null,
			'ui' 			=> 'team_members_form_ui',
			'uipath' 		=> null
		),
		
		'awards'	=> array(
			'controller' 	=> 'team_members_awards_ui',
			'path' 			=> null,
			'ui' 			=> 'team_members_awards_form_ui',
			'uipath' 		=> null
		),
        
         'awardlink'	=> array(
			'controller' 	=> 'team_members_awardlink_ui',
			'path' 			=> null,
			'ui' 			=> 'team_members_awardlink_form_ui',
			'uipath' 		=> null
		),
	);	
	
	
	protected $adminMenu = array(                                                                                     

		'main/list'			=> array('caption'=> LP_TM_MANAGE_MEMBERS, 'perm' => 'P',  'url'=>'admin_team_members.php'  ),
		'main/create'		=> array('caption'=> LP_TM_ADD_MEMBER, 'perm' => 'P' ,  'url'=>'admin_team_members.php?mode=main&action=create'  ),
						 /*
		'awards/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P', 'url'=>'admin_team_members_awards.php'),
		'awards/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P', 'url'=>'admin_team_members_awards.php?mode=main&action=create' ),
        
        'awardlink/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P', 'url'=>'admin_team_members_awardlink.php'), 
		'awardlink/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P', 'url'=>'admin_team_members_awardlink.php?mode=main&action=create' ),
		           */
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list',
        'awards/edit'	=> 'awards/list'			
	);	
	
	protected $menuTitle = LP_TEAMMEMBERS_NAME;
}



 