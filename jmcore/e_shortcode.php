<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
 
*/

if(!defined('e107_INIT'))
{
	exit;
}

class jmcore_shortcodes extends e_shortcode
{
	public $override = false; // when set to true, existing core/plugin shortcodes matching methods below will be overridden. 
  	public $settings  = false;
  
  	function __construct()
	{
  		  
	}
  
  	/* user navigation shortcode using template, by default main, but it's possible to add its own template */
	function sc_bootstrap_usernav($parm=null)
	{    
    if(!empty($parm['layout']))
		{
			$tmpl= $parm['layout'];
		}
    
    e107::includeLan(e_PLUGIN."login_menu/languages/".e_LANGUAGE.".php");
    require(e_PLUGIN."login_menu/login_menu_shortcodes.php"); // don't use 'require_once'.
    $userReg = defset('USER_REGISTRATION');
    
		if(!USERID) // Logged Out. 
		{	    
  		if($userReg==1)
  		{
      
    		$links[] = array(
  			'link_name'			=> LAN_LOGINMENU_3,
  			'link_url'			=> e_SIGNUP, // 'news.php?extend.'.$row['news_id'],
  			'link_description'	=> LAN_LOGINMENU_3,
  			'link_button'		=> '',
  			'link_category'		=> '',
  			'link_order'		=> '',
  			'link_parent'		=> 0,
  			'link_open'			=> '',
  			'link_class'		=> 252
    		);
   
  		}
         
  		if(!empty($userReg)) // value of 1 or 2 = login okay. 
  		{ 
    		$links[] = array(
  			'link_name'			=> LAN_LOGINMENU_51,
  			'link_url'			=> e_LOGIN, // 'news.php?extend.'.$row['news_id'],
  			'link_description'	=> LAN_LOGINMENU_51,
  			'link_button'		=> '',
  			'link_category'		=> '',
  			'link_order'		=> '',
  			'link_parent'		=> 0,
  			'link_open'			=> '',
  			'link_class'		=> 252
    		);
  		} 
    }
    else {
       $userNameLabel = !empty($parm['username']) ? USERNAME : '';
       
       $link1 = e107::getParser()->parseTemplate('{LM_USERSETTINGS_HREF}',true,$login_menu_shortcodes);
       $link2 = e107::getParser()->parseTemplate('{LM_PROFILE_HREF}',true,$login_menu_shortcodes);
       
       
       $links[1] = array( 
  			'link_name'			=> '<div class="profile-photo-small">{USER_AVATAR: w=30&h=30&crop=1&shape=circle}  </div>',
  			'link_url'			=> '#', // 'news.php?extend.'.$row['news_id'],
  			'link_description'	=> LAN_LOGINMENU_51,
  			'link_button'		=> '',
  			'link_category'		=> '',
  			'link_order'		=> '',
  			'link_parent'		=> 0,
  			'link_open'			=> '',
  			'link_class'		=> 253,
        'link_sub'      => array()
    		);
        
       	$links[1]['link_sub'][0] = array(
  			'link_name'			=> LAN_SETTINGS,
  			'link_url'			=> $link1, // 'news.php?extend.'.$row['news_id'],
  			'link_description'	=>  LAN_SETTINGS,
  			'link_button'		=> 'fa-cog.glyph',
  			'link_category'		=> '',
  			'link_order'		=> '',
  			'link_parent'		=> 1,
  			'link_open'			=> '',
  			'link_class'		=> 253
    		);
        
       	$links[1]['link_sub'][1] = array(
  			'link_name'			=>   LAN_LOGINMENU_13,
  			'link_url'			=> $link2, // 'news.php?extend.'.$row['news_id'],
  			'link_description'	=>  LAN_LOGINMENU_13,
  			'link_button'		=> 'fa-user.glyph',
  			'link_category'		=> '',
  			'link_order'		=> '',
  			'link_parent'		=> 1,
  			'link_open'			=> '',
  			'link_class'		=> 253
    		);        
        
  		if(ADMIN) 
  		{
       		/* $links[1]['link_sub'][2] = array(
  			'link_name'			=>   '<div class="dropdown-divider"></div>',
    		);  */
      
      
       		$links[1]['link_sub'][3] = array(
  			'link_name'			=>   LAN_LOGINMENU_11,
  			'link_url'			=> e_ADMIN_ABS,  
  			'link_description'	=>  LAN_LOGINMENU_11,
  			'link_button'		=> 'fa-cogs.glyph',
  			'link_category'		=> '',
  			'link_order'		=> '',
  			'link_parent'		=> 1,
  			'link_open'			=> '',
  			'link_class'		=> 253
    		); 	
  		} 
      
      
       $links[1]['link_sub'][4] = array(
  			'link_name'			=>   LAN_LOGOUT,
  			'link_url'			=> "index.php?logout", // 'news.php?extend.'.$row['news_id'],
  			'link_description'	=>  LAN_LOGOUT,
  			'link_button'		=> 'fa-sign-out.glyph',
  			'link_category'		=> '',
  			'link_order'		=> '',
  			'link_parent'		=> 1,
  			'link_open'			=> '',
  			'link_class'		=> 253
    		);        
           
    }
 
    
    $tmpl 			= vartrue($tmpl, 'main');
    $template		= e107::getCoreTemplate('navigation', $tmpl);	
    
    $text =  e107::getNav()->render($links, $template);
 
    return e107::getParser()->parseTemplate($text,true,$login_menu_shortcodes);
    
	return $text;
    
  }
  
