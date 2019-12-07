<?php

// loading css and js common just for menu and one page, not for all site in e_header.php

$skin = (e107::pref('jm_jplayer', 'skin')) ? e107::pref('jm_jplayer', 'skin') : 0;

if (0 == $skin)
{
		$css_filename = 'default';
}
elseif (1 == $skin)
{
		$css_filename = 'popestar';
}

if (!empty($_GET['playlist_id']) && $_GET['iframe'] == 'true')
{
		$embed = true;
}

e107::css('jm_jplayer', '/assets/css/min/jplayer-popestar.css');
e107::css('jm_jplayer', '/assets/css/min/jplayer-' . $css_filename . '.min.css');
e107::css('jm_jplayer', '/assets/wp/dashicons.min.css');
e107::css('jm_jplayer', '/assets/wp/dashicons.min.css');

e107::lan('jm_jplayer',false,true);
require_once (e_PLUGIN . 'jm_jplayer/includes/functions.php');

$bg_color_hex 	= e107::pref('jm_jplayer', 'bg_color') ? e107::pref('jm_jplayer', 'bg_color') : '#353535';
$bg_color_hex 	= e107::getParser()->toHtml($bg_color_hex);
$bg_color_rgba 	= e107::pref('jm_jplayer', 'bg_color') ? wolf_jplayer_hex_to_rgb(e107::pref('jm_jplayer', 'bg_color')) : wolf_jplayer_hex_to_rgb('#353535');
$bg_color_rgba 	= e107::getParser()->toHtml($bg_color_rgba);
$opacity 				= e107::pref('jm_jplayer', 'bg_opacity') ? intval(e107::pref('jm_jplayer', 'bg_opacity')) / 100 : 1;
$opacity 				= e107::getParser()->toHtml($opacity);
$font_color			= e107::pref('jm_jplayer', 'font_color') ? e107::pref('jm_jplayer', 'font_color') : '#ffffff';
$font_color 		= e107::getParser()->toHtml($font_color);
$song_height 		= 37; // default

// ???JM  $skin = absint( wolf_get_jplayer_option( 'font_color' ) );
// if ( 1 == wolf_get_jplayer_option( 'font_color' ) ) {
// 	$song_height = 40;
// }

$max_song_count = e107::pref('jm_jplayer', 'song_count_before_scroll');
$song_height 		= 37; // default

//	$skin = absint( wolf_get_jplayer_option( 'font_color' ) );      ???? CHECK

$playlist_height = (e107::pref('jm_jplayer', 'scrollbar') && $max_song_count) ? $max_song_count * $song_height : '';
$inline_css = '';

if ($embed):
		$inline_css.= '	body {background:none}
		  #wolf-jp-popup { display:none!important } ';
endif;

if ($in_popup && 0 == $skin):
		$inline_css.= ' html { background: ' . $bg_color_hex . '}
			body{
				background: ' . $bg_color_hex . ';
				height:auto!important;
			      	overflow-x:hidden!important;overflow-y:hidden!important; 
			}			
			.jp-repeat, .jp-repeat-off{
				right:34px!important;
			}
			.jp-shuffle, .jp-shuffle-off{
				right:10px!important;
			}	';
endif;
$inline_css.= '
		.wolf-jplayer-playlist-container, .wolf-jplayer-playlist a{
			color: ' . $font_color . '!important;
		}
		.wolf-jplayer-playlist .jp-play-bar, .wolf-jplayer-playlist .jp-volume-bar-value{
			background-color: ' . $font_color . '
		}
		.wolf-jplayer-loader-overlay{
			background-color: ' . $bg_color_hex . '
		}
		.wolf-jplayer-playlist-container{
			background-color:rgba(' . $bg_color_rgba . ',' . $opacity . ');
		}
		
		.wolf-jplayer-playlist-container .mCSB_scrollTools .mCSB_dragger_bar{
			background-color: ' . $font_color . ';
		}
 
}
		';

if ($playlist_height)
{
		$inline_css.= '.wolf-jplayer-playlist-container.wolf-jplayer-scrollbar .jp-playlist{
			max-height : ' . $playlist_height . 'px; }';
}

$inline_css.= '
		.wolf-music-logo-link{ border:none!important; } 
		.wolf-music-logo { 
		border:none!important; 
		box-shadow:none!important; -moz-box-shadow:none!important; 
		-webkit-box-shadow:none!important; 
		-o-box-shadow:none!important; }';
		
e107::css('inline', $inline_css);

if (e107::pref('jm_jplayer', 'scrollbar'))
{
		e107::css('jm_jplayer', '/assets/css/min/mCustomScrollbar.min.css');
		e107::js('footer', '{e_PLUGIN}/jm_jplayer/assets/js/min/jquery.mCustomScrollbar.concat.min.js', 'jquery', 3);
}
            
