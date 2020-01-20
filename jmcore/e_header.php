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
    $css = '';
    //colored navigation submenu header
    $adminlook_navheaders  = e107::pref('jmcore','adminlook_navheaders', true);

    if($adminlook_navheaders)  {
                                
     $navheader_bg      = trim(e107::pref('jmcore','adminlook_navheader_bg', "#EEE"));
     
     /* $custom_bg_primary      = varset($navheader_bg, "#EEE"); 
     $custom_bg_primary_color  = trim(e107::pref('jmcore','adminlook_navheader_color', "#dc6767"));  */   
     
		 $custom_bg_primary = "#dc6767";     
		 $custom_bg_primary_color = "#fff";
		   
	   $custom_bg_white = "#FFF";   
	   $custom_bg_light = "#e5e5e5";    
		 $custom_bg_light_color = "#222";	     
	   $custom_bg_dark = "#3C3C3C"; 
		 $custom_bg_dark_hover = "#303030";    
		 $custom_bg_dark_color = "#d9d9d9";
 
	

       //if KA Admin
      if(e107::getPref('admincss') == "css/kadmin.css") {  
					 
        $css .= "
				   li.nav-header { 
				        text-transform: uppercase;
				        background: {$custom_bg_light};
				        color: {$custom_bg_light_color}; 
		        } 
		       .admin-left-panel li.nav-header {
		           color: {$custom_bg_light_color};
		       }  
					 
            #admin-ui-list-batch, .adminlist > thead > tr {
                background-color: {$custom_bg_primary};
                color: {$custom_bg_primary_color}; 
            }
            .table .nav-tabs a, .table th a  {
                background-color: {$custom_bg_primary};
                color: {$custom_bg_primary_color}; 
            }
            
						.admin-left-panel {
						  background: {$custom_bg_dark};
						  color: {$custom_bg_dark_color}; 
						}
						
						.admin-container .admin-left-panel .panel  {
						  background: {$custom_bg_dark};
						  color: {$custom_bg_dark_color}; 
						}
							 				
						.plugin-navigation li a,
						.admin-left-panel li a,
						.admin-container .panel li a
						  {
						    color: {$custom_bg_dark_color};
						    padding: 15px;
						}

						.plugin-navigation li a:hover,
						.plugin-navigation li a:focus {
							background: {$custom_bg_dark_hover}; 
						  transition: 0.2s all ease-in-out;
						  outline: none;
						  color:#FFF;
						}
					
						#admin-ui-nav-menu li.divider {
						     padding-top:  0px;  
						     border-bottom: 0px; 
						     margin-bottom: 0px;
						}
 
 						/* flexpanel */
            #menu-area-07 .panel-heading,
						#core-infopanel-mye107 .panel-heading,
						#core-infopanel-news .panel-heading,
						#plug-infopanel-user-0  .panel-heading  {
						    background-color: {$custom_bg_primary};
						    color: {$custom_bg_primary_color}; 
						}
						
						/* infopanel */
						.admin-main-content .panel-heading  {
						    background-color: {$custom_bg_primary};
						    color: {$custom_bg_primary_color}; 
						} 
						.admin-main-content .panel  {
						    background-color: {$custom_bg_light};
						    color: {$custom_bg_light_color}; 
						} 	
						
						/* tabs */
            #menu-area-07 ,
						#core-infopanel-mye107 .panel-body,
						#core-infopanel-news .panel-body,
						#plug-infopanel-user-0  .panel-body  {
						    background-color: {$custom_bg_light}; 
						    color: {$custom_bg_light_color}; 
						}	
						
							ul.nav.nav-tabs {
							    border-bottom: 0 !important;
							    background: transparent; 
							    color: {$custom_bg_light_color}; 
							}
							
							ul.nav.nav-tabs li {
								    margin-bottom: 0px;
								    border-right: 1px solid {$custom_bg_light_color};
								    border-top: 1px solid {$custom_bg_light_color};
						  }
						  
				      ul.nav.nav-tabs > li > a {
						      margin-right: 0px;  
						      color: $custom_bg_light_color;
						 }
						.core-mainpanel-block .btn-default {
						   background: {$custom_bg_white};
						   background-color: {$custom_bg_white};
						}
            
            #admin-ui-list-db-language span.default {
              color: {$custom_bg_light_color}; 
            }
            
						 table.adminlist {
						  background-color: {$custom_bg_white};
						 }
						
						.e-container {
						  color: {$custom_bg_light_color}; 
						}
						.e-container a {
						  color: {$custom_bg_light_color}; 
						}
						
						.admin-main-content {
						  color: {$custom_bg_light_color};
						}
            
            li.after-submit input[type='radio']  {
              margin-left: 0;
            }
            
             li.after-submit   span {
              margin-left: 20px;
            }           
            
            .btn {
             padding: 10px;
            }
            .btn-default {
                background: {$custom_bg_light};
                border-radius: 0px !important;
            }		
						
						.alert-warning pre {
						  color: #222;
						}
						
						.block-text .panel {
						    background: #FFF;
						    color: #222;
						    border: 0;
						}
						
						.fborder .forumheader3    {
						      border: 1px solid {$custom_bg_light};
						}
			      .adminform {
						   background-color: {$custom_bg_white};
						}
			      .adminform .form-control {
						 background-color: {$custom_bg_light};
						}
        ";
 
      }
     }
     
     $adminlook_navheaders  = e107::pref('jmcore','adminlook_maintitles', true);
     if($adminlook_navheaders) { 
        $css .=  "ul.nav-admin a.navbar-admin-button:after { 
            content: attr(title);
        }";
        /* fix for non standard size, custom breakpoint was changed for admin theme to 1100px */
        /* Medium devices Desktops (>1100px)  .col-lg */
        $css .=  "
        @media all and (min-width: 1101px) and (max-width: 1320px)  {
                       	.nav-admin.navbar-left li a {
                            padding-left: 10px;
                            padding-right: 10px;
                        }
        }
        @media all and (min-width: 1101px) and (max-width: 1150px)  {
                       	.nav-admin.navbar-left li a {
                            font-size: 11px;
                        }
        }        
        "; 
     }
 
     e107::css('inline', $css); 
     
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

    //coloured navigation submenu header     original fix before #4020
   /* $js = "
		$(document).ready(function() {
    $('ul.nav-admin').find('span.hidden-lg').each(function() {
  	 $(this).removeClass('hidden-lg');
  	} ); 
		});		
	";
    e107::js('footer-inline', $js); 
   */  
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