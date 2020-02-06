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