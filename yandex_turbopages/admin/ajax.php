<?php
 
require_once('../../../class2.php');
if (!defined('e107_INIT')) { exit; }

/*
		#addall_ytb
		#deleteall_ytp
		.remove_turbopage
		.add_turbopage  ADD_turbopage
*/
 
 
require_once(e_PLUGIN."yandex_turbopages/lib/functions.php");

if ($_POST['func'] == 'REMOVE_turbopage') {
  
	remove_turbopage($_POST['sTable'], $_POST['sID']);
	echo "URL removed from TurboPages";
	die;
}

if ($_POST['func'] == 'ADD_turbopage') {
  
	add_turbopage($_POST['sTable'], $_POST['sID']);
	echo "URL added to TurboPages";
	die;
  
}



if ($_POST['func'] == 'GENERATEall_ytp') {
  
  $table =  $_POST['sTable'];
  $idName = $_POST['sIdName'];      
  $where = '';
	if($table == 'page' ) {
	  $where =  " AND page_title != ''  ";
	}
  if($records = e107::getDb()->retrieve($table, $idName, true,  $where  ) ) {
    $count = 0;
    foreach($records as $row)  {
      //check if CU exists
      $id = $row[$idName];
      if (e107::getDb()->count('yandex_turbopages', '(*)', "entity_type  = '{$table}' AND entity_id={$id} {$where} "  ))
    	{
        //do nothing
      }
      else {                   
        	add_turbopage($table, $id);
          ++$count;
 
      }                  
    }
  }
  if($count > 0 ) {
     echo "{$count} records of table: {$table} added to TurboPages ";
  }
  else {
    echo "Nothing to add";
  }
	die;
}

if ($_POST['func'] == 'DELETEall_ytp') {
  
  $table =  $_POST['sTable'];
  $idName = $_POST['sIdName'];
  if($records = e107::getDb()->retrieve($table, $idName, true, true) ) {
    $count = 0;  
    foreach($records as $row)  {
      //check if CU exists
 
      $id = $row[$idName];
      if (e107::getDb()->count('yandex_turbopages', '(*)', "entity_type = '{$table}' AND entity_id={$id}  "))
    	{
          	remove_turbopage($table, $id);
            ++$count;
 
      }
      else {
          //do nothing

      }
    }
  }
  if($count > 0 ) {
     echo "{$count} records of table: {$table} removed from TurboPages ";
  }
  else {
    echo "Nothing to remove";
  }
  
	die;
}