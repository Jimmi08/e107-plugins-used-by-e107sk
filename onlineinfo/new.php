<?php
/*
+---------------------------------------------------------------+
|	e107 website system
|
|	©Steve Dunstan 2001-2003
|	http://e107.org
|	jalist@e107.org
|
|	Released under the terms and conditions of the
|	GNU General Public License (http://gnu.org).
+---------------------------------------------------------------+
*/



require_once('../../class2.php');
 
if (!USER)
{
	e107::redirect();
	exit;
}

$plugPref =  e107::pref('onlineinfo');

$lan_file = e_PLUGIN.'onlineinfo/languages/'.e_LANGUAGE.'.php';
include_once(file_exists($lan_file) ? $lan_file : e_PLUGIN.'onlineinfo/languages/English.php');

include_once(e_PLUGIN.'onlineinfo/functions.php');
 
require_once(HEADERF);

$sql2 = e107::getDb();
$sql = e107::getDb();
//$lvisit = USERLV;
$lvisit = defined('USERLV') ? USERLV : time() + 1000;			// Set default value

  //    $lvisit = $lvisit - 3600*3600*3600;
$singleread= explode('.', e_QUERY);
$bullet = '<img src="'.THEME.'images/bullet2.gif" alt="bullet" /> ';

global $currentUser;  /* it's needed for forum */

   /*
$userfound = $sql2 -> select('onlineinfo_read','*','user_id='.USERID.'');


if ($userfound==0){

	$sql->insert(onlineinfo_read,"".USERID.",'','','','','','','','','','','','','','','','','','','','',''","user_id=".USERID."");

}    */

if (!$row = $sql->retrieve('onlineinfo_read', '*', 'user_id = "'.USERID.'"')) {
    $insert = array(
        'user_id' => USERID
    );

    $sql->insert('onlineinfo_read', $insert);  

}
 
extract($row);

$newsread = cleanup($news);
$chatboxread = cleanup($chatbox);
$commentsread = cleanup($comments);
$contentsread = cleanup($contents);
$downloadsread = cleanup($downloads);
 
$picturesread = cleanup($pictures);
$moviesread = cleanup($movies);
$linksread = cleanup($links);
$sitemembersread = cleanup($sitemembers);
$gamesread = cleanup($games);
$gametopread = cleanup($game_top);
$galleryread = cleanup($gallery);
$ibfread = cleanup($ibf);
$smfread = cleanup($smf);
$bugread = cleanup($bug);
$chatbox2read = cleanup($chatbox2);
 
$jokesread = cleanup($jokes);
$blogsread = cleanup($blogs);
$suggestionsread = cleanup($suggestions);
 
// MARKED AS READED STARTS - FIX THIS LATER 
 

