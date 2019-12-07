<?php
/**
 * @file
 * Class instantiation to prepare JavaScript configurations and include css/js
 * files to page header.
 */

if(!defined('e107_INIT'))
{
	exit;
}

if(USER_AREA) {
  $plugPrefs = e107::getPlugPref('jmgooglead');
  if($plugPrefs['googleads_global'] && $plugPrefs['googleads_script'] != '')  { 
    $code =  html_entity_decode($plugPrefs['googleads_script'], ENT_QUOTES);
 
    e107::js('footer-inline', $code);
  }
} 