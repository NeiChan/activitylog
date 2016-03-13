CREATE TABLE `activitylog_school`.`log_dataTypes` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `titel` char(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;