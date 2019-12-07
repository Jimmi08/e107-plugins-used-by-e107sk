<?php 
if (!defined('e107_INIT')) { exit; }
e107::lan('jm_jplayer',true);

$text = "<table class='help-table' style='width:100%'>
<tr><td colspan='2'>".LAN_JPLAYER_HELP_06." </td></tr>
<tr><!--<td>&nbsp;<b>&middot;</b></td>--><td>".LAN_JPLAYER_HELP_02."</td></tr>
<tr><!--<td>&nbsp;<b>&middot;</b></td>--><td>".LAN_JPLAYER_HELP_03."</td></tr>
<tr><!--<td>&nbsp;<b>&middot;</b></td>--><td>".LAN_JPLAYER_HELP_04."</td></tr>
<tr><!--<td>&nbsp;<b>&middot;</b></td>--><td>".LAN_JPLAYER_HELP_05."</td>";

$text .= "</table>";

$ns->tablerender(LAN_JPLAYER_HELP_01,$text);

?>