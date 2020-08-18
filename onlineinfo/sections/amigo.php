<?php
if (!defined('e107_INIT'))
{
	exit;
}

if (check_class($orderclass))
{

	$friendtext = "";
	$friendonline = 0;

	$sql2 = new db;

	$query = "SELECT " . MPREFIX . "user.user_login," . MPREFIX . "user.user_name," . MPREFIX . "user.user_id," . MPREFIX . "user.user_currentvisit FROM " . MPREFIX . "onlineinfo_friends left join " . MPREFIX . "user ON " . MPREFIX . "user.user_id=" . MPREFIX . "onlineinfo_friends.amigo_amigo  WHERE " . MPREFIX . "onlineinfo_friends.amigo_user='" . USERID . "'";

	$sql2->gen($query);
	while ($row = $sql2->fetch())
	{
		$amigo = true;
		extract($row);
		$gen = new convert;
		$datestamp = $gen->convert_date($user_currentvisit);

		$sql3 = new db;
		$sql3->select("online", "*", "online_user_id='" . $user_id . "." . $user_name . "' ");

		if ($row3 = $sql3->fetch())
		{
			$friendonline++;}
	}

	if ($friendonline != 0)
	{
		$friendtext = "<img src='" . e_PLUGIN_ABS . "onlineinfo/images/fonline.gif' style='vertical-align:middle; border:0;'  alt='" . AMIGO_22 . "' />";}

	if ($orderhide == 1)
	{

		$text .= "<div id='friend-title' style='cursor:hand; text-align:left; font-size: " . $onlineinfomenufsize . "px; vertical-align: middle; width:" . $onlineinfomenuwidth . "; font-weight:bold;' title='" . AMIGO_TITULO . "'>" . $friendtext . "&nbsp;" . AMIGO_TITULO . "</div>";
		$text .= "<div id='friend' class='switchgroup1' style='display:none; margin-left:5px;'>";

	}
	else
	{

		$text .= "<div class='smallblacktext' style='font-size: " . $onlineinfomenufsize . "px; font-weight:bold; margin-left:5px; margin-top:10px; width:" . $onlineinfomenuwidth . "'>" . $friendtext . "&nbsp;" . AMIGO_TITULO . "</div><div style='text-align:left; width:" . $onlineinfomenuwidth . "; margin-left:5px;'>";
	}

	$amigo = false;

	if (isset($_POST['addbuddy']) && $_POST['buddy'] > 0)
	{
		if (!$sql->select("onlineinfo_friends", "*", "amigo_user='" . USERID . "' AND amigo_amigo='" . $_POST['buddy'] . "'"))
		{
			if ($sql->insert("onlineinfo_friends", "0, '" . USERID . "', '" . $_POST['buddy'] . "' "))
			{

			}
			else
			{
				$text .= "<div style='text-align:center;font-weight:bold;padding: 5px 5px 5px 5px;'><img src='" . e_PLUGIN_ABS . "onlineinfo/images/error.png' style='vertical-align:middle' width='15' height='15' alt='IMPORTANT!' title='IMPORTANT!' />&nbsp;&nbsp;" . AMIGO_8 . "</div>";

			}
		}
		else
		{
			$text .= "<div style='text-align:center;font-weight:bold;padding: 5px 5px 5px 5px;'><img src='" . e_PLUGIN_ABS . "onlineinfo/images/error.png' style='vertical-align:middle' width='15' height='15' alt='IMPORTANT!' title='IMPORTANT!' />&nbsp;&nbsp;" . AMIGO_5 . "</div>";

		}

	}

	if (isset($_GET['remove']))
	{
		if ($sql->select("onlineinfo_friends", "*", "amigo_user='" . USERID . "' AND amigo_amigo='$_GET[remove]' "))
		{
			if ($sql->delete("onlineinfo_friends", "amigo_user='" . USERID . "' AND amigo_amigo='$_GET[remove]' "))
			{

			}
			else
			{
				$text .= "<div style='text-align:center;font-weight:bold;padding: 5px 5px 5px 5px;'><img src='" . e_PLUGIN_ABS . "onlineinfo/images/error.png' style='vertical-align:middle' width='15' height='15' alt='IMPORTANT!' title='IMPORTANT!' />&nbsp;&nbsp;" . AMIGO_6 . "</div>";

			}
		}
		else
		{
			$text .= "<div style='text-align:center;font-weight:bold;padding: 5px 5px 5px 5px;'><img src='" . e_PLUGIN_ABS . "onlineinfo/images/error.png' style='vertical-align:middle' width='15' height='15' alt='IMPORTANT!' title='IMPORTANT!' />&nbsp;&nbsp;" . AMIGO_7 . "</div>";

		}
	}
	// To create a list of users to choose

	$text .= "<div id='newamigo-title' style='cursor:hand; text-align:left; vertical-align: middle; width:" . $onlineinfomenuwidth . "; font-weight:bold;' title='" . AMIGO_21 . "'>&nbsp;" . AMIGO_21 . "</div>";
	$text .= "<div id='newamigo' class='switchgroup1' style='display:none; margin-left:20px;'>";

	$text .= "<form action='" . e_REQUEST_URL . "' method='post' id='buddygeraffel'><select class='tbox' name='buddy' size='1' width='10'>";

	$sql->select("user", "user_login,user_name,user_id", "user_name Like '%' ORDER BY user_name ");
	$text .= "<option value=''></option>";
	while ($row = $sql->fetch())
	{
		extract($row);
		if ($user_id != USERID)
		{
			$text .= "<option value='" . $user_id . "'>" . ($pref['realname'] == 1 && $user_login != "" ? $user_login : $user_name) . "</option>";
		}
	}

	$text .= "</select>&nbsp;<input class='button' type='submit' name='addbuddy' value='" . AMIGO_13 . "' title='" . AMIGO_11 . "'></form>";

	$text .= "</div>";

	$text .= "<div id='myfriend-title' style='cursor:hand; text-align:left; vertical-align: middle; width:" . $onlineinfomenuwidth . "; font-weight:bold;' title='" . AMIGO_23 . "'>&nbsp;" . AMIGO_23 . "</div>";
	$text .= "<div id='myfriend' class='switchgroup1' style='display:none'>";

	$query = "SELECT " . MPREFIX . "user.user_login," . MPREFIX . "user.user_name," . MPREFIX . "user.user_id," . MPREFIX . "user.user_currentvisit FROM " . MPREFIX . "onlineinfo_friends left join " . MPREFIX . "user ON " . MPREFIX . "user.user_id=" . MPREFIX . "onlineinfo_friends.amigo_amigo  WHERE " . MPREFIX . "onlineinfo_friends.amigo_user='" . USERID . "'";

	$sql2->gen($query);
	while ($row = $sql2->fetch())
	{
		$amigo = true;
		extract($row);
		$gen = new convert;
		$datestamp = $gen->convert_date($user_currentvisit);
		$sql3 = new db;
		$sql3->select("online", "*", "online_user_id='" . $user_id . "." . $user_name . "' ");

		if ($row3 = $sql3->fetch())
		{

			$text .= "<img src='" . e_PLUGIN . "onlineinfo/images/online_mini.png' alt='" . AMIGO_14 . "' />";
		}
		else
		{

			$text .= "<img src='" . e_PLUGIN . "onlineinfo/images/offline_mini.png' alt='" . AMIGO_15 . "' />";
		}

		$text .= "&nbsp;<a title='" . AMIGO_18 . " " . $datestamp . "' href='" . e_BASE . "user.php?id." . $user_id . "' " . getuserclassinfo($user_id) . ">" . ($pref['realname'] == 1 && $user_login != "" ? $user_login : $user_name) . "</a>&nbsp;";

		if (e107::isInstalled('pm'))
		{
			$text .= "<a href='" . e_PLUGIN . "pm/pm.php?send.$user_id'><img src='" . e_PLUGIN_ABS . "onlineinfo/images/icon_pm.png' height='16px' alt='" . AMIGO_16 . "' title='" . AMIGO_16 . "' border='0' id='im' /></a>&nbsp;";
		}
		$text .= "<a href='" . e_REQUEST_URL . "?remove=$user_id'><img src='" . e_PLUGIN_ABS . "onlineinfo/images/delete.png' alt='" . AMIGO_17 . "' title='" . AMIGO_17 . "' border='0' id='im' /></a><br />";

	}

	// Warning if the list is empty
	if (!$amigo)
	{

		$text .= AMIGO_1 . "<br />";
	}
	$text .= "</div>";

	$text .= "<div id='friendof-title' style='cursor:hand; text-align:left; vertical-align: middle; width:" . $onlineinfomenuwidth . "; font-weight:bold;' title='" . AMIGO_24 . "'>&nbsp;" . AMIGO_24 . "</div>";
	$text .= "<div id='friendof' class='switchgroup1' style='display:none'>";

	$query = "SELECT " . MPREFIX . "user.user_login," . MPREFIX . "user.user_name," . MPREFIX . "user.user_id," . MPREFIX . "user.user_currentvisit FROM " . MPREFIX . "onlineinfo_friends left join " . MPREFIX . "user ON " . MPREFIX . "user.user_id=" . MPREFIX . "onlineinfo_friends.amigo_user  WHERE " . MPREFIX . "onlineinfo_friends.amigo_amigo='" . USERID . "'";

	$sql2->gen($query);
	while ($row = $sql2->fetch())
	{

		$amigo = true;
		extract($row);
		$gen = new convert;
		$datestamp = $gen->convert_date($user_currentvisit);
		$sql3 = new db;
		$sql3->select("online", "*", "online_user_id='" . $user_id . "." . $user_name . "' ");

		if ($row3 = $sql3->fetch())
		{

			$text .= "<img src='" . e_PLUGIN_ABS . "onlineinfo/images/online_mini.png' alt='" . AMIGO_14 . "' />";
		}
		else
		{

			$text .= "<img src='" . e_PLUGIN_ABS . "onlineinfo/images/offline_mini.png' alt='" . AMIGO_15 . "' />";
		}

		$text .= "&nbsp;<a title='" . AMIGO_18 . " " . $datestamp . "' href='" . e_BASE . "user.php?id." . $user_id . "' " . getuserclassinfo($user_id) . ">" . ($pref['realname'] == 1 && $user_login != "" ? $user_login : $user_name) . "</a>&nbsp;
			<a href='" . e_PLUGIN . "pm/pm.php?send.$user_id'><img src='" . e_PLUGIN_ABS . "onlineinfo/images/icon_pm.png' height='16px' alt='" . AMIGO_16 . "' title='" . AMIGO_16 . "' border='0' id='im' /></a><br />";

	}

	// Warning if the list is empty
	if (!$amigo)
	{

		$text .= AMIGO_1 . "<br />";
	}
	$text .= "</div>";

	$text .= "<br /></div>";

}
 