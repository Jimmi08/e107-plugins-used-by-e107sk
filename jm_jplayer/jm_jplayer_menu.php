<?php

if (!defined('e107_INIT'))
{
		exit;
}

if (!empty($parm))
{
		if (is_string($parm))
		{
				parse_str($parm, $parms);
		}
		else
		{
				$parms = $parm;
		}
}

$caption = '';

if (isset($parms['playlist_caption'][e_LANGUAGE]))
{
		$caption = $parms['playlist_caption'][e_LANGUAGE];
}

require_once (e_PLUGIN . 'jm_jplayer/jm_jplayer.class.php');

$wolf_jplayer = new Wolf_Jplayer_Show;

if (isset($parms['playlist_id']))
{
		$playlist_id = intval($parms['playlist_id']);
}
else $playlist_id = 1;
$text = $wolf_jplayer->jplayer_show_single($playlist_id, false, false);
 
$ns->tablerender($caption, $text, 'jm-jplayer-menu');
?>