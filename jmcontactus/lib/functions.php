<?php

// Admin Functions ////////////////////////////////////////////////////

function orderitem($order,$id) 
{
	$sql = e107::getDb();
	$pname = 'jmcontactus';
	$sql->update(strtolower($pname."_form"), "`order`=".intval($order)." WHERE `id`=".intval($id));
}

function deleteitem($id) 
{
	$sql = e107::getDb();
	$result =  $sql->delete(strtolower("jmcontactus_form"), "`id`=".intval($id));
}

function deletemessage($id) 
{
	$sql = e107::getDb();
	$sql->delete("jmcontactus_messages" , "`id`=".intval($id));
 
}

function cu_make_calendar($boxname, $boxvalue, $format) //TODO
{
	/*	if(!function_exists("make_input_field")) { require_once(e_HANDLER."calendar/calendar_class.php"); }
		$cal = new DHTML_Calendar(true);
		unset($cal_options);
		unset($cal_attrib);
		$cal_options['showsTime'] = false;
		$cal_options['showOthers'] = true;
		$cal_options['weekNumbers'] = false;
		$cal_options['ifFormat'] = $format;
		$cal_attrib['class'] = "tbox";
		$cal_attrib['size'] = "5";
		$cal_attrib['name'] = $boxname;
		$cal_attrib['value'] = $boxvalue;
		return $cal->make_input_field($cal_options, $cal_attrib);   */
}

// Public Functions ////////////////////////////////////////////////////

function stripBBCode($text_to_search) 
{
	$pattern = '|[[\/\!]*?[^\[\]]*?]|si';
	$replace = '';
	return preg_replace($pattern, $replace, $text_to_search);
}

function cleanstring($var) 
{
	$ns = ereg_replace("[^A-Za-z0-9]", "", $var);
	return $ns;
}

function getformname($id,$col) 
{
	$sql =  e107::getDb();
	$pname = 'jmcontactus';
	$sql->db_Select(strtolower($pname."_form"), "*", "`id` = ".intval($id));
	while($row=$sql->db_Fetch(MYSQLI_ASSOC)){
		return $row[$col];
	}
}

function hasmessages() 
{
	$sql =  e107::getDb();
	$pname = 'jmcontactus';
	$count = $sql->db_Count(strtolower($pname."_messages"), "(*)", "WHERE 1");
	return intval($count);
}

function send_emails($formdata) 
{
	$tp = e107::getParser();
	$eplug_prefs = e107::getPlugConfig('jmcontactus')->getPref();
	$pname = 'jmcontactus';

	if (file_exists(THEME.'email_template.php'))
	{
		include(THEME.'email_template.php');
	}
	else
	{
		// include core default. 
		include(e107::coreTemplatePath('email'));
	}
	
	/*
	$EMAIL_TEMPLATE['jmcontactus']['name']				= "What's New";												
	$EMAIL_TEMPLATE['jmcontactus']['subject']			= '{SITENAME}: {SUBJECT} ';
	$EMAIL_TEMPLATE['jmcontactus']['header']			= $EMAIL_TEMPLATE['default']['header']; // will use default header above. 	
	$EMAIL_TEMPLATE['jmcontactus']['body']				= "Hi {USERNAME},<br />{BODY}";
	$EMAIL_TEMPLATE['jmcontactus']['footer']			= $EMAIL_TEMPLATE['default']['footer'];
	*/
	
	if (array_key_exists('jmcontactus', $EMAIL_TEMPLATE)) 
	{
		$EMAIL_HEADER = $EMAIL_TEMPLATE['jmcontactus']['header'];
		$EMAIL_FOOTER = $EMAIL_TEMPLATE['jmcontactus']['footer'];
	}
	else 
	{
		$EMAIL_HEADER = $EMAIL_TEMPLATE['default']['header'];
		$EMAIL_FOOTER = $EMAIL_TEMPLATE['default']['footer'];
	}

	// Header
	$header = (isset($EMAIL_HEADER)) ? $tp->parseTemplate($EMAIL_HEADER) : "";

	// User Message
	$msg .= "<p>".stripBBCode($eplug_prefs[$pname.'_thankyou_msg'])."</p>";
	foreach($formdata as $k => $c) 
	{
		if(is_numeric($k)) 
		{
			$msg .= "<p><strong>".getformname($k, "name")."</strong><br />".$c."</p>";
		}
	}
	$msg = $tp->toEmail($msg);

	// Admin Message
	foreach($formdata as $k => $c) 
	{
		if(is_numeric($k)) 
		{
			$admin_msg .= "<p><strong>".getformname($k, "name")."</strong><br />".$c."</p>";
		}
	}
	$admin_msg = $tp->toEmail($admin_msg);

	// Footer
	$footer = (isset($EMAIL_FOOTER)) ? $tp->parseTemplate($EMAIL_FOOTER) : "";

	$subject = ($formdata["3"]) ? CU_EMAIL_SUBJECT." - ".$formdata["3"] : CU_EMAIL_SUBJECT;
	$senders_name = ($formdata["1"]) ? $formdata["1"] : "Unknown";
 
 
	$body = $header.$admin_msg.$footer;
	$eml = array(
		'sender_email'  => $eplug_prefs[$pname.'_settings_emailfrom'],
		'subject'   => $subject,
		'sender_name'   => $eplug_prefs[$pname.'_settings_emailfromname'],
		'body' => $body,
		'replyto'   => $formdata["2"] ,
		'replytonames'  => $senders_name ,
		'template'  => 'default'
	);

	// Send to admins
	foreach($eplug_prefs[$pname.'_settings_emailto'] as $e) {
		e107::getEmail()->sendEmail($e, $eplug_prefs[$pname.'_settings_emailfromname'] , $eml, false);
	}

	// Send to User
	if($eplug_prefs[$pname."_settings_emailcopy"] == 1) 
	{
		$eml['subject'] =  CUP_RECEPIENT_MESSAGE_01;
		e107::getEmail()->sendEmail($formdata["2"], $formdata["1"], $eml, false);
	}
}

