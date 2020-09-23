<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
* $Id: e_shortcode.php 12438 2011-12-05 15:12:56Z secretr $
*
* Featurebox shortcode batch class - shortcodes available site-wide. ie. equivalent to multiple .sc files.
*/

if(!defined('e107_INIT'))
{
	exit;
}



class uclass_badges_shortcodes extends e_shortcode
{
	public $override = false; // when set to true, existing core/plugin shortcodes matching methods below will be overridden. 

 
	function sc_uclass_badges($parm = null)   
	{
		$sql = e107::getDb();
    $sc = e107::getScBatch('user');
    $data = $sc->getVars(); 
    $user_classes = $data['user_class'];
 
    $available_badges = $sql->retrieve('SELECT ucb.*, uc.userclass_name, uc.userclass_description FROM #uclass_badge AS ucb 
    LEFT JOIN #userclass_classes AS uc ON ucb.uc_badge_class = uc.userclass_id ',  true);
    
    $output ='<div class="main-wrapper">';
    foreach($available_badges as $badge) {
      $badge_class =  $badge['uc_badge_class'];
 
      if(check_class($badge_class, $user_classes, TRUE)) {  
           $output .= '<span class="'.$badge['uc_badge_css'].'" title="'.$badge['userclass_description'].'" >'.$badge['userclass_name'].'</span> ';     
      }
    }
    $output .='</div>';  
    return $output;
	}

}
