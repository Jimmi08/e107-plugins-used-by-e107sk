<?php

// Generated e107 Plugin Admin Area

require_once '../../../class2.php';
if (!getperms('P'))
{
	e107::redirect('admin');
	exit;
}



require_once "admin_leftmenu.php";

class jmcontactus_prefs_ui extends e_admin_ui
{

	protected $pluginTitle = CUP_SETTINGS_00;
	protected $pluginName = 'jmcontactus';
	protected $table = '';
	protected $pid = '';
	protected $listOrder = ' DESC';
	protected $fields = NULL;
	protected $fieldpref = array();

	//	protected $preftabs        = array('General', 'Other' );
	protected $prefs = array(
		'jmcontactus_map_type' => array(
			'title' => CUP_SETTINGS_MAP,
			'tab' => 0,
			'type' => 'dropdown',
			'data' => 'str',
			'help' => CUP_SETTINGS_MAP_HELP,
			'writeParms' => array(
				'optArray' => array(
					'nomap' => 'No map',
					'iframe' => 'Iframe',
					'gmap' => 'Google Map Api',
					'gmap3' => 'JQuery Gmap3 script'),
			),
		),
		'jmcontactus_google_maps_embed' => array('title' => CUP_SETTINGS_MAP_IFRAME, 'tab' => 0, 'type' => 'textarea', 'data' => 'str', 'help' => ''),
		'jmcontactus_googlemapsapikey' => array('title' => CUP_SETTINGS_MAP_KEY, 'type' => 'text',  'data'=>'str', 'writeParms' => array('size' => 'block-level'), 'help' => ''),
		'jmcontactus_googlemap' => array('title' => CUP_INFO_MAP, 'type' => 'text',  'data'=>'str', 'writeParms' => array('size' => 'block-level'), 
		'help' => CUP_INFO_ADDRESS),
		'jmcontactus_googlemap_zoom' => array('title' => CUP_INFO_MAP_ZOOM , 'type' => 'number',  'data'=>'str', 'writeParms' => array('size' => 'block-level')),
		'jmcontactus_mapmarker' => array('title' => CUP_SETTINGS_MAP_MARKER, 'type' => 'image', 'help' => CUP_SETTINGS_MAP_MARKER_HELP),
		
	);

	public function init()
	{
		$pname = 'jmcontactus';
		$googlemapsapikey = e107::pref('jmcontactus', 'jmcontactus_googlemapsapikey');
		$googlemapsapikey = trim($googlemapsapikey);
		if ($googlemapsapikey) {
			e107::js("footer", "https://maps.google.com/maps/api/js?key={$googlemapsapikey}&libraries=places" );
			e107::js('footer', e_PLUGIN . $pname . "/js/contact-admin.js", 'jquery');
		}
	}

}
 
class jmcontactus_form_prefs_ui extends e_admin_form_ui
{

}

new jmcontactus_admin_adminArea();

require_once e_ADMIN . "auth.php";
e107::getAdminUI()->runPage();

require_once e_ADMIN . "footer.php";
exit;

?>