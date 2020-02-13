<?php  
 
if(USER_AREA) {
 
  e107::css("jmcontactus", "css/contact-public.css" );
  e107::js("jmcontactus", "js/contact-public.js" );
 
 
  $sql = e107::getDb();
  $sql->select("jmcontactus_info", "*", "");
  
 
 
}  
  
?>