<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('jm_canonical', true);

require_once("admin_menu.php");

// to be sure it is loaded only on this admin page
if(e_PAGE=="admin_request_urls.php") {
 
 e107::js('footer',  e_PLUGIN."jm_canonical/js/bootstrap-notify.min.js", 'jquery');
 
 e107::js('footer',  e_PLUGIN."jm_canonical/js/jm_canonical-admin.js", 'jquery');
 
}

class request_urls_adminArea extends canonical_adminArea
{

	protected $modes = array(	
	
		'request_urls'	=> array(
			'controller' 	=> 'canonical_request_urls_ui',
			'path' 			=> null,
			'ui' 			=> 'canonical_request_urls_form_ui',
			'uipath' 		=> null
		),
		

	);		
}

class canonical_request_urls_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Canonical';
		protected $pluginName		= 'jm_canonical';
	//	protected $eventName		= 'jm_canonical_request_urls'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'canonical_request_urls';
		protected $pid				= 'canru_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'canru_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		  'canru_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'validate' => true, 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'canru_url' =>   array ( 'title' => 'e_ REQUEST _URL', 'type' => 'url', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'validate' => true, 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ('size' =>'block-level' ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'canonical_id' =>   array ( 'title' => 'Canonical URL', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'batch' => true, 'filter' => true, 'inline' => true, 'validate' => true, 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ('size' =>'xxlarge' ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'canru_note' =>   array ( 'title' => 'Note', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 	'class' => 'left', 'thclass' => 'left',  ),
			'canru_redirect' => array(
				'title' => 'Redirect',
				'type' => 'boolean',
				'data' => 'int',
				'width' => 'auto',
				'filter' => true,    'inline' => true,
				'help' => '',
				'readParms' => array() ,
				 'writeParms' => array(
					'size' => 'block-level',
					'post' => "<br><div class='label bg-info'>If this is set ON, then page will be redirect to Canonical URL with 301 (Moved Permanently)</div>"
			 	),
				'class' => 'left',
				'thclass' => 'left',
			) ,
  
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		);		
		
		protected $fieldpref = array('canru_id', 'canru_url', 'canonical_id', 'canru_note');

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		); 


    public function init()
	{
		// Set drop-down values (if any). 
		//$this->fields['game_category']['writeParms']['optArray'] = array('game_category_0','game_category_1', 'game_category_2'); // Example Drop-down array. 
		$sql = e107::getDb();
		if($sql->select('canonical_urls'))
		{
			while ($row = $sql->fetch())
			{
				$this->canonical_urls[$row['canonical_id']] = $row['canonical_url'];
			}
		}
		$this->fields['canonical_id']['writeParms'] = $this->canonical_urls;	
		
		$this->postFiliterMarkup =  $this->CustomButtons(); 

      	$readParms =  'table='.$this->table;
     	$this->fields['options'] 	=  array(
											'title'=> LAN_OPTIONS,
											'type' => 'method',
											'width' => '10%',
											'forced'=>TRUE,
											'thclass' => 'center last',
											'class' => 'left',
											'readParms'=>$readParms);

	}
				
		
	// left-panel help menu area. 
	public function renderHelp()
	{
		$caption = LAN_HELP;
		$text .= 'Here you can connect any of your site urls with canonicals urls you had set above. Most know double content: /index.php, news.php etc '; 

		return array('caption'=>$caption,'text'=> $text);

	}

	function CustomButtons()
	{
		$text = "</fieldset></form><div class='e-container'>
		<table id='custombuttons' style='".ADMIN_WIDTH."' class='table adminlist table-striped'>";
		$text .=  
		'<a href="admin_request_urls.php?mode=request_urls&action=create"  
		class="btn batch e-hide-if-js btn-success"><span>'.LAN_JM_CANONICAL_03.'</span></a>';
		
		$redirect_installed = e107::isInstalled('aredirection');
		$canru_redirect = e107::getDb()->retrieve('canonical_request_urls', 'canru_redirect', 'canru_redirect = 1 ');
	
		$disabled = "disabled";
		if($redirect_installed && $canru_redirect )  {    
			$disabled = " ";
		} 
		$text .= 
		"<button id='moveall_toredirection' type='button' table='canonical_request_urls' idname='canru_id' class='btn btn-primary ".$disabled." ' >".LAN_JM_CANONICAL_04."</button></div>";

		$text .= "</td></tr></table></div><form><fieldset>";
		return $text;
	}		
			
}

class canonical_request_urls_form_ui extends e_admin_form_ui
{
	function options($parms, $value, $id, $attributes)
	{
    	if(!$parms['table']) { return ''; }
 
		$tp = e107::getParser();
		$frm = e107::getForm();
		$editIconDefault =   $tp->toGlyph('fa-edit');
    	$table  = $parms['table'];

    	$redirect_installed = e107::isInstalled('aredirection');
     
		if($attributes['mode'] == 'read')
		{
			$text = "<div class='btn-group'>";
      
      		parse_str(str_replace('&amp;', '&', e_QUERY), $query); //FIXME - FIX THIS
			// keep other vars in tact
			$query['action'] = 'edit';
			$query['id'] = $id;
			$query = http_build_query($query, null, '&amp;');
			$value .= "<a href='".e_SELF."?{$query}' class='btn btn-success' title='".LAN_EDIT."' 
      		data-toggle='tooltip' data-placement='left'>
			".$editIconDefault."</a>";      
      
			$text .= $value;
      
      		$text .= $this->submit_image('etrigger_delete['.$id.']', $id, 'delete', LAN_DELETE.' [ ID: '.$id.' ]', 
      		array('class' => 'action delete btn btn-danger',
      		'icon'=> '<i class="fa fa-trash-o"></i>'));
 
			//display Move button only if old redirection is used
			if($redirect_installed) {
				$canru_redirect = e107::getDb()->retrieve($table, 'canru_redirect', 'canru_id ='.$id);
				if($canru_redirect)  {    
				$value ="<button type='button' table='".$table ."' tableid='".$id."' class='btn btn-primary move_toredirection' ".$disabled.">Move</button></div>";
				$text .= $value  ;
				}
			}
			$text .= "</div>";
			return $text;
		}  
    
	}
  
  
}		
		
		
new request_urls_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>