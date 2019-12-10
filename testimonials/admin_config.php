<?php
/**
 * @file
 * Class installations to handle configuration forms on Admin UI.
 */

require_once('../../class2.php');
if(!getperms('P'))
{
	header('location:' . e_BASE . 'index.php');
	exit;
}

// [PLUGINS]/testimonials/languages/[LANGUAGE]/[LANGUAGE]_admin.php
e107::lan('testimonials', true, true);


/**
 * Class testimonials_admin
 */
class testimonials_admin extends e_admin_dispatcher
{

	protected $modes = array(
		'items'  => array(
			'controller' => 'testimonials_admin_items_ui',
			'path'       => null,
			'ui'         => 'testimonials_admin_items_form_ui',
			'uipath'     => null
		),
		'main' => array(
			'controller' => 'testimonials_admin_ui',
			'path'       => null,
		),
	);

	protected $adminMenu = array(			
		'items/list'   => array(
			'caption' => LAN_TESTIMONIALS_ADMIN_07,
			'perm'    => 'P',
		),
		'items/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P'),
		'main/prefs' => array(
			'caption' => LAN_PREFS,
			'perm'    => 'P',
		),
	);

	protected $adminMenuAliases = array(
		'main/edit' => 'main/list',
	);

	protected $menuTitle = LAN_PLUGIN_TESTIMONIALS_NAME;
}


/**
 * Class testimonials_admin_ui.
 */
class testimonials_admin_ui extends e_admin_ui
{

	protected $pluginTitle = LAN_PLUGIN_TESTIMONIALS_NAME;
	protected $pluginName  = "testimonials";
	protected $preftabs    = array(
		LAN_TESTIMONIALS_ADMIN_01,
	);
	protected $prefs       = array(

 		'tm_menu_caption'    => array(
			'title'      => LAN_TESTIMONIALS_ADMIN_20,
			'type'       => 'text',
			'writeParms'=>'size=xxlarge',
			'tab'        => 0,
		),
 		'tm_menu_subtext'    => array(
			'title'      => LAN_TESTIMONIALS_ADMIN_21,
			'type'       => 'textarea',
			'writeParms'=>'size=xxlarge',
			'tab'        => 0,
		),
		'tm_menu_items'  => array(
			'title' => LAN_TESTIMONIALS_ADMIN_02,
			'type'  => 'number',
			'data'  => 'int',
			'tab'   => 0,
		),
		'tm_trim'  => array(
			'title' => LAN_TESTIMONIALS_ADMIN_03,
			'type'  => 'number',
			'data'  => 'int',
			'tab'   => 0,
		),
		'tm_submit_role' => array(
			'title'      => LAN_TESTIMONIALS_ADMIN_04,
			'type'       => 'userclass',
			'data'       => 'int',
			'tab'        => 0,
		),
		'tm_use_captcha' => array(
			'title'      => LAN_TESTIMONIALS_ADMIN_05,
			'type'       => 'boolean',
			'writeParms' => 'label=yesno',
			'data'       => 'int',
			'tab'        => 0,
		),
		'tm_approval'    => array(
			'title'      => LAN_TESTIMONIALS_ADMIN_06,
			'type'       => 'userclass',
			'writeParms' => 'label=yesno',
			'data'       => 'int',
			'tab'        => 0,
		),
	);
}


/**
 * Class testimonials_admin_items_ui.
 */
class testimonials_admin_items_ui extends e_admin_ui
{

	protected $pluginTitle = LAN_PLUGIN_TESTIMONIALS_NAME;
	protected $pluginName  = 'testimonials';
	protected $eventName   = 'testimonials_message';
	protected $table       = "testimonials";
	protected $pid         = "tm_id";
	protected $perPage     = 0; //no limit
	protected $batchDelete = true;
	protected $batchCopy   = true;
	protected $sortField   = 'tm_order';
	protected $listOrder   = "tm_order ASC";
	protected $batchExport = true;

