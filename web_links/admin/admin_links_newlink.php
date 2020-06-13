<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}
 
require_once("admin_leftmenu.php");
 

            	
class web_links_ui extends plugin_admin_ui
{
			
		protected $pluginTitle		= '';
		protected $pluginName		= 'web_links';
		//	protected $eventName		= 'web_links-links_newlink'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'links_newlink';
		protected $pid				= 'lid';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

		//	protected $sortField		= 'somefield_order';
		//	protected $sortParent      = 'somefield_parent';
		//	protected $treePrefix      = 'somefield_title';

		//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
			
		//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'lid DESC';
	
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'forced' => true,  'toggle' => 'e-multiselect',  'fieldpref' => '1',),

			'lid'                     => array (  'title' => 'Lid',  'data' => 'int',),
            
            'submitter'               => array (  'title' => _SUBMITTER,  'type' => 'text',  'data' => 'str',),
                        
			'title'                   => array (  'title' => _PAGETITLE,  'type' => 'text',  'data' => 'str',  
                'inline' => true,  'filter' => true,   'writeParms' => 'size=block-level',),            
            'url'                     => array (  'title' => _PAGEURL,  'type' => 'url',  'data' => 'str',  
                'inline' => true,  'readParms' => 'target=blank',  'writeParms' => 'size=block-level' ),
            
            'cid'                     => array (  'title' => LAN_CATEGORY,  'type' => 'dropdown',  'data' => 'int',  'batch' => true, 
                'inline' => true ),
            
			'sid'                     => array (  'title' => _SUBCATEGORY,  'type' => 'dropdown',  'data' => 'int',  'batch' => true  ),
	
            'description'             => array (  'title' => LAN_DESCRIPTION,  'type' => 'textarea',  'data' => 'str',  'readParms' => 'expand=...&truncate=150&bb=1',  'writeParms' => 'size=block-level',),
			
            'name'                    => array (  'title' => LAN_NAME,  'type' => 'text',  'data' => 'str',  'inline' => true,  'fieldpref' => '1',),
			
            'email'                   => array (  'title' => LAN_EMAIL,  'type' => 'email',  'data' => 'str',  'inline' => true,),

			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => 'method',  'data' => null,  'forced' => true,  'fieldpref' => '1',),
		);		
		
		protected $fieldpref = array('title', 'name');
		
        
		public function __construct($request, $response, $params = array()) {

			//$action = $this->getRequest()->getAction();
			$action = $_GET['action'];
			$this->pluginTitle = _WEBLINKSADMIN;

			if($action == 'edit') 
			{
				$this->pluginTitle .= ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._LINKVALIDATION;
			}

			parent::__construct($request, $response, $params = array());
		}
	
		public function init()
		{       
 
			$rows = e107::getDb()->retrieve("links_categories", "*", "WHERE parentid = 0 ", true);
			$values[0] = '_NONE';
			foreach($rows AS $row) 
			{
				$values[$row['cid']] = $row['title'];
			}
			$this->fields['cid']['writeParms']['optArray'] = $values ;   
            
            $values = array();
            
            $rows = e107::getDb()->retrieve("links_categories", "*", "WHERE parentid != 0 ", true);
			$values[0] = '_NONE';
			foreach($rows AS $row) 
			{
				$values[$row['cid']] = $row['title'];
			}
        	$this->fields['sid']['writeParms']['optArray'] = $values ; 
            	
		}
}  

class web_links_form_ui extends e_admin_form_ui
{
	/**
	 * Override the default Options field.
	*
	* @param $parms
	* @param $value
	* @param $id
	* @param $attributes
	*
	* @return string
	*/
	function options($parms, $value, $id, $attributes)
	{
	$text = '';
	if($attributes['mode'] == 'read')
	{

		//approve button, prepared, not used, too complicated
		$approve = '';

		$text = "<div class='btn-group'>";
		$text .= $approve;
		$text .= $this->renderValue('options',$value,$att,$id);
		//or here
		$text .= "</div>"; 
	} 
	return $text;
	} 

}		
		
		
new leftmenu_adminArea();

require_once(e_ADMIN."auth.php");
e107::getRender()->tablerender('', AdminHeader());
e107::getAdminUI()->runPage();
require_once(e_ADMIN."footer.php");
exit;