$inline_script = '
 
		var WolfjPlayerParams = { 
			"iTunesText": "' 	.LAN_FRONT_01 . '", 
			"amazonText": "' 	. LAN_FRONT_02 . '", 
			"buyNowText": "' 	. LAN_FRONT_03 . '", 
			"downloadText": "' .LAN_FRONT_04. '",
			"byText": "' 			.LAN_FRONT_05. '",
			"scrollBar": "",
			"skin": "' .$skin. '",             
		}; 
		
 
		';
	             
 
e107::js('inline', $inline_script, 'jquery', 4);	
	
e107::js('footer', '{e_PLUGIN}/jm_jplayer/assets/js/min/jquery.jplayer.concat.min.js', 'jquery', 5);


// THIS CLASS IS FOR FUTURE USING

class jm_jplayer_plugin_shortcodes extends e_shortcode

{
		protected $jmpref = array();
		public

		function __construct()
		{
				$this->jmpref = e107::pref('jm_jplayer');
		}

		function sc_playlist_name($parm = null)
		{
				return e107::getParser()->toHtml($this->var['name'], true, 'TITLE');
		}
}

// THIS CLASS IS FOR FUTURE USING

class jm_jplayer

{
		protected $jmpref = array();
		
		public
		function __construct()
		{
				$this->sc = new jm_jplayer_plugin_shortcodes();
				$this->get = $_GET;
				$this->post = $_POST;
		}


		private
		function renderForm()
		{
				$frm = e107::getForm();
				if (!USER)
				{
				}

				return $text;
		}

		public
		function render()
		{
				$ns = e107::getRender();
		}

 
}

