CREATE TABLE `jmcontactus_messages` (
  `id` int(10) UNSIGNED NOT NULL  auto_increment,
  `msg` text NOT NULL,
  `date` int(25) NOT NULL,
  `ip` varchar(50) NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `jmcontactus_info` (
  `id` int(10) UNSIGNED NOT NULL  auto_increment,
  `title` varchar(255) NOT NULL DEFAULT '',
  `info` text NOT NULL,
  `googlemap` varchar(255) NOT NULL DEFAULT '',
  `googlemap_zoom` int(11) NOT NULL DEFAULT '15',
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE `jmcontactus_form` (
  `id` int(10) UNSIGNED NOT NULL  auto_increment,
  `name` varchar(255) NOT NULL DEFAULT '',
  `req` int(1) NOT NULL,
  `type` varchar(25) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `order` int(11) NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;