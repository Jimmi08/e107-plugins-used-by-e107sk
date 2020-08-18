<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2016 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * onlineinfo menu file.
 *
 */


if (!defined('e107_INIT')) { exit; }

$plugPref =  e107::pref('onlineinfo');
$sql = e107::getDB(); 				// mysql class object

// $tp = e107::getParser(); 			// parser for converting to HTML and parsing templates etc.
// $frm = e107::getForm(); 				// Form element class.
// $ns = e107::getRender();				// render in theme box.

$text = '';

//$text.="<script type='text/javascript' src='".e_PLUGIN_ABS."onlineinfo/switchcontent.js'></script>";



$lan_file = e_PLUGIN."onlineinfo/languages/".e_LANGUAGE.".php";
include_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."onlineinfo/languages/English.php");

include_once(e_PLUGIN."onlineinfo/functions.php");


$ispminstalled = e107::isInstalled('pm');

$inlinecss =   '#onlineinfodhtmltooltip{
position: absolute;
width: 100px;
border: 2px solid '.$plugPref['onlineinfo_border'].';
padding: 2px;
background-color: '.$plugPref['onlineinfo_color'].';
visibility: hidden;
z-index: 100;
}
';

e107::css('header', $inlinecss);
e107::js("footer", e_PLUGIN_ABS."onlineinfo/switchcontent.js", "jquery");
e107::js("footer", e_PLUGIN_ABS."onlineinfo/online.js", "jquery");

$text.= '<div id="onlineinfodhtmltooltip"></div> ';

$onlineinfomenuwidth=$plugPref['onlineinfo_width'];
$onlineinfomenucolour=$plugPref['onlineinfo_flashtext_colour'];
$onlineinfomenufsize=$plugPref['onlineinfo_fontsize'];



$code =" 
		var showhide=new switchcontent('switchgroup1', 'div') //Limit scanning of switch contents to just div elements
		showhide.setStatus('<img src=\"".e_PLUGIN_ABS."onlineinfo/images/minus.gif\" width=\"11px\" alt=\"\" /> ', '<img src=\"".e_PLUGIN_ABS."onlineinfo/images/plus.gif\" width=\"11px\" alt=\"\" /> ')
		// showhide.setColor('#FFFFFF','#EAAE10')
		showhide.collapsePrevious(false) //Allow more than 1 content to be open simultanously
		showhide.setPersist(".$plugPref['onlineinfo_rememberbuttons'].")
		showhide.init() ";
  

$code.='
 
var flashlinks=new Array()
function changelinkcolor(){
for (i=0; i< flashlinks.length; i++){
var flashtype=document.getElementById? flashlinks[i].getAttribute("flashtype")*1 : flashlinks[i].flashtype*1
var flashcolor=document.getElementById? flashlinks[i].getAttribute("flashcolor") : flashlinks[i].flashcolor
if (flashtype==0){
if (flashlinks[i].style.color!=flashcolor)
flashlinks[i].style.color=flashcolor
else
flashlinks[i].style.color=""
}
else if (flashtype==1){
if (flashlinks[i].style.backgroundColor!=flashcolor)
flashlinks[i].style.backgroundColor=flashcolor
else
flashlinks[i].style.backgroundColor=""
}
}
}

function init(){
var i=0
if (document.all){
while (eval("document.all.flashlink"+i)!=null){
flashlinks[i]= eval("document.all.flashlink"+i)
i++
}
}
else if (document.getElementById){
while (document.getElementById("flashlink"+i)!=null){
flashlinks[i]= document.getElementById("flashlink"+i)
i++
}
}
setInterval("changelinkcolor()", 500)
}

if (window.addEventListener)
window.addEventListener("load", init, false)
else if (window.attachEvent)
window.attachEvent("onload", init)
else if (document.all)
window.onload=init
 
';


e107::js("footer-inline", $code , "jquery"); 
    







$n=0;
$suspended=0;

$script = "SELECT * from #onlineinfo_suspend WHERE user_id=" . USERID . " ORDER BY user_name";
$data = $sql->gen($script);

if ($data)
{
	$text.= '<script language="javascript" type="text/javascript"> window.location="' . e_BASE . 'index.php?logout"; </script>';
}

$script = "SELECT * from " . MPREFIX . "onlineinfo_suspend WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' ORDER BY user_name";
$data = $sql->gen($script);

if ($data)
{
	$caption = ONLINEINFO_LOGIN_MENU_L83;
	$text.= "<div id='flashlink" . $n . "' flashtype=0 flashcolor='" . $onlineinfomenucolour . "' style='font-size: 14px; text-align:center; vertical-align: middle; width:" . $onlineinfomenuwidth . "; font-weight:bold;'><br />" . ONLINEINFO_LOGIN_MENU_L83 . "<br /><br /></div>";
	$text.= "<div style='text-align:left; vertical-align: middle; width:" . $onlineinfomenuwidth . "; font-weight:bold;'>" . ONLINEINFO_LOGIN_MENU_L84 . "<br /><br /></div>";
	$suspended = 1;
	$n++;
}

