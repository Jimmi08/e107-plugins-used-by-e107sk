<?php
if (!defined('e107_INIT')){ exit; } 
  

if (substr(e_PAGE, 0, 8) == 'calendar')  {
   e107::js('calendar_menu', 'js/jquery.matchHeight.js','jquery');
   e107::css('calendar_menu', 'css/calendar.css','jquery');
   $footerscript .= " 
   $(function() {
        $('.calendar-day').matchHeight({
            byRow: false          
        });
    });"; 
   e107::js('footer-inline',$footerscript,'jquery');
}
if (substr(e_PAGE, 0, 5) == 'event')  {
 
   e107::css('calendar_menu', 'css/event.css' );
                
}
if (strpos(e_PAGE, 'ec_pf_page') !== false)  {
                                            
   e107::css('calendar_menu', 'css/event.css' );
 
}
if (strpos(e_PAGE, 'subscribe') !== false)  {
                                            
   e107::css('calendar_menu', 'css/event.css' );
 
}


?>