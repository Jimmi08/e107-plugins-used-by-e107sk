<?php

if (!defined('e107_INIT'))
{
	exit;
}

trait WebLinksTrait
{


	function menu($mainlink) {
		global  $user, $user_addlink, $links_anonaddlinklock;
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
		global $popular;
		$module_name =  WEB_LINKS_APP;
		if ($hits>=$popular) {
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
		$resulted2 = e107::getDB()->gen("SELECT COUNT(*) AS numrows FROM ".UN_TABLENAME_LINKS_EDITORIALS." WHERE linkid='".$lid."'");
		$rowed2 = e107::getDB()->fetch($resulted2);

		$recordexist = $rowed2['numrows'];
		if ($recordexist != 0) {
			$text =  " | <a \"".WEB_LINKS_FRONTFILE."?l_op=viewlinkeditorial&amp;lid=".$lid."\">"._EDITORIAL."</a>";
		}

		return $text;
	}

	function getparent($parentid,$title) {

		$parentid = intval($parentid);
		$result = e107::getDB()->gen("SELECT cid, title, parentid FROM ".UN_TABLENAME_LINKS_CATEGORIES." WHERE cid='".$parentid."'");
		$row = e107::getDB()->fetch($result);
		 
		$cid = $row['cid'];
		$ptitle = e107::getParser()->toHTML($row['title'], "", "TITLE");
		$pparentid = $row['parentid'];

		if(!empty($ptitle) && $ptitle != $title) $title = $ptitle."/".$title;
		if ($pparentid != 0) {
			$title = getparent($pparentid,$title);
		}
		return $title;
	}

}