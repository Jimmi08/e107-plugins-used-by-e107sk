CREATE TABLE uclass_badge (
  `uc_badge_id` int(10) NOT NULL AUTO_INCREMENT,
  `uc_badge_class` int(10) NOT NULL,
  `uc_badge_css` varchar(100) NOT NULL,
  PRIMARY KEY (`uc_badge_id`)
) ENGINE=MyISAM;