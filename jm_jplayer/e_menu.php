<?php

if (!defined('e107_INIT')) { exit; }


class jm_jplayer_menu
{
	function __construct()
	{
		e107::lan('jm_jplayer','admin',true,true); 
	}

	public function config($menu='')
	{

    $tmp =  e107::getDb()->retrieve('jm_jplayer_playlists','id,name',null, true);
    
    foreach($tmp as $val)
		{
			$id = $val['id'];
			$categories[$id] = $val['name'];
		}
		
		$fields = array();
		$fields['playlist_caption']  = array('title'=> LAN_CAPTION, 'type'=>'text', 'multilan'=>true, 'writeParms'=>array('size'=>'xxlarge'));
    $fields['playlist_id']       = array('title'=> LAN_JPLAYER_ADMIN_38, 'type'=>'dropdown', 'writeParms'=>array('optArray'=>$categories ));
    return $fields;

	}

}

?>