    // Custom download shortcode
    // {JMCORE_DL_CAT: download_category_id}
    // {JMCORE_DL_CAT: download_category_name}
    // {JMCORE_DL_CAT: download_category_icon_path}
    // {JMCORE_DL_CAT: download_category_url}
    function sc_jmcore_dl_cat($parm = null)
    {

			if (empty($parm)) return '';

			$key = array_keys($parm);
			if ($key) $key = strtolower($key[0]);
      
      $sc = e107::getScBatch('download',true);
      $data = $sc->dlsubrow;
   	  switch($key)
  		{
  			case 'download_category_name':
  				$text = $data['download_category_name'];
  				break;
  			case 'download_category_id':
  				$text = $data['download_category_id'];
  				break;
  			case 'download_category_description':
 
          $text =  e107::getParser()->toHTML($data['download_category_description'], TRUE, 'DESCRIPTION');
 
          if($parm['class']) {
            $text =  str_replace(array("<p>"), "<p class='".$parm['class']."'>", $text);
          }       
  				break;
  			case 'download_category_icon_path':
  				$imagepath = $data['download_category_icon'];
           $text = e107::getParser()->thumbUrl($imagepath, array('w'=>0, 'h'=>0));
  				break;          
        case 'download_category_url':
          $text = e107::url('download', 'category', $data);
        break;  
      }
      
      return $text;
 
    }
    
    // Custom download shortcode
    // {JMCORE_DL_SUBCAT: download_category_id}
    // {JMCORE_DL_SUBCAT: download_category_name}
    // {JMCORE_DL_SUBCAT: download_category_icon_path}
    // {JMCORE_DL_SUBCAT: download_category_url}
    function sc_jmcore_dl_subcat($parm = null)
    {

		if (empty($parm)) return '';

		$key = array_keys($parm);
    
		if ($key) $key = strtolower($key[0]);
      
      	$sc = e107::getScBatch('download',true);
      	if($parm['type'] == "parent")  {
				   $data = $sc->parent; 
				}
				else {
				  $data = $sc->dlsubsubrow;
				}
     
   	  switch($key)
  		{
  			case 'download_category_name':
  				$text = $data['download_category_name'];
  				break;
  			case 'download_category_id':
  				$text = $data['download_category_id'];
  				break;
  			case 'download_category_description':
 
          	$text =  e107::getParser()->toHTML($data['download_category_description'], TRUE, 'DESCRIPTION');
          $texts = explode("<p><!-- pagebreak --></p>", $text);
          /* there is summary */
          $text =  $texts[0]; 
          	if($parm['class']) {
            $text =  str_replace(array("<p>"), "<p class='".$parm['class']."'>", $text);
          	}       
  				break;
  			case 'download_category_icon_path':
  				$imagepath = $data['download_category_icon'];
           	$text = e107::getParser()->thumbUrl($imagepath, array('w'=>0, 'h'=>0));
  				break;          
        	case 'download_category_url':
          	$text = e107::url('download', 'category', $data);
        	break;  
      	}
      
      
      return $text;
    }
 
    // Custom download shortcode
    // {JMCORE_DOWNLOAD: download_id}
    // {JMCORE_DOWNLOAD: download_name}
    // {JMCORE_DOWNLOAD: download_icon_path}
    // {JMCORE_DOWNLOAD: download_url}
    function sc_jmcore_download($parm = null)
    {
      
		if (empty($parm)) return '';

		$key = array_keys($parm);
		if ($key) $key = strtolower($key[0]);
      
      	$sc = e107::getScBatch('download',true);   
      	$data = $sc->var;
 
   	  	switch($key)
  		{
  			case 'download_category_name':
  				$text = $datapar['download_category_name'];
  				break;
				
				case 'download_name':
  				$text = $data['download_name'];
  				break;
  			case 'download_id':
  				$text = $data['download_id'];
  				break;
  			case 'download_description':
 
          	$text =  e107::getParser()->toHTML($data['download_description'], TRUE, 'BODY');
 
          	$texts = explode("<p><!-- pagebreak --></p>", $text);
          	if($texts[1]) { $text =  $texts[0]; }
          	else {
          	return "";
          	}
          
 
          	if($parm['class']) {
            	$text =  str_replace(array("<p>"), "<p class='".$parm['class']."'>", $text);
          	}       
  			break;
  			case 'download_image':
  				$imagepath = $data['download_image'];
           		if($imagepath)  {
             	$text = e107::getParser()->thumbUrl($imagepath, array('w'=>0, 'h'=>0));
           	}
           	else {
              	$logopref = e107::getConfig('core')->get('sitelogo');
		        $logop = e107::getParser()->replaceConstants($logopref, "full");
              	$text = $logop;
           	}
  			break;          
        	case 'download_url':
          		$text = e107::url('download', 'item', $data);
        	break;  
      	}
      	return $text;
    }
    
