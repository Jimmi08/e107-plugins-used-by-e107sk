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

require_once('../../../class2.php');

if(!getperms("P") || !e107::isInstalled('web_links'))
{
	e107::redirect('admin');
	exit();
}

require_once("admin_leftmenu.php");

new leftmenu_adminArea();

$css = '
.form-control-inline {
    min-width: 0;
    width: auto;
    display: inline;
}
.panel-heading .accordion-toggle:after {
    
    font-family: "Glyphicons Halflings";   
    content: "\e114";    
    float: right;        
    color: grey;         /
}
.panel-heading .accordion-toggle.collapsed:after {
    content: "\e080";     
}
';

e107::css('inline', $css);

require_once(e_ADMIN."header.php"); 
  
// load UnNuke core functions TODO replace with e107 stuff
require_once(e_PLUGIN.'web_links/includes/web_links_core.php');
 
//process URL parameters, just copy, they knew what they did 
$qry = str_replace('&amp;', '&', e_QUERY);
$qry_tmp = explode('&', $qry);
$supportedkeys = array('op',  'lid', 'linkid', 'editorialtitle', 'editorialtext', 'cid', 'sid', 'title', 'lid', 'requestid' );  
 
foreach($qry_tmp as $tmp) {
  $qry_lop = explode('=', $tmp);
  $value = $qry_lop[1];
  $key = $qry_lop[0];
  if($value && in_array($key,$supportedkeys)) {
	    $par[$key] = $value;
	}
}
extract($par); 
 
//process $_POST parameters for searching ,
$supportedostkeys = array('op',  'lid', 'linkid', 'editorialtitle', 'editorialtext', 'cid', 'sid', 'title', 'lid', 
'requestid', 'url', 'description',   'cdescription',
'name', 'email', 'hits', 'cat',   'sub','rid', 'cidfrom', 'cidto',  'new',  'submitter',
'editorialtitle', 'editorialtext' );
foreach($_POST as $key => $value) {     
	if($value && in_array($key,$supportedostkeys)) {     
	    $formvalues[$key] = $value;
	}
}
 
$exType = EXTR_SKIP;
extract($formvalues, $exType);
 
if (isset($ratinglid) && isset ($ratinguser) && isset ($rating)) { 
	$web_linksFront->addrating($ratinglid, $ratinguser, $rating, $ratinghost_name, $ratingcomments);
}

switch ($op) {

	case "Links":
  	 links();
	break;
	
	case "LinksDelNew":
		LinksDelNew($lid);
	break;
 
	case "LinksAddEditorial":
		LinksAddEditorial($linkid, $editorialtitle, $editorialtext);
	break;

	case "LinksModEditorial":
		LinksModEditorial($linkid, $editorialtitle, $editorialtext);
	break;

	case "LinksLinkCheck":
		LinksLinkCheck();
	break;

	case "LinksValidate":
		LinksValidate($cid, $sid, $ttitle);
	break;
	
	case "LinksDelEditorial":
		LinksDelEditorial($linkid);
	break;	
	
	case "LinksCleanVotes":
		LinksCleanVotes();
	break;

	case "LinksListBrokenLinks":
		LinksListBrokenLinks();
	break;
	
	case "LinksEditBrokenLinks":
		LinksEditBrokenLinks($lid);
	break;

	case "LinksDelBrokenLinks":
		LinksDelBrokenLinks($lid);
	break;

	case "LinksIgnoreBrokenLinks":
		LinksIgnoreBrokenLinks($lid);
	break;

	case "LinksListModRequests":
		LinksListModRequests();
	break;

	case "LinksChangeModRequests":
		LinksChangeModRequests($requestid);
	break;	

	case "LinksChangeIgnoreRequests":
		LinksChangeIgnoreRequests($requestid);
	break;

	case "LinksDelCat":
		LinksDelCat($cid, $sub, $ok);
	break;
	
	case "LinksModCat":
		LinksModCat($cat);
	break;
	
	case "LinksModCatS":
		LinksModCatS($cid, $sid, $sub, $title, $cdescription);
	break;
	
	case "LinksModLink":
		LinksModLink($lid);
	break;
	
	case "LinksModLinkS":
		LinksModLinkS($lid, $title, $url, $description, $name, $email, $hits, $cat);
	break;
	
	case "LinksDelLink":
		LinksDelLink($lid);
	break;
	
	case "LinksDelVote":
		LinksDelVote($lid, $rid);
	break;
	
	case "LinksDelComment":
		LinksDelComment($lid, $rid);
	break;
	
	case "LinksTransfer":
		LinksTransfer($cidfrom,$cidto);
	break;
 
	case "LinksAddLink":    
		LinksAddLink($new, $lid, $title, $url, $cat, $description, $name, $email, $submitter);
	break;


}  

$ns->tablerender($caption, $text);

require_once(e_ADMIN."footer.php");
exit;

?>