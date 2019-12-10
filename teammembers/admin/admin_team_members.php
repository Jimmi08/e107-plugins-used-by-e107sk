<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('teammembers',true);

/******************************************************************************/
// copy to admin/admin_menu.php
/* 
class teammembers_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'team_members_ui',
			'path' 			=> null,
			'ui' 			=> 'team_members_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(

		'main/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P'),
		'main/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P'),

		// 'main/div0'      => array('divider'=> true),
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P'),
		
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'teammembers';
    
}
*/
//*********************************** END OF MENU *****************************/



require_once("admin_menu.php");

class team_members_adminArea extends teammembers_adminArea
{
       
}

            	
class team_members_ui extends e_admin_ui
{
			
		protected $pluginTitle		= LP_TEAMMEMBERS_NAME;
		protected $pluginName		= 'teammembers';
	//	protected $eventName		= 'teammembers-team_members'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'team_members';
		protected $pid				= 'uid';
		protected $perPage			= 20; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

    	protected $tabs				= array( LP_TM_TAB_BASIC_INFO,  LP_TM_TAB_PERSONAL_INFO, LP_TM_TAB_SOCIAL_LINKS, LP_TM_TAB_AWARDS); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'item_order DESC';
	
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'forced' => true,  'toggle' => 'e-multiselect',  'fieldpref' => '1',),
			'uid'                     => array (  'title' => 'Uid',  'data' => 'int',),
			'userid'                  => array (  'title' => LP_TM_USER_NAME,  'type' => 'user',  'data' => 'int',  'readParms' => 'idField=user_id&nameField=user_name',),
			'title'                   => array (  'title' => LP_TM_MEMBER_NAME,  'type' => 'text',  'data' => 'str',  'inline' => true,  'fieldpref' => '1',  'nosort' => true,),
			'sef'                     => array (  'title' => LAN_SEFURL,  'type' => 'text',  'data' => 'str',  'inline' => true,  'fieldpref' => '1',  'nosort' => true,  'writeParms' => 'size=xxlarge&sef=title' ),
			'position'                => array (  'title' => LP_TM_POSITION,  'type' => 'text',  'data' => 'str',  'inline' => true,  'fieldpref' => '1',  'nosort' => true,  'writeParms' => 'size=xxlarge',),
			'phone'                   => array (  'title' => LP_TM_PHONE_NUMBER,  'type' => 'text',  'data' => 'str',  'inline' => true,  'fieldpref' => '1',  'nosort' => true,  'writeParms' => 'size=xxlarge',),
			'email'                   => array (  'title' => LAN_EMAIL,  'type' => 'email',  'data' => 'str',  'inline' => true,),
			'website'                 => array (  'title' => LAN_URL,  'type' => 'url',  'data' => 'str',  'inline' => true,  'readParms' => 'target=blank',),
			'summary'                 => array (  'title' => LP_TM_SUMMARY,  'type' => 'text',  'data' => 'str',    'writeParms' => 'size=block-level',),
			'bio'                     => array (  'title' => LP_TM_BIO,  'type' => 'bbarea',  'data' => 'str',  'readParms' => 'expand=...&truncate=150&bb=1',  'writeParms' => 'size=block-level',),
			'image'                   => array (  'title' => LAN_IMAGE,  'type' => 'image',  'data' => 'str',  'readParms' => 'thumb=60&thumb_urlraw=0&thumb_aw=60',  'writeParms' => 'thumb=60&thumb_urlraw=0&thumb_aw=60',),
			'date'                    => array (  'title' => LAN_DATESTAMP,  'type' => 'hidden',  'data' => 'int',    'nosort' => true,),
			'last_updated'            => array (  'title' => LAN_DATESTAMP,  'type' => 'hidden',  'data' => 'int',    'nosort' => true,),
			'status'                  => array (  'title' => LP_TM_STATUS,  'type' => 'boolean',  'data' => 'int',  'batch' => true,  'inline' => true,  'filter' => true,  'fieldpref' => '1',  'nosort' => true,),
			'item_order'                   => array (  'title' => LAN_ORDER,  'type' => 'number',  'data' => 'int',),
			'links_multi'             => array (  'title' => 'Multi',  'type' => 'method',  'tab'=>2, 'data' => 'json',),
			'facts_multi'             => array (  'title' => 'Multi',  'type' => 'method', 'tab'=>1, 'data' => 'json',),           
			'awards_multi'            => array (  'title' => 'Multi',  'type' => 'method', 'tab'=>3, 'data' => 'json',),
            
            
			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'forced' => true,  'fieldpref' => '1',),
		);		
		
		protected $fieldpref = array('title', 'sef', 'position', 'phone', 'date', 'status');
		
	
		public function init()
		{
			// This code may be removed once plugin development is complete. 
			if(!e107::isInstalled('teammembers'))
			{
				e107::getMessage()->addWarning("This plugin is not yet installed. Saving and loading of preference or table data will fail.");
			}
			
			// Set drop-down values (if any). 
			$this->fields['status']['writeParms']['optArray'] = array('status_0','status_1', 'status_2'); // Example Drop-down array. 
	        
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
		   $new_data['date'] = time();
		   $new_data['last_updated'] = time();
			 $new_data = $this->processGlyph($new_data);	
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
		    $new_data['last_updated'] = time();
		    $new_data = $this->processGlyph($new_data);
            
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
		
		// left-panel help menu area. (replaces e_help.php used in old plugins)
		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = 'Some help text';

			return array('caption'=>$caption,'text'=> $text);

		}
        
        /*
		private function processGlyph($new_data)
		{
			foreach($new_data['links_multi'] as $key=>$row)
			{
				if(!empty($row['icon']) && strpos($row['icon'],".glyph")===false)
				{
					$new_data['links_multi'][$key]['icon'] = $row['icon'].".glyph";
				}

			}

			return $new_data;

		}
        */
        
			
	/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			$otherField  = $this->getController()->getFieldVar('other_field_name');
			return $text;
			
		}
        
        
		

	
	 // Handle batch options as defined in team_members_form_ui::links_multi;  'handle' + action + field + 'Batch'
	 // @important $fields['links_multi']['batch'] must be true for this method to be detected. 
	 // @param $selected
	 // @param $type
	function handleListLinksMultiBatch($selected, $type)
	{

		$ids = implode(',', $selected);

		switch($type)
		{
			case 'custombatch_1':
				// do something
				e107::getMessage()->addSuccess('Executed custombatch_1');
				break;

			case 'custombatch_2':
				// do something
				e107::getMessage()->addSuccess('Executed custombatch_2');
				break;

		}


	}

	
	 // Handle filter options as defined in team_members_form_ui::links_multi;  'handle' + action + field + 'Filter'
	 // @important $fields['links_multi']['filter'] must be true for this method to be detected. 
	 // @param $selected
	 // @param $type
	function handleListLinksMultiFilter($type)
	{

		$this->listOrder = 'links_multi ASC';
	
		switch($type)
		{
			case 'customfilter_1':
				// return ' links_multi != 'something' '; 
				e107::getMessage()->addSuccess('Executed customfilter_1');
				break;

			case 'customfilter_2':
				// return ' links_multi != 'something' '; 
				e107::getMessage()->addSuccess('Executed customfilter_2');
				break;

		}


	}
	
		
		
	*/
 
				
	/**
	 * Display a warning if there is a mismatch with the SEF Url.
	 * @param $new_data
	 */
	/*
	private function checkSEFSimilarity($new_data)
	{
		if(e_LANGUAGE === 'Japanese' || e_LANGUAGE === 'Korean')
		{
			return null;
		}


		$expectedSEF = eHelper::title2sef($new_data['title']);
		similar_text($expectedSEF,$new_data['sef'],$percSimilar);

		if($percSimilar < 60)
		{
			e107::getMessage()->addWarning(LAN_NEWS_108); // The SEF URL is unlike the title of your news item.
		}


	}
    */
}  

