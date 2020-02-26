<?php

// Template File
// jmcontactus Template file

if (!defined('e107_INIT')) { exit; }
 
$JMCONTACTUS_TEMPLATE = array();

$JMCONTACTUS_TEMPLATE['default']['start'] 	= '{SETIMAGE: w=400&h=300}';

$JMCONTACTUS_TEMPLATE['default']['item'] 	= '';

$JMCONTACTUS_TEMPLATE['default']['end'] 	= '';


global $sc_style ;

$sc_style['FORM_NAME']['pre'] = "";
$sc_style['FORM_NAME']['post'] = "";

$sc_style['FORM_FIELD']['pre'] = "";
$sc_style['FORM_FIELD']['post'] = "";

$sc_style['FORM_NAME_IMGCODE']['pre'] = "<span class='text-danger'>*</span> ";
$sc_style['FORM_NAME_IMGCODE']['post'] = "";

$sc_style['FORM_REQUIRED']['pre'] = "<span class='text-danger'>";
$sc_style['FORM_REQUIRED']['post'] = "</span>";

$sc_style['FORM_FIELD_ERROR']['pre'] = "<div class='label label-danger'>";
$sc_style['FORM_FIELD_ERROR']['post'] = "</div>";

$sc_style['FORM_FIELD_IMGCODE_ERROR']['pre'] = "<div class='label label-danger'>";
$sc_style['FORM_FIELD_IMGCODE_ERROR']['post'] = "</div>";

// Contact Information
$CONTACTUS_INFO_BEFORE =
"<div id='spcu_top' class='row'>
";

if($eplug_prefs['jmcontactus_map_type'] != 'nomap') {
	// With Google Map
	$CONTACTUS_INFO = "
		<div id='spcu_info' class='col-sm-4 col-xs-12'>
			{CONTACT_INFO}
		</div>
		<div id='spcu_map' class='col-sm-8 col-xs-12'>
			{CONTACT_MAP}
		</div>
	";
}
else {
	// Without Google Map
	$CONTACTUS_INFO = "
		<div id='spcu_info' class='col-sm-12'>
			{CONTACT_INFO}     
		</div>
	";
}

$CONTACTUS_INFO_AFTER = "
</div>
";

//Contact Form
$CONTACTUS_FORM_BEFORE =  "
<div class='well spcu_well'><div id='spcu_bottom'>
";

$CONTACTUS_FORM_ROWS = "
<div class='form-group bmd-form-group'>
 	<label class='bmd-label-floating' for='{FORM_FOR}'>{FORM_REQUIRED} {FORM_NAME}</label>
	{FORM_FIELD}{FORM_FIELD_ERROR}
</div>
";

$CONTACTUS_FORM_MESSAGE = "
<div class='form-group bmd-form-group'>
	<label class='control-label bmd-label-floating' for='{FORM_FOR}'>{FORM_REQUIRED} {FORM_NAME}</label>
	{FORM_FIELD}{FORM_FIELD_ERROR}
</div>
";
	
$CONTACTUS_FORM_AFTER = "
		<div class='form-group bmd-form-group'>
				<label class='control-label bmd-label-floating' for='code_verify'>{FORM_NAME_IMGCODE}</label>
				 {FORM_FIELD_IMGCODE}
        </div>
        <div class='form-group bmd-form-group'>        
                {FORM_FIELD_IMGCODE_ERROR} 
		</div>
  
<div class='submit text-center'>
		{FORM_SUBMIT_BUTTON}
</div>

";

// Thank You Page
$CONTACTUS_THANKYOU = '
<div class="alert alert-success" role="alert">
  {THANKYOU_MSG}
</div>	
';
