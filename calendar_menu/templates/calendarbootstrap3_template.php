<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Templates for event calendar displays
 *
 * $Source: /cvs_backup/e107_0.8/e107_plugins/calendar_menu/templates/calendar_template.php,v $
 * $Revision$
 * $Date$
 * $Author$
 */

/**
 *	e107 Event calendar plugin
 *
 * Templates for event calendar displays
 *
 *	@package	e107_plugins
 *	@subpackage	event_calendar
 *	@version 	$Id$;
 *
 */


if (!defined('e107_INIT')) { exit; }
if (!defined('USER_WIDTH')){ define('USER_WIDTH','width:auto'); }

//global $sc_style;

  $ec_images_path = e_IMAGE;
  $ec_images_path_abs = e_IMAGE_ABS;
  if (!defined('EC_RECENT_ICON')) 
  {
	define('EC_RECENT_ICON',e_IMAGE.'generic/new.png');
	define('EC_RECENT_ICON_ABS',e_IMAGE_ABS.'generic/new.png');
  }		// Filename of icon used to flag recent events



// TIMETABLE -------------------------------------------------------------------

$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['time_table_start']       = "<div class='calendar-wrapper'>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['time_table_end']         = "</div>";

 
// TIME SWITCH BUTTONS ---------------------------------------------------------

$CALENDARBOOTSTRAP3_WRAPPER['calendar']['EC_PREV_MONTH'] =  "<span class='defaulttext'>{---}</span>";
$CALENDARBOOTSTRAP3_WRAPPER['calendar']['EC_CURRENT_MONTH'] =  "<h2><b>{---}</b></h2>";
$CALENDARBOOTSTRAP3_WRAPPER['calendar']['EC_NEXT_MONTH'] =  "<span class='defaulttext'>{---}</span>";
$CALENDARBOOTSTRAP3_WRAPPER['calendar']['EC_PREV_YEAR'] =  "{---}";
$CALENDARBOOTSTRAP3_WRAPPER['calendar']['EC_MONTH_LIST'] =  "{---}";
$CALENDARBOOTSTRAP3_WRAPPER['calendar']['EC_NEXT_YEAR'] =  "{---}";
 
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['time_table']  = " 
 
  <div class='calendar-navigation'>
    <div class='month-browser row text-center'>     
      	<div class='calendar_nav col-xs-12 col-sm-3 col-md-2 '>	{EC_PREV_MONTH: class=btn btn-default} </div>
      	<div class='current-month col-xs-12 col-sm-6 col-md-8'>	<b>{EC_CURRENT_MONTH: class=btn btn-primary}</b> </div>	
        <div class='calendar_nav col-xs-12 col-sm-3 col-md-2 '>	{EC_NEXT_MONTH: class=btn btn-default}		</div>
      </div>
    <div class='year-browser row  text-center'>   
      	<div class='calendar_nav col-xs-12 col-sm-3 col-md-2 '>	{EC_PREV_YEAR: class=btn btn-primary} </div>
      	<div class='current-month col-xs-12 col-sm-6 col-md-8 hidden-xs '>	<b>{EC_MONTH_LIST: class=btn btn-primary}</b> </div>	
        <div class='calendar_nav col-xs-12 col-sm-3 col-md-2 '>	{EC_NEXT_YEAR: class=btn btn-primary}	</div>     
    </div>
  </div>
 ";  
 
// NAVIGATION BUTTONS CALENDAR PAGE --------------------------------------------
 
$CALENDARBOOTSTRAP3_WRAPPER['calendar']['EC_NAV_LINKCURRENTMONTH'] =  "{---}";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['navigation_table'] = "
<div style='text-align:center; margin-bottom:20px;'>
<form method='post' action='" . e_SELF . "?" . e_QUERY . "' id='calform'>
<table class='table'>
<tr>
<td style='text-align:center;'>{EC_NAV_CATEGORIES} {EC_NAV_BUT_ALLEVENTS} {EC_NAV_BUT_VIEWCAT} {EC_NAV_BUT_ENTEREVENT} {EC_NAV_BUT_SUBSCRIPTION} {EC_NAV_BUT_PRINTLISTS} {EC_NAV_LINKCURRENTMONTH}</td>
</tr>\n
</table>
</form>
</div>";

