<?php
/*
+---------------------------------------------------------------+
*	Contact Us Plugin for CMS e107
*	by Spinning Planet (www.spinningplanet.co.nz)
* modified and supported for version 2 by
* Jimako (www.jmsupport.sk) 
* with kindly permission from Spinning Planet
*	Released under the terms and conditions of the
*	GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
+---------------------------------------------------------------+
*/

 

if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}
       

$sql = e107::getDB(); 					// mysql class object
$tp = e107::getParser(); 				// parser for converting to HTML and parsing templates etc.
$frm = e107::getForm(); 				// Form element class.
$ns = e107::getRender();				// render in theme box.
    
$text = '';    

 
e107::lan("jmcontactus" , e_LANGUAGE);

if(!function_exists("buildformfield")) { require_once(e_PLUGIN."jmcontactus/lib/functions.php"); }

$pname = 'jmcontactus';
$error_count = 0;


// Shortcode Info ///////////////////////////
$contactus_shortcodes = e107::getScBatch('jmcontactus',true, 'jmcontactus');

$eplug_prefs = e107::getPlugConfig('jmcontactus')->getPref();        

if(is_readable(THEME."templates/jmcontactus/jmcontactus_template.php")) {
	require_once(THEME."templates/jmcontactus/jmcontactus_template.php");
}
else {
	require_once(e_PLUGIN."jmcontactus/templates/jmcontactus_template.php");
}
 

// Check if date field exists
if ($eplug_prefs['jmcontactus_settings_showform'] == 1) {
	$sql->select("jmcontactus_form", "*", "`type` != 'hidden' ORDER BY `order`");
	$form_fields = $sql->rows();
	foreach($form_fields as $field) {
		if ($field["type"] === "date") {
			$hasDateField = true;
		}
	}
}

// information
 
$contactinfo = $sql->retrieve("jmcontactus_info", "*", false);
$contactus_shortcodes->setVars($contactinfo);
$text = "";
                       
// Google Map simple way 
switch ($eplug_prefs['jmcontactus_map_type']) {   
	case 'gmap' :
		$googlemapsapikey = trim($eplug_prefs['jmcontactus_googlemapsapikey']);
		e107::js("url", "https://maps.google.com/maps/api/js?key={$googlemapsapikey}&libraries=places", 'jquery');
		$settings = array(
			'googlemap_address' =>  $contactinfo["googlemap"],
		  	'googlemap_zoom' => $contactinfo["googlemap_zoom"]
		);  

		$code = "
		var googlemap_address = '{$contactinfo["googlemap"]}';
		var googlemap_zoom = {$contactinfo["googlemap_zoom"]} ";
	  
	   e107::js("footer", e_PLUGIN."jmcontactus/js/googlemap.js" );    
	   e107::js("footer-inline", $code);	 

	break;
	case 'gmap3' : 
		$googlemapsapikey = trim($eplug_prefs['jmcontactus_googlemapsapikey']);
 
		e107::js("url", "https://maps.google.com/maps/api/js?key={$googlemapsapikey}", 'jquery');
		e107::js("footer", e_PLUGIN."jmcontactus/js/gmap3.min.js", 'jquery', 2);
		e107::js("footer", e_PLUGIN."jmcontactus/js/gmap3.custom.js", 'jquery', 2);
	break;
	case 'iframe' :
	default:
	break;	
}
 
 
define("e_PAGETITLE", $contactinfo["title"]);
require_once(HEADERF);
 
// Contact post
if ($_POST["Submit"]) {
	foreach($_POST as $k => $p) {
		$p_vars[$k] = $p;
	}

	//cachevars('contactform_post', $p_vars);
	e107::setRegistry('core/cachedvars/contactform_post', $p_vars);
}



