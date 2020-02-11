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

require_once('../../../class2.php');
if (!getperms('P')) {
	e107::redirect('admin');
	exit;
}
 
require_once("admin_leftmenu.php");

new jmcontactus_admin_adminArea();
require_once(e_ADMIN."header.php"); 
 
$pname = 'jmcontactus';
$caption = CUP_INFO_00;



// just not load this everywhere
if (e_PAGE == "contactinfo.php") 
{
	// to avoid console error if something is wrong
	$googlemapsapikey = e107::pref('jmcontactus', 'jmcontactus_googlemapsapikey');
	$googlemapsapikey = trim($googlemapsapikey);
	if ($googlemapsapikey) {
		e107::js("footer", "https://maps.google.com/maps/api/js?key={$googlemapsapikey}&libraries=places" );
		e107::js('footer', e_PLUGIN . $pname . "/js/contact-admin.js", 'jquery');
	}

	e107::js('jmcontactus',  "js/bootstrap-growl.min.js", 'jquery');
	e107::js('jmcontactus',  "js/contact-admin.js", 'jquery');
	
 
}
 
 
$pname = 'jmcontactus';

$ns = e107::getRender();
$tp = e107::getParser();
$frm = e107::getForm();
$sql = e107::getDb();


if (isset($_POST['update_info'])) 
{
	if (isset($_POST['id'])) 
	{
		if ($sql->update(strtolower($pname . "_info"), "title='" . $tp->toDB($_POST[$pname . "_title"]) . "', googlemap='" . $tp->toDB($_POST[$pname . "_googlemap"]) . "', googlemap_zoom='" . $tp->toDB($_POST[$pname . "_googlemap_zoom"]) . "', info='" . $tp->toDB($_POST[$pname . "_info"]) . "' WHERE id=" . intval($_POST['id']))) 
		{
			e107::js('footer-inline',  "$.bootstrapGrowl('" . $tp->toJS(CUP_INFO_SAVEMSG) . "', {type: 'success'});" );
		} else 
		{
			e107::js('footer-inline',  "$.bootstrapGrowl('" . $tp->toJS(CUP_INFO_ERRORMSG) . "', {type: 'danger'});" );
		}
	} else {
		if ($sql->insert(strtolower($pname . "_info"), "0, '" . $tp->toDB($_POST[$pname . "_title"]) . "', '" . $tp->toDB($_POST[$pname . "_info"]) . "', '" . $tp->toDB($_POST[$pname . "_googlemap"]) . "', '" . $tp->toDB($_POST[$pname . "_googlemap_zoom"]) . "'")) {
			e107::js('footer-inline',  "$.bootstrapGrowl('" . $tp->toJS(CUP_INFO_SAVEMSG) . "', {type: 'success'})" );
		} else 
		{
			e107::js('footer-inline',  "$.bootstrapGrowl('" . $tp->toJS(CUP_INFO_ERRORMSG) . "', {type: 'danger'})" );
		}
	}
}

if ($rows = $sql->retrieve("jmcontactus_info", "*", " WHERE 1 LIMIT 1", true)  ) 
{ 
	$fi = $rows[0];
	$e_id = $frm->hidden("id", $fi["id"]);
} else {
	$fi = array();
	$e_id;
}
 	
// The following form output will be put into variable $text.
// The form will call admin_config_edit for further actions.
// All language dependent text are referring to the language file.
// E.g. .YFP_CONF_01. will retrieve the accompanying text.
// Remember NOT to put comments in the text as they will be published.
// In the form data is retrieved from table core, record SitePrefs using $pref
$text = "<div class='padder'>";
$text .= $frm->open($pname . "_form", 'post', null, array('class' => 'form-horizontal'));
$text .= $e_id;
//	$text .= $frm->form-open("post", e_SELF, $pname."_form", "", " class='form-horizontal'").$e_id;
		
// Page Title
$text .= "<div class='form-group'><label class='control-label col-md-2' for='jmcontactus_title'>" . CUP_INFO_01 . "</label>";
$text .= "<div class='col-md-6'><div class='emailfrom_name'>" . $frm->text($pname . "_title", $tp->toHTML($fi["title"]), "200", 'size=40&class=form-control') . "</div></div></div>";

// Information
$text .= "<div class='form-group'><label class='control-label col-md-2' for='jmcontactus_info'>" . CUP_INFO_02 . "</label>";
$text .= "<div class='col-md-6'><div class='emailfrom_name'>" . $frm->textarea($pname . "_info", $tp->toHTML($fi["info"]), "20", "10", "size=200&class=form-control", true) . "</div></div></div>";
		
// Google Map
$text .= "<div class='form-group'><label class='control-label col-md-2' for='jmcontactus_googlemap'>" . CUP_INFO_MAP . "</label>";

//	$text .= "<div class='col-md-6'><div class='emailfrom_name'>".$frm->form_text($pname."_googlemap", "40", $tp->toHTML($fi["googlemap"]), "200", "form-control", "", "", "placeholder='".CUP_INFO_ADDRESS."'")."</div></div></div>";
$text .= "<div class='col-md-6'><div class='emailfrom_name'>" . $frm->text($pname . "_googlemap", $tp->toHTML($fi["googlemap"]), "200", "size=40&class=form-control&placeholder=" . CUP_INFO_ADDRESS) . "</div></div></div>";	

// Google Map Zoom
$text .= "<div class='form-group'><label class='control-label col-md-2' for='jmcontactus_googlemap_zoom'>" . CUP_INFO_MAP_ZOOM . "</label>";
$text .= "<div class='col-md-6'><div class='emailfrom_name'>" . $frm->text($pname . "_googlemap_zoom", $tp->toHTML($fi["googlemap_zoom"]), "200", "size=40&class=form-control") . "</div></div></div>";
		
// Button
$text .= "<div class='form-group'><div class='col-md-6 col-md-offset-2'>";
$text .= "<button type='submit' name='update_info' id='update_info' value='Save' class='btn btn-primary'>" . CUP_INFO_SAVE . "</button>";
$text .= "</div></div>";

$text .= $frm->close();
$text .= "</div>";
		
		// Display the $text string into a rendered table with a caption from the language file
$caption = CUP_INFO_00;
	

$ns->tablerender($caption, $text);

require_once(e_ADMIN."footer.php");
exit;

?>
