<?php

// v2.x Standard for extending admin areas.

class jm_canonical_admin

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
	public function config($ui)
	{
		$action = $ui->getAction(); // current mode: create, edit, list
		$type = $ui->getEventName(); // 'wmessage', 'news' etc.
		$id = $ui->getId();
		$sql = e107::getDb();
		$config = array();
    //print_a($type);
    if($type = "jm-canonical") {
      $type = $this->singletype($ui, $type);
    }
    //print_a($type);
    /***  cleaning queries - preparing for addon ***/
    switch ($type)
		{
		case "forum_thread" :    
		case "news_category" :
		case "download_category" :
    case "page" :
    case "news" :
    case "pcontent" :
    case "download" :
    $table = $type;     
    break;  

    default: 
      return $config;
    break;
    }
 
    /* its the same for all plugin now */
    $where = "can_table='{$table}' AND can_pid=" . $id;
 
  
    /*** Common for all plugins ***/
		$config['tabs'] = array('jm_canonical'=>'Canonical - e_admin');
 
		if ($this->active == true)
		{
				if (($action == 'edit') && !empty($id) && ($canonical = $sql->retrieve("canonical", "can_url, can_title", $where)))
				{
					$url   = $canonical['can_url'];
          $title = $canonical['can_title'];
				}
				else
				{
					$url = '';
          $title = '';
				}

 
				$config['fields']['url'] = array(
					'title' =>  "Canonical URL",
					'type' => 'url',
					'tab' => 'jm_canonical',
					'writeParms' => array(
						'size' => 'block-level',
						'placeholder' => '',
						'default' => $url
					) ,
					'width' => 'auto',
					'help' => '',
					'readParms' => '',
					'class' => 'left',
					'thclass' => 'left',
				);
 
    
				$config['fields']['title'] = array(
					'title' => 'Title',
					'type' => 'text',
					'tab' => 'jm_canonical',
					'writeParms' => array(
						'size' => 'block-level',
						'placeholder' => '',
						'default' => $title
					) ,
					'width' => 'auto',
					'help' => '',
					'readParms' => '',
					'class' => 'left',
					'thclass' => 'left',
				);
        
			}

		// Note: 'urls' will be returned as $_POST['x_jm_canonical_url']. ie. x_{PLUGIN_FOLDER}_{YOURKEY}

		return $config;
	}

  function singletype($ui, $type = '') {
       if($type = 'jm_canonical')   {
        $mode = $ui->getRequest()->getMode();
    
        switch ($mode)
    		{
    		case "pcontent" :
        case "download" :
        case "news" :
        case "page" :
        return $mode;
        break;        

        case "jm_download" :
        $type = "download";
        return $type;
        break;
				        
        case "downloadcategory" :
        $type = "download_category";
        return $type;
        break;
        
    		case "forumthread" :
        $type = "forum_thread";
        break; 
 
     		case "newscategory" :
        $type = "news_category";
        return $type;
        break;
         
        default: 
   
        break;
        }
        
        return $type;
      }
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
		
    if($type = "jm-canonical") {
      $type = $this->singletype($ui, $type);
    }
    
    $table = $type;
    
  
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
			if (!empty($data['x_jm_canonical_url']))
			{
				$title = $data['x_jm_canonical_title'];
        if($title == '') {
				if ($table == "news")
				{
					$title = $data['news_title'];
				}

				if ($table == "page")
				{
					$title = $data['page_title'];
				}
				
				if ($table == "forum_thread")
				{
					$title = $data['thread_name'];
				}				
				if ($table == "pcontent")
				{
					$title = $data['content_heading'];
				}	        
				if ($table == "news_category")
				{
					$title = $data['category_name'];
				}
				if ($table == "download")
				{
					$title = $data['download_name'];
				}
				if ($table == "download_category")
				{
					$title = $data['download_category_name'];
				}    
        }    
  
				$query = "SELECT can_id FROM #canonical WHERE can_table = '" . $table . "' AND can_pid= " . $id . ";";
				$result = $sql->gen($query);
 
				if ($sql->gen($query))
				{
					$update_query = "UPDATE #canonical SET can_url = '" . $data['x_jm_canonical_url'] . "', can_title='" . $title . "' WHERE can_table = '" . $table . "' AND can_pid= " . $id . ";";
					$result = $sql->gen($update_query);
 
				}
				else
				{
					$insert = array(
						"can_id" => NULL,
						"can_pid" => $id,
						"can_table" => $table,
						'can_title' => $title,
						'can_url' => $data['x_jm_canonical_url']
					);
 
				}

				/* indexes need to be changed or core
				$insert = array(
				"can_pid"=> $id,
				"can_table"=>$type,
				'can_title'=>$title,
				'can_url'=> $data['x_jm_canonical_url'],
				'_DUPLICATE_KEY_UPDATE' => true
				);
				$result = $sql->insert("canonical", $insert);
				if($result !==false)
				{
				e107::getMessage()->addSuccess("Canonical URL Saved");
				}
				else
				{
				e107::getMessage()->addError("Couldn't save canonical URL: ".var_export($result,true));
				e107::getMessage()->addDebug(var_export($insert,true));
				}

				*/
			}
			else
			{
				if (e107::getDb()->count('canonical', '(*)', "can_table = '{$table}' AND can_pid={$id} "))
				{

					// delete record

					if (e107::getDb()->delete("canonical", "can_table = '{$table}' AND can_pid={$id} ", true))
					{
						e107::getMessage()->addInfo('Related canonical URL was deleted');
					}
				}
			}
		}
	}
}

?>