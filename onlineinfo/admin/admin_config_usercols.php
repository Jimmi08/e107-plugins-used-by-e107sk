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
        
$pref['onlineinfo_admincolour']=$_POST['onlineinfo_admincolour'];
$pref['onlineinfo_modcolour']=$_POST['onlineinfo_modcolour'];
$pref['onlineinfo_memcolour']=$_POST['onlineinfo_memcolour'];
$pref['onlineinfo_headadmincolour']=$_POST['onlineinfo_headadmincolour'];
$pref['onlineinfo_onoffcolour']=$_POST['onlineinfo_onoffcolour'];
$pref['onlineinfo_headadminactive']=$_POST['onlineinfo_headadminactive'];
$pref['onlineinfo_adminactive']=$_POST['onlineinfo_adminactive'];
$pref['onlineinfo_memactive']=$_POST['onlineinfo_memactive'];
$pref['onlineinfo_modactive']=$_POST['onlineinfo_modactive'];
  
              
save_prefs('core');
e107::getPlugConfig('onlineinfo')->setPref($pref)->save();

              //$sql=new db;

//$script='TRUNCATE TABLE '.MPREFIX.'onlineinfo_userclasses';
//$sql->db_Select_gen($script);


for($a = 0; $a <= $_POST['onlineinfo_classcounter']; $a++){
	
	if ($a<>0){$buildclasssave.=',';}
			
	$buildclasssave.=$_POST['onlineinfo_classid'.$a].'|'.$_POST['onlineinfo_classcol'.$a].'|'.$_POST['onlineinfo_classact'.$a].'|'.$_POST['onlineinfo_classpri'.$a];
	
	//code for using a database table if Prefs is too slow
	
//	if($_POST['onlineinfo_classact'.$a]==1){
	
//	$script="INSERT INTO ".MPREFIX."onlineinfo_userclasses VALUES (".$_POST['onlineinfo_classid'.$a].",'".$_POST['onlineinfo_classcol'.$a]."',".$_POST['onlineinfo_classpri'.$a].")";
//	$sql->db_Select_gen($script);	
			
//	}
	
}


		 
	 
	$sql -> db_Update("onlineinfo_cache", "cache='".$buildclasssave."' WHERE type='classcolour'");	



	$ns -> tablerender('', '<div style="text-align:center"><b>' .ONLINEINFO_LOGIN_MENU_A1.' ( '.ONLINEINFO_LOGIN_MENU_A101. ' )</b></div>');


}

class onlineinfo_usercols_adminArea extends onlineinfomenu_adminArea

{
	protected $modes = array(
		'usercols' => array(
			'controller' => 'onlineinfo_usercols_ui',
			'path' => null,
			'ui' => 'onlineinfo_usercols_form_ui',
			'uipath' => null
		) ,
	);
	
}

class onlineinfo_usercols_ui extends e_admin_ui

{
	protected $pluginTitle = ONLINEINFO_LOGIN_MENU_A2;
	protected $pluginName = 'onlineinfo';
 
