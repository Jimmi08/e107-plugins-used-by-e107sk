<?php

/**
  * UNITED-NUKE CMS: Just Manage!
  * http://united-nuke.openland.cz/
  * http://united-nuke.openland.cz/forums/
  *
  * 2002 - 2005, (c) Jiri Stavinoha
  * http://united-nuke.openland.cz/weblog/
  *
  * Translation to English language
  * http://axlsystems.amjawa.com/ - 2005, (c) Roman Vosicky
  *  
  * Portions of this software are based on PHP-Nuke
  * http://phpnuke.org - 2002, (c) Francisco Burzi
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
**/

global $anonwaitdays,  $outsidewaitdays;

if (!defined(("_WEBLINKS"))) { define("_WEBLINKS","Web Links"); }  

define("_URL","URL");
define("_PREVIOUS","Previous Page");
define("_NEXT","Next Page");
define("_YOURNAME","Your Name");
//define("_CATEGORY","Category");
define("_CATEGORIES","Categories");
define("_LVOTES","votes");
define("_TOTALVOTES","Total Votes:");
define("_LINKTITLE","Link Title");
define("_HITS","Hits");
define("_THEREARE","There are");
define("_NOMATCHES","No matches found to your query");
define("_SCOMMENTS","Comments");
define("_DESCRIPTION","Description");
//define("_DATE","Date");
define("_TO","To");
define("_ADDLINK","Add Link");
define("_NEW","New");
define("_POPULAR","Popular");
define("_TOPRATED","Top Rated");
define("_RANDOM","Random");
define("_LINKSMAIN","Links Main");
define("_LINKCOMMENTS","Link Comments");
define("_ADDITIONALDET","Additional Details");
define("_EDITORREVIEW","Editor Review");
define("_REPORTBROKEN","Report Broken Link");
define("_LINKSMAINCAT","Links Main Categories");
define("_AND","and");
define("_INDB","in our database");
define("_ADDALINK","Add a New Link");
define("_INSTRUCTIONS","Instructions");
define("_SUBMITONCE","Submit a unique link only once.");
define("_POSTPENDING","All links are posted pending verification.");
define("_USERANDIP","Nickname and IP address is recorded, please do not annoy our system.");
define("_PAGETITLE","Page Title");
define("_PAGEURL","Page URL");
define("_YOUREMAIL","Your Email");
define("_LDESCRIPTION","Description: (255 characters max)");
define("_ADDURL","Add this URL");
define("_LINKSNOTUSER1","You are not a registered user or you have not logged in.");
define("_LINKSNOTUSER2","If you were registered you could add links on this website.");
define("_LINKSNOTUSER3","Becoming a registered user is a quick and easy process.");
define("_LINKSNOTUSER4","Why do we require registration for access to certain features?");
define("_LINKSNOTUSER5","So we can offer you only the highest quality content,");
define("_LINKSNOTUSER6","each item is individually reviewed and approved by our staff.");
define("_LINKSNOTUSER7","We hope to offer you only valuable information.");
define("_LINKSNOTUSER8","<a href='".e_SIGNUP."'>Register for an Account</a>");
define("_LINKALREADYEXT","ERROR: This URL is already listed in the Database!");
define("_LINKNOTITLE","ERROR: You need to type a TITLE for your URL!");
define("_LINKNOURL","ERROR: You need to type a URL for your URL!");
define("_LINKNODESC","ERROR: You need to type a DESCRIPTION for your URL!");
define("_LINKRECEIVED","We received your Link submission. Thanks!");
define("_EMAILWHENADD","After link validation you will receive confirmation email.");
define("_CHECKFORIT","Please do not email us. Your web link will be checked and validate as soon as possible.");
define("_ERRORTHELINK","ERROR: The link (title, url or description) ");
define("_ALREADYEXIST","already exists!");
define("_NEWLINKS","New Links");
define("_TOTALNEWLINKS","Total New Links");
define("_LASTWEEK","Last Week");
define("_LAST30DAYS","Last 30 Days");
define("_1WEEK","1 Week");
define("_2WEEKS","2 Weeks");
define("_30DAYS","30 Days");
define("_SHOW","Show");
define("_TOTALFORLAST","Total new links for last");
define("_DAYS","days");
define("_ADDEDON","Added on");
define("_RATING","Rating");
define("_RATESITE","Rate this Site");
define("_DETAILS","Details");
define("_BESTRATED","Best Rated Links - Top");
//define("_OF","of");
define("_TRATEDLINKS","total rated links");
define("_TVOTESREQ","minimum votes required");
define("_SHOWTOP","Show Top");
define("_MOSTPOPULAR","Most Popular - Top");
define("_OFALL","of all");
define("_SORTLINKSBY","Sort Links by");
define("_SITESSORTED","Sites currently sorted by");
define("_POPULARITY","Popularity");
define("_SELECTPAGE","Select Page");
define("_MAIN","Main");
define("_NEWTODAY","New Today");
define("_NEWLAST3DAYS","New last 3 days");
define("_NEWTHISWEEK","New This Week");
define("_CATNEWTODAY","New Links in this Category Added Today");
define("_CATLAST3DAYS","New Links in this Category Added in the last 3 days");
define("_CATTHISWEEK","New Links in this Category Added this week");
define("_POPULARITY1","Popularity (Least to Most Hits)");
define("_POPULARITY2","Popularity (Most to Least Hits)");
define("_TITLEAZ","Title (A to Z)");
define("_TITLEZA","Title (Z to A)");
define("_DATE1","Date (Old Links Listed First)");
define("_DATE2","Date (New Links Listed First)");
define("_RATING1","Rating (Lowest Scores to Highest Scores)");
define("_RATING2","Rating (Highest Scores to Lowest Scores)");
define("_SEARCHRESULTS4","Search Results for");
define("_USUBCATEGORIES","Sub-Categories");
define("_LINKS","Links");
define("_TRY2SEARCH","Try to search");
define("_INOTHERSENGINES","in others Search Engines");
define("_EDITORIAL","Editorial");
define("_LINKPROFILE","Link Profile");
define("_EDITORIALBY","Editorial by");
define("_NOEDITORIAL","No editorial is currently available for this website.");
define("_VISITTHISSITE","Visit this Website");
define("_RATETHISSITE","Rate this Resource");
define("_ISTHISYOURSITE","Is this your resource?");
define("_ALLOWTORATE","Allow other users to rate it from your web site!");
define("_LINKRATINGDET","Link Rating Details");
define("_OVERALLRATING","Overall Rating");
define("_TOTALOF","Total");
define("_USER","User");
define("_USERAVGRATING","average rating");
define("_NUMRATINGS","Number of total Ratings");
define("_EDITTHISLINK","Edit This Link");
define("_REGISTEREDUSERS","Registered Users");
define("_NUMBEROFRATINGS","Number of Ratings");
define("_NOREGUSERSVOTES","No Registered User Votes");
define("_BREAKDOWNBYVAL","Breakdown of Ratings by Value");
define("_LTOTALVOTES","total votes");
define("_LINKRATING","Links Rating");
define("_HIGHRATING","High Rating");
define("_LOWRATING","Low Rating");
define("_NUMOFCOMMENTS","Number of Comments");
define("_WEIGHNOTE","* Note: This Resource weighs Registered vs. Unregistered users ratings");
define("_NOUNREGUSERSVOTES","No Unregistered User Votes");
define("_WEIGHOUTNOTE","* Note: This Resource weighs Registered vs. Outside voters ratings");
define("_NOOUTSIDEVOTES","No Outside Votes");
define("_OUTSIDEVOTERS","Outside Voters");
define("_UNREGISTEREDUSERS","Unregistered Users");
define("_PROMOTEYOURSITE","Promote Your Website");
define("_PROMOTE01","There is several options how to rate your page in our web link archive.");
define("_TEXTLINK","Text Link");
define("_PROMOTE02","One way to link to the rating form is through a simple text link:");
define("_HTMLCODE1","The HTML code you should use in this case, is the following:");
define("_THENUMBER","The Number");
define("_IDREFER","in this code is unigue ID under which your link is saved in our database. Please make sure, that the link really points to your website.");
define("_BUTTONLINK","Button Link");
define("_PROMOTE03","If you look for something else then simple text link, you can use following button:");
define("_RATEIT","Rate this Site!");
define("_HTMLCODE2","The source code for the above button is:");
define("_REMOTEFORM","Remote Rating Form");
define("_PROMOTE04","Please do not abuse rating forms. Our policy is simple: if we find out the website with the form that does not correcpond to our records, we will block the rating of this website or remove it from our database.");
define("_VOTE4THISSITE","Vote for this Site!");
define("_LINKVOTE","Vote!");
define("_HTMLCODE3","Using this form will allow users to rate your resource directly from your site and the rating will be recorded here. The above form is disabled, but the following source code will work if you simply cut and paste it into your web page. The source code is shown below:");
define("_PROMOTE05","Thanks! and good luck with your ratings!");
define("_STAFF","Staff");
define("_THANKSBROKEN","Thank you for your help to keep our database up-to-date. Click on link bellow to confirm it.");
define("_THANKSFORINFO","Thanks for the information.");
define("_LOOKTOREQUEST","We will process your request as soon as possible.");
define("_ONLYREGUSERSMODIFY","Only registered users can suggest links modifications. Please <a href=\"modules.php?name=".UN_DIR_YOURACOUNT."\">register or login</a>.");
define("_REQUESTLINKMOD","Request Link Modification");
define("_LINKID","Link ID");
define("_SENDREQUEST","Send Request");
define("_THANKSTOTAKETIME","Thank you for taking the time to rate a site here at");
define("_LETSDECIDE","Input from users such as yourself will help other visitors better decide which links to click on.");
define("_RETURNTO","Return to");
define("_RATENOTE1","Please do not vote for the same link more than once.");
define("_RATENOTE2","The scale is 1 - 10, with 1 being poor and 10 being excellent.");
define("_RATENOTE3","Please be objective. If everybody vote for 1 or 10 the rating does not have sense.");
define("_RATENOTE4","You can view a list of the <a href=\"[x]?l_op=TopRated\">Top Rated Resources</a>.");
define("_RATENOTE5","Please do not vote if the website is yours.");
define("_YOUAREREGGED","You are a registered user and are logged in.");
define("_FEELFREE2ADD","Feel free to add a comment about this site.");
define("_YOUARENOTREGGED","You are not a registered user or you have not logged in.");
define("_IFYOUWEREREG","If you were registered you could make comments on this website.");
 
//define("_TITLE","Title");
define("_MODIFY","Modify");
define("_COMPLETEVOTE1","Your vote is appreciated.");
define("_COMPLETEVOTE2","You have already voted for this resource in the past $anonwaitdays day(s).");
define("_COMPLETEVOTE3","Vote for a resource only once.<br>All votes are recorded and reviewed.");
define("_COMPLETEVOTE4","You cannot vote on a link you submitted.<br>All votes are recorded and reviewed.");
define("_COMPLETEVOTE5","No rating selected - no vote tallied");
define("_COMPLETEVOTE6","Only one vote per IP address allowed every $outsidewaitdays day(s).");
define("_LINKSDATESTRING","%d-%b-%Y");

//pridane
define("_SCOMMENTSVL","Your comment");
define("_SEARCHWL","Search");
define("_NEWLINKS2","new link(s)");

define("_GOBACK","[ <a href=\"javascript:history.go(-1)\">Back</a> ]");
define("_NOTE","Note:");
define("_VOTES","Votes");
define("_COMMENTS","Comments");
define("_ANONYMOUSNAME","Anonymous Default Name");
define("_NONE","None");

?>
