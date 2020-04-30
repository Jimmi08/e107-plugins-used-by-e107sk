<?php
 
require_once('../../../class2.php');
if (!defined('e107_INIT')) { exit; }
 
 
require_once(e_PLUGIN."jm_canonical/lib/functions.php");

if ($_POST['func'] == 'DELETEcanurl') {
  
	deletecanurl($_POST['sTable'], $_POST['sID']);
	echo "Canonical URL deleted.";
	die;
}

if ($_POST['func'] == 'CREATEcanurl') {
 
	createcanurl($_POST['sTable'], $_POST['sID']);
	echo "Canonical URL created.";
	die;
  
}



if ($_POST['func'] == 'GENERATEcanurl') {
                             
  $table =  $_POST['sTable'];
  $idName = $_POST['sIdName'];
  if($records = e107::getDb()->retrieve($table, $idName, true, true) ) {
    $count = 0;
    foreach($records as $row)  {
      //check if CU exists
      $id = $row[$idName];
      if (e107::getDb()->count('canonical', '(*)', "can_table = '{$table}' AND can_pid={$id} "))
    	{
        //do nothing
      }
      else {
            
        	createcanurl($table, $id);
          ++$count;
	        //echo "Canonical URL for table: {$table} and ID:  {$id} created.<br>";
      }
    }
  }
  if($count > 0 ) {
     echo "Canonical URL for table: {$table} created for  {$count} records ";
  }
  else {
    echo "Nothing to create";
  }
	die;
}

if ($_POST['func'] == 'DELETEALLcanurl') {
  
  $table =  $_POST['sTable'];
  $idName = $_POST['sIdName'];
  if($records = e107::getDb()->retrieve($table, $idName, true, true) ) {
    $count = 0;  
    foreach($records as $row)  {
      //check if CU exists
 
      $id = $row[$idName];
      if (e107::getDb()->count('canonical', '(*)', "can_table = '{$table}' AND can_pid={$id}  AND can_redirect = 0 "))
    	{
          	deletecanurl($table, $id);
            ++$count;
	          // echo "Canonical URL for table: {$table} and ID:  {$id} deleted.<br>";
      }
      else {
          //do nothing

      }
    }
  }
  if($count > 0 ) {
     echo "Canonical URL for table: {$table} deleted for  {$count} records ";
  }
  else {
    echo "Nothing to delete";
  }
  
	die;
}

if ($_POST['func'] == 'MOVEtoredirection') {
  
	$result = movecanurl($_POST['sTable'], $_POST['sID']);
	if($result) {
   echo "Canonical URL moved to Redirection plugin.";
  }
	die;
  
}



if ($_POST['func'] == 'MOVEALLcanurl') {
  
  $table =  $_POST['sTable'];
  $idName = $_POST['sIdName'];
 
  if($records = e107::getDb()->retrieve($table, '*', "  canru_redirect = 1 ", true)) {
    
    $count = 0;  
    foreach($records as $row)  {
      //check if CU exists
      $id = $row[$idName];
      
    	movecanurl($table, $id);
      ++$count;
 
    }
  }
  if($count > 0 ) {
     echo "Canonical URL for table: {$table} deleted for  {$count} records ";
  }
  else {
    echo "Nothing to move";
  }
  
	die;
}