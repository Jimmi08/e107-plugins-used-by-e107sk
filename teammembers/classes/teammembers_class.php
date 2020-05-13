<?php 

// Generated e107 Plugin Admin Area 

class TeamMembers   {

  protected static $db_table        = "team_members";
  protected static $plugin_name     = "teammembers";
  protected static $db_pid          = "uid";  
 
 
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
    
	public static function templates() {
        $template = e107::getTemplate(static::$plugin_name, static::$db_table, null , true,  true); 
        return $template;
	}     
    
	public static function find_all() {
        $database = e107::getDb();
        return e107::getDb()->retrieve(static::$db_table, "*", false, true);
	}
    
	public static function find_by_query($query) {
		$database = e107::getDb();
		$result_set = $database->gen($query);   
		$the_array = array();
		while($row = $database->fetch())  {   
			$the_array[] = $row;
		}
		return $the_array;
	}

	public static function find_by_id($id) {
		$database = e107::getDb();
		$where = static::$db_pid. " = ".$id." LIMIT 1 ";

		return e107::getDb()->retrieve(static::$db_table, "*", $where );
	}	
 
}

 