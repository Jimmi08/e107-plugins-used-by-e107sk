<?php
 
if (!defined('e107_INIT'))
{
	require_once('../../class2.php');
}

$e107 = e107::getInstance();
 
if (!e107::isInstalled('yandex_turbopages'))
{
	e107::redirect();
	exit;
}

$pluginPrefs = e107::getPlugPref('yandex_turbopages');
extract($pluginPrefs);
if(!$yandex_turbo_active) {
  // default is now 301 
 	e107::redirect(SITEURL,'302');
	exit;
}


$tp = e107::getParser();
 
require_once(e_HANDLER.'userclass_class.php');

 
// Get language file
e107::lan('yandex_turbopages');

// Query handler
if(!empty($_GET['type']))
{
	$content_type = $tp->toDB($_GET['cat']);
	$rss_type = intval(varset($_GET['type'],0));
	$topic_id = $tp->toDB($_GET['topic'],'');

}
elseif(e_QUERY)
{
	$tmp = explode('.', e_QUERY);

	$content_type = $tp->toDB($tmp[0]);
	$rss_type = intval(varset($tmp[1],0));
	$topic_id = $tp->toDB($tmp[2],'');
}
else
{
	$content_type = false;
	$topic_id = false;
}
 
 
while (ob_get_level()) @ob_end_clean();

// ----------------------------------------------------------------------------

if($rss = new rssCreate($content_type, $rss_type, $topic_id, $row))
{
	$rss_title = ($rss->contentType ? $rss->contentType : ucfirst($content_type));

	if(false)
	{
		define('e_IFRAME',true);
		require_once(HEADERF);
		//$rss->debug();
		$rss->buildTurboRss($rss_title, true, false);
		require_once(FOOTERF);
		exit;
	}
	else
	{
		$rss->buildTurboRss($rss_title, false, true);
	}
}
else
{
	require_once(HEADERF);
	$ns->tablerender(LAN_PLUGIN_YTP_NAME, LAN_PLUGIN_YTP_ERROR_1);
	require_once(FOOTERF);
	exit;
}

class rssCreate
{
	protected $e107;

	var $contentType;
	var $rssType;
	var $path;
	var $parm;
	var $rssItems;
	var $rssQuery;
	var $topicid;
	var $offset;
	var $rssNamespace;
	var $rssCustomChannel;


      
	public function __construct($content_type, $rss_type, $topic_id, $row)
	{	// Constructor
		$sql_rs = new db;
		global $rssgen;
		$sql = e107::getDb();
		$tp = e107::getParser();

		$this->e107 = e107::getInstance();

 
		$this->rssType = $rss_type;
		$this->topicid = $topic_id;
		$this->limit = $row['rss_limit'];
		$this->contentType = $row['rss_name'];
 

		switch ($content_type)
		{
			case 'news' :
				$this->path = e_PLUGIN."yandex_turbopages/supported/news_turbopages.php";
				$this->contentType = LAN_PLUGIN_YTP_FEED_TYPE_NEWS;
				break;
			case 'page' :
				$this->path = e_PLUGIN."yandex_turbopages/supported/page_turbopages.php";
				$this->contentType = LAN_PLUGIN_YTP_FEED_TYPE_PAGES;
				break;       
        
		}

 
			if (is_readable($this->path))
			{
				require_once($this->path);
				
				$className = $content_type.'_turbopages';
				 
				// v2.x standard 
				if($data = e107::callMethod($className,'data', array('url' => $content_type, 'id' => $this->topicid, 'limit' => $this->limit)))
				{			
					$eplug_rss_data = array(0 => $data);
					unset($data);			
				}
 				
				foreach($eplug_rss_data as $key=>$rs)
				{
					foreach($rs as $k=>$row)
					{
						 
            $this -> rssItems[$k]['author'] = $row['author'];
						$this -> rssItems[$k]['author_email'] = $row['author_email'];
						$this -> rssItems[$k]['title'] = $row['title'];

						if($row['link'])
						{
							if(stripos($row['link'], 'http') !== FALSE)
							{
								$this -> rssItems[$k]['link'] = $row['link'];
							}
							else
							{
								$this -> rssItems[$k]['link'] = SITEURLBASE.e_PLUGIN_ABS.$row['link'];
							}
						}
						$this -> rssItems[$k]['turbocontent'] = $row['turbocontent'];
            $this -> rssItems[$k]['fulltext'] = $row['fulltext'];
						$this -> rssItems[$k]['summary'] = $row['summary'];
						if($row['enc_url'])
						{
							$this -> rssItems[$k]['enc_url'] = SITEURLBASE.e_PLUGIN_ABS.$row['enc_url'].$row['item_id'];
						}
						if($row['enc_leng'])
						{
							$this -> rssItems[$k]['enc_leng'] = $row['enc_leng'];
						}

						if(!empty($eplug_rss['enc_type']))
						{
							$this -> rssItems[$k]['enc_type'] = $this->getmime($eplug_rss['enc_type']);
						}
						elseif($row['enc_type'])
						{
							$this -> rssItems[$k]['enc_type'] = $row['enc_type'];
						}

						$this -> rssItems[$k]['category_name'] = $row['category_name'];
						if($row['category_link'])
						{
							if(stripos($row['category_link'], 'http') !== FALSE)
							{
								$this -> rssItems[$k]['category_link'] = $row['category_link'];
							}
							else
							{
								$this -> rssItems[$k]['category_link'] = SITEURLBASE.e_PLUGIN_ABS.$row['category_link'];
							}
						}
						if(!empty($row['datestamp']))
						{
							$this -> rssItems[$k]['pubdate'] = $row['datestamp'];
						}
						else
						{
							$this -> rssItems[$k]['pubdate'] = time();
						}

						if($row['custom'])
						{
							$this -> rssItems[$k]['custom'] = $row['custom'];
						}

						if($row['media'])
						{
							$this -> rssItems[$k]['media'] = $row['media'];
						}

						if($row['pageimage'])
						{
							$this -> rssItems[$k]['pageimage'] = $row['pageimage'];
						}
					}
				}
			}
			else {
			   	e107::redirect(SITEURL,'302');
					exit;
			} 
	}

