CREATE TABLE yandex_turbopages (
	`tb_id` INT(11) NOT NULL AUTO_INCREMENT,
	`entity_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`entity_type` varchar(50) NOT NULL DEFAULT '',
  `tb_include` int(1) unsigned NOT NULL DEFAULT '0',
KEY `tb_id` (`tb_id`),
KEY `entity_id` (`entity_id`),
KEY `entity_type` (`entity_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
  