// Edit Info
if (ADMIN && getperms("P")) {
	$text .= "
	<div class='row spcu-adminbuttons'>
		<div class='col-md-12'>
			<a href='".e_PLUGIN_ABS.$pname."/admin/contactinfo.php?mode=main&action=contactinfo' target='_blank' class='btn btn-default btn-sm'><i class='fa fa-pencil'></i> ".CU_EDIT_INFO."</a>
			<a href='".e_PLUGIN_ABS.$pname."/admin/contactform.php?mode=main&action=contactform' target='_blank' class='btn btn-default btn-sm'><i class='fa fa-pencil'></i> ".CU_EDIT_FORM."</a> ";
			if(hasmessages() !== 0) {
				$text .= "<a href='".e_PLUGIN_ABS.$pname."/admin/messages.php'  target='_blank' class='btn btn-default btn-sm'><i class='fa fa-comments'></i> ".CU_EDIT_MESSAGES."</a>";
			}
	$text .= "
		</div>
	</div>";
}


// Contact Info
if ($eplug_prefs[$pname.'_settings_showinfo'] == 1) {
	$text .= $tp->parseTemplate($CONTACTUS_INFO_BEFORE, FALSE, $contactus_shortcodes);
	$text .= $tp->parseTemplate($CONTACTUS_INFO, FALSE, $contactus_shortcodes);
	$text .= $tp->parseTemplate($CONTACTUS_INFO_AFTER, FALSE, $contactus_shortcodes);
}
 
// Contact Form
if ($eplug_prefs[$pname.'_settings_showform'] == 1 AND !strstr(e_QUERY, 'thankyou')) {
  $formurl = e107::url($pname, 'thankyou');
	$text .= form::form_open("post", $formurl, "ContactUs_form");
	$sql->db_Select(strtolower($pname."_form"), "*", "`type` = 'hidden'");
	while($row = $sql->db_Fetch(MYSQLI_ASSOC)) {
		$v = unserialize($row["vars"]);
		$text.= buildformfield($row["type"], $row["id"], $row["vars"], $v[0]);
	}
	$text .= $tp->parseTemplate($CONTACTUS_FORM_BEFORE, FALSE, $contactus_shortcodes);
  
	foreach ($form_fields as $field) {
     $contactus_shortcodes->setVars($field);
     $contactus_shortcodes->setVars($contactinfo);
		//cachevars('contactform_data', $field);
		e107::setRegistry('core/cachedvars/contactform_data', $field);
        if ($field['type'] === 'textarea') {
            $text .= $tp->parseTemplate($CONTACTUS_FORM_MESSAGE, FALSE, $contactus_shortcodes);
        } else {
            $text .= $tp->parseTemplate($CONTACTUS_FORM_ROWS, FALSE, $contactus_shortcodes);
        }
	}
	$text .= $tp->parseTemplate($CONTACTUS_FORM_AFTER, FALSE, $contactus_shortcodes);
	$text .= form::form_close();
}
 
if ($eplug_prefs[$pname.'_settings_showform'] != 1 && $eplug_prefs[$pname.'_settings_showinfo'] != 1) {
	$text .= "Contact form disabled";
}

$caption = $contactinfo["title"];
 
if (strstr(e_QUERY, 'thankyou') && $_POST["Submit"] && $error_count === 0) {
	$thanks = $tp->parseTemplate($CONTACTUS_THANKYOU, FALSE, $contactus_shortcodes);
    if($_POST["email"]) {
 
      $thanks = 'Thank you, really. Nobody will contact you. If you see this message, try to start with empty form or contact us different way. ';
      // do nothing, spam, but let them think that it was sent
    }
    else {
 
    	send_emails($p_vars);    
 
    	if($eplug_prefs[$pname.'_settings_savetodb'] == 1) {
            //    $p_vars['ip'] = e107::getIPHandler()->getIP(TRUE); 
            //    getCurrentIP();
    		save_msg($p_vars, time(), $_SERVER["REMOTE_ADDR"]);
    	}
    }
	$ns->tablerender($caption, $thanks, 'contactus_thanks');
} else {
	$ns->tablerender($caption, $text, 'contactus_form');
}
require_once(FOOTERF);
exit();
 
?>