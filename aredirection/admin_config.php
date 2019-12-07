<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('aredirection',true);

class aredirection_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'redirection_items_ui',
			'path' 			=> null,
			'ui' 			=> 'redirection_items_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(

		'main/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P'),
		'main/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P'),
    'main/help'				=> array('caption'=> LAN_HELP, 'perm' => '0' )		
		// 'main/div0'      => array('divider'=> true),
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P'),
		
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'JM Redirection';
}




				
class redirection_items_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'JM Redirection';
		protected $pluginName		= 'aredirection';
	//	protected $eventName		= 'aredirection-redirection_items'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'redirection_items';
		protected $pid				= 'redirection_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'redirection_id DESC';
	
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' =>  array (),  'writeParms' =>  array (),),
			'redirection_id'          => array (  'title' => LAN_ID,  'data' => 'int',  'width' => '5%',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),

			'redirection_url'  =>   
			array ( 'title' => 'Old URL',
											'type' => 'url',
											'data' => 'str',
											'width' => 'auto',
											'inline' => true,
											'validate' => true,
											'help' => '',
											'readParms' =>  array ( ),
											'writeParms' =>  array ('size' =>'block-level' ),
			),
 
			'redirection_newurl'      =>  
				array ( 'title' => 'New URL',
						'type' => 'url',
						'data' => 'str',
						'width' => 'auto',
						'inline' => true,
						'validate' => true,
						'help' => '',
						'readParms' =>  array ( ),
						'writeParms' =>  array ('size' =>'block-level' ),
			),

			'redirection_note'        =>  
			array ( 'title' => 'Note',
					'type' => 'text',
					'data' => 'str',
					'width' => 'auto',
					'help' => '',
					'readParms' =>  array ( ),
					'writeParms' => array ('size' =>'block-level' ),
					'class' => 'left',
					'thclass' => 'left',
			),

			'redirection_status'    => array (  'title' => 'Active',
					'type' => 'boolean',
					'data' => 'int',
					'width' => 'auto',
					'help' => '',
					'readParms' =>  array (),
					'writeParms' => 'label=yesno',
					'class' => 'left',
					'thclass' => 'left',
			),
 
			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last',  'class' => 'center last',  'forced' => true,  'readParms' =>  array (),  'writeParms' =>  array (),),
		);		
		
		protected $fieldpref = array('redirection_id', 'redirection_url', 'redirection_newurl', 'redirection_note', 'redirection_status');

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		); 

	
		public function init()
		{
			// This code may be removed once plugin development is complete. 
			if(!e107::isInstalled('aredirection'))
			{
				e107::getMessage()->addWarning("This plugin is not yet installed. Saving and loading of preference or table data will fail.");
			}
			
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
		
  	public function helpPage()
  	{
  		$ns = e107::getRender();
    
  		include('e_help.php');
  		$text = '<div class="tab-content"><div class="tab-pane  active">'.$helplink_text['body'].'</div></div>';
  		$ns->tablerender('',$text);	
  		
  	}
			
	/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			$otherField  = $this->getController()->getFieldVar('other_field_name');
			return $text;
			
		}
		
	
		
		
	*/
			
}
				


class redirection_items_form_ui extends e_admin_form_ui
{

}		
		
		
new aredirection_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