class team_members_form_ui extends e_admin_form_ui
{

	
	// Custom Method/Function 
	function links_multi($curVal,$mode)
	{

		$value = array();

		if(!empty($curVal))
		{
			$value = e107::unserialize($curVal);
		}
        
        //get the list of social available links
        $optIcons = array(
          'facebook'=>'Facebook',
          'twitter'=>'Twitter',
          'pinterest'=>'Pinterest',
          'github'=>'Github',
          'linkedin'=>'LinkedIn',
          'instagram'=>'Instagram',
          'youtube'=>'Youtube',
          'envelope'=>'Email',
          ); // Example Drop-down array. 
        		
		switch($mode)
		{
			case 'read': // List Page

                if(empty($value))
				{
					return null;
				}
               
             	$text = '<table style="background-color:transparent" cellspacing="4">';
            
            				foreach($value as $row)
            				{
            					$text .= "<tr><td style='width:30px;vertical-align:top'>";
            					$text .= e107::getParser()->toIcon($row['icon']);
            					$text .= "</td> </tr>";
            
            				}
            			$text .= "</table>";
				return $text;                
			break;
			
			case 'write': // Edit Page
                $amt = range(0,4);
            	$text = "<table class='table table-condensed table-bordered'>
				<colgroup>
					<col style='width:5%' />
					<col />
				</colgroup>
				<tr>
					<th class='text-center'>Icon</th>
					<th>Text</th>
					</tr>";
          
 				foreach($amt as $v)
				{
					$name = 'links_multi['.$v.']';
					$val = varset($value[$v]);
                                
					$text .= "<tr>
                      <td>".$this->select($name.'[icon]',  $optIcons, $val['icon'], array('size'=>'small'), true)."</td>								 
					  <td>".$this->textarea($name.'[text]',$val['text'],1,80,array('size'=>'block-level'))."</td>							 
				 	  </tr>";

				}

				$text .= "</table>";


				return $text;
                
                                   
			 
			break;
			
			case 'filter':
				return array('customfilter_1' => 'Custom Filter 1', 'customfilter_2' => 'Custom Filter 2');
			break;
			
			case 'batch':
				return array('custombatch_1' => 'Custom Batch 1', 'custombatch_2' => 'Custom Batch 2');
			break;
		}
		
		return null;
	}
    
    
	
