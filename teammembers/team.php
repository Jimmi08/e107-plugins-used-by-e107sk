<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 Blank Plugin
 *
*/
if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}
 
require_once(HEADERF); 					// render the header (everything before the main content area)
 
include("init.php");
 
$uid = isset($_GET['uid']) && is_int((int) $_GET['uid']) ? $_GET['uid'] : false;
 
$tp = e107::getParser();
 
if($uid) {     
 
    $agent   	= TeamMembers::find_by_id($uid);   
	$sc 	 	= TeamMembers::batch_shortcodes();
	$templates = TeamMembers::templates();
 	$breadcrumb = array();

    $breadcrumb[] = array('text' => 'Our Team', 'url' => e107::url('teammembers', 'index')); // @see e_url.php

    if(!empty($_GET['uid'])) // @see e_url 'other' redirect.
    {
      $breadcrumb[] = array('text' => $agent->title, 'url' => null); // Use null to omit link for current page.
    }
    
    e107::breadcrumb($breadcrumb); // assign values to the Magic Shortcode:  {---BREADCRUMB---}
       
    $data = (array) $agent;
    $data["oddeven"] = '';
    $data["url"] =  $url ;  
    $sc->setVars($data);     
    $template = $templates['view_'];  
    $text  = $tp->parseTemplate($template['item'], true, $sc);
    $start = $tp->parseTemplate($template['start'], true, $sc);
    $end = $tp->parseTemplate($template['end'], true, $sc);
 
 
    $tablerender = varset($template['tablerender'],'single-agent'); 
    e107::getRender()->tablerender($agent->title, $start.$text.$end, $tablerender ); 
 

}    
else { 
	//breadcrumbs
	$breadcrumb = array();

	$breadcrumb[] = array('text' => 'Our team', 'url' => e107::url('teammembers', 'index')); // @see e_url.php

	if(!empty($_GET['uid'])) // @see e_url 'other' redirect.
	{
		$breadcrumb[] = array('text' => 'Agent', 'url' => null); // Use null to omit link for current page.
	}
    
    e107::breadcrumb($breadcrumb); // assign values to the Magic Shortcode:  {---BREADCRUMB---}
 
	// PAGINATION
	$current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	$items_per_page = 1;
	
	$paginate_offset = ($current_page -1 ) * $items_per_page; 
  
	// doesn't work correctly
	// $parms  = "tmpl_prefix=bootstrap&total={$items_total_count}&amount={$items_per_page}&current={$current_page}&url=" . e_SELF . "?page=[FROM]";
  
	//all agents
	$query = "SELECT * FROM #team_members ";
	$query .= "LIMIT {$items_per_page} ";
	$query .= "OFFSET {$paginate_offset}";
	
	$agents_all = TeamMembers::find_by_query($query);

	
	
	$sc = TeamMembers::batch_shortcodes();
	$items_total_count = TeamMembers::count_all(); 
	$paginate = new PaginateTeamMembers($current_page, $items_per_page, $items_total_count); 
 
	$templates 	=  TeamMembers::templates();
	$template 	= $templates['list_'];

	foreach ($agents_all as $row):     
        
    	$data = (array) $row;
    	$data["oddeven"] = $count % 2 ? "even" : "odd" ;

   		$sc->setVars($data);

    	$text  .= $tp->parseTemplate($template['item'], true, $sc );

    	$count++;
 	endforeach; 
    
  	// e107 way is not correct see issue #4024
	// $pagination  = $tp->parseTemplate("{NEXTPREV={$parms}}"); 

  	$start = $tp->parseTemplate($template['start'], true, $sc);
  	$end = $tp->parseTemplate($template['end'], true, $sc);
 
	$tmpl = $templates["pagination"];  
   
  	if($paginate->page_total() > 1) {
      $pagination = $tmpl['start'];
      if($paginate->has_previous()) {
        $var['url'] = e_SELF."?page=".$paginate->previous();
        $var['label'] = "Previous";
        $var['url_label'] = "Previous";
        $pagination .=  $tp->simpleParse($tmpl['nav_prev'], $var);
      }
      for ($i=1; $i <= $paginate->page_total(); $i++) { 
            $var['url'] = e_SELF."?page=".$i;
            $var['label'] = $i;
            $var['url_label'] = $i;
            if($i == $paginate->current_page) {     
              $pagination .=  $tp->simpleParse($tmpl['item_current'], $var);
            } else {
            $pagination .=  $tp->simpleParse($tmpl['item'], $var);
            }
      }
                    
      if($paginate->has_next()) {
            $var['url'] = e_SELF."?page=".$paginate->next();
            $var['label'] = "Next";
            $var['url_label'] = "Next";
            
            $pagination .=  $tp->simpleParse($tmpl['nav_next'], $var);
      }
      $pagination .= $tmpl['end'];  
  	}
     
  	$tablerender = varset($template['tablerender'],'teammembers'); 
  	e107::getRender()->tablerender(LP_TEAMMEMBERS_LINK, $start.$text.$end.$pagination, $tablerender);   
 }

require_once(FOOTERF);					// render the footer (everything after the main content area)
exit; 
 