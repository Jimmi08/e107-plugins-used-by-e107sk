<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('hits',true);


class hits_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'hits_ui',
			'path' 			=> null,
			'ui' 			=> 'hits_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(

		'main/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P'),
	//	'main/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P'),
			
		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => '0'),

		'main/custom'		=> array('caption'=> 'Build empty entries', 'perm' => '0')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'Hits';
}




				
class hits_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Hits';
		protected $pluginName		= 'hits';
	//	protected $eventName		= 'hits-hits'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'hits';
		protected $pid				= 'hits_id';
		protected $perPage			= 15;
		protected $batchDelete		= false;
	//	protected $batchCopy		= true;		
	//	protected $sortField		= 'somefield_order';
	//	protected $orderStep		= 10;
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
		protected $listQry      	= "SELECT n.news_id,n.news_title,n.news_datestamp, h.* FROM `#news` AS n LEFT JOIN `#hits` as h ON n.news_id = h.hits_itemid WHERE h.hits_type = 'news'  "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'news_datestamp DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),

		  'hits_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),

		  'news_title' =>   array ( 'title' => LAN_TITLE, 'type'=>'text', 'data' => false, 'width' => '40%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'news_datestamp' =>   array ( 'title' => "Published", 'type'=>'datestamp', 'data' => false, 'width' => '10%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),

		  'hits_type' =>   array ( 'title' => LAN_TYPE, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'batch' => true, 'filter' => true,  'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'hits_itemid' =>   array ( 'title' => 'Item ID', 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'right', 'thclass' => 'right',  ),
		  'hits_counter' =>   array ( 'title' => 'Hits', 'type' => 'number', 'data' => 'int', 'width' => '8%',  'help' => '', 'readParms' => 'sep=,', 'writeParms' => '', 'class' => 'right', 'thclass' => 'right',  ),
		  'hits_unique' =>   array ( 'title' => 'Unique', 'type' => 'number', 'data' => 'int', 'width' => '8%', 'help' => '', 'readParms' => 'sep=,', 'writeParms' => '', 'class' => 'right', 'thclass' => 'right',  ),
		  'hits_lastupdated' =>   array ( 'title' => 'Last Hit', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => 'mask=relative', 'writeParms' => '', 'class' => 'right last', 'thclass' => 'right last',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' =>'method', 'nolist'=>true, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => false,  ),
		);		
		
		protected $fieldpref = array('news_title','news_datestamp', 'hits_type', 'hits_counter', 'hits_unique', 'hits_lastupdated');
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'Active'		=> array('title'=> 'Active', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>''),
		); 

	
		public function init()
		{
			// Set drop-down values (if any). 
		//	$this->fields['hits_type']['writeParms']['optArray'] = array('hits_type_0','hits_type_1', 'hits_type_2'); // Example Drop-down array.

			if(e_DEBUG === true)
			{
				$this->fields['hits_counter']['inline'] = true;
				$this->fields['hits_unique']['inline'] = true;
				$this->batchDelete = true;
			}
			else
			{
				unset($this->fields['checkboxes']);
			}
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
		
			

		public function customPage()
		{

			if(!empty($_POST['submitHits']))
			{

				$sql = e107::getDb();
				$data = $sql->retrieve('news','news_id',null,true);

				foreach($data as $row)
				{
					$insertArray = array(
						'hits_id' => 0,
						'hits_type' => 'news',
						'hits_itemid' => intval($row['news_id']),
						'hits_counter' => 0,
						'hits_unique' => 0,
					);

					 $sql->insert('hits', $insertArray);

				}

				e107::getMessage()->addSuccess("Done");

				return e107::getMessage()->render();

			}


			$frm = e107::getForm();
			$text = "Create empty records for all existing news items";

			$text .= $frm->open('createHits','post');

			$text .= $frm->button('submitHits',1,'submit',LAN_GO);

			$text .= $frm->close();

			return $text;
			
		}

			
}
				


class hits_form_ui extends e_admin_form_ui
{
	function options($curval,$bla,$bla2)
	{
		return '&nbsp;';

	}
}		
		
		
new hits_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>