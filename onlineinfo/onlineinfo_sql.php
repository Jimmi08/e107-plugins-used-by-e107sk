CREATE TABLE IF NOT EXISTS onlineinfo_friends (
  amigo_id int(10) unsigned NOT NULL auto_increment,
  amigo_user int(10) unsigned NOT NULL,
  amigo_amigo int(10) unsigned NOT NULL,
  PRIMARY KEY  (amigo_id)
) TYPE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS onlineinfo_cache (
  type varchar(50) NOT NULL default '',
  cache_name varchar(100) NOT NULL default '',
  cache text NOT NULL,
  cache_hide tinyint(1) NOT NULL default '0',
  cache_records int(11) NOT NULL default '0',
  cache_userclass int(10) NOT NULL default '0',
  cache_timestamp int(10) NOT NULL default '0',
  cache_active tinyint(1) NOT NULL default '0',
  type_order int(11) NOT NULL default '0',
  PRIMARY KEY  (type,cache_name,type_order)
) TYPE=MyISAM;

 
CREATE TABLE IF NOT EXISTS onlineinfo_suspend (
user_id INT(11) NOT NULL ,
user_name varchar(100) NOT NULL default '',
ip varchar(20) NOT NULL default '',
PRIMARY KEY (user_id)
) TYPE=MyISAM; 

CREATE TABLE IF NOT EXISTS onlineinfo_read (
  user_id int(10) NOT NULL default '0',
  news text NOT NULL,
  chatbox text NOT NULL,
  comments text NOT NULL,
  contents text NOT NULL,
  downloads text NOT NULL,
  guestbook text NOT NULL,
  pictures text NOT NULL,
  movies text NOT NULL,
  links text NOT NULL,
  sitemembers text NOT NULL,
  games text NOT NULL,
  game_top text NOT NULL,
  gallery text NOT NULL,
  ibf text NOT NULL,
  smf text NOT NULL,
  bug text NOT NULL,
  chatbox2 text NOT NULL,
  copper text NOT NULL,
  jokes text NOT NULL,
  blogs text NOT NULL,
  suggestions text NOT NULL,
  PRIMARY KEY  (user_id)
) TYPE=MyISAM;