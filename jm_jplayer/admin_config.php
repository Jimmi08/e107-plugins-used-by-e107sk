<?php

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('jm_jplayer',true,true);

e107::css('inline', "

.help-table td { padding:7px 0; }
td.chars { padding-right:15px; border-right:1px solid black }
.toggle-icon { cursor: pointer }
td.lan-odd { background-color: rgba(255,255,255,0.05); }

");

class jm_jplayer_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'jm_jplayer_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_jplayer_form_ui',
			'uipath' 		=> null
		),
		

		'cat'	=> array(
			'controller' 	=> 'jm_jplayer_playlists_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_jplayer_playlists_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(

		'main/list'			=> array('caption'=> LAN_JPLAYER_ADMMENU_03, 'perm' => 'P'),
		'main/create'		=> array('caption'=> LAN_JPLAYER_ADMIN_37, 'perm' => 'P'),

		'cat/list'			=> array('caption'=> LAN_JPLAYER_ADMMENU_01, 'perm' => 'P'),
		'cat/create'		=> array('caption'=> LAN_JPLAYER_ADMIN_04, 'perm' => 'P'),
		
		'main/prefs' 		=> array('caption'=> LAN_JPLAYER_ADMMENU_02, 'perm' => 'P'),
		
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'Wolf jPlayer';
}
				
class jm_jplayer_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Wolf jPlayer';
		protected $pluginName		= 'jm_jplayer';
		protected $table			= 'jm_jplayer';
		protected $pid				= 'id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
  	    protected $batchCopy		= true;		
		protected $listOrder		= 'id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'id' =>   array ( 'title' => LAN_ID, 'type' => 'number', 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'playlist_id' =>   array ( 'title' => LAN_JPLAYER_ADMIN_07, 'type' => 'dropdown', 'data' => 'int', 'width' => '15%', 
			  'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),		  
		  'name' =>   array ( 'title' => LAN_JPLAYER_ADMIN_39, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'validate' => true, 
					'filter' => true, 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'artist' =>   array ( 'title' => LAN_JPLAYER_ADMIN_40, 'type' => 'text', 'inline' => true, 'data' => 'str', 'width' => 'auto', 'help' => '', 
				'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
 		  'poster' =>   array ( 'title' => LAN_JPLAYER_ADMIN_47, 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'help' => '', 
					'readParms' => 'thumb=120x50', 'writeParms' => 'media=jm_jplayer',  'class' => 'left', 'thclass' => 'left',  ),							  
		  'mp3' =>   array ( 'title' => LAN_JPLAYER_ADMIN_41, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '',    'inline' => true,
				'writeParms' => array('size' => 'block-level'), 'class' => 'left', 'thclass' => 'left',  ),
		  'itunes' =>   array ( 'title' => LAN_JPLAYER_ADMIN_48, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 
			  'writeParms' => array('size' => 'block-level'), 'class' => 'left', 'thclass' => 'left',  ),
		  'amazon' =>   array ( 'title' => LAN_JPLAYER_ADMIN_49, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 
				'writeParms' => array('size' => 'block-level'), 'class' => 'left', 'thclass' => 'left',  ),
		  'buy' =>   array ( 'title' => LAN_JPLAYER_ADMIN_50, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 
				'writeParms' => array('size' => 'block-level'), 'class' => 'left', 'thclass' => 'left',  ),
		  'free' =>   array ( 'title' => LAN_JPLAYER_ADMIN_51, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'batch' => true, 'help' => LAN_JPLAYER_ADMIN_52, 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('name', 'artist', 'position', 'playlist_id');
		

   	protected $preftabs        = array(LAN_ADMIN_JPLAYER_OPTIONS_12, LAN_ADMIN_JPLAYER_OPTIONS_13 );
		protected $prefs = array(
			'bg_color'		=> array('title'=> LAN_ADMIN_JPLAYER_OPTIONS_02, 'tab'=>0, 'type'=>'text', 'data' => 'str', 
				'writeParms' => array('class' => 'colorpicker'), 'help'=>LAN_ADMIN_JPLAYER_OPTIONS_02),
			'bg_opacity'		=> array('title'=> LAN_ADMIN_JPLAYER_OPTIONS_03, 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>LAN_ADMIN_JPLAYER_OPTIONS_03),
			'font_color'		=> array('title'=> LAN_ADMIN_JPLAYER_OPTIONS_04, 'tab'=>0, 'type'=>'text', 'data' => 'str',  
				'writeParms' => array('class' => 'colorpicker'),
				'help'=>LAN_ADMIN_JPLAYER_OPTIONS_04),
			'social_meta'		=> array('title'=> LAN_ADMIN_JPLAYER_OPTIONS_07, 'tab'=>1, 'type'=>'boolean', 'data' => 'str', 'help'=>LAN_ADMIN_JPLAYER_OPTIONS_07),
			'scrollbar'		=> array('title'=> LAN_ADMIN_JPLAYER_OPTIONS_05, 'tab'=>1, 'type'=>'boolean', 'data' => 'str', 'help'=>LAN_ADMIN_JPLAYER_OPTIONS_05),
			'song_count_before_scroll'		=> array('title'=> LAN_ADMIN_JPLAYER_OPTIONS_06, 'tab'=>1, 'type'=>'number', 'data' => 'str', 'help'=>LAN_ADMIN_JPLAYER_OPTIONS_06),
			'skin'		=> array('title'=> LAN_ADMIN_JPLAYER_OPTIONS_01, 'tab'=>0, 'type'=>'dropdown', 'data' => 'str', 'help'=>LAN_ADMIN_JPLAYER_OPTIONS_01),
		);  

	
		public function init()
		{

		$this->prefs['skin']['writeParms']['optArray'] 	= array('default','modern');
		$this->prefs['skin']['readParms']['optArray'] 	= array('default','modern');
		
		$this->fields['playlist_id']['writeParms']['optArray'] = array('playlist_id_0','playlist_id_1', 'playlist_id_2'); 
	
		$sql = e107::getDb();
		$this->playlist[0] = LAN_JPLAYER_ADMIN_38;
		if($sql->select('jm_jplayer_playlists'))
		{
			while ($row = $sql->fetch())
			{
				$this->playlist[$row['id']] = $row['name'];
			}
		}

    $this->fields['playlist_id']['writeParms'] = $this->playlist;
		}
		
				
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			
		}

		public function onCreateError($new_data, $old_data)
		{
					
		}		
		
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
				
		}
}
				