function save_msg($vars, $timestamp, $ip) 
{
	$tp = e107::getParser();
	$sql =  e107::getDb();
	$pname = 'jmcontactus';
	foreach($vars as $k => $v) 
	{
		if(is_numeric($k)) 
		{
			$todb[getformname($k,"name")] = $v;
		}
	}
	$sql->insert(strtolower($pname."_messages"), "0, '".serialize($todb)."', ".intval($timestamp).", '".$tp->toDB($ip)."'");
}

function checkimgcode($usercode, $gencode) 
{
	global $error_count;

	$isrecaptchainstalled = e107::isInstalled('recaptcha');

	if ($isrecaptchainstalled)  
	{
		if(empty($usercode))
		{   
			$error_count++;
			return CU_POST_IMGCODE_ERROR;
		} else if(!e107::getSecureImg()->verify_code($gencode, $usercode))
		{
				$error_count++;
				return CU_POST_IMGCODE_ERROR2;
		} else
		{
				return TRUE;
		}
	}
	else 
	{
		if (!e107::getSecureImg()->verify_code($gencode, $usercode))
		{
			$error_count++;
			return CU_POST_RECAPTCHA_ERROR_MESSAGE;
		}
	}
}

function checkfields($type, $req, $name, $val) 
{
	global $error_count;
	if($req && !$val) 
	{
		$error_count++;
		return CU_POST_ERROR;
	}

	if($type == "email" && !preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $val)) 
	{
		$error_count++;
		return CU_POST_EMAIL_ERROR;
	}
}

function buildformfield($type, $id, $parameters = '',  $value = null) 
{
	if(!function_exists("secure_image")) {
		require_once(e_HANDLER.'secure_img_handler.php'); 
	}
 
	$sec_img = new secure_image;
   
	$parameters = unserialize($parameters);
 
	if($type === "text") 
	{
		$text = '<input class="form-control" id="'.$id.'" name="'.$id.'" type="text" value="'.$value.'">';
		return $text;
	}

	if($type === "email") 
	{
		$sk = e107::getPlugConfig('jmcontactus')->getPref();

		if($sk['use_honey-pot']) 
		{ 
			$text = '<input class="jmas_email" id="email" name="email" type="email" value="'.$value.'">';
			$text .= '<input class="form-control" id="'.$id.'" name="'.$id.'" type="text" value="'.$value.'">';
		}
		else 
		{
			$text = '<input class="form-control" id="'.$id.'" name="'.$id.'" type="text" value="'.$value.'">';
		} 
		return $text;
	}

	if($type === "textarea") 
	{
		$cols = varset($parameters[0], 25); 
        $rows = varset($parameters[1], 15);
        $opts['class'] = 'form-control';
        
        $textarea = e107::getForm()->textarea($id, $value, $cols, $rows,  $opts );
        //$textarea .= '<textarea class="form-control" id="'.$id.'" name="'.$id.'">'.$value.'</textarea>';
		return $textarea;
	}

	if($type === "checkbox") 
	{
		$checkbox = "";
		foreach($parameters as $option) 
		{
			$checkbox .= '
				<div class="checkbox">
					<label>
						<input name="'.$id.'" type="checkbox" value="'.$option.'" '.($value === $option ? "checked" : "").'> '.$option.'
					</label>
				</div>
			';
		}
		return $checkbox;
	}

	if($type === "radio") 
	{
		$radio = "";
		foreach($parameters as $option) 
		{
			$radio .= '
				<div class="radio">
					<label>
						<input name="'.$id.'" type="radio" value="'.$option.'" '.($value === $option ? "checked" : "").'> '.$option.'
					</label>
				</div>
			';
		}
		return $radio;
	}

	if($type === "dropdown") 
	{
		$select = '<select class="form-control" id="'.$id.'" name="'.$id.'">';
		foreach($parameters as $option) {
			$select .= '<option value="'.$option.'" '.($value === $option ? "selected" : "").'>'.$option.'</option>';
		}
		$select .= '</select>';
		return $select;
	}

	if($type === "date") 
	{
        
        $options['type'] = 'date';
        $date = e107::getForm()->datepicker($id,time(),$options);   
	 	//$date = '<input class="form-control js-datepicker" id="'.$id.'" name="'.$id.'" type="text" value="'.$value.'" placeholder="dd/mm/yyyy">';
		return $date;
	}

	if($type === "hidden" && $v[0]) 
	{
		$hidden = '<input name="'.$id.'" type="hidden" value="'.$v[0].'">';
		return $hidden;
	}

	if($type === "imgcode") 
	{
 
		// recaptcha is installed   {RECAPTCHA} should work too
		if (e107::isInstalled('recaptcha') && e107::pref('recaptcha', 'active'))  
		{   
			$recaptchaSiteKey = e107::pref('recaptcha', 'sitekey'); 
			$imgcode = '<div class="g-recaptcha" data-sitekey="'.$recaptchaSiteKey.'"  ></div> ';
		}
		else 
		{   
   			$imgcode = e107::getSecureImg()->r_image()."<div>".e107::getSecureImg()->renderInput()."</div>"; 	 
		}
   
		return $imgcode;
	}

	if($type === "submit") 
	{
		$button = '<button class="btn btn-primary" id="'.$id.'" name="'.$id.'" type="submit" value="'.$id.'">'.$id.'</button>';
		return $button;
	}
}

?>