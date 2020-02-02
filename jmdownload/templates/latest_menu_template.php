<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *
 *
 * $Source: /cvs_backup/e107_0.8/e107_plugins/download/templates/download_template.php,v $
 * $Revision$
 * $Date$
 * $Author$
 */

if (!defined('e107_INIT')) { exit; }

$LATEST_MENU_WRAPPER['JM_DOWNLOAD_CATEGORY'] 			= "<p>{---}</p>";
$LATEST_MENU_WRAPPER['JMDOWNLOAD_SIZE'] 			= "<span>{---}</span>";
$LATEST_MENU_WRAPPER['JMDOWNLOAD_AUTHOR'] 			= "<div class='author'>{---}</div>";

$LATEST_MENU_TEMPLATE['caption'] = '<h2 class="section-title">{MENU_CAPTION}</h2>';
$LATEST_MENU_TEMPLATE['start'] = '<div class="row">';
 
 
$LATEST_MENU_TEMPLATE['item']['item'] = '
<div class="col-md-4 col-sm-6  ">	 
	 <div class="icon-box icon-box-info" style="width: 95%;"> 
   <i class="fa fa-cloud-download"></i> 
    <div class="icon-box-content"> 
      <div >
			  <a href="{JMDOWNLOAD_VIEW_LINK}"><h3 class="contenttitle">{JMDOWNLOAD_NAME}</h3></a> </div>
				{JMDOWNLOAD_CATEGORY} 
			  <time class="icon-time" datetime="{JMDOWNLOAD_VIEW_DATETIME}">
		    {JMDOWNLOAD_VIEW_DATE}
			  </time>			
			  
			  {JMDOWNLOAD_AUTHOR} {JM_DOWNLOAD_ADMIN_EDIT}   
			  {JMDOWNLOAD_DESCRIPTION}
			  {JMDOWNLOAD_SIZE}
    </div>
    </div>
 </div> 
 ';
$LATEST_MENU_TEMPLATE['item']['separator'] = '';
$LATEST_MENU_TEMPLATE['end'] = '</div> ';  