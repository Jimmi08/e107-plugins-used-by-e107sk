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
require_once(e_ADMIN.'auth.php');

/////////////////////////////////////////////////////////////////

$text = "<div style='text-align:center'>";
$text .= "<table class='fborder' style='".ADMIN_WIDTH."'>";
	
// Help Files
$text .= "<tr>";
$text .= "<td class='fcaption' style='width:50%;'><strong>Help Files (Readme & Video Tutorial)</strong></td>";
$text .= "<td class='fcaption' style='width:50%;' valign='top'><strong>Help Files (Readme & Video Tutorial)</strong></td>";
$text .= "</tr>";
$text .= "<tr>";
$text .= "<td class='forumheader3' style='width:50%;'>";
$text .= "<iframe width='560' height='315' src='http://www.youtube.com/embed/jclKkPyc_qI?hd=1' frameborder='0' allowfullscreen></iframe>";
$text .= "<div>If you want to read the Readme you can <a href='".e_PLUGIN."jmcontactus/docs/ContactUs_Documentation.pdf' target='_blank'>download the documentation</a></div>";
$text .= "</td>";		
$text .= "<td class='forumheader3' style='width:50%;' valign='top'>";
$text .= "<strong>Parameters:</strong> All parameters should be separated by commas, here is what the parameters will be:";
$text .= "<div><strong>Text:</strong> length of textbox, maxlength allowed</div>";
$text .= "<div><strong>Email:</strong> length of textbox, maxlength allowed</div>";
$text .= "<div><strong>textarea:</strong> # of cols, # of rows</div>";
$text .= "<div><strong>checkbox:</strong> Options separated by commas</div>";
$text .= "<div><strong>radio:</strong> Options separated by commas</div>";
$text .= "<div><strong>dropdown:</strong> Options separated by commas</div>";
$text .= "<div><strong>date:</strong> use strftime (php) %d/%m/%y to have date represented as ".date("d/m/y",time()).". <a href='http://www.php.net/manual/en/function.strftime.php' target='_blank'>More Information</a></div>";
$text .= "</td>";
$text .= "</tr>";
$text .= "</table>";
$text .= "</div>";	

// Display the $text string into a rendered table with a caption from the language file
$caption = CUP_HELP_00;
$ns->tablerender($caption, $text);
// Display the footer of the current website
require_once(e_ADMIN.'footer.php');
?>