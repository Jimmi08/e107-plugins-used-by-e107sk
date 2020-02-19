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
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
}

function LinksCleanVotes() {
    $caption = _WEBLINKSADMIN. ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._CLEANLINKSDB;
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
}

function LinksListBrokenLinks() {
    $caption = _WEBLINKSADMIN. ' <span class="fa fa-angle-double-right e-breadcrumb"></span> '._BROKENLINKS;
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
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
     
	$result = $sql->gen("SELECT requestid, lid, cid, sid, title, url, description FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE requestid='".$requestid."'", true);  
	while ($row = $sql->fetch($result)) {        
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

        e107::getDb()->update( UN_TABLENAME_LINKS_LINKS, $update);
    
    }
 
 	$sql->gen("DELETE FROM #".UN_TABLENAME_LINKS_MODREQUEST." WHERE requestid=".$requestid);
    Header("Location: ".UN_FILENAME_ADMIN."?op=LinksListModRequests");
}