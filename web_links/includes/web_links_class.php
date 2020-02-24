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
 
		$links_anonaddlinklock = $this->plugPrefs['links_anonaddlinklock'];
		$user_addlink = $this->plugPrefs['user_addlink'];
		$mainlink = 1;
		$text =$this->menu(1);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$text .= "<div class='center'><span class=\"title\"><b>"._ADDALINK."</b></span></div><br><br>";
		if ((USER && $user_addlink == 1) || $links_anonaddlinklock != 1) {
			$text .= "<b>"._INSTRUCTIONS.":</b><br>"
			."<span class='big'>&middot;</span> "._SUBMITONCE."<br>"
			."<span class='big'>&middot;</span> "._POSTPENDING."<br>"
			."<span class='big'>&middot;</span> "._USERANDIP."<br>"
			."<form method=\"post\" action=\"".WEB_LINKS_FRONTFILE."?l_op=Add\">"
			._PAGETITLE.": <input type=\"text\" name=\"title\" size=\"50\" maxlength=\"100\"><br>"
			._PAGEURL.": <input type=\"text\" name=\"url\" size=\"50\" maxlength=\"100\" value=\"http://\"><br>";
			$text .= _CATEGORY.": <select name=\"cat\">";
			$result = e107::getDB()->gen("SELECT cid, title, parentid FROM #".UN_TABLENAME_LINKS_CATEGORIES." ORDER BY parentid,title");
				while ($row = e107::getDB()->fetch($result)) {
					$cid2 = $row['cid'];
					$ctitle2 = stripslashes(check_html($row['title'], "nohtml"));
					$parentid2 = $row['parentid'];
					if ($parentid2 != 0) $ctitle2 = $this->getparent($parentid2,$ctitle2);
					$text .= "<option value=\"".$cid2."\">".$ctitle2."</option>";
				}

			$text .= "</select><br><br>"
			._LDESCRIPTION."<br><textarea name=\"description\" id=\"weblinks_submit\" cols=\"70\" rows=\"15\"></textarea><br><br><br>"
			._YOURNAME.": <input type=\"text\" name=\"auth_name\" size=\"30\" maxlength=\"60\"><br>"
			._YOUREMAIL.": <input type=\"text\" name=\"email\" size=\"30\" maxlength=\"60\"><br><br>"
			."<input type=\"hidden\" name=\"l_op\" value=\"Add\">"
			."<input type=\"submit\" class='button btn' value=\""._ADDURL."\"> "._GOBACK."<br><br>"
			."</form>";
		}else {
			$text .= "<div class='center'>"._LINKSNOTUSER1."<br>"
			._LINKSNOTUSER2."<br><br>"
			._LINKSNOTUSER3."<br>"
			._LINKSNOTUSER4."<br>"
			._LINKSNOTUSER5."<br>"
			._LINKSNOTUSER6."<br>"
			._LINKSNOTUSER7."<br><br>"
			._LINKSNOTUSER8."</div>";
		}
		$text .= $this->plugTemplates['CLOSE_TABLE'];
 
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
		global    $user, $mainvotedecimal;
		 
		$aid = USERID;
		//$result = e107::getDB()->gen("SELECT radminsuper FROM #".UN_TABLENAME_AUTHORS." WHERE aid='".$aid."'");
		//$row = e107::getDB()->fetch($result);
 
		$dateDB = (date("d-M-Y", $selectdate));
		$dateView = (date("F d, Y", $selectdate));
		
		$text =$this->menu(1);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$newlinkDB = Date("Y-m-d", $selectdate);
		$totalresult = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE date LIKE '%".$newlinkDB."%'");
		$totalrow = e107::getDB()->fetch($totalresult);
 
		$totallinks = $totalrow['numrows'];
		$text .= "<span class=\"option\"><b>".un_convert_time_by_locale($dateView, "downloads")." - ".$totallinks." "._NEWLINKS2."</b></span>"
		."<table width=\"100%\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\"><tr><td><span class=\"content\">";
		$result2 = e107::getDB()->gen("SELECT ll.lid, ll.cid, ll.sid, ll.title, ll.description, ll.date, ll.hits, ll.linkratingsummary, ll.totalvotes, ll.totalcomments, lc.title AS cat_title FROM #".UN_TABLENAME_LINKS_LINKS." ll, #".UN_TABLENAME_LINKS_CATEGORIES." lc WHERE lc.cid = ll.cid AND ll.date LIKE '%".$newlinkDB."%' ORDER BY ll.title ASC");
			while ($row2 = e107::getDB()->fetch($result2)) {
				$lid = $row2['lid'];
				$cid = $row2['cid'];
				$sid = $row2['sid'];
				$title = stripslashes(check_html($row2['title'], "nohtml"));
				$description = stripslashes($row2['description']);
				$time = $row2['date'];
				$hits = $row2['hits'];
				$linkratingsummary = $row2['linkratingsummary'];
				$totalvotes = $row2['totalvotes'];
				$totalcomments = $row2['totalcomments'];
				$linkratingsummary = number_format($linkratingsummary, $mainvotedecimal);
				$ctitle = stripslashes(check_html($row2['cat_title'], "nohtml"));
				if (ADMIN) {
					$text .= "<a target='_blank' href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\"><img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"".LAN_EDIT."\"></a>&nbsp;&nbsp;";
				} else {
					$text .= "<img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"\">&nbsp;&nbsp;";
				}
				$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=visit&amp;lid=".$lid."\" target=\"_blank\">".$title."</a>";
				newlinkgraphic($time);
				popgraphic($hits);
				$text .= "<br>"._DESCRIPTION.": ".$description."<br>";
				setlocale (LC_TIME, $locale);
				/* INSERT code for *editor review* here */
				//eregx ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
				preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#i", $time, $datetime);
				$datetime = strftime(_LINKSDATESTRING, mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
				setlocale(LC_TIME, 'en_US');
				$datetime = ucfirst($datetime);
				$text .= _ADDEDON.": <b>".$datetime."</b> "._HITS.": ".$hits;
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
					if (getperms('0')) {  //e107 superadmin
						$text .= "<a target='_blank' href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">".LAN_EDIT."</a> | ";
					}
				$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
					if (USER) {
						$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=brokenlink&amp;lid=".$lid."\">"._REPORTBROKEN."-1</a>";
					}
					if ($totalvotes != 0) {
						$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkdetails&amp;lid=".$lid."\">"._DETAILS."</a>";
					}
					if ($totalcomments != 0) {
						$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkcomments&amp;lid=".$lid."\">"._SCOMMENTS.": (".$totalcomments.")</a>";
					}
				detecteditorial($lid);
				$text .= "<br>";
				$ctitle = $this->getparent($cid,$ctitle);
				$text .= _CATEGORY.": ".$ctitle;
				$text .= "<br><br>";
			}
 
		$text .= "</span></td></tr></table>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
 
        e107::getRender()->tablerender($caption, $text);
    } 
    public function TopRated($ratenum, $ratetype) 
	{
		global  $user,  $mainvotedecimal ;
		 
		$toplinkspercentrigger = $this->plugPrefs['toplinkspercentrigger'];
		$toplinks = $this->plugPrefs['toplinks'];
		$linkvotemin = $this->plugPrefs['linkvotemin'];

		$text = $this->menu(1);
		$text .=  "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$text .=  "<table border=\"0\" width=\"100%\"><tr><td align=\"center\">";
			if ($ratenum != "" && $ratetype != "") {
				$toplinks = $ratenum;
				if ($ratetype == "percent") {
				$toplinkspercentrigger = 1;
				}
			}
			if ($toplinkspercentrigger == 1) {
				$toplinkspercent = $toplinks;
				$totalresult = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE linkratingsummary <> '0'");
				$totalrow = e107::getDB()->fetch($totalresult);
				 
				$totalratedlinks = $totalrow['numrows'];
				$toplinks = $toplinks / 100;
				$toplinks = $totalratedlinks * $toplinks;
				$toplinks = round($toplinks);
			}
			if ($toplinkspercentrigger == 1) {
				$text .=  "<div class='center'><span class=\"option\"><b>"._BESTRATED." ".$toplinkspercent."% ("._OF." ".$totalratedlinks." "._TRATEDLINKS.")</b></span></div><br>";
			} else {
				$text .=  "<div class='center'><span class=\"option\"><b>"._BESTRATED." ".un_htmlentities($toplinks)." </b></span></div><br>";
			}
		$text .=  "</td></tr>"
		."<tr><td><div class='center'>"._NOTE." ".$linkvotemin." "._TVOTESREQ."<br>"
		._SHOWTOP.":  [ <a href=\"".WEB_LINKS_INDEX."?l_op=TopRated&amp;ratenum=10&amp;ratetype=num\">10</a> - "
		."<a href=\"".WEB_LINKS_INDEX."?l_op=TopRated&amp;ratenum=25&amp;ratetype=num\">25</a> - "
		."<a href=\"".WEB_LINKS_INDEX."?l_op=TopRated&amp;ratenum=50&amp;ratetype=num\">50</a> | "
		."<a href=\"".WEB_LINKS_INDEX."?&amp;l_op=TopRated&amp;ratenum=1&amp;ratetype=percent\">1%</a> - "
		."<a href=\"".WEB_LINKS_INDEX."?&amp;l_op=TopRated&amp;ratenum=5&amp;ratetype=percent\">5%</a> - "
		."<a href=\"".WEB_LINKS_INDEX."?&amp;l_op=TopRated&amp;ratenum=10&amp;ratetype=percent\">10%</a> ]</div><br><br></td></tr>";
		$result = e107::getDB()->gen("SELECT ll.lid, ll.cid, ll.sid, ll.title, ll.description, ll.date, ll.hits, ll.linkratingsummary, ll.totalvotes, ll.totalcomments, lc.title AS cat_title FROM #".UN_TABLENAME_LINKS_LINKS." ll, #".UN_TABLENAME_LINKS_CATEGORIES." lc WHERE lc.cid = ll.cid AND ll.linkratingsummary <> 0 AND ll.totalvotes >= ".$linkvotemin." ORDER BY ll.linkratingsummary DESC LIMIT 0,".$toplinks);
		$text .=  "<tr><td>";
			while ($row = e107::getDB()->fetch($result)) {
				$lid = $row['lid'];
				$cid = $row['cid'];
				$sid = $row['sid'];
				$title =  e107::getParser()->toHTML($row['title'], "", "TITLE");
				$description = stripslashes($row['description']);
				$time = $row['date'];
				$hits = $row['hits'];
				$linkratingsummary = $row['linkratingsummary'];
				$totalvotes = $row['totalvotes'];
				$totalcomments = $row['totalcomments'];
				$linkratingsummary = number_format($linkratingsummary, $mainvotedecimal);
				$ctitle = e107::getParser()->toHTML($row['cat_title'], "", "TITLE");
				if (ADMIN) {
					$text .=  "<a target='_blank' href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\"><img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"".LAN_EDIT."\"></a>&nbsp;&nbsp;";
				} else {
					$text .=  "<img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"\">&nbsp;&nbsp;";
				}
				$text .=  "<a href=\"".WEB_LINKS_INDEX."?l_op=visit&amp;lid=".$lid."\" target=\"_blank\">".$title."</a>";
				$text .= $this->newlinkgraphic($time);
				$text .= $this->popgraphic($hits);
				$text .=  "<br>";
				$text .=  _DESCRIPTION.": ".$description."<br>";
				setlocale (LC_TIME, $locale);
				//eregx ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
				preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#i", $time, $datetime);			
				$datetime = strftime(_LINKSDATESTRING, mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
				setlocale(LC_TIME, 'en_US');
				$datetime = ucfirst($datetime);
				$text .=  _ADDEDON.": ".$datetime." "._HITS.": ".$hits;
					/* voting & comments stats */
					if ($totalvotes == 1) {
						$votestring = _VOTE;
					} else {
						$votestring = _VOTES;
					}
					if ($linkratingsummary != "0" || $linkratingsummary != "0.0") {
						$text .=  " "._RATING.": <b> ".$linkratingsummary." </b> ("._VOTES.": ".$totalvotes.")";
					}
				$text .=  "<br><a href=\"".WEB_LINKS_FRONTFILE."?l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
					if (USER) {
						$text .=  " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=brokenlink&amp;lid=".$lid."\">"._REPORTBROKEN."-2</a>";
					}
					if ($totalvotes != 0) {
						$text .=  " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkdetails&amp;lid=".$lid."\">"._DETAILS."</a>";
					}
					if ($totalcomments != 0) {
						$text .=  " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkcomments&amp;lid=".$lid."\">"._SCOMMENTS." (".$totalcomments.")</a>";
					}
				$text = $this->detecteditorial($lid);
				$text .=  "<br>";
				$ctitle = $this->getparent($cid,$ctitle);
				$text .=  _CATEGORY.": ".$ctitle;
				$text .=  "<br><br>";
				$text .=  "<br><br>";
			}
		 
		$text .=  "</td></tr></table>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
		 
        e107::getRender()->tablerender($caption, $text);
    } 
    public function MostPopular($ratenum, $ratetype) 
	{
		$mainvotedecimal = $this->plugPrefs['mainvotedecimal'];
		$mostpoplinkspercentrigger = $this->plugPrefs['mostpoplinkspercentrigger'];
		$mostpoplinks = $this->plugPrefs['mostpoplinks'];
 
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
 
				if(ADMIN) {
					$text .= "<a target='_blank' href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">
					<img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"".LAN_EDIT."\"></a>&nbsp;&nbsp;";
				} else {
					$text .= "<img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"\">&nbsp;&nbsp;";
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
				if (ADMIN) {
					$text .= "<a target='_blank' href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">".LAN_EDIT."</a> | ";
				}
				$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
				//if (isx_user($user)) {
				if(USER) {	
					$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=brokenlink&amp;lid=".$lid."\">"._REPORTBROKEN."-3</a>";
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
		._TITLE." (<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=titleA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=titleD\">D</a>) "
		._DATE." (<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=dateA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=dateD\">D</a>) "
		._RATING." (<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=ratingA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=ratingD\">D</a>) "
		._POPULARITY." (<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=hitsA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."&amp;orderby=hitsD\">D</a>)"
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
 
				if (ADMIN) {
					$text .= "<a  target='_blank' href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\"><img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"". LAN_EDIT."\"></a>&nbsp;&nbsp;";
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
					if (getperms('0')) {
						$text .= "<a target='_blank' href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">".LAN_EDIT."</a> | ";
					}
				    $text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
					//if (isx_user($user)) {
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
		global  $user, $cookie ;
		if (USER) {
			$ratinguser = USERNAME;
			$text =$this->menu(1);
			$lid = intval($lid);
			$text .= "<br>";
			$result = e107::getDB()->gen("SELECT cid, title, url, description FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
			$row = e107::getDB()->fetch($result);

			$cid = $row['cid'];
			$title = stripslashes(check_html($row['title'], "nohtml"));
			$url = stripslashes($row['url']);
			$description = stripslashes($row['description']);
			$text .= $this->plugTemplates['OPEN_TABLE'];
			$text .= "<div class='center'><span class=\"option\"><b>"._REPORTBROKEN."</b></span><br><br><br><span class=\"content\">";
			$text .= "<form action=\"".WEB_LINKS_FRONTFILE."\" method=\"post\">";
			$text .= "<input type=\"hidden\" name=\"lid\" value=\"".$lid."\">";
			$text .= "<input type=\"hidden\" name=\"cid\" value=\"".$cid."\">";
			$text .= "<input type=\"hidden\" name=\"title\" value=\"".$title."\">";
			$text .= "<input type=\"hidden\" name=\"url\" value=\"".$url."\">";
			$text .= "<input type=\"hidden\" name=\"description\" value=\"".$description."\">";
			$text .= "<input type=\"hidden\" name=\"modifysubmitter\" value=\"".$ratinguser."\">";
			$text .= ""._THANKSBROKEN."<br><br>";
			$text .= "<input type=\"hidden\" name=\"l_op\" value=\"brokenlinkS\"><input type=\"submit\" class='button btn' value=\""._REPORTBROKEN."\"></div></form>";
			$text .= $this->plugTemplates['CLOSE_TABLE'];
	 
		} else {
			Header("Location: ".WEB_LINKS_FRONTFILE);
		}
        e107::getRender()->tablerender($caption, $text);
	}  	
	
    public function modifylinkrequest($lid)
	{
		global  $user,   $anonymous;

		$blockunregmodify = $this->plugPrefs['blockunregmodify'];
			if(USER) {
				$ratinguser = USERNAME;
			} else {
				$ratinguser = $anonymous;
			}
		$text =$this->menu(1);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$blocknow = 0;
		$lid = intval($lid);
			if ($blockunregmodify == 1 && $ratinguser== $anonymous) {
				$text .= "<br><br><div class='center'>"._ONLYREGUSERSMODIFY."</div>";
				$blocknow = 1;
			}
			if ($blocknow != 1) {
				$result = e107::getDB()->gen("SELECT cid, sid, title, url, description FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
				$text .= "<div class='center'><span class=\"option\"><b>"._REQUESTLINKMOD."</b></span><br><span class=\"content\">";
				while($row = e107::getDB()->fetch($result)) {
					$cid = $row['cid'];
					$sid = $row['sid'];
					$title = stripslashes(check_html($row['title'], "nohtml"));
					$url = stripslashes($row['url']);
					$description = stripslashes($row['description']);
					$text .= "<form action=\"".WEB_LINKS_FRONTFILE."\" method=\"post\">"
					._LINKID.": <b>".$lid."</b></div><br><br><br>"
					._LINKTITLE.":<br><input type=\"text\" class='form-control tbox' name=\"title\" value=\"".$title."\" size=\"50\" maxlength=\"100\"><br><br>"
					._URL.":<br><input type=\"text\" class='form-control tbox' name=\"url\" value=\"".$url."\" size=\"50\" maxlength=\"100\"><br><br>"
					._DESCRIPTION.": <br><textarea name=\"description\" class='form-control tbox' id=\"weblinks_modrequest\" cols=\"70\" rows=\"15\">".un_htmlentities($description, ENT_QUOTES)."</textarea><br><br>";
					$text .= "<input type=\"hidden\" name=\"lid\" value=\"".$lid."\">"
					."<input type=\"hidden\" name=\"modifysubmitter\" value=\"".$ratinguser."\">"
					._CATEGORY.": <select name=\"cat\" class='form-control tbox' >";
					$result2 = e107::getDB()->gen("SELECT cid, title, parentid FROM #".UN_TABLENAME_LINKS_CATEGORIES." ORDER BY title");
						while($row2 = e107::getDB()->fetch($result2)) {   
							$cid2 = $row2['cid'];
							$ctitle2 = stripslashes(check_html($row2['title'], "nohtml"));   
							$parentid2 = $row2['parentid'];
							if ($cid2==$cid) {
								$sel = "selected";
							} else {
								$sel = "";
							}
							if ($parentid2 > 0) $ctitle2 = $this->getparent($parentid2,$ctitle2);
							$text .= "<option value=\"".$cid2."\" ".$sel.">".$ctitle2."</option>";
						}
 
					$text .= "</select><br><br>"
					."<input type=\"hidden\" name=\"l_op\" value=\"modifylinkrequestS\">"
					."<input type=\"submit\" class='button btn' value=\""._SENDREQUEST."\"></form>";
				}
	
			}
		$text .= $this->plugTemplates['CLOSE_TABLE'];
 
        e107::getRender()->tablerender($caption, $text);
    }   	
    public function modifylinkrequestS($lid, $cat, $title, $url, $description, $modifysubmitter)
	{
		global   $user,  $anonymous, $blockunregmodify;
 
			if(USER) {
				$ratinguser = USERNAME;
			} else {
				$ratinguser = $anonymous;
			}
		$blocknow = 0;
			if ($blockunregmodify == 1 && $ratinguser == $anonymous) {
				
		$text =$this->menu(1);
				$text .= "<br>";
				$text .= $this->plugTemplates['OPEN_TABLE'];
				$text .= "<div class='center'><span class=\"content\">"._ONLYREGUSERSMODIFY."</span></div>";
				$blocknow = 1;
				$text .= $this->plugTemplates['CLOSE_TABLE'];
		 
			}
			if ($blocknow != 1) {
				$cat = explode("-", $cat);
					if ($cat[1]=="") {
						$cat[1] = 0;
					}
				$title = stripslashes(check_html($title, "nohtml"));
				$url = stripslashes($url);
				$description = stripslashes($description);
				$lid = intval($lid);
				$cat[0] = intval($cat[0]);
				$cat[1] = intval($cat[1]);
				e107::getDB()->gen("INSERT INTO #".UN_TABLENAME_LINKS_MODREQUEST." VALUES (NULL, '".$lid."', '".$cat[0]."', '".$cat[1]."', '".addslashes($title)."', '".addslashes($url)."', '".addslashes($description)."', '".addslashes($ratinguser)."', 0)");
				
		$text =$this->menu(1);
				$text .= "<br>";
				$text .= $this->plugTemplates['OPEN_TABLE'];
				$text .= "<div class='center'><span class=\"content\">"._THANKSFORINFO." "._LOOKTOREQUEST."</span></div>";
				$text .= $this->plugTemplates['CLOSE_TABLE'];
		 
			}
        e107::getRender()->tablerender($caption, $text);
    }    
    public function brokenlinkS($lid,$cid, $title, $url, $description, $modifysubmitter)
	{
		global   $user, $cookie,  $user;
		if (USERNAME) {
			$ratinguser = USERNAME;
			$lid = intval($lid);
			$cid = intval($cid);
			e107::getDB()->gen("INSERT INTO #".UN_TABLENAME_LINKS_MODREQUEST." VALUES (NULL, '".$lid."', '".$cid."', '0', '".addslashes($title)."', '".addslashes($url)."', '".addslashes($description)."', '".$ratinguser."', '1')");
			
	$text =$this->menu(1);
			$text .= "<br>";
			$text .= $this->plugTemplates['OPEN_TABLE'];
			$text .= "<br><div class='center'>"._THANKSFORINFO."<br><br>"._LOOKTOREQUEST."</div><br>";
			$text .= $this->plugTemplates['CLOSE_TABLE'];
	 
		} else {
			Header("Location: ".WEB_LINKS_INDEX);
		}
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
		 
		$user_addlink = $this->plugPrefs['user_addlink'];
		$links_anonaddlinklock = e107::getPlugConfig('web_links')->getPref('links_anonaddlinklock');

		$result = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE url='".addslashes($url)."'");
		$row = e107::getDB()->fetch($result);

		$numrows = $row['numrows'];
			if ($numrows>0) {
				
		$text =$this->menu(1);
				$text .= "<br>";
				$text .= $this->plugTemplates['OPEN_TABLE'];
				$text .= "<div class='center'><b>"._LINKALREADYEXT."</b><br><br>"
				._GOBACK;
				$text .= $this->plugTemplates['CLOSE_TABLE'];
		 
			} else {
				if(USER) {
					$submitter = USERNAME;
				}
				// Check if Title exist
				if ($title=="") {
					
			$text =$this->menu(1);
					$text .= "<br>";
					$text .= $this->plugTemplates['OPEN_TABLE'];
					$text .= "<div class='center'><b>"._LINKNOTITLE."</b><br><br>"
					._GOBACK;
					$text .= $this->plugTemplates['CLOSE_TABLE'];
			 
				}
				// Check if URL exist
				if ($url=="") {
					
			$text =$this->menu(1);
					$text .= "<br>";
					$text .= $this->plugTemplates['OPEN_TABLE'];
					$text .= "<div class='center'><b>"._LINKNOURL."</b><br><br>"
					._GOBACK;
					$text .= $this->plugTemplates['CLOSE_TABLE'];
			 
				}
				// Check if Description exist
				if ($description=="") {
					
			$text =$this->menu(1);
					$text .= "<br>";
					$text .= $this->plugTemplates['OPEN_TABLE'];
					$text .= "<div class='center'><b>"._LINKNODESC."</b><br><br>"
					._GOBACK;
					$text .= $this->plugTemplates['CLOSE_TABLE'];
			 
				}
				$cat = explode("-", $cat);
					if ($cat[1]=="") {
						$cat[1] = 0;
					}
				$title = e107::getParser()->toDb($title);
				$url = e107::getParser()->toDb($url);
				$description = e107::getParser()->toDb($description);
				$auth_name = e107::getParser()->toDb($auth_name);
				$email = e107::getParser()->toDb($email);
				$cat[0] = intval($cat[0]);
				$cat[1] = intval($cat[1]);
				$num_result = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_NEWLINK." WHERE title='".addslashes($title)."' OR url='".addslashes($url)."' OR description='".addslashes($description)."'");
				$num_row = e107::getDB()->fetch($num_result);
 
				$num_new = $num_row['numrows'];
					if ($num_new == 0) {
						if((USER && $user_addlink == 1) || $links_anonaddlinklock != 1) {
							e107::getDB()->gen("INSERT INTO #".UN_TABLENAME_LINKS_NEWLINK." VALUES (NULL, '".$cat[0]."', '".$cat[1]."', '".addslashes($title)."', '".addslashes($url)."', '".addslashes($description)."', '".addslashes($auth_name)."', '".addslashes($email)."', '".addslashes($submitter)."')");
						}
					}
				
		$text =$this->menu(1);
				$text .= "<br>";
				$text .= $this->plugTemplates['OPEN_TABLE'];
				$text .= "<div class='text-center'><b>"._LINKRECEIVED."</b><br>";
				if ($email != "") {
					$text .= _EMAILWHENADD;
				} else {
					$text .= _CHECKFORIT;
				}
				$text .= "</div>".$this->plugTemplates['CLOSE_TABLE'];
		 
			}
        e107::getRender()->tablerender($caption, $text);
    }	
    public function search($unquery, $min, $orderby, $show)
	{
		global  $bgcolor2 ;

		$linksresults 		= $this->plugPrefs['linksresults'];
		$mainvotedecimal 	= $this->plugPrefs['mainvotedecimal'];
 
		$perpage = $this->plugPrefs['perpage']; 
		if (!isset($min)) $min = 0;
		if (!isset($max)) $max = $min+$linksresults;
			if(isset($orderby)) {
				$orderby = $this->convertorderbyin($orderby);
			} else {
				$orderby = "title ASC";
			}
			if ($show != "") {
				$linksresults = $show;
			} else {
				$show = $linksresults;
			}
		$unquery = check_html($unquery, "nohtml");
		$unquery = addslashes($unquery);
			if(!is_numeric($linksresults) AND $linksresults==0) {
				$linksresults=10;
			}
		$result = e107::getDB()->retrieve("SELECT lid, cid, sid, title, url, description, date, hits, linkratingsummary, totalvotes, totalcomments FROM #".UN_TABLENAME_LINKS_LINKS." WHERE title LIKE '%".$unquery."%' OR description LIKE '%".$unquery."%' ORDER BY ".$orderby." LIMIT ".intval($min).",".$linksresults, true);
 
		$fullcountresult = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE title LIKE '%".$unquery."%' OR description LIKE '%".$unquery."%'");
		$fullcountrow = e107::getDB()->fetch($fullcountresult);
 
		$totalselectedlinks = $fullcountrow['numrows'];
		$nrows =  count($result) ;        
		$x=0;
		$the_query = stripslashes($unquery);
		$the_query = str_replace("\'", "'", $the_query);
        $text =$this->menu(1);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		if ($unquery != "") {
			if ($nrows>0) {
				$text .= "<span class=\"option\">"._SEARCHRESULTS4.": <b>".$the_query."</b></span><br><br>"
				."<table width=\"100%\" bgcolor=\"".$bgcolor2."\"><tr><td><span class=\"option\"><b>"._USUBCATEGORIES."</b></span></td></tr></table>";
				$result2 = e107::getDB()->gen("SELECT cid, title FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE title LIKE '%".$unquery."%' ORDER BY title DESC", true);
					foreach($result2 AS $row2) {
						$cid = $row2['cid'];
						$stitle = stripslashes(check_html($row2['title'], "nohtml"));
						$res = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_LINKS." WHERE cid='".$cid."'");
						$resrow = e107::getDB()->fetch($res);
				
						$numrows = $resrow['numrows'];
						$result3 = e107::getDB()->gen("SELECT cid,title,parentid FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE cid='".$cid."'");
						$row3 = e107::getDB()->fetch($result3);
 
						$cid3 = $row3['cid'];
						$title3 = stripslashes(check_html($row3['title'], "nohtml"));
						$parentid3 = $row3['parentid'];
						if ($parentid3>0) $title3 = $this->getparent($parentid3,$title3);
						$title3 = str_replace($unquery, "<b>".$unquery."</b>", $title3);
						$text .= "<span class='big'>&middot;</span>&nbsp;<a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlink&amp;cid=".$cid."\">".$title3."</a> (".$numrows.")<br>";
					}
 
				$text .= "<br><table width=\"100%\" bgcolor=\"".$bgcolor2."\"><tr><td><span class=\"option\"><b>"._LINKS."</b></span></td></tr></table>";
				$orderbyTrans = $this->convertorderbytrans($orderby);
				$text .= "<br><span class=\"content\">"._SORTLINKSBY.": "
				._TITLE." (<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;orderby=titleA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;orderby=titleD\">D</a>)"
				._DATE." (<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;orderby=dateA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;orderby=dateD\">D</a>)"
				._RATING." (<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;orderby=ratingA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;orderby=ratingD\">D</a>)"
				._POPULARITY." (<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;orderby=hitsA\">A</a>\<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;orderby=hitsD\">D</a>)"
				."<br>"._SITESSORTED.": ".$orderbyTrans."<br><br>";
                    foreach($result AS $row) {
						$lid = $row['lid'];
						$cid = $row['cid'];
						$sid = $row['sid'];
						$title = stripslashes(check_html($row['title'], "nohtml"));
						$url = stripslashes($row['url']);
						$description = stripslashes($row['description']);
						$time = $row['date'];
						$hits = $row['hits'];
						$linkratingsummary = $row['linkratingsummary'];
						$totalvotes = $row['totalvotes'];
						$totalcomments = $row['totalcomments'];
						$linkratingsummary = number_format($linkratingsummary, $mainvotedecimal);
						$title = str_replace($unquery, "<b>".$unquery."</b>", $title);
						if (ADMIN) {
							$text .= "<a target='_blank' href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\"><img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"".LAN_EDIT."\"></a>&nbsp;&nbsp;";
						} else {
							$text .= "<img src=\"".WEB_LINKS_APP_ABS."/images/lwin.gif\" border=\"0\" alt=\"\">&nbsp;&nbsp;";
						}
						$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=visit&amp;lid=".$lid."\" target=\"_blank\">".$title."</a>";
						$this->newlinkgraphic($time);
						$this->popgraphic($hits);
						$text .= "<br>";
						$description = str_replace($unquery, "<b>".$unquery."</b>", $description);
						$text .= _DESCRIPTION.": ".$description."<br>";
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
						$text .= "<br><a href=\"".WEB_LINKS_FRONTFILE."?l_op=ratelink&amp;lid=".$lid."\">"._RATESITE."</a>";
							if ($totalvotes != 0) {
								$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkdetails&amp;lid=".$lid."\">"._DETAILS."</a>";
							}
							if ($totalcomments != 0) {
								$text .= " | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=viewlinkcomments&amp;lid=".$lid."\">"._SCOMMENTS." (".$totalcomments.")</a>";
							}
						$this->detecteditorial($lid);
						$text .= "<br>";
						$result4 = e107::getDB()->gen("SELECT cid, title, parentid FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE cid='".$cid."'");
						$row4 = e107::getDB()->fetch($result4);
						$cid3 = $row4['cid'];
						$title3 = stripslashes(check_html($row4['title'], "nohtml"));
						$parentid3 = $row4['parentid'];
							if ($parentid3>0) $title3 = $this->getparent($parentid3,$title3);
								$text .= _CATEGORY.": ".$title3."<br><br>";
								$x++;
					}
				$text .= "</span>";
				$orderby = $this->convertorderbyout($orderby);
			} else {
				$text .= "<br><br><div class='center'><span class=\"option\"><b>"._NOMATCHES."</b></span><br><br>"._GOBACK."<br></div>";
			}

		/* Calculates how many pages exist.  Which page one should be on, etc... */
		$linkpagesint = ($totalselectedlinks / $linksresults);
		$linkpageremainder = ($totalselectedlinks % $linksresults);
			if ($linkpageremainder != 0) {
				$linkpages = ceil($linkpagesint);
				if ($totalselectedlinks < $linksresults) {
				$linkpageremainder = 0;
				}
			} else {
				$linkpages = $linkpagesint;
			}
			/* Page Numbering */
			if ($linkpages != 1 && $linkpages != 0) {
				$text .= "<br><br>"
				._SELECTPAGE.": ";
				$prev = $min-$linksresults;
					if ($prev>=0) {
						$leftarrow = "images/left.gif" ;
						$ThemeSel = get_theme();
							if (file_exists("themes/".$ThemeSel."/".$leftarrow)) {
								$leftarrow = "themes/".$ThemeSel."/images/left.gif";
							} else {
								$leftarrow = "images/left.gif";
							}
					$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;min=".$prev."&amp;orderby=".$orderby."&amp;show=".$show."\">"
					."<img src=\"".$leftarrow."\" align=\"middle\" border=\"0\" hspace=\"5\" alt=\""._PREVIOUS."\"></a>";
					}
				$counter = 1;
				$currentpage = ($max / $linksresults);
					while ($counter<=$linkpages ) {
						$cpage = $counter;
						$mintemp = ($perpage * $counter) - $linksresults;
							if ($counter == $currentpage) {
								$text .= "<b>".$counter."</b> ";
							} else {
								$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;min=".$mintemp."&amp;orderby=".$orderby."&amp;show=".$show."\">".$counter."</a> ";
							}
						$counter++;
					}
				$next=$min+$linksresults;
					if ($x>=$perpage) {
						$rightarrow = "images/right.gif";
						$ThemeSel = get_theme();
						if (file_exists("themes/".$ThemeSel."/".$rightarrow)) {
							$rightarrow = "themes/".$ThemeSel."/images/right.gif";
						} else {
							$rightarrow = "images/right.gif";
						}
						$text .= "<a href=\"".WEB_LINKS_FRONTFILE."?l_op=search&amp;unquery=".$the_query."&amp;min=".$max."&amp;orderby=".$orderby."&amp;show=".$show."\">"
						."<img src=\"".$rightarrow."\" align=\"middle\" border=\"0\" hspace=\"5\" alt=\""._NEXT."\"></a>";
					}
			}
            /*
		$text .= "<br><br><div class='center'><span class=\"content\">"
		._TRY2SEARCH." \"".$the_query."\" "._INOTHERSENGINES."<br>"
		."<a target=\"_blank\" href=\"http://www.altavista.com/cgi-bin/query?pg=q&amp;sc=on&amp;hl=on&amp;act=2006&amp;par=0&amp;q=".$the_query."&amp;kl=XX&amp;stype=stext\">Alta Vista</a> - "
		."<a target=\"_blank\" href=\"http://www.hotbot.com/?MT=".$the_query."&amp;DU=days&amp;SW=web\">HotBot</a> - "
		."<a target=\"_blank\" href=\"http://www.infoseek.com/Titles?qt=".$the_query."\">Infoseek</a> - "
		."<a target=\"_blank\" href=\"http://www.dejanews.com/dnquery.xp?QRY=".$the_query."\">Deja News</a> - "
		."<a target=\"_blank\" href=\"http://www.lycos.com/cgi-bin/pursuit?query=".$the_query."&amp;maxhits=20\">Lycos</a> - "
		."<a target=\"_blank\" href=\"http://search.yahoo.com/bin/search?p=".$the_query."\">Yahoo</a>"
		."<br>"
		."<a target=\"_blank\" href=\"http://es.linuxstart.com/cgi-bin/sqlsearch.cgi?pos=1&amp;unquery=".$the_query."&amp;language=&amp;advanced=&amp;urlonly=&amp;withid=\">LinuxStart</a> - "
		."<a target=\"_blank\" href=\"http://search.1stlinuxsearch.com/compass?scope=".$the_query."&amp;ui=sr\">1stLinuxSearch</a> - "
		."<a target=\"_blank\" href=\"http://www.google.com/search?q=".$the_query."\">Google</a> - "
		."<a target=\"_blank\" href=\"http://www.linuxlinks.com/cgi-bin/search.cgi?query=".$the_query."&amp;engine=Links\">LinuxLinks</a> - "
		."<a target=\"_blank\" href=\"http://www.freshmeat.net/search/?q=".$the_query."&amp;section=projects\">Freshmeat</a> - "
		."<a target=\"_blank\" href=\"http://www.justlinux.com/bin/search.pl?key=".$the_query."\">JustLinux</a>"
		."</span>"; */
		} else {
			$text .= "<div class='center'><span class=\"option\"><b>"._NOMATCHES."</b></span></div><br><br>";
		}
		$text .= $this->plugTemplates['CLOSE_TABLE'];
 
        e107::getRender()->tablerender($caption, $text);
    }	
    public function rateinfo($lid, $user)
	{ 
		$lid = intval($lid);
		e107::getDB()->gen("UPDATE #".UN_TABLENAME_LINKS_LINKS." SET hits=hits+1 WHERE lid='".$lid."'");
		$result = e107::getDB()->gen("SELECT url FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
		$row = e107::getDB()->fetch($result);
		 
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
		."<li>".e107::getParser()->lanVars(_RATENOTE4, WEB_LINKS_FRONTFILE)."</li>"  
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
		." <span class=\"content\"><input class='button btn' type=\"submit\" value=\""._RATETHISSITE."\"></span>"
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
		$text .= $this->$text .=$this->linkfooterchild($lid);
		$text .=  "</div>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
		 
        e107::getRender()->tablerender($caption, $text);
    } 
    
    public function addrating($ratinglid, $ratinguser, $rating, $ratinghost_name, $ratingcomments)
	{
		global  $cookie,  $anonymous;

		$anonwaitdays= $this->plugPrefs['anonwaitdays'];
		$outsidewaitdays = $this->plugPrefs['outsidewaitdays'];

		$passtest = "yes";
 
		$ratinglid = intval($ratinglid);
		$text = $this->completevoteheader();
			if(USER) {
				$ratinguser = USERNAME;
			} else if ($ratinguser=="outside") {
				$ratinguser = "outside";
			} else {
				$ratinguser = $anonymous;
			}
		/*$result = e107::getDB()->gen("SELECT title FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$ratinglid."'");
			while ($row = e107::getDB()->fetch($result)) {
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
						$text .= $this->completevote($error);
						$passtest = "no";
					}
					/* Check if Link POSTER is voting (UNLESS Anonymous users allowed to post) */
					if ($ratinguser != $anonymous && $ratinguser != "outside") {
						$result2 = e107::getDB()->gen("SELECT submitter FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$ratinglid."'");
							while ($row2 = e107::getDB()->fetch($result2)) {
								$ratinguserDB = $row2['submitter'];
									if ($ratinguserDB==$ratinguser) {
										$error = "postervote";
										$text .= $this->completevote($error);
										$passtest = "no";
									}
							}
						 
					}
					/* Check if REG user is trying to vote twice. */
					if ($ratinguser != $anonymous && $ratinguser != "outside") {
						$result3 = e107::getDB()->gen("SELECT ratinguser FROM #".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid='".$ratinglid."'");
							while ($row3 = e107::getDB()->fetch($result3)) {
								$ratinguserDB = $row3['ratinguser'];
								if ($ratinguserDB==$ratinguser) {
									$error = "regflood";
									$text .= $this->completevote($error);
									$passtest = "no";
								}
							}
						 
					}
					/* Check if ANONYMOUS user is trying to vote more than once per day. */
					if ($ratinguser == $anonymous){
						$yesterdaytimestamp = (time()-(86400 * $anonwaitdays));
						$ytsDB = Date("Y-m-d H:i:s", $yesterdaytimestamp);
						$result4 = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid='".$ratinglid."' AND ratinguser='".$anonymous."' AND ratinghostname = '".$ip."' AND TO_DAYS(NOW()) - TO_DAYS(ratingtimestamp) < '".$anonwaitdays."'");
						$row4 = e107::getDB()->fetch($result4);
						 
						$anonvotecount = $row4['numrows'];
							if ($anonvotecount >= 1) {
								$error = "anonflood";
								$text .= $this->completevote($error);
								$passtest = "no";
							}
					}
					/* Check if OUTSIDE user is trying to vote more than once per day. */
					if ($ratinguser=="outside"){
						$yesterdaytimestamp = (time()-(86400 * $outsidewaitdays));
						$ytsDB = Date("Y-m-d H:i:s", $yesterdaytimestamp);
						$result5 = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid='".$ratinglid."' AND ratinguser='outside' AND ratinghostname = '".$ip."' AND TO_DAYS(NOW()) - TO_DAYS(ratingtimestamp) < '".$outsidewaitdays."'");
						$row5 = e107::getDB()->fetch($result5);
						 
						$outsidevotecount = $row5['numrows'];
							if ($outsidevotecount >= 1) {
								$error = "outsideflood";
								$text .= $this->completevote($error);
								$passtest = "no";
							}
					}
					/* Passed Tests */
					if ($passtest == "yes") {
						$ratingcomments = stripslashes(check_html($ratingcomments, 'nohtml'));
							if ($comment != "") {
								$text .= update_points(16);
							}
						$text .= update_points(15);
						/* All is well.  Add to Line Item Rate to DB. */
						$ratinglid = intval($ratinglid);
						$rating = intval($rating);
							if ($rating > 10 || $rating < 1) {
								header("Location:  ".WEB_LINKS_INDEX."?l_op=ratelink&lid=".$ratinglid);
								die();
							}
						e107::getDB()->gen("INSERT INTO #".UN_TABLENAME_LINKS_VOTEDATA." VALUES (NULL,'".$ratinglid."', '".$ratinguser."', '".$rating."', '".$ip."', '".addslashes($ratingcomments)."', now())");
						/* All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB. */
						/* NOTE: If weight is modified, ALL links need to be refreshed with new weight. */
						/* Running a SQL statement with your modded calc for ALL links will accomplish this. */
						$voteresult = e107::getDB()->gen("SELECT rating, ratinguser, ratingcomments FROM #".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid = '".$ratinglid."'");
						$rowresult = e107::getDB()->rows();
						$totalvotesDB = count($voteresult);   //TODO check
						include (WEB_LINKS_INDEX."/voteinclude.php");
		 
						$lid = intval($lid);
						e107::getDB()->gen("UPDATE #".UN_TABLENAME_LINKS_LINKS." SET linkratingsummary='".$finalrating."',totalvotes='".$totalvotesDB."',totalcomments='".$truecomments."' WHERE lid = '".$ratinglid."'");
						$error = "none";
						$text .= $this->completevote($error);
					}
			 
					$text .= $this->completevotefooter($ratinglid, $ratinguser);
		 
        e107::getRender()->tablerender($caption, $text);
    } 
    public function viewlinkcomments($lid)
	{
		global  $bgcolor2 ;
		$text =$this->menu(1);
		$lid = intval($lid);
		$result = e107::getDB()->gen("SELECT title FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
		$row = e107::getDB()->fetch($result);

		$ttitle = stripslashes(check_html($row['title'], "nohtml"));
		$text .= "<br>";
		$result = e107::getDB()->gen("SELECT ratinguser, rating, ratingcomments, ratingtimestamp FROM #".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid = '".$lid."' AND ratingcomments <> '' ORDER BY ratingtimestamp DESC");
		$totalcomments = count(e107::getDB()->rows($result));
		$displaytitle = $ttitle;
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$text .= "<div class='center'><span class=\"option\"><b>"._LINKPROFILE.": ".un_htmlentities($displaytitle)."</b></span><br><br>";
		$text .= $this->linkinfomenu($lid);
		$text .= "<br><br><br>"._TOTALOF." ".$totalcomments." "._COMMENTS."</span></div><br>"
		."<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"450\">";
		$x=0;
			while($row = e107::getDB()->fetch($result)) {
				$ratinguser = $row['ratinguser'];
				$rating = $row['rating'];
				$ratingcomments = $row['ratingcomments'];
				$ratingtimestamp = $row['ratingtimestamp'];
				//eregx ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $ratingtimestamp, $ratingtime);
				preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#i", $ratingtimestamp, $ratingtime);			
				$ratingtime = strftime("%F",mktime($ratingtime[4],$ratingtime[5],$ratingtime[6],$ratingtime[2],$ratingtime[3],$ratingtime[1]));
				$date_array = explode("-", $ratingtime);
				$timestamp = mktime(0, 0, 0, $date_array["1"], $date_array["2"], $date_array["0"]);
				$formatted_date = date("F j, Y", $timestamp);
				/* Individual user information */
				$result2 = e107::getDB()->gen("SELECT rating FROM #".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinguser = '".$ratinguser."'");
				$usertotalcomments = count(e107::getDB()->rows($result2));
				$useravgrating = 0;
				while($row2 = e107::getDB()->fetch($result2)) $useravgrating = $useravgrating + $row2['rating'];
 
				$useravgrating = $useravgrating / $usertotalcomments;
				$useravgrating = number_format($useravgrating, 1);
				$text .= "<tr><td bgcolor=\"".$bgcolor2."\">"
				."<span class=\"content\"><b> "._USER.": </b><a href=\"modules.php?name=".UN_DIR_YOURACOUNT."&amp;op=userinfo&amp;username=".$ratinguser."\">".$ratinguser."</a></span>"
				."</td>"
				."<td bgcolor=\"".$bgcolor2."\">"
				."<span class=\"content\"><b>"._RATING.": </b>".$rating."</span>"
				."</td>"
				."<td bgcolor=\"".$bgcolor2."\" align=\"right\">"
				."<span class=\"content\">".$formatted_date."</span>"
				."</td>"
				."</tr>"
				."<tr>"
				."<td valign=\"top\">"
				."<span class=\"tiny\">"._USERAVGRATING.": ".$useravgrating."</span>"
				."</td>"
				."<td valign=\"top\" colspan=\"2\">"
				."<span class=\"tiny\">"._NUMRATINGS.": ".$usertotalcomments."</span>"
				."</td>"
				."</tr>"
				."<tr>"
				."<td colspan=\"3\">"
				."<span class=\"content\">";
					if (ADMIN) {
						$text .= "<a target='_blank' href=\"".UN_FILENAME_ADMIN."?op=LinksModLink&amp;lid=".$lid."\">
                        <img src=\"".WEB_LINKS_APP_ABS."\"/images/editicon.gif\" border=\"0\" alt=\""._EDITTHISLINK."\"></a>";
					}
				$text .= " ".$ratingcomments."</span>"
				."<br><br><br></td></tr>";
				$x++;
			}
		$text .= "</table><br><br><div class='center'>";
		$text .=$this->linkfooter($lid);
		$text .= "</div>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
 
        e107::getRender()->tablerender($caption, $text);
    } 	
    public function outsidelinksetup($lid)
	{
 
		$text = $this->menu(1);
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
 
		$text .=  "<div class='center'><span class=\"option\"><b>"._PROMOTEYOURSITE."</b></span></div><br><br>	
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
			<input type=\"submit\" class='button btn' value=\""._RATEIT."\">\n
		</form>\n
		</div>
		<div class='center'>"._HTMLCODE2."</div><br><br>
		<table border=\"0\" align=\"center\"><tr><td align=\"left\"><i>
		&lt;form action=\"".WEB_LINKS_INDEX."\" method=\"post\"&gt;<br>\n
		&nbsp;&nbsp;&lt;input type=\"hidden\" name=\"lid\" value=\"".$lid."\"&gt;<br>\n
		&nbsp;&nbsp;&lt;input type=\"hidden\" name=\"l_op\" value=\"ratelink\"&gt;<br>\n
		&nbsp;&nbsp;&lt;input type=\"submit\" class='button btn' value=\""._RATEIT."\"&gt;<br>\n
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
			<input type=\"submit\" class='button btn' value=\""._LINKVOTE."\">
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
				&lt;input type=\"submit\" class='button btn' value=\""._LINKVOTE."\"&gt;<br>
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
		$text =$this->menu(1);
		$lid = intval($lid);
		$result = e107::getDB()->gen("SELECT title FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
		$row = e107::getDB()->fetch($result);

		$ttitle = stripslashes(check_html($row['title'], "nohtml"));
		$result = e107::getDB()->gen("SELECT adminid, editorialtimestamp, editorialtext, editorialtitle FROM #".UN_TABLENAME_LINKS_EDITORIALS." WHERE linkid = '".$lid."'");
		$recordexist = count(e107::getDB()->rows($result));
		$displaytitle = $ttitle;
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$text .= "<div class='center'><span class=\"option\"><b>"._LINKPROFILE.": ".un_htmlentities($displaytitle)."</b></span><br>";
		$text .= $this->linkinfomenu($lid);
			if ($recordexist != 0) {
				while($row = e107::getDB()->fetch($result)) {
					$adminid = $row['adminid'];
					$editorialtimestamp = $row['editorialtimestamp'];
					$editorialtext = stripslashes($row['editorialtext']);
					$editorialtitle = stripslashes(check_html($row['editorialtitle'], "nohtml"));
					//eregx ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $editorialtimestamp, $editorialtime);
					epreg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#i", $editorialtimestamp, $editorialtime);				
					$editorialtime = strftime("%F",mktime($editorialtime[4],$editorialtime[5],$editorialtime[6],$editorialtime[2],$editorialtime[3],$editorialtime[1]));
					$date_array = explode("-", $editorialtime);
					$timestamp = mktime(0, 0, 0, $date_array['1'], $date_array['2'], $date_array['0']);
					$formatted_date = date("F j, Y", $timestamp);
					$text .= "<br><br>";
					$text .= $this->plugTemplates['OPEN_TABLE_2'];
					$text .= "<div class='center'><span class=\"option\"><b>'".$editorialtitle."'</b></span></div>"
					."<div class='center'><span class=\"tiny\">"._EDITORIALBY." ".$adminid." - ".$formatted_date."</span></div><br><br>"
					.$editorialtext;
					$text .= $this->plugTemplates['CLOSE_TABLE_2'];
				}
			} else {
				$text .= "<br><br><div class='center'><span class=\"option\"><b>"._NOEDITORIAL."</b></span></div>";
			}

		$text .= "</div><br><br><div class='center'>";
		$text .=$this->linkfooter($lid);
		$text .= "</div>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
 
        e107::getRender()->tablerender($caption, $text);
    }  
    public function viewlinkdetails($lid)
	{
		global  $bgcolor1, $bgcolor2, $bgcolor3, $anonymous ;

		$useoutsidevoting = $this->plugPrefs['useoutsidevoting'];
		$anonweight = $this->plugPrefs['anonweight'];
		$outsideweight = $this->plugPrefs['outsideweight'];
		$detailvotedecimal = $this->plugPrefs['detailvotedecimal'];

		$text =$this->menu(1);
		$lid = intval($lid);
		$voteresult = e107::getDB()->retrieve("SELECT rating, ratinguser, ratingcomments FROM #".UN_TABLENAME_LINKS_VOTEDATA." WHERE ratinglid = '".$lid."'", true);
		$totalvotesDB = count($voteresult);
		$anonvotes = 0;
		$anonvoteval = 0;
		$outsidevotes = 0;
		$outsidevoteeval = 0;
		$regvoteval = 0;
		$topanon = 0;
		$bottomanon = 11;
		$topreg = 0;
		$bottomreg = 11;
		$topoutside = 0;
		$bottomoutside = 11;
		$avv = $rvv = $ovv = array(0,0,0,0,0,0,0,0,0,0,0);
		$truecomments = $totalvotesDB;
            foreach($voteresult AS $row) {
				$ratingDB = $row['rating'];
				$ratinguserDB = $row['ratinguser'];
				$ratingcommentsDB = $row['ratingcomments'];
				if ($ratingcommentsDB=="") $truecomments--;
					if ($ratinguserDB==$anonymous) {
						$anonvotes++;
						$anonvoteval += $ratingDB;
					}
					if ($useoutsidevoting == 1) {
						if ($ratinguserDB=='outside') {
							$outsidevotes++;
							$outsidevoteval += $ratingDB;
						}
					} else {
						$outsidevotes = 0;
					}
					if ($ratinguserDB!=$anonymous && $ratinguserDB!="outside") {
						$regvoteval += $ratingDB;
					}
					if ($ratinguserDB!=$anonymous && $ratinguserDB!="outside") {
						if ($ratingDB > $topreg) $topreg = $ratingDB;
						if ($ratingDB < $bottomreg) $bottomreg = $ratingDB;
						for ($rcounter=1; $rcounter<11; $rcounter++) if ($ratingDB==$rcounter) $rvv[$rcounter]++;
					}
					if ($ratinguserDB==$anonymous) {
						if ($ratingDB > $topanon) $topanon = $ratingDB;
						if ($ratingDB < $bottomanon) $bottomanon = $ratingDB;
						for ($rcounter=1; $rcounter<11; $rcounter++) if ($ratingDB==$rcounter) $avv[$rcounter]++;
					}
					if ($ratinguserDB=="outside") {
						if ($ratingDB > $topoutside) $topoutside = $ratingDB;
						if ($ratingDB < $bottomoutside) $bottomoutside = $ratingDB;
						for ($rcounter=1; $rcounter<11; $rcounter++) if ($ratingDB==$rcounter) $ovv[$rcounter]++;
					}
			}

		$regvotes = $totalvotesDB - $anonvotes - $outsidevotes;
			if ($totalvotesDB == 0) {
				$finalrating = 0;
			} else if ($anonvotes == 0 && $regvotes == 0) {
				/* Figure Outside Only Vote */
				$finalrating = $outsidevoteval / $outsidevotes;
				$finalrating = number_format($finalrating, $detailvotedecimal);
				$avgOU = $outsidevoteval / $totalvotesDB;
				$avgOU = number_format($avgOU, $detailvotedecimal);
			} else if ($outsidevotes == 0 && $regvotes == 0) {
				/* Figure Anon Only Vote */
				$finalrating = $anonvoteval / $anonvotes;
				$finalrating = number_format($finalrating, $detailvotedecimal);
				$avgAU = $anonvoteval / $totalvotesDB;
				$avgAU = number_format($avgAU, $detailvotedecimal);
			} else if ($outsidevotes == 0 && $anonvotes == 0) {
				/* Figure Reg Only Vote */
				$finalrating = $regvoteval / $regvotes;
				$finalrating = number_format($finalrating, $detailvotedecimal);
				$avgRU = $regvoteval / $totalvotesDB;
				$avgRU = number_format($avgRU, $detailvotedecimal);
			} else if ($regvotes == 0 && $useoutsidevoting == 1 && $outsidevotes != 0 && $anonvotes != 0 ) {
				/* Figure Reg and Anon Mix */
				$avgAU = $anonvoteval / $anonvotes;
				$avgOU = $outsidevoteval / $outsidevotes;
					if ($anonweight > $outsideweight ) {
						/* Anon is 'standard weight' */
						$newimpact = $anonweight / $outsideweight;
						$impactAU = $anonvotes;
						$impactOU = $outsidevotes / $newimpact;
						$finalrating = ((($avgOU * $impactOU) + ($avgAU * $impactAU)) / ($impactAU + $impactOU));
						$finalrating = number_format($finalrating, $detailvotedecimal);
					} else {
						/* Outside is 'standard weight' */
						$newimpact = $outsideweight / $anonweight;
						$impactOU = $outsidevotes;
						$impactAU = $anonvotes / $newimpact;
						$finalrating = ((($avgOU * $impactOU) + ($avgAU * $impactAU)) / ($impactAU + $impactOU));
						$finalrating = number_format($finalrating, $detailvotedecimal);
					}
			} else {
				/* REG User vs. Anonymous vs. Outside User Weight Calutions */
				$impact = $anonweight;
				$outsideimpact = $outsideweight;
					if ($regvotes == 0) {
						$avgRU = 0;
					} else {
						$avgRU = $regvoteval / $regvotes;
					}
					if ($anonvotes == 0) {
						$avgAU = 0;
					} else {
						$avgAU = $anonvoteval / $anonvotes;
					}
					if ($outsidevotes == 0 ) {
						$avgOU = 0;
					} else {
						$avgOU = $outsidevoteval / $outsidevotes;
					}
				$impactRU = $regvotes;
				$impactAU = $anonvotes / $impact;
				$impactOU = $outsidevotes / $outsideimpact;
				$finalrating = (($avgRU * $impactRU) + ($avgAU * $impactAU) + ($avgOU * $impactOU)) / ($impactRU + $impactAU + $impactOU);
				$finalrating = number_format($finalrating, $detailvotedecimal);
			}
			$avgOU = (empty($avgOU)) ? "" : number_format($avgOU, $detailvotedecimal);
			$avgRU = (empty($avgRU)) ? "" : number_format($avgRU, $detailvotedecimal);
			$avgAU = (empty($avgAU)) ? "" : number_format($avgAU, $detailvotedecimal);
		if ($topanon == 0) $topanon = "";
		if ($bottomanon == 11) $bottomanon = "";
		if ($topreg == 0) $topreg = "";
		if ($bottomreg == 11) $bottomreg = "";
		if ($topoutside == 0) $topoutside = "";
		if ($bottomoutside == 11) $bottomoutside = "";
		$totalchartheight = 70;
		$chartunits = $totalchartheight / 10;
		$avvper = $rvvper = $ovvper = $avvpercent = $rvvpercent = $ovvpercent = $avvchartheight = $rvvchartheight = $ovvchartheight = array(0,0,0,0,0,0,0,0,0,0,0);
		$ovvmultiplier = $rvvmultiplier = $avvmultiplier = 0;
			for ($rcounter=1; $rcounter<11; $rcounter++) {
				if ($anonvotes != 0) $avvper[$rcounter] = $avv[$rcounter] / $anonvotes;
				if ($regvotes != 0) $rvvper[$rcounter] = $rvv[$rcounter] / $regvotes;
				if ($outsidevotes != 0) $ovvper[$rcounter] = $ovv[$rcounter] / $outsidevotes;
				$avvpercent[$rcounter] = number_format($avvper[$rcounter] * 100, 1);
				$rvvpercent[$rcounter] = number_format($rvvper[$rcounter] * 100, 1);
				$ovvpercent[$rcounter] = number_format($ovvper[$rcounter] * 100, 1);
				if ($avv[$rcounter] > $avvmultiplier) $avvmultiplier = $avv[$rcounter];
				if ($rvv[$rcounter] > $rvvmultiplier) $rvvmultiplier = $rvv[$rcounter];
				if ($ovv[$rcounter] > $ovvmultiplier) $ovvmultiplier = $ovv[$rcounter];
			}
		if ($avvmultiplier != 0) $avvmultiplier = 10 / $avvmultiplier;
		if ($rvvmultiplier != 0) $rvvmultiplier = 10 / $rvvmultiplier;
		if ($ovvmultiplier != 0) $ovvmultiplier = 10 / $ovvmultiplier;
		for ($rcounter=1; $rcounter<11; $rcounter++) {
			$avvchartheight[$rcounter] = ($avv[$rcounter] * $avvmultiplier) * $chartunits;
			$rvvchartheight[$rcounter] = ($rvv[$rcounter] * $rvvmultiplier) * $chartunits;
			$ovvchartheight[$rcounter] = ($ovv[$rcounter] * $ovvmultiplier) * $chartunits;
			if ($avvchartheight[$rcounter]==0) $avvchartheight[$rcounter]=1;
			if ($rvvchartheight[$rcounter]==0) $rvvchartheight[$rcounter]=1;
			if ($ovvchartheight[$rcounter]==0) $ovvchartheight[$rcounter]=1;
		}
		$res = e107::getDB()->gen("SELECT title FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
		$rowt = e107::getDB()->fetch($res);

		$ttitle = stripslashes(check_html($rowt['title'], "nohtml"));
		$text .= "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];
		$text .= "<div class='center'><span class=\"option\"><b>"._LINKPROFILE.": ".$ttitle."</b></span><br><br>";
		$text .= $this->linkinfomenu($lid);
		$text .= "<br><br>"._LINKRATINGDET."<br>"
			._TOTALVOTES." ".$totalvotesDB."<br>"
			._OVERALLRATING.": ".$finalrating."</div><br><br>"
		."<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"455\">"
		."<tr><td colspan=\"2\" bgcolor=\"".$bgcolor2."\">"
		."<span class=\"content\"><b>"._REGISTEREDUSERS."</b></span>"
		."</td></tr>"
		."<tr>"
		."<td bgcolor=\"".$bgcolor1."\">"
			."<span class=\"content\">"._NUMBEROFRATINGS.": ".$regvotes."</span>"
		."</td>"
		."<td rowspan=\"5\" width=\"200\">";
			if ($regvotes==0) {
				$text .= "<div class='center'><span class=\"content\">"._NOREGUSERSVOTES."</span></div>";
			} else {
				$text .= "<table border=\"1\" width=\"200\">"
				."<tr>"
				."<td valign=\"top\" align=\"center\" colspan=\"10\" bgcolor=\"".$bgcolor2."\"><span class=\"content\">"._BREAKDOWNBYVAL."</span></td>"
				."</tr>"
				."<tr>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[1]." "._LVOTES." (".$rvvpercent[1]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[1]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[2]." "._LVOTES." (".$rvvpercent[2]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[2]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[3]." "._LVOTES." (".$rvvpercent[3]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[3]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[4]." "._LVOTES." (".$rvvpercent[4]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[4]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[5]." "._LVOTES." (".$rvvpercent[5]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[5]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[6]." "._LVOTES." (".$rvvpercent[6]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[6]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[7]." "._LVOTES." (".$rvvpercent[7]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[7]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[8]." "._LVOTES." (".$rvvpercent[8]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[8]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[9]." "._LVOTES." (".$rvvpercent[9]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[9]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$rvv[10]." "._LVOTES." (".$rvvpercent[10]."% "._LTOTALVOTES.")\" src=\"".WEB_LINKS_APP_ABS."/images/blackpixel.gif\" width=\"15\" height=\"".$rvvchartheight[10]."\"></td>"
				."</tr>"
				."<tr><td colspan=\"10\" bgcolor=\"".$bgcolor2."\">"
				."<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"200\"><tr>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">1</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">2</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">3</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">4</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">5</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">6</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">7</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">8</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">9</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">10</span></td>"
				."</tr></table>"
				."</td></tr></table>";
			}
		$text .= "</td>"
		."</tr>"
		."<tr><td bgcolor=\"".$bgcolor2."\"><span class=\"content\">"._LINKRATING.": ".$avgRU."</span></td></tr>"
		."<tr><td bgcolor=\"".$bgcolor1."\"><span class=\"content\">"._HIGHRATING.": ".$topreg."</span></td></tr>"
		."<tr><td bgcolor=\"".$bgcolor2."\"><span class=\"content\">"._LOWRATING.": ".$bottomreg."</span></td></tr>"
		."<tr><td bgcolor=\"".$bgcolor1."\"><span class=\"content\">"._NUMOFCOMMENTS.": ".$truecomments."</span></td></tr>"
		."<tr><td></td></tr>"
		."<tr><td valign=\"top\" colspan=\"2\"><span class=\"tiny\"><br><br>"._WEIGHNOTE." ".$anonweight." "._TO." 1.</span></td></tr>"
		."<tr><td colspan=\"2\" bgcolor=\"".$bgcolor2."\"><span class=\"content\"><b>"._UNREGISTEREDUSERS."</b></span></td></tr>"
		."<tr><td bgcolor=\"".$bgcolor1."\"><span class=\"content\">"._NUMBEROFRATINGS.": ".$anonvotes."</span></td>"
		."<td rowspan=\"5\" width=\"200\">";
			if ($anonvotes==0) {
				$text .= "<div class='center'><span class=\"content\">"._NOUNREGUSERSVOTES."</span></div>";
			} else {
				$text .= "<table border=\"1\" width=\"200\">"
				."<tr>"
				."<td valign=\"top\" align=\"center\" colspan=\"10\" bgcolor=\"".$bgcolor2."\"><span class=\"content\">"._BREAKDOWNBYVAL."</span></td>"
				."</tr>"
				."<tr>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[1]." "._LVOTES." (".$avvpercent[1]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[1]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[2]." "._LVOTES." (".$avvpercent[2]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[2]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[3]." "._LVOTES." (".$avvpercent[3]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[3]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[4]." "._LVOTES." (".$avvpercent[4]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[4]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[5]." "._LVOTES." (".$avvpercent[5]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[5]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[6]." "._LVOTES." (".$avvpercent[6]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[6]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[7]." "._LVOTES." (".$avvpercent[7]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[7]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[8]." "._LVOTES." (".$avvpercent[8]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[8]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[9]." "._LVOTES." (".$avvpercent[9]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[9]."\"></td>"
				."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"".$avv[10]." "._LVOTES." (".$avvpercent[10]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$avvchartheight[10]."\"></td>"
				."</tr>"
				."<tr><td colspan=\"10\" bgcolor=\"".$bgcolor2."\">"
				."<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"200\"><tr>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">1</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">2</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">3</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">4</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">5</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">6</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">7</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">8</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">9</span></td>"
				."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">10</span></td>"
				."</tr></table>"
				."</td></tr></table>";
			}
		$text .= "</td>"
		."</tr>"
		."<tr><td bgcolor=\"".$bgcolor2."\"><span class=\"content\">"._LINKRATING.": ".$avgAU."</span></td></tr>"
		."<tr><td bgcolor=\"".$bgcolor1."\"><span class=\"content\">"._HIGHRATING.": ".$topanon."</span></td></tr>"
		."<tr><td bgcolor=\"".$bgcolor2."\"><span class=\"content\">"._LOWRATING.": ".$bottomanon."</span></td></tr>"
		."<tr><td bgcolor=\"".$bgcolor1."\"><span class=\"content\">&nbsp;</span></td></tr>";
			if ($useoutsidevoting == 1) {
				$text .= "<tr><td valign=\"top\" colspan=\"2\"><span class=\"tiny\"><br><br>"._WEIGHOUTNOTE." ".$outsideweight." "._TO." 1.</span></td></tr>"
				."<tr><td colspan=\"2\" bgcolor=\"".$bgcolor2."\"><span class=\"content\"><b>"._OUTSIDEVOTERS."</b></span></td></tr>"
				."<tr><td bgcolor=\"".$bgcolor1."\"><span class=\"content\">"._NUMBEROFRATINGS.": ".$outsidevotes."</span></td>"
				."<td rowspan=\"5\" width=\"200\">";
					if ($outsidevotes==0) {
						$text .= "<div class='center'><span class=\"content\">"._NOOUTSIDEVOTES."</span></div>";
					} else {
						$text .= "<table border=\"1\" width=\"200\">"
						."<tr>"
						."<td valign=\"top\" align=\"center\" colspan=\"10\" bgcolor=\"".$bgcolor2."\"><span class=\"content\">"._BREAKDOWNBYVAL."</span></td>"
						."</tr>"
						."<tr>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[1] "._LVOTES." (".$ovvpercent[1]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[1]."\"></td>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[2] "._LVOTES." (".$ovvpercent[2]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[2]."\"></td>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[3] "._LVOTES." (".$ovvpercent[3]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[3]."\"></td>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[4] "._LVOTES." (".$ovvpercent[4]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[4]."\"></td>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[5] "._LVOTES." (".$ovvpercent[5]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[5]."\"></td>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[6] "._LVOTES." (".$ovvpercent[6]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[6]."\"></td>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[7] "._LVOTES." (".$ovvpercent[7]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[7]."\"></td>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[8] "._LVOTES." (".$ovvpercent[8]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[8]."\"></td>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[9] "._LVOTES." (".$ovvpercent[9]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[9]."\"></td>"
						."<td bgcolor=\"".$bgcolor1."\" valign=\"bottom\"><img border=\"0\" alt=\"$ovv[10] "._LVOTES." (".$ovvpercent[10]."% "._LTOTALVOTES.")\" src=\"images/blackpixel.gif\" width=\"15\" height=\"".$ovvchartheight[10]."\"></td>"
						."</tr>"
						."<tr><td colspan=\"10\" bgcolor=\"".$bgcolor2."\">"
						."<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"200\"><tr>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">1</span></td>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">2</span></td>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">3</span></td>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">4</span></td>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">5</span></td>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">6</span></td>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">7</span></td>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">8</span></td>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">9</span></td>"
						."<td width=\"10%\" valign=\"bottom\" align=\"center\"><span class=\"content\">10</span></td>"
						."</tr></table>"
						."</td></tr></table>";
					}
				$text .= "</td>"
				."</tr>"
				."<tr><td bgcolor=\"".$bgcolor2."\"><span class=\"content\">"._LINKRATING.": ".$avgOU."</span></td></tr>"
				."<tr><td bgcolor=\"".$bgcolor1."\"><span class=\"content\">"._HIGHRATING.": ".$topoutside."</span></td></tr>"
				."<tr><td bgcolor=\"".$bgcolor2."\"><span class=\"content\">"._LOWRATING.": ".$bottomoutside."</span></td></tr>"
				."<tr><td bgcolor=\"".$bgcolor1."\"><span class=\"content\">&nbsp;</span></td></tr>";
			}
		$text .= "</table><br><br><div class='center'>";
		$text .=$this->linkfooter($lid);
		$text .= "</div>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];
 
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