<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
* $Id: e_shortcode.php 12438 2011-12-05 15:12:56Z secretr $
*
*/

if(!defined('e107_INIT'))
{
	exit;
}



class recaptcha_shortcodes extends e_shortcode
{

    /* {RECAPTCHA_IMAGE}  */
 	function sc_recaptcha_image($parm='')    { 
 
		return e107::getSecureImg()->r_image();
		//  return "<img src='".e_IMAGE_ABS."secimg.php?id={$code}&amp;clr={$color}' class='icon secure-image' alt='Missing Code' style='max-width:100%' />";
	}
    
    /* {RECAPTCHA_INPUT}  */
 	function sc_recaptcha_input($parm='')  { 
 
		return 	e107::getSecureImg()->renderInput();
		// return "<input class='tbox' type='text' name='code_verify' size='15' maxlength='20' />";	
	}    
    
    /*  {RECAPTCHA} */
 	function sc_recaptcha($parm='')  { 
     /*  if(USER)  {  
         return "";
       }  */
	   return 	e107::getSecureImg()->renderImage().e107::getSecureImg()->renderInput();
		// return "<input class='tbox' type='text' name='code_verify' size='15' maxlength='20' />";	
	}    
    
}

?>