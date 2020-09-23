<?php
 
require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('yandex_turbopages',true);
require_once("admin_menu.php");
 
 
if(e_PAGE=="admin_entites.php") {
	e107::js('footer',  e_PLUGIN."yandex_turbopages/js/bootstrap-notify.min.js", 'jquery');
	e107::js('footer',  e_PLUGIN."yandex_turbopages/js/yandex_turbopages-admin.js", 'jquery');
} 
         

class ytp_entites_adminArea extends yandex_turbopages_adminArea
{
	protected $modes = array(	
		'page'	=> array(
			'controller' 	=> 'yandex_turbopages_ui',
			'path' 			=> null,
			'ui' 			=> 'yandex_turbopages_form_ui',
			'uipath' 		=> null
		),     
	);		
}


 

class yandex_turbopages_ui extends e_admin_ui
{
 	protected $pluginTitle		= LAN_PLUGIN_YTP_NAME;
	protected $pluginName		= 'yandex_turbopages';
	protected $eventName		= "yandex_turbopages"; // remove comment to enable event triggers in admin. 		
 	protected $perPage			= 30; 
	protected $batchDelete		= false;
	protected $batchExport     = true;
	protected $batchCopy		= false;
 
    /* just to be sure not mess properties names */
    public $jmtable;
    public $jmplugin;
    public $jmtableid;
 
