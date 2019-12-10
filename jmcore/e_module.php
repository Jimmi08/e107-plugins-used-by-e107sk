<?php
 
if(e_ADMIN_AREA !==true)
{                
 	$onepage_active 		 = e107::pref('jmcore','onepage_active', false);
 	if($onepage_active) {

		$request_url = e_REQUEST_URL;
 	
		if(e_REQUEST_SELF == SITEURL)
		{
			//it's frontpage, do nothing
		}
    elseif(strpos($request_url, 'wysiwyg.php')!==false)  {
      //it's tinymce, do nothing
    }
    elseif(strpos($request_url, 'secimg.php')!==false)  {
      //it's tinymce, do nothing
    }
    elseif(strpos($request_url, 'admin')!==false)  {
      //e_ADMIN_AREA is not enough, double check, otherwise menu manager doesn't work
    }
		else 
		{ 
			if ( is_url_excluded( $request_url ) ) {
			//do nothing
			} 
			else {
				e107::redirect();
			exit;
			}
	
		}
 	} 

} 


/**
 * Check if the current url has been excluded.
 * Source: === SG Optimizer === SG CachePress http://www.siteground.com/
 * @since  5.0.0
 *
 * @param string $url The url to test.
 *
 * @return boolean True if it was excluded, false otherwise.
 */
	function is_url_excluded( $url = null ) {
	// Get excluded urls.
	$onepage_exclude = e107::pref('jmcore','onepage_exclude');
	$tmp 		= str_replace("\r", "", $onepage_exclude);
	$parts 	= explode("\n", trim($tmp));
	// Bail if there are no excluded urls.
	if ( empty( $parts ) ) {
		return false;
	}

	// Prepare the url parts for being used as regex.
	$prepared_parts = array_map(
		function( $item ) {
			return str_replace( '\*', '.*', preg_quote( $item, '/' ) );
		}, $parts
	);
   
	// Build the regular expression.
	$regex = sprintf(
		'/%s(%s)$/i',
		preg_quote( SITEURL, '/' ), // Add the home url in the beginning of the regex.
		implode( '|', $prepared_parts ) // Then add each part.
	);

	// Check if the current url matches any of the excluded urls.
	preg_match( $regex, $url, $matches );

	// The url is excluded if matched the regular expression.
	return ! empty( $matches ) ? true : false;
}

?>