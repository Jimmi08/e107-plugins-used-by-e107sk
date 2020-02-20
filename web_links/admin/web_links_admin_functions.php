<?php

if (!defined('e107_INIT'))
{
	exit;
}


function OpenTable() {
 
    $text = '<table><tbody>';
    return $text;
}

function CloseTable() {
 
    $text = '</tbody></table>';
    return $text;
}

// save time, move to class complicates things 

function LinksLinkCheck() {
    $caption = _WEBLINKSADMIN. ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._VALIDATELINKS;
 	$sql = e107::getDb();
 
	$content .= OpenTable();
	$content .= "<div class='center'><font class=\"title\"><b>"._WEBLINKSADMIN."</b></font></div>";
	$content .= CloseTable();
	$content .= "<br>";
    $content .=	OpenTable();
	$content .= "<div class='center'><font class=\"option\"><b>"._LINKVALIDATION."</b></font></div><br>"
	."<table width=\"100%\" align=\"center\"><tr><td colspan=\"2\" align=\"center\">"
	."<a href=\"".UN_FILENAME_ADMIN."?op=LinksValidate&amp;cid=0&amp;sid=0\">"._CHECKALLLINKS."</a><br><br></td></tr>"
	."<tr><td valign=\"top\"><div class='center'><b>"._CHECKCATEGORIES."</b><br>"._INCLUDESUBCATEGORIES."<br><br><font class=\"tiny\">";
	$result = $sql->retrieve("SELECT cid, title FROM #".UN_TABLENAME_LINKS_CATEGORIES." ORDER BY title", true);
        foreach($result AS $row) {
			$cid = $row['cid'];
			$title = $row['title'];
			$transfertitle = str_replace (" ", "_", $title);
			$content .="<a href=\"".UN_FILENAME_ADMIN."?op=LinksValidate&amp;cid=".$cid."&amp;sid=0&amp;ttitle=".$transfertitle."\">".$title."</a><br>";
		}
 
	$content .= "</font></div></td></tr></table>";
	$content .= CloseTable();
    e107::getRender()->tablerender($caption, $content, 'web_links_index');
}


function LinksValidate() {
    $caption = _WEBLINKSADMIN. ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._CLEANLINKSDB;
 	$sql = e107::getDb();   
    /* 
      $fl = e107::getFile();  $fp =  $fl->isValidURL($row['url']);
      - it doesn't return code to display reason and it uses get_headers without @
    */
	$content = OpenTable();
	$content .= "<div class='center'><font class=\"title\"><b>"._WEBLINKSADMIN."</b></font></div>";
	$content .= CloseTable();
	$content .= "<br>";
	$content .= OpenTable();
	$cid = intval($cid);
	$sid = intval($sid);
	$ttitle = stripslashes(check_html($ttitle, "nohtml"));
	$transfertitle = str_replace ("_", "", $ttitle);
	/* Check ALL Links */
	$content .="<table width=\"100%\" border=\"0\">";
		if ($cid==0 && $sid==0) {
			$content .="<tr><td colspan=\"3\"><div class='center'><b>"._CHECKALLLINKS."</b><br>"._BEPATIENT."</div><br><br></td></tr>";
			$result = $sql->retrieve("SELECT lid, title, url FROM #".UN_TABLENAME_LINKS_LINKS." ORDER BY title", true);
		}
		/* Check Categories & Subcategories */
		if ($cid!=0 && $sid==0) {
			$content .="<tr><td colspan=\"3\"><div class='center'><b>"._VALIDATINGCAT.": ".$transfertitle."</b><br>"._BEPATIENT."</div><br><br></td></tr>";
			$result = $sql->retrieve("SELECT lid, title, url FROM #".UN_TABLENAME_LINKS_LINKS." WHERE cid='".$cid."' ORDER BY title", true);
		}
		/* Check Only Subcategory */
		if ($cid==0 && $sid!=0) {
			$content .="<tr><td colspan=\"3\"><div class='center'><b>"._VALIDATINGSUBCAT.": ".$transfertitle."</b><br>"._BEPATIENT."</div><br><br></td></tr>";
			$result = $sql->retrieve("SELECT lid, title, url FROM #".UN_TABLENAME_LINKS_LINKS." WHERE sid='".$sid."' ORDER BY title", true);
		}
	       $content .= "<tr><td bgcolor=\"$bgcolor2\" align=\"center\"><b>".LAN_STATUS."</b></td>
           <td bgcolor=\"".$bgcolor2."\" width=\"100%\"><b>"._LINKTITLE."</b></td><td bgcolor=\"".$bgcolor2."\" align=\"center\"><b>".LAN_OPTIONS."</b></td></tr>";
        foreach($result AS $row) {
			$lid = $row['lid'];
			$title = stripslashes($row['title']);
			$url = stripslashes($row['url']);
			$vurl = parse_url($row['url']);
	 
            $fp = getHttpResponseCode_using_getheaders($url, false);
             
            //convert code to message
            $code = getCode($fp);
 
            if ($fp == '200' ) { 
				$content .="<tr><td align=\"center\">&nbsp;&nbsp;"._OK."&nbsp;&nbsp;</td>"
				."<td>&nbsp;&nbsp;<a href=\"".$url."\" target=\"_blank\">".$title."</a>&nbsp;&nbsp;</td>"
				."<td align=\"center\"><font class=\"content\">&nbsp;&nbsp;"._NONE."&nbsp;&nbsp;</font>"
				."</td></tr>";
		    } 
            else{ 
				$content .="<tr><td align=\"center\"><b>&nbsp;&nbsp;"._FAILED."&nbsp;&nbsp;</b></td>"
				."<td>&nbsp;&nbsp;<a href=\"".$url."\" target=\"_blank\">".$title."</a>&nbsp;&nbsp;".$code." </td>"
				."<td align=\"center\"><font class=\"content\">&nbsp;&nbsp;[ <a href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">".LAN_EDIT."</a> | <a href=\"".UN_FILENAME_ADMIN."?op=LinksDelLink&amp;lid=".$lid."\">".LAN_DELETE."</a> ]&nbsp;&nbsp;</font>"
				."</td></tr>";
			}		
		}
 
	$content .= "</table>";
	$content .= CloseTable(); 
    e107::getRender()->tablerender($caption, $content, 'web_links_index');
}