class jm_jplayer_form_ui extends e_admin_form_ui
{

}		
		

				
class jm_jplayer_playlists_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Wolf jPlayer';
		protected $pluginName		= 'jm_jplayer';
		protected $table			= 'jm_jplayer_playlists';
		protected $pid				= 'id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
	 	protected $sortField		= 'id';
	    protected $orderStep		= 10;
		protected $listOrder		= 'id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'id' =>   array ( 'title' => LAN_ID, 'type' => 'number', 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'name' =>   array ( 'title' => LAN_JPLAYER_ADMIN_07, 'type' => 'text', 'data' => 'str', 'width' => 'auto',  'validate' => true, 
					'filter' => true, 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'logo' =>   array ( 'title' => LAN_JPLAYER_ADMIN_08, 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'help' => '', 
					'readParms' => 'thumb=120x50', 'writeParms' => 'media=jm_jplayer',  'class' => 'left', 'thclass' => 'left',  ),
		  'poster' =>   array ( 'title' => LAN_JPLAYER_ADMIN_11, 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'filter' => true, 'help' => '', 
					'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'autoplay' =>   array ( 'title' => LAN_JPLAYER_ADMIN_12, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'batch' => true, 'help' => LAN_JPLAYER_ADMIN_AUTOPLAY_HELP, 
					'readParms' => '', 'class' => 'left', 'thclass' => 'left',  ),


		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('name', 'logo', 'autoplay', 'poster');
		
	
		public function init()
		{
			
	
		}

		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			
		}

		public function onCreateError($new_data, $old_data)
		{
				
		}		
		
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
				
		}				
				
}
				


class jm_jplayer_playlists_form_ui extends e_admin_form_ui
{

}		
		
		
new jm_jplayer_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>