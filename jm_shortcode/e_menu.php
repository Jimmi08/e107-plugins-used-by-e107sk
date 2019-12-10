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

//v2.x Standard for extending menu configuration within Menu Manager. (replacement for v1.x config.php)
	
class jm_shortcode_menu
{
	function __construct()
	{
		// e107::lan('jm_shortcode','menu',true); // English_menu.php or {LANGUAGE}_menu.php
	}

	/**
	 * Configuration Fields.
	 * @return array
	 */
	public function config($menu='')
	{

		$fields = array();
		$fields['shortcode_menuCaption']      = array('title'=> "Caption", 'type'=>'text', 'multilan'=>true, 'writeParms'=>array('size'=>'xxlarge'));
		$fields['shortcode_menuCode']        = array('title'=> "Shortcode code", 'type'=>'text', 'writeParms'=>array('size'=>'xxlarge'));
		$fields['shortcode_menuTableStyle']        = array('title'=> "ID for tablestyle", 'type'=>'text', 'writeParms'=>array('size'=>'xxlarge')); 
        return $fields;

	}

}
 


?>