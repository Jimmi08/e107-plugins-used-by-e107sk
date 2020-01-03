<?php

// Generated e107 Plugin Admin Area  1.1.2

require_once('../../../class2.php');
if (!getperms('P')) 
{
	header('location:'.e_BASE.'index.php');
	exit;
}

require_once("admin_menu.php");
require_once("../canonical.class.php");

//$config = e107::getPref('url_config');
// fixed all version for page

class canonical_config_adminArea extends canonical_adminArea
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'canonical_ui',
			'path' 			=> null,
			'ui' 			=> 'canonical_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
 
	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
 
}
 			
class canonical_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Canonical';
		protected $pluginName		= 'jm_canonical';
	//	protected $eventName		= 'canonical-canonical'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'canonical';
		protected $pid				= 'can_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
	//	protected $batchCopy		= true;		
	//	protected $sortField		= 'somefield_order';
	//	protected $orderStep		= 10;
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'can_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'can_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'can_table' =>   array ( 'title' => 'Table', 'type' => 'dropdown', 'data' => 'str', 'readonly'=>true, 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'can_pid' =>   array ( 'title' => 'Pid', 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'can_title' =>   array ( 'title' => LAN_TITLE, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'can_url' =>   array ( 'title' => LAN_URL, 'type' => 'url', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
 		 
       'can_url_test' =>   array ( 'title' => 'URL Check', 'type'=>'method', 
       'data' => false, 'width' => 'auto',   'help' => '', 'readParms' =>  array ( ),
		   'writeParms' =>  array (), 'class' => 'left', 'thclass' => 'left',  ), 
		'can_redirect' => array(
				'title' => 'Redirect',
				'type' => 'boolean',
				'data' => 'int',
				'width' => 'auto',
				'filter' => true,    'inline' => true,
				'help' => '',
				'readParms' => array() ,
				 'writeParms' => array(
					'size' => 'block-level',
					'post' => "<br><div class='label bg-info'>If this is set ON, then page will be redirect to Canonical URL </div>"
			 	),
				'class' => 'left',
				'thclass' => 'left',
			) ,       
       
       
      'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('can_table', 'can_pid', 'can_title', 'can_url_test');
		

	//	protected $preftabs        = array('General', 'Other' ); debug_frontend
		protected $prefs = array(
			'active'		=> array('title'=> 'Active', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'Help Text goes here'),
			'run_check'		=> array('title'=> 'Run check', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'Online check for 404 errors in Admin area. Could be slower with too much links. Be carefull.'),
      'debug_frontend'		=> array('title'=> 'Display Debug info on Frontend (only for main admins)', 
      'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'Very usefull to copy needed paths.'),
	 
	  'backslash'		=> array('title'=> 'Use backslash at the end of url with pretty urls', 
      'tab'=>0, 'type'=>'boolean', 'data' => 'str'),	  

		  'news_auto'		=> array('title'=> 'Auto Generated Links For News', 
      'tab'=>0, 'type'=>'dropdown', 'data' => 'str',
			'writeParms' => array('optArray' => array('none'=>"No Generated Links", 'sefurl'=>'Use e_REQUEST_URL', 'page'=>'Use e_PAGE + e_QUERY') )),			
			     
      'forum_thread_auto'		=> array('title'=> 'Auto Generated Links For Forum Topics', 
      'tab'=>0, 'type'=>'dropdown', 'data' => 'str',
			'writeParms' => array('optArray' => array('none'=>"No Generated Links",'legacy'=>'Use e_LEGACY_URL', 'sefurl'=>'Use e_REQUEST_URL') )),    
			  
      'page_auto'		=> array('title'=> 'Auto Generated Links For Pages', 
      'tab'=>0, 'type'=>'dropdown', 'data' => 'str', 
			'writeParms' => array('optArray' => array('none'=>"No Generated Links", 'sefurl'=>'Use e_REQUEST_URL', 'page'=>'Use e_PAGE + e_QUERY') )),                  
      
      'download_auto'		=> array('title'=> 'Auto Generated Links For Download plugin', 
      'tab'=>0, 'type'=>'dropdown', 'data' => 'str', 
			'writeParms' => array('optArray' => array('none'=>"No Generated Links", 'sefurl'=>'Use e_REQUEST_URL', 'page'=>'Use e_PAGE + e_QUERY') )),
 
		); 

	
		public function init()
		{
		  $this->postFiliterMarkup = $this->AddButton(); 
			//$this->fields['can_pid']['writeParms']['optArray'] = array('news'=>"News",'can_pid_1', 'can_pid_2'); // Example Drop-down array. 
			$this->fields['can_table']['writeParms']['optArray'] = array(
       'news'=>"News",
       'news_category'=>"News Category",
       'page'=>'Page', 
       'forum_thread'=>'Forum Thread' , 
			 'download_category'=>'Download category', 
       'download'=>'Download Item' ,          
       'pcontent'=>'Content plugin' ); // Example Drop-down array.
 
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data)
		{
        $table = $new_data['can_table'];
        $id = $new_data['can_pid']; 
  
	      // check double
	      if(e107::getDb()->count('canonical', '(*)', "can_table = '{$table}' AND can_pid={$id} "))
	      {
	        e107::getMessage()->addError('Record of table: '.$table.' with ID: '.$news_id.' already has Canonical URL. Check your ID.');
	        return false;
	      } 
	      
				if ($new_data['can_table'] == "news")
				{
				
					// check if news exists
				
					if ($related = e107::getDB()->retrieve($table, 'news_id, news_title', "news_id=" . $new_data['can_pid']))
					{
						e107::getMessage()->addInfo('You set Canonical URL for news with ID ' . $new_data['can_pid'] . " and title " . $related['news_title']);
						if ($new_data['can_title'] == '')
						{
							$new_data['can_title'] = $related['news_title'];
							e107::getMessage()->addInfo('Your title was generated from news title - you had left it empty');
						}
					}
					else
					{
						e107::getMessage()->addError('News with this ID doesn\'t exist. Check your ID. ');
						return false;
					}
				}
        if($new_data['can_table'] == "forum_thread" ) {   
           // check if news exists    
           if($related = e107::getDB()->retrieve($table, 'thread_id, thread_name' , "thread_id=".$new_data['can_pid']))
           {
            e107::getMessage()->addInfo('You set Canonical URL for forum topic with ID '.$new_data['can_pid']." and title ".$related['thread_name']);
           }
           else {
              e107::getMessage()->addError('Forum topic with this ID doesn\'t exist. Check your ID. ');
              return false;
           } 
        }        
         if($new_data['can_table'] == "page" ) {   
           // check if news exists    
           if($related = e107::getDB()->retrieve($table, 'page_id, page_title, menu_title' , "page_id=".$new_data['can_pid']))
           {
              e107::getMessage()->addInfo('You set Canonical URL for page with ID '.$new_data['can_pid']." and title ".$related['page_title']);

           }
           else {
              e107::getMessage()->addError('Page with this ID doesn\'t exist. Check your ID. ');
              return false;
           } 
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
        $table = $new_data['can_table'];
				$id = $new_data['can_pid'];    
        $canonical_id = $new_data['submit_value']; 
        
  
				if(empty($new_data['can_url'])) {
				    e107::getMessage()->addWarning('You left empty URL, your record will be ignored on frontend. If you edit page, this record will be deleted.');
				}          
	      // check double
	      if(e107::getDb()->count('canonical', '(*)', "can_table = '{$table}' AND can_pid={$id} AND can_id != {$canonical_id}"))
	      {
	        e107::getMessage()->addError('Record of table: '.$table.' with ID: '.$news_id.' already has Canonical URL. Check your ID.');
	        return false;
	      } 
	      
				if ($new_data['can_table'] == "news")
				{
				
					// check if news exists
				
					if ($related = e107::getDB()->retrieve($table, 'news_id, news_title', "news_id=" . $new_data['can_pid']))
					{
						e107::getMessage()->addInfo('You set Canonical URL for news with ID ' . $new_data['can_pid'] . " and title " . $related['news_title']);
						if ($new_data['can_title'] == '')
						{
							$new_data['can_title'] = $related['news_title'];
							e107::getMessage()->addInfo('Your title was generated from news title - you had left it empty');
						}
					}
					else
					{
						e107::getMessage()->addError('News with this ID doesn\'t exist. Check your ID. ');
						return false;
					}
				}
        if($new_data['can_table'] == "forum_thread" ) {   
           // check if news exists    
           if($related = e107::getDB()->retrieve($table, 'thread_id, thread_name' , "thread_id=".$new_data['can_pid']))
           {
               e107::getMessage()->addInfo('You set Canonical URL for forum topic with ID '.$new_data['can_pid']." and title ".$related['thread_name']);
               if($new_data['can_title'] == '') {
							     $new_data['can_title'] = $related['thread_name'];
							     e107::getMessage()->addInfo('Your title was generated from forum thread name - you had left it empty');
						   }
           }
           else {
              e107::getMessage()->addError('Forum topic with this ID doesn\'t exist. Check your ID. ');
              return false;
           } 
           
           if(substr($new_data['can_url'] , -1) != '/') {
						 e107::getMessage()->addError('Your URL for Forum Topic has to end with backslash because pagination.');				
						 return false;		
				 	 }
        }        
         if($new_data['can_table'] == "page" ) {   
           
           // check if news exists    
           if($related = e107::getDB()->retrieve($table, 'page_id, page_title, menu_title' , "page_id=".$new_data['can_pid']))
           {
							e107::getMessage()->addInfo('You set Canonical URL for page with ID '.$new_data['can_pid']." and title ".$related['page_title']);
							if($new_data['can_title'] == '') {
							     $new_data['can_title'] = $related['page_title'];
							     e107::getMessage()->addInfo('Your title was generated from page title - you had left it empty');
							}
							
           }
           else {
              e107::getMessage()->addError('Page with this ID doesn\'t exist. Check your ID. ');
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
			if($canonicalPlugin->getCanonicalRunCheck() )  
			{
				$text = "<span class='alert-danger '>Online Check is Active, it takes some time. Set it OFF</span><br>";
			}
			if($this->getAction() == "prefs") 
			{
				$text .= 'You can find more info about this plugin on <a href="https://www.e107sk.com/50/jm-canonical-plugin" target="_blank">e107.sk</a> 
					<br> You can support next development by visiting this site with AdBlock Off. Thank you.
					<br> We don\'t need your money, we need your feedback and activity. ';
			} 
			if($this->getAction() == "list") 
			{
					$text .= 'Related URLs are combination of table and record ID. Canonical URL is always the same for the same record. Just news for now';
			}
      
      
			return array('caption'=>$caption,'text'=> $text);

		}
		function AddButton()
	  	{
			$text .= "</fieldset></form><div class='e-container'>
			<table id='.$pid.' style='".ADMIN_WIDTH."' class='table adminlist table-striped'>";
			$text .=  
			'<a href="admin_config.php?mode=main&action=create"  
			class="btn batch e-hide-if-js btn-primary"><span>Add Canonical URL for Related URL</span></a>';
			$text .= "</td></tr></table></div><form><fieldset>";
			return $text;
    	}				
}
				


class canonical_form_ui extends e_admin_form_ui
{
   //canonical_url_test
  function can_url_test($curVal,$mode)
  {
    $canonicalPlugin = new Canonical; 
    
    if($mode == 'read')
  	{            
      if($canonicalPlugin->getCanonicalRunCheck() == false) {
         return "Check is OFF";
      }
    	$linkUrl = $this->getController()->getListModel()->get('can_url');	
      if(($canonical_url_test=file_get_contents($linkUrl))===false){
          // Retrieve HTTP status code
          list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
              
          $error_status = $canonicalPlugin->CanonicalStatus[$status_code];
          return $error_status;
      }
      else   return "OK";
     }
  }
}		
		
		
new canonical_config_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>