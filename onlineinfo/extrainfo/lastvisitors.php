<?php

if (!defined('e107_INIT'))
{
	exit;
}

if (check_class($extraclass))
{
	if ($extrahide == 1)
	{
		$text.= "<div id='lastv-title' style='cursor:hand; text-align:left; font-size: " . $onlineinfomenufsize . "px; vertical-align: middle; width:" . $onlineinfomenuwidth . "; font-weight:bold;' title='" . ONLINEINFO_LOGIN_MENU_L31 . "'>&nbsp;" . ONLINEINFO_LOGIN_MENU_L31 . "</div>";
		$text.= "<div id='lastv' class='switchgroup1' style='display:none'>";
		$text.= "<table style='text-align:left; width:" . $onlineinfomenuwidth . "; margin-left:5px;'>";
	}
	else
	{
		$text.= "<div class='smallblacktext' style='font-size: " . $onlineinfomenufsize . "px; font-weight:bold; margin-left:5px; margin-top:10px; width:" . $onlineinfomenuwidth . "'>" . ONLINEINFO_LOGIN_MENU_L31 . "</div><div style='text-align:left; width:" . $onlineinfomenuwidth . "; margin-left:5px;'><table style='text-align:left; width:" . $onlineinfomenuwidth . "'>";
	}

	$script = "SELECT user_id, user_name, user_currentvisit FROM " . MPREFIX . "user   ORDER  BY user_currentvisit DESC LIMIT 0," . $extrarecords;
	if ($userArray = $sql->retrieve($script, true))
	{
		foreach($userArray as $user)
		{
			$seen_ago = e107::getDateConvert()->convert_date($user['user_currentvisit'], '%d %b : %H:%M');
			$user_id = $user['user_id'];
			$user_name = $user['user_name'];
			$uparams = array(
				'id' => $user_id,
				'name' => $user_name
			);
			$userurl = e107::getUrl()->create('user/profile/view', $uparams);
			$text.= "<tr><td style='vertical-align:top; text-align:left; width:50%;' nowrap>
            <a href='" . $userurl . "'><span " . getuserclassinfo($user_id) . ">" . $user_name . "</span></a></td>
			<td style='vertical-align:top; text-align:right; width:50%; padding-right:20px;' nowrap>" . $seen_ago . "</td></tr>";
		}
	}
	else
	{
		$text.= "<div class='smalltext' style='text-align:left; width:" . $onlineinfomenuwidth . ";'>" . ONLINEINFO_LOGIN_MENU_L47 . "</div>";
	}

	$text.= "</table><br /></div>";
}
 