<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('jmgooglead',true);


class jmgooglead_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'jmgooglead_ui',
			'path' 			=> null,
			'ui' 			=> 'jmgooglead_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(

		'main/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P'),
		'main/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P'),
		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P'),	
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = LAN_JMGOOGLEAD_ADMIN_01;
}




				
class jmgooglead_ui extends e_admin_ui
{
			
		protected $pluginTitle		= LAN_JMGOOGLEAD_ADMIN_01;
		protected $pluginName		= 'jmgooglead';		
		protected $table			= 'jmgooglead';
		protected $pid				= 'googlead_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

		protected $listOrder		= 'googlead_id DESC';
	
		protected $fields = array(
			'checkboxes' => array(
				'title' => '',
				'type' => null,
				'data' => null,
				'width' => '5%',
				'thclass' => 'center',
				'forced' => '1',
				'class' => 'center',
				'toggle' => 'e-multiselect',
				'readParms' => array() ,
				'writeParms' => array() ,
			) ,
			'googlead_id' => array(
				'title' => LAN_ID,
				'data' => 'int',
				'width' => '5%',
				'help' => '',
				'readParms' => array() ,
				'writeParms' => array() ,
				'class' => 'left',
				'thclass' => 'left',
			) ,
			'googlead_name' => array(
				'title' => LAN_TITLE,
				'type' => 'text',
				'data' => 'str',
				'width' => 'auto',
				'filter' => true,
				'inline' => true,
				'help' => '',
				'readParms' => array() ,
				 'writeParms' => array(
					'size' => 'block-level', 
					'post' => "<div class='label bg-info'>Just title</div>"
			 	),
				'class' => 'left',
				'thclass' => 'left',
			) ,
			'googlead_gaid' => array(
				'title' => 'Gaid',
				'type' => 'text',
				'data' => 'int',
				'width' => 'auto',
				'inline' => true,
				'validate' => false,
				'help' => '',
				'readParms' => array() ,
				 'writeParms' => array(
					'size' => 'block-level',
					'post' => "<div class='label bg-info'>".LAN_JMGOOGLEAD_ADMIN_02."</div>"
			 	),
				'class' => 'left',
				'thclass' => 'left',
			) ,
			'googlead_code' => array(
				'title' => 'Code',
				'type' => 'textarea',
				'data' => 'str',
				'width' => 'auto',
				'validate' => true,
				'help' => '',
				'readParms' => array() ,
				 'writeParms' => array(
					'size' => 'block-level',
					'post' => "<div class='label bg-info'>".LAN_JMGOOGLEAD_ADMIN_03."</div>"
			 	),
				'class' => 'left',
				'thclass' => 'left',
			) ,
			'googlead_note' => array(
				'title' => LAN_DESCRIPTION,
				'type' => 'text',
				'data' => 'str',
				'width' => 'auto',
				'help' => '',
				'readParms' => array() ,
				 'writeParms' => array(
					'size' => 'block-level',
					'post' => "<div class='label bg-info'>".LAN_JMGOOGLEAD_ADMIN_04."</div>"
			 	),
				'class' => 'left',
				'thclass' => 'left',
			) ,
			'googlead_active' => array(
				'title' => LAN_ACTIVE,
				'type' => 'boolean',
				'data' => 'int',
				'width' => 'auto',
				'filter' => true,
				'help' => '',
				'readParms' => array() ,
				 'writeParms' => array(
					'size' => 'block-level',
					'post' => "<div class='label bg-info'>".LAN_JMGOOGLEAD_ADMIN_05."</div>"
			 	),
				'class' => 'left',
				'thclass' => 'left',
			) ,
			'googlead_class' => array(
					'title' => LAN_VISIBILITY,
					'type' => 'userclass',
					'data' => 'int',
					'inline' => false,
					'width' => 'auto',
					'filter' => true,
					'batch' => true,
				 'writeParms' => array(
					'size' => 'block-level',
					'post' => "<div class='label bg-info'>".LAN_JMGOOGLEAD_ADMIN_06."</div>"
			 	),
				) ,			
			'options' => array(
				'title' => LAN_OPTIONS,
				'type' => null,
				'data' => null,
				'width' => '10%',
				'thclass' => 'center last',
				'class' => 'center last',
				'forced' => '1',
				'readParms' => array() ,
				'writeParms' => array() ,
			) ,
		);		
		protected $fieldpref = array('googlead_id', 'googlead_name', 'googlead_gaid', 'googlead_note', 'googlead_active', 'googlead_class');
		

		//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'disableblock_code' => array(
				'title' => LAN_JMGOOGLEAD_ADMIN_08,
				'tab' => 0,
				'type' => 'textarea',
				'data' => 'str',
				'help' => '',
				'writeParms' => array(
					'size' => 'block-level',
					'post' => "<div class='label bg-info'>insert code for adblock checker f.e.  http://disableadblock.com/  </div>"
				)
			) ,
			'disableblock_active' => array(
				'title' => LAN_JMGOOGLEAD_ADMIN_09,
				'tab' => 0,
				'type' => 'boolean',
				'data' => 'str',
				'help' => '',
				'writeParms' => array(
					'post' => "<br /><div class='label bg-info'> Disable script for adblock check? </div> "
				)
			) ,
			'googleads_script' => array(
				'title' => LAN_JMGOOGLEAD_ADMIN_10,
				'tab' => 0,
				'type' => 'text',
				'data' => 'str',
				'help' => 'adsbygoogle script <script>... </script>',
				'writeParms' => array(
					'size' => 'block-level',
					'post' => "<div class='label bg-info'>code for adsbygoogle.js script < script >... < /script >  </div>"
				)
			) ,
			'googleads_global' => array(
				'title' => LAN_JMGOOGLEAD_ADMIN_11,
				'tab' => 0,
				'type' => 'boolean',
				'data' => 'str',
				'help' => '',
				'writeParms' => array(
					'post' => "<br /><div class='label bg-info'>if adsbygoogle script is inserted, load it on all pages? If not, you need to put this script to ad code </div> "
				)
			) ,
			'googleads_blockpages' => array(
				'title' => LAN_JMGOOGLEAD_ADMIN_12,
				'tab' => 0,
				'type' => 'textarea',
				'data' => 'str',
				'help' => '',
				'writeParms' => array(
					'size' => 'block-level',
					'post' => "<div class='label bg-info'>add pages where to not display google ads, each page on new line  </div>"
				)
			) ,
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
 	
}
				


class jmgooglead_form_ui extends e_admin_form_ui
{

}		
		
		
new jmgooglead_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>