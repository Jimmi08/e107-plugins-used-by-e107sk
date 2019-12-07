<?php
	/**
	 * e107 website system
	 *
	 * Copyright (C) 2008-2017 e107 Inc (e107.org)
	 * Released under the terms and conditions of the
	 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
	 *
	 */ 

/* view.php */	 
if(deftrue('BOOTSTRAP')) {
$SURVEY_TEMPLATE['view']['search'] 	= " 
<div class='row text-center' id='view_search' >  
  <div class='col-md-12 well'>  
    <form  action='{ACTION}' method='POST' class='form-inline' >  
      <div class='form-group'>       
        <input type='text' class='form-control tbox' name='search_text' value='{SEARCH_TEXT}' placeholder='{SEARCH_TEXT}'>  
      </div>  
      <input type='submit' class='button btn btn-default' name='search' value='".LAN_SUR11."'>  
      <div class='radio'>  
        <label>    
          <input type='checkbox' class='tbox'  name='list'>".LAN_SUR12."   
        </label>
      </div>  
    </form>  
  </div>  
</div>
";  
}
else {
$SURVEY_TEMPLATE['view']['search'] 	= "
<form action='{ACTION}' method='POST' class=''>
	<div style='text-align:center;'>
	<table class='table3'><tr>
	<td class='forumheader3'><input class='tbox' type='text' name='search_text' value='{SEARCH_TEXT}'></td>
	<td class='forumheader3'><input type='submit' class='tbox' name='search' value='".LAN_SUR11."'></td>
	<td class='forumheader3'><input type='checkbox' class='tbox' name='list'>".LAN_SUR12."</td>
	</tr></table></div></form>
	";
}
if(deftrue('BOOTSTRAP')) {
$SURVEY_TEMPLATE['view']['resultsbox'] 	= "
<div class='row text-left' id='view_resultsbox'>     
  <div class='col-md-6'>    
    <ul class='list-group'>  
      <li class='list-group-item'> 
        <span class='badge'>{NUMRESULTS}
        </span>".LAN_SUR14.":
      </li>  
      <li class='list-group-item'> 
        <span class='badge'>{FIRST_RESPONSE}
        </span>".LAN_SUR19.":
      </li>  
      <li class='list-group-item'> 
        <span class='badge'>{LAST_RESPONSE}
        </span>".LAN_SUR20.":
      </li>
    </ul>    
  </div>  
  <div class='col-md-6'>  
    <a href='word.php?{SURVEY_ID}' target='_blank' rel='nofollow' >
      <img src='images/Word.png' alt='".LAN_SUR100."' title='".LAN_SUR100."' width='32' height='32' border='0'></a>
    <a href='excel.php?{SURVEY_ID} target='_blank' rel='nofollow' '>
      <img src='images/Excel.png' title='".LAN_SUR101."' alt='".LAN_SUR101."' width='32' height='32' border='0'></a>
    <a href=\"javascript:open_window('view.php?{SURVEY_ID}.{SEARCH_TEXT}.{SELECTED_REC}{OPTS}')\">
      <img src='images/print.png' alt='".LAN_SUR35."' title='".LAN_SUR34."' width='32' height='32' border='0'></a>  
  </div>
</div>
";
}
else {
$SURVEY_TEMPLATE['view']['resultsbox'] 	= " 
<table align='center' class='table4'>   
  <tr>   
    <td class='forumheader2'>
      <div class='defaulttext'>".LAN_SUR14.":
      </div></td>
    <td class='forumheader2'>
      <div class='defaulttext'>{NUMRESULTS}
      </div></td>   
  </tr>
  <td class='forumheader2'>
    <div class='defaulttext'>".LAN_SUR19.":
    </div></td>
  <td class='forumheader2'>
    <div class='defaulttext'>{FIRST_RESPONSE}
    </div></td>
  </tr>
  <tr>
    <td class='forumheader2'>
      <div class='defaulttext'>".LAN_SUR20.":
      </div></td>
    <td class='forumheader2'>
      <div class='defaulttext'>{LAST_RESPONSE}
      </div></td>
  </tr>
  <tr>
    <td colspan='2'>
      <a href='word.php?{SURVEY_ID}'>
        <img src='images/Word.png' alt='".LAN_SUR100."' title='".LAN_SUR100."' width='32' height='32' border='0'></a>
      <a href='excel.php?{SURVEY_ID}'>
        <img src='images/Excel.png' title='".LAN_SUR101."' alt='".LAN_SUR101."' width='32' height='32' border='0'></a>
      <a href=\"javascript:open_window('view.php?{SURVEY_ID}.{SEARCH_TEXT}.{SELECTED_REC}{OPTS}')\">
        <img src='images/print.png' alt='".LAN_SUR35."' title='".LAN_SUR34."' width='32' height='32' border='0'></a></td>
  </tr></td>
  </tr>
</table>
";
} 



/* survey.php change this in theme templates and select in survey template in admin */	  
$SURVEY_TEMPLATE['view']['start'] 	= '{MESSAGE_TOP}';   
$SURVEY_TEMPLATE['view']['end'] 	= '{MESSAGE_BOTTOM}'; 

 