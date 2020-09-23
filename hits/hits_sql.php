CREATE TABLE `hits` (
 `hits_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `hits_type` varchar(12) NOT NULL,
 `hits_itemid` int(11) unsigned NOT NULL,
 `hits_counter` int(11) unsigned NOT NULL,
 `hits_unique` int(11) unsigned NOT NULL,
 `hits_lastupdated` int(11) unsigned NOT NULL,
 PRIMARY KEY (`hits_id`),
 UNIQUE KEY `hits_type` (`hits_type`,`hits_itemid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;