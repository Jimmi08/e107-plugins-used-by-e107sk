<?php

 
 
$i =0;
      $bb[$i]['name']        = 'prism';
      $bb[$i]['onclick_var'] = "[prism][/prism]";
      $bb[$i]['icon']        = e_PLUGIN_ABS."jm_shortcode/images/prism.png";
      $bb[$i]['helptext']    = "[prism]Badge[/prism]";      
      
      
$eplug_bb[] =  $bb[$i];       
//$BBCODE_TEMPLATE .= ' {BB=prism}';
$BBCODE_TEMPLATE_SUBMITNEWS .= ' {BB=prism}';
$BBCODE_TEMPLATE_NEWSPOST .= ' {BB=prism}';
$BBCODE_TEMPLATE_ADMIN .= ' {BB=prism}';
$BBCODE_TEMPLATE_CPAGE .= ' {BB=prism}';
 
 /*
 	  $temp['news'] 		= $BBCODE_TEMPLATE_NEWSPOST;
		$temp['submitnews']	= $BBCODE_TEMPLATE_SUBMITNEWS;
		$temp['extended']	= $BBCODE_TEMPLATE_NEWSPOST;
		$temp['admin']		= $BBCODE_TEMPLATE_ADMIN;
		$temp['mailout']	= $BBCODE_TEMPLATE_MAILOUT;
		$temp['page']		= $BBCODE_TEMPLATE_CPAGE;
		$temp['maintenance']= $BBCODE_TEMPLATE_ADMIN;
		$temp['comment'] 	= $BBCODE_TEMPLATE_COMMENT;
		$temp['signature'] 	= $BBCODE_TEMPLATE_SIGNATURE;
		*/     
        
?>