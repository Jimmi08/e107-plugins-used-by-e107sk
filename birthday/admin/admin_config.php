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


require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

include_lan(e_PLUGIN . "birthday/languages/" . e_LANGUAGE . "_birthday_mnu.php");
require_once("admin_menu.php");

class birthday_adminArea extends birthdaymenu_adminArea
{

 	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'birthday_ui',
			'path' 			=> null,
			'ui' 			=> 'birthday_form_ui',
			'uipath' 		=> null
		),
		

	);
	
	protected $menuTitle = 'Birthday Menu';
}




				
class birthday_ui extends e_admin_ui
{
			
		protected $pluginTitle		= BDAY_P03;
		protected $pluginName		= 'birthday';
	//	protected $eventName		= 'birthday-'; // remove comment to enable event triggers in admin. 		
		protected $table			= '';
		protected $pid				= '';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= ' DESC';
	
		protected $fields 		= NULL;		
		
		protected $fieldpref = array();
 
	
	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'bday_numdue'		=> array('title'=> BDAY_ADMIN_A2, 'tab'=>0, 'type'=>'number', 'data' => 'str', 'help'=>''),

			'bday_showage'		=> array('title'=> BDAY_ADMIN_A12, 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>''),

			'bday_avatar'		=> array('title'=> BDAY_ADMIN_A51, 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>''),

			'bday_avwidth'		=> array('title'=> BDAY_ADMIN_A52, 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>''),

			'bday_avshape'		=> array(			
			'title' => 'Avatar Border Style',
			'type'  => 'dropdown',
			'data'  => 'str',
			'help'  => 'Set avatar border style',
			'writeParms'=>array('optArray' => array(
				'circle' => 'Circle',
				'rounded' => 'Rounded',
				'none' => 'Square' 
			))), 

			'bday_demographic'		=> array('title'=> BDAY_ADMIN_A64, 'tab'=>0, 'type'=>'userclass', 'data' => 'str', 'help'=>''),

			'bday_showdate'		=> array('title'=> BDAY_ADMIN_A50, 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 
			'help'=>''),

			'bday_dformat'		=> array('title'=> BDAY_ADMIN_A4, 'tab'=>0, 'type'=>'dropdown', 'data' => 'str', 'help'=>'',
			'writeParms'=>array('optArray' => array(
				'1' => 'd M', 
				'2' => 'd M Y',
				'3' => 'M d', 
				'4' => 'M d Y', 
				'5' => 'd mmm Y',
				'6' => 'd MMM Y',
				'7' => 'mmm d Y',
				'8' => 'MMM d Y',
				'9' => 'dth mmm Y',
				'10' => 'dth MMM Y',
				'11' => 'mmm dth Y',
				'12' => 'MMM dth Y',
				'13' => 'd mmm',
				'14' => 'd MMM',
				'15' => 'mmm d',
				'16' => 'MMM d',
				'17' => 'dth mmm',
				'18' => 'dth MMM',
				'19' => 'mmm dth',
				'20' => 'MMM dth' 
			))),

			'bday_sendemail'		=> array('title'=> BDAY_ADMIN_A8, 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>''),
			
			'bday_emailfrom'		=> array('title'=> BDAY_ADMIN_A7, 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'',
			'writeParms' => array(
				'size' => 'block-level',
				'post' => "<div class='label bg-info'> If you left this empty, your email or PM will not be sent  </div>"
			 ),),			

			'bday_subject'		=> array('title'=> BDAY_ADMIN_A10, 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'', 
			'writeParms' => array(
				'size' => 'block-level',
				'post' => "<div class='label bg-info'> If you left this empty, your email or PM will not be sent  </div>"
			 ),),

			'bday_emailaddr'		=> array('title'=> BDAY_ADMIN_A11, 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>''), 
 
			'bday_showclass'		=> array('title'=> BDAY_ADMIN_A35, 'tab'=>0, 'type'=>'userclass', 'data' => 'str', 'help'=>'',
			'writeParms' => array(
				'post' => "<div class='label bg-info'>Class that see birthday menu (or set this in menu visibility) </div>"
			 ),),
			
			'bday_greeting'	=> array('title'=> BDAY_ADMIN_A9, 'tab'=>0, 'type'=>'textarea', 'data' => 'str',
			 'help'=>'',
			'writeParms' => array(
				'size' => 'block-level',
				'post' => "<div class='label bg-info'> Hi {NAME} Happy Birthday to you  </div>"
			 ),),
 

			'bday_exclude'		=> array('title'=> BDAY_ADMIN_A41, 'tab'=>0, 'type'=>'userclass', 'data' => 'str', 'help'=>'',
			'writeParms' => array(
				'post' => "<div class='label bg-info'>Users in this class will not see birthday menu </div>"
			 ),),

			'bday_usecss'		=> array('title'=> BDAY_ADMIN_A40, 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 
			'help'=>'',
			'writeParms' => array(
				'post' => "<br><div class='label bg-info'>In emails sent use the sites theme CSS </div>"
			 ),),
			 
			'bday_usepm'		=> array('title'=> BDAY_ADMIN_A38, 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 
			'help'=>'',
			'writeParms' => array(
				'post' => "<br><div class='label bg-info'>Send email has to be set ON!  </div>"
			 ),),

			'bday_pmfrom'		=> array('title'=> BDAY_ADMIN_A39, 'tab'=>0, 'type'=>'user', 'data' => 'str', 'help'=>''),
 
			'bday_lastemail'		=> array('title'=> 'Last email <div class=\'label bg-danger\'>BE CAREFULL! <br> Last date that was cached and emails already sent</div>', 
			'tab'=>0, 'type'=>'datestamp', 'data' => 'int', 'help'=>'', 'writeParms' => array('type'=>'datetime' )) 
 
 
		); 

	
		public function init()
		{
 
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
		// left-panel help menu area. 
		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = "<table width='97%' class='fborder'>";
 
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A20 . "</b></td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A21 . "</b><br />" . BDAY_ADMIN_A22 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A23 . "</b><br />" . BDAY_ADMIN_A24 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A53 . "</b><br />" . BDAY_ADMIN_A54 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A55 . "</b><br />" . BDAY_ADMIN_A56 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A57 . "</b><br />" . BDAY_ADMIN_A58 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A25 . "</b><br />" . BDAY_ADMIN_A26 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A27 . "</b><br />" . BDAY_ADMIN_A28 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A29 . "</b><br />" . BDAY_ADMIN_A30 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A31 . "</b><br />" . BDAY_ADMIN_A32 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A33 . "</b><br />" . BDAY_ADMIN_A34 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A36 . "</b><br />" . BDAY_ADMIN_A37 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A42 . "</b><br />" . BDAY_ADMIN_A43 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A44 . "</b><br />" . BDAY_ADMIN_A45 . "</td></tr>";
    $text .= "<tr><td class='forumheader3'><b>" . BDAY_ADMIN_A46 . "</b><br />" . BDAY_ADMIN_A47 . "</td></tr>";
	$text .= "</table>";

			return array('caption'=>$caption,'text'=> $text);

		}
			
		public function helpPage()
		{
			$ns = e107::getRender();
 
      include('e_help.php');
      $text = '<div class="tab-content"><div class="tab-pane  active">'.$helplink_text['body'].'</div></div>';
			$ns->tablerender('',$text);	
			
		}
			
}
				


class birthday_form_ui extends e_admin_form_ui
{

}		
		
		
new birthday_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>