	function debug()
	{
  
    foreach($this -> rssItems as $item) {
           
          $turboitem = $this->turbotags($item['turbocontent']);
       //   print_a($turboitem);
    }
 
	//	print_a($this -> rssItems);
	}
  
  /**
   * Prints xml code
   * @param string  $type                  
   * @param boolean $debug                (Optional) True or false.
   *                                      If true, the xml code will be displayed
   * @param boolean $display              (Optional) True or false.
   *                                      If false, the xml code will be returned but not displayed.
   * @return $this
   */

	function buildTurboRss($rss_title, $debug = true, $display = true)
	{
		global $pref;

	  $tp = e107::getParser();
	  $pluginPrefs = e107::getPlugPref('yandex_turbopages');
	  
	  // renamed class, Content is too general, look at problem with class Form
    if (!class_exists("TurboPageHelperContent", false)) {
		    $php_version = phpversion();
				if(version_compare($php_version, 7.0, ">="))
				{
					$helper = e_PLUGIN."yandex_turbopages/helpers/Content.php";
				}
				else {
				  $helper = e_PLUGIN."yandex_turbopages/helpers/Content_php5.php";
				}
		    require_once($helper);
    }	  

		
		header('Content-type: application/xml', TRUE);

		$rss_title = $tp->toRss($tp->toHTML($pref['sitename'],'','defs')." : ".$tp->toHTML($rss_title,'','defs'));
   	$rss_namespace = ($this->rssNamespace) ? "xmlns:".$this->rssNamespace : '';
    $rss_custom_channel = ($this->rssCustomChannel) ? $this->rssCustomChannel : '';
		$time = time();
		switch ($this -> rssType)
		{
      // Turbo pages
			case 5:
        //$rss_namespace = 
				$sitebutton = (strstr(SITEBUTTON, "http:") ? SITEBUTTON : SITEURL.str_replace("../", "", SITEBUTTON));
				$final_feed = "<?xml version=\"1.0\" encoding=\"utf-8\"?".">
				<!-- generator=\"e107\" -->
				<!-- content type=\"".$this->contentType."\" -->
				<rss
          xmlns:yandex=\"http://news.yandex.ru\"
          xmlns:media=\"http://search.yahoo.com/mrss/\"
          xmlns:turbo=\"http://turbo.yandex.ru\"
          version=\"2.0\"
        >
				<channel>
				<title>".$rss_title."</title>
				<link>".SITEURL."</link>
				<description>".$tp->toRss($pref['sitedescription'])."</description>\n
				<language>".CORE_LC."</language>\n";
      /*
      <turbo:analytics type="Yandex" id="123456"></turbo:analytics>
            <turbo:adNetwork type="AdFox" turbo-ad-id="first_ad_place">
                <![CDATA[
                    <div id="container ID"></div>
                    <script>
                        window.Ya.adfoxCode.create({
                            ownerId: 123456,
                            containerId: 'container ID',
                            params: {
                                pp: 'g',
                                ps: 'cmic',
                                p2: 'fqem'
                            }
                        });
                    </script>
                 ]]>
             </turbo:adNetwork>
             */

        $rlinks = '';
				foreach($this -> rssItems as $value)
				{   // Multi-language rss links.
             
					$itemlink 		= (e_LANQRY) ? str_replace("?","?".e_LANQRY,$value['link']) : $value['link'];
					
					// ?? where is this used, maybe rubbish from rss plugin?
          $catlink	= (e_LANQRY) ? str_replace("?","?".e_LANQRY,$value['category_link']) : $value['category_link'];


					// generate header
					// h1 heade
					$main_title =  $tp->toRss($value['title']);
					// h2 header
					$second_title = ($value['summary'] ? $value['summary'] : '');
					 // header image 
					$page_image =  ($value['pageimage']['media:content']['url']  ? urldecode($value['pageimage']['media:content']['url']) : '');
 
					$menuArray = array();      
					if($pluginPrefs['ytp_pages_navigation']) {
					  $category  = $pluginPrefs['ytp_pages_navigation_data'];
					  if($category) { 
						  $parm = array('flat'=>1);
						  $data = e107::getNav()->initData($category,$parm);  
						  foreach($data as $key => $link) {
						     $menuArray[$key]['url']  =  $link['link_url'];
						     $menuArray[$key]['title']  = $link['link_name'];
							}
					  }
					}
					
					$header = TurboPageHelperContent::header($main_title, $second_title,
					$page_image, $main_title, $menuArray);
		
          $content = $header.$value['turbocontent'];
          
          $fullcontent = $header.$value['fulltext'];
          $turbocontent= $this->turbotags($content);
 
					$final_feed .="<item turbo=\"true\">\n";
					$final_feed .= "<title>".$tp->toRss($value['title'])."</title>\n";
 					$final_feed .= "<link>".$itemlink."</link>\n";
 					$final_feed .= "<author>".$value['author']."</author>\n"; 
	        $final_feed .= "<category>".$tp->toRss($value['category_name'])."</category>\n";
         	$final_feed .= "<pubDate>".date("r", ($value['pubdate']))."</pubDate>\n";
            
					$final_feed .= "<turbo:content>".$turbocontent. "</turbo:content>\n";
					$final_feed .= "<yandex:full-text>".$tp->toRss($fullcontent, true). "</yandex:full-text>\n";
				 
          if($rlinks!=''){
             $final_feed .= '<yandex:related>'.$rlinks.'</yandex:related>';
          }          
					$final_feed .= "</item>\n\n";
				}
 
				$final_feed .= "
				</channel>                                            
				</rss>";

 
        // related links not available
        $rlinks = '';
								
        if ($debug == true) {
            echo '<pre class="prettyprint">' . htmlspecialchars($final_feed) . '</pre>';
        }
								
				if ($display) {
	          echo $final_feed;
	        } else {
	          return $final_feed;
	      }
			break;
			
			//just prepared for custom pages
			case xyz: 
			break;
		}
	}

