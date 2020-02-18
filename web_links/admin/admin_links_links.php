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
	
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'forced' => true,  'toggle' => 'e-multiselect' ),
			'lid'                     => array (  'title' => LAN_ID,  'data' => 'int',  'fieldpref' => '1',),
			'cid'                     => array (  'title' => LAN_CATEGORY,  'type' => 'dropdown',  'data' => 'int',  'batch' => true,  'inline' => true ),
			'sid'                     => array (  'title' => 'Sid',  'type' => 'number',  'data' => 'int',),
			'title'                   => array (  'title' => LAN_TITLE,  'type' => 'text',  'data' => 'str',  'filter' => true ),
			'url'                     => array (  'title' => LAN_URL,  'type' => 'url',  'data' => 'str',  'fieldpref' => '1',  'readParms' => 'target=blank',),
			'description'             => array (  'title' => LAN_DESCRIPTION,  'type' => 'textarea',  'data' => 'str',  'readParms' => 'expand=...&truncate=150&bb=1',  'writeParms' => 'size=block-level',),
			'date'                    => array (  'title' => LAN_DATESTAMP,  'type' => 'text',  'data' => 'str',  'filter' => true,  'fieldpref' => '1',  'nosort' => true,),
			'name'                    => array (  'title' => LAN_NAME,  'type' => 'text',  'data' => 'str',  'inline' => true,  'fieldpref' => '1',  'nosort' => true,),
			'email'                   => array (  'title' => LAN_EMAIL,  'type' => 'email',  'data' => 'str',  'inline' => true,),
			'hits'                    => array (  'title' => 'Hits',  'type' => 'number',  'data' => 'int',),
			'submitter'               => array (  'title' => 'Submitter',  'type' => 'text',  'data' => 'str',),
			'linkratingsummary'       => array (  'title' => 'Linkratingsummary',  'type' => 'number',  'data' => 'int',),
			'totalvotes'              => array (  'title' => 'Totalvotes',  'type' => 'number',  'data' => 'int',),
			'totalcomments'           => array (  'title' => 'Totalcomments',  'type' => 'number',  'data' => 'int',),
			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'forced' => true,  'fieldpref' => '1',),
		);		
		
		protected $fieldpref = array('lid', 'cid', 'title', 'url', 'date', 'name');

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
			class="btn batch e-hide-if-js btn-success"><span>'._ADD_CATEGORY.'</span></a>';
			$text .= "</td></tr></table></div><form><fieldset>";
			return $text;
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

