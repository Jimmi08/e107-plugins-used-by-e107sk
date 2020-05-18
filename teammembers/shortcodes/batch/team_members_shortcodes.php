<?php
/**
 * @file
 * Class installation to define shortcodes for re_agents
 * @example $this->sc = e107::getScBatch('','re_agents');
 */

if (!defined('e107_INIT'))
{
	exit;
}

class plugin_teammembers_team_members_shortcodes extends e_shortcode
{
	/**
	 * re_agents plugin preferences.
	 *
	 * @var mixed|null
	 */
	private $__plugPrefs = null;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->plugPrefs = e107::getPlugConfig('re_agents')->getPref();
	}

	/**
	 * {AGENT_BIO}
	 */
	public function sc_agent_bio($parm = null)
	{ // Type: textarea
		return e107::getParser()->toHtml($this->var['bio'], true, 'DESCRIPTION');
	}

	/**
	 * {AGENT_EMAIL}
	 */
	public function sc_agent_email($parm = null)
	{ // Type: email
		return $this->var['email'];
	}

	/**
	 * {AGENT_IMAGE}
	 */
	public function sc_agent_image($parm = null)
	{
		// Type: image
		$att['class'] = varset($parm['class'], 'img');
		$att['w'] = vartrue($parm['w']) ? $parm['w'] : e107::getParser()->thumbWidth(); // 190; // 160;
		$att['h'] = vartrue($parm['h']) ? $parm['h'] : e107::getParser()->thumbHeight(); // 130;
		$att['alt'] = ''; // $this->var[''];
		return e107::getParser()->toImage($this->var['image'], $att);
	}

	/**
	 * {AGENT_SUMMARY}
	 */
	public function sc_agent_summary($parm = null)
	{
		return e107::getParser()->toHtml($this->var['summary'], true, 'TITLE');
	}

	/**
	 * {AGENT_TITLE}
	 */
	public function sc_agent_title($parm = null)
	{ // Type: text
		return e107::getParser()->toHtml($this->var['title'], true, 'TITLE');
	}

	/**
	 * {AGENT_POSITION}
	 */
	public function sc_agent_position($parm = null)
	{
		return e107::getParser()->toHtml($this->var['position'], true, 'TITLE');
	}

	/**
	 * {AGENT_DETAIL_URL}
	 */
	public function sc_agent_detail_url($parm = null)
	{
		//sef
		$url = e107::url('teammembers', 'teammember', $this->var, "full");
		return $url;
	}

	/**
	 * {AGENT_UID}
	 */
	public function sc_agent_uid($parm = null)
	{ // Type:    return $this->var['uid'];

	}

	/**
	 * {AGENT_WEBSITE}
	 */
	public function sc_agent_website($parm = null)
	{ // Type: url
		return $this->var['website'];
	}

	/**
	 * {AGENT_SOCIALLINKS}
	 */
	public function sc_agent_sociallinks($parm = null)
	{ // Type: multi
		//$this->var['links_multi'];

		$tpl = varset($parm['template'], "social_links");
		$icon_class = varset($parm['icon_class'], "tmsl");
		$links = e107::unserialize($this->var['links_multi']);

		$template = e107::getTemplate("teammembers", "team_members", $tpl);
		$start = $template['start'];
		$end = $template['end'];
		$text = '';

		//email cab be first social link
		if ($parm['email'])
		{
			$icon = "fa-envelope";
			$var['ICON'] = e107::getParser()->toGlyph($icon, array('class' => $icon_class));
			$var['PROVIDER'] = $social;
			$var['URL'] = "mailto:" . $this->var['email'];
			$text .= e107::getParser()->simpleParse($template['item'], $var);
		}

		foreach ($links as $link)
		{
			if (empty($link['text']))
			{
				continue;
			}

			$social = $link['icon'];
			$icon = "fa-" . $social;

			$var['ICON'] = e107::getParser()->toGlyph($icon, array('class' => $icon_class));

			$var['PROVIDER'] = $social;
			$var['URL'] = $link['text'];

			$text .= e107::getParser()->simpleParse($template['item'], $var);
		}
		return $start . $text . $end;
	}

	/**
	 * {AGENT_FACTS}
	 */
	public function sc_agent_facts($parm = null)
	{
		// Type: multi
		//$this->var['facts_multi'];
		$links = e107::unserialize($this->var['facts_multi']);
		$template = e107::getTemplate("teammembers", "team_members", "facts", true, true);
		$start = $template['start'];
		$end = $template['end'];
		$text = '';
		foreach ($links as $link)
		{
			if (empty($link['text']))
			{
				continue;
			}
			$var['LABEL'] = $link['label'];
			$var['TEXT'] = $link['text'];

			$text .= e107::getParser()->simpleParse($template['item'], $var);
		}
		return $start . $text . $end;
	}

}