	protected $fields = array(
		'checkboxes' => array(
			'title'   => '',
			'type'    => null,
			'width'   => '5%',
			'forced'  => true,
			'thclass' => 'center',
			'class'   => 'center',
		),
		'tm_id'     => array(
			'title'    => LAN_TESTIMONIALS_ADMIN_09,
			'type'     => 'number',
			'width'    => '5%',
			'forced'   => true,
			'readonly' => true,
			'thclass'  => 'center',
			'class'    => 'center',
		),
		'tm_name'  => array(
			'title'    => LAN_TESTIMONIALS_ADMIN_10,
			'type'     => 'method',
			'inline'   => false,
			'width'    => 'auto',
			'thclass'  => 'left',
	/*		'readonly' => true, */
			'validate' => true,
			'writeParms'=>'size=xxlarge',
		),
		'tm_position'  => array(
			'title'    => LAN_TESTIMONIALS_ADMIN_19,
			'type'     => 'text',
			'inline'   => true,
			'width'    => 'auto',
			'thclass'  => 'left',
			'writeParms'=>'size=xxlarge',
			'validate' => true,
		),
		'tm_image'  => array(
			'title'    => LAN_TESTIMONIALS_ADMIN_18,
			'type'     => 'image',
			'inline'   => false,
			'width'    => '100px',
			'thclass'  => 'left',
			'readParms'=>'thumb=60&thumb_urlraw=0&thumb_aw=60',
			'writeParms'=>'size=xxlarge',
		),		
		'tm_url'   => array(
			'title'     => LAN_TESTIMONIALS_ADMIN_11,
			'type'     => 'text',
			'inline'   => true,
			'width'    => 'auto',
			'thclass'  => 'left',
			'readonly' => false,
			'writeParms'=>'size=xxlarge',
		),
		'tm_blocked' => array(
			'title'      => LAN_STATUS,
			'type'       => 'userclass',
			'width'      => 'auto',
			'readonly'   => false,
			'inline'     => true,
			'batch'      => true,
			'filter'     => true,
		/*	'writeParms' => array(
				0 => LAN_ACTIVE,
				1 => LAN_DISABLED,
			),
			'readParms'  => array(
				0 => LAN_ACTIVE,
				1 => LAN_DISABLED,
			),*/
			'thclass'    => 'center',
			'class'      => 'center',
		),
		'tm_rating'  => array (
			'title'   => LAN_TESTIMONIALS_ADMIN_22,
			'type'    => 'dropdown',
            'data'    => 'int',
			'width'   => 'auto',  'batch'=>true, 'filter'=>true,
			'thclass' => 'center',
			'class'   => 'center',
		),
		'tm_message'   => array(
			'title'     => LAN_TESTIMONIALS_ADMIN_15,
			'type'      => 'textarea',
			'inline'    => true,
			'width'     => 'auto',
			'thclass'   => 'left',
			'readParms' => 'expand=...&truncate=150&bb=1',
			'writeParms'=>'size=xxlarge',
			'readonly'  => false,
			'validate' => true,
		),
		'tm_order'  => array(
			'title'   => LAN_TESTIMONIALS_ADMIN_16,
			'type'    => 'text',
			'width'   => 'auto',
			'thclass' => 'center',
			'class'   => 'center',
		),
		'options'    => array(
			'title'   => LAN_TESTIMONIALS_ADMIN_17,
			'type'    => null,
			'width'   => '10%',
			'forced'  => true,
			'thclass' => 'center last',
			'class'   => 'center',
			'sort'    => true,
		),
	);

	protected $fieldpref = array(
		'checkboxes',
		'tm_id',
		'tm_name',
		'tm_url',
		'tm_blocked',
		'tm_message',
		'tm_order',
		'options',
	);

	function init()
	{
      $this->fields['tm_rating']['writeParms']['optArray'] = array(
      0 => 'not used',
      1 => '1 star',
      2 => '2 stars',
      3 => '3 stars',
      4 => '4 stars',
      5 => '5 stars');
	}

	public function beforeCreate($data)
	{
		if(empty($data['tm_order']))
		{
			$c = e107::getDb()->count('testimonials');
			$data['tm_order'] = $c ? $c : 0;
		}

		return $data;
	}


	public function beforeUpdate($data, $old_data, $id)
	{
	}

}


/**
 * Class testimonials_admin_items_form_ui.
 */
class testimonials_admin_items_form_ui extends e_admin_form_ui
{
	function tm_name($curVal,$mode) // not really necessary since we can use 'dropdown' - but just an example of a custom function.
	{

		if($mode == 'read')
		{
			if(empty($curVal))
			{
				return null;
			}

			$tmp = explode(".", $curVal,2);

			return !empty($tmp[1]) ? "<a rel='external' href='".e_BASE."user.php?id.".$tmp[0]."'>".$tmp[1]."</a>" : $curVal;
		}

		if($mode === 'write')
		{
			$tmp = explode(".",$curVal);
			return $this->text('tm_name', $curVal,80);
		}

	/*	if($mode == 'batch') // Custom Batch List for blank_type
		{
			return $types;
		}

		if($mode == 'filter') // Custom Filter List for blank_type
		{
			return $types;
		}*/


	}
}



new testimonials_admin();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();
require_once(e_ADMIN . "footer.php");
exit;
