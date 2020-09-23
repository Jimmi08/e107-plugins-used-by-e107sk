<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('yandex_turbopages',true);

require_once("admin_menu.php");

class ytp_config_adminArea extends yandex_turbopages_adminArea
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'yandex_turbopages_ui',
			'path' 			=> null,
			'ui' 			=> 'yandex_turbopages_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
 

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
}




				
class yandex_turbopages_ui extends e_admin_ui
{
			
	protected $pluginTitle		= LAN_PLUGIN_YTP_NAME;
	protected $pluginName		= 'yandex_turbopages';
	//	protected $eventName		= 'yandex_turbopages-'; // remove comment to enable event triggers in admin. 		
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
	
	protected $fields 		= array ();		
		
	protected $fieldpref = array();
		

	protected $prefs = array(
		'yandex_turbo_active' => array(
			'title' => LAN_ACTIVE,
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'int',
			'help' => '',
			'writeParms' => array(
				'post' => "<div class='bg-info' style='color: white;padding: 5px;'>".LAN_PLUGIN_YTP_HELP_001."</div>"
			) ,
		) ,
		'ytp_pages_active' => array(
			'title' => LAN_PLUGIN_YTP_PREF_002,
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'int',
			'help' => '',
			'writeParms' => array(
				'post' => "<div class='bg-info' style='color: white;padding: 5px;'>".LAN_PLUGIN_YTP_HELP_002."</div>"
			) ,
		) ,
		'ytp_pages_summarylimit' => array(
			'title' => LAN_PLUGIN_YTP_PREF_003,
			'tab' => 0,
			'type' => 'number',
			'data' => 'int',
			'help' => ''
		) ,
		'ytp_pages_navigation' => array(
			'title' => LAN_PLUGIN_YTP_PREF_004,
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'int',
			'help' => '',
			'writeParms' => array(
				'post' => "<div class='bg-info' style='color: white;padding: 5px;'>".LAN_PLUGIN_YTP_HELP_004."</div>"
			) ,
		) ,
		'ytp_pages_navigation_data' => array(
			'title' => LAN_PLUGIN_YTP_PREF_005,
			'tab' => 0,
			'type' => 'dropdown',
			'data' => 'int',
			'help' => '' 
		) ,		
		
	);
	
	public function init() {
			
		$types = array(
				1	=> "1 - Main",
				2	=> "2 - Sidebar",
				3	=> "3 - Footer",
				4	=> "4 - Alt",
				5	=> "5 - Alt",
				6	=> "6 - Alt"
			);		
    $this->prefs['ytp_pages_navigation_data']['writeParms']['optArray']  = $types;   
  
	}
	
