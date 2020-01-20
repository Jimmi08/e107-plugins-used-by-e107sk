<?php
   parse_str($parm);

   global $tp,$sql,$post_info,$forum,$meta ;
 
 
//-------------------------------------
//--  set type and find id field


//--- NEED TO MAKE THIS GENERIC
 
   //detect forum                             //TODO
   //if(e_PAGE=='forum_viewtopic.php'){ 
	  if (e_CURRENT_PLUGIN =='forum') {     
	    
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