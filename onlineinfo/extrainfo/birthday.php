<?php
if (!defined('e107_INIT')) { exit; }
if(check_class($extraclass) && e107::isInstalled('birthday')) {

	$plugPref =  e107::pref('onlineinfo');
	
	$nodata=0;
	// if display avatar
	$birthdayavatar=$pref['onlineinfo_bavatar'];
	
	// actual time
	$onlineinfo_birthday_now = time();
	$onlineinfo_birthday_today = date("Y-m-d", $onlineinfo_birthday_now);
	$onlineinfo_birthday_month = date("m", $onlineinfo_birthday_now);
	$onlineinfo_birthday_day = date("d", $onlineinfo_birthday_now);
	$onlineinfo_birthday_year = date("Y", $onlineinfo_birthday_now);
	    
	    
	$BDAY_now = time();
	
	$sql = e107::getDb();
	$onlineinfo_birthday_sql = e107::getDb();
	
	// if cache is set of in admin settings
 
	if($extraacache==1){
	  $cachet = $extracachetime*60;
		$currenttime=time();
		
		$script="SELECT * FROM ".MPREFIX."onlineinfo_cache Where type='birthday'";		
		
		if ($data = $sql->retrieve($script, true )) {  
		   extract($data[0]);
		   $lasttimerun= $cache_timestamp;  
		}
	 	if(($currenttime - $lasttimerun) > $cachet){
		 //run cache update
			$buildcache="";
			$script="select *,YEAR(NOW()) - YEAR(user_birthday) -( DATE_FORMAT(NOW(), '%m-%d') < DATE_FORMAT(user_birthday, '%m-%d')) AS age
				from #user_extended left join #user on user_extended_id = user_id
				where (YEAR(NOW()) - YEAR(user_birthday) -( DATE_FORMAT(NOW(), '%m-%d') < DATE_FORMAT(user_birthday, '%m-%d'))!=-1) AND (user_birthday != '0000-00-00' and user_name!='' AND ((DAYOFYEAR(CONCAT(DATE_FORMAT(NOW(), '%Y-'), DATE_FORMAT(user_birthday,'%m-%d'))) < DAYOFYEAR(now()))*366)+
				DAYOFYEAR(CONCAT(DATE_FORMAT(NOW(), '%Y-'), DATE_FORMAT(user_birthday,'%m-%d')))>=DAYOFYEAR(now())) ORDER BY
				((DAYOFYEAR(CONCAT(DATE_FORMAT(NOW(), '%Y-'), DATE_FORMAT(user_birthday,'%m-%d'))) < DAYOFYEAR(now())) * 366) + DAYOFYEAR(CONCAT(DATE_FORMAT(NOW(), '%Y-'), DATE_FORMAT(user_birthday,'%m-%d'))),date_format(user_birthday,'%m%d') asc
				limit 0,".$extrarecords."";   
		if (!$data = $sql->retrieve($script, true )){
			
			 $arraydata="0|".ONLINEINFO_BDAY_L2;
			 
			 $nodata = 1;
			
		}else{
			$setarray=0;	     	 	
 
		 	foreach($data as $row)
					 {
									extract($row);
									$onlineinfo_birthday_age  = date("Y-m-d", $BDAY_now) - $user_birthday;
									$buildcache[$setarray] = $user_id."|".$user_name."=>".$user_birthday."¬".$onlineinfo_birthday_age;
									$setarray++;
						}
						for ($y = 0; $y <= ($setarray-1); $y++)
						{
		 					$arraydata.=$buildcache[$y];
							$arraydata.= ($y < $setarray-1 ) ? "," : "";
						}						
				}   
 
				
				$sql -> update("onlineinfo_cache", "cache='".$arraydata."',cache_timestamp='".time()."' WHERE type='birthday'"); 
			 }  // if(($currenttime - $lasttimerun) > $cachet){
			//use cache
			$x=0;
			$y=0;
			$script="SELECT * FROM ".MPREFIX."onlineinfo_cache Where type='birthday'";
			$data = $sql->retrieve($script, true );	
			foreach($data as $row)  {
				      extract($row);
				      $blowdata = explode(",", $cache);        	
        			$countdata= count($blowdata);
       	for ($z = 0; $z <= ($countdata-1); $z++)
       	{				 
					  $blowmoredata = explode("=>", $blowdata[$z]);
						$blowdataagain = explode("|", $blowmoredata[0]);
						$blowevenmoredata = explode("¬", $blowmoredata[1]);
						$onlineinfo_birthday_datepart = explode("-", $blowevenmoredata[0]);
						$user_birthday = $onlineinfo_birthday_datepart[1] . "-" . $onlineinfo_birthday_datepart[2];
						$onlineinfo_birthday_age = $blowevenmoredata[1];
						$user_id = $blowdataagain[0];
						$user_name = $blowdataagain[1];	
						
					if($user_birthday == date("m-d",time()))
					{
					
							 if($y==0){
							  $hbtext .= "<div style='text-align:center;'><img src='".e_PLUGIN."onlineinfo/images/hb.gif' alt='Happy Birthday' /></div><div style='text-align:center; font-size: 14px; font-weight:bold;'><table width='100%'>";
							  $y++;
							 }
							 
							//Avatar
							$avatar = e107::getParser()->toAvatar($row); 
							$xavatar = e107::getParser()->toAvatar($row, array('type'=>'url')); 						
						
						
							if ($birthdayavatar == 1)
							{
							  $bavatar="<a href='javascript:void(0)' onMouseover='onlineinfoddrivetip(\"<center><img src=".e_PLUGIN."onlineinfo/images/hb.gif /><img src=".$xavatar."><br /><b>".$user_name."<br />".$onlineinfo_birthday_age." ".ONLINEINFO_BDAY_L0."</b></center>\",\"\",\"150\")'  
								onMouseout='hideonlineinfoddrivetip()'>" . $avatar . "</a>";  
							}
							else
							{
								$bavatar = "";
							}
							$uparams = array('id' => $user_id, 'name' => $user_name);
                            $link = e107::getUrl()->create('user/profile/view', $uparams);
							$hbtext.= "<tr><td>" . $bavatar . "</td><td style='text-align:left; font-size: 14px; font-weight:bold;'><a href='" . $link . "' " . getuserclassinfo($user_id) . ">" . $user_name . " (" . $onlineinfo_birthday_age . ")</a></td></tr>";
	 
 
					
					}
					{
					  
					}	
		
		    } //for ($z = 0; $z <= ($countdata-1); $z++)
				
		if($y==0){$text.= $nbtext;}else{$text.= $hbtext."</table></div>".$nbtext;}
    }		 //while ($row = $sql->db_Fetch()) foreach($data as $row)  {
	}  //if($extraacache==1)
	else{  // no cache
	   
		 $script="select *,YEAR(NOW()) - YEAR(user_birthday) -( DATE_FORMAT(NOW(), '%m-%d') < DATE_FORMAT(user_birthday, '%m-%d')) AS age from #user_extended left join #user on user_extended_id = user_id where (YEAR(NOW()) - YEAR(user_birthday) -( DATE_FORMAT(NOW(), '%m-%d') < DATE_FORMAT(user_birthday, '%m-%d'))!=-1) AND (user_birthday != '000-/00-00' and user_name!='' AND ((DAYOFYEAR(CONCAT(DATE_FORMAT(NOW(), '%Y-'), DATE_FORMAT(user_birthday,'%m-%d'))) < DAYOFYEAR(now()))*366)+ DAYOFYEAR(CONCAT(DATE_FORMAT(NOW(), '%Y-'), DATE_FORMAT(user_birthday,'%m-%d')))>=DAYOFYEAR(now())) ORDER BY ((DAYOFYEAR(CONCAT(DATE_FORMAT(NOW(), '%Y-'), DATE_FORMAT(user_birthday,'%m-%d'))) < DAYOFYEAR(now())) * 366) + DAYOFYEAR(CONCAT(DATE_FORMAT(NOW(), '%Y-'), DATE_FORMAT(user_birthday,'%m-%d'))),date_format(user_birthday,'%m%d') asc limit 0,".$extrarecords."";
	   if ($data = $sql->retrieve($script, true )) {
	   }
		 else {	
				 $arraydata="0|".ONLINEINFO_BDAY_L2; 
				 $nodata = 1;	
	 	 }		 
 
		 $x=0;
		 $y=0;
 
 
			  foreach($data as $row)
				{
					extract($row);
					$onlineinfo_birthday_age = date("Y-m-d", $BDAY_now) - $user_birthday;
					$onlineinfo_birthday_datepart = explode("-", $user_birthday);
					$user_birth = $onlineinfo_birthday_datepart[1] . "-" . $onlineinfo_birthday_datepart[2];			
	 
					 
					if($user_birth == date("m-d",time()))
					{					
					 	if($y==0)
						{
						  $hbtext .= "<div style='text-align:center;'><img src='".e_PLUGIN."onlineinfo/images/hb.gif' alt='Happy Birthday' /></div><div style='text-align:center; font-size: 14px; font-weight:bold;'><table width='100%'>";
						  $y++;
						}
						//Avatar
						$avatar = e107::getParser()->toAvatar($row); 
						$xavatar = e107::getParser()->toAvatar($row, array('type'=>'url')); 
						      
					 
						if ($birthdayavatar == 1)
						{
						  $bavatar="<a href='javascript:void(0)' onMouseover='onlineinfoddrivetip(\"<center><img src=".e_PLUGIN."onlineinfo/images/hb.gif /><img src=".$xavatar."><br /><b>".$user_name."<br />".$onlineinfo_birthday_age." ".ONLINEINFO_BDAY_L0."</b></center>\",\"\",\"150\")'  
							onMouseout='hideonlineinfoddrivetip()'>" . $avatar . "</a>";  
						}
						else
						{
							$bavatar = "";
						}
					    $uparams = array('id' => $user_id, 'name' => $user_name);
                        $link = e107::getUrl()->create('user/profile/view', $uparams);	
						$hbtext.= "<tr><td>" . $bavatar . "</td><td style='text-align:left; font-size: 14px; font-weight:bold;'><a href='" . $link . "' " . getuserclassinfo($user_id) . ">" . $user_name . " (" . $onlineinfo_birthday_age . ")</a></td></tr>";
 
						 
					}
					else
					{
						if ($x == 0)
						{
							if ($extrahide == 1)
							{
								$nbtext.= "<div id='bdays-title' style='cursor:hand; text-align:left; font-size: " . $onlineinfomenufsize . "px; vertical-align: middle; width:" . $onlineinfomenuwidth . ";' title='" . ONLINEINFO_BDAY_L3 . "'><b>&nbsp;" . ONLINEINFO_BDAY_L3 . "</b></div>";
								$nbtext.= "<div id='bdays' class='switchgroup1' style='display:none'>";
							}
							else
							{
								$nbtext.= "<div class='smallblacktext' style='font-size: " . $onlineinfomenufsize . "px; font-weight:bold; margin-left:5px; margin-top:10px; width:" . $onlineinfomenuwidth . "'>" . ONLINEINFO_BDAY_L3 . "</div>";
							}
					
							$x++;
						}
                        $uparams = array('id' => $user_id, 'name' => $user_name);
                        $link = e107::getUrl()->create('user/profile/view', $uparams);
					
						if ($plugPref['onlineinfo_formatbdays'] == "1")
						{
							$nbtext.= "<div style='margin-left:5px; text-align:left; width:" . $onlineinfomenuwidth . ";'>" . $onlineinfo_birthday_datepart[2] . "/" . $onlineinfo_birthday_datepart[1] . " <a title='" . $onlineinfo_birthday_datepart[2] . "." . $onlineinfo_birthday_datepart[1] . "." . $onlineinfo_birthday_datepart[0] . "' href='" . $link . "' " . getuserclassinfo($user_id) . ">" . $user_name . " (" . $onlineinfo_birthday_age . ")</a></div>";
						}
						else
						{
							$nbtext.= "<div style='margin-left:5px; text-align:left; width:" . $onlineinfomenuwidth . ";'>" . $onlineinfo_birthday_datepart[1] . "/" . $onlineinfo_birthday_datepart[2] . " <a title='" . $onlineinfo_birthday_datepart[2] . "." . $onlineinfo_birthday_datepart[1] . "." . $onlineinfo_birthday_datepart[0] . "' href='" . $link . "' " . getuserclassinfo($user_id) . ">" . $user_name . " (" . $onlineinfo_birthday_age . ")</a></div>";
						}
					}
	
		   }
	  if ($y == 0)
		{
			$text.= $nbtext;
		}
		else
		{
			$text.= $hbtext . "</table></div>" . $nbtext;
		}
	}
 
	
  if ($extrahide == 1 && $nodata==0)
  {
        $text .= "<br /></div>";
  } 
} 
?>