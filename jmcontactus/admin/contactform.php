<?php
/*
+---------------------------------------------------------------+
 *	Contact Us Plugin for CMS e107
 *	by Spinning Planet (www.spinningplanet.co.nz)
 *  modified and supported for version 2 by
 *  Jimako (www.e107sk.com) 
 *  with kindly permission from Spinning Planet
 *	Released under the terms and conditions of the
 *	GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
+---------------------------------------------------------------+
*/
//// Required ///////////////////////////////////////////////////
require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

require_once("admin_leftmenu.php");       
										 
if(e_PAGE == "contactform.php") 
{
	e107::js('jmcontactus',  "js/bootstrap-growl.min.js", 'jquery');
	e107::js('jmcontactus',  "js/contact-admin.js", 'jquery');
	// e107::js('jmcontactus',  "js/jquery-ui.sortable.min.js", 'jquery');
}

new jmcontactus_admin_adminArea();
require_once(e_ADMIN."header.php"); 
/////////////////////////////////////////////////////////////////


$caption = CUP_FORM_TITLE;
$pname = 'jmcontactus';

$ns = e107::getRender();
$tp = e107::getParser();
$frm = e107::getForm();
$sql = e107::getDb();
 
if (isset($_POST['update_form'])) 
{
	foreach($_POST[$pname."_name"] as $k => $name) 
	{   
		if (is_numeric($k)) 
		{
			$req = ($k<=4) ? 1 : intval($_POST[$pname."_req"][$k]);
			$type = ($k>4) ? "type='".$tp->toDB($_POST[$pname."_type"][$k])."'," : "";
			$vars = explode(",",$_POST[$pname."_vars"][$k]);
			$sql->update(strtolower($pname."_form"), "name='".$tp->toDB($name)."', req=".$req.", ".$type." vars='".serialize($vars)."' WHERE id=".intval($k), true);
		} 
		else if(!empty($name)) 
		{
			$vars = explode(",",$_POST[$pname."_vars"]['new']);
			$order = count($_POST[$pname."_name"]);
			$sql->insert(strtolower($pname."_form"), "NULL, '".$tp->toDB($name)."', ".intval($_POST[$pname."_req"]['new']).", '".$tp->toDB($_POST[$pname."_type"]['new'])."', '".serialize($vars)."', ".$order);
		}
	}
  	e107::js('footer-inline',  "$.bootstrapGrowl('".$tp->toJS(CUP_UPDATE_CONF)."', {type: 'success'});");
	//	$js_function_call[] = "$.bootstrapGrowl('".$tp->toJS(CUP_UPDATE_CONF)."', {type: 'success'});";
}

// The following form output will be put into variable $text.
// The form will call admin_config_edit for further actions.
// All language dependent text are referring to the language file.
// E.g. .YFP_CONF_01. will retrieve the accompanying text.
// Remember NOT to put comments in the text as they will be published.
// In the form data is retrieved from table core, record SitePrefs using $pref
$text = "<div style='text-align:center'>";
$text .= $frm->open($pname."_settings", "post", e_REQUEST_URI);
$text .= "<table class='fborder' style='".ADMIN_WIDTH."'>";
$text .= "<tr>";
$text .= "<td class='fcaption' style='width:5%; text-align:center;'>".CUP_FORM_CAP_ORDER."</td>";
$text .= "<td class='fcaption' style='width:25%;'>".CUP_FORM_CAP_NAME."</td>";
$text .= "<td class='fcaption' style='width:5%; text-align:center;'>".CUP_FORM_CAP_REQ."</td>";
$text .= "<td class='fcaption' style='width:15%;'>".CUP_FORM_CAP_TYPE."</td>";
$text .= "<td class='fcaption' style='width:40%;'>".CUP_FORM_CAP_VARS." <span class='smalltext'>(".CUP_FORM_CAP_VARS_HELP.")</span></td>";
$text .= "<td class='fcaption' style='width:10%; text-align:center;'>".CUP_FORM_CAP_OPT."</td>";
$text .= "</tr>";
$text .= "<tbody id='order_container'>";

$rows = $sql->retrieve("jmcontactus_form", "*", " WHERE 1 ORDER BY `order`", true);

