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

/////////////////////////////////////////////////////////////////

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

require_once("admin_menu.php");       
new jmcontactus_admin_adminArea();
require_once(e_ADMIN."auth.php");

if(e_PAGE == "messages.php") 
{
	e107::js('jmcontactus',  "js/bootstrap-growl.min.js", 'jquery');
	e107::js('jmcontactus',  "js/contact-admin.js", 'jquery');
	// e107::js('jmcontactus',  "js/jquery-ui.sortable.min.js", 'jquery');
}

$caption = CUP_MESSAGE_TITLE;
 	
function hasmessages() 
{
	$sql = e107::getDb();
	$pname = 'jmcontactus';
	$count = $sql->count(strtolower($pname."_messages"), "(*)", "WHERE 1");
	return intval($count);
}		


$pname = 'jmcontactus';

$ns = e107::getRender();
$tp = e107::getParser();
$frm = e107::getForm();
$sql = e107::getDb();
 
$pname = 'jmcontactus';

//page count
$from = ($_GET['view']) ? $_GET['view'] : 0;
$limit = 10;
$total =  hasmessages();

//nextprev($url, $from, $view, $total, $td, $qs = "", $return = false)
//$pp = $yy->nextprev(e_SELF, intval($from), intval($limit), intval($total), lan_go_to, "", true);
//$parms = $total.",".$limit.",".$from.",".e_SELF."?view=[FROM]";
$url = rawurlencode(e_SELF.'?mode='.$_GET['mode'].'&action='.$_GET['action'].'&view=[FROM]');
					$nextprev = array(
								'total'			=> $total,
								'amount'		=> $limit,
								'current'		=> $from,
								'url'			=> urldecode($url),
							//	'caption'		=> false,
								'tmpl_prefix'	=>'default'
					);
 					
					$npParms = http_build_query($nextprev,false,'&');
$pp = $tp->parseTemplate("{NEXTPREV={$npParms}}");

$text = "<div style='text-align:center'>";
$text .= "<table class='fborder' style='".ADMIN_WIDTH."'>";

$query = "SELECT * FROM #".strtolower($pname."_messages")." WHERE 1 ORDER BY `date` DESC LIMIT ".intval($from).",".intval($limit) ;
 
if($rows = $sql->retrieve($query, true)) 
{
  	foreach($rows as $row) 
  	{
		$msg ="";
		$id = $row['id'];
		$fields = unserialize($row["msg"]);     
		$msg .= "<tbody test id='".$id."_message' style='display:none;'>";
		foreach($fields as $k => $f) 
		{ 
			//if (eregxi('@', $f)) {
			if (preg_match('#@#i', $f)) 
			{
				$email = $f;
			}
			if($k) 
			{
				$msg .= "<tr>";
				$msg .= "<td class='forumheader3 smalltext'><strong>".$k.":</strong></td>";
				$msg .= "<td class='forumheader3 smalltext'>".$f."</td>";
				$msg .= "<td class='forumheader3'>&nbsp;</td>";
				$msg .= "</tr>";
			}
		}
		$msg .= "</tbody>";
    
		$text .= "<tbody><tr class='e-expandit'>";
		$text .= "<td class='fcaption' onclick='expandit(\"".$id."_message\");' colspan='2' style='cursor:pointer;'>View message from ".$email." on ".date("dS M Y h:ia",$row["date"])."</td>";
		$text .= "<td class='fcaption' style='text-align:center; width:5%;'><button type='button' class='btn btn-danger message_delete' id='".$id."'><i class='fa fa-trash-o'></i></button></td>";
		$text .= "</tbody></tr>";
		$text .= $msg;
	}
}

$text .= "</table>";
$text .= "</div>";
$text .= '
	<div class="text-center">
		'.$pp.'
	</div>
';

// Modal
$text .= "
<div id='modal-message-delete' class='modal fade'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				<h4 class='modal-title'>".CUP_MESSAGE_DELETEMESSAGETITLE."</h4>
			</div>
			<div class='modal-body'>
				<p><span class='fa fa-exclamation-triangle'></span> ".CUP_MESSAGE_CONFIRMDELETE."</p>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
				<button type='button' class='btn btn-danger'>".CUP_MESSAGE_BTN_DELETEMESSAGE."</button>
			</div>
		</div>
	</div>
</div>
";

$ns->tablerender($caption, $text);

require_once(e_ADMIN."footer.php");
exit;
 