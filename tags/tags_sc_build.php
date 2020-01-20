<?php
  


       //this gets wrapped in a table
       $TAGS .= "<tr><td class='".$plugPrefs['tags_style_item']."'>";

       $query = "SELECT
                  A.*
                 FROM
                  #tag_main A
                 JOIN
                  #tag_config B on A.Tag_Type = B.Tag_Config_Type
                 WHERE
                  B.Tag_Config_OnOffFlag = 1     and
                 Tag_Item_ID = ".$Tag_Item_ID." and Tag_Type ='".$Tag_Type."'
                 ORDER BY
                  Tag_Rank";

       if (e107::getDb()->gen("$query"))
       {
         while ($othertags = e107::getDb()->fetch())
         {
             $link = $tagcloud->MakeSEOLink($othertags['Tag_Name']);
             $TAGS     .= "<a ".$class." href='".$link."'>".preg_replace("#_#"," ",$othertags['Tag_Name'])."</a>   &nbsp;&nbsp;";
             $EDITLIST .= $com.preg_replace("#_#"," ",$othertags['Tag_Name']);
             $com       = ',';
             $meta     .= $othertags['Tag_Name'].' ';
         }
       }
       else
       {
        if($plugPrefs['tags_autogen'])     //JM rewritten to use v2 data 
        {        $keywords =  array();
                //auto generate tags if there are none:
                 if (e_PAGE=='news.php') {
                   //$news_item = getcachedvars('current_news_item');   
									 $sc = e107::getScBatch('news');    
									 $news_item = $sc->getScVar('news_item');          
                   //$param     = getcachedvars('current_news_param'); why?
                   $ystring    = e107::getParser() -> toHTML($news_item['news_body'], TRUE, 'parse_sc, fromadmin', $news_item['news_author']);
                   $keywords = explode(",",$news_item["news_meta_keywords"]); 
                 }
                 elseif (e_PAGE=='page.php' AND  $_GET['id'] > 0 ) {   
								   $sc   = e107::getScBatch('page', null, 'cpage');
        					 $page_item = $sc->getVars('cpage');         
                   $keywords = explode(",",$page_item["page_metakeys"]); 
                 }
                  elseif (e_CURRENT_PLUGIN =='download' AND $_GET['action'] == 'view' AND  $_GET['id'] > 0 ) {        //this works only after constants fix
                    $sc   = e107::getScBatch('download',true);
										$download_item = $sc->getVars('view');       
                    $keywords = explode(",",$download_item["download_keywords"]); 
                 }
                  elseif (e_PAGE=='pcontent.php') {  
                    //not tested
                    //$content_item = getcachedvars('current_content_item');  
                    //$keywords = explode(",",$download_item["content_meta"]); 
                 }  
                 elseif (e_PAGE=='forum_viewtopic.php') {
                   //uncomment to auto gen on your forum - read the note in the readme before doing this!  other solution is needed
                   //$ystring    = $post_info['thread_thread']; 
                 }
                 //else {continue;}   //caused an error

                 
                 $limit    = 0;
                 $time     = time();

                 if ($keywords)
                     {
                     foreach ($keywords as $word)
                      {
                       if ($limit>=$plugPrefs['tags_peritem']){continue;}
                       if (strlen($word)<=$plugPrefs['tags_minlen']){continue;}

                       $needle    = ','.$word.',';
                       $haystack  = ','.$plugPrefs['excludelist'].',';
                       $word      = preg_replace ("#\s#","_",$word);                         //echo  "$needle and $haystack</span>";
                       $pos       = strpos($haystack,$needle);
                       if ($pos===false){
                          $limit++; $cnt++;
                          e107::getDb()->db_insert("tag_main","null,".$Tag_Item_ID.",'".$Tag_Type."','".$word."',$limit,$time");}            //`Tag_ID`  `Tag_Item_ID`  `Tag_Type`  `Tag_Tags`
                          }
                     }


                   //---now tags are there get them again
                   if (e107::getDb()->select("tag_main","*","WHERE Tag_Item_ID = ".$Tag_Item_ID." and Tag_Type ='".$Tag_Type."' ORDER BY Tag_Rank" ,  TRUE))
                         {
                             while ($othertags = e107::getDb()->fetch())
                             {
                                 $link = $tagcloud->MakeSEOLink($othertags['Tag_Name']);
                                 $TAGS     .= "<a ".$class." href='".$link."'>".preg_replace("#_#"," ",$othertags['Tag_Name'])."</a>   &nbsp;&nbsp;";
                                 $EDITLIST .= $com.preg_replace("#_#"," ",$othertags['Tag_Name']);
                                 $com       = ',';
                                 $meta     .= $othertags['Tag_Name'].' ';
                             }
                         }
          }
       }
       $TAGS     .= "</td></tr>"; //end tag style div







?>