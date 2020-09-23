<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *	Yandex TurboPages News config
 */
 
if (!defined('e107_INIT')) { exit; }

// v2.x Standard 
class page_turbopages // plugin-folder + '_turbopages'
{
	/**
	 * Admin RSS Configuration
	 *
	 */		
	function config() 
	{
		$config = array();

		$config[] = array(
			'name'			=> ADLAN_0,
			'url'			=> 'page',               // The identifier and plugin-path location for the rss feed url
			'topic_id'		=> '',                  // The topic_id, empty on default (to select a certain category)
			'description'	=> RSS_PLUGIN_LAN_7,     // that's 'description' not 'text'
			'class'			=> '0',
			'limit'			=> '9'
		);

		// Page Chapters
		$sqli = e107::getDb();
		if($sqli ->select("page_chapter", "*","chapter_parent!=0 ORDER BY chapter_name "))
		{
			while($rowi = $sqli ->fetch())
			{

				$config[] = array(
					'name'			=> ADLAN_0.' > '.$rowi['chapter_name'],
					'url'			=> 'news',
					'topic_id'		=> $rowi['chapter_id'],
					'description'	=> RSS_PLUGIN_LAN_10.' '.$rowi['chapter_name'], // that's 'description' not 'text'
					'class'			=> '0',
					'limit'			=> '9'
				);

			}
		}
		
		return $config;
	}


	/**
	 * Generate the Feed Data
	 * @param string $parms
	 * @return array
	 */
	function data($parms='')
	{

		$pref                       = e107::getConfig()->getPref();
		$tp                         = e107::getParser();

	/*	$render         = ($pref['rss_othernews'] != 1) ? "AND (FIND_IN_SET('0', n.news_render_type) OR FIND_IN_SET(1, n.news_render_type))" : "";
		$nobody_regexp  = "'(^|,)(".str_replace(",", "|", e_UC_NOBODY).")(,|$)'";
		$topic          = (!empty($parms['id']) && is_numeric($parms['id'])) ?  " AND news_category = ".intval($parms['id']) : '';
		$limit          = vartrue($parms['limit'],10);  */

	  $pluginPrefs = e107::getPlugPref('yandex_turbopages');
    extract($pluginPrefs);

	/* custom pages ... */
			$rssQuery = "SELECT p.*, ch.chapter_sef as chapter_sef,   ch.chapter_name as chapter_name, 
				b.chapter_sef as book_sef FROM #page as p
				LEFT JOIN #yandex_turbopages AS g ON p.page_id = g.entity_id AND g.entity_type = 'page'  
				LEFT JOIN #page_chapters as ch ON p.page_chapter = ch.chapter_id
				LEFT JOIN #page_chapters as b ON ch.chapter_parent = b.chapter_id
						WHERE page_title !='' AND tb_include = 1  ORDER BY page_datestamp ASC";
 	
		$sql = e107::getDb();
 
		$sql->gen($rssQuery);
		$tmp = $sql->db_getList();

		$rss = array();
		$i=0;
		
		foreach($tmp as $value)
		{
 
			// canonical url
			$iscanonical = e107::isInstalled('jm_canonical');
			$id =  $value['page_id'];
      $table = 'page';
			if($iscanonical && $record = e107::getDb()->retrieve("canonical", "can_url, can_redirect, can_title", "can_table='{$table}' AND can_pid={$id}" ))   {
			     // if redirect is set, not use this in gsitemap 
				   if($record['can_redirect'])  {  continue;  }
				   // otherwise use canonical url in sitemap 
				   $url=$record['can_url'];		 
			}
      else {
          $route = ($value['page_chapter'] == 0) ? "page/view/other" : "page/view/index";
          $url = e107::getUrl()->create($route, $value, array('full'=>1, 'allow' => 'page_sef,page_title,page_id, chapter_sef, book_sef'));
      }   
		
			$rss[$i]['link']            = $url;			
			$rss[$i]['author']          = $value['page_author'];
			$rss[$i]['category_name']   = $tp->toHTML($value['chapter_name'],TRUE,'defs');
			$rss[$i]['category_link']   = e107::getUrl()->create('page/chapter/index', $value, array('full'=>1, 'allow' => 'chapter_id,chapter_sef,book_sef'));
			$rss[$i]['datestamp']       = $value['page_datestamp'];
      
      // temp solution for issue #3728
      $tag = "g";
      $value['page_text'] = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/", "", $value['page_text']);

			/* h1 heading */
			$rss[$i]['title']           = $value['page_title'];
			/* h2 heading */
			$rss[$i]['summary'] = e107::getParser()->text_truncate($tp->toText($value['page_text'],true), $ytp_pages_summarylimit);
    
			/* content - you get warning in YTP validation if real content is different, without images */
			$rss[$i]['turbocontent']     = $tp->toHtml($value['page_text'],true);
 
			$rss[$i]['media']           = $this->getMedia( $value);
		   
			// find first image 
			foreach($rss[$i]['media'] as $media)  {
					if($media['media:content']['medium'] == 'image') {
						$rss[$i]['pageimage']        = $media;
						break;
					}
			}
			$i++; 
		}	
		return $rss;	
	}

	function getMedia($row)
	{
		$tp = e107::getParser();
 
		if(empty($row['menu_image']))
		{
			return '';
		}
 
		$tmp =  $row['menu_image'] ;

		$ret = array();
  
		$ret[] =  array(
			'media:content'   => array(
				'url'=>$tp->thumbUrl($tmp,array('w'=>800), true, true),
				'medium'=>'image',
				'value' => array('media:title'=> array('type'=>'html', 'value'=>basename($v)))

			)
		);

		return $ret;



	}
	
 
			
		
	
}


 