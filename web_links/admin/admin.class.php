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

e107::lan("web_links", "lang_admin");

class plugin_admin_ui extends e_admin_ui
{
    protected $pluginName = 'web_links';
    protected $pluginTitle = _WEBLINKSADMIN;

    protected $perPage = 30;
 
 
    public function renderHelp()
    {
        $tp = e107::getParser();
        $hide_help = e107::isInstalled('unnuke_admin');
        if ($hide_help) {
            $text = '<ul class="list-unstyled text-center">
			<li><b>' . LAN_UN_LINKS_WEBLINKS . '</b></li>
			<li> ' . $tp->toHTML(LAN_UN_MAT_WEBLINKS, true) . ' </li></ul>';

            return array('caption' => LAN_UN_LINKS_WEBLINKS, 'text' => $text);
        }
        $text = '<ul class="list-unstyled text-center">
				<li><b>' . LAN_UN_LINKS_WEBLINKS . '</b></li>
				<li> ' . $tp->toHTML(LAN_UN_MAT_WEBLINKS, true) . ' </li>
				<li style="border-bottom: solid 1px dimgrey" class="divider">&nbsp;</li>
				<li>
					<h5>' . e107::getParser()->toGlyph('fa-heart') . '&nbsp;Thank the Developer!</h5>
				</li>
				<li>
					<p>
						<small>If you think this plugin is useful, please consider supporting what I do.</small>
					</p>
				</li>
				<li class="text-center">
					<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FKG5N3F6QL99J" rel="nofollow">
					<img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="Paypal" style="max-width:100%;"></a>
				</li>


				<li class="text-center">
					<p>
						<small>Thank you</small>
					 ' . e107::getParser()->toGlyph('fa-smile-o') . '</p>
				</li>
			</ul> ';

        return array('caption' => LAN_UN_LINKS_WEBLINKS, 'text' => $text);
    }

}
