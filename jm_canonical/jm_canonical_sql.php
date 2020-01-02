CREATE TABLE canonical_urls (
	`canonical_id`   INT(11) NOT NULL AUTO_INCREMENT,
	`canonical_url`  VARCHAR(254) NOT NULL DEFAULT '',
	`canonical_note` VARCHAR(254) NOT NULL DEFAULT '',
  `canonical_title` VARCHAR(250) NOT NULL DEFAULT '',	
	PRIMARY KEY (`canonical_id`)
) ENGINE=MyISAM;


CREATE TABLE canonical_request_urls (
	`canru_id`   INT(11) NOT NULL AUTO_INCREMENT,
	`canru_url`  VARCHAR(254) NOT NULL DEFAULT '',
	`canonical_id`   INT(11) NOT NULL DEFAULT '0',
	`canru_note` VARCHAR(254) NOT NULL DEFAULT '',  
	`canru_redirect`   INT(1) NOT NULL DEFAULT '0',  
	PRIMARY KEY (`canru_id`)
) ENGINE=MyISAM;


CREATE TABLE canonical (
  `can_id` int(10) unsigned NOT NULL AUTO_INCREMENT, 
  `can_table` varchar(50) NOT NULL DEFAULT '',
  `can_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `can_title` varchar(250) NOT NULL DEFAULT '',
  `can_url` varchar(250) NOT NULL DEFAULT '', 
	`can_redirect`   INT(1) NOT NULL DEFAULT '0',
   PRIMARY KEY  (`can_id`),
   KEY `can_pid` (`can_pid`)
) ENGINE=MyISAM;
