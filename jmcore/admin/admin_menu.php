<?php
if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
/* Notes for future re-using
   Always use prefs as first option, it saves time
*/ 
e107::lan('jmcore',true);
 
class jmcoremenu_adminArea extends e_admin_dispatcher
{ 

	/**
	 * Optional (set by child class).
	 *
	 * Required for admin menu render. Format:
	 * @code
	 *  'mode/action' => array(
	 *      'caption' => 'Link title',
	 *      'perm' => '0',
	 *      'url' => '{e_PLUGIN}plugname/admin_config.php',
	 *      ...
	 *  );
	 * @endcode
	 *
	 * Note that 'perm' and 'userclass' restrictions are inherited from the $modes, $access and $perm, so you don't
	 * have to set that vars if you don't need any additional 'visual' control.
	 *
	 * All valid key-value pair (see e107::getNav()->admin function) are accepted.
	 *
	 * @var array
	 */
   
             
	protected $adminMenu = array( 
	'main/prefs' 		=> array('caption'=> 	LAN_PREFS, 					'perm' => 'P', 'url'=>'admin_config.php'),
	'tools/opt1' 		=> array('header' => 	LAN_JM_CORE_MENU_LAN_01),
	'main/onepage' 		=> array('caption'=> 	LAN_JM_CORE_MENU_LAN_02, 	'perm' => '0', 'url'=>'admin_onepage.php'),	
	'tools/opt2' 		=> array('header' => 	LAN_JM_CORE_MENU_LAN_03),
	'tools/exportForm' 	=> array('caption'=> 	LAN_JM_CORE_MENU_LAN_04, 	'perm' => '0', 'url'=>'admin_tools.php'),   
	'divider2'          => array('divider'=>	true),
    'main/help'			=> array('caption'=> 	LAN_HELP, 					'perm' => '0', 'url'=>'admin_config.php')
	);   

	protected $adminMenuAliases = array();

	protected $menuTitle = 'JM Core Plugin'; 
}