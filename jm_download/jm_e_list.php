<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *
 *
 * $Source: /cvs_backup/e107_0.8/e107_plugins/download/e_list.php,v $
 * $Revision$
 * $Date$
 * $Author$
 */

if (!defined('e107_INIT')) { exit; }

class list_download
{
	protected $plugPrefs = array();
	protected $amount;

	function __construct() {
  
    //$this->plugPrefs = e107::getPlugConfig('jm_googlead')->getPref();
    $this->plugPrefs = e107::getPlugPref('jm_download');
		$this->amount = varset($this->plugPrefs['latestmenu_amount'],6);

  }


	function getListData()
	{                            
		$tp = e107::getParser();
		$sql = e107::getDB();
		
		$list_caption = $this->parent->settings['caption'];
		$list_display = ($this->parent->settings['open'] ? "" : "none");
    
        $qry = "AND d.download_class != '255'";
		//$bullet = $this->parent->getBullet($this->parent->settings['icon']);
    
		$qry = "SELECT d.*, dc.* 
		   FROM #download AS d
		   LEFT JOIN #download_category AS dc ON d.download_category=dc.download_category_id
		   WHERE d.download_active != '0' ".$qry."
		   ORDER BY download_datestamp DESC LIMIT 0,".intval($this->amount)." ";

		$downloads = e107::getDB()->retrieve($qry, true);

    return $downloads;
   }
}
?>