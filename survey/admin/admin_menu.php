<?php
if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
/* Notes for future re-using
   Always use prefs as first option, it saves time
*/ 

e107::lan('survey',true, true);

class survey_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
		'main'	=> array(
			'controller' 	=> 'survey_ui',
			'path' 			=> null,
			'ui' 			=> 'survey_form_ui',
			'uipath' 		=> null
		),
	);	
	
	
	protected $adminMenu = array(
		'main/list'			  => array('caption'=> ADLAN_SUR_MAINCONF, 'perm' => 'P', 'url'=>'admin_config.php'),
    'main/oldadmin'		=> array('caption'=> ADLAN_SUR_OLDCONF,  'perm' => 'P', 'url'=>'admin_config_old.php'),
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'Survey';
}

