<?php

/**
 * @file
 * Callback functions used for entity single.
 */
 
/* JM note: single page: no query, no pagination.  Single page with pagination should have it's own detection  */

/**
 * Determines if the current page is the single page.
 *
 * @return mixed
 * True if the current page is the single page without query, otherwise false.
 */
function metatag_entity_single_contact_detect()
{
  
    //$page = defset('e_PAGE', '');
    //$query = defset('e_QUERY', '');
    //                                        
    //if(deftrue('e_PAGE', false) == true && !e_QUERY)
    //{                    
    //	return true;
    //}
    //
   
    if(e_PAGE == 'contact.php' OR e_PAGE == 'contactus.php')  
    {                    
    return true;
    }
        
    return false;
}


function metatag_entity_single_login_detect()
{
    
    if(e_PAGE ==  'login.php')  
    {                    
    return true;
    }

    return false;
}


function metatag_entity_single_signup_detect()
{
    
    if(e_PAGE ==  'signup.php')  
    {                    
    return true;
    }

    return false;
}
                           

function metatag_entity_single_fpw_detect()
{
    
    if(e_PAGE ==  'fpw.php')  
    {                    
    return true;
    }

    return false;
}

/**
 * Returns with Contact page URL.
 * double content and custom url solved
 * works for contact.php /contact  /contact/ or any its alias
 */
 
function metatag_single_token_contact_url()
{
	$backslash = e107::getPref('jm_canonical', 'backslash', true);
    
    $url = e107::url('contact', 'index');
    
    if($backslash) {
      if(substr($url, -1) != "/" && substr($url, -5) != ".html" && substr($url, -4) != ".php" ) {
         $url.= "/";
      }
    } 
    
    return $url;
}

/**
 * Returns with Login page URL.
 * double content and custom url solved
 */
 
function metatag_single_token_login_url()
{
	 
    return e_LOGIN;
}


/**
 * Returns with Signup page URL.
 * double content and custom url solved
 */
 
function metatag_single_token_signup_url()
{
	 
    return e_SIGNUP;
}

/**
 * Returns with Forgotten password URL.
 * quick fix
 */
 
function metatag_single_token_fpw_url()
{
	 
    return "fpw.php";
}