if ($suspended==0) {

	global $eMenuActive, $e107, $tp, $use_imagecode;
 
	
	$ip = $e107->getip();
	$bullet = (defined("BULLET") ? "<img src='" . e_THEME_ABS . "images/" . BULLET . "' alt='' style='vertical-align: middle;' />" : "<img src='" . THEME_ABS . "images/bullet2.gif' alt='bullet' style='vertical-align: middle;' />");
	
	if (defined('CORRUPT_COOKIE') && CORRUPT_COOKIE == TRUE) {
		$text = "<div style='text-align:center'>".LOGIN_MENU_L7."<br /><br />
		".$bullet." <a href='".e_BASE."index.php?logout'>".LOGIN_MENU_L8."</a></div>";
		$ns->tablerender(LOGIN_MENU_L9, $text, 'login');
	}
	
	$use_imagecode = ($plugPref['logcode'] && extension_loaded('gd'));
	
	if ($use_imagecode)
	{
		global $sec_img;
		include_once (e_HANDLER . 'secure_img_handler.php');
	
		$sec_img = new secure_image;
	}
	
	$text.= "";

  if (USER == true || ADMIN == true)
	{
	
		$sql=new db;
		$script="SELECT cache_userclass FROM ".MPREFIX."onlineinfo_cache Where type='order' and cache_name='ONLINEINFO_CACHEINFO_12'";		
		$onlineinfoorder = $sql->gen($script);		
		while ($row = $sql->fetch()){
		 $cacheuserclass=$row['cache_userclass'];
		 }

    if($ispminstalled) {
		if(check_class($cacheuserclass)){

			$pm_user = USERID;
			$unreadpms = $sql -> count("private_msg", "(*)", "WHERE pm_to=$pm_user AND pm_read_del=0 and pm_read=0");
		
			$pmpath=e_PLUGIN."pm/pm.php?inbox";

		}
		}
		
		if($plugPref['onlineinfo_showpmmsg']==1){
		
			if($unreadpms<>0)
			{
				if($plugPref['onlineinfo_sound']!="none" || $plugPref['onlineinfo_sound']!=""){
					
					$checkpath = explode("/pm/",e_SELF);
					
					if($checkpath[1] != "pm.php"){
						
				 
					
					$text.="<embed src=\"".e_PLUGIN_ABS."onlineinfo/sounds/".$plugPref['onlineinfo_sound']."\" autostart=\"true\" loop=\"0\" hidden=\"true\"></embed>";
					
						}
				}
				$text.="<div style='font-size: 14px; text-align:center; vertical-align: middle; width:".$onlineinfomenuwidth."; font-weight:bold;'><br /><a id='flashlink".$n."' flashtype=0 flashcolor='".$onlineinfomenucolour."' href='".$pmpath."' title='".ONLINEINFO_LOGIN_MENU_L82."' style='text-decoration: none;'>".ONLINEINFO_LOGIN_MENU_L81."</a><br /><br /></div>";
			
				$n++;
			
			}
		
		}
		
		list($uid, $upw) = ($_COOKIE[$plugPref['cookie_name']] ? explode(".", $_COOKIE[$plugPref['cookie_name']]) : explode(".", $_SESSION[$plugPref['cookie_name']]));
		
		$ordersql=new db;
		$script="SELECT * FROM ".MPREFIX."onlineinfo_cache Where type='order' ORDER BY type_order";		
		$onlineinfoorder = $ordersql->gen($script);
 
		while ($orderrow = $ordersql->fetch()){
		 
		 $orderhide=$orderrow['cache_hide'];
		 $orderclass=$orderrow['cache_userclass'];
            /* avatar.php
			pm.php
			currentlyonline.php
			fc.php
			amigo.php
			extrainfo.php   */
       
			if($orderrow['cache']  == "fc.php")  { /*do nothing */ }
			elseif($orderrow['cache']  == "avatar.php")  {     
			    require_once(e_PLUGIN."onlineinfo/sections/".$orderrow['cache']);
			}
			elseif($orderrow['cache']  == "pm.php")  {     
			   require_once(e_PLUGIN."onlineinfo/sections/".$orderrow['cache']);
			}
			elseif($orderrow['cache']  == "currentlyonline.php")  {     
			   require_once(e_PLUGIN."onlineinfo/sections/".$orderrow['cache']);
			}
			elseif($orderrow['cache']  == "amigo.php")  {     
			   require_once(e_PLUGIN."onlineinfo/sections/".$orderrow['cache']);
			}			
			elseif($orderrow['cache']  == "extrainfo.php")  {     
			   require_once(e_PLUGIN."onlineinfo/sections/".$orderrow['cache']);
			}
			elseif($orderrow['cache']  == "tmembers.php")  {     
			   require_once(e_PLUGIN."onlineinfo/sections/".$orderrow['cache']);
			}
      //($orderrow['cache']);      
		  else { 
        //  require_once(e_PLUGIN."onlineinfo/sections/".$orderrow['cache']);	
      }
		}
	}
  else {
  
  if ($plugPref['onlineinfo_logindiag'] == 0)
    {
        $login_box = "{MENU: path=login_menu/login}"; 
        $text = e107::getParser()->parseTemplate($login_box); 
        echo  $text;
    }

  }



  
  
 	$text.=colourkey(1);
      /*

         */
}
 	

/**** CAPTION ****/
if (USER == true || ADMIN == true) {
  if ($plugPref['onlineinfo_caption'] == "[Welcome User]")
  {
      $caption = ONLINEINFO_LOGIN_MENU_L5 . "&nbsp;".USERNAME;
  }
  else
  {
      $caption = $plugPref['onlineinfo_caption'];
  }
  e107::getRender()->tablerender($caption, $text);
}
else {
   if(($plugPref['onlineinfo_logindiag'] == 0)) {
		 
		 
   }
}

 
	
 







?>