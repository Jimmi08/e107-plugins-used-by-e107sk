<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('jmcore',true);

require_once("admin_menu.php");

class jmcore_adminArea extends jmcoremenu_adminArea
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'jmcore_ui',
			'path' 			=> null,
			'ui' 			=> 'jmcore_form_ui',
			'uipath' 		=> null
		),
	);	
 
	

}




				
class jmcore_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'JM Core';
		protected $pluginName		= 'jmcore';
	//	protected $eventName		= 'jmcore-'; // remove comment to enable event triggers in admin. 		
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
		 
		); 

 
 
		
		// left-panel help menu area. 
		public function renderHelp()
		{
			$caption = "Basic info";
			$text = 'Don\'t forget to rename github folder';
      
			return array('caption'=> $caption,'text'=> $text);

		}
 
		public function helpPage()
		{
			$ns = e107::getRender();
 
      include('../e_help.php');
      $text = '<div class="tab-content"><div class="tab-pane  active">'.$helplink_text['body'].'</div></div>';
			$ns->tablerender('',$text);	
			
		}
    			
}
				


class jmcore_form_ui extends e_admin_form_ui
{

}		
		
		
new jmcore_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>