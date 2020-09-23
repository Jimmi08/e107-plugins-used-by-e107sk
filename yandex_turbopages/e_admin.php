<?php


//v2.x Standard for extending admin areas.


class yandex_turbopages_admin
{
	/**
	 * Extend Admin-ui Parameters
	 * @param $ui admin-ui object
	 * @return array
	 */
	public function config(e_admin_ui $ui)
	{
		$action     	= $ui->getAction(); // current mode: create, edit, list
		$type       	= $ui->getEventName(); // 'wmessage', 'news' etc. (core or plugin)
		$id         	= $ui->getId();
		$sql 					= e107::getDb();
		$config 			= array();
		$defaultValue = false;

    // get default value
	  $where = "entity_type='{$type}' AND entity_id=" . $id;
	
		if (($action == 'edit') && !empty($id) && ($entity = $sql->retrieve("yandex_turbopages", "tb_include", $where)))
		{
			$defaultValue   = $entity['tb_include'];
    }
		else
		{
			if($type=='page') {  $defaultValue = 0; } else { $defaultValue = 1; };
 
		}
				
  
	  
		switch($type)
		{
			case "page": // hook into the news admin form.

				$config['tabs'] = array('yandex_turbopages' => 'Turbo Pages' );
				$config['fields']['tb_include'] =   array ( 'title' =>"Add to TurboPages", 'type' => 'boolean', 'tab'=>'yandex_turbopages', 'data'=>'int', 
				'writeParms'=> array('default'=>$defaultValue), 
				'width' => 'auto', 'help' => '', 'readParms' => '', 'class' => 'left', 'thclass' => 'left',  );
				return $config;
				break;
	/*		case "news": // hook into the news admin form.
				$config['fields']['tb_include'] =   array ( 'title' =>"Add to TurboPages", 'type' => 'boolean', 'tab'=>'yandex_turbopages', 'data'=>'int', 
				'writeParms'=> array('default'=>$defaultValue), 
				'width' => 'auto', 'help' => '', 'readParms' => '', 'class' => 'left', 'thclass' => 'left',  );
         return $config;
				break;   */
          
        default: 
           return $config;
        break;
		}


	}


	/**
	 * Process Posted Data.
	 * @param object $ui admin-ui
	 * @param int|array $id - Primary ID of the record being created/edited/deleted or array data of a batch process.
	 */
	public function process(e_admin_ui $ui, $id=0)
	{

		$data       = $ui->getPosted(); // ie $_POST field-data
		$type       = $ui->getEventName(); // eg. 'news'
		$action     = $ui->getAction(); // current mode: create, edit, list, batch
		$changed    = $ui->getModel()->dataHasChanged(); // true when data has changed from what is in the DB.
    $sql = e107::getDb();
    
		if($action === 'delete')
		{
			return;
		}

    $table = $type;


		if(!empty($id) )
		{

			if(!empty($data['x_yandex_turbopages_tb_include']))
			{

				$value = $data['x_yandex_turbopages_tb_include']; 

				$query = "SELECT tb_id FROM #yandex_turbopages WHERE entity_type = '" . $table . "' AND entity_id = " . intval($id) . "";
				$result = $sql->gen($query);
 
				if ($sql->gen($query))
				{
					$update_query = "UPDATE #yandex_turbopages SET tb_include =" . $value . " WHERE entity_type = '" . $table . "' AND entity_id = " . intval($id) . "";
					$result = $sql->gen($update_query, true);
         
				}
				else
				{
					$insert = array(
						"tb_id" => NULL,
						"entity_id" => intval($id),
						"entity_type" => $table,
						'tb_include' => $value,
 
					);
          $result = $sql->insert("yandex_turbopages", $insert);
				}
				
			}

		  
		}



	}



}