/**
 * @param $url
 * @param array $options
 * @return string
 * @throws Exception
 */
function getCode($returnedStatusCode) {
 
    // list of HTTP status codes
    $httpStatusCodes = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        599 => 'Network Connect Timeout Error'
    );
    if (array_key_exists($returnedStatusCode, $httpStatusCodes)) {
        return "Code: {$returnedStatusCode} - Definition: {$httpStatusCodes[$returnedStatusCode]}";
    } else {
        return "Url does not exist";
    } 
    return   $httpStatusCodes[$returnedStatusCode];
 
}
 

    function getHttpResponseCode_using_getheaders($url, $followredirects = false){
        // returns string responsecode, or false if no responsecode found in headers (or url does not exist)
        // NOTE: could potentially take up to 0-30 seconds , blocking further code execution (more or less depending on connection, target site, and local timeout settings))
        // if $followredirects == false: return the FIRST known httpcode (ignore redirects)
        // if $followredirects == true : return the LAST  known httpcode (when redirected)
        if(! $url || ! is_string($url)){
            return false;
        }
        $headers = @get_headers($url);
        if($headers && is_array($headers)){
 
            if($followredirects){
                // we want the the last errorcode, reverse array so we start at the end:
                $headers = array_reverse($headers);
            }
            foreach($headers as $hline){
                // search for things like "HTTP/1.1 200 OK" , "HTTP/1.0 200 OK" , "HTTP/1.1 301 PERMANENTLY MOVED" , "HTTP/1.1 400 Not Found" , etc.
                // note that the exact syntax/version/output differs, so there is some string magic involved here
                if(preg_match('/^HTTP\/\S+\s+([1-9][0-9][0-9])\s+.*/', $hline, $matches) ){// "HTTP/*** ### ***"
                    $code = $matches[1];
                    return $code;
                }
            }
            // no HTTP/xxx found in headers:
            return false;
        }
        // no headers :
        return false;
    }
    
function LinksCleanVotes() {
    $caption = _WEBLINKSADMIN. ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._CLEANLINKSDB;
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
}

