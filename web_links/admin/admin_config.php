<?php    
/*
* e107 website system
*
* Copyright (C) 2008-2013 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* e107 Web Links Plugin
*
* #######################################
* #     e107 website system plugin      #
* #     by Jimako                    	 #
* #     https://www.e107sk.com          #
* #######################################
*/ 

/**
  * UNITED-NUKE CMS: Just Manage!
  * http://united-nuke.openland.cz/
  * http://united-nuke.openland.cz/forums/
  *
  * 2002 - 2005, (c) Jiri Stavinoha
  * http://united-nuke.openland.cz/weblog/
  *
  * Translation to English language
  * http://axlsystems.amjawa.com/ - 2005, (c) Roman Vosicky
  *  
  * Portions of this software are based on PHP-Nuke
  * http://phpnuke.org - 2002, (c) Francisco Burzi
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
**/


require_once '../../../class2.php';
if (!getperms('P')) {
    e107::redirect('admin');
    exit;
}

//load constants for front+admin
require_once 'admin_leftmenu.php';

/**  l_config.php
 * Web_Links Preferences
 **/
/*
# $perpage:            How many links to show on each page?
# $popular:            How many hits need a link to be listed as popular?
# $linksresults:        How many links to display on each search result page?
# $links_anonaddlinklock:    Lock Unregistered users from Suggesting New Links? (0=Yes 1=No)
# $anonwaitdays:        Number of days anonymous users need to wait to vote on a link
# $outsidewaitdays:        Number of days outside users need to wait to vote on a link (checks IP)
# $useoutsidevoting:        Allow Webmasters to put vote links on their site (1=Yes 0=No)
# $anonweight:            How many Unregistered User vote per 1 Registered User Vote?
# $outsideweight:        How many Outside User vote per 1 Registered User Vote?
# $detailvotedecimal:        Let Detailed Vote Summary Decimal out to N places. (no max)
# $mainvotedecimal:        Let Main Vote Summary Decimal show out to N places. (max 4)
# $toplinkspercentrigger:    1 to Show Top Links as a Percentage (else # of links)
# $toplinks:            Either # of links OR percentage to show (percentage as whole number. #/100)
# $mostpoplinkspercentrigger:    1 to Show Most Popular Links as a Percentage (else # of links)
# $mostpoplinks:        Either # of links OR percentage to show (percentage as whole number. #/100)
# $linkvotemin:            Number votes needed to make the 'top 10' list
# $blockunregmodify:        Block unregistered users from suggesting links changes? (1=Yes 0=No)
# $user_addlink:        Let registered users to add new link?
 */

class links_prefs_ui extends plugin_admin_ui
{

    protected $pluginName = 'web_links';
    //    protected $eventName        = 'web_links-links_categories'; // remove comment to enable event triggers in admin.
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
    // optional - a custom page.
    public function dashboardPage()
    {
        $ns = e107::getRender();

        $iconlist = e107::getNav()->adminLinks();

        //    $ns->setStyle('flexpanel');
        $mainPanel = "<div id='core-infopanel_mye107'>";
        $mainPanel .= "<div class='left'>";

        e107::getRender()->tablerender('', AdminHeader());

        $mainPanel .= "</div></div>";

        return $mainPanel;

    }
}

class links_prefs_form_ui extends e_admin_form_ui
{

}

new leftmenu_adminArea();

require_once e_ADMIN . "auth.php";

e107::getAdminUI()->runPage();

require_once e_ADMIN . "footer.php";
exit;
