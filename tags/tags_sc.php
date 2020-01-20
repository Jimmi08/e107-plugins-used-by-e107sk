<?php
   parse_str($parm);

   global $tp,$sql,$post_info,$forum,$meta ;
 
 
//-------------------------------------
//--  set type and find id field


//--- NEED TO MAKE THIS GENERIC
	  
   //detect news page:
   if(e_PAGE == "news.php")  
   {
	  $sc = e107::getScBatch('news');    
		$news_item = $sc->getScVar('news_item'); 
		$Tag_Item_ID = $news_item['news_id'];
    $Tag_Type    = 'news';}

   //detect page
   elseif (e_PAGE=='page.php' AND  $_GET['id'] > 0 ) {   
      //$tmp          = explode(".", e_QUERY);
      $sc   = e107::getScBatch('page', null, 'cpage');
      $page_item = $sc->getVars('cpage');        
      //$Tag_Item_ID  = intval($tmp[0]);
      $Tag_Item_ID  = $page_item["page_id"];
      $Tag_Type     = 'page';
         }

   //detect download view
   //if(e_PAGE=='download.php'){
   elseif (e_CURRENT_PLUGIN =='download' AND $_GET['action'] == 'view' AND  $_GET['id'] > 0 ) {        //this works only after constants fix
     // $tmp          = explode(".", e_QUERY);
     // $Tag_Item_ID  = intval($tmp[1]);
     $sc   = e107::getScBatch('download',true);        
	   $download_item = $sc->getVars('view'); 
	   $Tag_Item_ID  = $download_item['download_id'];     
      $Tag_Type     = 'download';
         }

   //detect forum                             //TODO
   //if(e_PAGE=='forum_viewtopic.php'){ 
	  elseif (e_CURRENT_PLUGIN =='forum') {     
	    
			$sc = e107::getScBatch('view', 'forum');
      $post_info = $sc->getScVar('postInfo');
      
    //  if ($post_info['user_id'] != '0' && $post_info['user_name'] === USERNAME && check_class($plugPrefs['tags_usermod'])){$TAGMOD=TRUE;}
      if ($post_info['post_user'] != '0' && $post_info['post_user'] === USERID && check_class($plugPrefs['tags_usermod'])) 
			{
				$TAGMOD=TRUE;
			}
      
      //$posturl = e_SELF."?".e_QUERY."#post_{$post_info['thread_id']}";
      //$Tag_Item_ID  = $post_info['thread_id'];
      $Tag_Item_ID  = $post_info['post_id'];
      $Tag_Type     = 'forum';
         }
    
   //detect content                   //TODO
   elseif(e_PAGE=='content.php'){

      $tmp          = explode(".", e_QUERY);
      $Tag_Item_ID  = intval($tmp[1]);
      $Tag_Type     = 'content';
         }
 
 

?>