<?php 
 
 /* Use traits for commonly used functions, instead of classes... */
  require_once('web_links_functions.php');

  class web_links_front
  {

    use WebLinksTrait;

    function __construct()
	{
		$this->plugTemplates = e107::getTemplate('web_links', 'web_links');
		$this->plugPrefs = e107::getPlugConfig('web_links')->getPref();
    }
 
    public function AddLink()
	{
        $text =  "AddLink in progress";
        e107::getRender()->tablerender($caption, $text);
	}
	
    public function NewLinks($newlinkshowdays)
	{
		
		if ($newdownloadshowdays != "") {
			if (!is_numeric($newdownloadshowdays)) {
				e107::redirect(WEB_LINKS_INDEX);
				exit();
			}
		}
		$text = $this->menu(1);
		$text .=  "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$text .=  "<div class='center'><font class=\"option\"><b>"._NEWLINKS."</b></font></div><br>";
		$counter = 0;
		$allweeklinks = 0;
		while ($counter <= 7-1){
			$newlinkdayRaw = (time()-(86400 * $counter));
			$newlinkday = date("d-M-Y", $newlinkdayRaw);
			$newlinkView = date("F d, Y", $newlinkdayRaw);
			$newlinkDB = Date("Y-m-d", $newlinkdayRaw);
			$totalresult = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE date LIKE '%".$newlinkDB."%'");
			$totalrow = e107::getDB()->fetch($totalresult);
				
			$totallinks = $totalrow['numrows'];
			$counter++;
			$allweeklinks = $allweeklinks + $totallinks;
		}
		$counter = 0;
			while ($counter <=30-1){
				$newlinkdayRaw = (time()-(86400 * $counter));
				$newlinkDB = Date("Y-m-d", $newlinkdayRaw);
				$totalresult = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE date LIKE '%".$newlinkDB."%'");
				$totalrow = e107::getDB()->fetch($totalresult);
				 
				$totallinks = $totalrow['numrows'];
				$allmonthlinks = $allmonthlinks + $totallinks;
				$counter++;
			}
		$text .= "<div class='center'><b>"._TOTALNEWLINKS.":</b> "._LASTWEEK." - ".$allweeklinks." \ "._LAST30DAYS." - ".$allmonthlinks."<br>"
		._SHOW.": <a href=\"".WEB_LINKS_FRONTFILE."?l_op=NewLinks&amp;newlinkshowdays=7\">"._1WEEK."</a> - <a href=\"".WEB_LINKS_FRONTFILE."?l_op=NewLinks&amp;newlinkshowdays=14\">"._2WEEKS."</a> - <a href=\"".WEB_LINKS_FRONTFILE."?l_op=NewLinks&amp;newlinkshowdays=30\">"._30DAYS."</a>"
		."</div><br>";
		/* List Last VARIABLE Days of Links */
		if (!isset($newlinkshowdays)) {
			$newlinkshowdays = 7;
		}
		$text .= "<br><div class='center'><b>"._TOTALFORLAST." ".$newlinkshowdays." "._DAYS.":</b><br><br>";
		$counter = 0;
		$allweeklinks = 0;
			while ($counter <= $newlinkshowdays-1) {
				$newlinkdayRaw = (time()-(86400 * $counter));
				$newlinkday = date("d-M-Y", $newlinkdayRaw);
				$newlinkView = date("F d, Y", $newlinkdayRaw);
				$newlinkDB = Date("Y-m-d", $newlinkdayRaw);
				$totalresult = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE date LIKE '%".$newlinkDB."%'");
				$totalrow = e107::getDB()->fetch($totalresult);
				 
				$totallinks = $totalrow['numrows'];
				$counter++;
				$allweeklinks = $allweeklinks + $totallinks;
				$text .= "<span class='big'>&middot;</span> <a href=\"".WEB_LINKS_FRONTFILE."?l_op=NewLinksDate&amp;selectdate=".$newlinkdayRaw."\">".un_convert_time_by_locale($newlinkView, "downloads")."</a>&nbsp;(".$totallinks.")<br>";
			}
		$counter = 0;
		$allmonthlinks = 0;
		$text .= "</div>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
		$caption = '';
        e107::getRender()->tablerender($caption, $text, 'web_links_newlinks');
    }	
    public function NewLinksDate($selectdate)
	{
        $text =  "NewLinksDate in progress";
        e107::getRender()->tablerender($caption, $text);
    } 
    public function TopRated($ratenum, $ratetype) 
	{
        $text =  "TopRated in progress";
        e107::getRender()->tablerender($caption, $text);
    } 
    public function MostPopular($ratenum, $ratetype) 
	{
		global $db, $admin, $module_name, $user, $mainvotedecimal, $mostpoplinkspercentrigger, $mostpoplinks;
		$admin = base64_decode($admin);
		$admin = addslashes($admin);
		$admin = explode(":", $admin);
		$aid = $admin[0];
		$result = $db->sql_query("SELECT radminsuper FROM ".UN_TABLENAME_AUTHORS." WHERE aid='".$aid."'");
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$radminsuper = $row['radminsuper'];
		include("header.php");
		//include("modules/".$module_name."/l_config.php");
		menu(1);
		echo "<br>";
		OpenTable();
		echo "<table border=\"0\" width=\"100%\"><tr><td align=\"center\">";
			if ($ratenum != "" && $ratetype != "") {
				$mostpoplinks = $ratenum;
				if ($ratetype == "percent") $mostpoplinkspercentrigger = 1;
			}
			if ($mostpoplinkspercentrigger == 1) {
				$toplinkspercent = $mostpoplinks;
				$result2 = $db->sql_query("SELECT COUNT(*) AS numrows FROM ".UN_TABLENAME_LINKS_LINKS);
				$row2 = $db->sql_fetchrow($result2);
				$db->sql_freeresult($result);
				$totalmostpoplinks = $row2['numrows'];
				$mostpoplinks = $mostpoplinks / 100;
				$mostpoplinks = $totalmostpoplinks * $mostpoplinks;
				$mostpoplinks = round($mostpoplinks);
			}
			if ($mostpoplinkspercentrigger == 1) {
				echo "<div class='center'><font class=\"option\"><b>"._MOSTPOPULAR." ".$toplinkspercent."% ("._OFALL." ".$totalmostpoplinks." "._LINKS.")</b></font></div>";
			} else {
				echo "<div class='center'><font class=\"option\"><b>"._MOSTPOPULAR." ".un_htmlentities($mostpoplinks)."</b></font></div>";
			}
		echo "<tr><td><div class='center'>"._SHOWTOP.": [ <a href=\"modules.php?name=".$module_name."&amp;l_op=MostPopular&amp;ratenum=10&amp;ratetype=num\">10</a> - "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=MostPopular&amp;ratenum=25&amp;ratetype=num\">25</a> - "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=MostPopular&amp;ratenum=50&amp;ratetype=num\">50</a> | "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=MostPopular&amp;ratenum=1&amp;ratetype=percent\">1%</a> - "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=MostPopular&amp;ratenum=5&amp;ratetype=percent\">5%</a> - "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=MostPopular&amp;ratenum=10&amp;ratetype=percent\">10%</a> ]</div><br><br></td></tr>";
		if(!is_numeric($mostpoplinks)) {
			$mostpoplinks = 10;
		}
		$result3 = $db->sql_query("SELECT ll.lid, ll.cid, ll.sid, ll.title, ll.description, ll.date, ll.hits, ll.linkratingsummary, ll.totalvotes, ll.totalcomments, lc.title AS cat_title FROM ".UN_TABLENAME_LINKS_LINKS." ll, ".UN_TABLENAME_LINKS_CATEGORIES." lc WHERE lc.cid = ll.cid ORDER BY ll.hits DESC LIMIT 0,".$mostpoplinks);
		echo "<tr><td>";
			while($row3 = $db->sql_fetchrow($result3)) {
				$lid = $row3['lid'];
				$cid = $row3['cid'];
				$sid = $row3['sid'];
				$title = stripslashes(check_html($row3['title'], "nohtml"));
				$description = stripslashes($row3['description']);
				$time = $row3['date'];
				$hits = $row3['hits'];
				$linkratingsummary = $row3['linkratingsummary'];
				$totalvotes = $row3['totalvotes'];
				$totalcomments = $row3['totalcomments'];
				$linkratingsummary = number_format($linkratingsummary, $mainvotedecimal);
				$ctitle = stripslashes(check_html($row3['cat_title'], "nohtml"));
				if (is_admin($admin)) {
					echo "<a href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\"><img src=\"modules/".$module_name."/images/lwin.gif\" border=\"0\" alt=\""._EDIT."\"></a>&nbsp;&nbsp;";
				} else {
					echo "<img src=\"modules/".$module_name."/images/lwin.gif\" border=\"0\" alt=\"\">&nbsp;&nbsp;";
				}
				echo "<font class=\"content\"><a href=\"modules.php?name=".$module_name."&amp;l_op=visit&amp;lid=".$lid."\" target=\"_blank\">".$title."</a>";
				newlinkgraphic($time);
				popgraphic($hits);
				echo "<br>";
				echo _DESCRIPTION.": ".$description."<br>";
				setlocale (LC_TIME, $locale);
				//eregx ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
				preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#i", $time, $datetime);			
				$datetime = strftime(_LINKSDATESTRING, mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
				setlocale(LC_TIME, 'en_US');
				$datetime = ucfirst($datetime);
				echo _ADDEDON.": ".$datetime." "._HITS.": <b>".$hits."</b>";
				/* voting & comments stats */
					if ($totalvotes == 1) {
						$votestring = _VOTE;
					} else {
						$votestring = _VOTES;
					}
					if ($linkratingsummary != "0" || $linkratingsummary != "0.0") {
						echo " "._RATING.": ".$linkratingsummary." ("._VOTES.": ".$totalvotes.")";
					}
				echo "<br>";
					if ($radminsuper == 1) {
						echo "<a href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">"._EDIT."</a> | ";
					}
				echo "<a href=\"modules.php?name=".$module_name."&amp;l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
					if (is_user($user)) {
						echo " | <a href=\"modules.php?name=".$module_name."&amp;l_op=brokenlink&amp;lid=".$lid."\">"._REPORTBROKEN."</a>";
					}
					if ($totalvotes != 0) {
						echo " | <a href=\"modules.php?name=".$module_name."&amp;l_op=viewlinkdetails&amp;lid=".$lid."\">"._DETAILS."</a>";
					}
					if ($totalcomments != 0) {
						echo " | <a href=\"modules.php?name=".$module_name."&amp;l_op=viewlinkcomments&amp;lid=".$lid."\">"._SCOMMENTS." (".$totalcomments.")</a>";
					}
				detecteditorial($lid);
				echo "<br>";
				$ctitle = getparent($cid,$ctitle);
				echo _CATEGORY.": ".$ctitle;
				echo "<br><br>";
				echo "<br><br></font>";
			}
		$db->sql_freeresult($result3);
		echo "</font></td></tr></table>";
		CloseTable();
		include("footer.php");
		
		$text =  "MostPopular in progress";
        e107::getRender()->tablerender($caption, $text);
    } 	
    public function RandomLink() 
	{
        $text =  "RandomLink in progress";
        e107::getRender()->tablerender($caption, $text);
    } 	
    public function viewlink($cid, $min, $orderby, $show) 
	{
        $text =  "viewlink in progress";
        e107::getRender()->tablerender($caption, $text);
    }  
    public function brokenlink($lid)
	{
        $text =  "brokenlink in progress";
        e107::getRender()->tablerender($caption, $text);
    }  	
    public function modifylinkrequest($lid)
	{
        $text =  "modifylinkrequest in progress";
        e107::getRender()->tablerender($caption, $text);
    }   	
    public function modifylinkrequestS($lid, $cat, $title, $url, $description, $modifysubmitter)
	{
        $text =  "modifylinkrequestS in progress";
        e107::getRender()->tablerender($caption, $text);
    }    
    public function brokenlinkS($lid,$cid, $title, $url, $description, $modifysubmitter)
	{
        $text =  "brokenlinkS in progress";
        e107::getRender()->tablerender($caption, $text);
    }   
    public function visit($lid)
	{
        $text =  "visit in progress";
        e107::getRender()->tablerender($caption, $text);
    }   
    public function Add($title, $url, $auth_name, $cat, $description, $email)
	{
        $text =  "Add in progress";
        e107::getRender()->tablerender($caption, $text);
    }	
    public function search($unquery, $min, $orderby, $show)
	{
        $text =  "search in progress";
        e107::getRender()->tablerender($caption, $text);
    }	
    public function rateinfo($lid, $user)
	{
        $text =  "rateinfo in progress";
        e107::getRender()->tablerender($caption, $text);
    }		
    public function ratelink($lid)
	{
        $text =  "ratelink in progress";
        e107::getRender()->tablerender($caption, $text);
    } 
    public function addrating($ratinglid, $ratinguser, $rating, $ratinghost_name, $ratingcomments, $user)
	{
        $text =  "addrating in progress";
        e107::getRender()->tablerender($caption, $text);
    } 
    public function viewlinkcomments($lid)
	{
        $text =  "viewlinkcomments in progress";
        e107::getRender()->tablerender($caption, $text);
    } 	
    public function outsidelinksetup($lid)
	{
        $text =  "outsidelinksetup in progress";
        e107::getRender()->tablerender($caption, $text);
    } 
    public function viewlinkeditorial($lid)
	{
        $text =  "viewlinkeditorial in progress";
        e107::getRender()->tablerender($caption, $text);
    }  
    public function viewlinkdetails($lid)
	{
        $text = "viewlinkdetails in progress";
        e107::getRender()->tablerender($caption, $text);
    } 	
    public function index()
	{
		$dum = NULL;
		$mainlink = 0;
		$text = $this->menu($mainlink);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$text .= "<div class='center'><font class=\"title\"><b>"._LINKSMAINCAT."</b></font></div><br>";
		$text .= "<table border=\"0\" cellspacing=\"10\" cellpadding=\"0\" align=\"center\"><tr>";	

		$result = e107::getDB()->gen("SELECT cid, title, cdescription FROM #".UN_TABLENAME_LINKS_CATEGORIES."  WHERE parentid='0' ORDER BY title");
		$rowresult = e107::getDB()->rows();
		$count = 0;
		foreach ($rowresult as $row)  {
			$cid = $row['cid'];
			$title = e107::getParser()->toHTML($row['title'], "nohtml");
			$cdescription = stripslashes($row['cdescription']);
			$text .= "<td><font class=\"option\"><span class='big'>&middot;</span> <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."\"><b>".$title."</b></a></font>";
			$text .= $this->categorynewlinkgraphic($cid);
			if ($cdescription) {
				$text .= "<br><font class=\"content\">".$cdescription."</font><br>";
			} else {
				$text .= "<br>";
			}
			$result2 = e107::getDB()->gen("SELECT cid, title FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE parentid='".$cid."' ORDER BY title");// limit 0,3");
			$rowresult2 = e107::getDB()->rows();
			$space = 0;   
			foreach ($rowresult2 as $row2)  { 
				$cid = $row2['cid'];
				$stitle = e107::getParser()->toHTML($row2['title'], "nohtml");
				if ($space>0) {
					$text .= ", ";
				}
				$text .= "<font class=\"content\"><a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."\">".$stitle."</a></font>";
				$space++;
			}
			if ($count<1) {
				$text .= "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				$dum = 1;
			}
			$count++;
			if ($count==2) {
				$text .= "</td></tr><tr>";
				$count = 0;
				$dum = 0;
			}
		}
		if ($dum == 1) {
			$text .= "</tr></table>";
		} elseif ($dum == 0) {
			$text .= "<td></td></tr></table>";
		}
		$result3 = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS);
		$numrow = e107::getDB()->fetch($result3);
		$numrows = $numrow['numrows'];
		$result4 = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_CATEGORIES);
		$catrow = e107::getDB()->fetch($result4);
		$catnum = $catrow['numrows'];
		$text .= "<br><br><center><font class=\"content\">"._THEREARE." <b>".$numrows."</b> "._LINKS." "._AND." <b>".$catnum."</b> "._CATEGORIES." "._INDB."</font></center>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];		
		 
		$caption = ''; 
        e107::getRender()->tablerender($caption, $text, 'web_links_index');
    } 
} 