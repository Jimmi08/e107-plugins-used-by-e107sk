<?php

if (!defined('e107_INIT'))
{
	exit;
}

trait WebLinksTrait
{


	function menu($mainlink) {
		 
		$links_anonaddlinklock = e107::getPlugConfig('web_links')->getPref('links_anonaddlinklock');
		$user_addlink = $this->plugPrefs['user_addlink'];

		$text = ''; 
		$text .= $this->plugTemplates['OPEN_TABLE'];
		
		$text .="<br><div class='text-center'><a href=\"".WEB_LINKS_FRONTFILE."\"><img src=\"".WEB_LINKS_APP_ABS."/images/link-logo.gif\" border=\"0\" alt=\"\"></a><br><br>";
		
		$text .= $this->SearchForm();
		$text .= "<div class=\"content\">[ ";
			if ($mainlink>0) {
				$text .="<a href=\"".WEB_LINKS_FRONTFILE."\">"._LINKSMAIN."</a> | ";
			}
			if (((getperms("P")) && $this->user_addlink == 1) || $this->links_anonaddlinklock != 1) {
				$text .="<a href=\"".WEB_LINKS_FRONTFILE."?l_op=AddLink\">"._ADDLINK."</a>"
				." | ";
			}
			
		$text .="<a href=\"".WEB_LINKS_FRONTFILE."?l_op=NewLinks\">"._NEW."</a>"
		." | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=MostPopular\">"._POPULAR."</a>"
		." | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=TopRated\">"._TOPRATED."</a>"
		." | <a href=\"".WEB_LINKS_FRONTFILE."?l_op=RandomLink\">"._RANDOM."</a> ]"
		."</div></div>";
		
		$text .= $this->plugTemplates['CLOSE_TABLE'];
		return $text;
	}

	function SearchForm() {
		global  $unquery;
		 
		if(empty($unquery)) $unquery = "";
		$text .="<form action=\"".WEB_LINKS_FRONTFILE."\" method=\"post\">"
		."<div class=\"content\"><input type=\"hidden\" name=\"l_op\" value=\"search\">
		<input type=\"text\" class='form-control text' size=\"25\" name=\"unquery\" value=\"".un_htmlentities($unquery)."\"> 
		<input type=\"submit\" class='button btn' value=\""._SEARCHWL."\"></div>"
		."</form>";
		return $text;
	}

