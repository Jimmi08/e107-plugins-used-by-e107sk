<?php

// Generated e107 Plugin Admin Area

require_once '../../class2.php';
if (!getperms('P'))
{
	e107::redirect('admin');
	exit;
}

// e107::lan('signup_secure',true);

class signup_secure_adminArea extends e_admin_dispatcher
{

	protected $modes = array(

		'main' => array(
			'controller' => 'signup_secure_ui',
			'path' => null,
			'ui' => 'signup_secure_form_ui',
			'uipath' => null,
		),

	);

	protected $adminMenu = array(

		'main/readme' => array('caption' => 'Read me', 'perm' => 'P'),
		'main/prefs' => array('caption' => LAN_PREFS, 'perm' => 'P'),

		// 'main/div0'      => array('divider'=> true),
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P'),

	);

	protected $adminMenuAliases = array(
		'main/edit' => 'main/list',
	);

	protected $menuTitle = 'Signup Secure';
}

class signup_secure_ui extends e_admin_ui
{

	protected $pluginTitle = 'Signup Secure';
	protected $pluginName = 'signup_secure';
	//	protected $eventName		= 'signup_secure-'; // remove comment to enable event triggers in admin.
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

	protected $fields = array(
	);

	protected $fieldpref = array();

	//	protected $preftabs        = array('General', 'Other' );
	protected $prefs = array(
		'button_class' => array('title' => 'Button class', 'tab' => 0, 'type' => 'text', 'data' => 'str', 'help' => ''),
		'input_class' => array('title' => 'Input Class', 'tab' => 0, 'type' => 'text', 'data' => 'str', 'help' => ''),
		'form_class' => array('title' => 'Form Class', 'tab' => 0, 'type' => 'text', 'data' => 'str', 'help' => ''),
	);

	public function init()
	{
		// This code may be removed once plugin development is complete.
		if (!e107::isInstalled('signup_secure'))
		{
			e107::getMessage()->addWarning("This plugin is not yet installed. Saving and loading of preference or table data will fail.");
		}

		// Set drop-down values (if any).

	}

	// ------- Customize Create --------

	public function beforeCreate($new_data, $old_data)
	{
		return $new_data;
	}

	public function afterCreate($new_data, $old_data, $id)
	{
		// do something
	}

	public function onCreateError($new_data, $old_data)
	{
		// do something
	}

	// ------- Customize Update --------

	public function beforeUpdate($new_data, $old_data, $id)
	{
		return $new_data;
	}

	public function afterUpdate($new_data, $old_data, $id)
	{
		// do something
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
		// do something
	}

	// optional - a custom page.
	public function ReadMePage()
	{

		$text .= "<table class='fborder' style='width:90%'><tr><td class='forumheader3'>" . SS_README . "</td></tr></table>";

		return $text;

	}

}

class signup_secure_form_ui extends e_admin_form_ui
{

}

new signup_secure_adminArea();

require_once e_ADMIN . "auth.php";
e107::getAdminUI()->runPage();

require_once e_ADMIN . "footer.php";
exit;
