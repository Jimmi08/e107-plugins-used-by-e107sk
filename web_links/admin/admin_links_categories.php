<?php    
/*
* e107 website system
*
* Copyright (C) 2008-2013 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* e107 Web Links Plugin
*
* #######################################
* #     e107 website system plugin      #
* #     by Jimako                    	 #
* #     https://www.e107sk.com          #
* #######################################
*/ 

/**
  * UNITED-NUKE CMS: Just Manage!
  * http://united-nuke.openland.cz/
  * http://united-nuke.openland.cz/forums/
  *
  * 2002 - 2005, (c) Jiri Stavinoha
  * http://united-nuke.openland.cz/weblog/
  *
  * Translation to English language
  * http://axlsystems.amjawa.com/ - 2005, (c) Roman Vosicky
  *  
  * Portions of this software are based on PHP-Nuke
  * http://phpnuke.org - 2002, (c) Francisco Burzi
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
**/

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

require_once("admin_leftmenu.php");
 
            	
class web_links_ui extends plugin_admin_ui
{
			
		 
		protected $pluginName		= 'web_links';		
		protected $table			= UN_TABLENAME_LINKS_CATEGORIES;
		protected $pid				= 'cid';
		protected $perPage			= 30; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;
		protected $listOrder		= 'cid DESC';
	
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'forced' => true,  'toggle' => 'e-multiselect',  'fieldpref' => '1',),
			'parentid'                => array (  'title' => _PARENT_CATEGORY,  'type' => 'dropdown',  
            'data' => 'int',  
            'batch' => true,  
            'filter' => true ),
			'cid'                     => array (  'title' => 'Cid',  'data' => 'int' ),
			'title'                   => array (  'title' => LAN_TITLE,  'type' => 'text',  'data' => 'str', 
             'inline' => true,  'filter' => true,   'writeParms' =>array('size'=>'block-level')
             ),
			'cdescription'            => array (  'title' => LAN_DESCRIPTION,  'type' => 'textarea',  'data' => 'str',  
              'writeParms' =>array('size'=>'block-level'
            ),
            ),
			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'forced' => true,  'fieldpref' => '1',),
		);		
		
		protected $fieldpref = array('cid', 'title', 'cdescription', 'parentid');

		public function init()
		{
			// Example Drop-down array from database.
			$rows = e107::getDb()->retrieve("links_categories", "*", "WHERE parentid = 0 ", true);
			$values[0] = _TOPLEVEL;
			foreach($rows AS $row) 
			{
				$values[$row['cid']] = $row['title'];
			}
        	$this->fields['parentid']['writeParms']['optArray'] = $values ; 
		}
  
}  

class web_links_form_ui extends e_admin_form_ui
{

}		
		
		
new leftmenu_adminArea();

require_once(e_ADMIN."auth.php");

e107::getAdminUI()->runPage();
require_once(e_ADMIN."footer.php");
exit;