	function newlinkgraphic($time) {
		$module_name =  WEB_LINKS_APP;
		//eregx ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
		preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#i", $time, $datetime);
		$datetime = date("d-M-Y", mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
		$startdate = time();
		$count = 0;
			while ($count <= 7) {
				$daysold = date("d-M-Y", $startdate);
				if ($daysold == $datetime) {
				if ($count<=1) {
					$text .= "&nbsp;<img src=\"".$module_name."/images/newred.gif\" alt=\""._NEWTODAY."\">";
				}
				if ($count<=3 && $count>1) {
					$text .= "&nbsp;<img src=\"".$module_name."/images/newgreen.gif\" alt=\""._NEWLAST3DAYS."\">";
				}
				if ($count<=7 && $count>3) {
					$text .= "&nbsp;<img src=\"".$module_name."/images/newblue.gif\" alt=\""._NEWTHISWEEK."\">";
				}
				}
				$count++;
				$startdate = (time()-(86400 * $count));
			}
	}

	function popgraphic($hits) {
		$popular = e107::getPlugConfig('web_links')->getPref('popular');
		$module_name =  WEB_LINKS_APP;
		if ($hits<=$popular) {
			$text = "&nbsp;<img src=\"".$module_name."/images/pop.gif\" alt=\""._POPULAR."\">";
		}
		return $text;
	}


	function categorynewlinkgraphic($cat) {
		$module_name =  WEB_LINKS_APP;
		$cat = intval($cat);
		$result = e107::getDB()->gen("SELECT date FROM #".UN_TABLENAME_LINKS_LINKS." WHERE cid='".$cat."' ORDER BY date DESC LIMIT 1");
		$row = e107::getDB()->fetch($result);
		$time = $row['date'];  
		#eregx ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
		preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#i", $time, $datetime);	
		$datetime = date("d-M-Y", mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
		$startdate = time();
		$count = 0;
			while ($count <= 7) {
				$daysold = date("d-M-Y", $startdate);
				if ($daysold == $datetime) {
					if ($count<=1) {
						$text = "&nbsp;<img src=\"".$module_name."/images/newred.gif\" alt=\""._CATNEWTODAY."\">";
					}
					if ($count<=3 && $count>1) {
						$text = "&nbsp;<img src=\"".$module_name."/images/newgreen.gif\" alt=\""._CATLAST3DAYS."\">";
					}
					if ($count<=7 && $count>3) {
						$text = "&nbsp;<img src=\"".$module_name."/images/newblue.gif\" alt=\""._CATTHISWEEK."\">";
					}
				}
				$count++;
				$startdate = (time()-(86400 * $count));
			}
		return $text;
	}

	function detecteditorial($lid) { 
		$lid = intval($lid);
		$resulted2 = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM #".UN_TABLENAME_LINKS_EDITORIALS." WHERE linkid='".$lid."'");
		$rowed2 = e107::getDB()->fetch($resulted2);

		$recordexist = $rowed2['numrows'];
		if ($recordexist != 0) {
			$text =  " | <a \"".WEB_LINKS_FRONTFILE."?l_op=viewlinkeditorial&amp;lid=".$lid."\">"._EDITORIAL."</a>";
		}

		return $text;
	}

	function getparent($parentid,$title) {

		$parentid = intval($parentid);
		$result = e107::getDB()->gen("SELECT cid, title, parentid FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE cid='".$parentid."'");
		$row = e107::getDB()->fetch($result);
		 
		$cid = $row['cid'];
		$ptitle = e107::getParser()->toHTML($row['title'], "", "TITLE");
		$pparentid = $row['parentid'];

		if(!empty($ptitle) && $ptitle != $title) $title = $ptitle."/".$title;
		if ($pparentid != 0) {
			$title = $this->getparent($pparentid,$title);
		}
		return $title;
	}

	function getparentlink($parentid,$title) {
		$module_name =  WEB_LINKS_APP;
		$parentid = intval($parentid);
		$result = e107::getDB()->gen("SELECT cid, title, parentid FROM #".UN_TABLENAME_LINKS_CATEGORIES." WHERE cid='".$parentid."'");
		$row = e107::getDB()->fetch($result);
		 
		$cid = $row['cid'];
		$ptitle = e107::getParser()->toHTML($row_two['title'], "", "TITLE");
		$pparentid = $row['parentid'];
		if ($ptitle != "") $title="<a href=\"".$module_name."?l_op=viewlink&amp;cid=".$cid."\">".$ptitle."</a>/".$title;
			if ($pparentid != 0) {
				$title = $this->getparentlink($pparentid,$ptitle);
			}
		return $title;
	}

	function convertorderbytrans($orderby) {
 
		
		switch($orderby) {
		
			case "hits ASC":
				return _POPULARITY1;
			break;
			
			case "hits DESC":
				return _POPULARITY2;
			break;
			
			case "title ASC":
				return _TITLEAZ;
			break;
			
			case "title DESC":
				return _TITLEZA;
			break;
			
			case "date ASC":
				return _DDATE1;
			break;
			
			case "date DESC":
				return _DDATE2;
			break;
			
			case "linkratingsummary ASC":
				return _RATING1;
			break;
			
			case "linkratingsummary DESC":
				return _RATING2;
			break;
			
			default:
				Header("Location: ".WEB_LINKS_INDEX);
				exit();
			break;
		}
	}

	function convertorderbyout($orderby) {
 
		switch($orderby) {
		
			case "title ASC":
				return "titleA";
			break;
			
			case "date ASC":
				return "dateA";
			break;
			
			case "hits ASC":
				return "hitsA";
			break;
			
			case "linkratingsummary ASC":
				return "ratingA";
			break;
			
			case "title DESC":
				return "titleD";
			break;
			
			case "date DESC":
				return "dateD";
			break;
			
			case "hits DESC":
				return "hitsD";
			break;
			
			case "linkratingsummary DESC":
				return "ratingD";
			break;
			
			default:
				Header("Location: ".WEB_LINKS_INDEX);
				exit();
			break;
		}
	}

	function linkfooterchild($lid) {
		 
		$useoutsidevoting = e107::getPlugConfig('web_links')->getPref('useoutsidevoting');
		 
		if ($useoutsidevoting = 1) {
			$text = "<br><font class=\"content\">"._ISTHISYOURSITE." <a href=\"".WEB_LINKS_FRONTFILE."?l_op=outsidelinksetup&amp;lid=".$lid."\">"._ALLOWTORATE."</a></font>";
		}
		return $text;

	}

	function completevoteheader(){
		$text = $this->menu(1);
		$text .=  "<br>";
		$text .= $this->plugTemplates['OPEN_TABLE'];

		return $text;
	}
	
	function completevotefooter($lid, $ratinguser) {
		$sitename = SITENAME;
		//include("modules/".$module_name."/l_config.php");
		$lid = intval($lid);
		$result = e107::getDB()->gen("SELECT title, url FROM #".UN_TABLENAME_LINKS_LINKS." WHERE lid='".$lid."'");
		$row = e107::getDB()->fetch($result);
		 
		$url = stripslashes($row['url']);
		$ttitle = stripslashes(check_html($row['title'], "nohtml"));
		$text .=  "<font class=\"content\">"._THANKSTOTAKETIME." ".$sitename.". "._LETSDECIDE."</font><br><br><br>";
		if ($ratinguser=="outside") {
			$text .=  "<div class='center'><font class=\"content\">".WEAPPREACIATE." ".$sitename."!<br><a href=\"".$url."\">"._RETURNTO." ".$ttitle."</a></font><div class='center'><br><br>";
		}
		$text .=  "<div class='center'>";
		$text .= $this->linkinfomenu($lid);
		$text .=  "</div>";
		$text .= $this->plugTemplates['CLOSE_TABLE'];

		return $text;
	}

	function completevote($error) {
 
		if ($error == "none") $text .=  "<div class='center'><font class=\"content\"><b>"._COMPLETEVOTE1."</b></font></div>";
		if ($error == "anonflood") $text .=  "<div class='center'><font class=\"option\"><b>"._COMPLETEVOTE2."</b></font></div><br>";
		if ($error == "regflood") $text .=  "<div class='center'><font class=\"option\"><b>"._COMPLETEVOTE3."</b></font></div><br>";
		if ($error == "postervote") $text .=  "<div class='center'><font class=\"option\"><b>"._COMPLETEVOTE4."</b></font></div><br>";
		if ($error == "nullerror") $text .=  "<div class='center'><font class=\"option\"><b>"._COMPLETEVOTE5."</b></font></div><br>";
		if ($error == "outsideflood") $text .=  "<div class='center'><font class=\"option\"><b>"._COMPLETEVOTE6."</b></font></div><br>";

		return $text;
	}

	function linkinfomenu($lid) {
		 
		$text = "<br><font class=\"content\">[ "
		."<a href=\"".WEB_LINKS_INDEX."?l_op=viewlinkcomments&amp;lid=".$lid."\">"._LINKCOMMENTS."</a>"
		." | <a href=\"".WEB_LINKS_INDEX."?l_op=viewlinkdetails&amp;lid=".$lid."\">"._ADDITIONALDET."</a>"
		." | <a href=\"".WEB_LINKS_INDEX."?l_op=viewlinkeditorial&amp;lid=".$lid."\">"._EDITORREVIEW."</a>"
		." | <a href=\"".WEB_LINKS_INDEX."?l_op=modifylinkrequest&amp;lid=".$lid."\">"._MODIFY."</a>";
		if (USER) {
			$text .= " | <a href=\"href=\"".WEB_LINKS_INDEX."?l_op=brokenlink&amp;lid=".$lid."\">"._REPORTBROKEN."</a>";
		}
		$text .= " ]</font>";

		return $text;
	}

	function linkfooter($lid) {
		$text = "<font class=\"content\">[ <a href=\"".WEB_LINKS_INDEX."?l_op=visit&amp;lid=".$lid."\" target=\"_blank\">"._VISITTHISSITE."</a> | <a href=\"modules.php?name=".$module_name."&amp;l_op=ratelink&amp;lid=".$lid."\">"._RATETHISSITE."</a> ]</font><br><br>";
		$text .= $this->linkfooterchild($lid);
	}

	function convertorderbyin($orderby) {

		switch($orderby) {
		
			case "titleA":
				return "title ASC";
			break;
			
			case "dateA":
				return "date ASC";
			break;
			
			case "hitsA":
				return "hits ASC";
			break;
			
			case "ratingA":
				return "linkratingsummary ASC";
			break;
			
			case "titleD":
				return "title DESC";
			break;
			
			case "dateD":
				return "date DESC";
			break;
			
			case "hitsD":
				return "hits DESC";
			break;
			
			case "ratingD":
				return "linkratingsummary DESC";
			break;
			
			default:
				Header("Location: ".WEB_LINKS_INDEX);
				exit();
			break;
		}
	}
	
}