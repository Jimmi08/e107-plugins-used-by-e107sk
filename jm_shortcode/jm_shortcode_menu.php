<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2016 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * jm_shortcode menu file.
 *
 */


if (!defined('e107_INIT')) { exit; }

$text = "";
/*			 	 
if(!empty($parm))
{
  print_a($parm);
 
}   */       

if(isset($parm['shortcode_menuCaption'][e_LANGUAGE]))
{
	$caption = $parm['shortcode_menuCaption'][e_LANGUAGE];
}
else $caption = $parm['shortcode_menuCaption']; 
  
 
$text =  e107::getParser()->parseTemplate($parm['shortcode_menuCode']);
$style =  e107::getParser()->parseTemplate($parm['shortcode_menuTableStyle']); 
e107::getRender()->tablerender($caption, $text, $style );






?>