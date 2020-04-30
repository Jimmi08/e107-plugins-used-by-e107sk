<?php

// Admin Functions ////////////////////////////////////////////////////
 
function deletecanurl($table, $id) {


	if (e107::getDb()->count('canonical', '(*)', "can_table = '{$table}' AND can_pid={$id} "))
	{

		// delete record

		if (e107::getDb()->delete("canonical", "can_table = '{$table}' AND can_pid={$id} " ))
		{
		return 'Related canonical URL was deleted';
		}
	}

}

function createcanurl($table, $id, $return = false) {
 
  $sql = e107::getDB();
  $url = '';
  $config = e107::getPref('url_config');
  $backslash = e107::getPref('jm_canonical', 'backslash');

  if($table == 'pcontent')  {
    $plugindir = e_PLUGIN."content/";
    require_once($plugindir."handlers/content_class.php"); 
    $aa = new content; 
    $query = "SELECT *  FROM #{$table} WHERE content_id=" . $id . " LIMIT 1";    
    if($rows = $sql->retrieve($query, true) ) {
            $contentrow = $rows[0];
             
             // parent = 0 main categories 
			if($contentrow['content_parent'] == 0){
                $contentrow['content_query'] = "?cat.".$contentrow['content_id'];
                $contentrow['content_sef'] = eHelper::title2sef($contentrow['content_heading'],'dashl');
                $contentrow['content_sef_parent'] = $contentrow['content_sef'];
                $title =  $contentrow['content_heading'];
  				$url = e107::url("content", 'mainparent',  $contentrow, "full");
             
			}else{
			   
				if(strpos($contentrow['content_parent'], ".")){     
                    $array	 	= $aa -> getCategoryTree("", 0, TRUE);
                    $arr = $array;   
                    
                    $row['content_id']  = $parent = $contentrow['content_id'];
                    $count = count($arr[$parent]);
                    $row['content_mainparent'] = $arr[$parent][0];
                    $row['content_mainparent_title'] = $arr[$parent][1];
                    $row['content_parent'] = $contentrow['content_parent'];
                    $row['content_parent_title'] = $arr[$parent][$count-1];
       
                    for($i=3;$i<count($arr[$parent]);$i+=2) {
                         $row['content_heading'] .=  " ".$arr[$parent][$i];
                    }
               
                    $title =  $row['content_mainparent_title'] .' '. $row['content_heading'];
                    $url = $aa->getSefUrl($row);
                    
                    if($return)  {return array($url, $title) ;}
  	                
                }else{
                
                
				   //it's content , canonical url is category url     
					//$contentrow['content_query'] = "?content.".$contentrow['content_id'];
					//$url = e107::url("content", "content", $contentrow, "full");
 
                    $tmp = createcanurl("pcontent", $contentrow['content_parent'], true );
                    $url = $tmp[0];
                    $title = $tmp[1] ." ".$contentrow['content_heading'] ;
		     
				}
			} 
      
    }
  } 
  elseif ( $table == 'download' ) {
     $query = "SELECT *  FROM #{$table} WHERE download_id=" . $id . " LIMIT 1";
     if($rows = $sql->retrieve($query, true) ) {
          $contentrow = $rows[0];
          $title = $contentrow['download_name'];
          $url = e107::url("download", "item", $contentrow, "full");
          /* it should end with slash */
				  if(substr($url, -1) != "/") {
				    $url.= "/";
				  } 
     } 
  }
  elseif ( $table == 'download_category' ) {
     $query = "SELECT *  FROM #{$table} WHERE download_category_id=" . $id . " LIMIT 1";
     if($rows = $sql->retrieve($query, true) ) {
          $contentrow = $rows[0];
          $title = $contentrow['download_category_name'];
          $url = e107::url("download", "category", $contentrow, "full"); 
     } 
  } 
  elseif ( $table == 'forum_thread' ) {
 
     $query = 'SELECT t.thread_id, t.thread_name, f.forum_sef FROM #forum_thread as t 
	  	LEFT JOIN #forum AS f ON t.thread_forum_id = f.forum_id WHERE t.thread_id=' . $id . ' LIMIT 1';
     if($rows = $sql->retrieve($query, true) ) {
          $contentrow = $rows[0];
          $title = $contentrow['thread_name'];
          $contentrow['thread_sef'] = eHelper::title2sef($title,'dashl');
          $url = e107::url('forum','topic', $contentrow, array("mode"=>"full"));
     } 
  }   
  
  elseif ( $table == 'news' ) {
     $query = "SELECT *  FROM #{$table} WHERE news_id=" . $id . " LIMIT 1";
     if($rows = $sql->retrieve($query, true) ) {
          $contentrow = $rows[0];
          $title = $contentrow['news_title'];
          $url = e107::getUrl()->create('news/view/item', $contentrow, array("full"=>1));  

          if($backslash) {
            if(substr($url, -1) != "/" && substr($url, -5) != ".html" && substr($url, -4) != ".php" ) {
               $url.= "/";
            }
          }              
     } 
  }     
  elseif ( $table == 'news_category' ) {
     $query = "SELECT *  FROM #{$table} WHERE category_id=" . $id . " LIMIT 1";
    
     if($rows = $sql->retrieve($query, true) ) {  
          $contentrow = $rows[0];
          $title = $contentrow['category_name'];
         	$category = array('id' => $contentrow['category_id'], 'name' => $contentrow['category_sef'] );
          $url = e107::getUrl()->create('news/list/category', $category, array("full"=>1));   
          if($backslash) {
            if(substr($url, -1) != "/" && substr($url, -5) != ".html" && substr($url, -4) != ".php" ) {
               $url.= "/";
            }
          }    
     } 
  }  
  elseif ( $table == 'page' ) {
     $query = "SELECT *  FROM #{$table} WHERE page_id=" . $id . " LIMIT 1";
     if($rows = $sql->retrieve($query, true) ) {
          $contentrow = $rows[0];
          $title = $contentrow['page_title'];
          $route = ($contentrow['page_chapter'] == 0) ? 'page/view/other' : 'page/view';
 
          //TODO: replace this with LEFT JOIN
          if($config['page'] == 'core/sef_chapters')   {
					   $query = "SELECT chapter_sef, chapter_parent, chapter_id FROM #page_chapters WHERE chapter_id=" . $contentrow['page_chapter'] . " LIMIT 1";
					   $chapterdata = $sql->retrieve($query, true);
					   $chapter = $chapterdata[0];
						 if($chapter) {
						     $contentrow['chapter_sef'] = $chapter['chapter_sef'];
						     $query = "SELECT chapter_sef, chapter_parent, chapter_id FROM #page_chapters WHERE chapter_id=" . $chapter['chapter_parent'] . " LIMIT 1";
						     $bookdata = $sql->retrieve($query, true);
						     $book = $bookdata[0];
						     $contentrow['book_sef'] = $book['chapter_sef'];
						 }
						 else {
						  $route = 'page/view/other';						
						 }
               }
               
          $url = e107::getUrl()->create($route, $contentrow, array("full"=>1, 'allow' => 'page_sef,page_id,chapter_sef,book_sef'));
          
          if($backslash) {
            if(substr($url, -1) != "/" && substr($url, -5) != ".html" && substr($url, -4) != ".php" ) {
               $url.= "/";
            }
          }  
     } 
  } 
     
       
  if($url) {
  	$insert = array(
  		"can_id" => NULL,
  		"can_pid" => $id,
  		"can_table" => $table,
  		'can_title' => $title,
  		'can_url' => $url
  	);
    

   $result = e107::getDB()->insert("canonical", $insert  ) ;
   return $result;
  }
}

 
function movecanurl($table, $id, $return = false) { 
  
   $sql = e107::getDB();
   $url = '';
   $config = e107::getPref('url_config');
   
   if($table == 'canonical_request_urls')  {
 
      $query = "SELECT r.canru_url, c.canonical_url, r.canru_redirect FROM #{$table} AS r LEFT JOIN #canonical_urls AS c 
	                 ON r.canonical_id = c.canonical_id
                    WHERE r.canru_id = {$id} LIMIT 1 ";                
      /*
      `canru_id`   INT(11) NOT NULL AUTO_INCREMENT,
      `canru_url`  VARCHAR(254) NOT NULL DEFAULT '',
      `canonical_id`   INT(11) NOT NULL DEFAULT '0',
      `canru_note` VARCHAR(254) NOT NULL DEFAULT '',  
      `canru_redirect`   INT(1) NOT NULL DEFAULT '0', 
      */
   }
  
   if($rows = $sql->retrieve($query, true) ) {
      $contentrow = $rows[0];
      if($table == 'canonical_request_urls')  {
         $url     = $contentrow['canru_url'];
         $newurl  = $contentrow['canonical_url'];   
         $note    = 'Moved from Manual Combination CanUrls table ';  
      }
        
      //check doubles? 
      $insert = array(
         "redirection_id" => NULL,
         "redirection_url" => $url,
         "redirection_newurl" => $newurl,
         'redirection_note' => $note,
         'redirection_status' => 1
      );
     
     if ($sql->insert("redirection_items", $insert)) {

         if ($result = e107::getDb()->delete($table, "canru_id ={$id} " )) {     return $result;
         }
     }
   }
   return $result;
}



?>