		// optional - a custom page.  
		public function SettingsPage()
		{
    
    include_once(e_PLUGIN.'onlineinfo/functions.php');
    
    $plugPref =  e107::pref('onlineinfo');
 
$onlineinfo_admincolour = $plugPref['onlineinfo_admincolour'];
$onlineinfo_modcolour = $plugPref['onlineinfo_modcolour'];
$onlineinfo_memcolour = $plugPref['onlineinfo_memcolour'];
$onlineinfo_headadmincolour = $plugPref['onlineinfo_headadmincolour'];
$onlineinfo_onoffcolour = $plugPref['onlineinfo_onoffcolour'];
$onlineinfo_headadminactive = $plugPref['onlineinfo_headadminactive'];
$onlineinfo_adminactive = $plugPref['onlineinfo_adminactive'];
$onlineinfo_memactive = $plugPref['onlineinfo_memactive'];
$onlineinfo_modactive = $plugPref['onlineinfo_modactive'];


		$sql=new db;
		$script="SELECT cache FROM ".MPREFIX."onlineinfo_cache Where type='classcolour'";
		$onlineinfo_classcolour = $sql->gen($script);
		while ($row = $sql->fetch())
		{
			
			$buildclasslist=$row['cache'];

		}


$splitclasslist = explode(',',$buildclasslist);

$text = '<script language="JavaScript" src="'.e_PLUGIN_ABS.'onlineinfo/admin/picker.js"></script>

<div style="text-align:center">
<form method="POST" action="'.e_REQUEST_URL.'" name="menu_conf_form">
<table class="fborder">
<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A104. '</td>
<td class="forumheader3" colspan="3">'.Create_yes_no_dropdown('onlineinfo_onoffcolour',$onlineinfo_onoffcolour).'</td>
</tr>
<tr><td class="forumheader" colspan="4">'.ONLINEINFO_LOGIN_MENU_A101.'</td></tr>

<tr><td class="forumheader3" style="text-align:center; font-weight:bold;">'.ONLINEINFO_LOGIN_MENU_A30.'</td><td class="forumheader3" style="text-align:center; font-weight:bold;">'.ONLINEINFO_LOGIN_MENU_A189.'</td><td class="forumheader3"  colspan="2" style="text-align:center; font-weight:bold;">'.ONLINEINFO_LOGIN_MENU_A190.'</td></tr>

<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A179. '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_headadmincolour" size="12" value="'.$onlineinfo_headadmincolour.'" maxlength="12" /> <a href="javascript:TCP.popup(document.forms[\'menu_conf_form\'].elements[\'onlineinfo_headadmincolour\'])"><img width="15" height="13" border="0" alt="'.ONLINEINFO_LOGIN_MENU_A159.'" src="'.e_PLUGIN.'onlineinfo/images/sel.gif"></a></td>
<td class="forumheader3" colspan="2" style="text-align:center;">'.Create_yes_no_dropdown("onlineinfo_headadminactive",$onlineinfo_headadminactive).'</td>
</tr>

<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A40. '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_admincolour" size="12" value="'.$onlineinfo_admincolour.'" maxlength="12" /> <a href="javascript:TCP.popup(document.forms[\'menu_conf_form\'].elements[\'onlineinfo_admincolour\'])"><img width="15" height="13" border="0" alt="'.ONLINEINFO_LOGIN_MENU_A159.'" src="'.e_PLUGIN.'onlineinfo/images/sel.gif"></a></td>
<td class="forumheader3" colspan="2" style="text-align:center;">'.Create_yes_no_dropdown("onlineinfo_adminactive",$onlineinfo_adminactive).'</td>
</tr>

<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A41. '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_modcolour" size="12" value="'.$onlineinfo_modcolour.'" maxlength="12" /> <a href="javascript:TCP.popup(document.forms[\'menu_conf_form\'].elements[\'onlineinfo_modcolour\'])"><img width="15" height="13" border="0" alt="'.ONLINEINFO_LOGIN_MENU_A159.'" src="'.e_PLUGIN.'onlineinfo/images/sel.gif"></a></td>
<td class="forumheader3" colspan="2" style="text-align:center;">'.Create_yes_no_dropdown("onlineinfo_modactive",$onlineinfo_modactive).'</td>
</tr>

<tr>
<td class="forumheader3">' .ONLINEINFO_LOGIN_MENU_A42. '</td>
<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_memcolour" size="12" value="'.$onlineinfo_memcolour.'" maxlength="12" /> <a href="javascript:TCP.popup(document.forms[\'menu_conf_form\'].elements[\'onlineinfo_memcolour\'])"><img width="15" height="13" border="0" alt="'.ONLINEINFO_LOGIN_MENU_A159.'" src="'.e_PLUGIN.'onlineinfo/images/sel.gif"></a></td>
<td class="forumheader3" colspan="2" style="text-align:center;">'.Create_yes_no_dropdown("onlineinfo_memactive",$onlineinfo_memactive).'</td>
</tr>

<tr><td class="forumheader" colspan="4">'.ONLINEINFO_LOGIN_MENU_A187.'</td></tr>
<tr><td class="forumheader3" colspan="4">'.ONLINEINFO_LOGIN_MENU_A192.'</td></tr>
<tr><td class="forumheader3" style="text-align:center; font-weight:bold;">'.ONLINEINFO_LOGIN_MENU_A188.'</td><td class="forumheader3" style="text-align:center; font-weight:bold;">'.ONLINEINFO_LOGIN_MENU_A189.'</td><td class="forumheader3" style="text-align:center; font-weight:bold;">'.ONLINEINFO_LOGIN_MENU_A190.'</td><td class="forumheader3" style="text-align:center; font-weight:bold;">'.ONLINEINFO_LOGIN_MENU_A191.'</td></tr>
';

$classcol=0;


$script="SELECT * FROM ".MPREFIX."userclass_classes ORDER BY userclass_id";		
		$sql->gen($script);	
		while ($row = $sql->fetch())
        {
        	extract($row);
        	
        	$checkhowmanyinsaved = count($splitclasslist);
        	
        	$foundit=-1;
        	
        	for($a = 0; $a <= $checkhowmanyinsaved; $a++){
				
			$getclasssaveddetails = explode('|',$splitclasslist[$a]);
				
			if($userclass_id==$getclasssaveddetails[0]){
				
				$foundit=$a;
			}
				
			}
        	        	
        	if($foundit<>-1){
			     	$getclasssaveddetails = explode('|',$splitclasslist[$foundit]);    
        	
   $text.='<tr>
   			<td class="forumheader3">'.$userclass_name.' ('.$userclass_description.')</td>     	
        	<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_classcol'.$classcol.'" size="12" value="'.$getclasssaveddetails[1].'" maxlength="12" />
			<input type="hidden" name="onlineinfo_classid'.$classcol.'" value="'.$userclass_id.'" />
			 <a href="javascript:TCP.popup(document.forms[\'menu_conf_form\'].elements[\'onlineinfo_classcol'.$classcol.'\'])"><img width="15" height="13" border="0" alt="'.ONLINEINFO_LOGIN_MENU_A159.'" src="'.e_PLUGIN.'onlineinfo/images/sel.gif"></a></td>
			 <td class="forumheader3" style="text-align:center;">'.Create_yes_no_dropdown("onlineinfo_classact".$classcol,$getclasssaveddetails[2]).'</td>
			 <td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_classpri'.$classcol.'" size="3" value="'.$getclasssaveddetails[3].'" maxlength="3" /></td>
        	</tr>';        
    	
        }else{
        
		 $text.='<tr>
   			<td class="forumheader3">'.$userclass_name.' ('.$userclass_description.')</td>     	
        	<td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_classcol'.$classcol.'" size="12" value="#000000" maxlength="12" />
			<input type="hidden" name="onlineinfo_classid'.$classcol.'" value="'.$userclass_id.'" />
			 <a href="javascript:TCP.popup(document.forms[\'menu_conf_form\'].elements[\'onlineinfo_classcol'.$classcol.'\'])"><img width="15" height="13" border="0" alt="'.ONLINEINFO_LOGIN_MENU_A159.'" src="'.e_PLUGIN.'onlineinfo/images/sel.gif"></a></td>
			 <td class="forumheader3" style="text-align:center;">'.Create_yes_no_dropdown("onlineinfo_classact".$classcol,"0").'</td>
			 <td class="forumheader3" style="text-align:center;"><input class="tbox" type="text" name="onlineinfo_classpri'.$classcol.'" size="3" value="0" maxlength="3" /></td>
        	</tr>';	
        	
			
		}	
        
		
		
			$classcol++;        	        	
        	
        }
        
        $classcol=$classcol-1;
        
$text.='<input type="hidden" name="onlineinfo_classcounter" value="'.$classcol.'" />

<tr>
<td colspan="4" class="forumheader" style="text-align:center"><input class="button" type="submit" name="update_menu" value="' .ONLINEINFO_LOGIN_MENU_A56. '" /></td>
</tr>
</table>
</form>
</div>';

return $text;
			 
			 
			
		}
}

class onlineinfo_usercols_form_ui extends e_admin_form_ui

{
}

new onlineinfo_usercols_adminArea();
require_once (e_ADMIN . "auth.php");

e107::getAdminUI()->runPage();
require_once (e_ADMIN . "footer.php");

exit;
 