// BIG CALENDAR PAGE -----------------------------------------------------------

$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_start']        = "<div class='respcalendar'  >";
//header row
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_header_start'] = "<ul class='weekdays'>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_header']       = "<li class='day_of_week'>{EC_CALENDAR_CALENDAR_HEADER_DAY}</li>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_header_end']   = "</ul><ul class='days'>";
//end
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_end']          = "</div>";

$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_weekswitch']   = "</ul><ul class='days'>";
// empty day
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_day_non']      = "<li class='calendar-day out_of_range'> </li>";
//today
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_day_today']    = "
<li class='calendar-day'><div class='date day_cell'><em>{EC_CALENDAR_CALENDAR_DAY_TODAY_HEADING}  </span></em>";

//day has events
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_day_event']    = "
<li class='calendar-day'><div class='date day_cell'><b>{EC_CALENDAR_CALENDAR_DAY_EVENT_HEADING}</b>";

// display events ------------------------------------------------------------
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['showevent'] = "
  <div class='show-info forumheader'>{EC_SHOWEVENT_IMAGE: w=20&h=20} {EC_SHOWEVENT_INDICAT}  {EC_SHOWEVENT_HEADING}
    <div class='show-time'>
      {EC_CALENDAR_CALENDAR_RECENT_ICON}
    </div>
  </div> 
 ";

// no events and not today
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_day_empty'] = "
<li class='calendar-day'><div class='date day_cell'>{EC_CALENDAR_CALENDAR_DAY_EMPTY_HEADING}   </div>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar']['calendar_day_end']   = "</li>";


// NAVIGATION BUTTONS EVENT PAGE -----------------------------------------------

$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_NAV_LINKCURRENTMONTH'] =  "{---}";

$CALENDARBOOTSTRAP3_TEMPLATE['event']['time_table'] 			= $CALENDARBOOTSTRAP3_TEMPLATE['calendar']['time_table'];
$CALENDARBOOTSTRAP3_TEMPLATE['event']['time_table_end']  	= $CALENDARBOOTSTRAP3_TEMPLATE['calendar']['time_table_end']; 
$CALENDARBOOTSTRAP3_TEMPLATE['event']['navigation_table'] = $CALENDARBOOTSTRAP3_TEMPLATE['calendar']['navigation_table'];


// EVENT LIST ------------------------------------------------------------------

$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENTLIST_CAPTION'] =  "<tr><td class='fcaption' colspan='2'>{---}:<br /><br /></td></tr>";

$CALENDARBOOTSTRAP3_TEMPLATE['event']['eventlist_table_start'] = "<table class='table fborder eventlist_table_start'>{EC_EVENTLIST_CAPTION}";
$CALENDARBOOTSTRAP3_TEMPLATE['event']['eventlist_table_end'] = "</table>";


// EVENT ARCHIVE ---------------------------------------------------------------

$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENTARCHIVE_CAPTION'] =  "<tr><td colspan='2' class='fcaption'>{---}</td></tr>";

$CALENDARBOOTSTRAP3_TEMPLATE['event']['archive_table_start'] = "<br /><table class='table fborder archive_table_start'>{EC_EVENTARCHIVE_CAPTION}";
$CALENDARBOOTSTRAP3_TEMPLATE['event']['archive_table'] = "
<tr>
	<td style='width:35%; vertical-align:top' class='forumheader3'>{EC_EVENT_RECENT_ICON}{EC_EVENTARCHIVE_DATE}</td>
	<td style='width:65%' class='forumheader3'>{EC_EVENTARCHIVE_HEADING}</td>