	// Custom Method/Function 
	function facts_multi($curVal,$mode)
	{

		$value = array();

		if(!empty($curVal))
		{
			$value = e107::unserialize($curVal);
		}
        
 
		switch($mode)
		{
			case 'read': // List Page

                if(empty($value))
				{
					return null;
				}
               
             	$text = 'OK';
				return $text;                
			break;
			
			case 'write': // Edit Page
          $amt = range(0,10);
        	$text = "<table class='table table-condensed table-bordered'>
				<colgroup>
					<col style='width:5%' />
					<col />
				</colgroup>
				<tr>
					<th class='text-left'>".LAN_TITLE."</th>
					<th>Text</th>
					</tr>";
          
                $field['label'] = array('type'  => 'text',   'writeParms' => array('size'=>'xlarge'));   
                $field['text']  = array('type'  => 'text',   'writeParms' => array('size'=>'xxlarge'));   
 				foreach($amt as $v)
				{
					$name = 'facts_multi['.$v.']';
					$val = varset($value[$v]);
                                
					$text .= "<tr>
                       							 
					  <td>".$this->renderElement($name.'[label]', $val['label'], $field['label'])."</td>		 
                      <td>".$this->renderElement($name.'[text]', $val['text'], $field['text'])."</td>						 
				 	  </tr>";

				}
 
				$text .= "</table>";
 
				return $text;
 
			break;
			
			case 'filter':
				return array('customfilter_1' => 'Custom Filter 1', 'customfilter_2' => 'Custom Filter 2');
			break;
			
			case 'batch':
				return array('custombatch_1' => 'Custom Batch 1', 'custombatch_2' => 'Custom Batch 2');
			break;
		}
		
		return null;
	}    
     
 
	// Custom Method/Function 
	function awards_multi($curVal,$mode)
	{

		$value = array();

		if(!empty($curVal))
		{
			$value = e107::unserialize($curVal);
		}
        
 
		switch($mode)
		{
			case 'read': // List Page

                if(empty($value))
				{
					return null;
				}
    
             	$text = 'OK';
				return $text;                
			break;
			
			case 'write': // Edit Page
          $amt = range(0,5);
        	$text = "<table class='table table-condensed table-bordered'>
				<colgroup>
					<col style='width:5%' />
					<col />
				</colgroup>
				<tr>
					<th class='text-left'>".LAN_TITLE."</th>
					<th>Text</th>
					</tr>";
          
                $field['image'] = array('type'  => 'image',   'writeParms' => array('size'=>'xlarge'));   
                $field['text']  = array('type'  => 'text',   'writeParms' => array('size'=>'xxlarge'));   
 				foreach($amt as $v)
				{
					$name = 'awards_multi['.$v.']';
					$val = varset($value[$v]);
                                
					$text .= "<tr>
                       							 
					  <td>".$this->renderElement($name.'[image]', $val['image'], $field['image'])."</td>		 
                      <td>".$this->renderElement($name.'[text]', $val['text'], $field['text'])."</td>						 
				 	  </tr>";

				}
 
				$text .= "</table>";
 
				return $text;
 
			break;
			
			case 'filter':
				return array('customfilter_1' => 'Custom Filter 1', 'customfilter_2' => 'Custom Filter 2');
			break;
			
			case 'batch':
				return array('custombatch_1' => 'Custom Batch 1', 'custombatch_2' => 'Custom Batch 2');
			break;
		}
		
		return null;
	}    
}		
		
		
new teammembers_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();
 
require_once(e_ADMIN."footer.php");
exit;

