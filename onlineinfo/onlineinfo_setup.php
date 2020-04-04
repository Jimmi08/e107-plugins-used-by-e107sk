<?php
/*
* e107 website system
*
* Copyright (C) 2008-2013 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* Custom install/uninstall/update routines for blank plugin
**
*/


if(!class_exists("onlineinfo_setup"))
{
	class onlineinfo_setup
	{

	  function install_pre($var)
		{
 		}

		/**
		 * For inserting default database content during install after table has been created by the blank_sql.php file.
		 * "INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_5','toppost',1,10,253,480,0,5);",
		 */
		function install_post($var)
		{
     $sql = e107::getDb();     
$default_data = array(
"INSERT INTO #onlineinfo_cache VALUES ('birthday','Birthday Data Cache','',0,0,0,0,0,0);",
"INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_1','updated',0,0,253,0,0,1);",
"INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_2','topvisits',1,10,253,10,0,4);",
"INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_3','lastvisitors',1,10,253,0,0,3);",
"INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_4','birthday',1,10,253,1440,0,2);",
"INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_5','toppost',1,10,253,480,0,5);",
"INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_6','toppoststarter',1,10,253,480,0,6);",
"INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_7','toppostreplier',1,10,253,480,0,7);",
"INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_8','topratedmember',1,10,253,480,0,8);",
"INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_9','counter',0,0,0,0,0,9);",
"INSERT INTO #onlineinfo_cache VALUES ('order','ONLINEINFO_CACHEINFO_10','avatar.php',0,0,253,0,0,1);",
"INSERT INTO #onlineinfo_cache VALUES ('order','ONLINEINFO_CACHEINFO_12','pm.php',0,0,253,0,0,2);",
"INSERT INTO #onlineinfo_cache VALUES ('order','ONLINEINFO_CACHEINFO_13','amigo.php',1,0,253,0,0,5);",
"INSERT INTO #onlineinfo_cache VALUES ('order','ONLINEINFO_CACHEINFO_14','currentlyonline.php',0,0,0,0,0,3);",
"INSERT INTO #onlineinfo_cache VALUES ('order','ONLINEINFO_CACHEINFO_15','extrainfo.php',0,0,0,0,0,6);",
"INSERT INTO #onlineinfo_cache VALUES ('order','ONLINEINFO_CACHEINFO_16','tmembers.php',0,0,0,0,0,7);",
"INSERT INTO #onlineinfo_cache VALUES ('toppost','Top Poster Data Cache','',0,0,0,0,0,0);",
"INSERT INTO #onlineinfo_cache VALUES ('toppostreplier','Top Replier Data Cache','',0,0,0,0,0,0);",
"INSERT INTO #onlineinfo_cache VALUES ('toppoststarter','Top Starter Data Cache','',0,0,0,0,0,0);",
"INSERT INTO #onlineinfo_cache VALUES ('topratedmember','Top Rated Data Cache','',0,0,0,0,0,0);",
"INSERT INTO #onlineinfo_cache VALUES ('topvisits','Top Visitor Data Cache','',0,0,0,0,0,0);",
"INSERT INTO #onlineinfo_cache VALUES ('classcolour','Save the User Class Colours info','',0,0,0,0,0,0);"
);

// check if there are any data

if($sql->retrieve('onlineinfo_cache'))     {
 // do nothing
}
else {      //insert demo data
foreach ($default_data AS $insert) {
   e107::getDb()->gen($insert);
}
}
		}

		function uninstall_options()
		{
 
		}


		function uninstall_post($var)
		{
			// print_a($var);
		}


		/*
		 * Call During Upgrade Check. May be used to check for existance of tables etc and if not found return TRUE to call for an upgrade.
		 *
		 * @return bool true = upgrade required; false = upgrade not required
		 */
		function upgrade_required()
		{
       $sql = e107::getDb();
        // removing FLash Chat support
       if($sql->retrieve('onlineinfo_cache', 'cache_name', 'WHERE cache_name = "ONLINEINFO_CACHEINFO_11"'))     {
         return true;
       }

       $sql = e107::getDb();
        // removing FLash Chat support
       if($sql->retrieve('onlineinfo_cache', 'cache_name', 'WHERE cache_name = "ONLINEINFO_CACHEINFO_5"'))     {
         return false;
       }
       else return true;
        
			return false;
		}

  	function upgrade_pre($var)
  	{
 
  	}
  
		function upgrade_post($var)
		{
			 $sql = e107::getDb();
        // removing FLash Chat support
       if($sql->retrieve('onlineinfo_cache', 'cache_name', 'WHERE cache_name = "ONLINEINFO_CACHEINFO_11"'))     { 
         $script = 'DELETE FROM #onlineinfo_cache  WHERE  `cache_name` = "ONLINEINFO_CACHEINFO_11"  LIMIT 1 ';
         e107::getDb()->gen($script);
       }
       
        // removing TopPoster 
       if($sql->retrieve('onlineinfo_cache', 'cache_name', 'WHERE cache_name = "ONLINEINFO_CACHEINFO_5"'))     { 
         //$script = 'DELETE FROM #onlineinfo_cache  WHERE  `cache_name` = "ONLINEINFO_CACHEINFO_5"  LIMIT 1 ';
        // e107::getDb()->gen($script);
       }
       else {
          $script = "INSERT INTO #onlineinfo_cache VALUES ('extraorder','ONLINEINFO_CACHEINFO_5','toppost',1,10,253,480,0,5);";
          e107::getDb()->gen($script);
       }
		}

	}

}