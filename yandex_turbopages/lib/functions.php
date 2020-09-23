<?php

// Admin Functions ////////////////////////////////////////////////////

 
function remove_turbopage($table, $id) {


	if (e107::getDb()->count('yandex_turbopages', '(*)', "entity_type = '{$table}' AND entity_id={$id} "))
	{

		// delete record

		if (e107::getDb()->delete("yandex_turbopages", "entity_type = '{$table}' AND entity_id={$id} " ))
		{
		return 'YTP was deleted';
		}
	}

}

function add_turbopage($table, $id) {
 
  $sql = e107::getDB();
 
  
				$value = true; 

				$query = "SELECT tb_id FROM #yandex_turbopages WHERE entity_type = '" . $table . "' AND entity_id = " . $id . " WHERE tb_include = 0 ;";
				$result = $sql->gen($query);
 
				if ($sql->gen($query))
				{
					$update_query = "UPDATE #yandex_turbopages SET tb_include =" . $value . " WHERE entity_type = '" . $table . "' AND entity_id = " . $id . ";";
					$result = $sql->gen($update_query, true);
         
				}
				else
				{
					$insert = array(
						"tb_id" => NULL,
						"entity_id" => $id,
						"entity_type" => $table,
						'tb_include' => $value,
 
					);
          $result = $sql->insert("yandex_turbopages", $insert);
				}
 
}




?>