</tr>\n";
//<br />{EVENTARCHIVE_DETAILS}
$CALENDARBOOTSTRAP3_TEMPLATE['event']['archive_table_empty'] = "<tr><td colspan='2' class='forumheader3'>{EC_EVENTARCHIVE_EMPTY}</td></tr>\n";
$CALENDARBOOTSTRAP3_TEMPLATE['event']['archive_table_end'] = "</table>";

// EVENT SHOW EVENT ------------------------------------------------------------

$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_HEADING_DATE'] =  "{---}";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_DETAILS'] 			=  "<tr><td colspan='2' class='forumheader3'>{---}</td></tr>";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_LOCATION'] 		=  "<tr><td colspan='2' class='forumheader3'><b>".EC_LAN_32."</b>{---}</td></tr>";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_AUTHOR'] =  "<b>".EC_LAN_31."</b>{---}&nbsp;";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_CONTACT'] 			=  "<b>".EC_LAN_33."</b> {---}&nbsp;";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_THREAD'] 		=  "<tr><td colspan='2' class='forumheader3'><span class='smalltext'>".EC_LAN_32."</span></td></tr>";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_CATEGORY'] =  "<b>".EC_LAN_30."</b> {---}&nbsp;";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_DATE_START'] 			=  "{---}";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_TIME_START'] 		=  "{---}";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_DATE_END'] =  "{---}";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_EVENT_EVENT_DATE_TIME'] 			=  "<b>".EC_LAN_29."</b> {---}";
$CALENDARBOOTSTRAP3_WRAPPER['event']['EC_IFNOT_ALLDAY'] 		=  EC_LAN_144."{---}";

$CALENDARBOOTSTRAP3_TEMPLATE['event']['event_table_start'] = "<table class='table fborder event_table_start'>";
$CALENDARBOOTSTRAP3_TEMPLATE['event']['event_table_end'] = "</table>";

// The $EVENT_EVENT_DATETIME strings are used with the EC_EVENT_EVENT_DATE_TIME shortcode.
// There are four cases, each with a corresponding index into $EVENT_EVENT_DATETIME:
// 	0 - Normal event, starting and finishing on different dates (the 'original' default)
//	1 - Normal event, starting and finishing on the same day
//	2 - All-day event, starting and finishing on different days
//	3 - All-day event, starting and finishing on the same day
$CALENDARBOOTSTRAP3_TEMPLATE['event']['event_datetime'][0]  = "{EC_EVENT_DATE_START}".EC_LAN_144."{EC_EVENT_TIME_START}<b>  ".EC_LAN_69."</b> {EC_EVENT_DATE_END}{EC_IFNOT_ALLDAY=EC_EVENT_TIME_END}";
$CALENDARBOOTSTRAP3_TEMPLATE['event']['event_datetime'][1]  = "{EC_EVENT_DATE_START} ".EC_LAN_84." {EC_EVENT_TIME_START}".EC_LAN_85."{EC_EVENT_TIME_END}";
$CALENDARBOOTSTRAP3_TEMPLATE['event']['event_datetime'][2]  = "{EC_EVENT_DATE_START} <b>".EC_LAN_69."</b> {EC_EVENT_DATE_END}";
$CALENDARBOOTSTRAP3_TEMPLATE['event']['event_datetime'][3]  = "{EC_EVENT_DATE_START}";

