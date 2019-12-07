<?php
/*
* e107 website system
*
* Copyright (C) 2008-2013 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* Custom install/uninstall/update routines for jmtheme plugin
**
*/

 
if(!class_exists("aredirection_setup"))
{

	//never don't relay on plugin version in database if there are database changes!
	class aredirection_setup
	{
    var $pluginname = 'aredirection';
 
		function upgrade_required()
		{        
        
			//if there is any old record with redirection
		  $where = " WHERE canru_redirect = 1  LIMIT 1"; 
		  $oldurl = e107::getDb()->retrieve("canonical_request_urls",  "canru_id", $where );
  
  		 if($oldurl) {   
  				 return true;
  		 } 

  		return false;

		}
 
    
		/**
		 * After Automatic Upgrade Routine has completed.. run this.
		 *
		 * @param $var
		 */
		function upgrade_pre($var)
		{
			$sql = e107::getDb();
			 
			$query = "SELECT r.canru_url, c.canonical_url, r.canru_redirect FROM #canonical_request_urls AS r LEFT JOIN #canonical_urls AS c 
	                 ON r.canonical_id = c.canonical_id
	                 WHERE r.canru_redirect = 1  ";
	    if ($sql->gen($query))
			{    
  			if ($url = $sql->fetch($query, true))
  			{
  			    //check if redirection is not existing already
  			    $where = " WHERE redirection_url = '" . $request_url . "'  AND redirection_status = 1  LIMIT 1";
  			    
        }   
			}
		 }
	 }
}