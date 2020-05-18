<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2016 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * ourteam menu file.
 *  
 *  {MENU: path=teammembers/ourteam&count=4&template=ourteam}
 *
 */

if (!defined('e107_INIT')) { exit; }

$text = "";

if(!class_exists('TeamMembers')) {
    require_once(e_PLUGIN."teammembers/classes/teammembers_class.php");
}
 
//load parameters from Menu Manager 
if(isset($parm['caption'][e_LANGUAGE]))
{
	$caption = $parm['caption'][e_LANGUAGE];
}
else $caption = $parm['caption'];

if(isset($parm['subtitle'][e_LANGUAGE]))
{
	$subtitle = $parm['subtitle'][e_LANGUAGE];
}
else $subtitle = $parm['subtitle']; 


$count = (int) $parm['count'];
($count > 0 ) ? ($count ) : ($count =  4);

$template_key =  ($parm['template'] == '') ? ('list_') : ($parm['template']);


e107::lan("teammembers");
$tp = e107::getParser();

//all agents
$query = "SELECT * FROM #team_members ";
$query .= "LIMIT {$count} ";
 
$agents_all = TeamMembers::find_by_query($query);
$sc         = TeamMembers::batch_shortcodes();
$templates 	= TeamMembers::templates();
$template 	= $templates[$template_key];
 
foreach ($agents_all as $data):     
    
    $data["oddeven"] = $count % 2 ? "even" : "odd" ;

    $sc->setVars($data);

    $text  .= $tp->parseTemplate($template['item'], true, $sc );

    $count++;
endforeach; 
  
$start = $tp->parseTemplate($template['start'], true, $sc);
$end = $tp->parseTemplate($template['end'], true, $sc);
$text =  $start.$text.$end;

/* tablestyle variability */
$default_tablestyle =  (empty($template['tablestyle'])) ? 'teammembers' : ($template['tablestyle']);   
$tablestyle = (empty($parm['tablestyle'])) ? ($default_tablestyle) : ($parm['tablestyle']);

 
/* caption variability */
if(isset($template['caption']) && isset($caption)){
  
  $var['MENU_TITLE'] = $caption;
  $var['MENU_SUBTITLE'] = $subtitle;
  $caption = e107::getParser()->simpleParse($template['caption'], $var);

}
   
e107::getRender()->tablerender($caption, $text, $tablestyle);