CREATE TABLE survey (
`survey_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`survey_name` varchar(128) NOT NULL DEFAULT '',
`survey_class` tinyint(3) unsigned NOT NULL DEFAULT '0',
`survey_once` tinyint(1) unsigned NOT NULL DEFAULT '0',
`survey_viewclass` tinyint(3) unsigned NOT NULL DEFAULT '0',
`survey_editclass` tinyint(3) unsigned NOT NULL DEFAULT '0',
`survey_mailto` varchar(255) NOT NULL DEFAULT '',
`survey_forum` int(10) unsigned NOT NULL DEFAULT '0',
`survey_save_results` tinyint(1) unsigned NOT NULL DEFAULT '0',
`survey_user` text NOT NULL,
`survey_parms` text NOT NULL,
`survey_message` text NOT NULL,
`survey_submit_message` text NOT NULL,
`survey_lastfnum` int(10) unsigned NOT NULL DEFAULT '0',
`survey_url` varchar(255) NOT NULL DEFAULT '',
`survey_template` varchar(255) NOT NULL DEFAULT '',
`survey_message1` text NOT NULL,
`survey_message2` text NOT NULL,
`survey_slogan` text NOT NULL,
PRIMARY KEY (`survey_id`)
) ENGINE=MyISAM;

CREATE TABLE survey_results (
`results_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`results_datestamp` int(10) unsigned NOT NULL DEFAULT '0',
`results_survey_id` int(10) unsigned NOT NULL DEFAULT '0',
`results_results` text,
PRIMARY KEY (`results_id`)
) ENGINE=MyISAM;

