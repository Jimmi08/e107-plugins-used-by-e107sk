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

e107::lan('jmelements',true);

//v2.x Standard for extending menu configuration within Menu Manager. (replacement for v1.x config.php)
// TODO add fields
class testimonials_menu
{
	function __construct()
	{
		// e107::lan('_blank','menu',true); // English_menu.php or {LANGUAGE}_menu.php
	}

	/**
	 * Configuration Fields.
	 * @return array
	 */
	public function config($menu='')
	{
 
		switch($menu)
		{
			case "testimonials":
			  $templates = e107::getLayouts('testimonials', 'testimonials', 'front', null, false, false);					 
			  $fields['template']     = array('title'=> LAN_TEMPLATE,  'type'=>'dropdown', 'writeParms'=>array('optArray'=>$templates, 
				), 'help'=>'');

			break;
 
		}

	  return $fields;

	}

}

 


?>