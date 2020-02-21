<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}
 
require_once("admin_leftmenu.php");
            	
class web_links_ui extends e_admin_ui
{
			
		protected $pluginTitle		= '';
		protected $pluginName		= 'web_links';		
		protected $table			= 'links_links';
		protected $pid				= 'lid';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;
		protected $listOrder		= 'lid DESC';
	    //'sid'  'date'  'hits' 'submitter'   'linkratingsummary'  'totalvotes'    'totalcomments'
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'forced' => true,  'toggle' => 'e-multiselect' ),
			'lid'                     => array (  'title' => LAN_ID,  'data' => 'int', ),
			'title'                   => array (  'title' => _PAGETITLE,  'type' => 'text',  'data' => 'str',  
            'writeParms' => 'size=block-level', 'filter' => true ),
			'url'                     => array (  'title' => _PAGEURL,  'type' => 'url',  'data' => 'str',   'readParms' => 'target=blank', 
            'writeParms' => 'size=block-level',),
            'cid'                     => array (  'title' => LAN_CATEGORY,  'type' => 'dropdown',  'data' => 'int',  'batch' => true,  'inline' => true ),          
			'description'             => array (  'title' => _DESCRIPTION255,  'type' => 'textarea',  'data' => 'str',  
            'readParms' => 'expand=...&truncate=150&bb=1',  'writeParms' => 'size=block-level',),
			'name'                    => array (  'title' => LAN_NAME,  'type' => 'text',  'data' => 'str',  'inline' => true,   'nosort' => true,),
			'email'                   => array (  'title' => LAN_EMAIL,  'type' => 'email',  'data' => 'str',  'inline' => true,),        
			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'forced' => true, ),
		);		
		
		protected $fieldpref = array('lid', 'cid', 'title', 'url', 'date', 'name');

		public function __construct($request, $response, $params = array()) {

			//$action = $this->getRequest()->getAction();
			$action = $_GET['action'];
			$this->pluginTitle = _WEBLINKSADMIN;

			if($action == 'create') 
			{
				$this->pluginTitle .= ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._ADDNEWLINK;
			}

			parent::__construct($request, $response, $params = array());
		}
        
		public function init()
		{	
			$this->postFiliterMarkup = $this->AddButton();
			$rows = e107::getDb()->retrieve("links_categories", "*", true, true);
			$values[0] = '_NONE';
			foreach($rows AS $row) 
			{
				$values[$row['cid']] = $row['title'];
			}
			$this->fields['cid']['writeParms']['optArray'] = $values ; 
		}

        function AddButton()
		{
			$mode = $this->getRequest()->getMode();	
			$text .= "</fieldset></form><div class='e-container'>
			<table id='.$pid.' style='".ADMIN_WIDTH."' class='table adminlist table-striped'>";
			$text .=  
			'<a href="'.e_SELF.'?mode='.$mode.'&action=create"  
			class="btn batch e-hide-if-js btn-success"><span>'._ADDNEWLINK.'</span></a>';
			$text .= "</td></tr></table></div><form><fieldset>";
			return $text;
	   }
       
       public function beforeCreate($new_data)
	   {
         print_a($new_data);
         $sql = e107::getDb();
         //check if link exists
         $url = $new_data['url'];    print_a($url);
         $numrows = $sql->retrieve("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE url='".addslashes($url)."'");
         if ($numrows > 0) {
            e107::getMessage()->addError(_ERRORURLEXISTWL);
            return false;
         }
         /* Check if Title exist */
         if ($new_data['title']=="") {
            e107::getMessage()->addError(_ERRORNOTITLEWL);
            return false;
         }
         /* Check if URL exist */
         if ($new_data['url']=="") {
            e107::getMessage()->addError(_ERRORNOURLWL);
            return false;
         }         
         /* Check if Description exist */
         if ($new_data['description']=="") {
            e107::getMessage()->addError(_ERRORNODESCRIPTIONWL);
            return false;
         }         
       }
       
}  


class web_links_form_ui extends e_admin_form_ui
{

}				
		
new leftmenu_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();
 
require_once(e_ADMIN."footer.php");
exit;

