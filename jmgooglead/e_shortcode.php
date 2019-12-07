<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
* $Id: e_shortcode.php 12438 2011-12-05 15:12:56Z secretr $
*
* Featurebox shortcode batch class - shortcodes available site-wide. ie. equivalent to multiple .sc files.
*/

if(!defined('e107_INIT'))
{
	exit;
}



class jmgooglead_shortcodes extends e_shortcode
{
	public $override = false; // when set to true, existing core/plugin shortcodes matching methods below will be overridden. 
  
  protected $plugPrefs = array();
  
  function __construct() {
  
        //$this->plugPrefs = e107::getPlugConfig('jmgooglead')->getPref();
        $this->plugPrefs = e107::getPlugPref('jmgooglead');
 
  }

	// Example: {JM_DISABLEBLOCK_CODE} shortcode - available site-wide.
	function sc_jm_disableblock_code($parm = null)  // Naming:  "sc_" + [plugin-directory] + '_uniquename'
	{
	  if($this->plugPrefs['disableblock_active'] && $this->plugPrefs['disableblock_code'] != '')  { 
    $code =  html_entity_decode($this->plugPrefs['disableblock_code'], ENT_QUOTES);   
	  return $code ;
	  }   	 
	}


	// Example: {JM_GOOGLE_AD: id=xxx} shortcode - available site-wide.
	function sc_jm_google_ad($parm = null)  // Naming:  "sc_" + [plugin-directory] + '_uniquename'
	{
		//check if it is not excluded page
		$request_url = e_REQUEST_URL;
		$c_url = str_replace(array('&amp;'), array('&'), $request_url);
		$c_url = rtrim(rawurldecode($c_url), '?'); 
 
		$tmp 		= e107::pref('jmgooglead','googleads_blockpages');
		$tmp 		= str_replace("\r", "", $tmp);
		$blockedpages 	= explode("\n", trim($tmp));

		foreach($blockedpages as $url) {
			if( strpos( $c_url, $url) !== false ) {
				return '';
			}
		}
		 
		// check if parm ID is set and banner is active  
		 if($parm['id'] > 0  ) {
			// select data and code
			$id=$parm['id']; 
			$where =  "googlead_id=".$id. " AND googlead_class IN (".USERCLASS_LIST.")";
			$banner = e107::getDB()->retrieve('jmgooglead', 'googlead_id,googlead_code,googlead_active,googlead_class' , $where);
 
			// banner is active, code is inserted
			  if($banner['googlead_active'] && $banner['googlead_code'] !='' ) {
					// return code
					$code = html_entity_decode($banner['googlead_code'], ENT_QUOTES); 
					return $code;
				}
				else return '';	
 
		 }
		 else return '';
	}
}
