<?php
/*
+---------------------------------------------------------------+
|        Birthday Menu for e107 v7xx - by Father Barry
|
|        This module for the e107 .7+ website system
|        Copyright Barry Keal 2004-2008
|
|        Released under the terms and conditions of the
|        GNU General Public License (http://gnu.org).
|
+---------------------------------------------------------------+
*/

// ***************************************************************
// *
// *		Plugin		:	Birthday Menu (e107 v7)
// *
// ***************************************************************
// check if cache

require_once (e_HANDLER . 'userclass_class.php');

$plugPref = e107::pref('birthday');

// print_a($plugPref['bday_showclass']);

global $bday_shortcodes, $tp, $sql, $sql2, $gold_obj, $bday_show, $user_id, $BDAY_datepart, $bday_showyear, $user_name, $BDAY_results, $BDAY_today, $bday_avatar, $bday_out, $e107cache, $pref;

$BDAY_now = time();

if (date("d", $plugPref['bday_cache']) != date("d", $BDAY_now))
{ 

	// we are on a new day

	$e107cache->clear("nq_bdaymenu");
	$plugPref['bday_cache'] = $BDAY_now;

	// save_prefs();

	e107::getPlugConfig('birthday')->setPref($plugPref)->save(true, false, false);
}

if ($cacheData = $e107cache->retrieve("nq_bdaymenu", 1440))
{

	// force cache clear at least every 24 hours

	echo $cacheData;
}
else
{      
	include_lan(e_PLUGIN . "birthday/languages/" . e_LANGUAGE . "_birthday_mnu.php");
	define(BDAY_AVATAR, $plugPref['bday_avatar']);
	if (BDAY_AVATAR == 1)
	{                             
		define(BDAY_AVHEIGHT, $plugPref['bday_avwidth']);
		define(BDAY_LINEHEIGHT, $plugPref['bday_avwidth'] + 3);
		define(BDAY_AVSHAPE, $plugPref['bday_avshape']);
		define(BDAY_ALIGN, 'left');
	}

	if (file_exists(THEME . 'templates/birthday/bday_template.php'))
	{
		define('BDAY_TEMPLATE', THEME . 'templates/birthday/bday_template.php');
	}
	else
	{
		define('BDAY_TEMPLATE', e_PLUGIN . 'birthday/templates/bday_template.php');
	}

	require_once (BDAY_TEMPLATE);

	if (!isset($bday_shortcodes))
	{
		require_once (e_PLUGIN . 'birthday/includes/bday_shortcodes.php');

	}

	$ec_dir = e_PLUGIN . "birthday/";
	$BDAY_months = explode(',', BDAY_LAN_MONTHS);
	$BDAY_monthl = explode(',', BDAY_LAN_MONTHL);
	$BDAY_suffix = explode(',', BDAY_LAN_MONTHSUFFIX);
	if (check_class($plugPref['bday_showclass']))
	{

		// it's ok, so check excluded users

		if (check_class($plugPref['bday_exclude']))
		{

			// you are out

			return '';
		}
		else
		{
		}
	}
	else
	{
		return '';
	}

	// $bday_find .= " and ! find_in_set('" . $plugPref['bday_exclude'] . "',user_class)";

	$bday_today = mktime(0, 0, 0, date("m", $BDAY_now) , date("d", $BDAY_now) , date("Y", $BDAY_now));
 
	// Have we already done an email to users

	$bday_doemail = ($plugPref['bday_lastemail'] < $bday_today ? true : false);
 
	unset($BDAY_text);
	$BDAY_today = date("Y-m-d", $BDAY_now);
	$BDAY_month = date("m", $BDAY_now);
	$BDAY_day = date("d", $BDAY_now);
	$BDAY_year = date("Y", $BDAY_now);

	// get any birthdays today
 
	$bday_arg = "
select user_name,user_email,user_id,user_birthday,user_image from #user
left join #user_extended on user_extended_id = user_id
where user_birthday LIKE '%-$BDAY_month-$BDAY_day' " . $bday_find;
  
	$BDAY_results = $sql2->gen($bday_arg, false);
	if ($BDAY_results) $BDAY_today = true;
	else $BDAY_today = false;

	// * Select the appropriate comment depending on the number of birthdays today

	$bday_datedisplay = date($plugPref['bday_dformat'], $BDAY_now);
	$BDAY_text.= $tp->parsetemplate($BDAY_MENU_HEADER, true, $bday_shortcodes);
	if ($BDAY_results)
	{
           
		$BDAY_text.= $tp->parsetemplate($BDAY_MENU_TODAY, true, $bday_shortcodes);
		while ($BDAY_row = $sql2->fetch())
		{
			// print_a($BDAY_row);

			extract($BDAY_row);

			// get location of avatar

			$bday_avatar = birthday_avatar($user_image, $user_id);
 
			// do gold if active and not already done and birthday gold active

			if (is_object($gold_obj))
			{
				$gold_obj->load_gold($user_id);
				$bday_thisyear = date('Y', $BDAY_now);
				if ($gold_obj->gold_plugins['birthday'] && $plugPref['bday_gold'] >= 0 && $gold_obj->gold_additional[$user_id]['bday_year'] != $bday_thisyear)
				{

					// if the birthday menu is active in gold, we do allocate gold and they not had it this year already
					// *	Parameters	: 	$gold_param['gold_user_id'] (default no user)
					// *				: 	$gold_param['gold_who_id'] (default no user)
					// *				:	$gold_param['gold_amount'] (default no amount)
					// *				:	$gold_param['gold_type'] (default "adjustment")
					// *				:	$gold_param['gold_action'] 	credit - add to account
					// *												debit - subtract from account
					// *				:	$gold_param['gold_plugin'] (default no plugin)
					// *				:	$gold_param['gold_log'] (default "")
					// *				:	$gold_param['gold_forum'] (default 0)

					$gold_param = array(
						"gold_user_id" => $user_id,
						"gold_who_id" => 0,
						"gold_amount" => $plugPref['bday_gold'],
						"gold_plugin" => "birthday",
						"gold_type" => BDAY_ADMIN_GOLD05,
						"gold_action" => "credit",
						"gold_log" => BDAY_ADMIN_GOLD04,
						"gold_forum" => 0
					);
					$gold_obj->gold_modify($gold_param);
					$gold_obj->gold_additional[$user_id]['bday_year'] = $bday_thisyear;
					$gold_obj->write_additional($user_id);
				}
			}

			// print $user_email;

			if (($plugPref['bday_sendemail'] == 1 && $bday_doemail))
			{          
				birthday_sendemail($user_email, $user_name);
			}

			if ($plugPref['bday_showage'] > 0)
			{
				$BDAY_age = date("Y-m-d", $BDAY_now) - $user_birthday;
				$bday_show = $BDAY_AGE_PRE . $BDAY_age . $BDAY_AGE_POST;
			}
			else
			{
				$bday_show = '';
			}

			$BDAY_text.= $tp->parsetemplate($BDAY_MENU_DETAIL, true, $bday_shortcodes);

			// $BDAY_text .= "<a href='" . e_BASE . "user.php?id." . $user_id . "'>" . $tp->toHTML($user_name, false) . " " . $bday_show . "<br /></a>";

		}

		// $BDAY_text .= "<br />";

	}
	else
	{

		// none today

		$BDAY_text.= $tp->parsetemplate($BDAY_MENU_NONE, true, $bday_shortcodes);
	}

	$BDAY_text.= $tp->parsetemplate($BDAY_MENU_NEXTHEADER, true, $bday_shortcodes);

	// if we have done email and gold check today

	if ($bday_doemail)
	{
		$plugPref['bday_lastemail'] = $BDAY_now;

		// e107::getPlugConfig('birthday')->setPref($plugPref['bday_lastemail'], $BDAY_now)->save(true,false,false);

		e107::getPlugConfig('birthday')->setPref($plugPref)->save(true, false, false);

		// save_prefs('birthday');

	}

	// fix for missing default value

	$limit = varsettrue($plugPref['bday_numdue'], 0);

	// Check for the upcoming birthdays

	$bday_datestring = date("Y-m-d", $BDAY_now);
	$bday_arg = "select *,YEAR('" . $bday_datestring . "') - YEAR(user_birthday) -( DATE_FORMAT('" . $bday_datestring . "', '%m-%d') < DATE_FORMAT(user_birthday, '%m-%d')) AS age
from #user left join #user_extended on user_extended_id = user_id
where(user_birthday != '0000/00/00' AND ((DAYOFYEAR(CONCAT(DATE_FORMAT('" . $bday_datestring . "', '%Y-'), DATE_FORMAT(user_birthday,'%m-%d'))) < DAYOFYEAR('" . $bday_datestring . "'))*366)+
DAYOFYEAR(CONCAT(DATE_FORMAT('" . $bday_datestring . "', '%Y-'), DATE_FORMAT(user_birthday,'%m-%d')))>=DAYOFYEAR('" . $bday_datestring . "'))
and not (DAYOFMONTH(user_birthday)=DAYOFMONTH('" . $bday_datestring . "') and MONTH(user_birthday)=MONTH('" . $bday_datestring . "') ) " . $bday_find . "
 ORDER BY
((DAYOFYEAR(CONCAT(DATE_FORMAT('" . $bday_datestring . "', '%Y-'), DATE_FORMAT(user_birthday,'%m-%d'))) < DAYOFYEAR('" . $bday_datestring . "')) * 366) + DAYOFYEAR(CONCAT(DATE_FORMAT('" . $bday_datestring . "', '%Y-'), DATE_FORMAT(user_birthday,'%m-%d'))),date_format(user_birthday,'%m%d') asc
limit 0," . $limit . "";

	// print $bday_arg;

	$BDAY_due = $sql2->gen($bday_arg, false);

	// If there are some display them

	if ($BDAY_due)
	{
		$bday_monthlist = explode(",", BDAY_LAN_MONTHS);

		// $BDAY_text .= "<br />" . BDAY_LAN_5 . "<br />";

		while ($BDAY_row = $sql2->fetch())
		{
			extract($BDAY_row);
			$bday_avatar = birthday_avatar($user_image, $user_id);
			$BDAY_datepart = explode("-", $user_birthday);
			$bday_bdate = mktime(0, 0, 0, $BDAY_datepart[1], $BDAY_datepart[2], $BDAY_datepart[0]);
			$BDAY_age = $age + 1;
			if ($plugPref['bday_showage'] > 0)
			{
				$bday_show = $BDAY_AGE_PRE . $BDAY_age . $BDAY_AGE_POST;
				$bday_showyear = $BDAY_datepart[0];
			}
			else
			{
				$bday_show = "";
				$bday_showyear = "";
			}

			$bday_d = intval($BDAY_datepart[2]);
			$bday_m = intval($BDAY_datepart[1]);
			$bday_y = ' ' . $BDAY_datepart[0];
			switch ($plugPref['bday_dformat'])
			{
			case 1:

				// d M Y

				$bday_out = $bday_d . " " . $bday_m . $bday_y;
				break;

			case 2:

				// M d

				$bday_out = $bday_m . " " . $bday_d;
				break;

			case 3:

				// M d Y

				$bday_out = $bday_m . " " . $bday_d . $bday_y;
				break;

			case 4:

				// Y M d

				$bday_out = $bday_y . " " . $bday_m . $bday_d;
				break;

			case 5:

				// d mmm Y

				$bday_out = $bday_d . " " . $BDAY_months[$bday_m] . $bday_y;
				break;

			case 6:

				// d MMM Y

				$bday_out = $bday_d . " " . $BDAY_monthl[$bday_m] . $bday_y;
				break;

			case 7:

				// mmm d Y

				$bday_out = $BDAY_months[$bday_m] . " " . $bday_d . $bday_y;
				break;

			case 8:

				// MMM d Y

				$bday_out = $BDAY_monthl[$bday_m] . " " . $bday_d . $bday_y;
				break;

			case 9:

				// d mmm Y

				$bday_out = $bday_d . $BDAY_suffix[$bday_d] . " " . $BDAY_months[$bday_m] . $bday_y;
				break;

			case 10:

				// d MMM Y

				$bday_out = $bday_d . $BDAY_suffix[$bday_d] . " " . $BDAY_monthl[$bday_m] . $bday_y;
				break;

			case 11:

				// mmm d Y

				$bday_out = $BDAY_months[$bday_m] . " " . $bday_d . $BDAY_suffix[$bday_d] . $bday_y;
				break;

			case 12:

				// MMM d Y

				$bday_out = $BDAY_monthl[$bday_m] . " " . $bday_d . $BDAY_suffix[$bday_d] . $bday_y;
				break;

			case 13:

				// d mmm Y

				$bday_out = $bday_d . " " . $BDAY_months[$bday_m];
				break;

			case 14:

				// d MMM Y

				$bday_out = $bday_d . " " . $BDAY_monthl[$bday_m];
				break;

			case 15:

				// mmm d Y

				$bday_out = $BDAY_months[$bday_m] . " " . $bday_d;
				break;

			case 16:

				// MMM d Y

				$bday_out = $BDAY_monthl[$bday_m] . " " . $bday_d;
				break;

			case 17:

				// d mmm Y

				$bday_out = $bday_d . $BDAY_suffix[$bday_d] . " " . $BDAY_months[$bday_m];
				break;

			case 18:

				// d MMM Y

				$bday_out = $bday_d . $BDAY_suffix[$bday_d] . " " . $BDAY_monthl[$bday_m];
				break;

			case 19:

				// mmm d Y

				$bday_out = $BDAY_months[$bday_m] . " " . $bday_d . $BDAY_suffix[$bday_d];
				break;

			case 10:

				// MMM d Y

				$bday_out = $BDAY_monthl[$bday_m] . " " . $bday_d . $BDAY_suffix[$bday_d];
				break;

			default:

				// d M

				$bday_out = $bday_d . " " . $bday_m;
			}

			$BDAY_text.= $tp->parsetemplate($BDAY_MENU_FUTURE, true, $bday_shortcodes);

			// $BDAY_text .= $bday_out . " <a title='" . $user_birthday = "$BDAY_datepart[2].{$BDAY_datepart[1]}{$bday_showyear}" . "' href='" . e_BASE . "user.php?id." . $user_id . "'>" . $tp->toHTML($user_name, false) . " " . $bday_show . "</a><br />";

		}
	}
	else
	{
		$BDAY_text.= $tp->parsetemplate($BDAY_MENU_NOFUTURE, true, $bday_shortcodes);
	}

	$BDAY_text.= $tp->parsetemplate($BDAY_MENU_FOOTER, true, $bday_shortcodes);
	ob_start(); // Set up a new output buffer
	$ns->tablerender(BDAY_LAN_3, $BDAY_text, 'birthday'); // Render the menu
	$cache_data = ob_get_flush(); // Get the menu content, and display it
	$e107cache->set("nq_bdaymenu", $cache_data); // Save to cache
}

