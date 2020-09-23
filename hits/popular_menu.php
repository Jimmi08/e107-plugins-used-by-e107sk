<?php
	/**
	 * e107 website system
	 *
	 * Copyright (C) 2008-2017 e107 Inc (e107.org)
	 * Released under the terms and conditions of the
	 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
	 *
	 */

		$sc     = e107::getScBatch('news'); // get news shortcodes.
		$tp     = e107::getParser(); // get parser.


		$limit = !empty($parm['limit']) ? intval($parm['limit']) : 5;


		$query = "SELECT h.hits_counter,h.hits_unique, n.*, c.* FROM `#hits` AS h
					LEFT JOIN `#news` AS n ON h.hits_type = 'news' 	AND h.hits_itemid = n.news_id
					LEFT JOIN `#news_category` AS c ON n.news_category = c.category_id
					ORDER BY h.hits_counter DESC LIMIT ".$limit;

		$data = e107::getDb()->retrieve($query,true);

		$srch = array('{HITS_COUNTER}', '{HITS_UNIQUE}');

		$template = e107::getTemplate('hits', 'popular_menu', 'default');

		$text = $tp->parseTemplate($template['start'], true);

		foreach($data as $row)
		{

			$repl = array(intval($row['hits_counter']), intval($row['hits_unique']));
			$tmpl = str_replace($srch,$repl, $template['item']);

			$sc->setScVar('news_item', $row); // send $row values to shortcodes.

			$text .= $tp->parseTemplate($tmpl, true, $sc); // parse news shortcodes.

		}

		$text .= $tp->parseTemplate($template['end'], true);

		e107::getRender()->tablerender(LAN_PLUGIN_HITS_POPULAR, $text);