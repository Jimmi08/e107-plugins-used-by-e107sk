<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Related configuration module - News
 *
 *
*/

if (!defined('e107_INIT')) { exit; }

e107::lan('smartsupp');
 
if(USER_AREA)  
{
	$pluginPrefs = e107::getPlugPref('smartsupp');   
	extract($pluginPrefs);
	if($smartsupp_active) {
		if($smartsupp_code  != '') {
			 
			$script =  html_entity_decode($smartsupp_code, ENT_QUOTES);  
			
			e107::js('inline', $script); 
		}
	
	  /* language for multilanguge site */
	  /* todo: Check supported languages vs CORE_LC : 
		en, ar, az, bg, br, ca, cn, cs, da, de, el, es, fa, fi, fr, he, hi, hr, hu, is, it, ja, ka, lt, lv, mk, nl, no, pl, pt, ro, ru, sk, sl, sr, sv, th, tr, tw, uk
	  */
	  if($smartsupp_siteLanguage)  {
		  $smartsupp_language = e_LAN;
		}
 
     
		/* e107 users info */
		 if(!USERID) // Logged Out. 
		 {
		 			$smartsupp_dashboard_name = '';
          $smartsupp_dashboard_email = '';
          $smartsupp_variables_enabled = '0';
          $smartsupp_variables_js = '';
		 }
		 else {
		   if ($smartsupp_enableVariables)   // enable user information
			 {  
			   $currentUser = e107::user(USERID);
	       
			   $smartsupp_variables_js = '';
			   
			   // just to be sure that admins know what they are doing
			   // Visitor section
				 if ($smartsupp_showVisitorName) {
							$smartsupp_dashboard_name = $currentUser['user_name'];
				 }
         if ($smartsupp_showVisitorEmail) {
	       $smartsupp_dashboard_email = $currentUser['user_email'];
	       }
	       
	       // Customer section
			   if ($smartsupp_showId) {
	             $smartsupp_variables_js .= 'id : {label: "' . LAN_SMARTSUPP_ID . '", value: "' . USERID . '"},';
	       }
	 		   if ($smartsupp_showName) {
	             $smartsupp_variables_js .= 'name : {label: "' . LAN_SMARTSUPP_EMAIL . '", value: "' . $currentUser['user_name'] . '"},';
	       }
			   if ($smartsupp_showEmail) {
	             $smartsupp_variables_js .= 'email : {label: "' . LAN_SMARTSUPP_USERNAME . '", value: "' . $currentUser['user_email'] . '"},';
	       }
				 			      
       	 $smartsupp_variables_js = trim($smartsupp_variables_js, ', ');
       }
		 }
				
		// this is not allowed  see issue #3506  $script = '<!-- Smartsupp Live Chat script -->';
    $script  = '<script type="text/javascript">';
    
	  if($smartsupp_sitelanguage)  {
		  $script .= "smartsupp('language', '" . $smartsupp_language . "');";
		}
		
    if ($smartsupp_enableVariables && !empty($smartsupp_variables_js)) {
       $script .= "var prSmartsuppVars = {" . $smartsupp_variables_js . "};";
    }
        
    if ($smartsupp_showVisitorName) {    
			$script .= "smartsupp('name', '" . $smartsupp_dashboard_name . "');";
		}
		
		if ($smartsupp_showVisitorEmail) {
			$script .= "smartsupp('email', '" . $smartsupp_dashboard_email . "');";
		}
		
    if ($smartsupp_enableVariables && !empty($smartsupp_variables_js)) {
        $script .= "smartsupp('variables', prSmartsuppVars);";
    }
    $script .= '</script>';	
    e107::js('inline', $script); 		 
	}
}



?>