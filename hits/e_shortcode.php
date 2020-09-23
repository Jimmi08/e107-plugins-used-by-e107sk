<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
* $Id: e_shortcode.php 12438 2011-12-05 15:12:56Z secretr $
*
* Featurebox shortcode batch class - shortcodes available site-wide. ie. equivalent to multiple .sc files.
*/

if(!defined('e107_INIT'))
{
	exit;
}



class hits_shortcodes extends e_shortcode
{
	public $override = false; // when set to true, existing core/plugin shortcodes matching methods below will be overridden. 
	private $multi = false;
	private $data = array();

	function sc_hits_counter($parm = null)
	{
		if(!empty($parm['multi']))
		{
		//	$this->multi = true;
		}

		return $this->getData('hits_counter', 'news');
	}

	function sc_hits_unique($parm = null)
	{
		if(!empty($parm['multi']))
		{
		//	$this->multi = true;
		}

		return $this->getData('hits_unique', 'news');
	}

	private function getData($field, $type)
	{


		$sc = e107::getScBatch('news');
		$sql = e107::getDb();
		$row = $sc->getScVar('news_item');
		$id = intval($row['news_id']);

		if(empty($id))
		{
			return false;
		}

		if(isset($this->data[$type][$id][$field]))
		{
			return (string) $this->data[$type][$id][$field];
		}

		if($this->multi === true)
		{
			 $rows = $sql->retrieve('hits', '*', "hits_type = '".$type."' ", true);

			foreach($rows as $row)
			{
				$kid = intval($row['hits_itemid']);
				$this->data[$type][$kid]['hits_counter'] = number_format(intval($row['hits_counter']),0);
				$this->data[$type][$kid]['hits_unique'] = number_format(intval($row['hits_unique']),0);
			}


			if(isset($this->data[$type][$id][$field]))
			{
				return (string) $this->data[$type][$id][$field];
			}
		}


		if(!empty($row['news_id']) && $count = $sql->retrieve('hits', $field, "hits_type = '".$type."' AND hits_itemid = ".$id." LIMIT 1"))
		{
			$count = intval($count);
			$value = number_format($count,0);
			$this->data[$type][$id][$field] = $value;
			return $value;
		}

		return '0';

	}

}