	// for now, otherwise similar table as for rss_menu plugin is needed
	public function rssPage()
	{
		$tp = e107::getParser();
		$sql = e107::getDb();
		$ns = e107::getRender();
		$ytp_pages_active = e107::getPlugPref('yandex_turbopages', 'ytp_pages_active');
		
		//display correct links for news categories, but links works without RSS plugin.
		if (e107::isInstalled('rss_menu'))
		{
			$query = "SELECT * FROM #rss WHERE rss_url='news' AND rss_topicid > 0 ORDER BY rss_id";
			if ($rssrows = $sql->retrieve($query, true))
			{
				foreach($rssrows as $rss)
				{
					$rows['news-' . $rss['rss_id']] = $rss;
				}
			}
		}
 
		//  add all news in one feed
        $rows['news']['rss_id']  = 0;
        $rows['news']['rss_name']  = LAN_PLUGIN_YTP_FEED_001;
        $rows['news']['rss_path']  = 'news';
        $rows['news']['rss_topicid']  = 0;
        $rows['news']['rss_text']   = LAN_PLUGIN_YTP_FEED_002; 
        $rows['news']['rss_url']  = 'news';
        $rows['news']['rss_datestamp']  = time();
        $rows['news']['rss_class']  = LAN_PLUGIN_YTP_FEED_ALL;
        $rows['news']['rss_limit']  = LAN_PLUGIN_YTP_FEED_NO_LIMIT;      
       
		 
   
        if($ytp_pages_active == 1) {
            $rows['page']['rss_id']  = 0;
            $rows['page']['rss_name']  = LAN_PLUGIN_YTP_FEED_003;
            $rows['page']['rss_path']  = 'page';
            $rows['page']['rss_topicid']  = 0;
            $rows['page']['rss_text']   = LAN_PLUGIN_YTP_FEED_004; 
            $rows['page']['rss_url']  = 'page';
            $rows['page']['rss_datestamp']  = time();
            $rows['page']['rss_class']  = LAN_PLUGIN_YTP_FEED_ALL;
            $rows['page']['rss_limit']  = LAN_PLUGIN_YTP_FEED_NO_LIMIT;
        }  
 
 
		$text = "
		<div style='text-align:center;'>
		<table class='fborder' style='".ADMIN_WIDTH."'>
		<tr>
			<td class='fcaption' style='white-space:nowrap;'>".LAN_ID."</td>
			<td class='fcaption' style='white-space:nowrap;'>".LAN_TITLE."</td>
			<td class='fcaption' style='white-space:nowrap;'>".LAN_PLUGIN_FOLDER."</td>
			<td class='fcaption' style='white-space:nowrap;'>".LAN_URL."</td>
			<td class='fcaption' style='white-space:nowrap;'>".LAN_PLUGIN_YTP_CATEGORY_ID."</td>
			<td class='fcaption' style='white-space:nowrap;'>".LAN_DESCRIPTION."</td>
			<td class='fcaption' style='white-space:nowrap;'>".LAN_DATESTAMP."</td>
			<td class='fcaption' style='white-space:nowrap;'>".LAN_VISIBILITY."</td>
			<td class='fcaption' style='white-space:nowrap;'>".LAN_LIMIT."</td>
		</tr>";
      	$lastid  =   0 ;
 
		foreach($rows as $row)
		{
			$row['rss_id'] = $lastid + 1;
		  
			// safety fix, sometimes it inserted 0 as topic ID
		  
			$rss_topicid = $row['rss_topicid'] == 0 ? '' : $row['rss_topicid'];
			$link = e107::url('yandex_turbopages', 'turbo', array(
				'rss_type' => '5',
				'rss_url' => $row['rss_url'],
				'rss_topicid' => $rss_topicid
			) , "full");
        
        	$link = e107::url('yandex_turbopages', 'turbo', array('rss_type'=>'5', 'rss_url'=>$row['rss_url'], 'rss_topicid'=>$rss_topicid) ,   "full"); 
        	$link = "<a target='_target'  href='".$link."'>".$row['rss_url']."</a><br>".$link ;  
                
			$text .= "
          	<tr>
          		<td class='forumheader3'>".$row['rss_id']."</td>
          		<td class='forumheader3'>".$row['rss_name']."</td>
          		<td class='forumheader3'>".$row['rss_path']."</td>
          		<td class='forumheader3'>".$link."</td>
          		<td class='forumheader3'>".$row['rss_topicid']."</td>
          		<td class='forumheader3'>".$row['rss_text']."</td>
          		<td class='forumheader3'>".date("d-m-Y", $row['rss_datestamp'])."</td>
          		<td class='forumheader3'>".$row['rss_class']."</td>
          		<td class='forumheader3'>".$row['rss_limit']."</td>
          	</tr>";
            //<td class='forumheader3'>".date("d-m-Y", $row['rss_datestamp'])."</td> // BETTER DATE RENDERING IN ADMINAREA
        	++$lastid;
		}
      	$text .= " 
		</table>
		</form>
		</div>";
 
		return $text;
			
		}		
}

class yandex_turbopages_form_ui extends e_admin_form_ui
{

}				
		
new ytp_config_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;
