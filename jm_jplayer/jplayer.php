<?php

if (!defined('e107_INIT'))
{
		require_once ("../../class2.php");

}

$wolf_jplayer = e107::getSingleton('Wolf_Jplayer_Show', e_PLUGIN . 'jm_jplayer/jm_jplayer.class.php');
$wolf_jplayer = new Wolf_Jplayer_Show;

if (!empty($_GET['playlist_id']) && $_GET['iframe'] == 'true')
{	
	  $embed = true;
		$in_popup = false; 						
		define('e_IFRAME', true);
		require_once (HEADERF);
		$playlist_id = intval($_GET['playlist_id']);
		$text = $wolf_jplayer->jplayer_show_iframe($playlist_id, false);
		$ns->tablerender($caption, $text, 'jm-jplayer-playlist');
}
elseif (!empty($_GET['playlist_id']) && $_GET['iframe'] == 'false')
{   define('e_IFRAME', true);
		require_once (HEADERF);
		$playlist_id = intval($_GET['playlist_id']);
		$embed = false;
		$in_popup = true;
		$text = $wolf_jplayer->jplayer_show_single($playlist_id, $in_popup, $embed);
		$ns->tablerender($caption, $text, 'jm-jplayer-playlist');
}
elseif (!empty($_GET['playlist_id']))
{
		require_once (HEADERF);
		$playlist_id = intval($_GET['playlist_id']);
		$embed = false;
		$in_popup = false;
		$text = $wolf_jplayer->jplayer_show_single($playlist_id, $in_popup, $embed);
		$ns->tablerender($caption, $text, 'jm-jplayer-playlist');
}
else
{   
		require_once (HEADERF);
		$caption = LAN_FRONT_20;
		$playlist_id = 1;
		$text = $wolf_jplayer->jplayer_show_single($playlist_id, false);
		$ns->tablerender($caption, $text, 'jm-jplayer-menu');
}

require_once (FOOTERF);

exit;
?>