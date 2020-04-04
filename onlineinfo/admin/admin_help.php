<?php

// Generated e107 Plugin Admin Area

require_once ('../../../class2.php');




if (!getperms('P'))
{
	e107::redirect('admin');
	exit;
}

// e107::lan('onlineinfo',true);

require_once ("admin_menu.php");

$lan_file = e_PLUGIN.'onlineinfo/languages/admin_'.e_LANGUAGE.'.php';
include_once(file_exists($lan_file) ? $lan_file : e_PLUGIN.'onlineinfo/languages/admin_English.php');

$text='';

 

class onlineinfo_help_adminArea extends onlineinfomenu_adminArea

{
	protected $modes = array(
		'help' => array(
			'controller' => 'onlineinfo_help_ui',
			'path' => null,
			'ui' => 'onlineinfo_help_form_ui',
			'uipath' => null
		) ,
	);
	
}

class onlineinfo_help_ui extends e_admin_ui

{
	protected $pluginTitle = ONLINEINFO_LOGIN_MENU_A2;
	protected $pluginName = 'onlineinfo';
 
		
	/**
	 *	Get data for a plugin
	 *
	 *	@param string $plugid - name (= base directory) of the required plugin
	 */
    function get_plugin_data($plugName) 
  	{
    $xml = e107::getXml();
    $ret = array();
  		if (is_readable(e_PLUGIN.$plugName.'/plugin.xml'))
  		{                     
        $where = 'plugin.xml';
        $file =   e_PLUGIN.$plugName.'/plugin.xml';               
  		  $pluginxml = $xml->loadXMLfile($file, true, true);
   
              $ret['eplug_name'] = $pluginxml['@attributes']['name'];
              $ret['eplug_version'] = $pluginxml['@attributes']['version'];
  		}	  
        return $ret;
    }    
    
