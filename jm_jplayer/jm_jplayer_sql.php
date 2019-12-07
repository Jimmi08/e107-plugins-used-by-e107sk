CREATE TABLE `jm_jplayer` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mp3` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `artist` varchar(255) NOT NULL default '',
  `poster` varchar(255) NOT NULL default '',
  `free` varchar(45) NOT NULL default '',
  `external` int(11) NOT NULL DEFAULT '0',
  `itunes` varchar(255) NOT NULL default '',
  `amazon` varchar(255) NOT NULL default '',
  `buy` varchar(255) NOT NULL default '',
  `position` int(11) NOT NULL DEFAULT '0',
  `playlist_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM;


CREATE TABLE `jm_jplayer_playlists` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL default '',
  `logo` varchar(255) NOT NULL default '',
  `autoplay` varchar(20) DEFAULT '0',
  `poster` varchar(255) NOT NULL default '',  
  PRIMARY KEY  (id)
) ENGINE=MyISAM;
