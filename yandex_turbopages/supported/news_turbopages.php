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

global $turbomode;

// v2.x Standard 
class news_turbopages // plugin-folder + '_turbopages'
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
			'url'			=> 'news',               // The identifier and plugin-path location for the rss feed url
			'topic_id'		=> '',                  // The topic_id, empty on default (to select a certain category)
			'description'	=> RSS_PLUGIN_LAN_7,     // that's 'description' not 'text'
			'class'			=> '0',
			'limit'			=> '9'
		);

		// News categories
		$sqli = e107::getDb();
		if($sqli ->select("news_category", "*","category_id!='' ORDER BY category_name "))
		{
			while($rowi = $sqli ->fetch())
			{

				$config[] = array(
					'name'			=> ADLAN_0.' > '.$rowi['category_name'],
					'url'			=> 'news',
					'topic_id'		=> $rowi['category_id'],
					'description'	=> RSS_PLUGIN_LAN_10.' '.$rowi['category_name'], // that's 'description' not 'text'
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
    global $turbomode;
		$pref                       = e107::getConfig()->getPref();
		$tp                         = e107::getParser();

		$render         = ($pref['rss_othernews'] != 1) ? "AND (FIND_IN_SET('0', n.news_render_type) OR FIND_IN_SET(1, n.news_render_type))" : "";
		$nobody_regexp  = "'(^|,)(".str_replace(",", "|", e_UC_NOBODY).")(,|$)'";
		$topic          = (!empty($parms['id']) && is_numeric($parms['id'])) ?  " AND news_category = ".intval($parms['id']) : '';
		$limit          = vartrue($parms['limit'],10);

		$rssQuery = "SELECT n.*, u.user_id, u.user_name, u.user_email, u.user_customtitle, nc.category_name, nc.category_icon FROM #news AS n
				LEFT JOIN #user AS u ON n.news_author = u.user_id
				LEFT JOIN #news_category AS nc ON n.news_category = nc.category_id
				WHERE n.news_class IN (".USERCLASS_LIST.") AND NOT (n.news_class REGEXP ".$nobody_regexp.") AND n.news_start < ".time()." AND (n.news_end=0 || n.news_end>".time().") {$render} {$topic} ORDER BY n.news_datestamp DESC LIMIT 0,".$limit;
		
		$sql = e107::getDb();
		
		
		$sql->gen($rssQuery);
		$tmp = $sql->db_getList();
 
		$rss = array();
		$i=0;
		
		foreach($tmp as $value)
		{
			$url = e107::getUrl()->create('news/view/item', $value, array('full' => 1));
			$iscanonicalinstalled = e107::isInstalled('jm_canonical');
			
			if($iscanonicalinstalled) {
			  if($record = e107::getDb()->retrieve("canonical", "can_url, can_redirect, can_title", "can_table='news' AND can_pid=" . $value['news_id']))   {
			     // if redirect is set, not use this in gsitemap 
				   if($record['can_redirect'])  {  continue;  }
           
				   // otherwise use canonical url in sitemap 
				   $url=$record['can_url'];
           
           // skip external urls
           if(strpos($url, SITEURL) === false || strpos($url,"/") == '0')   {  continue;  }
				}			 
			}	
			
					
			$rss[$i]['link']            = $url;			
			$rss[$i]['author']          = $value['user_name'];
			$rss[$i]['author_email']    = $value['user_email'];
			$rss[$i]['category_name']   = $tp->toHTML($value['category_name'],TRUE,'defs');
			$rss[$i]['category_link']   = SITEURL."news.php?cat.".$value['news_category']; //TODO SEFURL.
			$rss[$i]['datestamp']       = $value['news_datestamp'];

			/* h1 heading */
			$rss[$i]['title']           = $value['news_title'];
			/* h2 heading */
			$rss[$i]['summary']     	= $tp->toHtml($value['news_summary'],true);
			/* content - you get warning in YTP validation if real content is different, without images */
			$content     = $tp->toHtml($value['news_body'],true). "<br />".$tp->toHtml($value['news_extended'], true);
 
      $turbomode = false;
      // waste time only if shortcode is used
  		if(strpos($content,"{") !== false)
  		{    
  			$rss[$i]['fulltext'] = $tp->parseTemplate($content, TRUE); // shortcode in URL support - dynamic urls for multilanguage.
        $turbomode = true;
        $rss[$i]['turbocontent'] = $tp->parseTemplate($content, TRUE);
  		} 
      else {
        $rss[$i]['fulltext']  = $content;
        $rss[$i]['turbocontent']  = $content;
      } 
            // temp solution for issue #3728
      $tag = "g";
      $rss[$i]['turbocontent'] = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/", "", $rss[$i]['turbocontent']);
      $rss[$i]['fulltext'] = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/", "", $rss[$i]['fulltext']);
          
			$rss[$i]['media']            = $this->getMedia($value);
			
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

		if(empty($row['news_thumbnail']))
		{
			return '';
		}

		$tmp = explode(",", $row['news_thumbnail']);

		$ret = array();

		foreach($tmp as $v)
		{

			if($tp->isImage($v))
			{
				$ret[] =  array(
					'media:content'   => array(
						'url'=>$tp->thumbUrl($v,array('w'=>800), true, true),
						'medium'=>'image',
						'value' => array('media:title'=> array('type'=>'html', 'value'=>basename($v)))

					)
				);
			}
			elseif($tp->isVideo($v))
			{
				list($code,$type) = explode(".",$v);

				if($type == 'youtube')
				{

					//TODO Needs to be verified as working.
					$ret[] = array(
						'media:player'  => array('url'=>"http://www.youtube.com/embed/".$code, 'height'=>"560", 'width'=>"315" )
					);

				}
			}
		}

		return $ret;



	}
	
 
			
		
	
}


 