foreach($rows as $row) 
{
		// Email to            
		$text .= "<tr class='dragorder' id='listItem_".$row["id"]."' style='background-color:#FFF;'>";
		$text .= "<td class='forumheader3 move_item' style='text-align:center; cursor:move;'><i class='fa fa-bars'></i></td>";
		//	$text .= "<td class='forumheader3'>".$f->form_text($pname."_name[".$row['id']."]", "20", $row["name"])."</td>";
		$text .= "<td class='forumheader3'>".$frm->text($pname."_name[".$row['id']."]", $row["name"],  'size=20')."</td>";		
		$text .= "<td class='forumheader3' style='text-align:center;'>"
		.$frm->checkbox($pname."_req[".$row['id']."]", 1, ($row["req"] == 1) ? 1:0, "", (($row["id"]<=4)?"disabled":"") )."</td>";
		$text .= "<td class='forumheader3'>".
		$frm->select_open($pname."_type[".$row['id']."]", (($row["id"]<=4)?"disabled":"")).
		$frm->option("text", "text", (($row["type"] == "text") ? 1 : 0)).
		$frm->option("email", "email", (($row["type"] == "email") ? 1 : 0)).
		$frm->option("textarea", "textarea", (($row["type"] == "textarea") ? 1 : 0)).
		$frm->option("checkbox", "checkbox", (($row["type"] == "checkbox") ? 1 : 0)).
		$frm->option("radio", "radio", (($row["type"] == "radio") ? 1 : 0)).
		$frm->option("dropdown", "dropdown", (($row["type"] == "dropdown") ? 1 : 0)).
		$frm->option("date", "date", (($row["type"] == "date") ? 1 : 0)).
		$frm->option("hidden", "hidden", (($row["type"] == "hidden") ? 1 : 0)).
		$frm->select_close().
		"</td>";      
		//$text .= "<td class='forumheader3'>".$f->form_text($pname."_vars[".$row['id']."]", "40", implode(",",unserialize($row["vars"])) )."</td>";
		$text .= "<td class='forumheader3'>".$frm->text($pname."_vars[".$row['id']."]", implode(",",unserialize($row["vars"])), 80, "size=40")."</td>";		
		
		$text .= "<td class='forumheader3' style='text-align:center;'>
			<button type='button' id='".$row['id']."' ".(($row["id"]<=4)?"class='btn btn-danger' disabled":" class='btn btn-danger item_delete'")."><i class='fa fa-trash-o'></i></button>
		</td>";
		$text .= "</tr>";
 
}
$text .= "</tbody>";				  
$text .= "<tr>";
$text .= "<td class='fcaption' style='text-align:center;'>New</td>";
$text .= "<td class='forumheader3'>".$frm->text($pname."_name[new]", '', '', 'size=20')."</td>";
$text .= "<td class='forumheader3' style='text-align:center;'>".$frm->checkbox($pname."_req[new]", 1)."</td>";
$text .= "<td class='forumheader3'>".
$frm->select_open($pname."_type[new]").
$frm->option("text", "text",  0).
$frm->option("email", "email", 0).
$frm->option("textarea", "textarea", 0).
$frm->option("checkbox", "checkbox", 0).
$frm->option("radio", "radio", 0).
$frm->option("dropdown", "dropdown", 0).
$frm->option("date", "date", 0).
$frm->option("hidden", "hidden", 0).
$frm->select_close().
"</td>";
$text .= "<td class='forumheader3'>".$frm->text($pname."_vars[new]", "40", '')."</td>";
$text .= "<td class='forumheader3' style='text-align:center;'>&nbsp;</td>";
$text .= "</tr>";
				 
// button
$text .= "<tr><td class='forumheader3' colspan='6' style='text-align:right;'><button type='submit' name='update_form' id='update_form' value='Update Form' class='btn btn-primary'>".CUP_FORM_UPDATEFORM."</button></td></tr>";
$text .= "</table>";
$text .= $frm->close();
$text .= "</div>";	

// Modal
$text .= "
<div id='modal-form-delete' class='modal fade'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				<h4 class='modal-title'>".CUP_FORM_DELETEMESSAGETITLE."</h4>
			</div>
			<div class='modal-body'>
				<p><span class='fa fa-exclamation-triangle'></span> ".CUP_FORM_CONFIRMDELETE."</p>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
				<button type='button' class='btn btn-danger'>".CUP_FORM_BTN_DELETEMESSAGE."</button>
			</div>
		</div>
	</div>
</div>
";

$ns->tablerender($caption, $text);

require_once(e_ADMIN."footer.php");
exit;
 