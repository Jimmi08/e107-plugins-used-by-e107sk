<?php

/**
 * @file
 * Addon file to display help block on Admin UI.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/[PLUGIN]/languages/[LANGUAGE]_admin.php
e107::lan('jmgoogleads', true);


/**
 * Class jmgoogleads_help.
 */
class jmgooglead_help
{

	private $action;

	public function __construct()
	{
		$this->action = varset($_GET['action'], '');
		$this->renderHelpBlock();
	}

	public function renderHelpBlock()
	{
		switch($this->action)
		{
			default:
				$block = $this->getHelpBlockListPage();
				break;
		}

		if(!empty($block))
		{
			e107::getRender()->tablerender($block['title'], $block['body']);
		}
	}

	public function getHelpBlockListPage()
	{
		$content = '';
		$links = array();
		$links['supportforum']  =  "https://www.e107.sk/forum/jm-google-ad-plugin/";
		$links['documentation']  =  "https://www.e107.sk/documentation/jm-google-ads-plugin/?cat.189";	
		$content .= '<p class="text-center">' . LAN_JMGOOGLEAD_ADMIN_HELP_02 . '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a href="'.$links['supportforum'].'" target="_blank">' . LAN_JMGOOGLEAD_ADMIN_HELP_03. '</a>';
		$content .= '</p>';



		$content .= '<p class="text-center">' . LAN_JMGOOGLEAD_ADMIN_HELP_04 . '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a href="'.$links['documentation'].'" target="_blank">' . LAN_JMGOOGLEAD_ADMIN_HELP_05. '</a>';
		$content .= '</p>';
 

		$block = array(
			'title' => LAN_JMGOOGLEAD_ADMIN_HELP_01,
			'body'  => $content,
		);

		return $block;
	}

}


new jmgooglead_help();