if (!class_exists('Wolf_Jplayer_Show'))
{
		/**
		 * WolfJplayer output class
		 *
		 * @package WolfJplayer
		 * @since WolfJplayer 1.0.0
		 */
		class Wolf_Jplayer_Show
		{
				/**
				 * Output popup JS in wp_head
				 *
				 * @return string
				 */
				public

				function popup()
				{
						$popup = 'jQuery(".wolf-jp-popup").click(function() {
						Player = $(this).parent().prev();
						Player.jPlayer("stop");
				 		var url = jQuery(this).attr("href");
				 		var popupHeight = jQuery(this).parents(".wolf-jplayer-playlist-container").height();
						var popup = window.open(url,"null", "height=" + popupHeight + ",width=570, top=150, left=150");
						if (window.focus) {
							popup.focus();
						}
						return false;
						});';
						return $popup;
				}

 
				/**
				 * Check if a default playlist poster is set
				 *
				 * Otherwise, return the default image from the images folder : default_poster.png
				 *
				 * @param int $playlist_id
				 * @return string
				 */
				public

				function get_default_playlist_poster($playlist_id)
				{
						$sql = e107::getDb();
						$tp = e107::getParser();
						$where = 'id=' . $playlist_id;
						$poster = $sql->retrieve('jm_jplayer_playlists', 'poster', $where);
						return $poster ? $tp->replaceConstants($poster, 'full') : e_PLUGIN . 'jm_jplayer/assets/images/default_poster.png';
				}


				/**
				 * Output inline jplayer javascript
				 *
				 * @param int $id
				 * @param int $playlist_id
				 * @param array $songs
				 * @param bool $popup
				 * @param bool $autoplay
				 * @return string
				 */
				public

				function head_script($id, $playlist_id, $songs, $in_popup, $autoplay = false)
				{
						$output = '';
						$playlist = '';
						$artist = '';
						$free = null;
						$external = 0;
						$tp = e107::getParser();
						if ($songs)
						{							
								foreach($songs as $song)
								{     
										$free = $song['free'];
										if ($song['poster'])
										{
												$poster = $tp->replaceConstants($song['poster'], 'full');
										}
										else
										{
												$poster = $this->get_default_playlist_poster($playlist_id);
										}

										$playlist.= '{  title : "' . $song['name'] . '", mp3:"' . $tp->replaceConstants($song['mp3'], 'full') . '"';								
										if ($song['artist']) $playlist.= ', artist : "' . $song['artist'] . '" ';
										if ($free != '1')
										{
												if ($song['itunes']) $playlist.= ', itunes : "' . $tp->toText($song['itunes']) . '" ';
												if ($song['amazon']) $playlist.= ', amazon : "' . $tp->toText($song['amazon']) . '" ';
												if ($song['buy']) $playlist.= ', buy : "' . $tp->toText($song['buy']) . '" ';
										}
										else
										{
												$playlist.= ',download : "' . $tp->replaceConstants($song['mp3'], 'full') . '" '; // is free
										}

										$playlist.= ',poster : "' . $poster . '" ';
										$playlist.= ' },';
								}

								$playlist = substr($playlist, 0, -1);
								$output.= '<script type="text/javascript">//<![CDATA[';
								$output.= "\n";
								$output.= 'jQuery(document).ready(function($) {
										new jPlayerPlaylist( {
										jPlayer: "#jquery_jplayer_' . $id . '",
										cssSelectorAncestor: "#jp_container_' . $id . '" },
										[' . $playlist . '], {
										swfPath: "' . e_PLUGIN . 'jm_jplayer/assets/js/src",
										wmode: "window"';

 

								// $output .= ', solution:"html, flash"';

								if ($autoplay && $autoplay == 'on')
								{
										$output.= ',
									playlistOptions: { autoPlay : true }';
								}

								$output.= '});'; // end playlist
								if (!$in_popup) $output.= $this->popup();
								$output.= '});'; // end document ready playlist
								$output.= '//]]></script>';
						}

						echo $output;
				}

				/**
				 * Output jplayer HTML
				 *
				 * @param int $playlist_id
				 * @param bool $in_popup
				 * @param bool $embed
				 * @return string
				 */
				public

				function jplayer_show_playlist($playlist_id, $in_popup, $embed = false)
				{
						$sql = e107::getDb();
						$tp = e107::getParser();
						$wolf_jplayer_playlists_table = '#jm_jplayer_playlists';
						$wolf_jplayer_table = '#jm_jplayer';
						$playlist = $sql->retrieve("SELECT * FROM $wolf_jplayer_playlists_table WHERE id = '$playlist_id'", TRUE);
						$songs = $sql->retrieve("SELECT * FROM $wolf_jplayer_table WHERE playlist_id = '$playlist_id' ORDER BY position", TRUE);
						$autoplay = null;
						$playlist = $playlist[0];
						if ($playlist) $share_title = $playlist['name'] . ' | ' . SITENAME;
						else $share_title = SITENAME;						
						
						$id = $playlist_id . rand(1, 999);
						
						if ($playlist && $songs):
								$autoplay = $playlist['autoplay'];
								$max_song_count = e107::pref('jm_jplayer', 'song_count_before_scroll');
								$count_songs = (e107::pref('jm_jplayer', 'scrollbar') && $max_song_count) ? $max_song_count : count($songs);
								$player_height = 170 + 35 * $count_songs;
								$logo = null;
								$html = $this->head_script($id, $playlist_id, $songs, $in_popup, $autoplay);
								$poster = $this->get_default_playlist_poster($playlist_id);
								$playlisturl = e_PLUGIN_ABS . 'jm_jplayer/jplayer.php?playlist_id=' . $playlist_id;
								if ($playlist['logo'])
								{
										$logo = "background-image : url( '" . $tp->replaceConstants($playlist['logo'], 'full') . "' );";
								}

								//	$mobile_class    = wp_is_mobile() ?' wolf-jplayer-is-mobile' : '';

								$scrollbar_class = e107::pref('jm_jplayer', 'scrollbar') ? '  wolf-jplayer-scrollbar' : '';
								$html.= '<!-- jPlayer -->
				<div class="wolf-jplayer-playlist-container' . $mobile_class . $scrollbar_class . '">
					<div class="wolf-jp-blur-bg" style="background-image:url( ' . $poster . ' );"></div>
					<div class="wolf-jplayer-loader-overlay"><div class="wolf-jplayer-loader"></div></div>
					<div class="wolf-jplayer-playlist">
					<div class="wolf-jp-share-overlay">
						<div class="wolf-jp-share-container">
							<div class="wolf-jp-share">
							<div>
								<p><strong>'.LAN_FRONT_17.'</strong></p>
							</div>
							<!--<div class="wolf-share-input">
								<label>url : </label>
								<div>
									<input onclick="this.focus();this.select()" type="text" value="' . $playlisturl . '">
								</div>
							</div>-->
							<div class="wolf-share-input">
								<label>&nbsp;'.LAN_FRONT_21.'</label>
								<div>
								<input onclick="this.focus();this.select()" type="text" value="&lt;iframe width=&quot;100%&quot; height=&quot;' . $player_height . '&quot; scrolling=&quot;no&quot; frameborder=&quot;no&quot; src=&quot;' . $playlisturl . '&amp;iframe=true&amp;wmode=transparent&quot;&gt;&lt;/iframe&gt;">
								</div>
							</div>
							<div class="clear"></div>
							<div class="wolf-jp-share-socials">
								<a class="wolf-share-jp-popup" href="http://www.facebook.com/sharer.php?u=' . $playlisturl . '&t=' . urlencode($share_title) . '" title="' . LAN_FRONT_06 . '" target="_blank">
								<span id="wolf-jplayer-facebook-button"></span>
								</a>
								<a class="wolf-share-jp-popup" href="http://twitter.com/home?status=' . urlencode($share_title . ' - ') . $playlisturl . '" title="' . LAN_FRONT_07 . '" target="_blank">
								<span id="wolf-jplayer-twitter-button"></span>
								</a>
							</div>
							<span class="close-wolf-jp-share" title="' . LAN_FRONT_08 . '">&times;</span>
						</div>
					</div>
				</div>
				<div id="jplayer_container_' . $id . '" class="jplayer_container">
				<div id="jquery_jplayer_' . $id . '" class="jp-jplayer"></div>
					<div id="jp_container_' . $id . '" class="jp-audio">
					<div class="jp-logo" style="' . $logo . '"></div>
					<span title="' . LAN_FRONT_09 . '" class="wolf-jp-menu-icon"></span>';
								if (!$in_popup) $html.= '';
								$html.= '<div class="jp-type-playlist">
					<div class="jp-gui jp-interface">
						<ul class="jp-controls">
							<li><a href="javascript:;" class="jp-previous" tabindex="1" title="'.LAN_FRONT_26.'"></a></li>
							<li><a href="javascript:;" class="jp-play" tabindex="1" title="'.LAN_FRONT_27.'"></a></li>
							<li><a href="javascript:;" class="jp-pause" tabindex="1" title="'.LAN_FRONT_28.'"></a></li>
							<li><a href="javascript:;" class="jp-next" tabindex="1" title="'.LAN_FRONT_29.'"></a></li>
							<li><a href="javascript:;" class="jp-stop" tabindex="1" title="'.LAN_FRONT_30.'"></a></li>
							<li class="wolf-volume">
								<a href="javascript:;" class="jp-mute" tabindex="1" title="'.LAN_FRONT_23.'"></a>
								<a href="javascript:;" class="jp-unmute" tabindex="1" title="'.LAN_FRONT_24.'"></a>
							</li>
							<li><a href="javascript:;" class="jp-volume-max wolf-volume" tabindex="1" title="'.LAN_FRONT_25.'"></a></li>
						</ul>
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
						<div class="jp-volume-bar wolf-volume">
							<div class="jp-volume-bar-value"></div>
						</div>
						<div class="jp-current-time"></div>
						<div class="jp-duration"></div>
						<ul class="jp-toggles">
							<li id="wolf-jp-shuffle">
								<a href="javascript:;" class="jp-shuffle" tabindex="1" title="' . LAN_FRONT_10 . '">
								<a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="' . LAN_FRONT_11 . '"></a>
							</li>
							<li id="wolf-jp-repeat">
								<a href="javascript:;" class="jp-repeat" tabindex="1" title="' . LAN_FRONT_12 . '"></a>
								<a href="javascript:;" class="jp-repeat-off" tabindex="1" title="' . LAN_FRONT_13 . '"></a>
							</li>
							<li id="wolf-jp-share"><span title="' . LAN_FRONT_14 . '" class="wolf-jp-share-icon"></span></li>
							<li id="wolf-jp-popup"><a href="' . $playlisturl . '&amp;iframe=false" class="wolf-jp-popup" title="'.LAN_FRONT_22.'"></a></li>
						</ul>
					</div>

					<div class="jp-playlist">
						<ul>
							<li></li>
						</ul>
					</div>

					<div class="jp-no-solution">
						<span>' . LAN_FRONT_18 . '</span>
						' . LAN_FRONT_19 . '
					</div>

					</div>
				</div>
			</div>
			</div>
			</div>
			<!-- End jPlayer -->';
						else:
								if (USER) $html = '<p style="text-shadow:none!important"><em>' . LAN_FRONT_15 . '</em></p>';
								else $html = '<p style="text-shadow:none!important"><em>' . LAN_FRONT_16 . '</em></p>';
						endif;
						return $html;
				}

				/**
				 * Output jplayer HTML
				 *
				 * @param int $playlist_id
				 * @param bool $in_popup
				 * @param bool $embed
				 * @return string
				 */
				public

				function jplayer_show_single($playlist_id, $in_popup, $embed = false)
				{
						$html = '<div id="wolf-jplayer-single-page">';
						$html.= $this->jplayer_show_playlist($playlist_id, $in_popup, $embed, true);
						$html.= '</div>';
						return $html;
				}

				/**
				 * Output jplayer HTML
				 *
				 * @param int $playlist_id
				 * @param bool $in_popup
				 * @param bool $embed
				 * @return string
				 */
				public

				function jplayer_show_iframe($playlist_id, $in_popup, $embed = false)
				{
						$embed = true;
						$in_popup = false;
						define('e_IFRAME', true);
						
					  require_once (HEADERF);
						$html = $this->jplayer_show_playlist($playlist_id, $in_popup, $embed, true);
						 
						return $html;
				}
		}
}
