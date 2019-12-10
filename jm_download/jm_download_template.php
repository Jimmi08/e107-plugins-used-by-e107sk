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

$JM_DOWNLOAD_WRAPPER['latest_menu']['JM_DOWNLOAD_CATEGORY'] 			= "<p>{---}</p>";


$JM_DOWNLOAD_TEMPLATE['latest_menu']['caption'] = '
						';
$JM_DOWNLOAD_TEMPLATE['latest_menu']['start'] = '
<div class="col-md-12">
               <h2 class="section-title">Latest downloads</h2>
            </div>
 ';
 
 
$JM_DOWNLOAD_TEMPLATE['latest_menu']['item'] = '
<div class="col-md-4 col-sm-6  ">	 
	 <div class="icon-box icon-box-info" style="width: 95%;"> 
   <i class="fa fa-cloud-download"></i> 
    <div class="icon-box-content"> 
      <div >
			  <a href="{JM_DOWNLOAD_VIEW_LINK}"><h3 class="contenttitle">{JM_DOWNLOAD_NAME}</h3></a> </div>
				{JM_DOWNLOAD_CATEGORY}
			  <time class="icon-time" datetime="{JM_DOWNLOAD_VIEW_DATETIME}">
		    {JM_DOWNLOAD_VIEW_DATE}
			  </time>			
			  <div class="author">
			  {JM_DOWNLOAD_AUTHOR} {JM_DOWNLOAD_ADMIN_EDIT}   
			  </div>
    </div>
    </div>
 </div> 
 ';
$JM_DOWNLOAD_TEMPLATE['latest_menu']['end'] = ' ';  