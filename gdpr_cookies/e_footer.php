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
 
/**
 * @file
 * Class instantiation to prepare JavaScript configurations and include css/js
 * files to page header.
 */
if(!defined('e107_INIT'))
{
	exit;
}
// [PLUGINS]/cookie_consent/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('gdpr_cookies', false, true);
/**
 * Class cookie_consent_e_header.
 */
 
 
if(!USER) {
        
$didConsent =  isset($_COOKIE['cookieconsent_status']);
$typeConsent =  e107::pref('gdpr_cookies','gdpr_cookie_type');
$statusConsent =  $_COOKIE['cookieconsent_status'];
$gdpr_cookie_content_href= e107::pref('gdpr_cookies','gdpr_cookie_content_href');
 

 
/* super hard  to be sure*/
if ( $statusConsent == "deny" AND $statusConsent ) {
$past = time() - 3600;

	foreach ($_COOKIE as $key => $value)
	{
	    // delete all cookies except   cookieconsent_status
	    if($key != 'cookieconsent_status')      {
	        setcookie($key, $value, $past, '/');
	    }
	}
}

/* opt in -  not to use cookies before click on allow */ 
if ($typeConsent == 'opt-in' && $statusConsent != 'allow')  {
$past = time() - 3600;
       
	foreach ($_COOKIE as $key => $value)
	{     
	    // delete all cookies except   cookieconsent_status
	    if($key != 'cookieconsent_status')      {
	        unset($_COOKIE[$key]);
 
	      cookie($key, '', 1, '/', $_SERVER['SERVER_NAME']);
	      cookie($key, '', 1, '/', e_DOMAIN);
        cookie($key, '', 1, '/', '.'.e_DOMAIN);
        cookie($key, '', 1, '/', 'www.'.e_DOMAIN);
        cookie($key, '', 1, '/');    
	    }
	}
}
 

} 