function LinksListBrokenLinks() {
    $sql = e107::getDb();
    $tp = e107::getParser();
    
    $caption = _WEBLINKSADMIN. ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._BROKENLINKS;
    $content .= OpenTable();
	$content .= "<div class='center'><font class=\"title\"><b>"._WEBLINKSADMIN."</b></font></div>";
    $content .= CloseTable();
	$content .= "<br>";
    $content .= OpenTable();
	$result = $sql->retrieve("SELECT requestid, lid, modifysubmitter FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE brokenlink='1' ORDER BY requestid", true);
     
	$totalbrokenlinks = count($result);
	$content .= "<div class='center'><font class=\"option\"><b>"._USERREPBROKEN." (".$totalbrokenlinks.")</b></font></div><br><br><div class='center'>"
	._IGNOREINFO."<br>"
	._DELETEINFO."</div><br><br><br>"
	."<table align=\"center\" width=\"450\">";
		if ($totalbrokenlinks==0) {
			$content .= "<div class='center'><font class=\"option\">"._NOREPORTEDBROKEN."</font></div><br><br><br>";
		} else {
			$colorswitch = $bgcolor2;
			$content .= "<tr>"
			."<td><b>"._LINK."</b></td>"
			."<td><b>"._SUBMITTER."</b></td>"
			."<td><b>"._LINKOWNER."</b></td>"
			."<td><b>".LAN_EDIT."</b></td>"
			."<td><b>"._IGNORE."</b></td>"
			."<td><b>".LAN_DELETE."</b></td>"
			."</tr>";
 
                foreach($result AS $row) {      print_a($row2);
					$requestid = $row['requestid'];
					$lid = $row['lid'];
					$modifysubmitter = $row['modifysubmitter'];
					$row2 = $sql->retrieve("SELECT title, url, submitter FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'", true);
						if ($modifysubmitter != $anonymous) {
							$row3 = $sql->retrieve("SELECT ".UN_TABLENAME_USEREMAIL_ALIAS." FROM #".UN_TABLENAME_USERS." WHERE ".UN_TABLENAME_USERNAME."='".$modifysubmitter."'");
							$email = stripslashes($row3);
						}

					$title = stripslashes($row2[0]['title']);
					$url = $row2[0]['url'];
					//$url2 = urlencode($url);
					$owner = $row2[0]['submitter'];
					$row4 = $sql->retrieve("SELECT ".UN_TABLENAME_USEREMAIL_ALIAS." FROM #".UN_TABLENAME_USERS." WHERE ".UN_TABLENAME_USERNAME."='".$owner."'");
					$owneremail = stripslashes($row4);
					//$url = urlencode($url);
					$content .= "<tr>"
					."<td bgcolor=\"".$colorswitch."\"><a href=\"".$url."\" target='_blank' >".$title."</a>"
					."</td>";
						if ($email=='') {
							$content .= "<td bgcolor=\"".$colorswitch."\">".$modifysubmitter;
						} else {
							$content .= "<td bgcolor=\"".$colorswitch."\"><a href=\"mailto:".$email."\">".$modifysubmitter."</a>";
						}
					$content .= "</td>";
						if ($owneremail=='') {
							$content .= "<td bgcolor=\"".$colorswitch."\">".$owner;
						} else {
							$content .= "<td bgcolor=\"".$colorswitch."\"><a href=\"mailto:".$owneremail."\">".$owner."</a>";
						}
					$content .= "</td>"
					."<td bgcolor=\"".$colorswitch."\"><div class='center'><a href=\"".UN_FILENAME_ADMIN."?op=LinksEditBrokenLinks&amp;lid=".$lid."\">X</a></div>"
					."<td bgcolor=\"".$colorswitch."\"><div class='center'><a href=\"".UN_FILENAME_ADMIN."?op=LinksIgnoreBrokenLinks&amp;lid=".$lid."\">X</a></div>"
					."</td>"
					."<td bgcolor=\"".$colorswitch."\"><div class='center'><a href=\"".UN_FILENAME_ADMIN."?op=LinksDelBrokenLinks&amp;lid=".$lid."\">X</a></div>"
					."</td>"
					."</tr>";
						if ($colorswitch == $bgcolor2) {
							$colorswitch = $bgcolor1;
						} else {
							$colorswitch = $bgcolor2;
						}
				}
		}
 
	$content .= "</table>";
    $content .= CloseTable();
    
    e107::getRender()->tablerender($caption, $content, 'web_links_index');
}

