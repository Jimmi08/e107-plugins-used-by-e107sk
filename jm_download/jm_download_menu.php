<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2016 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * jm_download menu file.
 *
 */


if (!defined('e107_INIT')) { exit; }

// $sql = e107::getDB(); 				// mysql class object
// $frm = e107::getForm(); 				// Form element class.
// $ns = e107::getRender();				// render in theme box.

$template = e107::getTemplate('jm_download','jm_download', 'latest_menu'); 
$item = $template['item'];
 
$file = "jm_download";

require_once(e_PLUGIN.$file."/jm_e_list.php");

$class = new list_download();   // jm_version in jm_e_list.php
$listArray = $class->getListData();
 
$start    =  $tp->parseTemplate($template[$sectiontemplate]['start'], true, $sc);

$sc1 = e107::getScBatch('jm_download',true);
 
$sc1->wrapper('jm_download/latest_menu');

$caption  =  $tp->parseTemplate($template['caption'], true, $sc);
$start    =  $tp->parseTemplate($template['start'], true, $sc);
$end      =  $tp->parseTemplate($template['end'], true, $sc);

$items ='';
foreach ($listArray as  $v)
{			

	// missing core shortcodes
	// {DOWNLOAD_VIEW_DATE=%Y-%m-%d %H:%M:%S} returs span tags
	// {DOWNLOAD_VIEW_DATE=short} returs span tags
 
	$vars = array( 
			'{JM_DOWNLOAD_VIEW_DATETIME}' => e107::getDate()->convert_date($v['download_datestamp'], "%Y-%m-%d %H:%M:%S"),
			'{JM_DOWNLOAD_VIEW_DATE}' => e107::getDate()->convert_date($v['download_datestamp'], "short"),
	//		'{JM_DOWNLOAD_VIEW_THUMB}' => $tp->toImage($v['download_thumb']) 

	);   	 
	$sc1->setVars($v);   
	$template['item'] = str_replace(array_keys($vars), $vars, $item);    
  
  $items    .=  $tp->parseTemplate($template['item'], true, $sc1);
  
            
}
 
 
e107::getRender()->tablerender($caption, $start.$items.$end, 'jm-download');






?>