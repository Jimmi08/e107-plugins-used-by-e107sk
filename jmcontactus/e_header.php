<?php  
 
if(USER_AREA) {
 
  e107::css("jmcontactus", "css/contact-public.css" );
  e107::js("jmcontactus", "js/contact-public.js" );
 
  $map = e107::pref('jmcontactus', 'jmcontactus_settings_showmap');
  $sql = e107::getDb();
  $sql->select("jmcontactus_info", "*", "");
  
 
 
}  
  
?>