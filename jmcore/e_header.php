<?php
/*
* e107 website system
*
* Copyright (C) 2008-2015 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* Plugin JM core
*
*
*/

if (!defined('e107_INIT'))
{
	exit;
}  

/******************************************************************************/
/*  Google Search console issue                                               */
/*  Indexed, though blocked by robots.txt                                     */
/*  don't forget remove blocking from robots.txt                              */
/******************************************************************************/
if (e_PAGE == "login.php") {
   e107::meta('robots', 'noindex');
}
if (e_PAGE == "signup.php") {
   e107::meta('robots', 'noindex');
}
if (e_PAGE == "fpw.php") {
   e107::meta('robots', 'noindex');
}
 

/******************************************************************************/
/*  CSS FIX for admin area with bootstrap3 theme                              */
/*                                */
/******************************************************************************/

if (ADMIN_AREA) {   
    //coloured navigation submenu header
    $css = ' li.nav-header { 
        text-transform: uppercase;
        background: #eee;
        color: #222; } ';
    e107::css('inline', $css); 

}


/******************************************************************************/
/*  JS FIX for missing titles in main admin area with bootstrap3 theme        */
/*                                																						*/
/******************************************************************************/

if (ADMIN_AREA) {   
    //coloured navigation submenu header
    $js = "
		$(document).ready(function() {
    $('ul.nav-admin').find('span.hidden-lg').each(function() {
  	 $(this).removeClass('hidden-lg');
  	} ); 
		});		
	";
    e107::js('footer-inline', $js); 

}