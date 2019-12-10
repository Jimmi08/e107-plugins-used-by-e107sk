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

// [PLUGINS]/gallery/languages/[LANGUAGE]/[LANGUAGE]_front.php
//e107::lan('gallery', false, true);

//require_once(e_PLUGIN."download/download_shortcodes.php");
class jm_download_shortcodes extends e_shortcode
{
  public $override = true; // when set to true, existing core/plugin shortcodes matching methods below will be overridden.
  	
	protected $plugPrefs = array();
  
  function __construct() {
  
        //$this->plugPrefs = e107::getPlugConfig('jm_googlead')->getPref();
        $this->plugPrefs = e107::getPlugPref('jm_download');
 
  }
  
	
	//{JM_DOWNLOAD_VIEW_THUMB}
 	function sc_jm_download_view_thumb($parm = '')
	{
		$tp = e107::getParser(); 
		return  $tp->toImage($this->var['download_thumb']);
  }
  
 // {JM_DOWNLOAD_VIEW_LINK}
 	function sc_jm_download_view_link($parm = '')
	{
		$url = e107::url('download', 'item', $this->var);
		return  $url;
  }  
  
  function sc_jm_download_name($parm=null)
  {   	
  $tp = e107::getParser();
	$record = $tp->toHTML($this->var['download_name'],TRUE,'LINKTEXT');
	return $record;
  }  
  
  function sc_jm_download_category($parm=null)
  {   	
   $record = (vartrue($this->plugPrefs['latestmenu_category']) ? "<a href='".e107::url('download', 'category', $this->var)."'>".$this->var['download_category_name']."</a>" : "");
   return $record;
  }
  
  
  
  function sc_jm_download_author($parm=null)
  {   	           
	  if($this->plugPrefs['latestmenu_author']) {
      return ($this->var['download_author'] ? $this->var['download_author'] : "");
    }
  }
  
  
	//{DOWNLOAD_ADMIN_EDIT}    
	/*function sc_download_admin_edit()
	{
	 if($this->plugPrefs['latestmenu_adminlink']) {
 
		 $icon = "<img src='".e_IMAGE_ABS."generic/edit.png' alt='*' style='padding:0px;border:0px' />";
		 $url = e_PLUGIN_ABS."download/admin_download.php?action=edit&id=".$this->var['download_id'];
		 // 6 - Access to Media Manager
		 return (ADMIN && getperms('6')) ? "<a class='hidden-print' href='".$url."' title='".LAN_EDIT."'>".$icon."</a>" : "";
	 }
	 else {
	    return '';
	 }
	}    */
	
	//{JM_DOWNLOAD_ADMIN_EDIT}    
	function sc_jm_download_admin_edit()
	{
	 if($this->plugPrefs['latestmenu_adminlink']) {
 
		 $icon = "<img src='".e_IMAGE_ABS."generic/edit.png' alt='*' style='padding:0px;border:0px' />";
		 $url = e_PLUGIN_ABS."download/admin_download.php?action=edit&id=".$this->var['download_id'];
		 // 6 - Access to Media Manager
		 return (ADMIN && getperms('6')) ? "<a class='hidden-print' href='".$url."' title='".LAN_EDIT."'>".$icon."</a>" : "";
	 }
	 else {
	    return '';
	 }
	} 	
	  
}
