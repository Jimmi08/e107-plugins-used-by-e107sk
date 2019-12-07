<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('smartsupp', true);


class smartsupp_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'smartsupp_ui',
			'path' 			=> null,
			'ui' 			=> 'smartsupp_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(
			
		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P'),	

		// 'main/div0'      => array('divider'=> true),
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P'),
		
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = LAN_SMARTSUPP_NAME;
}




				
class smartsupp_ui extends e_admin_ui
{
			
		protected $pluginTitle	= LAN_SMARTSUPP_NAME;
		protected $pluginName	= 'smartsupp';
		protected $fields 		= NULL;				
		protected $fieldpref 	= array();
		

	  protected $preftabs        = array('General', 'Variables' );
		protected $prefs = array(
			'smartsupp_active'		=> array('title'=> LAN_ACTIVE, 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>LAN_SMARTSUPP_ACTIVE_HELP),

			'smartsupp_code'		=> array('title'=> LAN_SMARTSUPP_CODE, 'tab'=>0, 'type'=>'textarea', 'data' => 'str', 'help'=>LAN_SMARTSUPP_CODE_HELP,
			'writeParms' => array(
				'size' => 'block-level',
				'post' => "<div class='bg-info' style='color: white;padding: 5px;'>".LAN_SMARTSUPP_CODE_HELP."</div>"
			 ),
      ),
			'smartsupp_siteLanguage'		=> array('title'=> LAN_SMARTSUPP_LANGUAGE, 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>LAN_SMARTSUPP_LANGUAGE_HELP),
 
			'smartsupp_enableVariables'		=> array('title'=> 'Show Detailed Info', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'',
				'writeParms' => array(
				'post' => "<div class='bg-info' style='color: white;padding: 5px;'>See second Tab</div>"
			 ),
			 ),
			'smartsupp_showVisitorName'		=> array('title'=> 'Show user name in Visitor section', 'tab'=>1, 'type'=>'boolean', 'data' => 'str', 'help'=>''),
			'smartsupp_showVisitorEmail'	=> array('title'=> 'Show user email in Visitor section', 'tab'=>1, 'type'=>'boolean', 'data' => 'str', 'help'=>''),
			'smartsupp_showId'		=> array('title'=> 'Show user ID in Customer section', 'tab'=>1, 'type'=>'boolean', 'data' => 'str', 'help'=>''),
			'smartsupp_showName'		=> array('title'=> 'Show user name in Customer section', 'tab'=>1, 'type'=>'boolean', 'data' => 'str', 'help'=>''),
			'ssmartsupp_howEmail'		=> array('title'=> 'Show user Email in Customer section', 'tab'=>1, 'type'=>'boolean', 'data' => 'str', 'help'=>''),
		); 

		
		public function init()
		{
			// Set drop-down values (if any). 
	
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
			$text = 'Just insert your chat code';

			return array('caption'=>$caption,'text'=> $text);

		}
 
}
				


class smartsupp_form_ui extends e_admin_form_ui
{

}		
		
		
new smartsupp_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>