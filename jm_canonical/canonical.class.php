<?php

class Canonical  { 


	/**
  	 * Canonical Plugin preferencies
  	 *
  	 * @var array
  	 */
  	protected $CanonicalPrefs = false;
    			
	/**
  	 * Operational Run Check - to run tests
  	 *
  	 * @var boolean
  	 */
  	var $CanonicalRunCheck = false;
    

	/**
  	 * Operational Active - if plugin is active on Frontend
  	 *
  	 * @var boolean
  	 */
  	protected $CanonicalActive = false;
 

	/**
  	 * Canonical Array Status
  	 *
  	 * @var array
  	 */
  	var $CanonicalStatus = array();
    
	public function __construct()
	{
		$this->setCanonicalPrefs()
				->setCanonicalRunCheck()            	
		->setCanonicalActive()
		->setCanonicalStatus()  
			;

	}
    
    /**
  	 * Sets Canonical Plugins::$Prefs - plugin preferences
  	 *
  	*/
  	protected function setCanonicalPrefs()
  	{
  		$this->CanonicalPrefs = e107::getPlugPref('jm_canonical');
  		return $this;
  	}
    

    /**
  	 * Gets Canonical Plugins Prefs - plugin preferences
  	 *
  	 */
  	protected function getCanonicalPrefs()
  	{
  		return $this->CanonicalPrefs;
  	}
    
        
  	/**
  	 * Sets $CanonicalRunCheck - based on the plugin preference 'run_check'
  	 *
  	 */
  	protected function setCanonicalRunCheck()
  	{
  		$this->CanonicalRunCheck = $this->CanonicalPrefs['run_check'];
  		return $this;
  	}
    
  	/**
  	 * gets $CanonicalRunCheck - based on the plugin preference 'run_check'
  	 *
  	 */
  	function getCanonicalRunCheck()
  	{
  		return $this->CanonicalRunCheck;
  	}
    
  	/**
  	 * Sets $CanonicalRunCheck - based on the plugin preference 'active'
  	 *
  	 */
  	protected function setCanonicalActive()
  	{
  		$this->CanonicalActive = $this->CanonicalPrefs['active'];
  		return $this;
  	}
    
  	/**
  	 * gets $CanonicalRunCheck - based on the plugin preference 'run_check'
  	 *
  	 */
  	function getCanonicalActive()
  	{
  		return $this->CanonicalActive;
  	}    
    
    
  	function setCanonicalStatus()
  	{
		$this->CanonicalStatus = array( 
		'200' => "200: Success ",
		'400' => "400: Invalid request ",
		'404' => "404: Not found ",
		'500' => "500: server error ",
		'502' => "502: server error ",  
		'503' => "503: service unavailable ",  
						
		);
		
		return $this;
    }
 
 
 
	function runFixConstants() 
	{
		/* FIX for missing e_PAGE defined with SEF-URL */
		if (!defined('e_PAGE') AND strpos(e_URL_LEGACY, 'download.php') !== false)     
		{
			define("e_PAGE", 'download.php');
		}
		if (!defined('e_PAGE') AND strpos(e_URL_LEGACY, 'forum_viewtopic.php') !== false)     
		{
			define("e_PAGE", 'forum_viewtopic.php');
		}		
		if (!defined('e_PAGE') AND strpos(e_URL_LEGACY, 'forum_viewforum.php') !== false)     
		{
			define("e_PAGE", 'forum_viewforum.php');
		}		
		if (!defined('e_PAGE') AND strpos(e_URL_LEGACY, 'forum.php') !== false)     
		{
			define("e_PAGE", 'forum.php');
		}		
		if (!defined('e_PAGE') AND strpos(e_CURRENT_PLUGIN, 'download') !== false)     
		{
			define("e_PAGE", 'download.php');
		}			  
		

	}
		
		
	function getManualCanonicalUrl($requestedUrl = '', $return = false)  
	{
		$sql = e107::getDb();
		
		$result = false;
		
		$query = "SELECT c.canonical_url, r.canru_redirect FROM #canonical_request_urls AS r LEFT JOIN #canonical_urls AS c 
					ON r.canonical_id = c.canonical_id
					WHERE r.canru_url = '" . $requestedUrl . "' LIMIT 1";
					
		if ($sql->gen($query))
		{
			if ($url = $sql->fetch($query))
			{
				$canonicalurl = $url['canonical_url'];
				// redirect 
				if($url['canru_redirect'])  {
					e107::redirect($canonicalurl, 301);
					exit;
				}

				if($return) 
				{ 
					return $canonicalurl; 
				}
									
				e107::link(array('rel'=>"canonical", "href" =>$canonicalurl ));
				
				//debug info
				$type = "from canonical_request_urls table";
				$this->renderDebugInfo($canonicalurl,  $type );
				return true;
			}
		}		
	}
		
