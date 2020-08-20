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


if (!defined('e107_INIT')) {exit;}

require_once "../../../class2.php";

//load constants for front+admin
require_once "admin.class.php";

e107::lan("web_links", true);

require_once e_PLUGIN . 'web_links/web_links_defines.php';
require_once e_PLUGIN . 'web_links/admin/web_links_admin_functions.php';

class leftmenu_adminArea extends e_admin_dispatcher
{

    protected $modes = array(

        'main' => array(
            'controller' => 'links_prefs_ui',
            'path' => null,
            'ui' => 'links_prefs_form_ui',
            'uipath' => null,
        ),
        'links_categories' => array(
            'controller' => 'web_links_ui',
            'path' => null,
            'ui' => 'web_links_form_ui',
            'uipath' => null,
        ),
        'links_links' => array(
            'controller' => 'web_links_ui',
            'path' => null,
            'ui' => 'web_links_form_ui',
            'uipath' => null,
        ),
        'links_newlink' => array(
            'controller' => 'web_links_ui',
            'path' => null,
            'ui' => 'web_links_form_ui',
            'uipath' => null,
        ),

    );

    protected $adminMenuAliases = array(
    );

    protected $menuTitle = _WEBLINKS;

    public function init()
    {

        $db = e107::getDb();

        $links = $db->retrieve("SELECT COUNT(*) AS numrows FROM #" . UN_TABLENAME_LINKS_LINKS);

        // get actual data TODO move to e_dashboard ?

        $brokenl = $db->retrieve("SELECT COUNT(*) AS numrows FROM #" . UN_TABLENAME_LINKS_MODREQUEST . " WHERE brokenlink='1'");
        $modreql = $db->retrieve("SELECT COUNT(*) AS numrows FROM #" . UN_TABLENAME_LINKS_MODREQUEST . " WHERE brokenlink='0'");

        $this->adminMenu = array(
            'main/dashboard' => array(
                'caption' => 'Dashboard',
                'perm' => 'P',
                'url' => 'admin_config.php'),
            'main/prefs' => array(
                'caption' => LAN_PREFS,
                'perm' => 'P',
                'url' => 'admin_config.php'),
            'links_links/list' => array(
                'caption' => _WEBLINKS,
                'perm' => 'P',
                'url' => 'admin_links_links.php'),
            'links_categories/list' => array(
                'caption' => _ALLCATEGORIES,
                'perm' => 'P',
                'url' => 'admin_links_categories.php'),

            'Links' => array(
                'caption' => _WEBLINKSADMIN,
                'perm' => '0',
                'uri' => 'index.php?op=Links',
            ),

            'tools/opt1' => array(
                'header' => _WAITINGCONT),

            'links_newlink/list' => array(
                'caption' => _LINKSWAITINGVAL,
                'perm' => 'P',
                'badge' => array('value' => $num['numrows'], 'type' => 'default'),
                'url' => 'admin_links_newlink.php'),

            'LinksListModRequests' => array(
                'caption' => _LINKMODREQUEST,
                'perm' => 'P',
                'uri' => 'index.php?op=LinksListModRequests',
                'badge' => array('value' => $modreql['numrows'], 'type' => 'default'),
            ),
            'LinksListBrokenLinks' => array(
                'caption' => _BROKENLINKSREP,
                'perm' => 'P',
                'uri' => 'index.php?op=LinksListBrokenLinks',
                'badge' => array('value' => $brokenl['numrows'], 'type' => 'default'),
            ),

        );

        if ($num > 0) {
            $this->adminMenu['Links']['badge']['type'] = 'danger';
            $this->adminMenu['links_newlink/list']['badge']['type'] = 'danger';
        }

        if ($modreql > 0) {
            $this->adminMenu['LinksListModRequests']['badge']['type'] = 'danger';

        }
        if ($brokenl > 0) {
            $this->adminMenu['LinksListBrokenLinks']['badge']['type'] = 'danger';

        }

    }

}
