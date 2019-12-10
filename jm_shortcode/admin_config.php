<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('jm_shortcode',true);


class jm_shortcode_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'jm_shortcode_ui',
			'path' 			=> null,
			'ui' 			=> 'jm_shortcode_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(
    'main/index'		=> array('caption'=> 'About plugin', 'perm' => 'P')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'JM Shortcode Menu';
}




				
class jm_shortcode_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'JM Shortcode Menu';
		protected $pluginName		= 'jm_shortcode';
	//	protected $eventName		= 'jm_shortcode-'; // remove comment to enable event triggers in admin. 		
		protected $table			= '';
		protected $pid				= '';
 
 
		
		// left-panel help menu area. 
		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text =  'You can find more info about this plugin on <a href="https://www.e107.sk/51/jm-shortcode-plugin" target="_blank">e107.sk</a> 
			<br> You can support next development by visiting this site with AdBlock Off. Thank you.
			<br> We don\'t need your money, we need your feedback and activity. ';

			return array('caption'=>$caption,'text'=> $text);

		}
			
 	
		// optional - a custom page.  
		public function IndexPage()
		{
			$text = "<h2>JM Shortcode Plugin v 2.0</h2>
<p>This is very simple plugin to extend possibility to use shortcodes directly in Menu manager.</p>
<p>In fact it's just configurable menu with About page.</p>
<p><em>About name:</em></p>
<p>I use shortcut JM to be sure I avoid any conflict with other plugins.</p>
<p>Original plugin directory was shortcode_menu plugin, but menu file has to end with _menu, so it looked very weird: shortcode_menu_menu.php, so I cut it.&nbsp;</p>
<p><em>Reasons for this:</em></p>
<p>1. power of e107 shortcodes&nbsp; (visibility, configuration, templating).</p>
<p>2. you can use custom menus, but with Tinymce plugin there could be parse issues. With custom menu you create page too, so easier way is better.</p>
<p>3. you can use theme shortcodes, but you can't have them as menu&nbsp;</p>
<p>4. there are menus with parameters, but they are missing configuration in Menu manager.</p>
<p>Shortly, this saves theme development time.&nbsp;</p>
<p><em>Negative:</em></p>
<p><em>-&nbsp;</em>for now you need to click on configuration button to see menu parameters (I have feature request for this )</p>
<p>- you need to know how shortcodes look and how to set them.&nbsp; For this I am creating list of available shortcodes on our site</p>
<p><strong>Example:</strong></p>
<p>Chapter menu (page/chapter_menu.php).&nbsp; You can add it Menu manager (It's listed there). No parameters.&nbsp;</p>
<p>You can insert it to theme.php this way:</p>
<p>{MENU: path=page/chapter} to have the same result as in Menu manager.</p>
<p>You can use&nbsp;{MENU: path=page/chapter&book=2} to display just chapters of book 2, but only hardcoded.</p>
<p>OR</p>
<p>you can add shortcode menu in Menu manager, click on configuration and insert shortcode there. This way each your menu can have different caption (you can set there too), or can be without caption.&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
     ";
			 
			return $text;
			
		}
 
			
}
				


class jm_shortcode_form_ui extends e_admin_form_ui
{

}		
		
		
new jm_shortcode_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>