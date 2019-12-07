<?php
//***************************************************************
//*
//*		Plugin		:	Birthday Menu (e107 v7x) 
//*
//*		Author		:	Barry Keal (c) 2003 - 2008
//*	
//*		Web site		:	www.keal.org.uk
//*
//*		Description		:	Birthday Menu
//*
//*		Version		:	1.10
//*
//*		Date			:	23 April 2007
//*
//*		License		:	GPL
//*
//***************************************************************
//*
//*		Update 				:	Jimako (e107 v2.x) 
//*
//*   Web site			: https://www.e107sk.com/
//*
//*		Last Change		:	09.07.2019
//*
//*		Version				:	2.1.1
//***************************************************************

if (!defined('e107_INIT')) { exit; }
require_once("../../../class2.php");
 
/* Notes for future re-using
   Always use prefs as first option, it saves time
*/ 

include_lan(e_PLUGIN . "birthday/languages/" . e_LANGUAGE . "_birthday_mnu.php");
 
class birthdaymenu_adminArea extends e_admin_dispatcher
{
            
	protected $adminMenu = array(
  
    'main/prefs' 		=> array('caption'=> BDAY_ADMIN_A13, 'perm' => 'P', 'url'=>'admin_config.php'),
    'main/help'		=> array('caption'=> LAN_HELP, 'perm' => '0')
	);      
	
	protected $adminMenuAliases = array(
  			
	);	
	
	protected $menuTitle = 'Birthday Menu';
 
}