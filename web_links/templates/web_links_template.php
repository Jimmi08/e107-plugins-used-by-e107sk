<?php


$WEB_LINKS_TEMPLATE['OPEN_TABLE'] = '<div class="panel panel-default un-wrapper"><div class="un-subwrapper">';
$WEB_LINKS_TEMPLATE['CLOSE_TABLE'] = "</div></div>";
$WEB_LINKS_TEMPLATE['OPEN_TABLE_2'] = '<div class="un-wrapper"><div class="un-subwrapper">';
$WEB_LINKS_TEMPLATE['CLOSE_TABLE_2'] = "</div></div>";

$WEB_LINKS_TEMPLATE['FORM_START_DIV_CLASS'] = " d-flex justify-content-center mt-4";
$WEB_LINKS_TEMPLATE['FORM_CLASS'] = " col-md-12 ";
$WEB_LINKS_TEMPLATE['FORM_ADD_BUTTON_CLASS'] = " button btn btn-primary ";

/* table version */
/*
$WEB_LINKS_TEMPLATE['CATEGORY_TABLE_START'] = "<table border=\"0\" cellspacing=\"10\" cellpadding=\"0\" align=\"center\">";
$WEB_LINKS_TEMPLATE['CATEGORY_COLUMN_START'] = "<td>";
$WEB_LINKS_TEMPLATE['CATEGORY_COLUMN_END'] = "</td>";
$WEB_LINKS_TEMPLATE['CATEGORY_COLUMN_CENTER'] = "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
$WEB_LINKS_TEMPLATE['CATEGORY_COLUMN_EMPTY'] = "<td></td>";
$WEB_LINKS_TEMPLATE['CATEGORY_ROW_START'] = "<tr>";
$WEB_LINKS_TEMPLATE['CATEGORY_ROW_END'] = "</tr>";
$WEB_LINKS_TEMPLATE['CATEGORY_TABLE_END'] = "</table>";
$WEB_LINKS_TEMPLATE['CENTER_START'] = "<br><br><center>";
$WEB_LINKS_TEMPLATE['CENTER_END'] = "<center><br>";
*/
 

$WEB_LINKS_TEMPLATE['CATEGORY_TABLE_START'] = '<div class="cards cards-hover row">';
$WEB_LINKS_TEMPLATE['CATEGORY_ROW_START'] = ' ';
$WEB_LINKS_TEMPLATE['CATEGORY_COLUMN_START'] = '<div class="col-md-6 col-lg-6"><div class="card-block card-default text-center animated mb-4 shadow-lg  bg-light"><div class="card-body"> ';
$WEB_LINKS_TEMPLATE['CATEGORY_COLUMN_END'] = "</div></div></div>";
$WEB_LINKS_TEMPLATE['CATEGORY_COLUMN_CENTER'] = " ";
$WEB_LINKS_TEMPLATE['CATEGORY_ROW_END'] = " ";
$WEB_LINKS_TEMPLATE['CATEGORY_TABLE_END'] = "</div> ";
$WEB_LINKS_TEMPLATE['CENTER_START'] = " <div class='d-flex justify-content-center pb-3'>";
$WEB_LINKS_TEMPLATE['CENTER_END'] = " </div>";

//this is correct for html 5 specs */
$WEB_LINKS_TEMPLATE['CATEGORY_INLINE_CSS'] = "";

$WEB_LINKS_TEMPLATE['SUBCATEGORY_SEPARATOR'] = ", ";
$WEB_LINKS_TEMPLATE['SUBCATEGORY_ITEM'] = "<span class=\"content\"><a class='card-link' href='{SUBCAT_LINK}'>{SUBCAT_TITLE}</a></span>";

$WEB_LINKS_TEMPLATE['CATEGORY_ITEM'] = "<span class=\"option\"><span class='big'>&middot;</span> <a href='{CAT_LINK}'><b>{CAT_TITLE}</b></a></span>
<br><span class=\"content\">{CAT_DESC}</span><br>
";