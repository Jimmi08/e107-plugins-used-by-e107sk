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

//load constants for front+admin
require_once(e_PLUGIN.'web_links/web_links_defines.php');	

if(!class_exists("web_links_setup"))
{
	//never don't relay on plugin version in database if there are database changes!
	class web_links_setup
	{
        var $pluginname = 'web_links';
        
        
        /**
		 * For inserting default database content during install after table has been created by the jmcontactus_sql.php file.
		 */
		public function install_post($var)
		{
			$sql = e107::getDb();
			$mes = e107::getMessage();
			$options = array();
			$eplug_folder = "web_links";

            $eplug_tables = array( 
            "CREATE TABLE ".MPREFIX.UN_TABLENAME_LINKS_CATEGORIES." (
              `cid` int(11) NOT NULL auto_increment,
              `title` varchar(50) NOT NULL default '',
              `cdescription` text NOT NULL,
              `parentid` int(11) NOT NULL default '0',
              PRIMARY KEY  (`cid`),
              KEY `cid` (`cid`)
            ) ENGINE=MyISAM;",
			
            "CREATE TABLE ".MPREFIX.UN_TABLENAME_LINKS_EDITORIALS." (
              `linkid` int(11) NOT NULL default '0',
              `adminid` varchar(60) NOT NULL default '',
              `editorialtimestamp` datetime NOT NULL default '0000-00-00 00:00:00',
              `editorialtext` text NOT NULL,
              `editorialtitle` varchar(100) NOT NULL default '',
              PRIMARY KEY  (`linkid`),
              KEY `linkid` (`linkid`)
            ) ENGINE=MyISAM;",

            "CREATE TABLE ".MPREFIX.UN_TABLENAME_LINKS_LINKS." (
              `lid` int(11) NOT NULL auto_increment,
              `cid` int(11) NOT NULL default '0',
              `sid` int(11) NOT NULL default '0',
              `title` varchar(100) NOT NULL default '',
              `url` varchar(100) NOT NULL default '',
              `description` text NOT NULL,
              `date` datetime default NULL,
              `name` varchar(100) NOT NULL default '',
              `email` varchar(100) NOT NULL default '',
              `hits` int(11) NOT NULL default '0',
              `submitter` varchar(60) NOT NULL default '',
              `linkratingsummary` double(6,4) NOT NULL default '0.0000',
              `totalvotes` int(11) NOT NULL default '0',
              `totalcomments` int(11) NOT NULL default '0',
              PRIMARY KEY  (`lid`),
              KEY `lid` (`lid`),
              KEY `cid` (`cid`),
              KEY `sid` (`sid`)
            ) ENGINE=MyISAM;",	

            "CREATE TABLE ".MPREFIX.UN_TABLENAME_LINKS_MODREQUEST." (
              `requestid` int(11) NOT NULL auto_increment,
              `lid` int(11) NOT NULL default '0',
              `cid` int(11) NOT NULL default '0',
              `sid` int(11) NOT NULL default '0',
              `title` varchar(100) NOT NULL default '',
              `url` varchar(100) NOT NULL default '',
              `description` text NOT NULL,
              `modifysubmitter` varchar(60) NOT NULL default '',
              `brokenlink` int(3) NOT NULL default '0',
              PRIMARY KEY  (`requestid`),
              UNIQUE KEY `requestid` (`requestid`)
            ) ENGINE=MyISAM;",
            
            "CREATE TABLE ".MPREFIX.UN_TABLENAME_LINKS_NEWLINK." (
              `lid` int(11) NOT NULL auto_increment,
              `cid` int(11) NOT NULL default '0',
              `sid` int(11) NOT NULL default '0',
              `title` varchar(100) NOT NULL default '',
              `url` varchar(100) NOT NULL default '',
              `description` text NOT NULL,
              `name` varchar(100) NOT NULL default '',
              `email` varchar(100) NOT NULL default '',
              `submitter` varchar(60) NOT NULL default '',
              PRIMARY KEY  (`lid`),
              KEY `lid` (`lid`),
              KEY `cid` (`cid`),
              KEY `sid` (`sid`)
            ) ENGINE=MyISAM;",
            
            
            "CREATE TABLE ".MPREFIX.UN_TABLENAME_LINKS_VOTEDATA." (
              `ratingdbid` int(11) NOT NULL auto_increment,
              `ratinglid` int(11) NOT NULL default '0',
              `ratinguser` varchar(60) NOT NULL default '',
              `rating` int(11) NOT NULL default '0',
              `ratinghostname` varchar(60) NOT NULL default '',
              `ratingcomments` text NOT NULL,
              `ratingtimestamp` datetime NOT NULL default '0000-00-00 00:00:00',
              PRIMARY KEY  (`ratingdbid`),
              KEY `ratingdbid` (`ratingdbid`)
            ) ENGINE=MyISAM;",
            
          
            );		
			foreach ($eplug_tables as $table_query)
			{
				e107::getDB()->gen($table_query);
			}
		}
        
		
		function upgrade_post($var)
		{
			// TODO Add pref for this - for now just way how get data
			if(e107::isInstalled('links_page')) 
			{ 
 				$links_page_cat = e107::getDB()->retrieve('links_page_cat', '*' , false, true);
				 
				foreach($links_page_cat AS $links_category) 
				{
					$insert = array(
						'cid'       	=> $links_category['link_category_id']  ,
						'title'     	=> $links_category['link_category_name']  , 
						'cdescription'  => $links_category['link_category_description']  , 
						'parentid'      => 0  ,
						'_DUPLICATE_KEY_UPDATE' => 1
					);

					e107::getDB()->insert("links_categories", $insert);
				}
 
				$links_pages = e107::getDB()->retrieve('links_page', '*' , false, true);
				 
				foreach($links_pages AS $links_page) 
				{
					$timestamp = $links_page['link_datestamp'];
					$time = strftime('%Y-%m-%d %H:%M:%S',$timestamp); 
					$insert = array(
						'lid'       			=> $links_page['link_id']  ,
						'cid'     				=> $links_page['link_category']  , 
						'sid'     				=> $links_page['link_author'], 
						'title'  				=> $links_page['link_name']  , 
						'url'  					=> $links_page['link_url']  , 
						'description'  			=> $links_page['link_description']  , 
						'date'  				=> $time, 
						'name'  				=> '' , 
						'email'  				=> ''  , 
						'hits'  				=> $links_page['link_refer']  ,   
						'submitter'  			=> '' , 
						'linkratingsummary'  	=> 0 ,
						'totalvotes'  			=> 0  ,						
						'totalcomments'  		=> 0 ,						
						'_DUPLICATE_KEY_UPDATE' => 1
					);

					e107::getDB()->insert("links_links", $insert, true);
 
				}	
			}
		}
			
			
		function upgrade_required()
		{        

			//this way save time and admin part can wait 
			//for adding new links use LinksPage plugin admin area

			if(e107::isInstalled('links_page')) {   
				$links_categories = e107::getDB()->retrieve('links_categories', '*' , false, true);
				$links_page_cat = e107::getDB()->retrieve('links_page_cat', '*' , false, true);
                 
				if(count($links_categories) < count($links_page_cat)) {
					return true;
				}

				$links_links = e107::getDB()->retrieve('links_links', '*' , false, true);
				$links_page = e107::getDB()->retrieve('links_page', '*' , false, true);
				if(count($links_links) < count($links_page)) {
				 	return true;
				}
			} 
			return false;
		}
  	}  
}