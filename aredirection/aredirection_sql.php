CREATE TABLE IF NOT EXISTS `redirection_items` (
	`redirection_id`   				INT(11) NOT NULL AUTO_INCREMENT,
	`redirection_url`  				VARCHAR(254) NOT NULL DEFAULT '',
	`redirection_newurl`  		VARCHAR(254) NOT NULL DEFAULT '',
	`redirection_note` 				VARCHAR(254) NOT NULL DEFAULT '',  
	`redirection_status`   	  INT(1) NOT NULL DEFAULT '0',  
	PRIMARY KEY (`redirection_id`),
	KEY `redirection_url` (`redirection_url`(191)) 
) ENGINE=MyISAM;
 