function LinksListModRequests() {
    $sql = e107::getDb();
    
    $caption = _WEBLINKSADMIN. ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '. _USERMODREQUEST;
    
    $content .= OpenTable();
    $content .= "<div class='center'><font class=\"title\"><b>"._WEBLINKSADMIN."</b></div>";
    $content .= CloseTable();

    $content .= "<br>";
    $content .= OpenTable();
    $result = $sql->retrieve("SELECT requestid, lid, cid, sid, title, url, description, modifysubmitter FROM #".UN_TABLENAME_LINKS_MODREQUEST." 
    WHERE brokenlink='0' ORDER BY requestid", true);
     
    $totalmodrequests = count($result);
    $content .= "<div class='center'><font class=\"option\"><b>"._USERMODREQUEST." (".$totalmodrequests.")</b></div><br><br><br>";
    $content .= "<table width=\"95%\"><tr><td>";
      foreach($result AS $row) {
 
        $requestid = $row['requestid'];
        $lid = $row['lid'];
        $cid = $row['cid'];
        $sid = $row['sid'];
        $title = stripslashes($row['title']);
        $url = $row['url'];
        $url = urlencode($url);
        $description = stripslashes($row['description']);
      //	$xdescription = eregix_replace("<a href=\"http://", "<a href=\"index.php?url=http://", $description);
        $xdescription = preg_replace("#<a href=\"http://#i", "<a href=\"index.php?url=http://", $description);			
        $modifysubmitter = $row['modifysubmitter'];
        $rows2 = $sql->retrieve("SELECT cid, sid, title, url, description, submitter FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'", true );  
        $row2 = $rows2[0];           
 
        $origcid = $row2['cid'];
        $origsid = $row2['sid'];
        $origtitle = stripslashes($row2['title']);
        $origurl = $row2['url'];
        $origurl = urlencode($origurl);
        $origdescription = stripslashes($row2['description']);
    //			$xorigdescription = eregix_replace("<a href=\"http://", "<a href=\"index.php?url=http://", $xorigdescription);
        $xorigdescription = preg_replace("#<a href=\"http://#i", "<a href=\"index.php?url=http://", $xorigdescription);
        $owner = $row2['submitter'];

        $row3 = $sql->retrieve("SELECT title FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE cid='".$cid."'" );        
        $row5 = $sql->retrieve("SELECT title FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE cid='".$origcid."'");
        $row7 = $sql->retrieve("SELECT ".UN_TABLENAME_USEREMAIL_ALIAS." FROM #".UN_TABLENAME_USERS." WHERE ".UN_TABLENAME_USERNAME."='".$modifysubmitter."'");
        $row8 = $sql->retrieve("SELECT ".UN_TABLENAME_USEREMAIL_ALIAS." FROM #".UN_TABLENAME_USERS." WHERE ".UN_TABLENAME_USERNAME."='".$owner."'");
        $cidtitle = stripslashes($row3);
        $origcidtitle = stripslashes($row5);
        $modifysubmitteremail = $row7['user_email'];
        $owneremail = $row8['user_email'];
          if ($owner == "") {
            $owner = _OWNERISADMIN;
          }
          if ($origsidtitle == "") {
            $origsidtitle= "-----";
          }
          if ($sidtitle == "") {
            $sidtitle = "-----";
          }
        $content .=  
         "<table class='table adminlist text-left' >"
        ."<thead><tr>"
        ."<td colspan=2><b>"._ORIGINAL."</b></td></tr></thead>"
        ."<tbody>"
        ."<tr><td><br>".LAN_DESCRIPTION.":</td><td>".$origdescription."</td></tr>"
        ."<tr><td>".LAN_TITLE.":</td><td>".$origtitle."</td></tr>"
        ."<tr><td>".LAN_URL.":</td><td> <a href=\"index.php?url=".$origurl."\">".$origurl."</a></td></tr>"
        ."<tr><td>".LAN_CATEGORY.":</td><td> ".$origcidtitle."</td></tr>"
        ."<tr><td>"._SUBCATEGORY.":</td><td> ".$origsidtitle."</td></tr>"
        ."</table><br>";
        
        $content .=  
         "<table class='table adminlist text-left' >"
        ."<thead><tr>"
        ."<td colspan=2><b>"._PROPOSED."</b></td></tr></thead>"
        ."<tbody>"        
        ."<td><br>".LAN_DESCRIPTION.":</td><td>".$xdescription."</td>"
        ."</tr>"
        ."<tr><td>".LAN_TITLE.":</td><td> ".$title."</td></tr>"
        ."<tr><td>".LAN_URL.":</td><td> <a href=\"index.php?url=".$url."\">".$url."</a></td></tr>"
        ."<tr><td>".LAN_CATEGORY.":</td><td> ".$cidtitle."</td></tr>"
        ."<tr><td>"._SUBCATEGORY.":</td><td> ".$sidtitle."</td></tr>"
        ."</table>"
        
        ."<div class='buttons-bar form-inline'>"
        ."<table align=\"center\" width=\"450\">"
        ."<tr>";
          if ($modifysubmitteremail=="") {
            $content .= "<td align=\"left\">"._SUBMITTER.":  ".$modifysubmitter."</td>";
          } else {
            $content .= "<td align=\"left\">"._SUBMITTER.":  <a href=\"mailto:".$modifysubmitteremail."\">".$modifysubmitter."</a></td>";
          }
          if ($owneremail=="") {
            $content .= "<td align=\"center\">"._OWNER.":  ".$owner."</td>";
          } else {
            $content .= "<td align=\"center\">"._OWNER.": <a href=\"mailto:".$owneremail."\">$owner</a></td>";
          }
        $content .= "<td align=\"right\">( <a class='btn update btn-success' href=\"".UN_FILENAME_ADMIN."?op=LinksChangeModRequests&amp;requestid=".$requestid."\">"._ACCEPT."</a> /
         <a class='btn update btn-warning' href=\"".UN_FILENAME_ADMIN."?op=LinksChangeIgnoreRequests&amp;requestid=".$requestid."\">"._IGNORE."</a> )</td></tr></table></div>";
      }
     
    if ($totalmodrequests == 0) {
      $content .= "<div class='center'>"._NOMODREQUESTS."</div><br><br>";
    }
    $content .= "</td></tr></table>";
    $content .= CloseTable();
    e107::getRender()->tablerender($caption, $content, 'web_links_index');
}

function LinksEditBrokenLinks($lid) {
    $sql = e107::getDb();
    
    $caption = _WEBLINKSADMIN. ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._EZBROKENLINKS;
	$content = OpenTable();
	$content .="<div class='center'><font class=\"option\"><b>"._EZBROKENLINKS."</b></font></div><br><br>";
	$lid = intval($lid);
	$result = $sql->retrieve("SELECT requestid, lid, cid, title, url, description, modifysubmitter FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE brokenlink='1' AND lid='".$lid."'", true);
	$row = $result[0];
    print_a($row);
	$requestid = $row['requestid'];
	$lid = $row['lid'];
	$cid = $row['cid'];
	$title = stripslashes($row['title']);
	$url = $row['url'];
	$url2 = urlencode($url);
	$description = stripslashes($row['description']);
	$modifysubmitter = $row['modifysubmitter'];
	$result2 = $sql->retrieve("SELECT name, email, hits FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'", true);
 
	$row2 = $result2[0];
 
	$name = $row2['name'];
	$email = $row2['email'];
	$hits = $row2['hits'];
	$content .="<form action=\"".UN_FILENAME_ADMIN."\" method=\"post\">"
	."<b>"._LINKID.": ".$lid."</b><br><br>"
	._SUBMITTER.":  ".$modifysubmitter."<br>"
	._PAGETITLE.": <input type=\"text\" name=\"title\" value=\"".$title."\" size=\"50\" maxlength=\"100\"><br>"
	._PAGEURL.": <input type=\"text\" name=\"url\" value=\"".$url."\" size=\"50\" maxlength=\"100\">&nbsp;[ <a  href='.$url.' target=\"_blank\">"._VISIT."</a> ]<br>"
	.LAN_DESCRIPTION.": <br><textarea name=\"description\" id=\"weblinks_link_broken_edit\" cols=\"70\" rows=\"15\">".un_htmlentities($description, ENT_QUOTES)."</textarea><br>"
	.LAN_NAME.": <input type=\"text\" name=\"name\" size=\"20\" maxlength=\"100\" value=\"".$name."\">&nbsp;&nbsp;"
	.LAN_EMAIL.": <input type=\"text\" name=\"email\" size=\"20\" maxlength=\"100\" value=\"".$email."\"><br>";
	$content .="<input type=\"hidden\" name=\"lid\" value=\"".$lid."\">";
	$content .="<input type=\"hidden\" name=\"hits\" value=\"".$hits."\">";
	$content .=_CATEGORY.": <select name=\"cat\">";
	$result = $sql->retrieve("SELECT cid, title, parentid FROM #".UN_TABLENAME_LINKS_CATEGORIES." ORDER BY title", true);
		foreach($result AS $row) {
			$cid2 = $row['cid'];
			$ctitle2 = $row['title'];
			$parentid2 = $row['parentid'];
			if ($cid2==$cid) {
				$sel = "selected";
			} else {
				$sel = "";
			}
			if ($parentid2 != 0) $ctitle2 = getparent($parentid2,$ctitle2);
				$content .="<option value=\"".$cid2."\" ".$sel.">".$ctitle2."</option>";
		}
 
	$content .="</select><input type=\"hidden\" name=\"op\" value=\"LinksModLinkS\">
    <input type=\"submit\" value=\""._MODIFY."\"> [ <a href=\"".UN_FILENAME_ADMIN."?op=LinksDelNew&amp;lid=".$lid."\">".LAN_DELETE."</a> ]</form>";
	$content .= CloseTable();
	$content .="<br>";
    e107::getRender()->tablerender($caption, $content, 'web_links_index');
}

function LinksModLinkS($lid, $title, $url, $description, $name, $email, $hits, $cat) {
	$sql = e107::getDb();
	$cat = explode("-", $cat);
		if ($cat[1] == "") {
			$cat[1] = 0;
		}
	$lid = intval($lid);
	$title = stripslashes(FixQuotes($title));
	$url = stripslashes(FixQuotes($url));
	$description = stripslashes(FixQuotes($description));
	$name = stripslashes(FixQuotes($name));
	$email = stripslashes(FixQuotes($email));
	$hits = intval($hits);
	$sql->gen("UPDATE ".UN_TABLENAME_LINKS_LINKS." SET cid='".$cat[0]."', sid='".$cat[1]."', title='".$title."', url='".$url."', description='".$description."', name='".$name."', email='".$email."', hits='".$hits."' WHERE lid='".$lid."'");
	$sql = "SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE lid='".$lid."'";
	$result = $sql->retrieve($sql);
	$row = $sql->fetch($result);
    $numrows = $result['numrows'];
		if ($numrows>0) {
			$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE lid='".$lid."'");
		}
	Header("Location: ".UN_FILENAME_ADMIN."?op=Links");
}

 
function LinksDelNew($lid) {
	$sql = e107::getDb();
	$lid = intval($lid);
	$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_NEWLINK." WHERE lid='".$lid."'");
	Header("Location: ".UN_FILENAME_ADMIN."?op=Links");
}

