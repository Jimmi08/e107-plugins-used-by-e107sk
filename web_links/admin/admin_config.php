<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}
 
//load constants for front+admin
require_once('admin_leftmenu.php');



/**  l_config.php
 * Web_Links Preferences
**/
/*
# $perpage:			How many links to show on each page?
# $popular:			How many hits need a link to be listed as popular?
# $linksresults:		How many links to display on each search result page?
# $links_anonaddlinklock:	Lock Unregistered users from Suggesting New Links? (0=Yes 1=No)
# $anonwaitdays:		Number of days anonymous users need to wait to vote on a link
# $outsidewaitdays:		Number of days outside users need to wait to vote on a link (checks IP)
# $useoutsidevoting:		Allow Webmasters to put vote links on their site (1=Yes 0=No)
# $anonweight:			How many Unregistered User vote per 1 Registered User Vote?
# $outsideweight:		How many Outside User vote per 1 Registered User Vote?
# $detailvotedecimal:		Let Detailed Vote Summary Decimal out to N places. (no max)
# $mainvotedecimal:		Let Main Vote Summary Decimal show out to N places. (max 4)
# $toplinkspercentrigger:	1 to Show Top Links as a Percentage (else # of links)
# $toplinks:			Either # of links OR percentage to show (percentage as whole number. #/100)
# $mostpoplinkspercentrigger:	1 to Show Most Popular Links as a Percentage (else # of links)
# $mostpoplinks:		Either # of links OR percentage to show (percentage as whole number. #/100)
# $linkvotemin:			Number votes needed to make the 'top 10' list
# $blockunregmodify:		Block unregistered users from suggesting links changes? (1=Yes 0=No)
# $user_addlink:		Let registered users to add new link?
*/
 			
class links_prefs_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Web Links';
		protected $pluginName		= 'web_links';		
		protected $table			= '';
		protected $pid				= 'cid';
		protected $fields 			= array ();			
		protected $fieldpref 		= array();
		
	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'perpage'		=> array(
				'title'=> 'How many links to show on each page?[perpage]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'How many links to show on each page?'),
			'popular'		=> array(
				'title'=> 'How many hits need a link to be listed as popular? [popular]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'How many hits need a link to be listed as popular?'),
			'linksresults'		=> array(
				'title'=> 'How many links to display on each search result page? [linksresults]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'How many links to display on each search result page?'),
			'links_anonaddlinklock'		=> array(
				'title'=> 'Lock Unregistered users from Suggesting New Links? [links_anonaddlinklock]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Lock Unregistered users from Suggesting New Links? (0=Yes 1=No)'),
			'anonwaitdays'		=> array(
				'title'=> 'Number of days anonymous users need to wait to vote on a link [anonwaitdays]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Number of days anonymous users need to wait to vote on a link'),
			'outsidewaitdays'		=> array(
				'title'=> 'Number of days outside users need to wait to vote on a link [outsidewaitdays]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Number of days outside users need to wait to vote on a link (checks IP)'),
			'useoutsidevoting'		=> array(
				'title'=> 'Allow Webmasters to put vote links on their site [useoutsidevoting]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Allow Webmasters to put vote links on their site (1=Yes 0=No)'),
			'anonweight'		=> array(
				'title'=> 'How many Unregistered User vote per 1 Registered User Vote? [Anonweight]', 
				'tab'=>0, 'type'=>'number', 
				'data' => 'str', 
				'help'=>'How many Unregistered User vote per 1 Registered User Vote?'),
			'outsideweight'		=> array(
				'title'=> 'How many Outside User vote per 1 Registered User Vote? [outsideweight]', 
				'tab'=>0, 'type'=>'number', 
				'data' => 'str', 
				'help'=>'How many Outside User vote per 1 Registered User Vote?'),
			'detailvotedecimal'		=> array(
				'title'=> 'Let Detailed Vote Summary Decimal out to N places [detailvotedecimal]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Let Detailed Vote Summary Decimal out to N places. (no max)'),
			'mainvotedecimal'		=> array(
				'title'=> 'Let Main Vote Summary Decimal show out to N places [mainvotedecimal]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Let Main Vote Summary Decimal show out to N places. (max 4)'),
			'toplinkspercentrigger'		=> array(
				'title'=> '1 to Show Top Links as a Percentage [toplinkspercentrigger]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'1 to Show Top Links as a Percentage (else # of links)'),
			'toplinks'		=> array(
				'title'=> 'Either # of links OR percentage to show [toplinks]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Either # of links OR percentage to show (percentage as whole number. #/100)'),
			'mostpoplinkspercentrigger'		=> array(
				'title'=> '1 to Show Most Popular Links as a Percentage [mostpoplinkspercentrigger]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'1 to Show Most Popular Links as a Percentage (else # of links)'),
			'mostpoplinks'		=> array(
				'title'=> 'Either # of links OR percentage to show [mostpoplinks]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Either # of links OR percentage to show (percentage as whole number. #/100)'),
			'linkvotemin'		=> array(
				'title'=> 'Number votes needed to make the \'top 10\' list [linkvotemin]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Number votes needed to make the \'top 10\' list'),
			'blockunregmodify'		=> array(
				'title'=> 'Block unregistered users from suggesting links changes? [blockunregmodify]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Block unregistered users from suggesting links changes? (1=Yes 0=No)'),
			'user_addlink'		=> array(
				'title'=> 'Let registered users to add new link? [user_addlink]', 
				'tab'=>0, 
				'type'=>'number', 
				'data' => 'str', 
				'help'=>'Let registered users to add new link?'),
		); 
			
}
				


class links_prefs_form_ui extends e_admin_form_ui
{

}		
 
new leftmenu_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>