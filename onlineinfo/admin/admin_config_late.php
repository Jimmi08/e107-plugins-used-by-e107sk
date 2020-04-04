<?php
/*
+---------------------------------------------------------------+
|	e107 website system
|
|	Released under the terms and conditions of the
|	GNU General Public License (http://gnu.org).
|
+---------------------------------------------------------------+
*/
require_once ('../../../class2.php');

global $pref;

if (!getperms('P'))
{
	e107::redirect('admin');
	exit;
}

// e107::lan('onlineinfo',true);

require_once ("admin_menu.php");

include_lan(e_PLUGIN . 'list_new/languages/' . e_LANGUAGE . '.php');
$lan_file = e_PLUGIN . 'onlineinfo/languages/admin_' . e_LANGUAGE . '.php';
include_once (file_exists($lan_file) ? $lan_file : e_PLUGIN . 'onlineinfo/languages/admin_English.php');

include_once (file_exists($lan_file) ? $lan_file : e_PLUGIN . 'onlineinfo/languages/admin_English.php');

include_once (e_PLUGIN . 'onlineinfo/functions.php');

$sql = e107::getDb();


 
if (IsSet($_POST['update_menu']))
{
	if ($_POST['onlineinfo_showupdates'] == e_UC_PUBLIC)
	{
		$_POST['onlineinfo_showupdates'] = e_UC_MEMBER;
	}

 
 
	$pref['onlineinfo_downloads'] = $_POST['onlineinfo_downloads'];
	$pref['onlineinfo_new_icon'] = $_POST['onlineinfo_new_icon'];
	$pref['onlineinfo_new_icontype'] = $_POST['onlineinfo_new_icontype'];
	$pref['onlineinfo_hideadminarea'] = $_POST['onlineinfo_hideadminarea'];
	$pref['onlineinfo_content'] = $_POST['onlineinfo_content'];
	$pref['onlineinfo_chatnum'] = $_POST['onlineinfo_chatnum'];
	$pref['onlineinfo_forumnum'] = $_POST['onlineinfo_forumnum'];
	$pref['onlineinfo_downloadnum'] = $_POST['onlineinfo_downloadnum'];
 
 
	$pref['onlineinfo_commentsnum'] = $_POST['onlineinfo_commentsnum'];
 
	$pref['onlineinfo_linksnum'] = $_POST['onlineinfo_linksnum'];
	$pref['onlineinfo_usersnum'] = $_POST['onlineinfo_usersnum'];
	$pref['onlineinfo_newsnum'] = $_POST['onlineinfo_newsnum'];
	$pref['onlineinfo_contentsnum'] = $_POST['onlineinfo_contentsnum'];
	$pref['onlineinfo_whatsnewtype'] = $_POST['onlineinfo_whatsnewtype'];
	$pref['onlineinfo_flashtext'] = $_POST['onlineinfo_flashtext'];
	$pref['onlineinfo_flashtext_colour'] = $_POST['onlineinfo_flashtext_colour'];
	$pref['onlineinfo_chatbox'] = $_POST['onlineinfo_chatbox'];
	$pref['onlineinfo_hideadmin'] = $_POST['onlineinfo_hideadmin'];
	$pref['onlineinfo_hideregusers'] = $_POST['onlineinfo_hideregusers'];
	$pref['onlineinfo_showregusers'] = $_POST['onlineinfo_showregusers'];
	$pref['onlineinfo_shownews'] = $_POST['onlineinfo_shownews'];
	$pref['onlineinfo_youtubenum'] = $_POST['onlineinfo_youtubenum'];
	$pref['onlineinfo_youtube'] = $_POST['onlineinfo_youtube'];
	$pref['onlineinfo_kroozearcade'] = $_POST['onlineinfo_kroozearcade'];
	$pref['onlineinfo_kroozearcadenum'] = $_POST['onlineinfo_kroozearcadenum'];
	$pref['onlineinfo_kroozearcadetop'] = $_POST['onlineinfo_kroozearcadetop'];
	$pref['onlineinfo_kroozearcadetopnum'] = $_POST['onlineinfo_kroozearcadetopnum'];
	$pref['onlineinfo_links'] = $_POST['onlineinfo_links'];
	$pref['onlineinfo_members'] = $_POST['onlineinfo_members'];
	$pref['onlineinfo_hideifnonew'] = $_POST['onlineinfo_hideifnonew'];
	$pref['onlineinfo_joke'] = $_POST['onlineinfo_joke'];
	$pref['onlineinfo_jokenum'] = $_POST['onlineinfo_jokenum'];
	$pref['onlineinfo_blog'] = $_POST['onlineinfo_blog'];
	$pref['onlineinfo_blognum'] = $_POST['onlineinfo_blognum'];
	$pref['onlineinfo_suggestions'] = $_POST['onlineinfo_suggestions'];
	$pref['onlineinfo_suggestionsnum'] = $_POST['onlineinfo_suggestionsnum'];
	$pref['onlineinfo_showcomments'] = $_POST['onlineinfo_showcomments'];
	save_prefs();
	e107::getPlugConfig('onlineinfo')->setPref($pref)->save();
	$ns->tablerender('', '<div style="text-align:center"><b>' . ONLINEINFO_LOGIN_MENU_A1 . ' ( ' . ONLINEINFO_LOGIN_MENU_A76 . ' )</b></div>');
}

