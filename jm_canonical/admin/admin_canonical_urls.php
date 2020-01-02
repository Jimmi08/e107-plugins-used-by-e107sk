<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

//e107::lan('jm_canonical');

require_once("admin_menu.php");
require_once("../canonical.class.php");



 
class canonical_urls_adminArea extends canonical_adminArea
{

	protected $modes = array(	
	
		'canonical_urls'	=> array(
			'controller' 	=> 'canonical_urls_ui',
			'path' 			=> null,
			'ui' 			=> 'canonical_urls_form_ui',
			'uipath' 		=> null
		),
 
	);	
 
  
		protected $menuTitle = 'Canonical URLs';
}




				
class canonical_urls_ui extends e_admin_ui
{
 
    protected $pluginTitle		= 'Canonical';
		protected $pluginName		= 'jm_canonical';
	//	protected $eventName		= 'test-canonical_urls'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'canonical_urls';
		protected $pid				= 'canonical_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'canonical_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		  'canonical_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'validate' => true, 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'canonical_url' =>   array ( 'title' => LAN_URL, 'type' => 'url', 'data' => 'str', 'width' => 'auto', 'filter' => true, 'inline' => true, 'validate' => true, 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ('size' =>'block-level' ),
		 'class' => 'left', 'thclass' => 'left',  ),
     
 		 'canonical_url_test' =>   array ( 'title' => 'URL Check', 'type'=>'method', 
       'data' => false, 'width' => 'auto',   'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array (), 'class' => 'left', 'thclass' => 'left',  ),    

 		  'canonical_url_inuse' =>   array ( 'title' => 'In Use', 'type'=>'method', 
       'data' => false, 'width' => 'auto',   'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array (), 'class' => 'left', 'thclass' => 'left',  ),  
          
		  'canonical_note' =>   array ( 'title' => 'Note', 'type' => 'textarea', 'data' => 'str', 'width' => 'auto', 'batch' => true, 'filter' => true, 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ('size' =>'block-level' ),
		 'class' => 'left', 'thclass' => 'left',  ),
 
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		);		
		
		protected $fieldpref = array('canonical_id', 'canonical_url', 'canonical_url_test', 'canonical_url_inuse', 'canonical_note');
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		); 

	

		public function init()
		{
       $this->postFiliterMarkup = $this->AddButton();
 		}

  		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			$sef = e107::getParser()->toDB($new_data['canonical_url']);
      if(e107::getDb()->count('canonical_urls', '(*)', "canonical_url='{$sef}'"))
      {
          e107::getMessage()->addError('Your Canonical URL already exists! It must be unique.');
          return false;
      }  
      
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
     
			$sef = e107::getParser()->toDB($new_data['canonical_url']);
      if($new_data['canonical_url'] != $old_data['canonical_url'])  {
        if(e107::getDb()->count('canonical_urls', '(*)', "canonical_url='{$sef}'"))
        {
            e107::getMessage()->addError('Your Canonical URL already exists! Change it to something else and make note about duplicate.');
            return false;
        }  
      }
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
      $canonicalPlugin = new Canonical; 
      if($canonicalPlugin->getCanonicalRunCheck() )  {
       $text = "<span class='alert-danger '>Online Check is Active, it takes some time. Set it OFF</span><br>";
      }
			$text .= 'Insert your desired form of canonical urls. Use only absolute URLs. Notes are only for internal purposes. You will be able to select canonical urls only from this list';
 
			return array('caption'=>$caption,'text'=> $text);

		}
 
		function AddButton()
	  {
      $text .= "</fieldset></form><div class='e-container'>
      <table id='.$pid.' style='".ADMIN_WIDTH."' class='table adminlist table-striped'>";
      $text .=  
      '<a href="admin_canonical_urls.php?mode=canonical_urls&action=create"  
      class="btn batch e-hide-if-js btn-primary"><span>Add Canonical URLs</span></a>';
      $text .= "</td></tr></table></div><form><fieldset>";
      return $text;
    }				
}
				


class canonical_urls_form_ui extends e_admin_form_ui
{
   
    //canonical_url_test
  function canonical_url_test($curVal,$mode)
  {     
    $canonicalPlugin = new Canonical; 
 
    if($mode == 'read')
  	{            
      if($canonicalPlugin->getCanonicalRunCheck() == false) {
         return "Check is OFF";
      }
    	$linkUrl = $this->getController()->getListModel()->get('canonical_url');	
      if(($canonical_url_test=file_get_contents($linkUrl))===false){
          // Retrieve HTTP status code
          list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
              
          $error_status = $canonicalPlugin->CanonicalStatus[$status_code];
          return $error_status;
      }
      else   return "OK";
     }
  }  
  
  function canonical_url_inuse($curVal,$mode)
  {
 
    if($mode == 'read')
  	{               
			$id = $this->getController()->getListModel()->get('canonical_id');
			if($in_use = e107::getDb()->count("canonical_request_urls","(*)",  "canonical_id=".$id)) 
      {
      return $in_use;
      }
      else return "Not used";
     }
  }   
   
}		
		
new canonical_urls_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>