// renamed to be able to run old and new together

function birthday_sendemail($to, $name)
{
	global $sysprefs, $sql, $tp, $THEMES_DIRECTORY, $IMAGES_DIRECTORY;
  
	// # # sendemail($user_email, $plugPref['bday_subject'], $plugPref['bday_greeting'], $user_name, $plugPref['bday_emailaddr'], $plugPref['bday_emailfrom']);

	$plugPref = e107::getPlugPref('birthday');
	$mail_head = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
	$mail_head.= "<html xmlns='http://www.w3.org/1999/xhtml' >\n";
	$mail_head.= "<head><meta http-equiv='content-type' content='text/html; charset=utf-8' />\n";
	$emessage = $plugPref['bday_greeting'];
	$emessage = str_replace("{NAME}", $name, $emessage);
	$subj = $tp->toFORM($plugPref['bday_subject'], false);
	$subj = str_replace("&#039;", "'", $subj);
	if ($plugPref['bday_usepm'] == 1)
	{
		$retrieve_prefs[] = 'pm_prefs';
		require_once (e_PLUGIN . "pm/pm_class.php");

		require_once (e_PLUGIN . "pm/pm_func.php");

		// $lan_file = e_PLUGIN . "pm/languages/" . e_LANGUAGE . ".php";
		// include_once(is_readable($lan_file) ? $lan_file : e_PLUGIN . "pm/languages/English.php");

		e107::includeLan(e_PLUGIN . 'pm/languages/' . e_LANGUAGE . '.php');
		$pm_prefs = $sysprefs->getArray("pm_prefs");
		$bday_pmfrom = ($plugPref['bday_pmfrom'] > 0 ? $plugPref['bday_pmfrom'] : 1);
		$bday_pm = new private_message;

		// PM User

		$sql->select("user", "*", "where user_name='$name'", "", false);
		$row = $sql->fetch();
		extract($row);
		if ($user_id > 0)
		{
			$bday_vars['pm_subject'] = $subj;
			$bday_vars['pm_message'] = $emessage;
			$bday_vars['to_info']['user_id'] = $user_id;
			$bday_vars['from_id'] = $bday_pmfrom;
			$bday_vars['to_info']['user_email'] = $user_email;
			$bday_vars['to_info']['user_name'] = $user_name;
			$bday_vars['to_info']['user_class'] = $user_class;
			$res = $bday_pm->add($bday_vars);
		}
	}
	else
	{
		if ($plugPref['bday_usecss'] == 1)
		{
     
			// Use the site theme for the email, embed in email

			$theme = $THEMES_DIRECTORY . $plugPref['sitetheme'] . "/";
			$style_css = file_get_contents(e_THEME . $plugPref['sitetheme'] . "/style.css");
			$mail_head.= "<style>\n" . $style_css . "\n</style>";
			$message = $mail_head;
			$message.= "</head>\n<body>\n";
			$message.= "<div style='padding:10px;width:97%'><div class='forumheader3'>\n";
			$message.= $tp->toHTML($emessage, true) . "</div></div></body></html>";
		}
		else
		{
			$message = $mail_head;
			$message.= "</head>\n<body>\n";
			$message.= $tp->toHTML($emessage, true) . "</body></html>";
			$message = str_replace("&quot;", '"', $message);
			$message = str_replace('src="', 'src="' . SITEURL, $message);
		}
 
 		$eml = array(
					'subject' 		=> $subj,
					'sender_email'	=> $plugPref['bday_emailaddr'],
					'sender_name'	=> $plugPref['bday_emailfrom'],
					'html'			=> true,
					'template'		=> 'default',
					'body'			=> $message
		);
    
		e107::getEmail()->sendEmail($to, $subj, $eml);
    //new: sendEmail($send_to, $to_name, $eml = array(), $bulkmail = false)
		//old: sendEmail($to, $subj, $message, $name, $plugPref['bday_emailaddr'], $plugPref['bday_emailfrom']);

	}
}

/**
 * bday_avatar()
 *
 * @param string $bday_avatar
 * @param integer $user_id
 * @return
 */

// renamed to be able to run old and new together

function birthday_avatar($bday_avatar = '', $user_id = 0)
{
	global $FILES_DIRECTORY;
	$plugPref = e107::getPlugPref('birthday');
	
	$data = e107::user($user_id);
	
	$parm = array(
				'w' => BDAY_AVHEIGHT,
				'h' => BDAY_AVHEIGHT,
				'crop' => 'C',
			  'shape' => BDAY_AVSHAPE
				);
	
	return e107::getParser()->toAvatar($data, $parm);
 
}