<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('jmcore',true);
 
require_once("admin_menu.php");
 
class adminlook_adminArea extends jmcoremenu_adminArea
{
	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'adminlook_ui',
			'path' 			=> null,
			'ui' 			=> 'adminlook_form_ui',
			'uipath' 		=> null
		),		
	);	
}
				
class adminlook_ui extends e_admin_ui
{		
		protected $pluginTitle		= LAN_JM_CORE_LAN_01;
		protected $pluginName		= 'jmcore';
		protected $listOrder		= ' DESC';	
		protected $fields 		= NULL;				
		protected $fieldpref = array();

		//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array (
			'adminlook_removetooltips'		=> 
				array('title'=>  LAN_JM_CORE_ADMINLOOK_LAN_01 ,
				'tab'		=>	0,
				'type'		=>'boolean',
				'data'		=> 'str',
				'help'		=>LAN_JM_CORE_ADMINLOOK_LAN_02
				),
					
			'adminlook_navheaders'		=> 
				array('title'=>  LAN_JM_CORE_ADMINLOOK_LAN_03 ,
				'tab'		=>	0,
				'type'		=>'boolean',
				'data'		=> 'str',
				'help'		=>LAN_JM_CORE_ADMINLOOK_LAN_04
				), 	
			'adminlook_navheader_bg'		=> 
				array('title'=>  LAN_JM_CORE_ADMINLOOK_LAN_05 ,
				'tab'		=>	0,
				'type'		=>'text',
				'data'		=> 'str',
				'help'		=>LAN_JM_CORE_ADMINLOOK_LAN_07
				),               
			'adminlook_navheader_color'		=> 
				array('title'=>  LAN_JM_CORE_ADMINLOOK_LAN_06 ,
				'tab'		=>	0,
				'type'		=>'text',
				'data'		=> 'str',
				'help'		=>LAN_JM_CORE_ADMINLOOK_LAN_08
				),                
                
                
		); 

	
		public function init()
		{
			// Set drop-down values (if any). 
		}

		/**
		 * User defined before pref saving logic
		 * @param $new_data
		 * @param $old_data
		 */
		public function beforePrefsSave($new_data, $old_data)
		{
			/* $menu_slug = preg_split ('/\n/', $new_data['adminlook_exclude']); 
			 $new_data['adminlook_exclude'] = $menu_slug;   */
			 return $new_data;			  
		}
 
}

class adminlook_prefs_form_ui extends e_admin_form_ui
{
   	
}		
		
		
new adminlook_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>