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
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

require_once("admin_leftmenu.php");        
						 
if(e_PAGE == "config.php") 
{
	e107::js('jmcontactus',  "js/bootstrap-growl.min.js", 'jquery');
	e107::js('jmcontactus',  "js/contact-admin.js", 'jquery');
	
	e107::css('inline', " .bootstrap-switch.form-control {
    padding: 0;
    height: 35px;
	}

	.bootstrap-switch.bootstrap-switch-small .bootstrap-switch-handle-on, .bootstrap-switch.bootstrap-switch-small .bootstrap-switch-handle-off, .bootstrap-switch.bootstrap-switch-small .bootstrap-switch-label {
		padding: 9px 10px;
	}

 	" );
}

$caption = CUP_SETTINGS_00;
new jmcontactus_admin_adminArea();
require_once(e_ADMIN."header.php");

$pname = 'jmcontactus';

$ns = e107::getRender();
$tp = e107::getParser();
$frm = e107::getForm();
$sql = e107::getDb();
			
       
// If the submit button is hit; update the settings in table core, record SitePrefs
// Initial default values of the preferences are set by plugin.php at $eplug_prefs
 
if (isset($_POST['update_prefs'])) 
{
    $eplug_prefs = e107::getPlugConfig('jmcontactus')->getPref();
    
	$eplug_prefs[$pname.'_settings_emailto']	= $tp->toDB($_POST[$pname.'_settings_emailto']);
	$eplug_prefs[$pname.'_settings_emailfrom']	= $tp->toDB($_POST[$pname.'_settings_emailfrom']);
	$eplug_prefs[$pname.'_settings_emailfromname']	= $tp->toDB($_POST[$pname.'_settings_emailfromname']);
	$eplug_prefs[$pname.'_settings_emailcopy']	= intval($_POST[$pname.'_settings_emailcopy']);
	$eplug_prefs[$pname.'_settings_savetodb']	= intval($_POST[$pname.'_settings_savetodb']);
	$eplug_prefs[$pname.'_settings_showinfo']	= intval($_POST[$pname.'_settings_showinfo']);
	$eplug_prefs[$pname.'_settings_showform']	= intval($_POST[$pname.'_settings_showform']);
	$eplug_prefs[$pname.'_thankyou_msg']		= $tp->toDB($_POST[$pname.'_thankyou_msg']);
  
 
  e107::getPlugConfig('jmcontactus')->reset()->setPref($eplug_prefs)->save(true);
  e107::js('footer-inline',  "$.bootstrapGrowl('".$tp->toJS(CUP_S_SAVEMSG)."', {type: 'success'});");   
//	$js_function_call[] = "$.bootstrapGrowl('".$tp->toJS(CUP_S_SAVEMSG)."', {type: 'success'});";
}
$eplug_prefs = e107::pref('jmcontactus'); 
$emails = $eplug_prefs[$pname.'_settings_emailto'];    
 
$i = 0;
$e_fields = "";
$disabled = 'disabled';
while(count($emails) >= ($i + 1)) 
{
  	if($i > 0) {
	  $disabled = '';
	}
	$e_fields .= "<div class='row emailto_email'>
	<div class='col-md-8'>"
	.$frm->text($pname."_settings_emailto[]", $tp->toForm($emails[$i]), "200", "size=30&class=form-control addEMAIL")
	."</div>
	<button type='button' class='btn btn-danger delete_field' ".$disabled."><i class='fa fa-trash-o'></i></button></div>";
		$i++;
}
 
$text = "<div class='padder'>";
$text .= $frm->open($pname."_settings", "post",e_REQUEST_URI, array('class'=>'form-horizontal'));

$text.= "<div class='form-group'>";
$text.= "<label class='control-label col-md-2'>".CUP_SETTINGS_01."</label>";
$text.= "<div class='col-md-9'>".$e_fields;
$text.="<div class='additionalfields'></div><br /><button type='button' class='btn btn-default'
id='add_fields' name='add_fields'><i class='fa fa-plus'></i> ".CUP_SETTINGS_BTNADD."</button>";
$text.= "</div>";
$text.= "</div>";

//Email from
$text .= "<div class='form-group'><label class='control-label col-md-2' for='".$pname."_settings_emailfromname'>".CUP_SETTINGS_EMAILFROM."</label>";
$text .= "<div class='col-md-6'><div class='emailfrom_name'>"
.$frm->text($pname."_settings_emailfromname", $tp->toForm($eplug_prefs[$pname.'_settings_emailfromname']), 'size=30&class=form-control addEMAIL')."</div></div></div>";

//Email from name
$text .= "<div class='form-group'><label class='control-label col-md-2' for='".$pname."_settings_emailfrom'>".CUP_SETTINGS_EMAILFROMNAME."</label>";
$text .= "<div class='col-md-6'><div class='emailfrom_email'>"
.$frm->text($pname."_settings_emailfrom", $tp->toForm($eplug_prefs[$pname.'_settings_emailfrom']), "200", "size=30&class=form-control addEMAIL")."</div></div></div>";

// Email a copy  
$text .= "<div class='form-group'><label class='control-label col-md-2' for='".$pname."_settings_emailcopy'>".CUP_SETTINGS_02."</label>";
$text .= "<div class='col-md-6'><div class='settings_emailcopy'>"
.$frm->radio_switch($pname."_settings_emailcopy", $eplug_prefs[$pname.'_settings_emailcopy'])
."</div></div></div>";
 
// Save Messages to DB 
$text .= "<div class='form-group'><label class='control-label col-md-2' for='".$pname."_settings_savetodb'>"
.CUP_SETTINGS_03."</label>";
$text .= "<div class='col-md-6'><div class='settings_savetodb'>"
.$frm->radio_switch($pname."_settings_savetodb", $eplug_prefs[$pname.'_settings_savetodb'])
."</div></div></div>"; 

// Show Contact Information
$text .= "<div class='form-group'><label class='control-label col-md-2' for='".$pname."_settings_showinfo'>"
.CUP_SETTINGS_04."</label>";
$text .= "<div class='col-md-6'><div class='settings_showinfo'>"
.$frm->radio_switch($pname."_settings_showinfo", $eplug_prefs[$pname.'_settings_showinfo'])
."</div></div></div>"; 
 
// Show Contact Form
$text .= "<div class='form-group'><label class='control-label col-md-2' for='".$pname."_settings_showformp'>"
.CUP_SETTINGS_05."</label>";
$text .= "<div class='col-md-6'><div class='settings_showform'>"
.$frm->radio_switch($pname."_settings_showform", $eplug_prefs[$pname.'_settings_showform'])
."</div></div></div>";

 
// Thankyou Message
$text .= "<div class='form-group'><label class='control-label col-md-2' for=''>".CUP_SETTINGS_06."</label>";
$text .= "<div class='col-md-6'>".$frm->bbarea($pname."_thankyou_msg", $tp->toHTML($eplug_prefs[$pname.'_thankyou_msg']), "10", "20", "class=form-control"," true")."</div></div>";

// Button
$text.= "<div class='form-group'><div class='col-md-6 col-md-offset-2'>";
	$text.= "<button type='submit' name='update_prefs' id='update_prefs' value='Save Settings' class='btn btn-primary'>".CUP_SETTINGS_SAVESETTINGS."</button>";
$text.= "</div></div>";

$text .= $frm->close();
$text .= "</div>";
 

$ns->tablerender($caption, $text);

require_once(e_ADMIN."footer.php");
exit;
 