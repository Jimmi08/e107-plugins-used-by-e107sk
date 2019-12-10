<?php 

//replace this with core model class if there is enough documentation for this (how to do it)
//source:  OOP fundamentals course

//Db_object_pluginname   to avoid conflict if you are using more than one plugin with this solution

class Db_object_teammembers {
 
    protected static $plugin_name  = "teammembers";
  
	public static function find_all() {
		return static::find_by_query("SELECT * FROM #" . static::$db_table . " ");
	}
                                                            
	public static function find_by_id($id) {
    $query = "SELECT * FROM #".static::$db_table . " WHERE " . static::$db_pid. " = $id LIMIT 1";
    //print_a($query);
		$the_result_array = static::find_by_query($query);
		return !empty($the_result_array) ? array_shift($the_result_array) : false;
	}

	public static function find_by_query($query) {
		$db = e107::getDb();
		$result_set = $db->gen($query);
		$the_object_array = array();
		while($row = $db->fetch())  {
			$the_object_array[] = static::instantation($row);
		}
		return $the_object_array;
	}

	public static function instantation($the_record) {
		$calling_class = get_called_class();
		$the_object = new $calling_class;
		foreach ($the_record as $the_attribute => $value) {
			if($the_object->has_the_attribute($the_attribute)) {
				$the_object->$the_attribute = $value;
				// values for simple parsing
				//$key = strtoupper($the_attribute); 
			    //$the_object->var[$key] = $value;
			}
		}
         
    
    $the_object->field_id = static::$db_pid;
    
	  return $the_object;
 
	} 

	private function has_the_attribute($the_attribute) {
		return property_exists($this, $the_attribute);
	}
 
	protected function properties() {
		$properties = array();
		foreach (static::$db_table_fields  as $db_field) {
			if(property_exists($this, $db_field)) {
				$properties[$db_field] = $this->$db_field;
			}	
		}
		return $properties;
	}


	protected function clean_properties() {
		$database = e107::getDb();
		$clean_properties = array();
		foreach ($this->properties() as $key => $value) {
			
			$clean_properties[$key] = $database->escape($value);
		}
		return $clean_properties ;
	}

	public function save() {
		return isset($this->field_id) ? $this->update() : $this->create();
	}

	public function create() {
		$database = e107::getDb();;
		$properties = $this->clean_properties();

		$query = "INSERT INTO #" . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
		$query .= "VALUES ('". implode("','", array_values($properties)) ."')";
 
		if($database->gen($query)) {
			$this->field_id = $database->lastInsertId();
			return true;
		} else {
			return false;
		}
	}
 

	public function update() {
		$database = e107::getDb();
		$properties = $this->clean_properties();
     
		$properties_pairs = array();

		foreach ($properties as $key => $value) {
			$properties_pairs[] = "{$key}='{$value}'";
		}

		$query = "UPDATE  #" .static::$db_table . "  SET ";
		$query .= implode(", ", $properties_pairs);
		$query .= " WHERE " .static::$db_pid . "= " . $database->escape($this->field_id);

		return ($database->gen($query, true) == 1 ) ? true : false;

	} // end of the update method

 
	public function delete() { 
		$database = e107::getDb();
		$query = "DELETE FROM #" .static::$db_table . "  ";
		$query .= "WHERE id=" . $database->escape($this->field_id);
		$query .= " LIMIT 1";

		return ($database->gen($query, true) == 1 ) ? true : false;
	}

	public static function count_all() {
		$database = e107::getDb();
		$debug = false;
      	$count = $database->count(static::$db_table, "(*)", '', $debug );
			//return array_shift($row);
		return $count;
	}
	
	
	public static function batch_shortcodes() {
    $sc = e107::getScBatch(static::$db_table,static::$plugin_name);
    return $sc;
	}  
 
}
