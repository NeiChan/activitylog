CREATE TABLE `activitylog_school`.`log_companies` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `titel` char(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;