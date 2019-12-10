<?php
  
$bootstrap_classes = array('default','primary','success','info','warning','danger');
$i = 0;

$labelselect = "<select class='btn btn-default btn-secondary dropdown-toggle' id='labelselect'
title='Format text' onchange=\"addtext(this.value);this.value=''\">
<option value=''>Labels</option>";
 
foreach ($bootstrap_classes as $class) {
  ++$i;
  $bb[$i]['name'] =  'label-'.$class;
  $bb[$i]['onclick_var'] =  "[label=label label-{$class}][/label]";
  $bb[$i]['menutext'] = "Label ".$class;
  $bb[$i]['helptext']    = "Help: [label=class]Text to be displayed as label[/label]";
  $labelselect .= "<option value='[label=label label-{$class}][/label]' style='font-size:12px;' class='label label-{$class}'>".$bb[$i]['menutext']."</option>\n";
  
  $eplug_bb[] =  $bb[$i];
} 
$labelselect .= "</select>";
++$i;


      $bb[$i]['name']        = 'badge';
      $bb[$i]['onclick_var'] = "[badge][/badge]";
      $bb[$i]['icon']        = e_PLUGIN_ABS."jmcore/images/badge.png";
      $bb[$i]['helptext']    = "[badge]Badge[/badge]";
$eplug_bb[] =  $bb[$i];
       
      
      
$eplug_bb[] =  $bb[$i];       
//$BBCODE_TEMPLATE .= $labelselect.'{BB=badge}';
$BBCODE_TEMPLATE_SUBMITNEWS .= $labelselect.'{BB=badge}';
$BBCODE_TEMPLATE_NEWSPOST .= $labelselect.'{BB=badge}';
$BBCODE_TEMPLATE_ADMIN .= $labelselect.'{BB=badge}';
$BBCODE_TEMPLATE_CPAGE .= $labelselect.'{BB=badge}';
 
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