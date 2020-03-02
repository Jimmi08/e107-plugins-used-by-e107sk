<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('spoiler',true);


class spoiler_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'spoiler_ui',
			'path' 			=> null,
			'ui' 			=> 'spoiler_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(
			
		'main/index'		=> array('caption'=> 'About plugin', 'perm' => 'P'),
		'main/prefs'		=> array('caption'=> LAN_OPTIONS, 'perm' => 'P'),
		// 'main/div0'      => array('divider'=> true),
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P'),
		
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'spoiler';
}




				
class spoiler_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'spoiler';
		protected $pluginName		= 'spoiler';
	//	protected $eventName		= 'spoiler-'; // remove comment to enable event triggers in admin. 		
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
			'text_showspoiler'		=> array('title'=> 'Text_showspoiler', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>''),
			'text_hidespoiler'		=> array('title'=> 'Text_hidespoiler', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>''),
			'text_forspoiler_parm '		=> array('title'=> 'Text_forspoiler_parm ', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>''),
			'text_forspoiler'		=> array('title'=> 'Text_forspoiler', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>''),
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
			
	 	
		// optional - a custom page.  
		public function IndexPage()
		{
			$txt = "
	
			<table class='fborder'>
		 
		    <tr>
			<td><p>Dies ist die Version 1.0 von <strong>Spoiler</strong> <br>
			  
		<br />http://www.hupsis-e107.de/theme/news.php
		</td></tr>
		  <tr><td>bei klick auf den Button bekommst du das [sp][/sp] nun kannst du dieses so einsetzten <br/>[sp=text]Hallo ich bin das Spoiler Plugin[/sp] <br/>wobei aus sp=text das entsteht Spoiler f&uuml;r text:
		  <br/>
		  wenn du das sp so l&auml;st wie es kommt steht dort nur spoiler:</td></tr>
		 
		</td>
			
			  </tr>
			</table>
		
			";
			return $txt;
			
		}
		
	
		
		
	 
			
}
				


class spoiler_form_ui extends e_admin_form_ui
{

}		
		
		
new spoiler_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>