	protected $tabs				= array('Overview'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 

	
	protected $fields = array(
		'checkboxes' => array(
			'title' => '',
			'type' => null,
			'data' => null,
			'width' => '5%',
			'thclass' => 'center',
			'forced' => '1',
			'class' => 'center',
			'toggle' => 'e-multiselect',
			'readParms' => array() ,
			'writeParms' => array() ,
		) ,
	);		
 
	//	protected $preftabs        = array('General', 'Other' );
	protected $prefs = array(); 

	public function init()
		{
      	$mode = $this->getRequest()->getMode();
      	switch ($mode)
  			{     
				case "page" :
					$this->jmtable =   "page";
					$this->jmplugin = 'page';
					$this->jmtableid    = 'page_id';
					$this->jmtabletitle = 'page_title';
					$this->jmpublished = 'page_datestamp';
					$this->jmaccess = 'page_class';
					$this->jmwhere = ' WHERE page_title != ""  ';
				break;       
				default: 
				break;
      		}
      
      	/* set special options */
		$this->fields[$this->jmtableid] = array(
			'title' => LAN_PLUGIN_YTP_RECORD_ID,
			'data' => 'int',
			'width' => '5%',
			'help' => '',
			'tab' => 0,
			'readParms' => array() ,
			'writeParms' => array()
		); 
     
		$this->fields[$this->jmtabletitle] = array(
			'title' => LAN_PLUGIN_YTP_RECORD_TITLE,
			'type' => 'text',
			'data' => 'str',
			'width' => 'auto',
			'tab' => 0,
			'help' => '',
			'readParms' => array() ,
			'writeParms' => array() ,
			'class' => 'left',
			'thclass' => 'left',
		);

		$this->fields[$this->jmpublished] = array(
			'title' => LAN_DATE,
			'tab' => 1,
			'type' => 'datestamp',
			'data' => 'int',
			'width' => 'auto',
			'writeParms' => 'auto=1&type=datetime'
		);
		$this->fields[$this->jmaccess] = array(
			'title' => LAN_VISIBILITY,
			'tab' => 1,
			'type' => 'userclass',
			'data' => 'str',
			'inline' => true,
			'width' => 'auto',
			'filter' => true,
			'batch' => false,
			'noedit' => true
		);
								
			 
		$this->fields['tb_include'] = array(
			'title' => LAN_PLUGIN_YTP_INCLUDE_IN_TP,
			'width' => 'auto',
			'type' => 'method',
			'readParms' => array() ,
			'method' => 'tb_include',
			'data' => false,
			'tab' => 1,
			'noedit' => false
		);

		$readParms =  'table='.$this->jmtable;
		$this->fields['options'] = array(
			'title' => LAN_OPTIONS,
			'type' => 'method',
			'width' => '10%',
			'forced' => TRUE,
			'thclass' => 'center last',
			'class' => 'left',
			'readParms' => $readParms
		);

		/* set listry */
		$this->table        	= $this->jmtable;
		$this->pid	        = $this->jmtableid;
		$this->listOrder		= $this->jmtableid . ' DESC' ;
      
		// this is ignored by e_admin  workaround
		// $this->eventName		= "yandex_turbopages_".$this->jmtable; // remove comment to enable event triggers in admin.
   
      	$this->listQry      = "SELECT rt.*,c.*  FROM #{$this->table} AS rt 
			LEFT JOIN #yandex_turbopages AS c  ON   c.entity_type='{$this->table}' AND c.entity_id= rt.{$this->jmtableid}  {$this->jmwhere}";
 
 
      	$this->fieldpref = array($this->jmtableid, $this->jmtabletitle, $this->jmpublished, $this->fields[$this->jmaccess], 'tb_include'   );

      	// Modal
		$text .= "
		<div id='modal-canurl-delete' class='modal fade'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
						<h4 class='modal-title'> ".LAN_PLUGIN_YTP_LAN_001." </h4>
					</div>
					<div class='modal-body'>
						<p><span class='fa fa-exclamation-triangle'></span>".LAN_PLUGIN_YTP_LAN_002."</p>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>".LAN_PLUGIN_YTP_LAN_003."</button>
						<button type='button' class='btn btn-danger'>".LAN_PLUGIN_YTP_LAN_004."</button>
					</div>
				</div>
			</div>
		</div>
		";

 
		$this->postFiliterMarkup = $text.$this->GenerateButton(); 
			} 
			
			public function BeforeDelete($data, $id)
			{
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
		
		
		function GenerateButton()
		{
		$text .= "</fieldset></form><div class='e-container'>
		<table id='.$pid.' style='".ADMIN_WIDTH."' class='table adminlist table-striped'>";
		$text .=  
		"<button id='addall_ytp' type='button' table='".$this->jmtable ."' idName='".$this->jmtableid."' class='btn btn-primary' ".$disabled.">".LAN_PLUGIN_YTP_ADD_ALL."</button></div>";       
		$text .= 
		"<button id='deleteall_ytp' type='button' table='".$this->jmtable ."' idName='".$this->jmtableid."' class='btn btn-danger' ".$disabled.">".LAN_PLUGIN_YTP_REMOVE_ALL."</button></div>";
		$text .= "</td></tr></table></div><form><fieldset>";
		return $text;
		}
    
}


class yandex_turbopages_form_ui extends e_admin_form_ui
{
	function tb_include($curval,$mode, $att)
	{
		if($mode == 'read')
		{
			$field = $att['field'];

			if($this->getController()->getAction() == 'list')
			{
				$data =  $this->getController()->getListModel()->get($field); // ($att['field']);
				if($data) {
				  $data = "<i class=' text-success fa  fa-check fa-2x'></i>";
				}
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
		} 
	}  

	// Override the default Options field. 
	function options($parms, $value, $id, $attributes)
	{
	if (!$parms['table'])
		{
		return '';
		}

	$tp = e107::getParser();
	$frm = e107::getForm();
	$editIconDefault = $tp->toGlyph('fa-edit');
	$table = $parms['table'];
	if ($attributes['mode'] == 'read')
		{
		$text = "<div class='btn-group'>";
		//parse_str(str_replace('&amp;', '&', e_QUERY) , $query); //FIXME - FIX THIS - 	not used anymore?

		// keep other vars in tact
		$text.= $value;
		if (e107::getDb()->count('yandex_turbopages', '(*)', "entity_type = '{$table}' AND entity_id={$id} "))
			{
				$value ="<button type='button' table='".$table ."' tableid='".$id."' 
				title='Remove as TurboPage'
				class='btn btn-danger remove_turbopage' ".$disabled."><i class='fa fa-minus'></i></button></div>"; 
				$text .= $value  ;
			}
		else {
				$value ="<button type='button' table='".$table ."' tableid='".$id."' 
				title='Add as TurboPage'
				class='btn btn-primary add_turbopage' ".$disabled."><i class='fa fa-plus'></i></div>";
				$text .= $value  ;
			}
		$text .= "</div>";
		return $text;
		}
	}

}		
		
		
new ytp_entites_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>