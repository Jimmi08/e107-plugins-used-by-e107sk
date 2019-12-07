<?php

if (!defined('e107_INIT'))
{
	exit;
}

if (e107::isInstalled('jm_jplayer'))
{
	if (USER_AREA && e107::getMenu()->isLoaded('jm_jplayer'))
	{
		$jm_jplayer = e107::getSingleton('jm_jplayer', e_PLUGIN . 'jm_jplayer/jm_jplayer.class.php');
	}
}

?>