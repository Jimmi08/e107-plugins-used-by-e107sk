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
 
class onepage_adminArea extends jmcoremenu_adminArea
{
	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'onepage_ui',
			'path' 			=> null,
			'ui' 			=> 'onepage_form_ui',
			'uipath' 		=> null
		),		
	);	
}
				
class onepage_ui extends e_admin_ui
{		
		protected $pluginTitle		= 'One Page Site Setting';
		protected $pluginName		= 'jmcore';
		protected $listOrder		= ' DESC';	
		protected $fields 		= NULL;				
		protected $fieldpref = array();

		//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'onepage_active'		=> 
				array('title'=> "<b>".LAN_ACTIVE.'</b><br /><small>'.LAN_JM_CORE_ONEPAGE_LAN_03.'</small>',
				'tab'		=>	0,
				'type'		=>'boolean',
				'data'		=> 'str',
				'help'		=>''
				),
					
			'onepage_exclude'		=> 
				array('title'=> "<b>".LAN_JM_CORE_ONEPAGE_LAN_04.'</b><br /><small>'.LAN_JM_CORE_ONEPAGE_LAN_03.'<br /></small><b>'.LAN_JM_CORE_ONEPAGE_LAN_06.'</b> '.SITEURL,
				'tab'=>0,
				'type'=>'textarea', 'data' => 'str',
				'writeParms'=> array(
				'post' 	=> "<div class='label bg-info'>contact.php should be here always! .</div>"),
				) 			
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
			/* $menu_slug = preg_split ('/\n/', $new_data['onepage_exclude']); 
			 $new_data['onepage_exclude'] = $menu_slug;   */
			 return $new_data;			  
		}

		public function renderHelp()
		{
			$tp = e107::getParser(); 
			$text = "";
			$text .= "<b>".LAN_JM_CORE_ONEPAGE_LAN_02."</b><br />"; 
			$text .= "<div>".$tp->toHTML(LAN_JM_CORE_ONEPAGE_LAN_05,true)."</div>";
			return array('caption'=>LAN_JM_CORE_ONEPAGE_LAN_01, 'text'=>$text);	
		}
}

class onepage_prefs_form_ui extends e_admin_form_ui
{
   	
}		
		
		
new onepage_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>