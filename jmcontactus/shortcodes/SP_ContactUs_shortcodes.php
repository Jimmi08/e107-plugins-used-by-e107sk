<?php 
if (!defined('e107_INIT')) { exit; }
include_once(e_HANDLER.'shortcode_handler.php');
require_once(e_PLUGIN."SP_ContactUs/lib/functions.php");
include_lan(e_PLUGIN.'SP_ContactUs/languages/'.e_LANGUAGE.'.php');

global $tp, $pref;
$pname = "SP_ContactUs";
$contactus_shortcodes = $tp->e_sc->parse_scbatch(__FILE__);

/*

// ------------------------------------------------
SC_BEGIN FORM_NAME
    $fields = getcachedvars('contactform_data');
	return $fields["name"];
SC_END

// ------------------------------------------------
SC_BEGIN FORM_NAME_IMGCODE
  if (!isset($pref['plug_installed']['recaptcha']))  { 
		return CU_IMGCODE;
	}
	else {
	  return '';
	}
SC_END

// ------------------------------------------------
SC_BEGIN FORM_REQUIRED
    $fields = getcachedvars('contactform_data');
	return ($fields["req"]) ? CU_REQUIRED : FALSE;
SC_END

// ------------------------------------------------
SC_BEGIN FORM_REQUIRED_MSG
    $fields = getcachedvars('contactform_data');
	return $sc_style['FORM_REQUIRED']['pre'].CU_REQUIRED.$sc_style['FORM_REQUIRED']['post']." ".CU_REQUIRED_MSG;
SC_END

// ------------------------------------------------
SC_BEGIN FORM_FIELD
    $fields = getcachedvars('contactform_data');
	$posted = getcachedvars('contactform_post');
	$name = $fields["id"];
	return buildformfield($fields["type"], $name, $fields["vars"], $posted[$name]);
SC_END

// ------------------------------------------------
SC_BEGIN FORM_FOR
    $fields = getcachedvars('contactform_data');
	$for = $fields["id"];
	return $for;
SC_END

// ------------------------------------------------
SC_BEGIN FORM_FIELD_IMGCODE
    $fields = getcachedvars('contactform_data');
	$posted = getcachedvars('contactform_post');
	return buildformfield("imgcode", "codeverify", "", "", $posted["codeverify"]);
SC_END

// ------------------------------------------------
SC_BEGIN FORM_SUBMIT_BUTTON
	return buildformfield("submit", "Submit");
SC_END

// ------------------------------------------------
SC_BEGIN FORM_FIELD_ERROR
	$fields = getcachedvars('contactform_data');
	$posted = getcachedvars('contactform_post');
	$name = $fields["id"];
	return ($posted) ? checkfields($fields["type"], $fields["req"], $name, $posted[$name]) : "";
SC_END

// ------------------------------------------------
SC_BEGIN FORM_FIELD_IMGCODE_ERROR
	$posted = getcachedvars('contactform_post');
	return ($posted) ? checkimgcode($posted["codeverify"], $posted["rand_num"]) : "";
SC_END

// ------------------------------------------------
SC_BEGIN CONTACT_INFO
	global $tp;
   $item = getcachedvars('contactinfo_data');
   return $tp->toHTML(stripBBCode($item["info"]));
SC_END

// ------------------------------------------------

SC_BEGIN CONTACT_MAP
   return "<div id='google-map'></div>";
SC_END

// ------------------------------------------------
SC_BEGIN THANKYOU_MSG
	global $tp, $pref;
	$pname = "SP_ContactUs";
	return stripBBCode($tp->toHTML($pref[$pname.'_thankyou_msg']));
SC_END

*/
?>