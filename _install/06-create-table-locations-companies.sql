CREATE TABLE `activitylog_school`.`log_locations_companies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(255) DEFAULT NULL,
  `location_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;