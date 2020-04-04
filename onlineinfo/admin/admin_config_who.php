<?php

// Generated e107 Plugin Admin Area

require_once ('../../../class2.php');
global $pref;


if (!getperms('P'))
{
	e107::redirect('admin');
	exit;
}

// e107::lan('onlineinfo',true);

require_once ("admin_menu.php");

$lan_file = e_PLUGIN . 'onlineinfo/languages/admin_' . e_LANGUAGE . '.php';
include_once (file_exists($lan_file) ? $lan_file : e_PLUGIN . 'onlineinfo/languages/admin_English.php');

if(IsSet($_POST['update_menu'])){
        
$pref['onlineinfo_border']=$_POST['onlineinfo_border'];
$pref['onlineinfo_color']=$_POST['onlineinfo_color'];
$pref['onlineinfo_avatar']=$_POST['onlineinfo_avatar'];
$pref['onlineinfo_showicons']=$_POST['onlineinfo_showicons'];
$pref['onlineinfo_showadmin']=$_POST['onlineinfo_showadmin'];
$pref['onlineinfo_guest']=$_POST['onlineinfo_guest'];
$pref['onlineinfo_hideguest']=$_POST['onlineinfo_hideguest'];
$pref['onlineinfo_hideusers']=$_POST['onlineinfo_hideusers'];
$pref['onlineinfo_usernamefontsize']=$_POST['onlineinfo_usernamefontsize'];
$pref['onlineinfo_botchecker']=$_POST['onlineinfo_botchecker'];
$pref['onlineinfo_ipchecker']=$_POST['onlineinfo_ipchecker'];
$pref['onlineinfo_nolocations']=$_POST['onlineinfo_nolocations'];
  
              
save_prefs('core');
e107::getPlugConfig('onlineinfo')->setPref($pref)->save();
 

}

class onlineinfo_who_adminArea extends onlineinfomenu_adminArea

{
	protected $modes = array(
		'who' => array(
			'controller' => 'onlineinfo_who_ui',
			'path' => null,
			'ui' => 'onlineinfo_who_form_ui',
			'uipath' => null
		) ,
	);
	
}

class onlineinfo_who_ui extends e_admin_ui

{
	protected $pluginTitle = ONLINEINFO_LOGIN_MENU_A2;
	protected $pluginName = 'onlineinfo';
 
		// optional - a custom page.  
		public function SettingsPage()
		{
    
    include_once(e_PLUGIN.'onlineinfo/functions.php');
    
    $plugPref =  e107::pref('onlineinfo');
 
$onlineinfo_border = $plugPref['onlineinfo_border'];
$onlineinfo_color = $plugPref['onlineinfo_color'];
$onlineinfo_avatar = $plugPref['onlineinfo_avatar'];
$onlineinfo_showicons = $plugPref['onlineinfo_showicons'];
$onlineinfo_showadmin = $plugPref['onlineinfo_showadmin'];
$onlineinfo_guest = $plugPref['onlineinfo_guest'];
$onlineinfo_hideguest = $plugPref['onlineinfo_hideguest'];
$onlineinfo_hideusers = $plugPref['onlineinfo_hideusers'];
$onlineinfo_usernamefontsize = $plugPref['onlineinfo_usernamefontsize'];
$onlineinfo_botchecker = $plugPref['onlineinfo_botchecker'];
$onlineinfo_ipchecker = $plugPref['onlineinfo_ipchecker'];
$onlineinfo_nolocations = $plugPref['onlineinfo_nolocations'];


$splitclasslist = explode(',',$buildclasslist);

$text = '<script language="JavaScript" src="'.e_PLUGIN.'onlineinfo/admin/picker.js"></script>

<div style="text-align:center">
<form method="POST" action="'.e_REQUEST_URL.'" name="menu_conf_form">
<table class="fborder">

<tr><td class="forumheader3" colspan="4">'.ONLINEINFO_LOGIN_MENU_A43.'</td></tr>

<tr><td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A38. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_nolocations',$onlineinfo_nolocations).'</td>
</tr>

<tr><td class="forumheader" colspan="4">'.ONLINEINFO_LOGIN_MENU_A102.'</td></tr>

<tr><td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A37. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_botchecker',$onlineinfo_botchecker).'</td>
</tr>

<tr><td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A35. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_ipchecker',$onlineinfo_ipchecker).'</td>
</tr>

<tr><td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A119. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_hideusers',$onlineinfo_hideusers).'</td>
</tr>

<tr><td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A120. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_hideguest',$onlineinfo_hideguest).'</td>
</tr>

<tr><td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A15. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_avatar',$onlineinfo_avatar).'</td>
</tr>
<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A16. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_guest',$onlineinfo_guest).'</td>
</tr>

<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A17. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_showicons',$onlineinfo_showicons).'</td>
</tr>
<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A18. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_showadmin',$onlineinfo_showadmin).'</td>
</tr>

<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A58. '</td>
<td class="forumheader3" colspan="3"><input class="tbox" type="text" name="onlineinfo_border" size="12" value="'.$onlineinfo_border.'" maxlength="12" /> <a href="javascript:TCP.popup(document.forms[\'menu_conf_form\'].elements[\'onlineinfo_border\'])"><img width="15" height="13" border="0" alt="'.ONLINEINFO_LOGIN_MENU_A159.'" src="'.e_PLUGIN.'onlineinfo/images/sel.gif"></a></td>
</tr>
<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A59. '</td>
<td class="forumheader3" colspan="3"><input class="tbox" type="text" name="onlineinfo_color" size="12" value="'.$onlineinfo_color.'" maxlength="12" /> <a href="javascript:TCP.popup(document.forms[\'menu_conf_form\'].elements[\'onlineinfo_color\'])"><img width="15" height="13" border="0" alt="'.ONLINEINFO_LOGIN_MENU_A159.'" src="'.e_PLUGIN.'onlineinfo/images/sel.gif"></a></td>
</tr>

<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A144. '</td>
<td class="forumheader3" colspan="3"><input class="tbox" type="text" name="onlineinfo_usernamefontsize" size="2" value="'.$onlineinfo_usernamefontsize.'" maxlength="2" />&nbsp;'.ONLINEINFO_LOGIN_MENU_A143.'</td>
</tr>

<tr>
<td colspan="4" class="forumheader" style="text-align:center"><input class="button" type="submit" name="update_menu" value="' .ONLINEINFO_LOGIN_MENU_A56. '" /></td>
</tr>
</table>
</form>
</div>';

 
return $text;			
		}
}

class onlineinfo_who_form_ui extends e_admin_form_ui

{
}

new onlineinfo_who_adminArea();
require_once (e_ADMIN . "auth.php");

e107::getAdminUI()->runPage();
require_once (e_ADMIN . "footer.php");

exit;
 