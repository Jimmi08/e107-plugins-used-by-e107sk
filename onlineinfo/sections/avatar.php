<?php
if (!defined('e107_INIT')) { exit; }
 

$bulletimageintheme =  THEME.'images/bullet2.gif';
$bulletimage = file_exists($bulletimageintheme) ? THEME_ABS.'images/bullet2.gif'  : e_PLUGIN_ABS.'onlineinfo/images/bullet2.gif';
//$bulletimage = $bulletimageintheme;
if(check_class($orderclass))
{

if ($orderhide == 1)
    {

    $text .= '<div id="avatar-title" style="cursor:hand; text-align:left; font-size: '.$onlineinfomenufsize.'px; vertical-align: middle; width:'.$onlineinfomenuwidth.'; font-weight:bold;" title="'.ONLINEINFO_LOGIN_MENU_L80.'">&nbsp;'.ONLINEINFO_LOGIN_MENU_L80.'</div>
	<div id="avatar" class="switchgroup1" style="display:none; margin-left:2px;">';

}else{
	$text .= '<div>';

}

unset($avatardata);
unset($avatarimage);

		$sql = new db;
		if($sql -> select("user", "*", "user_id='".USERID."'")){
			$row = $sql -> fetch();
      $avatarimage = e107::getParser()->toAvatar($row, array("w"=>"50", "h"=>50));

			if(ADMIN == TRUE){
			//	$adminfpage = (!$pref["adminstyle"] || $pref["adminstyle"] == 'default' ? 'admin.php' : $pref["adminstyle"].'.php');
				$adminfpage = e_ADMIN_ABS.'admin.php'; 
				$avatardata .= ($pref["maintainance_flag"]==1 ? '<div style="text-align:center"><b>'.ONLINEINFO_LOGIN_MENU_L10.'</div></b><br />' : '' );
				$avatardata .= '<img src="'.$bulletimage.'" alt="bullet" />&nbsp;<a href="'.$adminfpage.'">'.ONLINEINFO_LOGIN_MENU_L11.'</a><br />';
    	}
 
      // put here new plugins
            $link1 =  e107::getUrl()->create('user/myprofile/edit',array('id'=>USERID));
            $link2 = e107::getUrl()->create('user/profile/view',array('user_id'=>USERID, 'user_name'=>USERNAME));
			$avatardata .= '<img src="'.$bulletimage.'" alt="bullet" /> <a href="'.$link1.'">'.ONLINEINFO_LOGIN_MENU_L12.'</a><br /><img src="'.$bulletimage.'" alt="bullet" /> 
            
            <a href="'.$link2.'">'.ONLINEINFO_LOGIN_MENU_L13.'</a><br /><img src="'.$bulletimage.'" alt="bullet" /> <a href="'.e_BASE.'index.php?logout">'.ONLINEINFO_LOGIN_MENU_L8.'</a>';
			if(!$sql -> select("online", "*", "online_ip='".$ip."' AND online_user_id='0' ")){
				$sql -> delete("online", "online_ip='".$ip."' AND online_user_id='0' ");
			}
		$new_total = 0;
		$time = USERLV;
		}


		$text .='<table style="width:'.$onlineinfomenuwidth.'">
		<tr>
		<td valign="middle">';

		if($pref['onlineinfo_turnoffavatar']==0){
		$text.=$avatarimage;
		}

		$text.='</td>
		<td valign="middle" align="left">'.$avatardata.'</td>
		</tr></table>
		<br /></div>';

}   
?>