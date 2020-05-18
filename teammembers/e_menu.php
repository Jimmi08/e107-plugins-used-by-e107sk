<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2015 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *
*/

if (!defined('e107_INIT')) { exit; }
 
	
class teammembers_menu
{
	function __construct()
	{
		e107::lan('teammembers',true);
	}

	/**
	 * Configuration Fields.
	 * @return array
	 */
	public function config($menu='')
	{

        $sql = e107::getDb();
		$fields = array();

		//see TeamMembers::templates();  Allow merge? 
        $templates = e107::getLayouts('teammembers', 'team_members', 'front', null, true, false);

        switch($menu)
      	{
      		case "ourteam":
            
				foreach($templates AS $key => $value) {
					if (strpos($key, "list_") === 0) {
						$template[$key] = $value;
					} 
				}
				$fields['caption']      = array('title'=> LAN_CAPTION, 'type'=>'text', 'multilan'=>true, 'writeParms'=>array('size'=>'xxlarge'));	
                $fields['subtitle']     = array('title'=> LAN_TITLE, 'type'=>'text', 'multilan'=>true, 'writeParms'=>array('size'=>'xxlarge'));	
				$fields['count']        = array('title'=> LAN_LIMIT, 'type'=>'number', 'writeParms'=>array('pattern'=>'[0-9]*', 'size'=>'mini'));   
				$fields['template']     = array('title'=> LAN_TEMPLATE,  'type'=>'dropdown', 'writeParms'=>array('optArray'=>$template, 'default'=>'blank'), 'help'=>'');
				$fields['tablestyle']   = array('title'=> LP_TM_MENU_01, 'type'=>'text', 'writeParms'=>array('size'=>'xxlarge')); 
				return $fields;
			break;
       
        } 
	}

}
 
 