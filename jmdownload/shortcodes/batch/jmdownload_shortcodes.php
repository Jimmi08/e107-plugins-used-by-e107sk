<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
* $Id: e_shortcode.php 12438 2011-12-05 15:12:56Z secretr $
*
* Local shortcodes for special menus
*/

if (!defined('e107_INIT')) {
    exit;
}
 
e107::lan("jmdownload" , "lan_menu");

//require_once(e_PLUGIN."download/download_shortcodes.php");
class plugin_jmdownload_jmdownload_shortcodes extends e_shortcode
{
    public $override = true; // when set to true, existing core/plugin shortcodes matching methods below will be overridden.
    
    protected $plugPrefs = array();
  
    public function __construct()
    {
  
        //$this->plugPrefs = e107::getPlugConfig('jm_googlead')->getPref();
        $this->plugPrefs = e107::getPlugPref('jmdownload');
    }
  
    
    //{JM_DOWNLOAD_VIEW_THUMB}
    public function sc_jmdownload_view_thumb($parm = '')
    {
        $tp = e107::getParser();
        return  $tp->toImage($this->var['download_thumb']);
    }
  
    // {JMDOWNLOAD_VIEW_LINK}
    public function sc_jmdownload_view_link($parm = '')
    {
        $url = e107::url('download', 'item', $this->var);
        return  $url;
    }
  
	// {JMDOWNLOAD_NAME}
	public function sc_jmdownload_name($parm=null)
    {
        $tp = e107::getParser();
        $record = $tp->toHTML($this->var['download_name'], true, 'LINKTEXT');
        return $record;
    }
  
	// {JMDOWNLOAD_CATEGORY}
    public function sc_jmdownload_category($parm=null)
    {
        $record = (vartrue($this->plugPrefs['menus_category']) ? "<a href='".e107::url('download', 'category', $this->var)."'>".$this->var['download_category_name']."</a>" : "");
        return $record;
	}
	
  
    /* {JMDOWNLOAD_DESCRIPTION} */
    public function sc_jmdownload_description($parm=null)
    {
        if ($this->plugPrefs['menus_description']) {
            $download_description =  e107::getParser()->toText($this->var['download_description'], true, 'TITLE');
       
            if ($this->plugPrefs['menus_usepagebreak'] > 0) {
                $texts = explode("<!-- pagebreak -->", $download_description);
                /* there is summary */
                $download_description =  $texts[0];
            }
            if ($this->plugPrefs['menus_maxchars'] > 0) {
                $download_description = e107::getParser()->html_truncate($download_description, $this->plugPrefs['menus_maxchars'], "&nbsp;");
            }
      
            if ($this->plugPrefs['menus_readmore'] > 0) {
                $download_description .= "<br /><a href='".$this->sc_jmdownload_view_link()."'><strong>" . LAN_READ_MORE . "</strong></a>";
            }
 
            return $download_description;
        }
    }

    /* {JMDOWNLOAD_AUTHOR} */
    public function sc_jmdownload_author($parm=null)
    {
        if ($this->plugPrefs['menus_author']) {
            return ($this->var['download_author'] ? $this->var['download_author'] : "");
        }
    }

    /* {JMDOWNLOAD_SIZE} */
    public function sc_jmdownload_size($parm=null)
    {
        if ($this->plugPrefs['menus_size']) {
            return ($this->var['download_filesize'] ? eHelper::parseMemorySize($this->var['download_filesize']) : "");
        }
    }
 
    
    //{JMDOWNLOAD_ADMIN_EDIT}
    public function sc_jmdownload_admin_edit($parm=null)
    {
        if ($this->plugPrefs['menus_adminlink']) {
            $icon = "<img src='".e_IMAGE_ABS."generic/edit.png' alt='*' style='padding:0px;border:0px' />";
            $url = e_PLUGIN_ABS."download/admin_download.php?action=edit&id=".$this->var['download_id'];
            // 6 - Access to Media Manager
            return (ADMIN && getperms('6')) ? "<a class='hidden-print' href='".$url."' title='".LAN_EDIT."'>".$icon."</a>" : "";
        } else {
            return '';
        }
	}
	
    /* {JMDOWNLOAD_LAST_PERIOD_COUNT} */
    public function sc_jmdownload_last_period_count($parm=null)
    {
	 $text = $this->var['download_this_period_count'];
	 
	 return $text;
 
    }

	public function sc_download_period($parm='', $mode='')
	{
		if(0 == $this->var['period']) {
			return LAN_JMD_TOPDOWNLOADS_ALL_TIME;
		}
		return (7 == $this->var['period'] ? LAN_JMD_TOPDOWNLOADS_WEEK : LAN_JMD_TOPDOWNLOADS_MONTH);
	}
	
}
