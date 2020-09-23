<?php
	/**
	 * e107 website system
	 *
	 * Copyright (C) 2008-2017 e107 Inc (e107.org)
	 * Released under the terms and conditions of the
	 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
	 *
	 */



$POPULAR_MENU_TEMPLATE['default']['start'] 	= "<ul class='media-list unstyled list-unstyled popular-menu'>{SETIMAGE: w=100&h=100&crop=1}"; // set the {NEWSIMAGE} dimensions.
$POPULAR_MENU_TEMPLATE['default']['item'] 	= '<li class="media">
													  <div class="media-left media-top">
															<a href="{NEWS_URL}">
													      {NEWS_IMAGE: type=tag&class=media-object img-rounded&placeholder=1}
															</a>
													  </div>
													  <div class="media-body">
													    <h4 class="media-heading">{NEWS_TITLE}</a></h4>
													    <p>{NEWS_SUMMARY: limit=60}</p>
													    <small>{GLYPH=fa-stats} {HITS_COUNTER}</small>
													  </div>
													  </li>';
										
$POPULAR_MENU_TEMPLATE['default']['end'] 	= "</ul>";