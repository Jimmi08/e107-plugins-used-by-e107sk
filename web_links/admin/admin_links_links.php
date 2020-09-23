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
 
		protected $table			= UN_TABLENAME_LINKS_LINKS;
		protected $pid				= 'lid';
		protected $perPage			= 30; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;
		protected $listOrder		= 'lid DESC';
	    //   'date'  'hits' 'submitter'   'linkratingsummary'  'totalvotes'    'totalcomments'
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'forced' => true,  'toggle' => 'e-multiselect' ),    
			'lid'                     => array ( 'title' => LAN_ID, 'data' => 'int', 'type'=>'number', 'forced'=> TRUE, 'readonly'=>TRUE),
			'title'                   => array (  'title' => _PAGETITLE,  'type' => 'text',  'data' => 'str',  
            'writeParms' => 'size=block-level', 'filter' => true ),
			'url'                     => array (  'title' => _PAGEURL,  'type' => 'url',  'data' => 'str',   'readParms' => 'target=blank', 
            'writeParms' => 'size=block-level',),
            'cid'                     => array (  'title' => LAN_CATEGORY,  'type' => 'dropdown',  'data' => false, 'filter' => true,    'batch' => true,  'inline' => true ),               
			'description'             => array (  'title' => _DESCRIPTION255,  'type' => 'textarea',  'data' => 'str',  
              'writeParms' => 'size=block-level',),
			'name'                    => array (  'title' => LAN_NAME,  'type' => 'text',  'data' => 'str',  'inline' => true,   'nosort' => true,),
			'email'                   => array (  'title' => LAN_EMAIL,  'type' => 'email',  'data' => 'str',  'inline' => true,),  
            'date'                    => array (  'title' => LAN_DATE,  'type' => false,  'data' => 'str'   ),        
			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'forced' => true, ),
		);		
		
		protected $fieldpref = array('lid', 'cid', 'title', 'url', 'date', 'name');
 
        
		public function init()
		{	
 
            $rows = e107::getDb()->retrieve(UN_TABLENAME_LINKS_CATEGORIES, "cid, title, parentid", "WHERE TRUE ORDER BY parentid,title ",  true);
            $values[0] = 'LAN_NONE';
            foreach($rows AS $row) 
			{   $ctitle2 = e107::getParser()->toHTML($row['title'], "", "TITLE");
                $parentid2 = $row['parentid'];
				if ($parentid2 != 0) $ctitle2 = $this->getparent($parentid2,$ctitle2);
				$values[$row['cid']] = $ctitle2;
			}
            
        	$this->fields['cid']['writeParms']['optArray'] = $values ; 
		}
        
 
    	function getparent($parentid,$title) {
    
    		$parentid = intval($parentid);
    		$result = e107::getDB()->gen("SELECT cid, title, parentid FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE cid='".$parentid."'");
    		$row = e107::getDB()->fetch($result);
    		 
    		$cid = $row['cid'];
    		$ptitle = e107::getParser()->toHTML($row['title'], "", "TITLE");
    		$pparentid = $row['parentid'];
    
    		if(!empty($ptitle) && $ptitle != $title) $title = $ptitle."/".$title;
    		if ($pparentid != 0) {
    			$title = $this->getparent($pparentid,$title);
    		}
    		return $title;
    	}
           
       public function beforeCreate($new_data)
	   {
 
         $sql = e107::getDb();
         //check if link exists

         /* Check if Title exist */
         if ($new_data['title']=="") {
            e107::getMessage()->addError(_ERRORNOTITLEWL);
            return false;
         }
         /* Check if URL exist */
         if ($new_data['url']=="") {
            e107::getMessage()->addError(_ERRORNOURLWL);
            return false;
         }         
         /* Check if Description exist */
         if ($new_data['description']=="") {
            e107::getMessage()->addError(_ERRORNODESCRIPTIONWL);
            return false;
         }   
         
         $url = $new_data['url'];   
         $result = $sql->retrieve("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE url='".addslashes($url)."'"  );   
 
         if(is_array($result))  {
           $numrows = $result['numrows'];
         }
         else  $numrows = $result; 
        
         if ($numrows > 0) {
            e107::getMessage()->addError(_ERRORURLEXISTWL);
            return false;
         }
               
		$new_data['date'] = date("Y-m-d H:i:s");
		return $new_data;
              
       }
		public function beforeUpdate($new_data, $old_data, $id)
		{
		    $new_data['date'] = $old_data['date'];
            if($new_data['date'] == "0000-00-00 00:00:00" OR $new_data['date'] == '' ) {
               $new_data['date'] = date("Y-m-d H:i:s");
            }
           
            return $new_data;
 
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

