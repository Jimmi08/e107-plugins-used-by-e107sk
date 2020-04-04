<?php

// Generated e107 Plugin Admin Area

require_once ('../../../class2.php');

if (!getperms('P'))
{
	e107::redirect('admin');
	exit;
}

// e107::lan('onlineinfo',true);

require_once ("admin_menu.php");

$lan_file = e_PLUGIN . 'onlineinfo/languages/admin_' . e_LANGUAGE . '.php';
include_once (file_exists($lan_file) ? $lan_file : e_PLUGIN . 'onlineinfo/languages/admin_English.php');

class onlineinfo_adminArea extends onlineinfomenu_adminArea

{
	protected $modes = array(
		'main' => array(
			'controller' => 'onlineinfo_ui',
			'path' => null,
			'ui' => 'onlineinfo_form_ui',
			'uipath' => null
		) ,
	);
 
}

class onlineinfo_ui extends e_admin_ui

{
	protected $pluginTitle = ONLINEINFO_LOGIN_MENU_A2;
	protected $pluginName = 'onlineinfo';

	//	protected $eventName		= 'onlineinfo-'; // remove comment to enable event triggers in admin.

	protected $table = '';
	protected $pid = '';
	protected $perPage = 10;
	protected $batchDelete = true;
	protected $batchExport = true;
	protected $batchCopy = true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable.
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder = ' DESC';
	protected $fields = NULL;
	protected $fieldpref = array();

	//	protected $preftabs        = array('General', 'Other' );

	protected $prefs = array(
		'onlineinfo_caption' => array(
			'title' => ONLINEINFO_LOGIN_MENU_A3,
			'tab' => 0,
			'type' => 'text',
			'data' => 'str',
			'help' => ONLINEINFO_LOGIN_MENU_A4,
			'writeParms' => array(
				'size' => 'block-level',
				'post' => ONLINEINFO_LOGIN_MENU_A6x
			) ,
		) ,
		'onlineinfo_width' => array(
			'title' => ONLINEINFO_LOGIN_MENU_A7,
			'tab' => 0,
			'type' => 'text',
			'data' => 'str',
			'help' => ONLINEINFO_LOGIN_MENU_A8,
			'writeParms' => array(
				'size' => 'block-level',
				'post' => ONLINEINFO_LOGIN_MENU_A9
			) ,
		) ,
		'onlineinfo_showpmmsg' => array(
			'title' => ONLINEINFO_LOGIN_MENU_A126,
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'str',
			'help' => ''
		) ,
		'onlineinfo_sound' => array(
			'title' => ONLINEINFO_LOGIN_MENU_A64,
			'tab' => 0,
			'type' => 'dropdown',
			'data' => 'str',
			'help' => '',
			'writeParms' => array(
				'size' => 'block-level',
				'post' => ONLINEINFO_LOGIN_MENU_A65
			) ,
		) ,
		'onlineinfo_rememberbuttons' => array(
			'title' => ONLINEINFO_LOGIN_MENU_A128,
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'str',
			'help' => ONLINEINFO_LOGIN_MENU_A141,
			'writeParms' => array(
				'post' => ONLINEINFO_LOGIN_MENU_A141
			) ,
		) ,
		'onlineinfo_fontsize' => array(
			'title' => ONLINEINFO_LOGIN_MENU_A142,
			'tab' => 0,
			'type' => 'text',
			'data' => 'str',
			'help' => ONLINEINFO_LOGIN_MENU_A143,
			'writeParms' => array(
				'post' => ONLINEINFO_LOGIN_MENU_A143
			) ,
		) ,
		'onlineinfo_deleteme' => array(
			'title' => ONLINEINFO_LOGIN_MENU_A152,
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'str',
			'help' => '',
			'writeParms' => array(
				'size' => 'block-level',
				'post' => ONLINEINFO_LOGIN_MENU_A161
			) ,
		) ,
		'onlineinfo_logindiag' => array(
			'title' => ONLINEINFO_LOGIN_MENU_A160,
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'str',
			'help' => '',
			'writeParms' => array(
				'size' => 'block-level',
				'post' => ONLINEINFO_LOGIN_MENU_A162
			) ,
		) ,
		'onlineinfo_turnoffavatar' => array(
			'title' => ONLINEINFO_LOGIN_MENU_A203,
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'str',
			'help' => '',
			'writeParms' => array(
				'size' => 'block-level',
				'post' => ''
			) ,
		) ,
	);
	public

	function init()
	{

		// Set drop-down values (if any).

		$this->prefs['onlineinfo_sound']['writeParms']['optArray'] = $this->Create_sound_dropdown();
	}

	function Create_sound_dropdown()
	{ // Sound setup in admin
		$sound_option['none'] = ONLINEINFO_LOGIN_MENU_A61;
		$soundhandle = opendir(e_PLUGIN . 'onlineinfo/sounds/');
		while ($soundfile = readdir($soundhandle))
		{
			if ($soundfile != '.' && $soundfile != '..')
			{
				$soundlist = $soundfile;
				$name = ucwords(preg_replace('%_%', ' ', $soundlist));
				$name = ucwords(preg_replace('%.wav%', ' (wav)', $name));
				$name = ucwords(preg_replace('%.mp3%', ' (mp3)', $name));
				$sound_option[$soundlist] = $name;
			}
		}

		closedir($soundhandle);
		return $sound_option;
	}

	// ------- Customize Create --------

	public

	function beforeCreate($new_data, $old_data)
	{
		return $new_data;
	}

	public

	function afterCreate($new_data, $old_data, $id)
	{

		// do something

	}

	public

	function onCreateError($new_data, $old_data)
	{

		// do something

	}

	// ------- Customize Update --------

	public

	function beforeUpdate($new_data, $old_data, $id)
	{
		return $new_data;
	}

	public

	function afterUpdate($new_data, $old_data, $id)
	{

		// do something

	}

	public

	function onUpdateError($new_data, $old_data, $id)
	{

		// do something

	}
 
}

class onlineinfo_form_ui extends e_admin_form_ui

{
}

new onlineinfo_adminArea();
require_once (e_ADMIN . "auth.php");

e107::getAdminUI()->runPage();
require_once (e_ADMIN . "footer.php");

exit;
?>