  function turbotags($text)  {


     $tp = e107::getParser();
     $yandex_turbo_allowed_tags = '<header><p><a><h1><h2><div><h3><menu><figure><img><figcaption><header><ul><ol><li><video><source><br><b><strong><i><em><sup><sub><ins><del><small><big><pre><abbr><u><table><tr><td><th><tbody><col><thead><tfoot><button><iframe><embed><object><param>';     
     $xml_item_content = strip_tags($text, $yandex_turbo_allowed_tags );
          // removing empty p tags
	    $xml_item_content = preg_replace('/<p>\s*<\/p>/', '', $xml_item_content );
      // removing classes - formatting
	    $xml_item_content = preg_replace('/class\s*=\s*".*?"/', '', $xml_item_content );
      $xml_item_content = preg_replace('/class\s*=\s*\'.*?\'/', '', $xml_item_content );
      // removing backslashes in closing tags
	    $xml_item_content = preg_replace('/\s+>/', '>', $xml_item_content);
      // replace all comments
      $xml_item_content = preg_replace('/<!--(.|\s)*?-->/', '', $xml_item_content);
      // img
      $xml_item_content = preg_replace('/(<img\s(.+?)\/?>)/is', "<figure>$1</figure>", $xml_item_content);      
      
      $xml_item_content  = $tp->toRss($xml_item_content,true);        
      return $xml_item_content ; 
 
  }
  
	/**
	 * Build an XML Tag
	 * @param string $name
	 * @param array $attributes
	 * @param bool $closing
	 * @return string
	 */
	function buildTag($name='', $attributes=array())
	{
		$tp = e107::getParser();

		if(empty($name))
		{
			return '';
		}

		if(isset($attributes['value']))
		{
			$value = $attributes['value'];
			unset($attributes['value']);
		}

		$text = "\n<".$name;

		foreach($attributes as $att=>$attVal)
		{

			$text .= " ".$att."=\"".$tp->toRss($attVal)."\"";
		}

		$text .= ">";

		if(!empty($value))
		{
			if(is_array($value))
			{
				foreach($value as $t=>$r)
				{
					$text .= $this->buildTag($t,$r);
				}

			}
			else
			{
				$text .= $tp->toRss($value);
			}

		}

		$text .= "</".$name.">\n";

		return $text;
	}

 

 
} // End class rssCreate
