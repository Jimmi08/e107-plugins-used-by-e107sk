<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('jm_download',true);

require_once("admin_menu.php");

class jm_download_adminArea extends jm_downloads_adminArea
{

	protected $modes = array(	
	
		'admin_downloadmenu'	=> array(
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
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= ' DESC';
	
		protected $fields 		= NULL;		
		
		protected $fieldpref = array();
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'latestmenu_amount'		=> array('title'=> 'Latest menu display items', 'tab'=>0, 'type'=>'number', 'data' => 'int', 'help'=>''),
			'latestmenu_author'		=> array('title'=> 'Display author', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'',
			'writeParms' => array(
					'post' => "<br /><div class='label bg-info'> If set ON,  download author will be displayed in Latest menu</div> "
				)), 
			'latestmenu_category'		=> array('title'=> 'Display category', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'',
				'writeParms' => array(
					'post' => "<br /><div class='label bg-info'> If set ON,  download category will be displayed in Latest menu</div> "
				)), 
			'latestmenu_adminlink'		=> array('title'=> 'Display Admin link', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'',
				'writeParms' => array(
					'post' => "<br /><div class='label bg-info'> If set ON, direct link to edit download will be displayed. Set it off it breaks layout for admins. </div> "
				)),
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
			$text = 'Some help text';

			return array('caption'=>$caption,'text'=> $text);

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