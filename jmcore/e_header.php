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

    //colored navigation submenu header
    $adminlook_navheaders  = e107::pref('jmcore','adminlook_navheaders', true);

    if($adminlook_navheaders)  {
    
     $navheader_bg      = e107::pref('jmcore','adminlook_navheader_bg', "#EEE");
     $navheader_color   = e107::pref('jmcore','adminlook_navheader_color', "#222");     
     
     /* not standard solution for KA Admin
     .admin-left-panel li.nav-header {
        color: white;
     }
     */

        $css = " li.nav-header { 
        text-transform: uppercase;
        background: {$navheader_bg};
        color: {$navheader_color}; 
        } 
       .admin-left-panel li.nav-header {
           color: {$navheader_color};
       }        
        
        ";
        
        
        e107::css('inline', $css); 
    }

 
     /* not needed after changing class, left here as example how to do it without it 
     $removetooltips  = e107::pref('jmcore','adminlook_removetooltips', true);
     if($removetooltips) {
     $css .= ' div.field-help,
               span.field-help     
               {
                  font-size: 11px;
                  display: block!important;
               } 
    '; */
    


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
    
  $removetooltips  = e107::pref('jmcore','adminlook_removetooltips', true);
 
  if($removetooltips) { 
    $js2 = "
  	$(document).ready(function() {
      $('td').find('div.field-help').each(function() {
       $(this).removeClass('field-help').addClass('smalltext') ;
    	} ); 
      $('span').find('.field-help').each(function() {
       $(this).removeClass('field-help').addClass('smalltext') ;
    	} );     
      
  		});		
  	";    
    e107::js('inline', $js2); 
    }

}