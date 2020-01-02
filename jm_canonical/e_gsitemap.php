<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2018 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *	gSitemap addon
 */

if (!defined('e107_INIT')) { exit; }

// v2.x Standard
class jm_canonical_gsitemap // plugin-folder + '_rss'
{

	function import()
	{
		$import = array();

		$sql = e107::getDb();



		/* public, quests */
		$userclass_list =  "0,252";
		$_t = time();
		/*  it's in core now
		$data = $sql->retrieve("news_category", "*", " ORDER BY category_order ASC", true);

		foreach($data as $row)
		{
			$import[] = array(
					'name'  => $row['category_name'],
					'url'   => e107::getUrl()->create('news/list/category', $row, array('full' => 1)), // ('forum/forum/view', $row['forum_id']),
					'type'  => 'News Categories',
					'table' => 'news_category',
          'table_id' => $row['category_id'],
			);

		}		
		 */
		$data = $sql->retrieve("news", "*", "news_class IN (".$userclass_list.") AND news_start < ".$_t."   ORDER BY news_datestamp ASC", true);

    $iscanonicalinstalled = e107::isInstalled('jm_canonical');
    
		foreach($data as $row)
		{
		
			$url = e107::getUrl()->create('news/view/item', $row, array('full' => 1));
			$title = $row['news_title'];
			$type  = 'News';
			
			// if site using canonical urls, replace them   
			if($iscanonicalinstalled) {
			  if($record = e107::getDb()->retrieve("canonical", "can_url, can_redirect, can_title", "can_table='news' AND can_pid=" . $row['news_id']))   {
			     // if redirect is set, not use this in gsitemap 
				   if($record['can_redirect'])  {  continue;  }
				   // otherwise use canonical url in sitemap 
				   $url=$record['can_url'];
				   $title = $record['can_title'];
				   $type  = 'Canonical News';
  
  			$import[] = array(
  					'name'  => $title,
  					'url'   => $url, // ('forum/forum/view', $row['forum_id']),
  					'type'  => $type,
  					'table' => 'news',
            'table_id' => $row['news_id'],
  			);
        }		 
			} 
      /* otherwise core news are used */
 
			


		}

		return $import;
	}



}
