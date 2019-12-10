<?php

// v2.x Standard for extending admin areas.

class jm_download_admin

{
	private $active = false;
	function __construct()
	{

		// $pref = e107::pref('core','trackbackEnabled');

		$this->active = 1;
	}

	/**
	 * Extend Admin-ui Parameters
	 * @param $ui admin-ui object
	 * @return array
	 */
	public

	function config($ui)
	{
		$action = $ui->getAction(); // current mode: create, edit, list
		$type = $ui->getEventName(); // 'wmessage', 'news' etc.
		$id = $ui->getId();
		$sql = e107::getDb();
		$config = array();
		switch ($type)
		{
		case "download":
			if ($this->active == true)
			{
				$config['tabs'] = array(
					'jm_download' => 'Latest menu'
				);
				if (($action == 'edit') && !empty($id) && ($url = $sql->retrieve("download", "can_url", "can_table='news' AND can_pid=" . $id)))
				{
					$default = $url;
				}
				else
				{
					$default = '';
				}

				$title = "Download URL <br /> Don't forget Absolute URL! " . SITEURL;
				$config['fields']['url'] = array(
					'title' => $title,
					'type' => 'url',
					'tab' => 'jm_download',
					'writeParms' => array(
						'size' => 'xxlarge',
						'placeholder' => '',
						'default' => $default
					) ,
					'width' => 'auto',
					'help' => '',
					'readParms' => '',
					'class' => 'left',
					'thclass' => 'left',
				);
			}

			break;
			 
		 
		}

		// Note: 'urls' will be returned as $_POST['x_jm_download_url']. ie. x_{PLUGIN_FOLDER}_{YOURKEY}

		return $config;
	}

	/**
	 * Process Posted Data.
	 * @param $ui admin-ui object
	 */
	public

	function process($ui, $id = 0)
	{
		$data = $ui->getPosted();
		$type = $ui->getEventName();
		$action = $ui->getAction(); // current mode: create, edit, list
		$sql = e107::getDb();

		//	e107::getMessage()->addDebug("Object: ".print_a($ui,true));
		//	e107::getMessage()->addInfo("ID: ".$id);
		//	e107::getMessage()->addInfo("Action: ".$action);
		//	e107::getMessage()->addInfo(print_a($data,true));

		if ($action == 'delete')
		{
			return;
		}

		if (e_LANGUAGE != 'English')
		{
			return;
		}

		if (!empty($id) && $this->active)
		{
			if (!empty($data['x_jm_download_url']))
			{
				$title = '';
				if ($type == "news")
				{
					$title = $data['news_title'];
				}

				if ($type == "page")
				{
					$title = $data['page_title'];
				}

				$query = "SELECT can_id FROM #download WHERE can_table = '" . $type . "' AND can_pid= " . $id . ";";
				$result = $sql->gen($query);
				e107::getMessage()->addDebug("Query Select Result:" . print_a($result, true));
				if ($sql->gen($query))
				{
					$update_query = "UPDATE #download SET can_url = '" . $data['x_jm_download_url'] . "', can_title='" . $title . "' WHERE can_table = '" . $type . "' AND can_pid= " . $id . ";";
					$result = $sql->gen($update_query);
					e107::getMessage()->addDebug("Query Update Result:" . print_a($result, true));
					e107::getMessage()->addSuccess("Download URL Updated");
				}
				else
				{
					$insert = array(
						"can_id" => NULL,
						"can_pid" => $id,
						"can_table" => $type,
						'can_title' => $title,
						'can_url' => $data['x_jm_download_url']
					);
					if ($result = $sql->insert("download", $insert, true))
					{
						e107::getMessage()->addDebug("Query Insert Result:" . print_a($result, true));
						e107::getMessage()->addDebug(print_a($insert, true));
						e107::getMessage()->addSuccess("Download URL Created");
					}
					else
					{
						e107::getMessage()->addDebug("Query Insert Result:" . print_a($result, true));
						e107::getMessage()->addDebug(print_a($insert, true));
						e107::getMessage()->addError("Couldn't create Download URL");
					}
				}

				/* indexes need to be changed or core
				$insert = array(
				"can_pid"=> $id,
				"can_table"=>$type,
				'can_title'=>$title,
				'can_url'=> $data['x_jm_download_url'],
				'_DUPLICATE_KEY_UPDATE' => true
				);
				$result = $sql->insert("download", $insert);
				if($result !==false)
				{
				e107::getMessage()->addSuccess("Download URL Saved");
				}
				else
				{
				e107::getMessage()->addError("Couldn't save download URL: ".var_export($result,true));
				e107::getMessage()->addDebug(var_export($insert,true));
				}

				*/
			}
			else
			{
				if (e107::getDb()->count('download', '(*)', "can_table = '{$type}' AND can_pid={$id} "))
				{

					// delete record

					if (e107::getDb()->delete("download", "can_table = '{$type}' AND can_pid={$id} ", true))
					{
						e107::getMessage()->addInfo('Related download URL was deleted');
					}
				}
			}
		}
	}
}

?>