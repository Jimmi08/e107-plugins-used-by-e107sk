<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * XXX HIGHLY EXPERIMENTAL AND SUBJECT TO CHANGE WITHOUT NOTICE. 
*/

if (!defined('e107_INIT')) { exit; }


class hits_event // plugin-folder + '_event'
{

	/**
	 * Configure functions/methods to run when specific e107 events are triggered.
	 * For a list of events, please visit: http://e107.org/developer-manual/classes-and-methods#events
	 * Developers can trigger their own events using: e107::getEvent()->trigger('plugin_event',$array);
	 * Where 'plugin' is the folder of their plugin and 'event' is a unique name of the event.
	 * $array is data which is sent to the triggered function. eg. myfunction($array) in the example below.
	 *
	 * @return array
	 */
	function config()
	{

		$event = array();
		// @todo add preference page to configure which events to count.
		$event[] = array(
			'name'	=> "user_news_item_viewed", // when this is triggered... (see http://e107.org/developer-manual/classes-and-methods#events)
			'function'	=> "counter", // ..run this function (see below).
		);

		return $event;

	}

	//@todo make generic
	function counter($data) // the method to run.
	{


		if(!empty($data['news_id']))
		{
			$sess = e107::getSession('hits');
 
			$key = "news_".$data['news_id'];

			$query = "
			INSERT INTO `#hits` (hits_id,hits_type,hits_itemid,hits_counter,hits_unique,hits_lastupdated )
			VALUES (0,'news',".$data['news_id'].",1,1,".time().")
			ON DUPLICATE KEY
            UPDATE hits_counter=hits_counter +1, hits_lastupdated=".time()."
			";

			if($sess->get($key) !== true)
			{
				$query .= ", hits_unique = hits_unique + 1 ";
			}

			$query .= " ; ";

			if(e107::getDb()->gen($query)!==false)
			{
				$sess->set($key,true);
			}
		}


	}





} //end class

