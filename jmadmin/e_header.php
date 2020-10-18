<?php    
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 JMAdmin Plugin
 *
 * #######################################
 * #     e107 website system plugin      #
 * #     by Jimako                    	 #
 * #     https://www.e107sk.com          #
 * #######################################
 */ 


/* THIS PLUGIN IS ONLY FOR ADMIN AREA */

/******************************************************************************/
/*  1. CSS FIX for missing titles in main admin area with bootstrap3 theme    */
/*  2. JX FIX for display help as text not as tooltips                  	  */
/*  3. JS FIX for removing stats graph on dashboard                    	      */
/*  4. JS FIX for removing blog news and full row of plugins           	      */
/*  5. JS FIX for removing e107 links from user right menu           	      */
/******************************************************************************/

if (ADMIN_AREA) {  
	$settings  = e107::pref('jmadmin'); 


	
	/* 1 */
	$adminlook_navheaders = varset($settings['adminlook_maintitles'], true);
	 
	if($adminlook_navheaders) { 
        $css .=  "ul.nav-admin a.navbar-admin-button:after { 
            content: attr(title);
        }";
        
        //JS FIX for missing titles in main admin area with bootstrap3 theme   original fix before #4020
        if (version_compare(e_VERSION, '2.3.0', '<')) {
        $js = "
      		$(document).ready(function() {
          $('ul.nav-admin').find('span.hidden-lg').each(function() {
        	 $(this).removeClass('hidden-lg');
        	} ); 
      		});		
      	";
        }
        e107::js('footer-inline', $js); 
 
        /* fix for non standard size, custom breakpoint was changed for admin theme to 1100px */
        /* Medium devices Desktops (>1100px)  .col-lg */
        $css .=  "
        @media all and (min-width: 1101px) and (max-width: 1320px)  {
                       	.nav-acdmin.navbar-left li a {
                            padding-left: 10px;
                            padding-right: 10px;
                        }
        }
        @media all and (min-width: 1101px) and (max-width: 1150px)  {
                       	.nav-acdmin.navbar-left li a {
							font-size: 11px;
                        }
        }";        
		
		//if KA Admin
			if(true) {  
				$css .= " 
                @media (min-width: 1200px) {
                  .col-lg-2 {
                    width: 20%;
                  }
                  .col-lg-10 {
                    width: 80%;
                  }
                }
                
				@media all and (max-width: 1150px)  {
				.dropdown-menu {
					width: 100%;
				}
				}
				@media (max-width: 767px)  {
					.navbar-nav .open .dropdown-menu {
						background-color: white;
					}
					.navbar-default .navbar-nav .open .dropdown-menu > li > a {
						padding: 10px 15px 10px 25px;
					}
				} 

				ul.nav.nav-admin.navbar-nav.navbar-right:first-of-type li>ul>li:nth-child(4) {
					background: red!important;
				}
			";
		}
	 }
	 /* 2 */
	 $removetooltips  = varset($settings['adminlook_removetooltips'], true); 
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
	 /* 3 */
	 $inline_script = '';
	 $dashboard_remove_stats  = varset($settings['dashboard_remove_stats'], true); 
	 if($dashboard_remove_stats) { 
		$start = "$(document).ready(function() {";
		$end   = "});	";
		$inline_script = " $('#menu-area-02').remove(); ";
	 }
	 /* 4 */
	 $dashboard_remove_news  = varset($settings['dashboard_remove_news'], true); 
	 if($dashboard_remove_news) { 
		$start = "$(document).ready(function() {";
		$end   = "});	";
		/* remove box */
		$inline_script .= " $('#core-infopanel_news').remove(); ";
        $inline_script .= " $('#menu-area-08').remove(); ";  
		/* get plugins to full width */
		$inline_script .= " $('#menu-area-07').parent().removeClass('col-sm-6').addClass('col-sm-12').parent().removeClass('row-flex'); ";
	 } 
	 /* 5 */ 
	 
	 $remove_e107links  = varset($settings['remove_e107links'], true); 
	 if($remove_e107links) { 
		$start = "$(document).ready(function() {";
		$end   = "});	";
		$inline_script .= "  
		 	$('ul.nav.nav-admin.navbar-nav.navbar-right:first').find('li>ul>li:nth-child(8)').remove();	
			$('ul.nav.nav-admin.navbar-nav.navbar-right:first').find('li>ul>li:nth-child(7)').remove();	
		 	$('ul.nav.nav-admin.navbar-nav.navbar-right:first').find('li>ul>li:nth-child(6)').remove();
		 	$('ul.nav.nav-admin.navbar-nav.navbar-right:first').find('li>ul>li:nth-child(5)').remove();	  
		 	$('ul.nav.nav-admin.navbar-nav.navbar-right:first').find('li>ul>li:nth-child(4)').remove();
		 ";
	 }

	 /* 6 */
	$adminlook_kadmin  = varset($settings['adminlook_kadmin'], true); 
    
    $inline_script .= "  
     $('table.adminlist').wrap('<div class=\"table-responsive\"></div>');
     $('#admin-ui-list-filter .form-inline').removeClass('span8 col-md-8').addClass('col-md-12');
    ";
	
    if($adminlook_kadmin) { 


		if(e107::getPref('admincss') == "css/bootstrap-dark.min.css") { 
			e107::css('jmadmin', "css/bootstrap3_flat_fix.css"); 
			e107::css('jmadmin', "css/bootstrap3_light.css"); 
		}

		$css .= "
		table textarea.form-control {
			width: 100%;  
		}
		#admin-ui-nav-menu li.divider {
			padding-top:  0px;  
			border-bottom: 0px; 
			margin-bottom: 0px;
		}
		/* forms */
		.form-control,
		.table select {
			height: 42px;
		}
 
		.admin-main-content div.block > .caption {
			background: ".$settings['kadmin_white_bg'].";
		} 
 
        #etrigger-filter {
          background: ".$settings['kadmin_primary_bg'].";
        }
        
		.btn-default {
			border-radius: 0px !important;
		}

		.admin-left-panel li.nav-header { 
			text-transform: uppercase;
		}
		
		.big-header {
			padding: 20px 0;
		}

 
		/* see search edit */
		input[name=pre_title] {
			display: inline;
			margin-right: 10px;
		}
		/* when form-control is missing */
		.tbox {
			height: 42px;
			padding: 6px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			color: #555;
			background-color: #fff;
			background-image: none;
			border: 1px solid #e5e5e5;
			border-radius: 0;
			box-shadow: none !important;
			-webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
			-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
			-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
			transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
			transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
			transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		}


		";

		$kadmin_dark_text =  $settings['kadmin_dark_text'];
		$kadmin_light_text =  $settings['kadmin_light_text'];
		$kadmin_dark_bg =  $settings['kadmin_darkmenu_bg'];
		$kadmin_light_bg =  $settings['kadmin_lightmenu_bg'];
		$kadmin_primary_bg =  $settings['kadmin_primary_bg'];
		$kadmin_primary_text =  $settings['kadmin_primary_text'];
		$kadmin_primary_bg_hover =  $settings['kadmin_primary_bg_hover'];
		$kadmin_primary_text_hover =  $settings['kadmin_primary_text_hover'];
		$kadmin_white_bg =  $settings['kadmin_white_bg'];

		$css .= "
			/* default text color */
			body {
				color: ".$kadmin_dark_text.";
			}
 
            /* main navigation */
            
            .nav-admin.navbar-left li a {
                padding-top: 10px;
                padding-bottom: 10px;
                
            } 
            
            .nav-admin.navbar-left ul.dropdown-menu   {   
                padding: 0px;
            }            
            .nav-admin.navbar-left ul.dropdown-menu li {   
                border-bottom: 2px solid ".$kadmin_primary_bg.";
            }
            
            .dropdown-menu>li.active  {
                color: ".$kadmin_primary_text.";
                background-color: ".$kadmin_primary_bg.";   
            }

            .dropdown-menu>li>a:focus, 
            .dropdown-menu>li>a:hover {
                color: ".$kadmin_primary_text_hover.";
                background-color: ".$kadmin_primary_bg_hover.";
            }

			/* Left menu */
			.admin-left-panel {
				background: ".$kadmin_dark_bg.";
				color: ".$kadmin_light_text."; 
			}
			.admin-container .admin-left-panel .panel  {  
				background: ".$kadmin_dark_bg.";
				color: ".$kadmin_light_text."; 
			}		
            
			.admin-left-panel li a:hover{
				color: ".$kadmin_primary_bg.";
			} 	
			
			.admin-left-panel li.nav-header { 
				background: ".$kadmin_light_bg.";
				color: ".$kadmin_dark_text."; 
			} 

			.admin-left-panel a {
				color: #e5e5e5;
			}
            
            /* menu.php Menu manager */            
			.admin-left-panel .menu-selector {    		  
				  color: ".$kadmin_dark_text.";   
				  overflow-wrap: break-word;                    
			}  
            
            .menu-selector input:checked + span {
                color: initial;
            }
                        
			/* right menu */
			.admin-right-panel {
				background: ".$kadmin_light_bg.";
				color: ".$kadmin_dark_text.";  
			}

			.admin-right-panel .h1, 
			.admin-right-panel .h2, 
			.admin-right-panel .h3, 
			.admin-right-panel .h4, 
			.admin-right-panel .h5, 
			.admin-right-panel .h6, 
			.admin-right-panel h1, 
			.admin-right-panel h2, 
			.admin-right-panel h3, 
			.admin-right-panel h4, 
			.admin-right-panel h5, 
			.admin-right-panel h6 {
				background: transparent; 
				color: ".$kadmin_dark_text.";  
			}
            
            .admin-right-panel .modal-content {
                background: white; 
            }

			.nav-pills li.active a {
				background: ".$kadmin_primary_bg.";
				color: ".$kadmin_primary_text.";  
			}

			.nav-pills li.active a:hover, 
			.nav-pills li.active a:focus {
				background: ".$kadmin_primary_bg_hover.";
				color: ".$kadmin_primary_text_hover.";  
			}

			.nav>li>a:focus, .nav>li>a:hover {
				background-color: ".$kadmin_primary_bg_hover.";
				color: ".$kadmin_primary_text_hover.";  
			}

			/* main navigation */	
			.navbar-default .navbar-nav > .active > a, 
			.navbar-default .navbar-nav > .active > a:focus  {
				background: ".$kadmin_primary_bg.";
				color: ".$kadmin_primary_text.";  
			}
			.navbar-default .navbar-nav > .active > a:hover {
				background: ".$kadmin_primary_bg_hover.";
				color: ".$kadmin_primary_text_hover.";  
			}

			/* buttons */
			.btn-primary {
				background: ".$kadmin_primary_bg.";
				color: ".$kadmin_primary_text.";  
			}
			/* buttons */
			.btn-primary:hover {
				background: ".$kadmin_primary_bg_hover.";
				color: ".$kadmin_primary_text_hover."; 
			}
			.admin-main-content .btn-default {
				background: ".$kadmin_primary_bg.";
			}
              
          	.admin-left-panel .btn-default {
				background: ".$kadmin_primary_bg.";
				color: ".$kadmin_primary_text.";
			} 
            
            .admin-left-panel .btn-default:hover {
				background: ".$kadmin_primary_bg_hover.";
				color: ".$kadmin_primary_text_hover."; 
			}
            

			/* Exceptions: */
			.btn.batch.btn-primary,
			.e-modal.btn-primary,
			.e-sef-generate.btn.btn-default {
				background-color: #d75252 !important;
				color: white;
			}

			/* Dashboard */
			/* flexpanel */
			#menu-area-07 .panel-heading,
			#core-infopanel-mye107 .panel-heading,
			#core-infopanel-news .panel-heading,
			#plug-infopanel-user-0  .panel-heading  {
				background: ".$kadmin_primary_bg.";
				color: ".$kadmin_primary_text.";  
			}
					
			/* infopanel */
			.admin-main-content .panel-heading  {
				background: ".$kadmin_primary_bg.";
				color: ".$kadmin_primary_text.";  
			} 
			.admin-main-content .panel  {
				background: ".$kadmin_light_bg.";
				color: ".$kadmin_dark_text.";   
			} 	

			/* Admin UI tables */
			.e-container td,
			.e-container td i  {
				color: ".$kadmin_dark_text.";
			}
			.e-container td a.editable-click {
				  color: ".$kadmin_primary_bg.";
			}
			.e-container td a:not([class]) {
				  color: ".$kadmin_primary_bg.";
			}
			
			.e-container td .panel-heading a:not([class]) {
				color: ".$kadmin_primary_bg.";  
			}
			
			.e-container a {
				color: ".$kadmin_primary_bg.";  
			}
						 
			#admin-ui-list-batch, .adminlist > thead > tr {
				background-color: ".$kadmin_primary_bg.";
				color: ".$kadmin_primary_text."; 
			}
			
            .table-responsive>.table,
			table {
				background-color: ".$kadmin_light_bg.";
			}

			thead tr {
				background-color: ".$kadmin_light_bg.";
			}

			.table .nav-tabs a, .table th a  {
				background-color: ".$kadmin_primary_bg.";
				color: ".$kadmin_primary_text."; 
			}

			 ul.nav.nav-tabs li {
				background: ".$kadmin_light_bg.";
			}

			ul.nav.nav-tabs li.active a {
				background-color: ".$kadmin_primary_bg.";
				color: ".$kadmin_primary_text."; 
			}
		
		    .table th  ul.col-selection > li a  {
				background-color: ".$kadmin_white_bg.";
				color: ".$kadmin_dark_text."; 
			}
    
            /* submit button in admin UI */
		    .etrigger-submit-group  ul.col-selection > li   {
				background-color: ".$kadmin_white_bg.";
				color: ".$kadmin_dark_text.";
                padding-left: 30px; 
			}

            
			table.adminlist {
				background-color: ".$kadmin_white_bg.";
				color: ".$kadmin_dark_text."; 
			}
			.adminform {
				background-color: ".$kadmin_white_bg.";
				color: ".$kadmin_dark_text."; 
			}
			.adminform .form-control,
			.adminform .tbox   {
				background-color: ".$kadmin_light_bg.";
				color: ".$kadmin_dark_text.";
			}	
			.fborder .forumheader3    {
				border: 1px solid ".$kadmin_light_bg.";
			}	

					
			/* tabs */
			#menu-area-07 ,
			#core-infopanel-mye107 .panel-body,
			#core-infopanel-news .panel-body,
			#plug-infopanel-user-0  .panel-body  {
				background-color: ".$kadmin_light_bg."; 
					color: ".$kadmin_dark_text."; 
			}	
					
			ul.nav.nav-tabs {
				border-bottom: 0 !important;
				background: transparent; 
				color: ".$kadmin_dark_text."; 
			}
						
			ul.nav.nav-tabs li {
				margin-bottom: 0px;
				border-right: 1px solid ".$kadmin_dark_text.";
				border-top: 1px solid ".$kadmin_dark_text.";
			}
					  
			ul.nav.nav-tabs > li > a {
				margin-right: 0px;  
				color: ".$kadmin_dark_text.";
			}
			.core-mainpanel-block .btn-default {
				background: ".$kadmin_white_bg.";
				color: ".$kadmin_dark_text."; 
			}

			.tab-content {
				background: ".$kadmin_white_bg.";
				color: ".$kadmin_dark_text."; 
			}

			/* superheader */
			.big-header {
				border-top: ".$kadmin_primary_bg." 3px solid;
				border-bottom: ".$kadmin_primary_bg." 3px solid;
			}

			";
	}

	$css .= "
	.colorpicker-2x .colorpicker-with-alpha {
		min-width: 220px;
	}

    .colorpicker-2x .colorpicker-hue,
    .colorpicker-2x .colorpicker-alpha {
        width: 30px;
        height: 200px;
    }

    .colorpicker-2x .colorpicker-color,
    .colorpicker-2x .colorpicker-color div {
        height: 30px;

	.colorpicker-2x .colorpicker-saturation {
        width: 220px;
        height: 200px;
	}
	";

	 e107::css('jmadmin', 'css/bootstrap-colorpicker.min.css');
	 e107::js('footer', e_PLUGIN.'jmadmin/js/bootstrap-colorpicker.min.js', 'jquery');
	 e107::js('footer', e_PLUGIN.'jmadmin/js/script.js', 'jquery');

	 e107::js('inline', $start.$inline_script.$end); 
	 e107::css('inline', $css); 

}