	function getRelatedCanonicalUrl($element_type = '', $element_id = 0, $backslash = true, $p = 0, $return = false )  
	{
		$sql = e107::getDb();         
		if($element_type == '')  
		{
			return false; 
		}    
		// TODO check allowed types
		if($element_id < 1 )  
		{ 
			return false; 
		}
		
		if ($row = e107::getDb()->retrieve("canonical", "can_url, can_redirect", "can_table='{$element_type}' AND can_pid={$element_id}" ))
		{
			if($row['can_url']  == '' ) 
			{  
				return false; 
			}
			$canonicalurl=$row['can_url'];  
			if($row['can_redirect'])  
			{
				e107::redirect($canonicalurl);
				exit;
			}
	
			// add backslash to canonical url  TODO: reductant now
			if($backslash) 
			{
				if(substr($canonicalurl, -1) != "/" && substr($canonicalurl, -5) != ".html" && substr($canonicalurl, -4) != ".php" ) 
				{
					$canonicalurl.= "/";
				}
			}     

			if (!empty($p) && $p!=1)
			{
				$canonicalurl.= $p;
			}

			if($return) 
			{ 
				return $canonicalurl; 
			}
			
			e107::link(array('rel'=>"canonical", "href" =>$canonicalurl ));
			
			$type = "{$element_type} related urls with id= {$element_id} ";
			echo "\n";
			
			$this->renderDebugInfo($canonicalurl,  $type );
			return true;
		}     

	}
		
	function getAutogeneratedCanonicalUrl($element_type = '', $auto_type = '', $backslash = false, $return = false)  
	{
	
		switch($auto_type) 
		{
			case "none" : 
			case "" :
				$canonicalurl = '';
				$type = "Nothing is generated";
				break;
			case "sefurl" :
				$canonicalurl = e_REQUEST_URL;
				$type = "{$element_type}: autogenerated from e_REQUEST_URL";
				echo "<link rel='canonical' href='" . $canonicalurl . "' />\n";
				break;						     
			case "page" :
				$canonicalurl = SITEURL . e_PAGE;
				if (e_QUERY)
				{
					$canonicalurl.= "?" . e_QUERY;
				}
				$type = "{$element_type}: autogenerated from e_PAGE + e_QUERY";
				echo "<link rel='canonical' href='" . $canonicalurl . "' />\n";
				break;
			default:  
				$type = "Something is wrong with autogeneration";	
				break;					    
		}

		// add backslash to canonical url  TODO: reductant now
		if($backslash) 
		{
			if(substr($canonicalurl, -1) != "/" && substr($canonicalurl, -5) != ".html" && substr($canonicalurl, -4) != ".php" ) 
			{
				$canonicalurl.= "/";
			}
		}  
		if($return) { 
				return $canonicalurl; 
		}  

		echo '<link rel="canonical" href="' . $canonicalurl . '" />';
		echo "\n";        
		$this->renderDebugInfo($canonicalurl, $type );
		return true;
	}		
		
	function renderDebugInfo($canonicalurl = '', $type = '') 
	{
		$mes = e107::getMessage();
		if (getperms('0') && $this->CanonicalPrefs['debug_frontend'])
		{    
			$debugtext = "Canonical URL:  " . $canonicalurl . "<br /> Type: " . $type . "<br /> e_REQUEST_URL " . e_REQUEST_URL;
			$debugtext.= "<br /> e_REQUEST_URI " . e_REQUEST_URI;
			$debugtext.= "<br /> e_URL_LEGACY " . e_URL_LEGACY;
			$debugtext.= "<br /> SITEURL      " . SITEURL;
			$debugtext.= "<br /> e_PAGE       " . e_PAGE;
			$debugtext.= "<br /> e_QUERY     " . e_QUERY;
			$debugtext.= "<br /> e_CURRENT_PLUGIN " . e_CURRENT_PLUGIN;
		//	print_a($_GET);	
			$mes->addInfo($debugtext);	
		}
	}   
}