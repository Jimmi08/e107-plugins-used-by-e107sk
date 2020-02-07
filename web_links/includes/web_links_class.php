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
		$text .=  "<div class='center'><span class=\"option\"><b>"._NEWLINKS."</b></span></div><br>";
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
		global $db, $admin, $module_name, $user, $toplinks, $mainvotedecimal, $toplinkspercentrigger, $linkvotemin;
		include("header.php");
		//include("modules/".$module_name."/l_config.php");
		menu(1);
		echo "<br>";
		OpenTable();
		echo "<table border=\"0\" width=\"100%\"><tr><td align=\"center\">";
			if ($ratenum != "" && $ratetype != "") {
				$toplinks = $ratenum;
				if ($ratetype == "percent") {
				$toplinkspercentrigger = 1;
				}
			}
			if ($toplinkspercentrigger == 1) {
				$toplinkspercent = $toplinks;
				$totalresult = $db->sql_query("SELECT COUNT(*) AS numrows FROM ".UN_TABLENAME_LINKS_LINKS." WHERE linkratingsummary <> '0'");
				$totalrow = $db->sql_fetchrow($totalresult);
				$db->sql_freeresult($totalresult);
				$totalratedlinks = $totalrow['numrows'];
				$toplinks = $toplinks / 100;
				$toplinks = $totalratedlinks * $toplinks;
				$toplinks = round($toplinks);
			}
			if ($toplinkspercentrigger == 1) {
				echo "<div class='center'><font class=\"option\"><b>"._BESTRATED." ".$toplinkspercent."% ("._OF." ".$totalratedlinks." "._TRATEDLINKS.")</b></font></div><br>";
			} else {
				echo "<div class='center'><font class=\"option\"><b>"._BESTRATED." ".un_htmlentities($toplinks)." </b></font></div><br>";
			}
		echo "</td></tr>"
		."<tr><td><div class='center'>"._NOTE." ".$linkvotemin." "._TVOTESREQ."<br>"
		._SHOWTOP.":  [ <a href=\"modules.php?name=".$module_name."&amp;l_op=TopRated&amp;ratenum=10&amp;ratetype=num\">10</a> - "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=TopRated&amp;ratenum=25&amp;ratetype=num\">25</a> - "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=TopRated&amp;ratenum=50&amp;ratetype=num\">50</a> | "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=TopRated&amp;ratenum=1&amp;ratetype=percent\">1%</a> - "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=TopRated&amp;ratenum=5&amp;ratetype=percent\">5%</a> - "
		."<a href=\"modules.php?name=".$module_name."&amp;l_op=TopRated&amp;ratenum=10&amp;ratetype=percent\">10%</a> ]</div><br><br></td></tr>";
		$result = $db->sql_query("SELECT ll.lid, ll.cid, ll.sid, ll.title, ll.description, ll.date, ll.hits, ll.linkratingsummary, ll.totalvotes, ll.totalcomments, lc.title AS cat_title FROM ".UN_TABLENAME_LINKS_LINKS." ll, ".UN_TABLENAME_LINKS_CATEGORIES." lc WHERE lc.cid = ll.cid AND ll.linkratingsummary <> 0 AND ll.totalvotes >= ".$linkvotemin." ORDER BY ll.linkratingsummary DESC LIMIT 0,".$toplinks);
		echo "<tr><td>";
			while ($row = $db->sql_fetchrow($result)) {
				$lid = $row['lid'];
				$cid = $row['cid'];
				$sid = $row['sid'];
				$title = stripslashes(check_html($row['title'], "nohtml"));
				$description = stripslashes($row['description']);
				$time = $row['date'];
				$hits = $row['hits'];
				$linkratingsummary = $row['linkratingsummary'];
				$totalvotes = $row['totalvotes'];
				$totalcomments = $row['totalcomments'];
				$linkratingsummary = number_format($linkratingsummary, $mainvotedecimal);
				$ctitle = stripslashes(check_html($row['cat_title'], "nohtml"));
				if (is_admin($admin)) {
					echo "<a href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\"><img src=\"modules/".$module_name."/images/lwin.gif\" border=\"0\" alt=\""._EDIT."\"></a>&nbsp;&nbsp;";
				} else {
					echo "<img src=\"modules/".$module_name."/images/lwin.gif\" border=\"0\" alt=\"\">&nbsp;&nbsp;";
				}
				echo "<a href=\"modules.php?name=".$module_name."&amp;l_op=visit&amp;lid=".$lid."\" target=\"_blank\">".$title."</a>";
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
				echo _ADDEDON.": ".$datetime." "._HITS.": ".$hits;
					/* voting & comments stats */
					if ($totalvotes == 1) {
						$votestring = _VOTE;
					} else {
						$votestring = _VOTES;
					}
					if ($linkratingsummary != "0" || $linkratingsummary != "0.0") {
						echo " "._RATING.": <b> ".$linkratingsummary." </b> ("._VOTES.": ".$totalvotes.")";
					}
				echo "<br><a href=\"modules.php?name=".$module_name."&amp;l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
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
				echo "<br><br>";
			}
		$db->sql_freeresult($result);
		echo "</td></tr></table>";
		CloseTable();
		include("footer.php");
        e107::getRender()->tablerender($caption, $text);
    } 
    public function MostPopular($ratenum, $ratetype) 
	{
		global   $mainvotedecimal, $mostpoplinkspercentrigger, $mostpoplinks;
		/*
		global  $admin;
		$admin = base64_decode($admin);
		$admin = addslashes($admin);
		$admin = explode(":", $admin);
		$aid = $admin[0];
		$result = e107::getDB()->gen("SELECT radminsuper FROM ".UN_TABLENAME_AUTHORS." WHERE aid='".$aid."'");
		$row = e107::getDB()->fetch($result);
		 
		$radminsuper = $row['radminsuper'];  */
		$module_name =  WEB_LINKS_APP;

		$text  = $this->menu(1);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$text .= "<table border=\"0\" width=\"100%\"><tr><td align=\"center\">";
			if ($ratenum != "" && $ratetype != "") {
				$mostpoplinks = $ratenum;
				if ($ratetype == "percent") $mostpoplinkspercentrigger = 1;
			}
			if ($mostpoplinkspercentrigger == 1) {
				$toplinkspercent = $mostpoplinks;
				$result2 = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS);
				$row2 = e107::getDB()->fetch($result2);
				 
				$totalmostpoplinks = $row2['numrows'];
				$mostpoplinks = $mostpoplinks / 100;
				$mostpoplinks = $totalmostpoplinks * $mostpoplinks;
				$mostpoplinks = round($mostpoplinks);
			}
			if ($mostpoplinkspercentrigger == 1) {
				$text .= "<div class='center'><span class=\"option\"><b>"._MOSTPOPULAR." ".$toplinkspercent."% ("._OFALL." ".$totalmostpoplinks." "._LINKS.")</b></span></div>";
			} else {
				$text .= "<div class='center'><span class=\"option\"><b>"._MOSTPOPULAR." ".un_htmlentities($mostpoplinks)."</b></span></div>";
			}
		$text .= "<tr><td><div class='center'>"._SHOWTOP.": [ <a href=\"".WEB_LINKS_FRONTFILE."?l_op=MostPopular&amp;ratenum=10&amp;ratetype=num\">10</a> - "
		."<a href=\"".WEB_LINKS_FRONTFILE."?l_op=MostPopular&amp;ratenum=25&amp;ratetype=num\">25</a> - "
		."<a href=\"".WEB_LINKS_FRONTFILE."?l_op=MostPopular&amp;ratenum=50&amp;ratetype=num\">50</a> | "
		."<a href=\"".WEB_LINKS_FRONTFILE."?l_op=MostPopular&amp;ratenum=1&amp;ratetype=percent\">1%</a> - "
		."<a href=\"".WEB_LINKS_FRONTFILE."?l_op=MostPopular&amp;ratenum=5&amp;ratetype=percent\">5%</a> - "
		."<a href=\"".WEB_LINKS_FRONTFILE."?l_op=MostPopular&amp;ratenum=10&amp;ratetype=percent\">10%</a> ]</div><br><br></td></tr>";
		if(!is_numeric($mostpoplinks)) {
			$mostpoplinks = 10;
		}
		$result3 = e107::getDB()->gen("SELECT ll.lid, ll.cid, ll.sid, ll.title, ll.description, ll.date, ll.hits, ll.linkratingsummary, ll.totalvotes, ll.totalcomments, lc.title AS cat_title FROM #".UN_TABLENAME_LINKS_LINKS." ll, #".UN_TABLENAME_LINKS_CATEGORIES." lc WHERE lc.cid = ll.cid ORDER BY ll.hits DESC LIMIT 0,".$mostpoplinks);
		$text .= "<tr><td>";
		$rowresult3 = e107::getDB()->rows();
		foreach ($rowresult3 as $row3)  {
				$lid = $row3['lid'];
				$cid = $row3['cid'];
				$sid = $row3['sid'];
				$title = e107::getParser()->toHTML($row3['title'], "", "TITLE");
				$description = e107::getParser()->toHTML($row3['description'], "", "DESCRIPTION");
				$time = $row3['date'];
				$hits = $row3['hits'];
				$linkratingsummary = $row3['linkratingsummary'];
				$totalvotes = $row3['totalvotes'];
				$totalcomments = $row3['totalcomments'];
				$linkratingsummary = number_format($linkratingsummary, $mainvotedecimal);
				$ctitle = e107::getParser()->toHTML($row3['cat_title'], "", "TITLE");
				 
				//if (is_admin($admin)) {
				if(ADMIN) {
					$text .= "<a href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">
					<img src=\"".$module_name."/images/lwin.gif\" border=\"0\" alt=\""._EDIT."\"></a>&nbsp;&nbsp;";
				} else {
					$text .= "<img src=\"".$module_name."/images/lwin.gif\" border=\"0\" alt=\"\">&nbsp;&nbsp;";
				}
				$text .= "<span class=\"content\"><a href=\"".WEB_LINKS_FRONTFILE."?l_op=visit&amp;lid=".$lid."\" target=\"_blank\">".$title."</a>";
				$text .=$this->newlinkgraphic($time);
				$text .=$this->popgraphic($hits);
				$text .= "<br>";
				$text .= _DESCRIPTION.": ".$description."<br>";
				setlocale (LC_TIME, $locale);
				//eregx ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
				preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#i", $time, $datetime);			
				$datetime = strftime(_LINKSDATESTRING, mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
				setlocale(LC_TIME, 'en_US');
				$datetime = ucfirst($datetime);
				$text .= _ADDEDON.": ".$datetime." "._HITS.": <b>".$hits."</b>";
				/* voting & comments stats */
				if ($totalvotes == 1) {
					$votestring = _VOTE;
				} else {
					$votestring = _VOTES;
				}
				if ($linkratingsummary != "0" || $linkratingsummary != "0.0") {
					$text .= " "._RATING.": ".$linkratingsummary." ("._VOTES.": ".$totalvotes.")";
				}
				$text .= "<br>";
				if ($radminsuper == 1) {
					$text .= "<a href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">"._EDIT."</a> | ";
				}
				$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
				//if (is_user($user)) {
				if(USER) {	
					$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=brokenlink&amp;lid=".$lid."\">"._REPORTBROKEN."</a>";
				}
				if ($totalvotes != 0) {
					$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkdetails&amp;lid=".$lid."\">"._DETAILS."</a>";
				}
				if ($totalcomments != 0) {
					$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkcomments&amp;lid=".$lid."\">"._SCOMMENTS." (".$totalcomments.")</a>";
				}
				$text .= $this->detecteditorial($lid);
				$text .= "<br>";
				$ctitle = $this->getparent($cid,$ctitle);
				$text .= _CATEGORY.": ".$ctitle;
				$text .= "<br><br>";
				$text .= "<br><br></span>";
			}
		 
		$text .= "</span></td></tr></table>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
		 

		$caption  =  "";
        e107::getRender()->tablerender($caption, $text, 'web_links_mostpopular');
    } 	
    public function RandomLink() 
	{
		$result = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS);
		$row = e107::getDB()->fetch($result);
		 
		$numrows = $row['numrows'];
			if ($numrows == 1) {
				$random = 1;
			} else {
				srand((double)microtime()*1000000);
				$random = rand(1,$numrows);
			}
		$result2 = e107::getDB()->gen("SELECT url FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$random."'");
		$row2 = e107::getDB()->fetch($result2);
		 
		$url = stripslashes($row2['url']);
		e107::getDB()->gen("UPDATE #".UN_TABLENAME_LINKS_LINKS." SET hits=hits+1 WHERE lid='".$random."'");
		Header("Location: ".$url);  //TODO check LP , don't use e107::redirect()
	}
	 	
    public function viewlink($cid, $min, $orderby, $show) 
	{
		$perpage = $this->plugPrefs['perpage'];
		$mainvotedecimal = $this->plugPrefs['mainvotedecimal'];

		$show = intval($show);
			if (empty($show)) {
				$show = '';
			}
 
		if (!isset($min) || empty($min)) $min = 0;
		if (!isset($max)) $max=$min+$perpage;
			if(isset($orderby)) {
				$orderby = $this->convertorderbyin($orderby);
			} else {
				$orderby = "title ASC";
			}
			if ($show != "") {
				$perpage = $show;
			} else {
				$show = $perpage;
			}
		$text = $this->menu(1);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$cid = intval($cid);
		$result_two = e107::getDB()->gen("SELECT title, parentid FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE cid='".$cid."'");
		$row_two = e107::getDB()->fetch($result_two);
		 
		$title = e107::getParser()->toHTML($row_two['title'], "", "TITLE");
		$parentid = $row_two['parentid'];
		$title = $this->getparentlink($parentid,$title);
		$title = "<a href=\"".WEB_LINKS_FRONTFILE."\">"._MAIN."</a>/".$title;
		$text .= "<div class='center'><span class=\"option\"><b>"._CATEGORY.": ".$title."</b></span></div><br>";
		$text .= "<table border=\"0\" cellspacing=\"10\" cellpadding=\"0\" align=\"center\"><tr>";
		$cid = intval($cid);
		$result2 = e107::getDB()->gen("SELECT cid, title, cdescription FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE parentid='".$cid."' ORDER BY title");
		$count = 0;
		$rowresult2 = e107::getDB()->rows();  
		foreach ($rowresult2 as $row2)  {
				$cid2 = $row2['cid'];
				$title2 = e107::getParser()->toHTML($row2['title'], "", "TITLE");
				$cdescription2 = stripslashes($row2['cdescription']); 
				$text .= "<td><span class=\"option\"><span class='big'>&middot;</span> <a href=\"".WEB_LINKS_FRONTFILE."?&amp;l_op=viewlink&amp;cid=".$cid2."\"><b>".$title2."</b></a></span>";
				$this->categorynewlinkgraphic($cid2);
				if ($cdescription2) {
					$text .= " <span class=\"content\">".$cdescription2."</span><br>";
				} else {
					$text .= "<br>";
				}
				$result3 = e107::getDB()->gen("SELECT cid, title FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE parentid='".$cid2."' ORDER BY title");// limit 0,3");
				$space = 0;
					while($row3 = e107::getDB()->fetch($result3)) {
						$cid3 = $row3['cid'];
						$title3 = e107::getParser()->toHTML($row3['title'], "", "TITLE");
							if ($space>0) {
								$text .= ", ";
							}
						$text .= "<span class=\"content\"><a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid3."\">".$title3."</a></span>";
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
		$text .= "<hr noshade size=\"1\">";
		$orderbyTrans = $this->convertorderbytrans($orderby);
		$text .= "<div class='center'><span class=\"content\">"._SORTLINKSBY.": "
		._TITLE." (<a href=\"href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=titleA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=titleD\">D</a>) "
		._DATE." (<a href=\"href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=dateA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=dateD\">D</a>) "
		._RATING." (<a href=\"href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=ratingA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=ratingD\">D</a>) "
		._POPULARITY." (<a href=\"href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=hitsA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=hitsD\">D</a>)"
		."<br><b>"._SITESSORTED.": ".$orderbyTrans."</b></span></div><br><br>";
			if(!is_numeric($min)){
				$min=0;
			}
		$result4 = e107::getDB()->gen("SELECT lid, title, description, date, hits, linkratingsummary, totalvotes, totalcomments FROM #".UN_TABLENAME_LINKS_LINKS." WHERE cid='".$cid."' ORDER BY ".$orderby." LIMIT ".$min.",".$perpage);
		$rowresult4 = e107::getDB()->rows(); 
		$fullcountresult = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE cid='".$cid."'");
		$fullcountrow = e107::getDB()->fetch($fullcountresult);
		 
		$totalselectedlinks = $fullcountrow['numrows'];	
		$text .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\"><tr><td><span class=\"content\">";
		$x=0;
		 
	    foreach ($rowresult4 as $row4)  {
		//	while($row4 = e107::getDB()->fetch($result4)) {
				$lid = $row4['lid'];
				$title = e107::getParser()->toHTML($row4['title'], "", "TITLE");
				$description = stripslashes($row4['description']);
				$time = $row4['date'];
				$hits = $row4['hits'];
				$linkratingsummary = $row4['linkratingsummary'];
				$totalvotes = $row4['totalvotes'];
				$totalcomments = $row4['totalcomments'];
				$linkratingsummary = number_format($linkratingsummary, $mainvotedecimal);
				//if (is_admin($admin)) {
				if (ADMIN) {
					$text .= "<a href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\"><img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\""._EDIT."\"></a>&nbsp;&nbsp;";
				} else {
					$text .= "<img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"\">&nbsp;&nbsp;";
				}
				$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=visit&amp;lid=".$lid."\" target=\"_blank\"><b>".$title."</b></a>";
				$this->newlinkgraphic($time);
				$this->popgraphic($hits);
				/* INSERT code for *editor review* here */
				$text .= "<br>";
				$text .= ""._DESCRIPTION.": ".$description."<br>";
				setlocale (LC_TIME, $locale);
				//eregx ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
				preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#i", $time, $datetime);			
				$datetime = strftime(_LINKSDATESTRING, mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
				setlocale(LC_TIME, 'en_US');
				$datetime = ucfirst($datetime);
				$text .= _ADDEDON.": ".$datetime." "._HITS.": ".$hits;
					/* voting & comments stats */
					if ($totalvotes == 1) {
						$votestring = _VOTE;
					} else {
						$votestring = _VOTES;
					}
					if ($linkratingsummary != "0" || $linkratingsummary != "0.0") {
						$text .= " "._RATING.": ".$linkratingsummary." ("._VOTES.": ".$totalvotes.")";
					}
				$text .= "<br>";
					if ($radminsuper == 1) {
						$text .= "<a href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">"._EDIT."</a> | ";
					}
				$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
					//if (is_user($user)) {
					if (USER) {
						$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=brokenlink&amp;lid=".$lid."\">"._REPORTBROKEN."</a>";
					}
					if ($totalvotes != 0) {
						$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkdetails&amp;lid=".$lid."\">"._DETAILS."</a>";
					}
					if ($totalcomments != 0) {
						$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkcomments&amp;lid=".$lid."\">"._SCOMMENTS." (".$totalcomments.")</a>";
					}
				$this->detecteditorial($lid);
				$text .= "<br><br>";
				$x++;
			}
		 
		$text .= "</span>";
		$orderby = $this->convertorderbyout($orderby);
		/* Calculates how many pages exist. Which page one should be on, etc... */
		$linkpagesint = ($totalselectedlinks / $perpage);
		$linkpageremainder = ($totalselectedlinks % $perpage);
			if ($linkpageremainder != 0) {
				$linkpages = ceil($linkpagesint);
				if ($totalselectedlinks < $perpage) {
					$linkpageremainder = 0;
				}
			} else {
				$linkpages = $linkpagesint;
			}
			/* Page Numbering */
			if ($linkpages!=1 && $linkpages!=0) {
				$text .= "<br><br>";
				$text .= _SELECTPAGE.": ";
				$prev = $min-$perpage;
					if ($prev>=0) {
						$leftarrow = WEB_LINKS_APP_ABS."images/left.gif" ;
						$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;min=".$prev."&amp;orderby=".$orderby."&amp;show=".$show."\">";
						$text .= "<img src=\"".$leftarrow."\" align=\"middle\" border=\"0\" hspace=\"5\" alt=\""._PREVIOUS."\"></a>";
					}
				$counter = 1;
				$currentpage = ($max / $perpage);
				$text .= "[ ";
					while ($counter<=$linkpages ) {
						$cpage = $counter;
						$mintemp = ($perpage * $counter) - $perpage;
							if ($counter == $currentpage) {
								$text .= "<b>".$counter."</b> ";
							} else {
								$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;min=".$mintemp."&amp;orderby=".$orderby."&amp;show=".$show."\">".$counter."</a> ";
							}
						$counter++;
					}
				$text .= " ]";
				$next=$min+$perpage;
					if ($x>=$perpage) {
						$rightarrow = WEB_LINKS_APP_ABS."images/right.gif";					  
						 
						$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;min=".$max."&amp;orderby=".$orderby."&amp;show=".$show."\">";
						$text .= "<img src=\"".$rightarrow."\" align=\"middle\" border=\"0\" hspace=\"5\" alt=\""._NEXT."\"></a>";
					}
			}
		$text .= "</td></tr></table>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
 
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
		$lid = intval($lid);
		e107::getDB()->gen("UPDATE #".UN_TABLENAME_LINKS_LINKS." SET hits=hits+1 WHERE lid='".$lid."'");
		update_points(14);
		$result = e107::getDB()->gen("SELECT url FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
		$row = e107::getDB()->fetch($result);
		$url = stripslashes($row['url']);
		Header("Location: ".$url);
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
		global $db;
		$lid = intval($lid);
		$db->sql_query("UPDATE ".UN_TABLENAME_LINKS_LINKS." SET hits=hits+1 WHERE lid='".$lid."'");
		$result = $db->sql_query("SELECT url FROM ".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$url = stripslashes($row['url']);
		Header("Location: ".$url);
        e107::getRender()->tablerender($caption, $text);
    }		
    public function ratelink($lid)
	{
		global $cookie, $datetime, $anonymous, $user;
		 
		$text = $this->menu(1);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$lid = intval($lid);
		$res = e107::getDB()->gen("SELECT title FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
		$row =  e107::getDB()->fetch($res);
		$displaytitle = e107::getParser()->toHTML($row['title'], "", "TITLE");
		$ip = $_SERVER["REMOTE_HOST"];
		if (empty($ip)) {
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		$text .=  "<b>".$displaytitle."</b>"
		."<ul class='text-left'>"
		."<li>"._RATENOTE1."</li>"
		."<li>"._RATENOTE2."</li>"
		."<li>"._RATENOTE3."</li>"
		."<li>"._RATENOTE4."</li>"  //FIX LAN with [x]
		."<li>"._RATENOTE5."</li>";
			if(USER) {
				$auth_name = USERNAME;
				$text .=  "<li>"._YOUAREREGGED."</li>"
				."<li>"._FEELFREE2ADD."</li>";
 
			} else {
				$text .=  "<li>"._YOUARENOTREGGED."</li>"
				."<li>"._IFYOUWEREREG."</li>";
				$auth_name = $anonymous;
			}
		$text .=  "</ul>"
		."<form method=\"post\" action=\"".WEB_LINKS_FRONTFILE."\">"
		."<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">"
		."<tr><td width=\"25\" nowrap></td>"
		."<tr><td width=\"25\" nowrap></td><td width=\"550\">"
		."<input type=\"hidden\" name=\"ratinglid\" value=\"".$lid."\">"
		."<input type=\"hidden\" name=\"ratinguser\" value=\"".$auth_name."\">"
		."<input type=\"hidden\" name=\"ratinghost_name\" value=\"".$ip."\">"
		."<span class=\"content\">"._RATETHISSITE
		."<select name=\"rating\">"  //TODO fix select look
		."<option>--</option>"
		."<option>10</option>"
		."<option>9</option>"
		."<option>8</option>"
		."<option>7</option>"
		."<option>6</option>"
		."<option>5</option>"
		."<option>4</option>"
		."<option>3</option>"
		."<option>2</option>"
		."<option>1</option>"
		."</select></span>"
		." <span class=\"content\"><input class='button tbox btn' type=\"submit\" value=\""._RATETHISSITE."\"></span>"
		."<br><br>";
		// karma system, not banned users TODO
		//$result = e107::getDB()->gen("SELECT karma FROM #".UN_TABLENAME_USERS." WHERE user_id='".intval($cookie[0])."'");
		//$karma =  e107::getDB()->fetch($result);
		$karma['karma'] = 1; //temp fix   
			if(USER AND $karma['karma'] != 3 AND $karma['karma'] != 4) {
				$text .=  "<span class=\"content\"><b>"._SCOMMENTS.":</b><br>
				<textarea class='form-control' wrap=\"virtual\" cols=\"70\" rows=\"15\" name=\"ratingcomments\" id=\"weblinks_comments\"></textarea>"
				."<br><br><br>"
				."</span></td>";
			} else {
				$text .=  "<input type=\"hidden\" name=\"ratingcomments\" value=\"\">";
			}
		$text .=  "</tr></table></form>";
		$text .=  "<div class='center'>";
		$text .= $this->linkfooterchild($lid);
		$text .=  "</div>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
		 
        e107::getRender()->tablerender($caption, $text);
    } 
    public function addrating($ratinglid, $ratinguser, $rating, $ratinghost_name, $ratingcomments)
	{
		global $db, $cookie, $user, $module_name, $anonymous, $anonwaitdays, $outsidewaitdays;
		$passtest = "yes";
		include("header.php");
		//include("modules/".$module_name."/l_config.php");
		$ratinglid = intval($ratinglid);
		completevoteheader();
			if(is_user($user)) {
				$user2 = base64_decode($user);
				$user2 = addslashes($user2);
				$cookie = explode(":", $user2);
				cookiedecode($user);
				$ratinguser = $cookie[1];
			} else if ($ratinguser=="outside") {
				$ratinguser = "outside";
			} else {
				$ratinguser = $anonymous;
			}
		/*$result = $db->sql_query("SELECT title FROM ".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$ratinglid."'");
			while ($row = $db->sql_fetchrow($result)) {
				$title = stripslashes(check_html($row['title'], "nohtml"));
				$ttitle = $title;*/
				/* Make sure only 1 anonymous from an IP in a single day. */
				$ip = $_SERVER["REMOTE_HOST"];
					if (empty($ip)) {
						$ip = $_SERVER["REMOTE_ADDR"];
					}
					/* Check if Rating is Null */
					if ($rating == "--") {
						$error = "nullerror";
						completevote($error);
						$passtest = "no";
					}
					/* Check if Link POSTER is voting (UNLESS Anonymous users allowed to post) */
					if ($ratinguser != $anonymous && $ratinguser != "outside") {
						$result2 = $db->sql_query("SELECT submitter FROM ".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$ratinglid."'");
							while ($row2 = $db->sql_fetchrow($result2)) {
								$ratinguserDB = $row2['submitter'];
									if ($ratinguserDB==$ratinguser) {
										$error = "postervote";
										completevote($error);
										$passtest = "no";
									}
							}
						$db->sql_freeresult($result2);
					}
					/* Check if REG user is trying to vote twice. */
					if ($ratinguser != $anonymous && $ratinguser != "outside") {
						$result3 = $db->sql_query("SELECT ratinguser FROM ".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid='".$ratinglid."'");
							while ($row3 = $db->sql_fetchrow($result3)) {
								$ratinguserDB = $row3['ratinguser'];
								if ($ratinguserDB==$ratinguser) {
									$error = "regflood";
									completevote($error);
									$passtest = "no";
								}
							}
						$db->sql_freeresult($result3);
					}
					/* Check if ANONYMOUS user is trying to vote more than once per day. */
					if ($ratinguser == $anonymous){
						$yesterdaytimestamp = (time()-(86400 * $anonwaitdays));
						$ytsDB = Date("Y-m-d H:i:s", $yesterdaytimestamp);
						$result4 = $db->sql_query("SELECT COUNT(*) AS numrows FROM ".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid='".$ratinglid."' AND ratinguser='".$anonymous."' AND ratinghostname = '".$ip."' AND TO_DAYS(NOW()) - TO_DAYS(ratingtimestamp) < '".$anonwaitdays."'");
						$row4 = $db->sql_fetchrow($result4);
						$db->sql_freeresult($result4);
						$anonvotecount = $row4['numrows'];
							if ($anonvotecount >= 1) {
								$error = "anonflood";
								completevote($error);
								$passtest = "no";
							}
					}
					/* Check if OUTSIDE user is trying to vote more than once per day. */
					if ($ratinguser=="outside"){
						$yesterdaytimestamp = (time()-(86400 * $outsidewaitdays));
						$ytsDB = Date("Y-m-d H:i:s", $yesterdaytimestamp);
						$result5 = $db->sql_query("SELECT COUNT(*) AS numrows FROM ".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid='".$ratinglid."' AND ratinguser='outside' AND ratinghostname = '".$ip."' AND TO_DAYS(NOW()) - TO_DAYS(ratingtimestamp) < '".$outsidewaitdays."'");
						$row5 = $db->sql_fetchrow($result5);
						$db->sql_freeresult($result5);
						$outsidevotecount = $row5['numrows'];
							if ($outsidevotecount >= 1) {
								$error = "outsideflood";
								completevote($error);
								$passtest = "no";
							}
					}
					/* Passed Tests */
					if ($passtest == "yes") {
						$ratingcomments = stripslashes(check_html($ratingcomments, 'nohtml'));
							if ($comment != "") {
								update_points(16);
							}
						update_points(15);
						/* All is well.  Add to Line Item Rate to DB. */
						$ratinglid = intval($ratinglid);
						$rating = intval($rating);
							if ($rating > 10 || $rating < 1) {
								header("Location: modules.php?name=".$module_name."&l_op=ratelink&lid=".$ratinglid);
								die();
							}
						$db->sql_query("INSERT INTO ".UN_TABLENAME_LINKS_VOTEDATA." VALUES (NULL,'".$ratinglid."', '".$ratinguser."', '".$rating."', '".$ip."', '".addslashes($ratingcomments)."', now())");
						/* All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB. */
						/* NOTE: If weight is modified, ALL links need to be refreshed with new weight. */
						/* Running a SQL statement with your modded calc for ALL links will accomplish this. */
						$voteresult = $db->sql_query("SELECT rating, ratinguser, ratingcomments FROM ".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid = '".$ratinglid."'");
						$totalvotesDB = $db->sql_numrows($voteresult);
						include ("modules/".$module_name."/voteinclude.php");
						$db->sql_freeresult($voteresult);
						$lid = intval($lid);
						$db->sql_query("UPDATE ".UN_TABLENAME_LINKS_LINKS." SET linkratingsummary='".$finalrating."',totalvotes='".$totalvotesDB."',totalcomments='".$truecomments."' WHERE lid = '".$ratinglid."'");
						$error = "none";
						completevote($error);
					}
			/*}
		$db->sql_freeresult($result);*/
		completevotefooter($ratinglid, $ratinguser);
		include("footer.php");
        e107::getRender()->tablerender($caption, $text);
    } 
    public function viewlinkcomments($lid)
	{
        $text =  "viewlinkcomments in progress";
        e107::getRender()->tablerender($caption, $text);
    } 	
    public function outsidelinksetup($lid)
	{
 
		//include("modules/".$module_name."/l_config.php");
		$text = $this->menu(1);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
 
		$text .=  "<div class='center'><font class=\"option\"><b>"._PROMOTEYOURSITE."</b></font></div><br><br>	
		"._PROMOTE01."<br><br>	
		<b>1) "._TEXTLINK."</b><br><br>
		"._PROMOTE02."<br><br>
		<div class='center'><a href=\"".WEB_LINKS_INDEX."?l_op=ratelink&amp;lid=".$lid."\">"._RATETHISSITE." @ ".$sitename."</a></div><br><br>
		<div class='center'>"._HTMLCODE1."</div><br>
		<div class='center'><i>&lt;a href=\"".WEB_LINKS_INDEX."?l_op=ratelink&amp;lid=".$lid."\"&gt;"._RATETHISSITE."&lt;/a&gt;</i></div>
		<br><br>
		"._THENUMBER." \"$lid\" "._IDREFER."<br><br>
		
		<b>2) "._BUTTONLINK."</b><br><br>
		
		"._PROMOTE03."<br><br>
		<div class='center'>
		<form action=\"".WEB_LINKS_INDEX."\" method=\"post\">\n
			<input type=\"hidden\" name=\"lid\" value=\"".$lid."\">\n
			<input type=\"hidden\" name=\"l_op\" value=\"ratelink\">\n
			<input type=\"submit\" value=\""._RATEIT."\">\n
		</form>\n
		</div>
		<div class='center'>"._HTMLCODE2."</div><br><br>
		<table border=\"0\" align=\"center\"><tr><td align=\"left\"><i>
		&lt;form action=\"".WEB_LINKS_INDEX."\" method=\"post\"&gt;<br>\n
		&nbsp;&nbsp;&lt;input type=\"hidden\" name=\"lid\" value=\"".$lid."\"&gt;<br>\n
		&nbsp;&nbsp;&lt;input type=\"hidden\" name=\"l_op\" value=\"ratelink\"&gt;<br>\n
		&nbsp;&nbsp;&lt;input type=\"submit\" value=\""._RATEIT."\"&gt;<br>\n
		&lt;/form&gt;\n
		</i></td></tr></table>
		<br><br>
		<b>3) "._REMOTEFORM."</b><br><br>
		"._PROMOTE04."
		<div class='center'>
		<form method=\"post\" action=\"".WEB_LINKS_INDEX."\">
		<table align=\"center\" border=\"0\" width=\"175\" cellspacing=\"0\" cellpadding=\"0\">
		<tr><td align=\"center\"><b>"._VOTE4THISSITE."</b></a></td></tr>
		<tr><td>
		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
		<tr><td valign=\"top\">
			<select name=\"rating\">
			<option selected>--</option>
			<option>10</option>
			<option>9</option>
			<option>8</option>
			<option>7</option>
			<option>6</option>
			<option>5</option>
			<option>4</option>
			<option>3</option>
			<option>2</option>
			<option>1</option>
			</select>
		</td><td valign=\"top\">
			<input type=\"hidden\" name=\"ratinglid\" value=\"".$lid."\">
			<input type=\"hidden\" name=\"ratinguser\" value=\"outside\">
			<input type=\"hidden\" name=\"op value=\"addrating\">
			<input type=\"submit\" value=\""._LINKVOTE."\">
		</td></tr></table>
		</td></tr></table></form>
		<br>"._HTMLCODE3."<br><br></div>
		<blockquote><i>
		&lt;form method=\"post\" action=\"".WEB_LINKS_INDEX."\"&gt;<br>
			&lt;table align=\"center\" border=\"0\" width=\"175\" cellspacing=\"0\" cellpadding=\"0\"&gt;<br>
			&lt;tr&gt;&lt;td align=\"center\"&gt;&lt;b&gt;"._VOTE4THISSITE."&lt;/b&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;<br>
			&lt;tr&gt;&lt;td&gt;<br>
			&lt;table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"&gt;<br>
				&lt;tr&gt;&lt;td valign=\"top\"&gt;<br>
				&lt;select name=\"rating\"&gt;<br>
				&lt;option selected&gt;--&lt;/option&gt;<br>
				&lt;option&gt;10&lt;/option&gt;<br>
				&lt;option&gt;9&lt;/option&gt;<br>
				&lt;option&gt;8&lt;/option&gt;<br>
				&lt;option&gt;7&lt;/option&gt;<br>
				&lt;option&gt;6&lt;/option&gt;<br>
				&lt;option&gt;5&lt;/option&gt;<br>
				&lt;option&gt;4&lt;/option&gt;<br>
				&lt;option&gt;3&lt;/option&gt;<br>
				&lt;option&gt;2&lt;/option&gt;<br>
				&lt;option&gt;1&lt;/option&gt;<br>
				&lt;/select&gt;<br>
			&lt;/td&gt;&lt;td valign=\"top\"&gt;<br>
				&lt;input type=\"hidden\" name=\"ratinglid\" value=\"".$lid."\"&gt;<br>
				&lt;input type=\"hidden\" name=\"ratinguser\" value=\"outside\"&gt;<br>
				&lt;input type=\"hidden\" name=\"l_op\" value=\"addrating\"&gt;<br>
				&lt;input type=\"submit\" value=\""._LINKVOTE."\"&gt;<br>
			&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;<br>
			&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;<br>
		&lt;/form&gt;<br>
		</i></blockquote>
		<br><br><div class='center'>
		"._PROMOTE05."<br><br>
		- $sitename "._STAFF."
		<br><br></div>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
		 
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
		$text .= "<div class='center'><span class=\"title\"><b>"._LINKSMAINCAT."</b></span></div><br>";
		$text .= "<table border=\"0\" cellspacing=\"10\" cellpadding=\"0\" align=\"center\"><tr>";	

		$result = e107::getDB()->gen("SELECT cid, title, cdescription FROM #".UN_TABLENAME_LINKS_CATEGORIES."  WHERE parentid='0' ORDER BY title");
		$rowresult = e107::getDB()->rows();
		$count = 0;
		foreach ($rowresult as $row)  {
			$cid = $row['cid'];
			$title = e107::getParser()->toHTML($row['title'], "", "TITLE");
			$cdescription = e107::getParser()->toHTML($row['cdescription'], "", "DESCRIPTION");
			$text .= "<td><span class=\"option\"><span class='big'>&middot;</span> <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."\"><b>".$title."</b></a></span>";
			$text .= $this->categorynewlinkgraphic($cid);
			if ($cdescription) {
				$text .= "<br><span class=\"content\">".$cdescription."</span><br>";
			} else {
				$text .= "<br>";
			}
			$result2 = e107::getDB()->gen("SELECT cid, title FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE parentid='".$cid."' ORDER BY title");// limit 0,3");
			$rowresult2 = e107::getDB()->rows();
			$space = 0;   
			foreach ($rowresult2 as $row2)  { 
				$cid = $row2['cid'];
				$stitle = e107::getParser()->toHTML($row2['title'], "", "TITLE");
				if ($space>0) {
					$text .= ", ";
				}
				$text .= "<span class=\"content\"><a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."\">".$stitle."</a></span>";
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
		$text .= "<br><br><center><span class=\"content\">"._THEREARE." <b>".$numrows."</b> "._LINKS." "._AND." <b>".$catnum."</b> "._CATEGORIES." "._INDB."</span></center>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];		
		 
		$caption = ''; 
        e107::getRender()->tablerender($caption, $text, 'web_links_index');
    } 
} 