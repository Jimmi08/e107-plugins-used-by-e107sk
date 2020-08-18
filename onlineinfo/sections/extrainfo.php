<?php
if (!defined('e107_INIT')) { exit; }
    
if(check_class($orderclass))
{
    
		if($orderhide==1){


        $text .= '<div id="info-title" style="cursor:hand; text-align:left; font-size: '.$onlineinfomenufsize.'px; vertical-align: middle; width:'.$onlineinfomenuwidth.'; font-weight:bold;" title="'.ONLINEINFO_LOGIN_MENU_L38.'">&nbsp;'.ONLINEINFO_LOGIN_MENU_L38.'</div>
		<div id="info" class="switchgroup1" style="display:none;text-align:left; width:'.$onlineinfomenuwidth.'; margin-left:16px;">';

		}
    	
		$extrasql=e107::getDb();;
		$script="SELECT * FROM ".MPREFIX."onlineinfo_cache Where type='extraorder' ORDER BY type_order";
		$onlineinfoextra = $extrasql->gen($script);

    
		while ($extrarow = $extrasql->fetch()){
				 
		 $extrahide=$extrarow['cache_hide'];
		 $extraclass=$extrarow['cache_userclass'];
		 $extraacache=$extrarow['cache_active'];
		 $extracachetime=$extrarow['cache_timestamp'];
		 $extrarecords=$extrarow['cache_records'];
  
		 /*
		 updated
birthday
lastvisitors
topvisits
toppost
toppoststarter
toppostreplier
topratedmember
counter
*/                          
	    
			if($extrarow['cache']  == "updated")  { 
			//  require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
			}   
			elseif($extrarow['cache']  == "birthday")  {     
		     require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
			} 
			elseif($extrarow['cache']  == "lastvisitors")  {     
		     require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
			}
			elseif($extrarow['cache']  == "topvisits")  {     
			  require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
			}
			elseif($extrarow['cache']  == "toppost")  {     
			 require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
			}	 	
			elseif($extrarow['cache']  == "toppoststarter")  {     
			 require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
			}
			elseif($extrarow['cache']  == "toppostreplier")  {     
			 require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
			}
			elseif($extrarow['cache']  == "topratedmember")  {     
		   require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
			}       
			elseif($extrarow['cache']  == "counter")  {     
			 require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
			} 
      //     
		  else {           print_a($extrarow['cache']); 
        // require_once(e_PLUGIN.'onlineinfo/extrainfo/'.$extrarow['cache'].'.php');
      }      
		}       
     
		if($orderhide==1){ $text .='<br/></div>';}

}     
?>