$CALENDARBOOTSTRAP3_TEMPLATE['event']['event_table'] = " {SETIMAGE: w=100&h=100}  
<tr>
  <td >
	<a href='#{EC_EVENT_ID}' class='e-show-if-js e-expandit fcaption' style='display:inline-block; cursor:pointer; text-align:left; border:0px solid #000; width:100%' title='".EC_LAN_132."'>
	{EC_EVENT_RECENT_ICON}
	{EC_EVENT_CAT_ICON}
	{EC_EVENT_HEADING_DATE}{EC_IFNOT_ALLDAY=EC_EVENT_TIME_START}&nbsp;-&nbsp;{EC_EVENT_TITLE}</a>
	<div id='{EC_EVENT_ID}' {EC_EVENT_DISPLAYCLASS} style='padding-top:10px; padding-bottom:10px; text-align:left;'>
	  <table style='width:100%;'  cellspacing='0' cellpadding='0'>
		<tr><td colspan='2' class='forumheader3'>{EC_EVENT_AUTHOR} {EC_EVENT_CAT_ICON} {EC_EVENT_CATEGORY} {EC_EVENT_CONTACT} {EC_EVENT_OPTIONS}</td></tr>
		<tr><td colspan='2' class='forumheader3'>{EC_EVENT_EVENT_DATE_TIME}</td></tr>\n
		{EC_EVENT_LOCATION}
		{EC_EVENT_DETAILS}
		{EC_EVENT_THREAD}
	  </table>
	</div>
  </td>
</tr>\n
";


//------------------------------------------
// Calendar menu - 'Small' calendar
//------------------------------------------
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['hdg_link_class'] = "class='forumlink'";			// Class, and optional style, for menu heading if its a clickable link

$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['start'] = '<div class="e107 e107-mini-calendar  text-center">';
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['table_start'] =  '<table class="table table-striped table-bordered">';	 

$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['end'] = "</table></div>";

// Blank cells at beginning and end
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_non'] = "<td class='case2 text-center'><div>&nbsp;</div></td>";  

//header row
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['header_start'] = '
<tr class="e107-mini-calendar-header">';
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['header_front'] = '<th class="text-center">';
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['header_back'] = "</th>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['header_end'] = "</tr><tr>";


$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['weekswitch'] = "</tr><tr>";

// Start and end CSS for date cells - six cases to decode, determined by array index:
//    	1 - Today, no events
//		2 - Some other day, no events
//		3 - Today with events
//		4 - Some other day with events
//		5 - today with events, one or more of which has recently been added/updated
//		6 - Some other day with events, one or more of which has recently been added/updated
// all classes can be rewritten in css with .e107-mini-calendar .case1  ... selectors 
 
//today, no events
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_start']['1'] = "<td class='case1 text-center bg-warning'><div>";

// no events and not today
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_start']['2'] = "<td class='case2 text-center'><div>";

//day has events - same whether its today or not
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_start']['3'] = "<td class='case3 text-center'><div>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_start']['4'] = "<td class='case4 text-center bg-info'><div>";
// day has events, one which is recently added/updated
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_start']['5'] = "<td class='case5 text-center bg-danger'><div>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_start']['6'] = "<td class='case6 text-center bg-success'><div>";
// Example highlight using background colour:
//$CALENDAR_MENU_DAY_START['5'] = "<td class='indent' style='width:14.28%; padding:1px; text-align:center; background-color: #FF8000;'>";
//$CALENDAR_MENU_DAY_START['6'] = "<td class='indent' style='width:14.28%; padding:1px; text-align:center; background-color: #FF0000; '>";
 
 
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_end']['1'] = "</div></td>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_end']['2'] = "</div></td>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_end']['3'] = "</div></td>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_end']['4'] = "</div></td>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_end']['5'] = "</div></td>";
$CALENDARBOOTSTRAP3_TEMPLATE['calendar_menu']['day_end']['6'] = "</div></td>";

//============================================================================
// Next event menu template
$CALENDARBOOTSTRAP3_WRAPPER['next_event_menu']['EC_NEXT_EVENT_TIME'] = EC_LAN_144."{---}";
 

$CALENDARBOOTSTRAP3_TEMPLATE['next_event_menu']['cal_fe_line'] = "
{EC_NEXT_EVENT_RECENT_ICON}  
{EC_NEXT_EVENT_ICON: w=100}    
{EC_NEXT_EVENT_DATE}    
{EC_NEXT_EVENT_TIME}    
<br />
<strong>{EC_NEXT_EVENT_TITLE}</strong>
{EC_NEXT_EVENT_GAP}";
 
?>