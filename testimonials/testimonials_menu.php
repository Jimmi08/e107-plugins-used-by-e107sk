<?php
/**
 * Testimonials plugin for e107 v2.
 *
 * @file
 * Class to render Testimonials menu.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/testimonials/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('testimonials', false, true);

class testimonials_menu
{

	/**
	 * Store plugin preferences.
	 *
	 * @var mixed|null
	 */
	private $plugPrefs = null;


	/**
	 * Store testimonial items.
	 *
	 * @var array
	 */
	private $testimonials = array();


  private $template = array();
  
  private $template_key = 'menu';
	/**
	 * Constructor.
	 */
	function __construct($template_key = 'menu')
	{
		// Get plugin preferences.
		$this->plugPrefs = e107::getPlugConfig('testimonials')->getPref();
    $this->template_key = $template_key;
		$this->plugTemplate= e107::getTemplate('testimonials', null, $this->template_key , true, true);
 
		foreach($this->plugTemplate['css'] as $css)  {
		    e107::css($css[0], $css[1]);
		}

		foreach($this->plugTemplate['js'] as $js)  {	  
		    e107::js($js[0], $js[1], "jquery");
		}     
 
    $this->renderMenu();
	}


	/**
	 * Render testimonials menu.
	 */
	function renderMenu()
	{
 
		$cache = e107::getConfig();

		// if(!$text = $cache->get("testimonials"))
		// {
			$this->getItems();
			$count = count($this->testimonials);    
			if($count > 0)  {
 
 					$sc = e107::getScBatch('testimonials', true);
					$tp = e107::getParser();
		
					preg_match('/\{TESTIMONIALS_ITEMS=(\d)\}/',$this->plugTemplate['body'],$m);
		
					$limit = (!empty($m[1])) ? (int) $m[1] : 1;
 
					$grouped = $this->getGrouped($limit);
		
		
					$sc->setVars(array('count' => count($grouped)));
		
				//	$sc->setVars(array('count' => count($this->testimonials)));
		
		
					$text = $tp->parseTemplate($this->plugTemplate['header'], true, $sc);
		
		      if($this->plugTemplate['body']) {
					foreach($grouped as $key => $val)
					{
						$val['active'] = ((int) $key === 0);
						$val['template_key'] = $this->template_key;
						$sc->setVars($val);
						$text .= $tp->parseTemplate($this->plugTemplate['body'], true, $sc);
					}
          }
          else {
              foreach($this->testimonials as $key => $val)  {
							    $val['active'] = ((int) $key === 0);     
                                $val['template_key'] = $this->template_key;   
							    $sc->setVars($val);
								$text .= $tp->parseTemplate($this->plugTemplate['item'], true, $sc);							    
					}
					
					}
		
					$text .= $tp->parseTemplate($this->plugTemplate['footer'], true, $sc);
		
					$cache->set("testimonials", $text);
				// }
			 
			  $caption = e107::getParser()->toHTML($this->plugPrefs['tm_menu_caption'],true, 'TITLE'); // incase a LAN is used.
		
		    $tablerender = varset($this->plugTemplate['tablerender'], "testimonials");       
				e107::getRender()->tablerender($caption, $text, $tablerender);
        }
	}

	function getGrouped($count=3)
	{
		$c = 0;
		$arr = array();
		$cnt = 0;

		foreach($this->testimonials as $row)
		{

			if($cnt > ($count - 1))
			{
				$c++;
				$cnt = 0;
			}


			$arr[$c][] = $row;

			$cnt++;

		}


		return $arr;
	}



	/**
	 * Select messages from database.
	 */
	function getItems()
	{
	  
		$db = e107::getDb('testimonials');

		$query = 'SELECT t.*, u.user_id, u.user_name, u.user_image FROM #testimonials AS t ';
		$query .= 'LEFT JOIN #user AS u ON SUBSTRING_INDEX(t.tm_name,".",1) = u.user_id ';
		$query .= 'WHERE t.tm_blocked IN ('.USERCLASS_LIST.') ';
	//	$query .= 'ORDER BY rand() '; // TODO add a pref for random
			$query .= 'ORDER BY tm_order ';
		$query .= 'LIMIT 0, ' . (int) $this->plugPrefs['tm_menu_items'];
 
		$db->gen($query);

		while($row = $db->fetch())
		{
			$item = $row;
	 
			list($tm_uid, $tm_nick) = explode(".", $row['tm_name'], 2);
			$item['user_name'] = $tm_nick;

			if (!empty($item['tm_url'])) {
				if (strpos($item['tm_url'], 'http') === FALSE) {
					$item['tm_url'] = 'http://' . $item['tm_url'];
				}
			}

			$this->testimonials[] = $item;
		}
	}   
}
 
$template_key = $parm['template'] ?? 'menu';        

new testimonials_menu($template_key);

 
