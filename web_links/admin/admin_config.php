<?php

// Generated e107 Plugin Admin Area

require_once '../../../class2.php';
if (!getperms('P'))
{
	e107::redirect('admin');
	exit;
}

//load constants for front+admin
require_once 'admin_leftmenu.php';

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

class links_prefs_ui extends plugin_admin_ui
{

	protected $pluginName = 'web_links';
	//	protected $eventName		= 'web_links-links_categories'; // remove comment to enable event triggers in admin.
	protected $table = '';
	protected $pid = 'cid';
	protected $fields = array();
	protected $fieldpref = array();

	protected $preftabs = array(LAN_SETTINGS, LAN_WEB_LINKS_VOTING, LAN_WEB_LINKS_POPULAR, LAN_WEB_LINKS_TOP);
	protected $prefs = array(
		'xanonymous' => array(
			'title' => _ANONYMOUSNAME,
			'tab' => 0,
			'type' => 'text',
			'data' => 'str',
			'writeParms' => array('default' => 'Anonymous'),
			'help' => 'If you let Anonymous vote, displayed name for them'),

		'perpage' => array(
			'title' => 'How many links to show on each page?',
			'tab' => 0,
			'type' => 'number',
			'data' => 'str',
			'help' => 'How many links to show on each page?'),
		'popular' => array(
			'title' => 'How many hits need a link to be listed as popular?',
			'tab' => 2,
			'type' => 'number',
			'data' => 'str',
			'help' => 'How many hits need a link to be listed as popular?'),
		'linksresults' => array(
			'title' => 'How many links to display on each search result page?',
			'tab' => 0,
			'type' => 'number',
			'data' => 'str',
			'help' => 'How many links to display on each search result page?'),
		'links_anonaddlinklock' => array(
			'title' => 'Lock Unregistered users from Suggesting New Links?',
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'str',
			'help' => 'Lock Unregistered users from Suggesting New Links? (0=Yes 1=No)'),
		'anonwaitdays' => array(
			'title' => 'Number of days anonymous users need to wait to vote on a link',
			'tab' => 1,
			'type' => 'number',
			'data' => 'str',
			'help' => 'Number of days anonymous users need to wait to vote on a link'),
		'outsidewaitdays' => array(
			'title' => 'Number of days outside users need to wait to vote on a link',
			'tab' => 1,
			'type' => 'number',
			'data' => 'str',
			'help' => 'Number of days outside users need to wait to vote on a link (checks IP)'),
		'useoutsidevoting' => array(
			'title' => 'Allow Webmasters to put vote links on their site?',
			'tab' => 1,
			'type' => 'boolean',
			'data' => 'str',
			'help' => 'Allow Webmasters to put vote links on their site (1=Yes 0=No)'),
		'anonweight' => array(
			'title' => 'How many Unregistered User vote per 1 Registered User Vote?',
			'tab' => 1, 'type' => 'number',
			'data' => 'str',
			'help' => 'How many Unregistered User vote per 1 Registered User Vote?'),
		'outsideweight' => array(
			'title' => 'How many Outside User vote per 1 Registered User Vote?',
			'tab' => 1, 'type' => 'number',
			'data' => 'str',
			'help' => 'How many Outside User vote per 1 Registered User Vote?'),
		'detailvotedecimal' => array(
			'title' => 'Let Detailed Vote Summary Decimal out to N places',
			'tab' => 1,
			'type' => 'number',
			'data' => 'str',
			'help' => 'Let Detailed Vote Summary Decimal out to N places. (no max)'),
		'mainvotedecimal' => array(
			'title' => 'Let Main Vote Summary Decimal show out to N places',
			'tab' => 1,
			'type' => 'number',
			'data' => 'str',
			'help' => 'Let Main Vote Summary Decimal show out to N places. (max 4)'),
		'toplinkspercentrigger' => array(
			'title' => 'Show Top Links as a Percentage',
			'tab' => 3,
			'type' => 'boolean',
			'data' => 'str',
			'help' => 'Show Top Links as a Percentage (else # of links)'),
		'toplinks' => array(
			'title' => 'Either # of links OR percentage to show',
			'tab' => 3,
			'type' => 'boolean',
			'data' => 'str',
			'help' => 'Either # of links OR percentage to show (percentage as whole number. #/100)'),
		'mostpoplinkspercentrigger' => array(
			'title' => 'Show Most Popular Links as a Percentage',
			'tab' => 2,
			'type' => 'boolean',
			'data' => 'str',
			'help' => 'Show Most Popular Links as a Percentage (else # of links)'),
		'mostpoplinks' => array(
			'title' => 'Either # of links OR percentage to show',
			'tab' => 0,
			'type' => 'number',
			'data' => 'str',
			'help' => 'Either # of links OR percentage to show (percentage as whole number. #/100)'),
		'linkvotemin' => array(
			'title' => 'Number votes needed to make the \'top 10\' list',
			'tab' => 3,
			'type' => 'number',
			'data' => 'str',
			'help' => 'Number votes needed to make the \'top 10\' list'),
		'blockunregmodify' => array(
			'title' => 'Block unregistered users from suggesting links changes?',
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'str',
			'help' => 'Block unregistered users from suggesting links changes? (1=Yes 0=No)'),
		'user_addlink' => array(
			'title' => 'Let registered users to add new link?',
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'int',
			'help' => 'Let registered users to add new link?'),

	);

	public function init()
	{
		//Don't confuse other users for now
		if (false)
		{
			$this->preftabs[4] = "UnNuke Support";
			$this->prefs['use_unnuke'] = array(
				'title' => 'Use UnNuke Tables?',
				'tab' => 4,
				'type' => 'boolean',
				'data' => 'int',
				'help' => 'If yes, UnNuke prefixes are used for tables. Those tables have to already exists and they have e107 prefix too.  ');
			$this->prefs['unnuke_prefix'] = array(
				'title' => 'UnNuke Table prefix ',
				'tab' => 4,
				'type' => 'text',
				'data' => 'str',
				'help' => 'UnNuke prefix with _ (for example: unnuke_) !');
			$this->prefs['unnuke_user_prefix'] = array(
				'title' => 'UnNuke User Table prefix ',
				'tab' => 4,
				'type' => 'text',
				'data' => 'str',
				'help' => 'UnNuke User prefix with _ (for example: unnuke_) !');
		}
	}
}

class links_prefs_form_ui extends e_admin_form_ui
{

}

new leftmenu_adminArea();

require_once e_ADMIN . "auth.php";

e107::getRender()->tablerender('', AdminHeader());
e107::getAdminUI()->runPage();

require_once e_ADMIN . "footer.php";
exit;

?>