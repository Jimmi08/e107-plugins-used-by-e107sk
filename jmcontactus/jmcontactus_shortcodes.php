<?php
	

// jmcontactus Shortcodes file

if (!defined('e107_INIT')) { exit; }
 
class plugin_jmcontactus_jmcontactus_shortcodes extends e_shortcode
{
	var $eplug_prefs;

	function __construct() {
		$this->eplug_prefs = e107::getPlugConfig('jmcontactus')->getPref();  
	}

	// {FORM_NAME}
	function sc_form_name() {
		//$fields = getcachedvars('contactform_data');
		$fields = e107::getRegistry('core/cachedvars/contactform_data', false);
		return $fields["name"];
	}

	// ------------------------------------------------
	// {FORM_NAME_IMGCODE}
	function sc_form_name_imgcode() {    
	if (e107::isInstalled('recaptcha'))  { 
			return '';
		}
		else {
		return CU_IMGCODE;
		}
	}

	// ------------------------------------------------
	// {FORM_REQUIRED}
	function sc_form_required() {
		$fields = getcachedvars('contactform_data');
		return ($fields["req"]) ? CU_REQUIRED : FALSE;
	}

	// ------------------------------------------------
	// {FORM_REQUIRED_MSG}
	function sc_form_required_msg() {
		//$fields = getcachedvars('contactform_data');
		$fields = e107::getRegistry('core/cachedvars/contactform_data', false);
		return $sc_style['FORM_REQUIRED']['pre'].CU_REQUIRED.$sc_style['FORM_REQUIRED']['post']." ".CU_REQUIRED_MSG;
	}

	// ------------------------------------------------
	// {FORM_FIELD}
	function sc_form_field() {    
	// $fields = getcachedvars('contactform_data');
	$fields = e107::getRegistry('core/cachedvars/contactform_data', false);
	//	$posted = getcachedvars('contactform_post');
	$posted = e107::getRegistry('core/cachedvars/contactform_post', false);
		$name = $fields["id"];
		return buildformfield($fields["type"], $name, $fields["vars"], $posted[$name]);
	}

	// ------------------------------------------------
	// {FORM_FOR}
	function sc_form_for() {
		//$fields = getcachedvars('contactform_data');
		$fields = e107::getRegistry('core/cachedvars/contactform_data', false);
		$for = $fields["id"];
		return $for;
	}

	// ------------------------------------------------
	// {FORM_FIELD_IMGCODE}
	function sc_form_field_imgcode() {
	//$fields = getcachedvars('contactform_data');
	$fields = e107::getRegistry('core/cachedvars/contactform_data', false);
		//$posted = getcachedvars('contactform_post');
	$posted = e107::getRegistry('core/cachedvars/contactform_post', false);
		return buildformfield("imgcode", "code_verify", "", "", $posted["codeverify"]);
	}

	// ------------------------------------------------
	// {FORM_SUBMIT_BUTTON}
	function sc_form_submit_button() {          
		return buildformfield("submit", "Submit");
	}

	// ------------------------------------------------
	// {FORM_FIELD_ERROR}
	function sc_form_field_error() {
		//$fields = getcachedvars('contactform_data');
		$fields = e107::getRegistry('core/cachedvars/contactform_data', false);
		//$posted = getcachedvars('contactform_post');
		$posted = e107::getRegistry('core/cachedvars/contactform_post', false);
		$name = $fields["id"];
		return ($posted) ? checkfields($fields["type"], $fields["req"], $name, $posted[$name]) : "";
	}

	// ------------------------------------------------
	// {FORM_FIELD_IMGCODE_ERROR}
	function sc_form_field_imgcode_error() {
		//$posted = getcachedvars('contactform_post');
		$posted = e107::getRegistry('core/cachedvars/contactform_post', false);

		return ($posted) ? checkimgcode($posted["code_verify"], $posted["rand_num"]) : "";
	}

	// ------------------------------------------------
	// {CONTACT_INFO}
	function sc_contact_info() {
	$item = e107::getParser() -> toHTML($this->var['info'], TRUE,'DESCRIPTION');
	return $item;
	}

	// ------------------------------------------------

	// {CONTACT_MAP}
	function sc_contact_map() {  
		
		if(isset($this->eplug_prefs['jmcontactus_google_maps_embed'])) 
		{   
			return $this->sc_google_map_embed();
		}
		else 
		{
			return "<div id='google-map'></div>";
		}  
	}

	// ------------------------------------------------
	// {THANKYOU_MSG}
	function sc_thankyou_msg() {
		$tmp = $this->eplug_prefs['jmcontactus_thankyou_msg'];      
		return stripBBCode(e107::getParser()->toHTML($tmp));
	}

	// ------------------------------------------------
	// {MAPMARKER}
	function sc_mapmarker() {
		$mapmarker = '';
		$mapmarker = $this->eplug_prefs['jmcontactus_mapmarker'];      
		if($mapmarker)  	{  $mapmarker = e107::getParser()->replaceConstants($mapmarker);    } 
		return $mapmarker;
	}

	// ------------------------------------------------
	// {GOOGLE_MAP_EMBED}
	function sc_google_map_embed() {
		$google_maps_embed = $this->eplug_prefs['jmcontactus_google_maps_embed'];      
		if($google_maps_embed)  	{  
			$google_maps_embed= e107::getParser()->toHTML($google_maps_embed);   
			return $google_maps_embed;  
		} 
		return '';
	}
}
	