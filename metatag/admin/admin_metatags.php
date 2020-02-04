<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('jm_download',true);
e107::lan('metatag', true, true);

require_once("admin_menu.php");
 

class jmmetatag_adminArea extends jmcoremenu_adminArea
{

	protected $modes = array(	
	
		'metatag'	=> array(
			'controller' 	=> 'jmmetatag_ui',
			'path' 			=> null,
			'ui' 			=> 'jmmetatag_form_ui',
			'uipath' 		=> null
		),
	);	
 
	
	protected $menuTitle = 'JM Core Plugin';
}
 
				
class jmmetatag_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'JM Core';
		protected $pluginName		= 'metatag';
	//	protected $eventName		= 'jmmetatag-'; // remove comment to enable event triggers in admin. 		
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
		protected $preftabs        = array("Basic Setting", 
		LAN_METATAG_ADMIN_PANEL_02, LAN_METATAG_ADMIN_PANEL_03 );
 		protected $prefs = 
					array(
 	      
					'metatag_title'		=> array('title'=> LAN_METATAG_ADMIN_PANEL_01 .": ". LAN_METATAG_ADMIN_02,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=>LAN_METATAG_ADMIN_03),
          
					'metatag_description'		=> array('title'=>  LAN_METATAG_ADMIN_PANEL_01 .": ". LAN_METATAG_ADMIN_04,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=>LAN_METATAG_ADMIN_05),
					'metatag_abstract'		=> array('title'=> LAN_METATAG_ADMIN_PANEL_01 .": ". LAN_METATAG_ADMIN_06,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=>LAN_METATAG_ADMIN_07),
					'metatag_keywords'		=> array('title'=> LAN_METATAG_ADMIN_PANEL_01 .": ". LAN_METATAG_ADMIN_08,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=>LAN_METATAG_ADMIN_09),
					'metatag_canonical'		=> array('title'=> LAN_METATAG_ADMIN_PANEL_01 .": ". LAN_METATAG_ADMIN_26,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=>LAN_METATAG_ADMIN_27),
                    
                    'robots'		=> array('title'=> LAN_METATAG_ADMIN_PANEL_01 .": ". LAN_METATAG_ADMIN_10,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=>LAN_METATAG_ADMIN_11),
                    
                    
					'metatag_advanced'		=> array('title'=> 'Panel: '.LAN_METATAG_ADMIN_PANEL_02,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int'),
					'metatag_opengraph'		=> array('title'=> 'Panel: '.LAN_METATAG_ADMIN_PANEL_03,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> ''),
					'metatag_facebook'		=> array('title'=> 'Panel: '.LAN_METATAG_ADMIN_PANEL_04,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> ''),

					'metatag_twitter'		=> array('title'=> 'Panel: '.LAN_METATAG_ADMIN_PANEL_05,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> ''),

					'metatag_dublin'		=> array('title'=> 'Panel: '.LAN_METATAG_ADMIN_PANEL_06,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> ''),

					'metatag_googleplus'		=> array('title'=> 'Panel: '.LAN_METATAG_ADMIN_PANEL_07,
					'tab'=>0,
					'type'=>'boolean',
					'data' => 'int',
					'help'=>''),          
                    

          
					'google_news'		=> array('title'=> LAN_METATAG_ADMIN_12,
					'tab'=>1,
					'type'=>'boolean',
					'data' => 'int',
					'help'=>LAN_METATAG_ADMIN_13),
          
					'advanced_rating'		=> array('title'=> LAN_METATAG_ADMIN_16,
					'tab'=>1,
					'type'=>'boolean',
					'data' => 'int',
					'help'=>LAN_METATAG_ADMIN_13),          
          
					'advanced_referrer'		=> array('title'=> LAN_METATAG_ADMIN_18,
					'tab'=>1,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_19),   
                    
					'opengraph_type'		=> array('title'=> LAN_METATAG_ADMIN_162,
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_163),                           
 
					'opengraph_url'		=> array('title'=> LAN_METATAG_ADMIN_164,
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_165,
                    ), 					 

					'opengraph_title'		=> array('title'=> LAN_METATAG_ADMIN_166,
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_167,
                    ), 

					'opengraph_determiner'		=> array('title'=> LAN_METATAG_ADMIN_168,
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_169),  
                    
					'opengraph_description'		=> array('title'=> LAN_METATAG_ADMIN_170,
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_171,
                    ),    
                    
					'opengraph_updated_time'		=> array('title'=> LAN_METATAG_ADMIN_172,
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> ''),                     
                                     
					'opengraph_see_also'		=> array('title'=> LAN_METATAG_ADMIN_174,
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_175), 
                    
					'opengraph_image'		=> array('title'=> LAN_METATAG_ADMIN_176,
  					'tab'=>2,
  					'type'=>'boolean',
  					'data' => 'int',
  					'help'=> LAN_METATAG_ADMIN_177,

                    ),           
                    
					 
					'opengraph_location'	=> array('title'=> "Location info",
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_188.', '.LAN_METATAG_ADMIN_190.', '. LAN_METATAG_ADMIN_192.', '.LAN_METATAG_ADMIN_194.', '
                    .LAN_METATAG_ADMIN_196.', '.LAN_METATAG_ADMIN_198.' '.LAN_METATAG_ADMIN_200,
                    ),  
                    
					'opengraph_contact'		=> array('title'=> "Contact Info",
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_202.', '. LAN_METATAG_ADMIN_204 . ', '.  LAN_METATAG_ADMIN_206     ,
                    ),  
                                   
					'opengraph_locale'		=> array('title'=> "Locale Info",
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_208.', '. LAN_METATAG_ADMIN_210     ,
                    ),                  
                                                   
					'opengraph_article'		=> array('title'=> "Article Info",
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_212.', '. LAN_METATAG_ADMIN_214.', '. LAN_METATAG_ADMIN_216.', '.LAN_METATAG_ADMIN_218.', '.LAN_METATAG_ADMIN_220  
                    .', '.LAN_METATAG_ADMIN_222.', '.LAN_METATAG_ADMIN_224,
                    ),   
                    
                   	'opengraph_profile'		=> array('title'=> "Profile Info",
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_226.', '. LAN_METATAG_ADMIN_228.', '. LAN_METATAG_ADMIN_230.', '.LAN_METATAG_ADMIN_232 ,
                    ),      
                   	'opengraph_audio'		=> array('title'=> "Audio Info",
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_234.', '. LAN_METATAG_ADMIN_236.', '. LAN_METATAG_ADMIN_238  ,
                    ),  
                    'opengraph_book'		=> array('title'=> "Book Info",
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_240.', '. LAN_METATAG_ADMIN_242.', '. LAN_METATAG_ADMIN_244.', '.LAN_METATAG_ADMIN_246 ,
                    ),  
                    'opengraph_video'		=> array('title'=> "Video Info",
					'tab'=>2,
					'type'=>'boolean',
					'data' => 'int',
					'help'=> LAN_METATAG_ADMIN_248.', '. LAN_METATAG_ADMIN_250.', '. LAN_METATAG_ADMIN_252.', '.LAN_METATAG_ADMIN_254
                    .', '.LAN_METATAG_ADMIN_256.', '.LAN_METATAG_ADMIN_258.', '.LAN_METATAG_ADMIN_260.', '.LAN_METATAG_ADMIN_262
                    .', '.LAN_METATAG_ADMIN_264.', '.LAN_METATAG_ADMIN_266.', '.LAN_METATAG_ADMIN_268.', '.LAN_METATAG_ADMIN_270
                    .', '.LAN_METATAG_ADMIN_272   ,
                    ), 
                                                       					  		
		); 		
		
		protected $fieldpref = array();
		

 	
 
 
 
 
		public function helpPage()
		{
			$ns = e107::getRender();
 
      include('../e_help.php');
      $text = '<div class="tab-content"><div class="tab-pane  active">'.$helplink_text['body'].'</div></div>';
			$ns->tablerender('',$text);	
			
		}
    	
      
		public function CorePage()
		{
			$ns = e107::getRender();
 
      include('admin_coremeta.php');
   
			
		}		
}
				


class jmmetatag_form_ui extends e_admin_form_ui
{

}		
		
		
new jmmetatag_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>