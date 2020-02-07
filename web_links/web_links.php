<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
*/

/**
  * UNITED-NUKE CMS: Just Manage!
  * http://united-nuke.openland.cz/
  * http://united-nuke.openland.cz/forums/
  *
  * 2002 - 2005, (c) Jiri Stavinoha
  * http://united-nuke.openland.cz/weblog/
  *
  * Portions of this software are based on PHP-Nuke
  * http://phpnuke.org - 2002, (c) Francisco Burzi
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
**/


if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

e107::lan("web_links" , "lang_front");

define(e_PAGE, "web_links.php");
define(e_PAGENAME, "- "._WEBLINKS);

//load constants for front+admin
require_once(e_PLUGIN.'web_links/web_links_defines.php');	

// load UnNuke core functions TODO replace with e107 stuff
require_once(e_PLUGIN.'web_links/includes/web_links_core.php');

// load UnNuke Frontend stuff
require_once(e_PLUGIN.'web_links/includes/web_links_class.php');
$web_linksFront = new web_links_front;

//process URL parameters, just copy, they knew what they did 
$qry = str_replace('&amp;', '&', e_QUERY);
$qry_tmp = explode('&', $qry);
$supportedkeys = array('l_op',  'cid', 'orderby', 'tikerid', 'category', 'newlinkshowdays', 'ratenum', 'ratetype', 'lid');  

foreach($qry_tmp as $tmp) {
  $qry_lop = explode('=', $tmp);
  $value = $qry_lop[1];
  $key = $qry_lop[0];
  if($value && in_array($key,$supportedkeys)) {
	    $par[$key] = $value;
	}
}
extract($par);
  
require_once(HEADERF); 					// render the header (everything before the main content area)

switch($l_op) {

	case "AddLink":
		$web_linksFront->AddLink();
	break;
	
	case "NewLinks":
		$web_linksFront->NewLinks($newlinkshowdays);
	break;
	
	case "NewLinksDate":
		$web_linksFront->NewLinksDate($selectdate);
	break;
	
	case "TopRated":
		$web_linksFront->TopRated($ratenum, $ratetype);
	break;
	
	case "MostPopular":
		$web_linksFront->MostPopular($ratenum, $ratetype);
	break;
	
	case "RandomLink":
		$web_linksFront->RandomLink();
	break;
	
	case "viewlink":
		$web_linksFront->viewlink($cid, $min, $orderby, $show);
	break;
	
	case "brokenlink":
		$web_linksFront->brokenlink($lid);
	break;
	
	case "modifylinkrequest":
		$web_linksFront->modifylinkrequest($lid);
	break;
	
	case "modifylinkrequestS":
		$web_linksFront->modifylinkrequestS($lid, $cat, $title, $url, $description, $modifysubmitter);
	break;
	
	case "brokenlinkS":
		$web_linksFront->brokenlinkS($lid,$cid, $title, $url, $description, $modifysubmitter);
	break;
	
	case "visit":
		$web_linksFront->visit($lid);
	break;
	
	case "Add":
		$web_linksFront->Add($title, $url, $auth_name, $cat, $description, $email);
	break;
	
	case "search":
		$web_linksFront->search($unquery, $min, $orderby, $show);
	break;
	
	case "rateinfo":
		$web_linksFront->rateinfo($lid, $user);
	break;
	
	case "ratelink":
		$web_linksFront->ratelink($lid);
	break;
	
	case "addrating":
		$web_linksFront->addrating($ratinglid, $ratinguser, $rating, $ratinghost_name, $ratingcomments, $user);
	break;
	
	case "viewlinkcomments":
		$web_linksFront->viewlinkcomments($lid);
	break;
	
	case "outsidelinksetup":
		$web_linksFront->outsidelinksetup($lid);
	break;
	
	case "viewlinkeditorial":
		$web_linksFront->viewlinkeditorial($lid);
	break;
	
	case "viewlinkdetails":
		$web_linksFront->viewlinkdetails($lid);
	break;
	
	default:
		$web_linksFront->index();
	break;

}



 
require_once(FOOTERF);					// render the footer (everything after the main content area)
exit; 