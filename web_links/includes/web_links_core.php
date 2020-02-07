<?php 
 
  /* TODO: REPLACE WITH E107 core functions if they are available */

function un_htmlspecialchars($string, $mode = 0) {
	return un_entities_func($string, HTML_SPECIALCHARS, $mode);
}

function un_htmlentities($string, $mode = 0) {
	return un_entities_func($string, HTML_ENTITIES, $mode);
}


function un_entities_func($str_to_enc, $char_table, $char_mode = 0) {
	$trans = get_html_translation_table ($char_table, $char_mode);
	$ampersandtrick = uniqid(rand());
	$encoded = str_replace("&", $ampersandtrick, $str_to_enc);

		foreach ($trans as $trans_key => $trans_value) {
			if (strpos(_UN_EXTENSIONS_HTMLENTITIESSKIPPEDCHARS, $trans_key) === false && $trans_key != "&") {
				$encoded = str_replace($trans_key, $trans_value, $encoded);
			}
		}

	$encoded = str_replace($ampersandtrick, "&amp;", $encoded);
	return $encoded;
}

function un_unentities_func($str_to_dec, $char_table, $char_mode = 0) {
	$trans = get_html_translation_table ($char_table, $char_mode);
	$trans = array_flip($trans);
	$ampersandtrick = uniqid(rand());

	$decoded = str_replace("&amp;", $ampersandtrick, $str_to_dec);

		foreach ($trans as $trans_key => $trans_value) {
			if (strpos(_UN_EXTENSIONS_HTMLENTITIESSKIPPEDCHARS, $trans_key) === false && $trans_key != "&amp;") {
				$decoded = str_replace($trans_key, $trans_value, $decoded);
			}
		}
	$decoded = str_replace($ampersandtrick, "&", $decoded);
	return $decoded;
}

/** Read input date/time and return date/time in specified locale format.
  * @function: un_convert_time_by_locale
  * @param String $un_time - Date/time in any text format.
  * @param String $to_form - Format or constant of returned/printed date/time.
  * @param Boolean $raw - False to translate $to_form with translate() defined in main lang file.
  * @return String - Date in desired format.
  * @version: 1.0
  */

  function un_convert_time_by_locale($un_time, $to_form, $raw = false) {
	global $locale;
	
		if ($raw == false) {
			$to_form = translate($to_form);
		}
	
	//setlocale(LC_TIME, $locale); //set locale managed by e107
	
	$un_time = str_replace("@", " ", $un_time); // for some types

	//if (eregx("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $un_time, $datetime)) {
	if (preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $un_time, $datetime)) {    
		$new_date_by_locale = mktime($datetime[4], $datetime[5], $datetime[6], $datetime[2], $datetime[3], $datetime[1]);
		
			if (strpos($to_form, "%") === false) {
				$new_date_by_locale = date($to_form, $new_date_by_locale);
			} else {
				$new_date_by_locale = strftime($to_form, $new_date_by_locale);
			}
		
	//} elseif (eregx("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $un_time, $datetime)) {
	} elseif (preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $un_time, $datetime)) {

		$new_date_by_locale = mktime(0, 0, 0, $datetime[2],$datetime[3],$datetime[1]);
		
			if (strpos($to_form, "%") === false) {
				$new_date_by_locale = date($to_form, $new_date_by_locale);
			} else {
				$new_date_by_locale = strftime($to_form, $new_date_by_locale);
			}
	
	
	} else {
	
		$new_date_by_locale = strtotime($un_time); //load date in words
	
			if (strpos($to_form, "%") === false) {
				$new_date_by_locale = date($to_form, $new_date_by_locale);
			} else {
				$new_date_by_locale = strftime($to_form, $new_date_by_locale);
			}
			
	}
	
	setlocale(LC_TIME, 'en_US'); //set locale to previous value
	
	return $new_date_by_locale;
}

/*****************************************************/
/* Function to translate Datestrings                 */
/*****************************************************/

function translate($phrase) {
 
	switch($phrase) {
			case "xdatestring":             $tmp = "%A, %B %d @ %T %Z"; break;
			case "linksdatestring":         $tmp = "%b %d, %Y"; break;
			case "xdatestring2":            $tmp = "%A, %B %d"; break;
			//UNITED-NUKE added
			//user_dateformat in DB
			case "user_dateformat":         $tmp = 'D, M d, Y G:i'; break;
			//modul Avantgo
			case "avantgo":                 $tmp = '%m %d %Y, %H:%M:%S'; break;
			//modul Downloads and Web_Links
			case "downloads":               $tmp = '%B %d, %Y'; break;
			//modul Review
			case "reviews":                 $tmp = '%B %d, %Y'; break;
			case "reviewscomments":         $tmp = '%m/%d/%Y'; break;
			//for administrating stories and planed stories on main admin page
			case "adminstories":            $tmp = '%B %e, %Y - %H:%M:%S'; break;
			//for Submissions
			case "submissions":             $tmp = '%B %e, %Y'; break;
			//ipban admin module
			case "convertipban":            $tmp = "%m/%d/%Y"; break;
			//slufu tray check time
			case "slufuchecktime":          $tmp = "n/j/Y \\a\\t G:i"; break;
			//Content module (showpage)
			case "content_page":            $tmp = "%m/%d/%Y"; break;
			//News module (mail to friend)
			case "news_time":               $tmp = "%B %e, %Y - %H:%M:%S"; break;
			//Stories_Archive
			case "sa_time":                 $tmp = "%m/%d/%Y"; break;
			//Review post time
			case "reviews_ptime":           $tmp = "%B %e, %Y"; break;
			//Reviews comment post time
			case "reviews_ctime":           $tmp = "%m/%e/%Y, %H:%M:%S"; break;
			default:                        $tmp = $phrase; break;
	}
	return $tmp;
}


function update_points($id) {
	 //reward system
	 //do nothing for now
}