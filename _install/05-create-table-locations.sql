CREATE TABLE `activitylog_school`.`log_locations` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `titel` char(255) DEFAULT NULL,
  `description` text,
  `l_date` char(255) DEFAULT NULL,
  `l_time` char(255) DEFAULT NULL,
  `l_lat` char(255) DEFAULT NULL,
  `l_long` char(255) DEFAULT NULL,
  `user_id` int(255) NOT NULL,
  `category_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;