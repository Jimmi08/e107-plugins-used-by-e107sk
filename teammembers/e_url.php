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

class teammembers_url // plugin-folder + '_url'
{
	function config() 
	{
		$config = array();

		$config['teammember'] = array(
			'alias'         => 'teammembers',                            // default alias 're_agents'. {alias} is substituted with this value below. Allows for customization within the admin area.
			'regex'			=> '^{alias}/(\d*)-(.*)$',
			'sef'			=> '{alias}/{uid}-{sef}',
			'redirect'		=> '{e_PLUGIN}teammembers/team.php?uid=$1', 		// file-path of what to load when the regex returns true.

		);


		$config['index'] = array(
			'alias'         => 'teammembers',     
			'regex'			=> '^{alias}/(.*)$', 						// matched against url, and if true, redirected to 'redirect' below.
			'sef'			=> 'teammembers', 							// used by e107::url(); to create a url from the db table.
			'redirect'		=> '{e_PLUGIN}teammembers/team.php?query=$1', 		// file-path of what to load when the regex returns true.

		);

		return $config;
	}
	

}