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

$lan_file = e_PLUGIN.'onlineinfo/languages/admin_'.e_LANGUAGE.'.php';
include_once(file_exists($lan_file) ? $lan_file : e_PLUGIN.'onlineinfo/languages/admin_English.php');

include_once(e_PLUGIN.'onlineinfo/functions.php');

//$ispminstalled = $sql -> db_Count("plugin", "(*)", "WHERE plugin_path ='pm' AND plugin_installflag ='1'");
$ispminstalled = e107::isInstalled('pm');

if(IsSet($_POST['update_menu'])){



				$sql=new db;
	$checkcacheno = $sql -> db_Count("onlineinfo_cache", "(*)", "WHERE type ='order'");

		for ($b = 1; $b <= $checkcacheno; $b++)
	{


	$sql -> db_Update("onlineinfo_cache", "cache_hide='".$_POST['onlineinfo_hide'.$b]."', cache_userclass='".$_POST['onlineinfo_show'.$b]."', type_order='".$_POST['onlineinfo_order'.$b]."' WHERE type='order' AND cache_name='".$_POST['onlineinfo_cachename'.$b]."'");
	}

			$ns -> tablerender('', '<div style="text-align:center"><b>' .ONLINEINFO_LOGIN_MENU_A1.' ( '.ONLINEINFO_LOGIN_MENU_A74. ' )</b></div>');

}


class onlineinfo_sections_adminArea extends onlineinfomenu_adminArea

{
	protected $modes = array(
		'sections' => array(
			'controller' => 'onlineinfo_sections_ui',
			'path' => null,
			'ui' => 'onlineinfo_sections_form_ui',
			'uipath' => null
		) ,
	);
	
}

class onlineinfo_sections_ui extends e_admin_ui

{
	protected $pluginTitle = ONLINEINFO_LOGIN_MENU_A2;
	protected $pluginName = 'onlineinfo';
 
		// optional - a custom page.  
		public function SettingsPage()
		{
    
    include_once(e_PLUGIN.'onlineinfo/functions.php');
    
    $plugPref =  e107::pref('onlineinfo');
    $ispminstalled = e107::isInstalled('pm');
    
$text = '<div style="text-align:center">
<form method="POST" action="'.e_REQUEST_URL.'" name="menu_conf_form">
<table class="fborder">';

$text .= '<tr>
			<td class="forumheader3" style="text-decoration: underline; text-align: center;">'.ONLINEINFO_LOGIN_MENU_A74.'</td>
			<td class="forumheader3" style="text-decoration: underline; text-align: center;">'.ONLINEINFO_LOGIN_MENU_A36.'</td>
			<td class="forumheader3" style="text-decoration: underline; text-align: center;">'.ONLINEINFO_LOGIN_MENU_A30.'</td>
			<td class="forumheader3" style="text-decoration: underline; text-align: center;">'.ONLINEINFO_LOGIN_MENU_A21.'</td>
		</tr>';


		$b=1;
		$cname='';
		$onlineinfo_order_sql=new db;
		$script="SELECT * FROM ".MPREFIX."onlineinfo_cache Where type='order' ORDER BY type_order";
		$onlineinfo_order = $onlineinfo_order_sql->db_Select_gen($script);
		while ($row = $onlineinfo_order_sql->db_Fetch())
		{

			if($row['cache_name']=='ONLINEINFO_CACHEINFO_10'){$cname=ONLINEINFO_CACHEINFO_10;}
			if($row['cache_name']=='ONLINEINFO_CACHEINFO_11'){ continue; }
			if($row['cache_name']=='ONLINEINFO_CACHEINFO_12'){$cname=ONLINEINFO_CACHEINFO_12;}
			if($row['cache_name']=='ONLINEINFO_CACHEINFO_13'){$cname=ONLINEINFO_CACHEINFO_13;}
			if($row['cache_name']=='ONLINEINFO_CACHEINFO_14'){$cname=ONLINEINFO_CACHEINFO_14;}
			if($row['cache_name']=='ONLINEINFO_CACHEINFO_15'){$cname=ONLINEINFO_CACHEINFO_15;}
			if($row['cache_name']=='ONLINEINFO_CACHEINFO_16'){$cname=ONLINEINFO_CACHEINFO_16;}


$text.='<tr>
		<td class="forumheader3" style="text-align: center;">'.Create_order_dropdown('onlineinfo_order'.$b,$row['type_order']).'
		<input type="hidden" name="onlineinfo_cachename'.$b.'" size="3" value="'.$row['cache_name'].'" />
		</td>
		<td class="forumheader3" style="text-align: right;">'.$cname.': </td>';


	if($row['cache_name']=='ONLINEINFO_CACHEINFO_11' /* && $pref['onlineinfo_xxflashchatuse']==0 */ ){
  $text.='<td class="forumheader3" style="text-align: center;">'.r_userclass('onlineinfo_show'.$b,'255',$mode = 'off',$optlist = 'nobody').'</td>';
	}
  elseif($row['cache_name']=='ONLINEINFO_CACHEINFO_12' && $ispminstalled==0){
		$text.='<td class="forumheader3" style="text-align: center;">'.r_userclass('onlineinfo_show'.$b,'255',$mode = 'off',$optlist = 'nobody').'</td>';
   
	}  
  
  elseif($row['cache_name']=='ONLINEINFO_CACHEINFO_14' && $plugPref['track_online']==0){
  		$text.='<td class="forumheader3" style="text-align: center;">'.r_userclass('onlineinfo_show'.$b,'255',$mode = 'off',$optlist = 'nobody').'</td>';
	}else{
		$text.='<td class="forumheader3" style="text-align: center;">'.r_userclass('onlineinfo_show'.$b,$row['cache_userclass']).'</td>';
	}

		$text.='<td class="forumheader3" style="text-align: center;">'.Create_yes_no_dropdown('onlineinfo_hide'.$b,$row['cache_hide']).'</td>';


$text.='</tr>';

$b++;
}



$text .= '<tr>
<td class="forumheader" colspan="4" style="text-align:center"><input class="button" type="submit" name="update_menu" value="' .ONLINEINFO_LOGIN_MENU_A56. '" /></td>
</tr>
</table>
</form>
</div>';

return $text;
		}
}

class onlineinfo_sections_form_ui extends e_admin_form_ui

{
}

new onlineinfo_sections_adminArea();
require_once (e_ADMIN . "auth.php");

e107::getAdminUI()->runPage();
require_once (e_ADMIN . "footer.php");

exit;