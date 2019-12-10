<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('gdpr_cookies',true);


class gdpr_cookies_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'gdpr_cookies_ui',
			'path' 			=> null,
			'ui' 			=> 'gdpr_cookies_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(
			
		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P'),	

		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'EU GDPR cookies';
}




				
class gdpr_cookies_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'EU GDPR cookies';
		protected $pluginName		= 'gdpr_cookies';
	//	protected $eventName		= 'gdpr_cookies-'; // remove comment to enable event triggers in admin. 		
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
		

	  protected $preftabs        = array('General', 'Compliance type', 'Button texts', 'Policy link' );
		protected $prefs = array(
			'gdpr_cookie_active'		=> array('title'=> 'Active', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'Activate plugin'),
			
			'gdpr_cookie_type'		=> array('title'=> 'Compliance type', 'tab'=>1, 'type'=>'method', 'data' => 'str', 'help'=>'', 
			'writeParms' => array("nolabel"=>1)),
			
			'gdpr_cookie_content_message'		=> array('title'=> 'Message', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'Custom Message Text',
			'writeParms' => array("size"=>"block-level")),
			
			'gdpr_cookie_position'		=> array('title'=> 'Banner position', 'tab'=>0, 'type'=>'dropdown', 'data' => 'str', 'help'=>'Position'),
			'gdpr_cookie_theme'		=> array('title'=> 'Layout', 'tab'=>0, 'type'=>'dropdown', 'data' => 'str', 'help'=>'Layout'),
			'gdpr_cookie_palette_popup_background'		=> array('title'=> 'Banner colour', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'Banner colour'),
			'gdpr_cookie_palette_popup_text'		=> array('title'=> 'Banner text', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'Banner text'),
			'gdpr_cookie_palette_button_background'		=> array('title'=> 'Button colour text', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'Button colour text'),
			'gdpr_cookie_palette_button_text'		=> array('title'=> 'Button text', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'Button text'),
			
			'gdpr_cookie_showLink'		=> array('title'=> 'Learn more link', 'tab'=>3, 'type'=>'boolean', 'data' => 'str', 'help'=>'Learn more link'),		
			'gdpr_cookie_customLink'		=> array('title'=> 'Use Custom link', 'tab'=>3, 'type'=>'boolean', 'data' => 'str', 'help'=>''),				
			'gdpr_cookie_content_link'		=> array('title'=> 'Policy link text', 'tab'=>3, 'type'=>'text', 'data' => 'str', 'help'=>'Policy custom link text'),
			'gdpr_cookie_content_href'		=> array('title'=> 'Link to your own policy', 'tab'=>3, 'type'=>'text', 'data' => 'str', 'help'=>'URL adress to your own policy'),
			
			'gdpr_cookie_content_dismiss'		=> array('title'=> 'Dismiss button text', 'tab'=>2, 'type'=>'text', 'data' => 'str', 'help'=>'Dismiss custom button text'),
			'gdpr_cookie_content_deny'		=> array('title'=> 'Deny button text', 'tab'=>2, 'type'=>'text', 'data' => 'str', 'help'=>'Deny custom button text'),
			'gdpr_cookie_content_allow'		=> array('title'=> 'Accept button text', 'tab'=>2, 'type'=>'text', 'data' => 'str', 'help'=>'Accept custom button text'),
		); 

	
		public function init()
		{
			// Set drop-down values (if any). 
	    $gdpr_cookie_position = array('bottom'=>"Banner bottom", 'top' => 'Banner top', 'top_static'=>"Banner top (pushdown)", 'bottom-left' => 'Floating left', 'bottom-right' => 'Floating right');  
      $this->prefs['gdpr_cookie_position']['writeParms'] = $gdpr_cookie_position;
      
			// Set drop-down values (if any). 
	    $gdpr_cookie_theme = array('block'=>"Block", 'classic' => 'Classic', 'edgeless'=>"Edgeless", 'wire' => 'Wire');  
      $this->prefs['gdpr_cookie_theme']['writeParms'] = $gdpr_cookie_theme;
			
			      
	    $gdpr_cookie_type = array('dismiss'=>"Just tell users that we use cookies", 'opt-out' => 'Let users opt out of cookies', 'opt-in'=>"Ask users to opt into cookies ");
		  $this->prefs['gdpr_cookie_type']['writeParms'] = $gdpr_cookie_type;      
		   /*   "position": "top",
		  "static": true, */ 
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
				


class gdpr_cookies_form_ui extends e_admin_form_ui
{
	// Custom Method/Function 
	function gdpr_cookie_type($curVal,$mode)
	{
		$frm = e107::getForm();	
    $size = e107::pref('gdpr_cookies', 'gdpr_cookie_type');	    
		switch($mode)
		{
    	case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
 			
 			
 			
      $text ="</div>";
			
			$text .="<div class='panel panel-default'>";	 
		  $text .="<div class='panel-heading '>  ";
		  $text .= $frm->radio('gdpr_cookie_type', 'only-tell', ($curVal == 'only-tell')) ;
	    $text .=" Just tell users that we use cookies  
			    </div>";
		  $text .="<div class='panel-body '>
							<p>You tell your users that you use cookies, and that by continuing to use your website they accept them.</p>
						</div>";
      $text .="</div>";			
			$text .="<div class='panel panel-default'>";	 
		  $text .="<div class='panel-heading '>  ";	
			$text .= $frm->radio('gdpr_cookie_type', 'opt-out', ($curVal == 'opt-out')) ;	
	    $text .=" Let users opt out of cookies (Advanced)   
			    </div>";
		  $text .="<div class='panel-body '>
						  You tell your users that you use cookies, and give them one button to disable cookies, and another to dismiss the message.  
						  <p class='text-danger'>You must modify your site for advanced options to work! </p>
						  <p class='text-danger'>See <a href='https://cookieconsent.insites.com/documentation/disabling-cookies/' target='_blank'>disabling cookies</a> </p>
						</div>";
      $text .="</div>";				
			$text .="<div class='panel panel-default'>";	 
		  $text .="<div class='panel-heading '>  ";			
	    $text .= $frm->radio('gdpr_cookie_type', 'opt-in', ($curVal == 'opt-in')) ;		
	    $text .=" Ask users to opt into cookies (Advanced)  
			    </div>";
		  $text .="<div class='panel-body '>
						 	<p>You tell your users that you wish to use cookies, and give them one button to enable cookies, and another to refuse them. </p>
						 	<p class='text-danger'>You must modify your site for advanced options to work! </p>
						  <p class='text-danger'>See <a href='https://cookieconsent.insites.com/documentation/disabling-cookies/' target='_blank'>disabling cookies</a> </p>
						</div>";
      $text .="</div>";				
 
 
      $text .= '</div>';          
      return $text;  	
			break;
			
			case 'filter':
			case 'batch':
 
			break;
		}
	}
}		
		
		
new gdpr_cookies_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>