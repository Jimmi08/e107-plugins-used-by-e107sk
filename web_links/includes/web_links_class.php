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
				$text .= "<div class='center'><font class=\"option\"><b>"._MOSTPOPULAR." ".$toplinkspercent."% ("._OFALL." ".$totalmostpoplinks." "._LINKS.")</b></font></div>";
			} else {
				$text .= "<div class='center'><font class=\"option\"><b>"._MOSTPOPULAR." ".un_htmlentities($mostpoplinks)."</b></font></div>";
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
				$text .= "<font class=\"content\"><a href=\"".WEB_LINKS_FRONTFILE."?l_op=visit&amp;lid=".$lid."\" target=\"_blank\">".$title."</a>";
				$this->newlinkgraphic($time);
				$this->popgraphic($hits);
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
				$this->detecteditorial($lid);
				$text .= "<br>";
				$ctitle = $this->getparent($cid,$ctitle);
				$text .= _CATEGORY.": ".$ctitle;
				$text .= "<br><br>";
				$text .= "<br><br></font>";
			}
		 
		$text .= "</font></td></tr></table>";
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
		$title = "<a href=\"modules.php?name=".$module_name."\">"._MAIN."</a>/".$title;
		$text .= "<div class='center'><font class=\"option\"><b>"._CATEGORY.": ".$title."</b></font></div><br>";
		$text .= "<table border=\"0\" cellspacing=\"10\" cellpadding=\"0\" align=\"center\"><tr>";
		$cid = intval($cid);
		$result2 = e107::getDB()->gen("SELECT cid, title, cdescription FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE parentid='".$cid."' ORDER BY title");
		$count = 0;
		$rowresult2 = e107::getDB()->rows();  
		foreach ($rowresult2 as $row2)  {
				$cid2 = $row2['cid'];
				$title2 = e107::getParser()->toHTML($row2['title'], "", "TITLE");
				$cdescription2 = stripslashes($row2['cdescription']); 
				$text .= "<td><font class=\"option\"><span class='big'>&middot;</span> <a href=\"modules.php?name=Web_Links&amp;l_op=viewlink&amp;cid=".$cid2."\"><b>".$title2."</b></a></font>";
				$this->categorynewlinkgraphic($cid2);
				if ($cdescription2) {
					$text .= " <font class=\"content\">".$cdescription2."</font><br>";
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
						$text .= "<font class=\"content\"><a href=\"modules.php?name=$module_name&amp;l_op=viewlink&amp;cid=".$cid3."\">".$title3."</a></font>";
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
		$text .= "<div class='center'><font class=\"content\">"._SORTLINKSBY.": "
		._TITLE." (<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;orderby=titleA\">A</a>\<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;orderby=titleD\">D</a>) "
		._DATE." (<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;orderby=dateA\">A</a>\<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;orderby=dateD\">D</a>) "
		._RATING." (<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;orderby=ratingA\">A</a>\<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;orderby=ratingD\">D</a>) "
		._POPULARITY." (<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;orderby=hitsA\">A</a>\<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;orderby=hitsD\">D</a>)"
		."<br><b>"._SITESSORTED.": ".$orderbyTrans."</b></font></div><br><br>";
			if(!is_numeric($min)){
				$min=0;
			}
		$result4 = e107::getDB()->gen("SELECT lid, title, description, date, hits, linkratingsummary, totalvotes, totalcomments FROM #".UN_TABLENAME_LINKS_LINKS." WHERE cid='".$cid."' ORDER BY ".$orderby." LIMIT ".$min.",".$perpage);
		$rowresult4 = e107::getDB()->rows(); 
		$fullcountresult = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE cid='".$cid."'");
		$fullcountrow = e107::getDB()->fetch($fullcountresult);
		 
		$totalselectedlinks = $fullcountrow['numrows'];	
		$text .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\"><tr><td><font class=\"content\">";
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
					$text .= "<a href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\"><img src=\"modules/".$module_name."/images/lwin.gif\" border=\"0\" alt=\""._EDIT."\"></a>&nbsp;&nbsp;";
				} else {
					$text .= "<img src=\"modules/".$module_name."/images/lwin.gif\" border=\"0\" alt=\"\">&nbsp;&nbsp;";
				}
				$text .= "<a href=\"modules.php?name=".$module_name."&amp;l_op=visit&amp;lid=".$lid."\" target=\"_blank\"><b>".$title."</b></a>";
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
				$text .= "<a href=\"modules.php?name=".$module_name."&amp;l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
					//if (is_user($user)) {
					if (USER) {
						$text .= " | <a href=\"modules.php?name=".$module_name."&amp;l_op=brokenlink&amp;lid=".$lid."\">"._REPORTBROKEN."</a>";
					}
					if ($totalvotes != 0) {
						$text .= " | <a href=\"modules.php?name=".$module_name."&amp;l_op=viewlinkdetails&amp;lid=".$lid."\">"._DETAILS."</a>";
					}
					if ($totalcomments != 0) {
						$text .= " | <a href=\"modules.php?name=".$module_name."&amp;l_op=viewlinkcomments&amp;lid=".$lid."\">"._SCOMMENTS." (".$totalcomments.")</a>";
					}
				$this->detecteditorial($lid);
				$text .= "<br><br>";
				$x++;
			}
		 
		$text .= "</font>";
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
						$leftarrow = "images/left.gif" ;
						$text .= "<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;min=".$prev."&amp;orderby=".$orderby."&amp;show=".$show."\">";
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
								$text .= "<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;min=".$mintemp."&amp;orderby=".$orderby."&amp;show=".$show."\">".$counter."</a> ";
							}
						$counter++;
					}
				$text .= " ]";
				$next=$min+$perpage;
					if ($x>=$perpage) {
						$rightarrow = WEB_LINKS_APP_ABS."images/right.gif";					  
						 
						$text .= "<a href=\"modules.php?name=".$module_name."&amp;l_op=viewlink&amp;cid=".$cid."&amp;min=".$max."&amp;orderby=".$orderby."&amp;show=".$show."\">";
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
			$title = e107::getParser()->toHTML($row['title'], "", "TITLE");
			$cdescription = e107::getParser()->toHTML($row['cdescription'], "", "DESCRIPTION");
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
				$stitle = e107::getParser()->toHTML($row2['title'], "", "TITLE");
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