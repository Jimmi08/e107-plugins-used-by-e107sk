<?php
/*
*************************************
*        Signup Secure				*
*									*
*        (C)Oyabunstyle.de			*
*        http://oyabunstyle.de		*
*        info@oyabunstyle.de		*
*************************************
*/
if (!defined('e107_INIT'))
{
    exit;
}
if (!isset($pref['plug_installed']['signup_secure']))
{
    return ;
}
include_lan(e_PLUGIN."signup_secure/languages/".e_LANGUAGE.".php");

$pluginPrefs = e107::getPlugPref('signup_secure');

$buttonClass = ($pluginPrefs['button_class']  ? 'class="'.$pluginPrefs['button_class'].'"' : '') ;
$inputClass = ($pluginPrefs['input_class']  ? 'class="'.$pluginPrefs['input_class'].'"' : 'class="tbox"') ;
$formClass = ($pluginPrefs['form_class']  ? 'class="'.$pluginPrefs['form_class'].'"' : '') ;
 
if(USER_AREA) {
	if (strpos(e_SIGNUP, e_PAGE) !== false) 
	{            
	  //if (e_PAGE==e_SIGNUP) 
		if (isset($_POST['human']) and !isset($_POST['newver']))
		{
			$coppa = $_POST["coppa"];
			$first = $_POST["first"];
			$operator = $_POST["operator"];
			$second = $_POST["second"];
			if ($operator == 0) {$var="+";$ergebnis = $first + $second;}
			elseif ($operator == 1) {$var="-";$ergebnis = $first - $second;}
			$deinergebnis = $_POST["deinergebnis"];
			if ($ergebnis!=$deinergebnis)
			{
				$SIGNUP_BEGIN = substr ("{SIGNUP_FORM_OPEN}", 18);
				$SIGNUP_BODY = substr ("{SIGNUP_FORM_CLOSE}", 19);
				
				$SIGNUP_BEGIN = "
					<h3 class='center'>
						<br />
						".SS_FAIL."
					</h3>
					<br />
					<center>
						<form action='".e_SELF."?stage1' method='post' ".$formClass.">
							<input type='hidden' name='e-token' value='".e_TOKEN."' />
							<input type='submit' name='back' ".$buttonClass." value='".SS_BACK."'/>
						</form>
					</center>
					 
				";
			}
		}
		elseif (isset($_POST['human']) and isset($_POST['newver']))
		{
			$coppa = $_POST["coppa"];
			$first = $_POST["first"];
			$operator = $_POST["operator"];
			$second = $_POST["second"];
			if ($operator == 0) {$var="+";$ergebnis = $first + $second;}
			elseif ($operator == 1) {$var="-";$ergebnis = $first - $second;}
			$deinergebnis = $_POST["deinergebnis"];
			if ($ergebnis!=$deinergebnis)
			{
				$SIGNUP_BEGIN = substr ("{SIGNUP_FORM_OPEN}", 18);
				$SIGNUP_BODY = substr ("{SIGNUP_FORM_CLOSE}", 19);
				
				$SIGNUP_BEGIN = "
					<h3 class='center'>
						<br />
						".SS_FAIL."
					</h3>
					<br />
					<center>
						<form action='".e_SELF."?stage1' method='post' ".$formClass.">
							<input type='hidden' name='coppa' value='".$coppa."' />
							<input type='hidden' name='e-token' value='".e_TOKEN."' />
							<input type='submit' name='newver' ".$buttonClass." value='".SS_BACK."'/>
						</form>
					</center>
					<br /><br /> 
				";
			}
		}
		elseif (isset($_POST['newver']))
		{
			$coppa = $_POST["coppa"];
			$first = mt_rand(10,99);
			$operator = mt_rand(0,1);
			$second = mt_rand(1,9);
			if ($operator == 0) {$var="+";}
			elseif ($operator == 1) {$var="-";}
			
			$SIGNUP_BEGIN = substr ("{SIGNUP_FORM_OPEN}", 18);
			$SIGNUP_BODY = substr ("{SIGNUP_FORM_CLOSE}", 19);
			
			$SIGNUP_BEGIN = "
				<h3 class='center'>
					<br />
					".SS_REQUEST."
					<br /><br />
				</h3>
				<form action='".e_SELF."?stage1' method='post' ".$formClass.">
				<input type='hidden' name='first' value='".$first."'/>
				<input type='hidden' name='operator' value='".$operator."'/>
				<input type='hidden' name='second' value='".$second."'/>
					<table class='fborder' style='width:95%;'>
						<tr>
							<td class='forumheader3 center' style='width:50%;'>
								<h3>".$first." ".$var." ".$second." = </h3>
							</td>
							<td class='forumheader3 center'>
								<input type='text' ".$inputClass." name='deinergebnis' />
								
							</td>
						</tr>
							<td class='forumheader3 center' colspan='2'>
								<input type='hidden' name='coppa' value='".$coppa."' />
								<input type='hidden' name='e-token' value='".e_TOKEN."' />
								<input type='hidden' name='newver' value='newver' />
								<input type='submit' name='human'  ".$buttonClass." value='".SS_SEND."'/>
							</td>
						<tr>
						</tr>
					</table>
				</form>
				<br /><br /> 
			";
	 
		}
		else
		{
			$first = mt_rand(10,99);
			$operator = mt_rand(0,1);
			$second = mt_rand(1,9);
			if ($operator == 0) {$var="+";}
			elseif ($operator == 1) {$var="-";}
	
			$SIGNUP_BEGIN = substr ("{SIGNUP_FORM_OPEN}", 18);
			$SIGNUP_BODY = substr ("{SIGNUP_FORM_CLOSE}", 19);
			
			$SIGNUP_BEGIN .= "
				<h3 class='center'>
					<br />
					".SS_REQUEST."
					<br /><br />
				</h3>
				<form action='".e_SELF."?stage1' method='post' ".$formClass.">
				<input type='hidden' name='first' value='".$first."'/>
				<input type='hidden' name='operator' value='".$operator."'/>
				<input type='hidden' name='second' value='".$second."'/>
					<table class='fborder signupsecure' style='width:95%;'>
						<tr>
							<td class='forumheader3 center' style='width:50%;'>
								<h3>".$first." ".$var." ".$second." = </h3>
							</td>
							<td class='forumheader3 center'>
								<input type='text' ".$inputClass." name='deinergebnis' />
								
							</td>
						</tr>
							<td class='forumheader3 center' colspan='2'>
								<input type='hidden' name='e-token' value='".e_TOKEN."' />
								<input type='submit' name='human' ".$buttonClass."  value='".SS_SEND."'/>
							</td>
						<tr>
						</tr>
					</table>
				</form>
				<br /><br /> 
			";
		}
 
    
		$SIGNUP_TEMPLATE['start'] = $SIGNUP_BEGIN;
 
	}
}
?>