if ($singleread[0] == 'markcontentsasread')
{
	unset ($u_new);

	$id = intval($singleread[1]);

	if (!$contentsread){
				$u_new .= $id;
				}else{
				$u_new .= $contentsread.",".$id;
				}


	$sql->db_Update("onlineinfo_read", "contents='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newcontents_as_read')
{
unset ($u_new);
	$u_new = $contentsread;

	if($u_new){$qy=' AND content_id NOT IN('.$u_new.')';}

	$qry = 'content_datestamp > '.$lvisit.$qy;
		if ($sql->db_Select('pcontent', 'content_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['content_id'];
				}else{
				$u_new .= ','.$row['content_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "contents='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}


if ($singleread[0] == 'marknewsmfasread')
{
	unset ($u_new);

	$topic_id = intval($singleread[1]);

	if (!$ibfread){
				$u_new .= $topic_id;
				}else{
				$u_new .= $smfread.','.$topic_id;
				}


	$sql->db_Update("onlineinfo_read", "smf='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newsmf_as_read')
{
unset ($u_new);
	$u_new = $smfread;

		if($u_new){$qy=' AND ID_MSG NOT IN('.$u_new.')';}

	$qry = 'posterTime > '.$lvisit.$qy;
	$sqlqry='SELECT ID_MSG FROM '.$plugPref ['onlineinfo_smfprefix'].'messages WHERE '.$qry;

		if ($sql->db_Select_gen($sqlqry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['ID_MSG'];
				}else{
				$u_new .= ','.$row['ID_MSG'];
				}

			}

			$sql->db_Update("onlineinfo_read", "smf='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}

// COMMENTS POSTING

$splitcomments= explode('|',$commentsread);
 
if ($singleread[0] == 'markcommentasread')
{
	unset ($u_new);

	$comment_id = intval($singleread[1]);

	if (!$splitcomments[0]){
				$u_new .= $comment_id;
				}else{
				$u_new .= $splitcomments[0].','.$comment_id;
				}


	$sql->db_Update("onlineinfo_read", "comments='".$u_new."|".$splitcomments[1]."|".$splitcomments[2]."|".$splitcomments[3]."|".$splitcomments[4]."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}

if ($singleread[0] == 'markccommentasread')
{
	unset ($u_new);

	$msg_id = intval($singleread[1]);

	if (!$splitcomments[1]){
				$u_new .= $msg_id;
				}else{
				$u_new .= $splitcomments[1].','.$msg_id;
				}


	$sql->db_Update("onlineinfo_read", "comments='".$splitcomments[0]."|".$u_new."|".$splitcomments[2]."|".$splitcomments[3]."|".$splitcomments[4]."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}

if ($singleread[0] == 'markgcommentasread')
{
	unset ($u_new);

	$g_id = intval($singleread[1]);

	if (!$splitcomments[2]){
				$u_new .= $g_id;
				}else{
				$u_new .= $splitcomments[2].','.$g_id;
				}


	$sql->db_Update("onlineinfo_read", "comments='".$splitcomments[0]."|".$splitcomments[1]."|".$u_new."|".$splitcomments[3]."|".$splitcomments[4]."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if ($singleread[0] == 'markbtcommentasread')
{
	unset ($u_new);

	$g_id = intval($singleread[1]);

	if (!$splitcomments[3]){
				$u_new .= $g_id;
				}else{
				$u_new .= $splitcomments[3].','.$g_id;
				}


	$sql->db_Update("onlineinfo_read", "comments='".$splitcomments[0]."|".$splitcomments[1]."|".$splitcomments[2]."|".$u_new."|".$splitcomments[4]."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}

if ($singleread[0] == 'markcpgcommentasread')
{
	unset ($u_new);

	$msg_id = intval($singleread[1]);

	if (!$splitcomments[4]){
				$u_new .= $msg_id;
				}else{
				$u_new .= $splitcomments[4].','.$msg_id;
				}


	$sql->db_Update("onlineinfo_read", "comments='".$splitcomments[0]."|".$splitcomments[1]."|".$splitcomments[2]."|".$splitcomments[3]."|".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}



if (e_QUERY == 'mark_all_comments_as_read')
{
unset ($partone);
	$partone = $splitcomments[0];

	if($partone){$qy=' AND comment_id NOT IN('.$splitcomments[0].')';}

	$qry='comment_datestamp > '.$lvisit.$qy;
if ($sql->db_Select('comments', 'comment_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$partone){
				$partone .= $row['comment_id'];
				}else{
				$partone .= ','.$row['comment_id'];
				}
			}

}

unset ($parttwo);
	$parttwo = $splitcomments[1];

	if($parttwo){$qy=' AND msg_id NOT IN('.$splitcomments[1].')';}

	$qry='UNIX_TIMESTAMP(msg_date) > '.$lvisit.$qy;
	if ($sql->db_Select('CPG_comments', 'msg_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$parttwo){
				$parttwo .= $row['msg_id'];
				}else{
				$parttwo .= ','.$row['msg_id'];
				}
			}

}


unset ($partthree);
	$partthree = $splitcomments[2];

	if($partthree){$qy=' AND g_id NOT IN('.$splitcomments[2].')';}

	$sqlqry='SELECT g_id FROM '.$plugPref ['onlineinfo_gallery2prefix'].'Comment WHERE g_date > '.$lvisit.$qy;

		if ($sql->gen($sqlqry)) {
			while ($row = $sql->fetch()) {

				if (!$partthree){
				$partthree .= $row['g_id'];
				}else{
				$partthree .= ','.$row['g_id'];
				}

			}

	}


	unset ($partfour);
	$partfour = $splitcomments[3];
 

	unset ($partfive);
	$partfive = $splitcomments[4];

 
	$sql->db_Update("onlineinfo_read", "comments='".$partone."|".$parttwo."|".$partthree."|".$partfour."|".$partfive."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

}


// END COMMENTS POSTING



if ($singleread[0] == 'marknewibfasread')
{
	unset ($u_new);

	$topic_id = intval($singleread[1]);

	if (!$ibfread){
				$u_new .= $topic_id;
				}else{
				$u_new .= $ibfread.','.$topic_id;
				}


	$sql->db_Update("onlineinfo_read", "ibf='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newibf_as_read')
{
unset ($u_new);
	$u_new = $ibfread;

		if($u_new){$qy=' AND topic_id NOT IN('.$u_new.')';}

	$qry = 'post_date > '.$lvisit.$qy;
	$sqlqry='SELECT topic_id FROM '.$plugPref ['onlineinfo_ibfprefix'].'topics WHERE '.$qry;

		if ($sql->db_Select_gen($sqlqry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['topic_id'];
				}else{
				$u_new .= ','.$row['topic_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "ibf='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}

if ($singleread[0] == 'marknewgallerypostsasread')
{
	unset ($u_new);

	$g_id = intval($singleread[1]);

	if (!$galleryread){
				$u_new .= $g_id;
				}else{
				$u_new .= $galleryread.','.$g_id;
				}


	$sql->db_Update("onlineinfo_read", "gallery='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newgalleryposts_as_read')
{
unset ($u_new);
	$u_new = $galleryread;

	if($u_new){$qy=' AND g_id NOT IN('.$u_new.')';}

	$qry = 'g_viewedSinceTimestamp > '.$lvisit.$qy;
	$sqlqry='SELECT g_id FROM '.$plugPref ['onlineinfo_gallery2prefix'].'Item WHERE '.$qry;

		if ($sql->db_Select_gen($sqlqry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['g_id'];
				}else{
				$u_new .= ','.$row['g_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "gallery='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}


 

 
if ($singleread[0] == 'marknewjokepostsasread')
{
	unset ($u_new);

	$id = intval($singleread[1]);

	if (!$jokesread){
				$u_new .= $id;
				}else{
				$u_new .= $jokesread.','.$id;
				}


	$sql->db_Update("onlineinfo_read", "jokes='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newjokeposts_as_read')
{
unset ($u_new);
	$u_new = $jokesread;

	if($u_new){$qy=' AND joke_id NOT IN('.$u_new.')';}

	$qry = 'joke_approved=1 AND joke_posted > '.$lvisit.$qy;
		if ($sql->db_Select('jokemenu_jokes', 'joke_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['joke_id'];
				}else{
				$u_new .= ','.$row['joke_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "jokes='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}

if ($singleread[0] == 'marksuggestionsasread')
{
	unset ($u_new);

	$id = intval($singleread[1]);

	if (!$suggestionsread){
				$u_new .= $id;
				}else{
				$u_new .= $suggestionsread.','.$id;
				}


	$sql->db_Update("onlineinfo_read", "suggestions='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_suggestions_as_read')
{
unset ($u_new);
	$u_new = $suggestionsread;

	if($u_new){$qy=' AND suggestion_id NOT IN('.$u_new.')';}

	$qry = 'suggestion_approved=1 AND suggestion_posted > '.$lvisit.$qy;
		if ($sql->db_Select('sugg_suggs', 'suggestion_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['suggestion_id'];
				}else{
				$u_new .= ','.$row['suggestion_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "suggestions='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}


if ($singleread[0] == 'marknewblogasread')
{
	unset ($u_new);

	$id = intval($singleread[1]);

	if (!$blogsread){
				$u_new .= $id;
				}else{
				$u_new .= $blogsread.','.$id;
				}


	$sql->db_Update("onlineinfo_read", "blogs='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_allnewblog_as_read')
{
unset ($u_new);
	$u_new = $blogsread;

	if($u_new){$qy=' AND userjournals_id NOT IN('.$u_new.')';}

	$qry = 'userjournals_timestamp > '.$lvisit.$qy;
		if ($sql->db_Select('userjournals', 'userjournals_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['userjournals_id'];
				}else{
				$u_new .= ','.$row['userjournals_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "blogs='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}



if ($singleread[0] == 'marknewpicturesasread')
{
	unset ($u_new);

	$pid = intval($singleread[1]);

	if (!$picturesread){
				$u_new .= $pid;
				}else{
				$u_new .= $picturesread.','.$pid;
				}


	$sql->db_Update("onlineinfo_read", "pictures='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newpictures_as_read')
{
unset ($u_new);
	$u_new = $picturesread;
	if($u_new){$qy=' AND pid NOT IN('.$u_new.')';}
	$qry = 'ctime > '.$lvisit.$qy;
		if ($sql->db_Select('CPG_pictures', 'pid', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['pid'];
				}else{
				$u_new .= ','.$row['pid'];
				}

			}

			$sql->db_Update("onlineinfo_read", "pictures='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}

 




if ($singleread[0] == 'marknewmovieasread')
{
	unset ($u_new);

	$movie_id = intval($singleread[1]);

	if (!$moviesread){
				$u_new .= $movie_id;
				}else{
				$u_new .= $moviesread.','.$movie_id;
				}


	$sql->db_Update("onlineinfo_read", "movies='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newmovies_as_read')
{
unset ($u_new);
	$u_new = $moviesread;
	if($u_new){$qy=' AND movie_id NOT IN('.$u_new.')';}
	$qry = 'UNIX_TIMESTAMP(timestamp) > '.$lvisit.$qy;
		if ($sql->db_Select('er_ytm_gallery_movies', 'movie_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['movie_id'];
				}else{
				$u_new .= ','.$row['movie_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "movies='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}



if ($singleread[0] == 'marknewgamesasread')
{
	unset ($u_new);

	$game_id = intval($singleread[1]);

	if (!$gamesread){
				$u_new .= $game_id;
				}else{
				$u_new .= $gamesread.','.$game_id;
				}


	$sql->db_Update("onlineinfo_read", "games='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newgames_as_read')
{
unset ($u_new);
	$u_new = $gamesread;
	if($u_new){$qy=' AND game_id NOT IN('.$u_new.')';}
	$qry = 'date_added > '.$lvisit.$qy;
		if ($sql->db_Select('arcade_games', 'game_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['game_id'];
				}else{
				$u_new .= ','.$row['game_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "games='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}



if ($singleread[0] == 'marknewtopscoresasread')
{
	unset ($u_new);

	$champ_id = intval($singleread[1]);

	if (!$gametopread){
				$u_new .= $champ_id;
				}else{
				$u_new .= $gametopread.','.$champ_id;
				}


	$sql->db_Update("onlineinfo_read", "game_top='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newtopscores_as_read')
{
unset ($u_new);
	$u_new = $gametopread;
	if($u_new){$qy=' AND champ_id NOT IN('.$u_new.')';}
	$qry = 'date_scored > '.$lvisit.$qy;
		if ($sql->db_Select('arcade_champs', 'champ_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['champ_id'];
				}else{
				$u_new .= ','.$row['champ_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "game_top='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}



if ($singleread[0] == 'marknewlinksasread')
{
	unset ($u_new);

	$link_id = intval($singleread[1]);

	if (!$linksread){
				$u_new .= $link_id;
				}else{
				$u_new .= $linksread.','.$link_id;
				}


	$sql->db_Update("onlineinfo_read", "links='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newlinks_as_read')
{
unset ($u_new);
	$u_new = $linksread;
	if($u_new){$qy=' AND link_id NOT IN('.$u_new.')';}
	$qry = 'link_datestamp > '.$lvisit.$qy;
		if ($sql->db_Select('links_page', 'link_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['link_id'];
				}else{
				$u_new .= ','.$row['link_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "links='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}


if ($singleread[0] == 'marknewmemberasread')
{
	unset ($u_new);

	$user_id = intval($singleread[1]);

		if (!$sitemembersread){
				$u_new .= $user_id;
				}else{
				$u_new .= $sitemembersread.','.$user_id;
				}


	$sql->db_Update("onlineinfo_read", "sitemembers='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_newmember_as_read')
{
unset ($u_new);
	$u_new = $sitemembersread;
	if($u_new){$qy=' AND user_id NOT IN('.$u_new.')';}
	$qry = 'user_join > '.$lvisit.$qy;
		if ($sql->db_Select('user', 'user_id', $qry)) {
			while ($row = $sql->db_Fetch()) {

				if (!$u_new){
				$u_new .= $row['user_id'];
				}else{
				$u_new .= ','.$row['user_id'];
				}

			}

			$sql->db_Update("onlineinfo_read", "sitemembers='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}



if ($singleread[0] == 'markdownloadsasread')
{
	unset ($u_new);

	$download_id = intval($singleread[1]);

			if (!$downloadsread){
				$u_new .= $download_id;
				}else{
				$u_new .= $downloadsread.','.$download_id;
				}


	$sql->db_Update("onlineinfo_read", "downloads='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}


if (e_QUERY == 'mark_all_downloads_as_read')
{
unset ($u_new);
	$u_new = $downloadsread;
	if($u_new){$qy=' AND download_id NOT IN('.$u_new.')';}
	$qry = 'download_datestamp > '.$lvisit.$qy;
		if ($sql->db_Select('download', 'download_id', $qry)) {
			while ($row = $sql->db_Fetch()) {
				if (!$u_new){
				$u_new .= $row['download_id'];
				}else{
				$u_new .= ','.$row['download_id'];
				}
			}

			$sql->db_Update("onlineinfo_read", "downloads='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}




if ($singleread[0] == 'marknewsasread')
{
	unset ($u_new);

	$news_id = intval($singleread[1]);

		if (!$newsread){
				$u_new .= $news_id;
				}else{
				$u_new .= $newsread.','.$news_id;
				}

	$sql->db_Update("onlineinfo_read", "news='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;
}

//Mark all News as read
if (e_QUERY == 'mark_all_news_as_read')
{
unset ($u_new);

$u_new = $newsread;
	if($u_new){$qy=' AND news_id NOT IN('.$u_new.')';}
	$qry = 'news_datestamp > '.$lvisit.$qy;
		if ($sql->db_Select('news', 'news_id', $qry)) {
			while ($row = $sql->db_Fetch()) {
				if (!$u_new){
				$u_new .= $row['news_id'];
				}else{
				$u_new .= ','.$row['news_id'];
				}
			}

			$sql->db_Update("onlineinfo_read", "news='".$u_new."' WHERE user_id='".USERID."'");

	header("location:".e_SELF);
	exit;

	}

}

if ($singleread[0] == 'markchatboxasread')
{
	unset ($u_new);

	$cb_id = intval($singleread[1]);


	if (!$chatboxread){
				$u_new .= $cb_id;
				}else{
				$u_new .= $chatboxread.','.$cb_id;
				}


	$sql->db_Update("onlineinfo_read", "chatbox='".$u_new."' WHERE user_id='".USERID."'");

    e107::redirect(e_REQUEST_SELF);
		exit;
}

/***********************starts marked all chatbox posts as readed***************/
if (e_QUERY == 'mark_all_chatbox_as_read')
{
	unset($u_new);
	$u_new = $newsread;
	if ($u_new)
	{
		$qy = ' AND cb_id NOT IN(' . $u_new . ')';
	}

	$qry = 'cb_datestamp > ' . $lvisit . $qy;
	if ($chatrows = $sql->retrieve('chatbox', 'cb_id', $qry, true))
	{
		foreach($chatrows as $row)
		if (!$u_new)
		{
			$u_new.= $row['cb_id'];
		}
		else
		{
			$u_new.= ',' . $row['cb_id'];
		}
	}

	$sql->db_Update("onlineinfo_read", "chatbox='" . $u_new . "' WHERE user_id='" . USERID . "'");
	e107::redirect(e_REQUEST_SELF);
	exit;
}
/******************** end marked all chatbox posts as readed ******************/ 

 
// MARKED AS READED ENDS - FIX THIS LATER


$text = '<div style="text-align:center">
<table style="width:95%" class="fborder">';


// ************************************************************
// ******                  New News                      ******
// ************************************************************
if ($plugPref ['onlineinfo_shownews'] == 1)
{
	if ($newsread != '')
	{
		$news_read = 'AND news_id NOT IN (' . $newsread . ')';
	}

	$script = 'SELECT ' . MPREFIX . 'news.*, ' . MPREFIX . 'user.user_name FROM ' . MPREFIX . 'news LEFT JOIN ' . MPREFIX . 'user
  ON ' . MPREFIX . 'news.news_author = ' . MPREFIX . 'user.user_id WHERE news_datestamp>' . $lvisit . ' 
  and news_class IN (' . USERCLASS_LIST . ') ' . $news_read . ' ORDER BY news_datestamp DESC LIMIT 0,' . $plugPref ['onlineinfo_newsnum'];
	if ($recents = $sql->retrieve($script, true))
	{
		$news_items = count($recents);
		foreach($recents as $row)
		{
			extract($row);
			if (check_class($news_class))
			{
				$str.= '<a href="' . e_REQUEST_SELF . '?marknewsasread.' . $news_id . '">
    <img src="' . e_PLUGIN_ABS . 'onlineinfo/images/read.png" border="0" alt="' . ONLINEINFO_LOGIN_MENU_L92 . '"></a>  
    <a href="' . e_HTTP . 'news.php?item.' . $news_id . '">' . $news_title . '</a> <i>' . ONLINEINFO_LOGIN_MENU_L90 . '</i> 
    <a href="' . e_HTTP . 'user.php?id.' . $news_author . '" ' . getuserclassinfo($news_author) . '>' . $user_name . '</a><br />';
			}
			else
			{
				$news_items = $news_items - 1;
			}
		}
	}
	else
	{
		$str = ONLINEINFO_LIST_4;
	}

	$notnewsallread = '';
	if ($news_items != 0)
	{
		$notnewsallread = '  <i><a href="' . e_REQUEST_SELF . '?mark_all_news_as_read">[' . ONLINEINFO_LOGIN_MENU_L91 . ']</a></i>';
	}

	if (!$news_items)
	{
		$news_items = 0;
	}

	$text.= '<tr>
  <td class="fcaption">' . ONLINEINFO_LIST_1 . ' (' . $news_items . ')' . $notnewsallread . '</td>
  </tr><tr>
  <td class="forumheader3">' . $str . '</td>
  </tr>';
}


// ************************************************************
// ******                  New Content                   ******
// ************************************************************
/*
if($plugPref ['onlineinfo_content']==1){
// content
unset($str);

if($contentsread != '')
		{
			$contents_read = 'AND content_id NOT IN ('.$contentsread.')';
		}

$content_items = $sql -> db_Select("pcontent", "*", "content_datestamp>$lvisit AND content_parent!='0' and content_class IN (".USERCLASS_LIST.") ".$contents_read." ORDER BY content_datestamp DESC LIMIT 0," . $plugPref ['onlineinfo_contentsnum'] . "");
while($row = $sql -> db_Fetch()){
	extract($row);


				$str .= '<a href="'.e_SELF.'?markcontentsasread.'.$content_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  <a href="'.e_PLUGIN.'content/content.php?content.'.$content_id.'">'.$content_heading.'</a><br />';


}
if(!$content_items){
	$str = ONLINEINFO_LIST_4;
}

$notnewcontentsallread='';
if($content_items !=0){

	$notnewcontentsallread='  <i><a href="'.e_SELF.'?mark_all_newcontents_as_read">['.ONLINEINFO_LOGIN_MENU_L91.']</a></i>';
}

$text .= '<tr>
<td class="fcaption">'.ONLINEINFO_LIST_21.' ('.$content_items.') '.$notnewcontentsallread.'</td>
</tr><tr>
<td class="forumheader3">'.$str.'</td>
</tr>';

}
 */
// ************************************************************
// ******                New Comments                    ******
// ************************************************************
if ($plugPref ['onlineinfo_showcomments'] == 1)
    {
 

$splitcomments= explode('|',$commentsread);

	if($splitcomments[0] != '')
		{

			$ecomments = 'AND comment_id NOT IN ('.$splitcomments[0].')';
		}


unset($str);
$comment_count=0;

$str = '';

if($comments = $sql -> db_Select("comments", "*", "comment_datestamp>$lvisit ".$ecomments." ORDER BY comment_datestamp DESC LIMIT 0," . $plugPref ['onlineinfo_commentsnum'] . "")){
	while($row = $sql -> db_Fetch()){
		extract($row);


$author= explode('.',$comment_author);


if($author[0]==0){
	$astr=$author[1];
	}else{
	$astr='<a href="'.e_BASE.'user.php?id.'.$author[0].'" '.getuserclassinfo($author[0]).'>'.$author[1].'</a>';
		}

		if ($comment_type=='profile'){$comment_type=999;}
		if ($comment_type=='links_page'){$comment_type=998;}
		if ($comment_type=='pcontent'){$comment_type=997;}
		if ($comment_type=='jokemenu'){$comment_type=995;}
		if ($comment_type=='userjourna'){$comment_type=994;}
		if ($comment_type=='sugg_suggs'){$comment_type=993;}
		if ($comment_type=='page'){$comment_type=992;}
		if ($comment_type=='krooze'){$comment_type=991;}
		if ($comment_type=='agenda'){$comment_type=990;}

		switch($comment_type){

			case 0:	// news
				$sql2 -> db_Select("news", "*", "news_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch(); extract($row);
				if(check_class($news_class)){

					$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_1.' ]&nbsp;</span><span><a href="'.e_BASE.'comment.php?comment.news.'.$comment_item_id.'">'.$news_title.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
					$comment_count++;
				}
			break;

			case 1:	//	article, review or content page
				//	find out whether article, review or content page ...
				$sql2 -> db_Select("pcontent", "content_heading, content_type, content_class", "content_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch();
				extract($row);

							$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_15.' ]&nbsp;</span><span><a href="'.e_PLUGIN.'content/content.php?content.'.$content_id.'">'.$content_heading.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';

			break;

			case 2: //	downloads
				$mp = MPREFIX;
				$qry = "SELECT download_name, {$mp}download_category.download_category_class FROM {$mp}download LEFT JOIN {$mp}download_category ON {$mp}download.download_category={$mp}download_category.download_category_id WHERE {$mp}download.download_id={$comment_item_id}";
				$sql2 -> db_Select_gen($qry);
				$row = $sql2 -> db_Fetch();
				extract($row);
				if(check_class($download_category_class)){
					$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_17.' ]&nbsp;</span><span><a href="'.e_BASE.'download.php?view.'.$comment_item_id.'">'.$download_name.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
					$comment_count++;
				}
			break;

			case 3: //	faq
				$sql2 -> db_Select("faq", "faq_question", "faq_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch(); extract($row);
				$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_18.' ]&nbsp;</span><span><a href="'.e_PLUGIN.'faq/faq.php?view.'.$comment_item_id.'">'.$faq_question.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
					$comment_count++;
			break;

			case 4:	//	poll comment
				$sql2 -> db_Select("polls", "*", "poll_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch(); extract($row);
				$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_19.' ]&nbsp;</span><span><a href="'.e_BASE.'comment.php?comment.poll.'.$comment_item_id.'">'.$poll_title.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
					$comment_count++;
			break;

 





		case 990:	//	agenda

				$sql2 -> db_Select("agenda", "agn_title, agn_start", "agn_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch(); extract($row);
				$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_62.' ]&nbsp;</span><span><a href="'.e_PLUGIN.'agenda/agenda.php?viewitem.1.'.$comment_item_id.'.'.$agn_start.'">'.$agn_title.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';


		$comment_count++;
	break;





		case 991:	//	krooze

				$sql2 -> db_Select("arcade_games", "game_title", "game_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch(); extract($row);
				$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_61.' ]&nbsp;</span><span><a href="'.e_PLUGIN.'kroozearcade_menu/play.php?gameid='.$comment_item_id.'">'.$game_title.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';


		$comment_count++;
	break;





	case 992:	//	pages

				$sql2 -> db_Select("page", "page_title", "page_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch(); extract($row);
				$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_60.' ]&nbsp;</span><span><a href="'.e_BASE.'page.php?'.$comment_item_id.'">'.$page_title.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';


		$comment_count++;
	break;


	case 993:	//	Suggestions

				$sql2 -> db_Select("sugg_suggs", "suggestion_name", "suggestion_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch(); extract($row);
				$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_59.' ]&nbsp;</span><span><a href="'.e_PLUGIN.'suggestions_menu/suggestions.php?0.view.'.$comment_item_id.'">'.$suggestion_name.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
		$comment_count++;

	break;




	case 994:	//	blog user journal

				$sql2 -> db_Select("userjournals", "userjournals_subject", "userjournals_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch(); extract($row);
				$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_58.' ]&nbsp;</span><span><a href="'.e_PLUGIN.'userjournals_menu/userjournals.php?blog.'.$comment_item_id.'">'.$userjournals_subject.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
		$comment_count++;

	break;

	case 995:	//	jokes

				$sql2 -> db_Select("jokemenu_jokes", "joke_name", "joke_id=$comment_item_id ");
				$row = $sql2 -> db_Fetch(); extract($row);
				$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_57.' ]&nbsp;</span><span><a href="'.e_PLUGIN.'jokes_menu/jokes.php?0.view.'.$comment_item_id.'">'.$joke_name.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
		$comment_count++;

	break;

 

			case 997: // pcontent pages

							$sql2 -> db_Select("pcontent", "content_heading", "content_id=$comment_item_id ");
							$row = $sql2 -> db_Fetch(); extract($row);
							$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_33.' ]&nbsp;</span><span><a href="'.e_PLUGIN.'content/content.php?content.'.$comment_item_id.'">'.$content_heading.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
					$comment_count++;

			break;


			case 998: // link pages

							$sql2 -> db_Select("links_page", "link_name", "link_id=$comment_item_id ");
							$row = $sql2 -> db_Fetch(); extract($row);
							$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_32.' ]&nbsp;</span><span><a href="'.e_PLUGIN.'links_page/links.php?comment.'.$comment_item_id.'">'.$link_name.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
					$comment_count++;

			break;


			case 999:	//	profile
							$sql2 -> db_Select("user", "*", "user_id=$comment_item_id ");
							$row = $sql2 -> db_Fetch(); extract($row);
							$str .= '<div><span><a href="'.e_SELF.'?markcommentasread.'.$comment_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </span><span>[ '.ONLINEINFO_LIST_24.' ]&nbsp;</span><span><a href="'.e_BASE.'user.php?id.'.$comment_item_id.'" '.getuserclassinfo($comment_item_id).'>'.$user_name.'</a></span><span>'.ONLINEINFO_LIST_41.$astr.'</span></div>';
								$comment_count++;
			break;

		}

	}
   
}

 


if($comment_count==0){
	$str = ONLINEINFO_LIST_4;
}else{

$str .='';

}

$notcommentsallread='';
if($comment_count !=0){

	$notcommentsallread='  <i><a href="'.e_SELF.'?mark_all_comments_as_read">['.ONLINEINFO_LOGIN_MENU_L91.']</a></i>';
}


$text .= '<tr>
<td class="fcaption">'.ONLINEINFO_LIST_2.' ('.$comment_count.') '.$notcommentsallread.'</td>
</tr><tr>
<td class="forumheader3">'.$str.'</td>
</tr>';

}

// ************************************************************
// ******                  New Chatbox                   ******
// ************************************************************

if ($plugPref ['onlineinfo_chatbox'] == 1 )
    {
    		if($chatboxread != '')
		{
			$chatbox_read = 'AND cb_id NOT IN ('.$chatboxread.')';
		}


unset($str);


$str = '<table width="100%">';


if($recents = $sql -> retrieve("chatbox", "*", "cb_datestamp>".$lvisit." ".$chatbox_read." ORDER BY cb_datestamp DESC LIMIT 0," . $plugPref ['onlineinfo_chatnum'] . "", true)){

  	$chatbox_posts = count($recents);
		foreach($recents as $row) {   
		extract($row);
		$cb_nickid = substr($cb_nick , 0, strpos($cb_nick , '.'));
		$cb_nick = substr($cb_nick , (strpos($cb_nick , '.')+1));

		$str .='<tr><td width="18px"><a href="'.e_REQUEST_SELF.'?markchatboxasread.'.$cb_id.'">
    <img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  </td>
    <td width="10%" nowrap>[ <a href="'.e_HTTP.'user.php?id.'.$cb_nickid.'" '.getuserclassinfo($cb_nickid).'>'.$cb_nick.'</a> ] </td>
    <td> '.$cb_message.'</td></tr>';
	}
}

if($chatbox_posts==0){
	$str = ONLINEINFO_LIST_4;
}else{

$str .='</table>';
}

$notchatboxallread='';
if($chatbox_posts !=0){

	$notchatboxallread='  <i><a href="'.e_REQUEST_SELF.'?mark_all_chatbox_as_read">['.ONLINEINFO_LOGIN_MENU_L91.']</a></i>';
}



$text .= '<tr>
<td class="fcaption">'.ONLINEINFO_LIST_5.' ('.$chatbox_posts.') '.$notchatboxallread.'</td>
</tr><tr>
<td class="forumheader3">'.$str.'</td>
</tr>';

}


// ************************************************************
// ******           New Forum Post (Summary)             ******
// ************************************************************

// FORUM
 if ($plugPref ['onlineinfo_forum'] == 1)
    {



require_once(e_PLUGIN.'forum/forum_class.php');
$forum = new e107forum;



if ($singleread[0] == 'markasread')
{
	$splitoutthreads = str_replace(',','.',$singleread[1]);
  $forum->threadMarkAsRead($splitoutthreads);
   /*
	unset ($u_new);
		$u_new = USERVIEWED.'.'.$splitoutthreads;
    $forum->forumMarkAsRead($splitoutthreads);
		$sql->db_Update("user", "user_viewed='$u_new' WHERE user_id=".USERID);
    */

	header("location:".e_REQUEST_SELF);
	exit;
}

/******************************************************************************/
// Mark all threads as read
/******************************************************************************/
if (e_QUERY == 'mark_all_as_read')
{
	unset($u_new);
	$qry = 'WHERE thread_lastpost > ' . $lvisit;
	if ($rows = $sql->retrieve('forum_thread', 'thread_id', $qry, true))
	{ 
       
		foreach($rows as $forumrow)
		{        
			$forum->threadMarkAsRead($forumrow['thread_id']);
      
		}            
                              
    e107::redirect(e_REQUEST_SELF);
		exit;
	}
}
/* LAST CHECK 30.7.2018 */


unset($str);
  /* jimmi */
  
$userviewed =  $currentUser['user_plugin_forum_viewed'];
 

$viewed = '';
		if($userviewed)
		{
			$viewed = cleanup($userviewed);
		}
		if($viewed != '')
		{
			$viewed = ' AND t.thread_id NOT IN ('.$viewed.')';
		}

	$oloop=0;

 

// ************************************************************
// ******          New Forum Post (Detailed)             ******
// ************************************************************

// Old Style
                  /*
$qry = "SELECT   fp.thread_name as post_subject, fp.thread_total_replies as replies, u.user_id, f.forum_name,f.forum_id, u.user_name, 
      f.forum_class
		FROM #forum_t AS ft
		LEFT JOIN #forum_t as fp ON fp.thread_id = ft.thread_parent
		LEFT JOIN #user as u ON u.user_id = SUBSTRING_INDEX(ft.thread_user,'.',1)
		LEFT JOIN #forum as f ON f.forum_id = ft.thread_forum_id
		WHERE ft.thread_datestamp > ".$lvisit. "
		AND f.forum_class IN (".USERCLASS_LIST.")
		".$viewed."
		ORDER BY ft.thread_datestamp DESC LIMIT 0, ".$plugPref ['onlineinfo_forumnum'];  */
    
    $qry = "
      SELECT t.thread_name AS parent_name, t.thread_id as parent_id,
			f.forum_id, f.forum_name, f.forum_class, 
			u.user_name, lp.user_name AS lp_name, 
			t.thread_id, t.thread_views as tviews, t.thread_name, t.thread_datestamp, t.thread_user,
			tp.post_thread, tp.post_user, tp.post_user_anon, t.thread_lastpost, t.thread_lastuser, t.thread_total_replies
			FROM #forum_thread AS t
			LEFT JOIN #forum_post AS tp ON t.thread_id = tp.post_thread
			LEFT JOIN #forum AS f ON f.forum_id = t.thread_forum_id
			LEFT JOIN #user AS u ON tp.post_user = u.user_id
			LEFT JOIN #user AS lp ON t.thread_lastuser = lp.user_id
			WHERE find_in_set(forum_class, '".USERCLASS_LIST."')
			AND t.thread_lastpost > {$lvisit}
      {$viewed} 
      GROUP BY t.thread_id
			ORDER BY tp.post_datestamp DESC LIMIT 0,".intval($plugPref ['onlineinfo_forumnum']);

$forum_posts_sql = new db;
$forum_posts = $forum_posts_sql->db_Select_gen($qry);
                       
while ($row = $forum_posts_sql->db_Fetch())
	{  
		extract($row);    
                
		$userinfo = explode('.',$thread_lastuser);
  
      if($post_user) {
        $uparams = array('id' =>$post_user, 'name' => $user_name);
        $link = e107::getUrl()->create('user/profile/view', $uparams);
        $LASTPOST = "<a href='".$link."' " .getuserclassinfo($userinfo[0])." >".$user_name."</a>";
 
      }
      else {
        $LASTPOST = $post_user_anon;
      }
		if($parent_id){
			$ttemp = $thread_id;
      // user_link 

      
       // post_subject = thread_name 
       // thread_lastuser_username = thread_lastuser
      //  $thread_user = thread_lastuser
      //  $thread_parent = $parent_id
			$str .= '<a href="'.e_REQUEST_SELF.'?markasread.'.$thread_id.'">
      <img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  
      [ <a href="'.e_PLUGIN.'forum/forum_viewforum.php?'.$forum_id.'">'.$forum_name.'</a> ] 
       Re: <a href="'.e_PLUGIN.'forum/forum_viewtopic.php?'.$ttemp.'.post">'.$thread_name.'</a> <i>'.ONLINEINFO_LOGIN_MENU_L90.'</i> 
       '.$LASTPOST.'<br />';
			}else{
				$str .= '<a href="'.e_REQUEST_SELF.'?markasread.'.$thread_id.'">
        <img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  
        [ <a href="'.e_PLUGIN.'forum/forum_viewforum.php?'.$forum_id.'">'.$forum_name.'</a> ] 
        <a href="'.e_PLUGIN.'forum/forum_viewtopic.php?'.$thread_id.'.post">'.$thread_name.'</a> <i>'.ONLINEINFO_LOGIN_MENU_L90.'</i> 
        '.$LASTPOST.'<br/>';
			}
}


$notallread='';
if($forum_posts !=0){

	$notallread='  <i><a href="'.e_SELF.'?mark_all_as_read">['.ONLINEINFO_LOGIN_MENU_L91.']</a></i>';
}

if(!$forum_posts){
	$str = ONLINEINFO_LIST_4;
}



$text .= '<tr>
<td class="fcaption">'.ONLINEINFO_LIST_6.' ('.$forum_posts.') '.$notallread.'</td>
</tr>
<td class="forumheader3">'.$str.'</td>
</tr>';

}

 

// ************************************************************
// ******                New Download                    ******
// ************************************************************

if ($plugPref ['onlineinfo_downloads'] == 1 && e107::isInstalled('download'))
{        
unset($str);

	if($downloadsread != '')
		{
			$downloads_read = 'AND download_id NOT IN ('.$downloadsread.')';
		}

if($new_downloads = $sql -> db_Select("download", "*", "download_datestamp>$lvisit and download_visible IN (".USERCLASS_LIST.") ".$downloads_read." ORDER BY download_datestamp DESC LIMIT 0," . $plugPref ['onlineinfo_downloadnum'] . "")){
	while($row = $sql -> db_Fetch()){
		extract($row);
		$str .= '<a href="'.e_SELF.'?markdownloadsasread.'.$download_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  <a href="'.e_BASE.'download.php?view.'.$download_id.'">'.$download_name.'</a><br />';
	}
}else{
	$str = ONLINEINFO_LIST_4;
}


$notdownloadsallread='';
if($new_downloads !=0){

	$notdownloadsallread='  <i><a href="'.e_SELF.'?mark_all_downloads_as_read">['.ONLINEINFO_LOGIN_MENU_L91.']</a></i>';
}

if (!$new_downloads){$new_downloads=0;}

$text .= '<tr>
<td class="fcaption">'.ONLINEINFO_LIST_17.' ('.$new_downloads.')'.$notdownloadsallread.'</td>
</tr><tr>
<td class="forumheader3">'.$str.'</td>
</tr>';

}

 

 
 

// ************************************************************
// ******                  New Link Page                 ******
// ************************************************************

if ($plugPref ['onlineinfo_links'] == 1)
    {
unset($str);

if($linksread != '')
		{
			$linksread = 'AND link_id NOT IN ('.$linksread.')';
		}

if($new_link = $sql -> db_Select("links_page", "*", "link_datestamp>$lvisit ".$linksread." ORDER BY link_datestamp DESC LIMIT 0," . $plugPref ['onlineinfo_linksnum'] . "")){
	while($row = $sql -> db_Fetch()){
		extract($row);
		$str .= '<a href="'.e_SELF.'?marknewlinksasread.'.$link_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  <a href="'.$link_url.'">'.$link_name.'</a><br />';
	}
}else{
	$str = ONLINEINFO_LIST_4;
}


$notnewlinksallread='';
if($new_link !=0){

	$notnewlinksallread='  <i><a href="'.e_SELF.'?mark_all_newlinks_as_read">['.ONLINEINFO_LOGIN_MENU_L91.']</a></i>';
}


$text .='<tr>
<td class="fcaption">'.ONLINEINFO_LIST_30.' ('.$new_link.')'.$notnewlinksallread.'</td>
</tr><tr>
<td class="forumheader3">'.$str.'</td>
</tr>';
}

 


// ************************************************************
// ******                  New blogs                     ******
// ************************************************************
if ($plugPref ['onlineinfo_blog'] == 1)
    {
unset($str);

if($blogsread != '')
		{
			$blogs_read = 'AND userjournals_id NOT IN ('.$blogsread.')';
		}


$script='SELECT '.MPREFIX.'userjournals.*, '.MPREFIX.'user.user_name FROM '.MPREFIX.'userjournals LEFT JOIN '.MPREFIX.'user ON '.MPREFIX.'userjournals.userjournals_userid = '.MPREFIX.'user.user_id WHERE userjournals_timestamp>'.$lvisit.' '.$blogs_read.' ORDER BY userjournals_timestamp DESC LIMIT 0,' . $plugPref ['onlineinfo_blognum'];


if($new_blogs = $sql->db_Select_gen($script)){

while ($row = $sql->db_Fetch()){
        extract($row);

		$str .= '<a href="'.e_SELF.'?marknewblogasread.'.$userjournals_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  <a href="'.e_PLUGIN.'userjournals_menu/userjournals.php?blog.'.$userjournals_id.'">'.$userjournals_subject.'</a> <i>'.ONLINEINFO_LOGIN_MENU_L90.'</i> <a href="'.e_BASE.'user.php?id.'.$userjournals_userid.'" '.getuserclassinfo($userjournals_userid).'>'.$user_name.'</a><br />';
	}
}else{
	$str = ONLINEINFO_LIST_4;
}


$notnewblogallread='';
if($new_blogs !=0){

	$notnewblogallread='  <i><a href="'.e_SELF.'?mark_allnewblog_as_read">['.ONLINEINFO_LOGIN_MENU_L91.']</a></i>';
}

if (!$new_blogs){$new_blogs=0;}

$text .= '<tr>
<td class="fcaption">'.ONLINEINFO_LIST_58.' ('.$new_blogs.')'.$notnewblogallread.'</td>
</tr><tr>
<td class="forumheader3">'.$str.'</td>
</tr>';

}

// ************************************************************
// ******                  New Suggestions               ******
// ************************************************************

if ($plugPref ['onlineinfo_suggestions'] == 1)
    {

    		if($suggestionsread != '')
		{
			$suggestions_read = 'AND suggestion_id NOT IN ('.$suggestionsread.')';
		}


unset($str);

if($suggestions_posts = $sql -> db_Select("sugg_suggs", "*", "suggestion_posted>".$lvisit." AND suggestion_approved=1 ".$suggestions_read." ORDER BY suggestion_posted DESC LIMIT 0," . $plugPref ['onlineinfo_suggestionsnum'] . "")){
	while($row = $sql -> db_Fetch()){
		extract($row);
		$author = explode('.',$suggestion_author);

		$str .= '<a href="'.e_SELF.'?marksuggestionsasread.'.$suggestion_id.'"><img src="'.e_PLUGIN_ABS.'onlineinfo/images/read.png" border="0" alt="'.ONLINEINFO_LOGIN_MENU_L92.'"></a>  <a href="'.e_PLUGIN.'suggestions_menu/suggestions.php?0.view.'.$suggestion_id.'">'.$suggestion_name.'</a> <i>'.ONLINEINFO_LOGIN_MENU_L90.'</i> <a href="'.e_BASE.'user.php?id.'.$author[0].'" '.getuserclassinfo($author[0]).'>'.$author[1].'</a><br />';



	}
}

if($suggestions_posts==0){
	$str = ONLINEINFO_LIST_4;
}

$notsuggestionsallread='';
if($suggestions_posts !=0){

	$notsuggestionsallread='  <i><a href="'.e_SELF.'?mark_all_suggestions_as_read">['.ONLINEINFO_LOGIN_MENU_L91.']</a></i>';
}



$text .= '<tr>
<td class="fcaption">'.ONLINEINFO_LIST_59.' ('.$suggestions_posts.') '.$notsuggestionsallread.'</td>
</tr><tr>
<td class="forumheader3">'.$str.'</td>
</tr>';

}
 


// ************************************************************
// ******                  New Member                    ******
// ************************************************************

if ($plugPref ['onlineinfo_members'] == 1)
{
	unset($str);
	if ($sitemembersread != '')
	{
		$sitemembers_read = 'AND user_id NOT IN (' . $sitemembersread . ')';
	}

	if ($recents = $sql->retrieve("user", "*", "user_join>$lvisit " . $sitemembers_read . " ORDER BY user_join DESC LIMIT 0," . $plugPref ['onlineinfo_usersnum'] . "", true))
	{
		$new_members = count($recents);
		foreach($recents as $row)
		{
			extract($row);
			$userurl = e107::url('user/profile/view', array(
				'name' => $user_name,
				'id' => $user_id
			));
			$str.= '<a href="' . e_REQUEST_SELF . '?marknewmemberasread.' . $user_id . '">
    <img src="' . e_PLUGIN_ABS . 'onlineinfo/images/read.png" border="0" alt="' . ONLINEINFO_LOGIN_MENU_L92 . '"></a>  
    <a href="' . $userurl . '" ' . getuserclassinfo($user_id) . '>' . $user_name . '</a><br />';
		}
	}
	else
	{
		$str = ONLINEINFO_LIST_4;
	}

	$notnewmemberallread = '';
	if ($new_members != 0)
	{
		$notnewmemberallread = '  <i><a href="' . e_REQUEST_SELF . '?mark_all_newmember_as_read">[' . ONLINEINFO_LOGIN_MENU_L91 . ']</a></i>';
	}

	if (!$new_members)
	{
		$new_members = 0;
	}

	$text.= '<tr>
<td class="fcaption">' . ONLINEINFO_LIST_7 . ' (' . $new_members . ')' . $notnewmemberallread . '</td>
</tr><tr>
<td class="forumheader3">' . $str . '</td>
</tr>';
}
// ************************************************************

$text.='<tr>
<td class="fcaption">&nbsp;</td>
</tr><tr>
<td class="forumheader3">'.colourkey(0).'</td>
</tr>';


$text .= '</table></div>';



$text = $tp->toHTML($text, true, 'emotes_on');



$ns -> tablerender(ONLINEINFO_LIST_3, $text);


require_once(FOOTERF);
?>