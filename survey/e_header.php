<?php

if (!defined('e107_INIT'))
{ 
	require_once("../../class2.php");
}


if (!e107::isInstalled('survey'))
{
	e107::redirect();
	exit;
}

if(USER_AREA)
{
	e107::js('survey','js/survey_cal.min.js');
	e107::css('survey','css/survey_cal.min.css');
	//TODO: ?check if rate type is used at all
	e107::js('core', 'rate/js/jquery.raty.js', 'jquery', 2);
}

if(ADMIN_AREA)
{
	e107::js('survey','js/survey.min.js');
}

if(USER_AREA && (strpos(e_REQUEST_URI, 'survey') !== false))
{
	$tmp = explode(".", e_QUERY);   // $tmp, because $qs is used
	if(is_numeric($tmp[0]))  // legacy url
	{
		define('e_PAGETITLE', 'Surveys' );
	}
	else
	{
	  $tp = e107::getParser();
		$survey_url = $tmp[0];	 // At least one parameter here
		$where = 'survey_url ="'.$survey_url.'"';  
		$pagetitle =   e107::getDB()->retrieve('survey', 'survey_slogan', $where);
		$pagetitle =   $tp->toText($pagetitle, false, 'TITLE');

		define('e_PAGETITLE', $pagetitle );
	}
}			
			
?>
