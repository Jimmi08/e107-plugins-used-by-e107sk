<?php
/*
 * e107 Bootstrap CMS
 *
 * Copyright (C) 2008-2016 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)

 */
 
if (!defined('e107_INIT')) { exit; }

// v2.x Standard  - Simple mod-rewrite module. 

class yandex_turbopages_url // plugin-folder + '_url'
{
	function config() 
	{
		$config = array();

		$config['turbo'] = array(
			'alias'			=> 'feed',
  		'regex'			=> '^{alias}/turbo/(.*)\/([\d]*)?$',    
      'sef'			=> '{alias}/turbo/{rss_url}/{rss_topicid}',  
     	'redirect'		=> '{e_PLUGIN}yandex_turbopages/rss.php?cat=$1&type=5&topic=$2' 
		);
    
 

		return $config;
	}
	
}