    // optional - a custom page.  
		public function helpinfoPage()
		{
   
    $pref = e107::getPref();
     
    $plug_data = $this->get_plugin_data('onlineinfo');
    extract($plug_data);
$text ='<script type="text/javascript" src="'.e_PLUGIN.'onlineinfo/switchcontent.js"></script>';

$text .= '<center><strong><img src="'.e_PLUGIN.'onlineinfo/images/logo.png"><br />'.ONLINEINFO_HELP_1.': '.$eplug_version.'</strong></center>';
$text .= '<hr />';
$text .= ONLINEINFO_HELP_2;


$text .= '<br /><hr />';
$text .= '<center><strong>'.ONLINEINFO_HELP_3.'</strong></center>';
$text .= ONLINEINFO_HELP_4.'<a href="https://www.e107.sk/forum/online-advanced-info-menu-by-themadmonk/">[OnlineInfo Forum]</a>';
$text .= ONLINEINFO_HELP_16.'<a href="https://github.com/Jimmi08/onlineinfo_menu/issues">[Github Issues]</a>';
$text .= '<br /><br />'.ONLINEINFO_HELP_5;
$text .= '<br /><hr />';

$text .= '<center><strong>'.ONLINEINFO_HELP_6.' '.$eplug_version.'</strong></center>';
$text.='<table>';
//added
$text.='<table>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>Created new plugin folder </td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>	REMOVED -  Chatbox II  Integration.</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>	REMOVED -  Bugtracker3  Integration.</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>	REMOVED -  Coppermine  Integration.</td></tr>'; 
 
$text.='</table>';



$text .= '</tr></table><br />';

$text.='<div id="hideoldinfo-title" style="cursor:hand; text-align:left; font-size: 10px; vertical-align: middle; font-weight:bold;">'.ONLINEINFO_HELP_60.'</div>';

$text.='<div id="hideoldinfo" class="switchgroup1" style="display:none; margin-left:2px;">';

$text .= '<center><strong>8.05</strong></center>';
$text.='<table>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_77.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_76.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_57.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_58.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_59.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_61.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_66.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_68.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_70.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_72.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_74.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_75.'</td></tr>';

//changed
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_62.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_73.'</td></tr>';
//fixed
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_63.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_64.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_65.'</td></tr>';

$text .= '</tr></table><center><strong>8.04</strong></center>';
$text.='<table>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_53.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_54.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_55.'</td></tr>';

$text .= '</tr></table><center><strong>8.02</strong></center>';
$text.='<table>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_51.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_52.'</td></tr>';

$text .= '</tr></table><center><strong>8.01</strong></center>';
$text.='<table>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_48.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_49.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_50.'</td></tr>';

$text .= '</tr></table><center><strong>8.00</strong></center>';
$text.='<table>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_7.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_9.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_10.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_11.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_12.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_13.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_15.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_30.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_32.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_33.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_34.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_35.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_36.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_42.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_43.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_44.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_46.'</td></tr>';
$text .= '<tr><td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_47.'</td></tr>';
$text.='</table>';

    $text.='</div><br /><hr /><br />';

    $text.='<script type="text/javascript">
		var showhide=new switchcontent("switchgroup1", "div") //Limit scanning of switch contents to just div elements
		showhide.setStatus("<img src=\"'.e_PLUGIN.'onlineinfo/images/minus.gif\" width=\"11px\" alt=\"\" /> ", "<img src=\"'.e_PLUGIN.'onlineinfo/images/plus.gif\" width=\"11px\" alt=\"\" /> ")
		showhide.collapsePrevious(false) //Allow more than 1 content to be open simultanously
		showhide.setPersist('.$pref["onlineinfo_rememberbuttons"].')
		showhide.init()
</script>';



  $text .='<table class="fborder"><tr><td class="forumheader3" style="font-weight:bold; text-align:center;" colspan="2">'.ONLINEINFO_LOGIN_MENU_A60.'</td></tr>';

    $sql = new db;

$ispminstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="pm" AND plugin_installflag ="1"');
 
$isloginstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="log" AND plugin_installflag ="1"');
 
$isforuminstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="forum" AND plugin_installflag ="1"');
$islistinstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="list_new" AND plugin_installflag ="1"');
$isdeletemeinstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="deleteme" AND plugin_installflag ="1"');
$isyoutubeinstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="ytm_gallery" AND plugin_installflag ="1"');
$iskroozearcadeinstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="kroozearcade_menu" AND plugin_installflag ="1"');
$islinkpageinstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="links_page" AND plugin_installflag ="1"');
$ischatboxinstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="chatbox_menu" AND plugin_installflag ="1"');
$ischatboxIIinstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="chatbox2_menu" AND plugin_installflag ="1"');
$isjokeinstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="jokes_menu" AND plugin_installflag ="1"');
$isbloginstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="userjournals_menu" AND plugin_installflag ="1"');
$issuggestioninstalled = $sql -> db_Count('plugin', '(*)', 'WHERE plugin_path ="suggestions_menu" AND plugin_installflag ="1"');


if ($ispminstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A84.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A84.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A84.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}
 

if ($isloginstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A85.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A85.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A85.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}

if ($pref["statActivate"]==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A85.ONLINEINFO_LOGIN_MENU_A80.'</td></tr>';
}else{
	if ($isloginstalled==1){
	$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;"><a href="'.e_PLUGIN.'log/admin_config.php">'.ONLINEINFO_LOGIN_MENU_A85.ONLINEINFO_LOGIN_MENU_A81.'</a>&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A85.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
	}else{
	$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A85.ONLINEINFO_LOGIN_MENU_A81.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A85.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
	}
}

 
if ($isforuminstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A86.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A86.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A86.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}

if ($pref["track_online"]==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A87.ONLINEINFO_LOGIN_MENU_A80.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;"><a href="'.e_ADMIN.'users.php?mode=main&action=prefs">'.ONLINEINFO_LOGIN_MENU_A87.ONLINEINFO_LOGIN_MENU_A81.'</a>&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A87.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}

if ($pref["profile_rate"]==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A88.ONLINEINFO_LOGIN_MENU_A80.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;"><a href="'.e_ADMIN.'users.php?mode=main&action=prefs">'.ONLINEINFO_LOGIN_MENU_A88.ONLINEINFO_LOGIN_MENU_A81.'</a>&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A88.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}


if ($islistinstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A106.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A106.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A106.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}

if ($isdeletemeinstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A150.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A150.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A150.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}



if ($isyoutubeinstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A151.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A151.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A151.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}

if ($iskroozearcadeinstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A164.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A164.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A164.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}


if ($islinkpageinstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A168.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A168.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A168.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}

 

if ($ischatboxinstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A180.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A180.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A180.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}
 
if ($isjokeinstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A193.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A193.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A193.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}

if ($isbloginstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A195.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A195.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A195.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}

if ($issuggestioninstalled==1){
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/tick.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A197.ONLINEINFO_LOGIN_MENU_A78.'</td></tr>';
}else{
$text .='<tr><td class="forumheader3" style="text-align:center;"><img src="'.e_PLUGIN.'onlineinfo/images/cross.png"></td><td class="forumheader3" style="vertical-align: middle;">'.ONLINEINFO_LOGIN_MENU_A197.ONLINEINFO_LOGIN_MENU_A79.'&nbsp;(&nbsp;'.ONLINEINFO_LOGIN_MENU_A197.ONLINEINFO_LOGIN_MENU_A103.'&nbsp;)</td></tr>';
}



$text .='</table></div>';



    $text.='<br /><hr /><br />';

$text .= '<center><strong>'.ONLINEINFO_HELP_18.'</strong></center>';
$text.='<table><tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_17.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_20.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_31.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_21.'</td></tr>';
 
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_56.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_67.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_69.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_71.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_25.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_26.'</td></tr>';
$text.='</table>';

$text.='<table><tr>';
$text .= '<br /><br /><center><strong>'.ONLINEINFO_HELP_29.'</strong></center>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_19.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_22.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_23.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_24.'</td></tr>';


$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_27.'</td></tr>';
$text.='</table>';

$text.='<br /><hr /><br />';


$text .= '<center><strong>'.ONLINEINFO_HELP_38.'</strong></center>';
$text.='<table><tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_37.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_39.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_40.'</td></tr>';
$text .= '<td style="vertical-align:top;"><li /></td><td>'.ONLINEINFO_HELP_41.'</td></tr>';
$text.='</table>';

$text.='<br /><hr />';  
  
  
return $text;
		}
}

class onlineinfo_help_form_ui extends e_admin_form_ui

{
}

new onlineinfo_help_adminArea();
require_once (e_ADMIN . "auth.php");

e107::getAdminUI()->runPage();
require_once (e_ADMIN . "footer.php");

exit;