<?php
/*
	* e107 website system
	*
	* Copyright (C) 2008-2013 e107 Inc (e107.org)
	* Released under the terms and conditions of the
	* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
	*
	* e107 Web Links plugin
	*
	#######################################
	#     e107 website system plugin       #
	#     by Jimako                    	  #
	#     https://www.e107sk.com          #
	#######################################
*/

require_once '../../../class2.php';
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}
 
e107::lan("web_links" , "lang_admin");

class plugin_admin_ui extends e_admin_ui
{
	protected $pluginName   = 'web_links';
	protected $pluginTitle	=  _WEBLINKSADMIN;

	protected $perPage = 30;

	public function __construct($request, $response, $params = array()) {

		e107::getRender()->tablerender($caption, AdminHeader() );
		 
		parent::__construct($request, $response, $params = array());
	}
	 
	public function helpPage()
	{
		$ns = e107::getRender();

		include('e_help.php');
		$text = '<div class="tab-content" style="padding:10px;)><div class="tab-pane  active">'.$helplink_text['body'].'</div></div>';
		$ns->tablerender('',$text);	
		
	}
 
	public function renderHelp()
	{
		$tp = e107::getParser();
		$hide_help= e107::getPlugConfig('simplepage')->getPref('hide_help'); 
		if($hide_help) 
		{
			return '';
		}
		$text =
		'
			<ul class="list-unstyled text-center">
				<li><b>' . LAN_UN_LINKS_WEBLINKS . '</b></li>
				<li> ' . $tp->toHTML(LAN_UN_MAT_WEBLINKS, true) . ' </li>
				<li style="border-bottom: solid 1px dimgrey" class="divider">&nbsp;</li>
				<li>
					<h5>' . e107::getParser()->toGlyph('fa-heart') . '&nbsp;Thank the Developer!</h5>
				</li>
				<li>
					<p>
						<small>If you think this plugin is useful, please consider supporting what I do.</small>
					</p>
				</li>
				<li class="text-center">
					<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FKG5N3F6QL99J" rel="nofollow">
					<img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="Paypal" style="max-width:100%;"></a>
				</li>
				 
			
				<li class="text-center">
					<p>
						<small>Thank you</small>
					 ' . e107::getParser()->toGlyph('fa-smile-o') .'</p>
				</li>
			</ul> ';                 
		 
		return array('caption' => LAN_UN_LINKS_WEBLINKS, 'text' => $text);
	}


}