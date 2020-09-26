<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2012 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * User signup
 *
 * $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.8/signup.php $
 * $Id: signup.php 12780 2012-06-02 14:36:22Z secretr $
 * 
 */

$recaptchaActive = e107::pref('recaptcha', 'active');
$recaptchaSiteKey = e107::pref('recaptcha', 'sitekey');
$recaptchaSecretKey = e107::pref('recaptcha', 'secretkey');
 
	if($recaptchaActive)
	{
	

	 
	 
	class e107recaptcha 
	{
	
		public function __construct()
	    {
	
	        e107::lan('recaptcha', false, true);
	  }
	    
		static function blank()
		{
			return ;
		}
	 
		static function input()
		{
		 //$text = '<div class="g-recaptcha" data-sitekey="'.e107::pref('recaptcha', 'sitekey').'"  ></div> ';
		 
		 $text = '<div class="g-recaptcha"  ></div> ';
			return $text;
		}
		
		static function hiddeninput()
		{	 
			$frm = e107::getForm();	
            $element = '<div class="g-recaptcha"  ></div> ';
            $element .= $frm->hidden("rand_num", 'google' );
			return $element;
		}
		
		static function verify($code, $other)
		{
	 
			if ( ! function_exists( 'recaptcha_get_html' ) )
				require_once e_PLUGIN.'recaptcha/inc/recaptchalib.php';
	  
			// your secret key
			$secret = e107::pref('recaptcha', 'secretkey');
			 
			// empty response
			$response = null;
			 
			// check secret key
			$reCaptcha = new ReCaptcha($secret);
	
			// if submitted check response
			if ($_POST["g-recaptcha-response"]) {
			    $response = $reCaptcha->verifyResponse(
			        $_SERVER["REMOTE_ADDR"],
			        $_POST["g-recaptcha-response"]
			    );
			}
 	
	   if ($response != null && $response->success) {
		    return true;
		  } else {       
		    return false;
			}
		}
		
		// Return an Error message (true) if check fails, otherwise return false. 
		/**
		 * @param $rec_num
		 * @param $checkstr
		 * @return bool|mixed|string
		 */
		function invalidinvalid($code, $other)
		{
	 	
			if(self::verify($rec_num,$checkstr))
			{
				return false;	
			}
			else
			{
				return 'You did not pass robot test';	
			}		
	
		}
		  
	 }  
	 
		/* remove original captcha */
	  e107::getOverride()->replace('secure_image::r_image',     'e107recaptcha::blank');
		e107::getOverride()->replace('secure_image::renderInput', 'e107recaptcha::hiddeninput');
		e107::getOverride()->replace('secure_image::invalidCode', 'e107recaptcha::invalid');
	 	e107::getOverride()->replace('secure_image::renderLabel', 'e107recaptcha::blank');
		e107::getOverride()->replace('secure_image::verify_code', 'e107recaptcha::verify'); 
}
