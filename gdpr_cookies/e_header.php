<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Related configuration module - News
 *
 *
*/
 
/**
 * @file
 * Class instantiation to prepare JavaScript configurations and include css/js
 * files to page header.
 */
if(!defined('e107_INIT'))
{
	exit;
}
// [PLUGINS]/cookie_consent/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('gdpr_cookies', false, true);
/**
 * Class cookie_consent_e_header.
 */
 
 
if(!USER) {
 
 
class gdpr_cookies_e_header
{
	public $prefs;
	
	/**
	 * Constructor.
	 */
	function __construct()
	{
		$this->prefs = e107::getPlugConfig('gdpr_cookies')->getPref();
		
		if(USER_AREA &&  $this->prefs['gdpr_cookie_active'])
		{
			self::include_components();
		}
	}
	/**
	 * Include necessary CSS and JS files
	 */
	function include_components()
	{
    /* message settings */
    $message1 = vartrue($this->prefs['gdpr_cookie_content_message'], 'This website uses cookies to ensure you get the best experience on our website.');
		
		/* compliance settings */
		$type = vartrue($this->prefs['gdpr_cookie_type'], '');
		$button1 = vartrue($this->prefs['gdpr_cookie_content_dismiss'], 'I agree');
		$button1 = '"dismiss": "'.$button1.'",'; 
		$button2 = vartrue($this->prefs['gdpr_cookie_content_deny'], 'Deny cookies');
		$button2 = '"deny": "'.$button2.'",';		
		$button3 = vartrue($this->prefs['gdpr_cookie_content_deny'], 'Allow cookies');	
 		$button3 = '"allow": "'.$button3.'",';
 		
		if($type == 'opt-in') {  
		   $typesetting = '"type": "opt-in",'; 
			 $buttons = $button1.$button2;
		}
		elseif($type =='opt-out') { 
		    $typesetting = '"type": "opt-out",'; 
				$buttons = $button1.$button3; } 
		else {
		 $typesetting = '';
		 $buttons = $button1;
		}
		
		/* colors */
		$color_button_background = vartrue($this->prefs['gdpr_cookie_palette_button_background'], '#f1d600');
		$color_button_text = vartrue($this->prefs['gdpr_cookie_palette_button_text'], '#000');
 		$color_banner_background = vartrue($this->prefs['gdpr_cookie_palette_popup_background'], '#000');
		$color_banner_text = vartrue($this->prefs['gdpr_cookie_palette_popup_text'], '#FFF');
		
		$banner_background =  '"background": "'.$color_banner_background.'",';
		$banner_text =   '"text": "'.$color_banner_text.'",';		
		
		$button_background =  '"background": "'.$color_button_background.'",';
		$button_text =   '"text": "'.$color_button_text.'",';
		
		
		$button_border =   '';
		/* theme setting */
		$theme='';
		$gdpr_cookie_theme = vartrue($this->prefs['gdpr_cookie_theme'], 'block');
		if($gdpr_cookie_theme == 'wire') {  
		    $button_background =  '"background": "transparent",';
				$button_text =   '"text": "'.$color_button_background.'",';
				$button_border =   '"border": "'.$color_button_background.'",';

		}
		elseif($gdpr_cookie_theme =='classic') { 
		     $theme= '"theme": "classic",';
		   } 
		elseif($gdpr_cookie_theme =='edgeless') { 
		     $theme= '"theme": "edgeless",';
			 } 
		else {
      // do nothing                    
		}
		
				
		/*  learn more policy */
		$gdpr_cookie_showLink= vartrue($this->prefs['gdpr_cookie_showLink'], false); 
		$gdpr_cookie_customLink= vartrue($this->prefs['gdpr_cookie_customLink'], false);
		$gdpr_cookie_content_link= vartrue($this->prefs['gdpr_cookie_content_link'], false);
		$gdpr_cookie_content_href= vartrue($this->prefs['gdpr_cookie_content_href'], '');
 
		if(empty($gdpr_cookie_showLink))  {
		  $text1 =  '"showLink": false,';
		  $text2 = '';
		  $text3 = '';
		}
		elseif(empty($gdpr_cookie_customLink))  {
		  $text1 = '';  
			$text2 = '"link": "'.$gdpr_cookie_content_link.'",';
			$text3 = '';
		}
		elseif($gdpr_cookie_customLink && $gdpr_cookie_content_href=='')  {
		  $text1 =  '"showLink": false,';
		  $text2 = '';
		  $text3 = '';		  
		}
		else {
		    $text1 = '';
		    $text2 = '"link": "'.$gdpr_cookie_content_link.'",';  
		    $text3 = '"href": "'.$gdpr_cookie_content_href.'",';  
		}		
		
		e107::css('url', '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css');     
   	e107::js('footer', e_PLUGIN.'gdpr_cookies/js/custom.min.js', 'jquery');      

		 $script = 'window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      '.$banner_background.'
      '.$banner_text.'
    },
    "button": {          
      '.$button_background.'
      '.$button_text.'
      '.$button_border.'
    }
  },
  '.$theme.'
  '.$typesetting.'
  '.$text1.' 
  "revokable": "true",
  "content": {
    "message": "'.$message1 .'",
  '.$buttons.'
  '.$text2.'
  '.$text3.'
 
  } 
})});';


	 
   e107::js('footer-inline', $script);    
	}
}
// Class instantiation.
new gdpr_cookies_e_header;

} 