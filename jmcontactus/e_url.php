<?php
/*
 * e107 Bootstrap CMS
 *
 * Copyright (C) 2008-2015 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * 
 * IMPORTANT: Make sure the redirect script uses the following code to load class2.php: 
 * 
 * 	if (!defined('e107_INIT'))
 * 	{
 * 		require_once("../../class2.php");
 * 	}
 * 
 */
 
if (!defined('e107_INIT')) { exit; }

// v2.x Standard  - Simple mod-rewrite module. 

define("e_PAGE", "contact.php");

class jmcontactus_url // plugin-folder + '_url'
{
	function config() 
	{
		$config = array();

		$config['index'] = array(
			'alias'         => 'contactus',                         
			'regex'			=> '^{alias}\/$', 					 
			'sef'			=> '{alias}/', 						 
			'redirect'		=> '{e_PLUGIN}jmcontactus/contactus.php',  
		);

		$config['thankyou'] = array(
			'alias'         => 'contactus',                         
			'regex'			=> '^{alias}/thankyou/', 					 
			'sef'			=> '{alias}/thankyou/', 						 
			'redirect'		=> '{e_PLUGIN}jmcontactus/contactus.php?thankyou',  
		);
		return $config;
	}
	

	
}