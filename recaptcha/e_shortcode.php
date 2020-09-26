<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
* https://github.com/e107inc/e107/issues/3980
*/

if(!defined('e107_INIT'))
{
	exit;
}
 
define('HIDEFROMMEMBERS', e107::pref('recaptcha', 'hidefrommembers'));

class recaptcha_shortcodes extends e_shortcode
{

    /* {RECAPTCHA_IMAGE}  not tested */
 	function sc_recaptcha_image($parm='')    { 
 
		return e107::getSecureImg()->r_image();
		//  return "<img src='".e_IMAGE_ABS."secimg.php?id={$code}&amp;clr={$color}' class='icon secure-image' alt='Missing Code' style='max-width:100%' />";
	}
    
    /* {RECAPTCHA_INPUT}  not tested */
 	function sc_recaptcha_input($parm='')  { 
 
		return 	e107::getSecureImg()->renderInput();
		// return "<input class='tbox' type='text' name='code_verify' size='15' maxlength='20' />";	
	}    
    
    /*  {RECAPTCHA} */
 	function sc_recaptcha($parm='')  { 
	   $hidefrommembers = defset('HIDEFROMMEMBERS', false);  
       if(USER && $hidefrommembers) {  
         return "";
       }  
	   return 	e107::getSecureImg()->renderImage().e107::getSecureImg()->renderInput();
		// return "<input class='tbox' type='text' name='code_verify' size='15' maxlength='20' />";	
	}    
    
}

?>