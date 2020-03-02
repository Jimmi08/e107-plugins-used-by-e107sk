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

 
if(!class_exists("web_links_setup"))
{
	//never don't relay on plugin version in database if there are database changes!
	class web_links_setup
	{
        var $pluginname = 'web_links';
		
		function upgrade_post($var)
		{
			// TODO Add pref for this - for now just way how get data
			if(e107::isInstalled('links_page')) 
			{ 
				/* unnuke
				CREATE TABLE `links_categories` (
					`cid` int(11) NOT NULL auto_increment,
					`title` varchar(50) NOT NULL default '',
					`cdescription` text NOT NULL,
					`parentid` int(11) NOT NULL default '0',
					PRIMARY KEY  (`cid`),
					KEY `cid` (`cid`)
					) ENGINE=MyISAM AUTO_INCREMENT=1 ; 
				*/

				/* e107
				CREATE TABLE links_page_cat (
					link_category_id int(10) unsigned NOT NULL auto_increment,
					link_category_name varchar(100) NOT NULL default '',
					link_category_description varchar(250) NOT NULL default '',
					link_category_icon varchar(100) NOT NULL default '',
					link_category_order int(10) unsigned NOT NULL default '0',
					link_category_class varchar(100) NOT NULL default '0',
					link_category_datestamp int(10) unsigned NOT NULL default '0',
					link_category_sef varchar(100) NOT NULL default '',
					PRIMARY KEY  (link_category_id)
				) ENGINE=MyISAM;
				*/
				
				 
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

				/* Note: differences */
				/* link_category_sef, */
				/* link_category_class,  */
				/* link_category_order, */
				/* link_category_icon,  */ 


				/* LINKS */
				/* e107 
				CREATE TABLE links_page (
					link_id int(10) unsigned NOT NULL auto_increment,
					link_name varchar(100) NOT NULL default '',
					link_url varchar(200) NOT NULL default '',
					link_description text NOT NULL,
					link_button varchar(100) NOT NULL default '',
					link_category tinyint(3) unsigned NOT NULL default '0',
					link_order int(10) unsigned NOT NULL default '0',
					link_refer int(10) unsigned NOT NULL default '0',
					link_open tinyint(1) unsigned NOT NULL default '0',
					link_class tinyint(3) unsigned NOT NULL default '0',
					link_datestamp int(10) unsigned NOT NULL default '0',
					link_author varchar(255) NOT NULL default '',
					link_active tinyint(1) unsigned NOT NULL default '0',    
					PRIMARY KEY  (link_id)
				  ) ENGINE=MyISAM;
				*/

				/* unnuke 
				CREATE TABLE `links_links` (
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
				  ) ENGINE=MyISAM AUTO_INCREMENT=1 ;

				*/ 
 
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

				/* Note: differences */
				/* link_button, */
				/* link_open,  */
				/* link_class, */
				/* link_active,  */ 

				/* TODO:
					decide what to do with date and what is the purpose of other not familiar fields
					'name'
					'email'
					'hits'
					'submitter'
					'linkratingsummary' 
					'totalvotes'
					'totalcomments'
				*/
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
				if(count($links_categories) != count($links_page_cat)) {
					return true;
				}

				$links_links = e107::getDB()->retrieve('links_links', '*' , false, true);
				$links_page = e107::getDB()->retrieve('links_page', '*' , false, true);
				if(count($links_links) != count($links_page)) {
					return true;
				}
			} 
			return false;
		}
  	}  
}