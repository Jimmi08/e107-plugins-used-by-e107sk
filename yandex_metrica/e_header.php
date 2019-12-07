<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Related configuration module - News
 *
 *
*/

if (!defined('e107_INIT')) { exit; }


if(USER_AREA) // prevents inclusion of JS/CSS/meta in the admin area.
{
	$pluginPrefs = e107::getPlugPref('yandex_metrica');   
	extract($pluginPrefs);
	
	if($yandex_metrika_active) {
 	 if($yandex_metrika_id > 0) {    
	    if($yandex_metrika_script != '' ) {
	       $script =  html_entity_decode($yandex_metrika_script, ENT_QUOTES);
	    }
	    else {
        
        $yandex_metrika_clickmap =  $yandex_metrika_clickmap ? 'true' : 'false';  
        $yandex_metrika_trackLinks =  $yandex_metrika_trackLinks ? 'true' : 'false';  
        $yandex_metrika_accurateTrackBounce = $yandex_metrika_accurateTrackBounce ? 'true' : 'false';  
        $yandex_metrika_webvisor = $yandex_metrika_webvisor ? 'true' : 'false';  
       
      // inline footer script can't start with <!--    
      $script ='
			<script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter' . $yandex_metrika_id . ' = new Ya.Metrika2({ id:' . $yandex_metrika_id . ', clickmap:' . $yandex_metrika_clickmap . ', trackLinks:' . $yandex_metrika_trackLinks. ', accurateTrackBounce:' . $yandex_metrika_accurateTrackBounce  . ', webvisor:' . $yandex_metrika_webvisor . ' }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/' . $yandex_metrika_id . '" style="position:absolute; left:-9999px;" alt="" /></div></noscript>';
		 }					
		if($yandex_metrika_footer )  {
			   e107::js('footer-inline', $script);
		}
		else {
			   e107::js('inline', $script);
		}
 
		}
	}
}



?>