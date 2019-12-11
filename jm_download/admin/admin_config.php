<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('jm_download',true);

// error page text is already in core, under Agreement tab in Download prefs
// 'errorpage_text'		=> array('title'=> 'Error Page Text for Users', 'tab'=>0, 'type'=>'bbarea', 'data' => 'str', 'help'=>''),
 

require_once("admin_menu.php");

e107::getMessage()->addInfo("Nothing for now")->render(true);
 

class jm_download_adminArea extends jm_downloads_adminArea
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'jm_download_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_download_form_ui',
			'uipath' 		=> null
		),
 
	);	
	
	
 
	
	protected $menuTitle = 'JM Downloads';
}




				
class jm_download_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'JM Downloads';
		protected $pluginName		= 'jm_download';
	//	protected $eventName		= 'jm_download-'; // remove comment to enable event triggers in admin. 		
		protected $table			= '';
		protected $pid				= '';
 
		protected $fields 		= NULL;		
		
		protected $fieldpref = array();
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		
		); 

	
		public function init()
		{
			// Set drop-down values (if any). 
	
		}

 
			
}
				


class jm_download_form_ui extends e_admin_form_ui
{

}		
		
		
new jm_download_adminArea();

require_once(e_ADMIN."auth.php");


 
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>