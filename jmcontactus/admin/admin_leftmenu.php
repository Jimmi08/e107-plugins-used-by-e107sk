<?php
/*
+---------------------------------------------------------------+
 *	Contact Us Plugin for CMS e107
 *	by Spinning Planet (www.spinningplanet.co.nz)
 *  modified and supported for version 2 by
 *  Jimako (www.e107sk.com) 
 *  with kindly permission from Spinning Planet
 *	Released under the terms and conditions of the
 *	GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
+---------------------------------------------------------------+
*/

//// Required ///////////////////////////////////////////////////
if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
// Language Files ///////////////////////////////////////////////
e107::lan("jmcontactus" , e_LANGUAGE);

/////////////////////////////////////////////////////////////////
						
class jmcontactus_admin_adminArea extends e_admin_dispatcher
{
	   
	protected $modes = array(	
	
		'config'	=> array(
			'controller' 	=> 'jmcontactus_prefs_ui',
			'path' 			=> null,
			'ui' 			=> 'jmcontactus_form_prefs_ui',
			'uipath' 		=> null
		),
 
	);
  
 
 	protected $adminMenu = array(
		'main/config'					=> array('caption'=> CUP_MENU_03, 'perm' => 'P', 'url'=>'config.php'),
		'config/prefs'		      		=> array('caption'=> CUP_MENU_06, 'perm' => 'P',  'url'=>'admin_config.php'),	
		'main/contactinfo'  			=> array('caption'=> CUP_MENU_01, 'perm' => 'P',  'url'=>'contactinfo.php'),
		'main/contactform'				=> array('caption'=> CUP_MENU_02, 'perm' => 'P',  'url'=>'contactform.php'),   
  
		'main/messages'					=> array('caption'=> CUP_MENU_04, 'perm' => 'P',  'url'=>'messages.php'),
		'main/contacthelp'				=> array('caption'=> CUP_MENU_05, 'perm' => 'P',  'url'=>'contacthelp.php'), 
 	);      
 
	
	protected $menuTitle = CUP_MENU_00;
 
}   