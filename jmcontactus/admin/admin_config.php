<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}
 
require_once("admin_leftmenu.php");
			
class jmcontactus_prefs_ui extends e_admin_ui
{
			
		protected $pluginTitle		= CUP_SETTINGS_00;
		protected $pluginName		= 'jmcontactus'; 		
		protected $table			= '';
		protected $pid				= '';	
		protected $listOrder		= ' DESC';	
		protected $fields 		= NULL;				
		protected $fieldpref = array();

		//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'jmcontactus_settings_showmap'		=> array('title'=> CUP_SETTINGS_MAP, 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>''),
			'jmcontactus_googlemapsapikey'		=> array('title' => CUP_SETTINGS_MAP_KEY, 'type'=>'text', 'writeParms'=>array('size'=>'block-level'),  'help'=>''),
			); 
	
		public function init()
		{
                  
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
		// left-panel help menu area. 
		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = 'Some help text';

			return array('caption'=>$caption,'text'=> $text);

		}
			
}

class jmcontactus_form_prefs_ui extends e_admin_form_ui
{
 
}				
		
new jmcontactus_admin_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>