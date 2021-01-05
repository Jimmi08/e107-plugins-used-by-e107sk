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
define("SS_FAIL", "Your result was not correct. Please try again.");
define("SS_BACK", "Back");
define("SS_REQUEST", "To prove that you are an human being figure out the following small calculation.");
define("SS_SEND", "Send my result");
define("SS_INQ", "Supported by ");

define("SS_README", "
<p>With this Plugin you defend your website from spam bots which join your site automaticly and post dozens of links to other sites.</p>
<p>The plugin alone can not defend your page perfectly. Here are some advices what you can do to make your page more secure:</p>
<ol>
  <li>Do not allow guests posting in the forum or in the comments.</li>
  <li>Do not allow guests to post or to adjust anything at your page, but very well guarded guestbooks or formulars.</li>
  <li>Backup your database periodically.</li>
  <li>Keep your e107 actual.</li>
  <li>Do not just delete spammers. Bann the regarding IP and mail adresses too.</li>
</ol>
<p>
<br /><br />
<b>Version 1.4:</b>
<ol>
  <li>Fixed for version e107 2.3.0</li>
</ol>
<br /><br />

<b>Version 1.3:</b>
<ol>
  <li>Updated to be compatible with version 2</li>
  <li>added plugin.xml</li>
  <li>updated redirect</li>
  <li>checked not hardcoded 'signup.php' but value e_SIGNUP </li>
  <li><b>Warning:</b> This will work until core signup template is not changed. </li>
</ol>
<br /><br />
 
<b>Version 1.1:</b>
<p>Pages, which using COPPA within registration are supported now 100 percently. 
Thanks a thousand times to C6Dave for the auxiliary evidence!</p>
<br /><br />
<table class='fborder' style='width:95%'>
	<tr>
		<td class='fcaption' valign='middle'>
			<blockquote>Full credit for this plugin belongs to Oyabun, but sites Oyabunstyle.de and e107-german.de don't work anymore.</blockquote>
		</td>
	</tr>
</table>
<br /><br />
</p>
");
 