function LinksDelBrokenLinks($lid) {
	$sql = e107::getDb();
	$lid = intval($lid);
	$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE lid='".$lid."'");
	$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
	Header("Location: ".UN_FILENAME_ADMIN."?op=LinksListBrokenLinks");
}


function LinksIgnoreBrokenLinks($lid) {
	$sql = e107::getDb();
	$lid = intval($lid);
	$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE lid='".$lid."' AND brokenlink='1'");
	Header("Location: ".UN_FILENAME_ADMIN."?op=LinksListBrokenLinks");
}

function Links() {
    $caption = _WEBLINKSADMIN. ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._WLINKS;
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
}

function LinksChangeIgnoreRequests($requestid) {
	$sql = e107::getDb();
	$requestid = intval($requestid);
	$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE requestid='".$requestid."'");
	Header("Location: ".UN_FILENAME_ADMIN."?op=LinksListModRequests");
}

function LinksChangeModRequests($requestid) {  
	$sql = e107::getDb();
    $tp  = e107::getParser();
	$requestid = intval($requestid);
 
	$result = $sql->retrieve("SELECT requestid, lid, cid, sid, title, url, description FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE requestid='".$requestid."'", true);  
 
    foreach($result as $row) {        
		$requestid = $row['requestid'];
		$lid = $row['lid'];
		$cid = $row['cid'];
		$sid = $row['sid'];
		$title = $tp->toDb($row['title']);
		$url = $row['url'];
		$description = stripslashes($row['description']);
      
        $update = array(
        'data' => 
             array(
             'cid' =>  $cid,
             'sid'=>   $sid,
             'title'=>   $title,
             'url'=>  $url,
             'description'=>   $description
             ),
        'WHERE' =>  "lid = ".$lid
        );  
        $sql->gen("UPDATE #".UN_TABLENAME_LINKS_LINKS." SET cid='".$cid."', sid='".$sid."', title='".$title."', url='".$url."', description='".$description."' WHERE lid = ".$lid."");
       // e107::getDb()->update( UN_TABLENAME_LINKS_LINKS, $update);
    
    }
 
 	$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE requestid=".$requestid);
    Header("Location: ".UN_FILENAME_ADMIN."?op=LinksListModRequests");
}


function LinksDelLink($lid) {
	$sql = e107::getDb();
	$lid = intval($lid);
	$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
	$query = "SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE lid='".$lid."'";
	$result = $sql->gen($query);
	$row = $sql->fetch($result);
 
	$numrows = $row['numrows'];
		if ($numrows>0) {
			$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE lid='".$lid."'");
		}
	Header("Location: ".UN_FILENAME_ADMIN."?op=Links");
}