    // Custom forum shortcode
    // {JMCORE_FORUM: forumsubforums}
    // {JMCORE_FORUM: lastpost}  + avatar
    
    function sc_jmcore_forum($parm = null)
    {

			if (empty($parm)) return '';

			$key = array_keys($parm);
			if ($key) $key = strtolower($key[0]);
      
      $sc = e107::getScBatch('forum',true);
      $data = $sc->var;
 
   	  switch($key)
  		{
  			case 'forumsubforums':
  				 $subforums =  $data['text'];
  				 if($subforums == '') return  '';
  				 $texts = explode(",", $subforums);
  				 $template = e107::getTemplate('forum','forum', 'subforums');
  				 //$start = e107::getParser()->simpleParse($template['start'], $var);
    			 //$end = e107::getParser()->simpleParse($template['end'], $var);
    			 $start = $template['start'];
    			 $end = $template['end'];
    			 foreach($texts as $item)
     			 {      			   
							$var['SUBFORUM'] = $item;
				      $items .= e107::getParser()->simpleParse($template['item'], $var); 				       
  				 }
  				 $text = $start.$items.$end;
        break;
				
				// NOT FINISHED, something is wrong with core version, it returns not existing users
				
				case 'lastpost':     
				 		if (empty($data['forum_lastpost_info']))
						{
							return false;
						};
					 list($lastpost_datestamp, $lastpost_thread) = explode('.', $data['forum_lastpost_info']);
					 
					 $lastpost       = $this->threadGetLastpost($lastpost_thread); //FIXME TODO inefficient to have SQL query here.
					 $urlData        = array('forum_sef'=>$data['forum_sef'], 'thread_id'=>$lastpost['post_thread'],'thread_sef'=>$lastpost['thread_sef']);
					 $lastpost_url   = e107::url('forum', 'topic', $urlData)."?last=1#post-".$lastpost['post_id'];
					 $lastpost_username = empty($data['user_name']) ? e107::getParser()->toHTML($data['forum_lastpost_user_anon']) : "<a href='".e107::url('user/profile/view', array('name' => $data['user_name'], 'id' => v['forum_lastpost_user']))."'>{$data['user_name']}</a>";

					 $format = !empty($parm['date-format']) ? $parm['date-format'] : 'relative';
			
					 $relativeDate = e107::getParser()->toDate($lastpost_datestamp, $format);
					
					
						$lastpost_user = e107::user($data['forum_lastpost_user']);
						
						$row = array('user_image'=>$lastpost_user['user_sess']);
						$lastpost_user_avatar = e107::getParser()->toAvatar($row, array('class'=>'img'));
						$lastpost_user_url =  empty($data['user_name']) ? e107::getParser()->toHTML($data['forum_lastpost_user_anon']) :  e107::url('user/profile/view', array('name' => $data['user_name'], 'id' => v['forum_lastpost_user'])) ;
						$template = e107::getTemplate('forum','forum', 'lastpost');
						$start = $template['start'];
	    			$end = $template['end'];
	    		
	    			$var['LASTPOST_USERNAME'] = $lastpost_user['user_name'];
	    			
	    			$var['LASTPOST_URL'] = $lastpost_url;
	    			$var['LASTPOST_DATE'] = $relativeDate;
	    			$var['LASTUSER_URL'] = $lastpost_user_url;
	    			$var['LASTUSER_AVATAR'] = $lastpost_user_avatar;
	    		 
						$items .= e107::getParser()->simpleParse($template['item'], $var); 		
						$text = $start.$items.$end;
				break;
      }
      
      return $text;
 
    }
    
    // why to load all forum class
		function threadGetLastpost($id)
		{
			$e107 = e107::getInstance();
			$sql = e107::getDb();
			$id = (int)$id;
			$qry = "
			SELECT p.post_user, p.post_id, p.post_user_anon, p.post_datestamp, p.post_thread, t.thread_name, u.user_name FROM `#forum_post` AS p
			LEFT JOIN `#forum_thread` AS t ON p.post_thread = t.thread_id
			LEFT JOIN `#user` AS u ON u.user_id = p.post_user
			WHERE p.post_thread = {$id}
			ORDER BY p.post_datestamp DESC LIMIT 0,1
			";
			if ($sql->gen($qry))
			{
				$row = $sql->fetch();
				$row['thread_sef'] = eHelper::title2sef($row['thread_name'],'dashl');
				return $row;
			}
			return false;
		}
}
