<?php


// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('test',true);
require_once("admin_menu.php");
require_once("../canonical.class.php");

 
if(e_PAGE=="admin_canonical.php") {

// e107::js('jm_canonical',  "js/bootstrap-growl.min.js", 'jquery');
 
 //e107::js('footer', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js');
 
 e107::js('footer',  e_PLUGIN."jm_canonical/js/bootstrap-notify.min.js", 'jquery');
 
 e107::js('footer',  e_PLUGIN."jm_canonical/js/jm_canonical-admin.js", 'jquery');
 
} 
 

class jm_canonical_adminArea extends canonical_adminArea
{

	protected $modes = array(	
	
		'pcontent'	=> array(
			'controller' 	=> 'jm_canonical_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_canonical_form_ui',
			'uipath' 		=> null
		),
		'download'	=> array(
			'controller' 	=> 'jm_canonical_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_canonical_form_ui',
			'uipath' 		=> null
		),
		'forumthread'	=> array(
			'controller' 	=> 'jm_canonical_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_canonical_form_ui',
			'uipath' 		=> null
		),    
		'page'	=> array(
			'controller' 	=> 'jm_canonical_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_canonical_form_ui',
			'uipath' 		=> null
		),     
		'downloadcategory'	=> array(
			'controller' 	=> 'jm_canonical_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_canonical_form_ui',
			'uipath' 		=> null
		),       
		'news'	=> array(
			'controller' 	=> 'jm_canonical_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_canonical_form_ui',
			'uipath' 		=> null
		),    		
		'newscategory'	=> array(
			'controller' 	=> 'jm_canonical_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_canonical_form_ui',
			'uipath' 		=> null
		),  
	);	

	
	protected $menuTitle = 'JM Canonical';
}


 

class jm_canonical_ui extends e_admin_ui
{
 		protected $pluginTitle		= 'JM Canonical';
		protected $pluginName		= 'jm_canonical';
	  protected $eventName		= "jm_canonical"; // remove comment to enable event triggers in admin. 		
 
		protected $perPage			= 30; 
		protected $batchDelete		= false;
		protected $batchExport     = true;
		protected $batchCopy		= false;
 
    /* just to be sure not mess properties names */
    public $jmtable;
    public $jmplugin;
    public $jmtableid;
    
	//
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	 	protected $tabs				= array('Overview'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 

	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 
     'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
 
 
		);		
 
	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		); 

		public function init()
		{

      $mode = $this->getRequest()->getMode();

      
      switch ($mode)
  		{
  		case "pcontent" :
      $this->jmtable =   "pcontent";
      $this->jmplugin     = 'content';
      $this->jmtableid    = 'content_id';
      $this->jmtabletitle = 'content_heading';
 
      
      
      break;
      
  		case "download" :
      $this->jmtable =   "download";
      $this->jmplugin = 'download';
      $this->jmtableid    = 'download_id';
      $this->jmtabletitle = 'download_name';
 
 
      break; 
      
      case "downloadcategory" :
      $this->jmtable =   "download_category";
      $this->jmplugin = 'download';
      $this->jmtableid    = 'download_category_id';
      $this->jmtabletitle = 'download_category_name';
      break;    
 
  		case "forumthread" :
      $this->jmtable =   "forum_thread";
      $this->jmplugin = 'forum';
      $this->jmtableid    = 'thread_id';
      $this->jmtabletitle = 'thread_name';
      break; 
      
  		case "news" :
      $this->jmtable =   "news";
      $this->jmplugin = 'news';
      $this->jmtableid    = 'news_id';
      $this->jmtabletitle = 'news_title';
      break;
 
  		case "newscategory" :
      $this->jmtable =   "news_category";
      $this->jmplugin = 'news';
      $this->jmtableid    = 'category_id';
      $this->jmtabletitle = 'category_name';
      break;
                 
      case "page" :
      $this->jmtable =   "page";
      $this->jmplugin = 'page';
      $this->jmtableid    = 'page_id';
      $this->jmtabletitle = 'page_title';
      break;
       
      default: 
 
      break;
      }
      
      /* set special options */

		$this->fields[$this->jmtableid]  =   array ( 'title' => 'Record ID', 'data' => 'int', 'width' => '5%', 'help' => '',   'tab'=>0,  'readParms' =>  array ( ),
		 'writeParms' =>  array ( )); 
     
    $this->fields[$this->jmtabletitle]  =  array ( 'title' => 'Record title', 'type' => 'text', 'data' => 'str', 'width' => 'auto',    'tab'=>0,
      'help' => '', 'readParms' =>  array ( ), 'writeParms' =>  array ( ),  'class' => 'left', 'thclass' => 'left',  );  
 
		$this->fields['can_url'] = array('title' => 'Canonical URL' ,'width' => 'auto', 'type'=>'method', 
   'readParms'=>array( ), 'method'=>'canonical_fields', 'data'=>false, 
   'tab'=>1, 'noedit'=>false);
    
		$this->fields['can_title'] = array('title' => 'Can. Title' ,'width' => 'auto', 'type'=>'method', 
   'readParms'=>array( ), 'method'=>'canonical_fields', 'data'=>false, 
   'tab'=>1, 'noedit'=>false);

		$this->fields['can_redirect'] = array('title' => 'Redirect' ,'width' => 'auto', 'type'=>'boolean', 
   'readParms'=>array( ),  'data'=>false,  
   'tab'=>1, 'noedit'=>false); 	
      
      $readParms =  'table='.$this->jmtable;
      $this->fields['options'] 	=  array('title'=> LAN_OPTIONS,				'type' => 'method',			'width' => '10%',
       'forced'=>TRUE, 'thclass' => 'center last', 'class' => 'left', 'readParms'=>$readParms);
       
   
 
       
      /* set listry */
      $this->table        = $this->jmtable;
      $this->pid	        = $this->jmtableid;
      $this->listOrder		= $this->jmtableid . ' DESC' ;
      
   // this is ignored by e_admin  workaround
   // $this->eventName		= "jm_canonical_".$this->jmtable; // remove comment to enable event triggers in admin.
   
      $this->listQry      = "SELECT rt.*,c.*  FROM #{$this->table} AS rt LEFT JOIN #canonical AS c  ON   c.can_table='{$this->table}' AND c.can_pid= rt.{$this->jmtableid}";
 
  
      $this->fieldpref = array($this->jmtableid, $this->jmtabletitle, 'can_url' , 'can_title', 'can_redirect' );
      /* check if plugin is installed   sometimes it doesn't work
      if($this->jmplugin)  {
        $iscontentinstalled = e107::isInstalled($this->jmplugin);
      
        if(!$iscontentinstalled)  {
       
               $mes = e107::getMessage();
               $mes->addError("Plugin {$this->jmplugin} is not installed");
               echo $mes->render();
              
        }
      }
      */
         
      // Modal
$text .= "
<div id='modal-canurl-delete' class='modal fade'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				<h4 class='modal-title'> Confirm Deletion of Canonical URL </h4>
			</div>
			<div class='modal-body'>
				<p><span class='fa fa-exclamation-triangle'></span>Canonical URL will be permanently deleted and cannot be recovered. Are you sure?</p>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
				<button type='button' class='btn btn-danger'>Delete Canonical URL</button>
			</div>
		</div>
	</div>
</div>
";

$this->postFiliterMarkup = $text.$this->GenerateButton(); 
		} 
		
		public function BeforeDelete($data, $id)
		{
      /* it delete canonical ulr record */
 
 
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
		// left-panel help menu area. 
		public function renderHelp()
		{   
			$caption = LAN_HELP;
 
			$text .= 'Canonical URLs ';
 
      
      
			return array('caption'=>$caption,'text'=> $text);

		}
    
		function GenerateButton()
	  {
      $text .= "</fieldset></form><div class='e-container'>
      <table id='.$pid.' style='".ADMIN_WIDTH."' class='table adminlist table-striped'>";
      $text .=  
      "<button id='generate_canurl' type='button' table='".$this->jmtable ."' idName='".$this->jmtableid."' class='btn btn-primary' ".$disabled.">Generate All</button></div>";       
       $text .= 
      "<button id='deleteall_canurl' type='button' table='".$this->jmtable ."' idName='".$this->jmtableid."' class='btn btn-danger' ".$disabled.">Delete All</button></div>";
      $text .= "</td></tr></table></div><form><fieldset>";
      return $text;
    }	
    
    
}

				
 			


