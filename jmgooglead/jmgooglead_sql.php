CREATE TABLE jmgooglead (
`googlead_id` int(10) NOT NULL AUTO_INCREMENT,
`googlead_name` varchar(255) NOT NULL,
`googlead_gaid` int(15) NOT NULL,
`googlead_code` text NOT NULL,
`googlead_note` varchar(255) NOT NULL,
`googlead_active` int(10) NOT NULL,
`googlead_class` varchar(255) NOT NULL default '0',
PRIMARY KEY (`googlead_id`)
) ENGINE=InnoDB;