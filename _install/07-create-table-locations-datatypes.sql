CREATE TABLE `activitylog_school`.`log_locations_datatypes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datatype_id` int(255) DEFAULT NULL,
  `location_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;