class onlineinfo_late_adminArea extends onlineinfomenu_adminArea

{
	protected $modes = array(
		'latestchanges' => array(
			'controller' => 'onlineinfo_late_ui',
			'path' => null,
			'ui' => 'onlineinfo_late_form_ui',
			'uipath' => null
		) ,
	);
}

class onlineinfo_late_ui extends e_admin_ui

{
	protected $pluginTitle = ONLINEINFO_LOGIN_MENU_A2;
	protected $pluginName = 'onlineinfo';

	// optional - a custom page.

	public function SettingsPage()
	{
		include_once (e_PLUGIN . 'onlineinfo/functions.php');

		$sql = e107::getDb(); 
   
    $islistinstalled = e107::isInstalled('list_new');
    
		$plugPref = e107::pref('onlineinfo');

 
		$onlineinfo_downloads = $plugPref['onlineinfo_downloads'];
		$onlineinfo_new_icon = $plugPref['onlineinfo_new_icon'];
		$onlineinfo_new_icontype = $plugPref['onlineinfo_new_icontype'];
		$onlineinfo_hideadminarea = $plugPref['onlineinfo_hideadminarea'];
		$onlineinfo_content = $plugPref['onlineinfo_content'];
		$onlineinfo_chatnum = $plugPref['onlineinfo_chatnum'];
		$onlineinfo_forumnum = $plugPref['onlineinfo_forumnum'];
		$onlineinfo_downloadnum = $plugPref['onlineinfo_downloadnum'];
 
		$onlineinfo_commentsnum = $plugPref['onlineinfo_commentsnum'];
		$onlineinfo_linksnum = $plugPref['onlineinfo_linksnum'];
		$onlineinfo_usersnum = $plugPref['onlineinfo_usersnum'];
		$onlineinfo_newsnum = $plugPref['onlineinfo_newsnum'];
		$onlineinfo_contentsnum = $plugPref['onlineinfo_contentsnum'];
		$onlineinfo_whatsnewtype = $plugPref['onlineinfo_whatsnewtype'];
		$onlineinfo_flashtext = $plugPref['onlineinfo_flashtext'];
		$onlineinfo_flashtext_colour = $plugPref['onlineinfo_flashtext_colour'];
		$onlineinfo_chatbox = $plugPref['onlineinfo_chatbox'];
		$onlineinfo_forum = $plugPref['onlineinfo_forum'];
		$onlineinfo_hideadmin = $plugPref['onlineinfo_hideadmin'];
		$onlineinfo_hideregusers = $plugPref['onlineinfo_hideregusers'];
		$onlineinfo_showregusers = $plugPref['onlineinfo_showregusers'];
		$onlineinfo_youtubenum = $plugPref['onlineinfo_youtubenum'];
		$onlineinfo_youtube = $plugPref['onlineinfo_youtube'];
		$onlineinfo_shownews = $plugPref['onlineinfo_shownews'];
		$onlineinfo_kroozearcadenum = $plugPref['onlineinfo_kroozearcadenum'];
		$onlineinfo_kroozearcade = $plugPref['onlineinfo_kroozearcade'];
		$onlineinfo_kroozearcadetopnum = $plugPref['onlineinfo_kroozearcadetopnum'];
		$onlineinfo_kroozearcadetop = $plugPref['onlineinfo_kroozearcadetop'];
		$onlineinfo_links = $plugPref['onlineinfo_links'];
		$onlineinfo_members = $plugPref['onlineinfo_members'];
		$onlineinfo_hideifnonew = $plugPref['onlineinfo_hideifnonew'];

		// added 8.5.0

		$onlineinfo_joke = $plugPref['onlineinfo_joke'];
		$onlineinfo_jokenum = $plugPref['onlineinfo_jokenum'];
		$onlineinfo_blog = $plugPref['onlineinfo_blog'];
		$onlineinfo_blognum = $plugPref['onlineinfo_blognum'];
		$onlineinfo_suggestions = $plugPref['onlineinfo_suggestions'];
		$onlineinfo_suggestionsnum = $plugPref['onlineinfo_suggestionsnum'];
		$onlineinfo_showcomments = $plugPref['onlineinfo_showcomments'];
		$text = '<div style="text-align:center">
<form method="POST" action="' . e_REQUEST_URL . '" name="menu_conf_form">
<table class="fborder">';

		// check for plugins installed and active
    
 
		$ischatboxinstalled = e107::isInstalled('chatbox_menu');
		$isforuminstalled = e107::isInstalled('forum');
		$isyoutubeinstalled = e107::isInstalled('ytm_gallery');
		$iskroozearcadeinstalled = e107::isInstalled('kroozearcade_menu');
		$islinkpageinstalled = e107::isInstalled('links_page');
		$isjokeinstalled = e107::isInstalled('jokes_menu');
		$isbloginstalled = e107::isInstalled('userjournals_menu');
		$issuggestioninstalled = e107::isInstalled('suggestions_menu');
    
		$text.= '<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A107 . '</td>
<td class="forumheader3" colspan="4">';
		if ($onlineinfo_whatsnewtype == '1')
		{
			$text.= ONLINEINFO_LOGIN_MENU_A108 . '<input type="radio"  name="onlineinfo_whatsnewtype" value="1" checked />&nbsp;&nbsp;&nbsp;';
			$text.= ONLINEINFO_LOGIN_MENU_A109 . '<input type="radio"  name="onlineinfo_whatsnewtype" value="0"';
			if ($islistinstalled == 1)
			{
				$text.= ' />';
			}
			else
			{
				$text.= ' disabled />';
			}
		}
		else
		{
			if ($islistinstalled == 1)
			{
				$text.= ONLINEINFO_LOGIN_MENU_A108 . '<input type="radio"  name="onlineinfo_whatsnewtype" value="1" />&nbsp;&nbsp;&nbsp;';
				$text.= ONLINEINFO_LOGIN_MENU_A109 . '<input type="radio"  name="onlineinfo_whatsnewtype" value="0" checked />';
			}
			else
			{
				$text.= ONLINEINFO_LOGIN_MENU_A108 . '<input type="radio"  name="onlineinfo_whatsnewtype" value="1" checked />&nbsp;&nbsp;&nbsp;';
				$text.= ONLINEINFO_LOGIN_MENU_A109 . '<input type="radio"  name="onlineinfo_whatsnewtype" value="0" disabled />';
			}
		}

		$text.= '</td>
</tr>
<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A68 . '</td>
<td class="forumheader3" colspan="3">' . r_userclass('onlineinfo_showregusers', $onlineinfo_showregusers) . '</td>

</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A123 . '</td>
<td class="forumheader3" colspan="3">' . Create_yes_no_dropdown('onlineinfo_hideregusers', $onlineinfo_hideregusers) . '</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A12 . '</td>
<td class="forumheader3" colspan="3">' . Create_yes_no_dropdown('onlineinfo_flashtext', $onlineinfo_flashtext) . '
&nbsp;&nbsp;&nbsp;' . ONLINEINFO_LOGIN_MENU_A13 . Create_colour_dropdown('onlineinfo_flashtext_colour', $onlineinfo_flashtext_colour) . '
</td>
</tr>


<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A23 . '</td>
<td class="forumheader3">' . Create_yes_no_dropdown('onlineinfo_new_icon', $onlineinfo_new_icon) . '</td>';
		if ($onlineinfo_new_icontype == 'new.gif')
		{
			$text.= '<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A24 . '<br /><span class="smalltext">' . ONLINEINFO_LOGIN_MENU_A25 . '</span></td>
<td class="forumheader3"><input type="radio"  name="onlineinfo_new_icontype" value="new.gif" checked />&nbsp;<img src="' . e_PLUGIN . 'onlineinfo/images/new.gif" />' . ONLINEINFO_LOGIN_MENU_A26 . '<br /><input type="radio"  name="onlineinfo_new_icontype" value="new2.gif"/>&nbsp;<img src="' . e_PLUGIN . 'onlineinfo/images/new2.gif" />' . ONLINEINFO_LOGIN_MENU_A27 . '</td>';
		}
		else
		{
			$text.= '<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A24 . '<br /><span class="smalltext">' . ONLINEINFO_LOGIN_MENU_A25 . '</span></td>
<td class="forumheader3"><input type="radio"  name="onlineinfo_new_icontype" value="new.gif"/>&nbsp;<img src="' . e_PLUGIN . 'onlineinfo/images/new.gif" />' . ONLINEINFO_LOGIN_MENU_A26 . '<br /><input type="radio"  name="onlineinfo_new_icontype" value="new2.gif" checked />&nbsp;<img src="' . e_PLUGIN . 'onlineinfo/images/new2.gif" />' . ONLINEINFO_LOGIN_MENU_A27 . '</td>';
		}

		$text.= '</tr>
<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A177 . '</td>
<td class="forumheader3" colspan="4">' . Create_yes_no_dropdown('onlineinfo_hideifnonew', $onlineinfo_hideifnonew) . '<span class="smalltext">' . ONLINEINFO_LOGIN_MENU_A178 . '</span></td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A63 . '</td>
<td class="forumheader3" colspan="3">' . Create_yes_no_dropdown('onlineinfo_hideadminarea', $onlineinfo_hideadminarea) . '&nbsp;&nbsp;&nbsp;' . ONLINEINFO_LOGIN_MENU_A122 . Create_yes_no_dropdown('onlineinfo_hideadmin', $onlineinfo_hideadmin) . '
</td>
</tr>

<tr><td class="forumheader3" colspan="5" style="font-style: italic;">' . ONLINEINFO_LOGIN_MENU_A171 . '</td></tr>

<tr>
<td class="forumheader" colspan="5" style="text-align:center; font-weight:bold;">' . ONLINEINFO_LOGIN_MENU_A89 . '</td>
</tr>

<tr>
<td class="forumheader3" style="text-align:center; font-weight:bold;">' . ONLINEINFO_LOGIN_MENU_A199 . '</td>
<td class="forumheader3" style="text-align:center; font-weight:bold;">' . ONLINEINFO_LOGIN_MENU_A200 . '</td>
<td class="forumheader3" style="text-align:center; font-weight:bold;">' . ONLINEINFO_LOGIN_MENU_A201 . '</td>
<td class="forumheader3" style="text-align:center; font-weight:bold;">' . ONLINEINFO_LOGIN_MENU_A176 . '</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A153 . '</td>
<td class="forumheader3">' . Create_yes_no_dropdown('onlineinfo_shownews', $onlineinfo_shownews) . '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_newsnum" size="4" value="' . $onlineinfo_newsnum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A67 . '</td>
<td class="forumheader3">' . Create_yes_no_dropdown('onlineinfo_content', $onlineinfo_content) . '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_contentsnum" size="4" value="' . $onlineinfo_contentsnum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A14 . '</td>

<td class="forumheader3">';
		if ($ischatboxinstalled == 1)
		{
			$text.= Create_yes_no_dropdown('onlineinfo_chatbox', $onlineinfo_chatbox);
		}
		else
		{
			$text.= Create_no_dropdown('onlineinfo_chatbox', '0');
		}

		$text.= '</td>

<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_chatnum" size="4" value="' . $onlineinfo_chatnum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

 

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A121 . '</td>
<td class="forumheader3">
';
		if ($isforuminstalled == 1)
		{
			$text.= Create_yes_no_dropdown('onlineinfo_forum', $onlineinfo_forum);
		}
		else
		{
			$text.= Create_no_dropdown('onlineinfo_forum', '0');
		}

		$text.= '</td>

<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_forumnum" size="4" value="' . $onlineinfo_forumnum . '" maxlength="4" /></td>';
		$text.= '</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A28 . '</td>
<td class="forumheader3">' . Create_yes_no_dropdown('onlineinfo_downloads', $onlineinfo_downloads) . '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_downloadnum" size="4" value="' . $onlineinfo_downloadnum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

 

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A155 . '</td>

<td class="forumheader3">';
		if ($isyoutubeinstalled == 1)
		{
			$text.= Create_yes_no_dropdown('onlineinfo_youtube', $onlineinfo_youtube);
		}
		else
		{
			$text.= Create_no_dropdown('onlineinfo_youtube', '0');
		}

		$text.= '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_youtubenum" size="4" value="' . $onlineinfo_youtubenum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A165 . '</td>
<td class="forumheader3">
';
		if ($iskroozearcadeinstalled == 1)
		{
			$text.= Create_yes_no_dropdown('onlineinfo_kroozearcade', $onlineinfo_kroozearcade);
		}
		else
		{
			$text.= Create_no_dropdown('onlineinfo_kroozearcade', '0');
		}

		$text.= '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_kroozearcadenum" size="4" value="' . $onlineinfo_kroozearcadenum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A166 . '</td>

<td class="forumheader3">';
		if ($iskroozearcadeinstalled == 1)
		{
			$text.= Create_yes_no_dropdown('onlineinfo_kroozearcadetop', $onlineinfo_kroozearcadetop);
		}
		else
		{
			$text.= Create_no_dropdown('onlineinfo_kroozearcadetop', '0');
		}

		$text.= '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_kroozearcadetopnum" size="4" value="' . $onlineinfo_kroozearcadetopnum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A169 . '</td>

<td class="forumheader3">';
		if ($islinkpageinstalled == 1)
		{
			$text.= Create_yes_no_dropdown('onlineinfo_links', $onlineinfo_links);
		}
		else
		{
			$text.= Create_no_dropdown('onlineinfo_links', '0');
		}

		$text.= '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_linksnum" size="4" value="' . $onlineinfo_linksnum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A170 . '</td>
<td class="forumheader3">' . Create_yes_no_dropdown('onlineinfo_members', $onlineinfo_members) . '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_usersnum" size="4" value="' . $onlineinfo_usersnum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

 

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A194 . '</td>

<td class="forumheader3">';
		if ($isjokeinstalled == 1)
		{
			$text.= Create_yes_no_dropdown('onlineinfo_joke', $onlineinfo_joke);
		}
		else
		{
			$text.= Create_no_dropdown('onlineinfo_joke', '0');
		}

		$text.= '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_jokenum" size="4" value="' . $onlineinfo_jokenum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A196 . '</td>

<td class="forumheader3">';
		if ($isbloginstalled == 1)
		{
			$text.= Create_yes_no_dropdown('onlineinfo_blog', $onlineinfo_blog);
		}
		else
		{
			$text.= Create_no_dropdown('onlineinfo_blog', '0');
		}

		$text.= '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_blognum" size="4" value="' . $onlineinfo_blognum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A198 . '</td>

<td class="forumheader3">';
		if ($issuggestioninstalled == 1)
		{
			$text.= Create_yes_no_dropdown('onlineinfo_suggestions', $onlineinfo_suggestions);
		}
		else
		{
			$text.= Create_no_dropdown('onlineinfo_suggestions', '0');
		}

		$text.= '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_suggestionsnum" size="4" value="' . $onlineinfo_suggestionsnum . '" maxlength="4" /></td>
<td class="forumheader3">&nbsp;</td>
</tr>

<tr>
<td class="forumheader3">' . ONLINEINFO_LOGIN_MENU_A95 . '</td>
<td class="forumheader3">' . Create_yes_no_dropdown('onlineinfo_showcomments', $onlineinfo_showcomments) . '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_commentsnum" size="4" value="' . $onlineinfo_commentsnum . '" maxlength="4" /></td>
<td class="forumheader3" style="text-style:italic;">' . ONLINEINFO_LOGIN_MENU_A202 . '</td>
</tr>

<tr>
<td colspan="6" class="forumheader" style="text-align:center"><input class="button" type="submit" name="update_menu" value="' . ONLINEINFO_LOGIN_MENU_A56 . '" /></td>
</tr>
</table>
</form>
</div>';
		return $text;
	}
}

class onlineinfo_late_form_ui extends e_admin_form_ui

{
}

new onlineinfo_late_adminArea();
require_once (e_ADMIN . "auth.php");

e107::getAdminUI()->runPage('settings');
require_once (e_ADMIN . "footer.php");

exit;
 

 