class jm_canonical_form_ui extends e_admin_form_ui
{
 
 
  
	function canonical_fields($curval,$mode, $att)
	{
		if($mode == 'read')
		{
			$field = $att['field'];

			if($this->getController()->getAction() == 'list')
			{
				$data =  $this->getController()->getListModel()->get($field); // ($att['field']);
			}
			else
			{
				$data =  $this->getController()->getModel()->get($field); // ($att['field']);
			}
 


			return $data;

		}
		if($mode == 'write')
		{
      return '';
			// e107::getUserExt()->user_extended_edit
		//	return 'hello';
	/*		$field = $att['field'];
			$extData = $this->getController()->getExtended();
			$extData[$field]['user_extended_struct_required'] = 0;

			return e107::getUserExt()->user_extended_edit($extData[$field],$curval);
                                       */
		//	return print_a($att,true);
		}


	}  
  
  function content_parent($curVal,$mode)
  {
    $frm = e107::getForm(false, true); //enable inner tabindex counter
    $sql = e107::getDb();
    $text = '';
    if($mode == 'read')
  	{   $data_row = $this->getController()->getListModel()->getData(); 
  	    $parent = $data_row['content_parent'];
        if($parent == 0)  {
          $text = 'Main category';
          
        }
        else {
        if(strpos($data_row['content_parent'], ".")){
					$newid = substr($data_row['content_parent'],2);
				  $text = "Subcategory of: <br>";
        }else{
					$newid = $data_row['content_parent'];
				}
        $text .= $sql->retrieve("pcontent", "content_heading", " content_id='".intval($newid)."' "); 
  
        } 
        
        return $text;
    }
			
  }  
  
  
 
		// Override the default Options field. 
	function options($parms, $value, $id, $attributes)
	{
    if(!$parms['table']) { return ''; }
 
    $tp = e107::getParser();
    $frm = e107::getForm();
		$editIconDefault =   $tp->toGlyph('fa-edit');
    $table  = $parms['table'];
    
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
      // delete canonical url
      if (e107::getDb()->count('canonical', '(*)', "can_table = '{$table}' AND can_pid={$id} "))
    	{
      $value ="<button type='button' table='".$table ."' tableid='".$id."' class='btn btn-danger delete_canurl' ".$disabled."><i class='fa fa-trash-o'></i></button></div>"; 
      $text .= $value  ;
      }
      else {
      $value ="<button type='button' table='".$table ."' tableid='".$id."' class='btn btn-primary create_canurl' ".$disabled.">Generate</button></div>";
      $text .= $value  ;
      }
			$text .= "</div>";
			return $text;
		}
	}

}		
		
		
new jm_canonical_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>