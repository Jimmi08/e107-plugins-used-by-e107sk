<?php

 $request_url = $tp->toDB(e_REQUEST_URL);
 //$response = e107::getSingleton('eResponse');
 
 $newurl = '';
 $where = " WHERE redirection_url = '" . $request_url . "'  AND redirection_status = 1  LIMIT 1";
	 
 $newurl = e107::getDb()->retrieve("redirection_items",  "redirection_newurl", $where);
 
 if($newurl) {   
	 e107::redirect($newurl, 301);
	 exit;	
 }         
                 
?>