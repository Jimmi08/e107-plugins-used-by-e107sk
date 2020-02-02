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

$text = "";


/* CAPTION FROM MENU SETTINGS */
$menu_caption = '';
if(isset($parm['menuCaption'][e_LANGUAGE]))
{
	$menu_caption = $parm['menuCaption'][e_LANGUAGE];
}
else $menu_caption = $parm['menuCaption']; 

$vars = array('{MENU_CAPTION}' => $menu_caption);

$caption  = str_replace(array_keys($vars), $vars, $template['caption']);    


/* ITEM LIMIT FROM MENU SETTINGS */
$menu_limit = 0;
if(isset($parm['menuLimit']))
{
	$menu_limit = $parm['menuLimit'];
}
else $menu_limit = $parm['menuLimit']; 


/* TABLERENDER FROM MENU SETTINGS */
$menu_tablestyle = 0;
if(isset($parm['menuTableStyle']))
{
	$menu_tablestyle = $parm['menuTableStyle'];
}
else $menu_tablestyle = $parm['menuTableStyle']; 


$template = e107::getTemplate('jmdownload', 'latest_menu'); 
$item = $template['item'];
 
require_once(e_PLUGIN."/jmdownload/classes/latest_downloads_class.php");

$class = new latest_downloads_list();  
$listArray = $class->getListData($menu_limit);
 
$start    =  $tp->parseTemplate($template[$sectiontemplate]['start'] );

$sc = e107::getScBatch('jmdownload', 'jmdownload');
 
$sc->wrapper('jmdownload/latest_menu');
 
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
		'{JM_DOWNLOAD_VIEW_DATE_SHORT}' => e107::getDate()->convert_date($v['download_datestamp'], "short"),
		'{JM_DOWNLOAD_VIEW_DATE_RELATIVE}' => e107::getDate()->convert_date($v['download_datestamp'], "relative"),
		'{JM_DOWNLOAD_VIEW_THUMB}' => $tp->toImage($v['download_thumb'])
	);   	 
	$sc->setVars($v);   
 
	$template['item'] = str_replace(array_keys($vars), $vars, $item);    

    $items    .=  $tp->parseTemplate($template['item']['item'], true, $sc);
         
}

e107::getRender()->tablerender($caption, $start.$items.$end, $tablestyle);



?>