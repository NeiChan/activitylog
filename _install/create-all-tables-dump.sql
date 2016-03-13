# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.38-0ubuntu0.12.04.1)
# Database: activitylog_school
# Generation Time: 2016-03-13 01:10:55 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table log_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_categories`;

CREATE TABLE `log_categories` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `titel` char(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `log_categories` WRITE;
/*!40000 ALTER TABLE `log_categories` DISABLE KEYS */;

INSERT INTO `log_categories` (`id`, `titel`, `user_id`)
VALUES
	(2,'Online',14),
	(3,'Offline',14),
	(4,'Transacties',14),
	(5,'Verkeer',14),
	(6,'Vervoer',14);

/*!40000 ALTER TABLE `log_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table log_companies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_companies`;

CREATE TABLE `log_companies` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `titel` char(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `log_companies` WRITE;
/*!40000 ALTER TABLE `log_companies` DISABLE KEYS */;

INSERT INTO `log_companies` (`id`, `titel`, `user_id`)
VALUES
	(5,'Albert Heijn',14),
	(6,'Translink',14),
	(7,'Café/Restaurant',14),
	(8,'Gemeente',14),
	(9,'Overheid',14),
	(10,'Facebook',14),
	(11,'Belastingdienst',14),
	(12,'HTM',14),
	(13,'NS',14),
	(14,'ABN AMRO',14),
	(15,'RET',14),
	(16,'Politie',14);

/*!40000 ALTER TABLE `log_companies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table log_dataTypes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_dataTypes`;

CREATE TABLE `log_dataTypes` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `titel` char(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `log_dataTypes` WRITE;
/*!40000 ALTER TABLE `log_dataTypes` DISABLE KEYS */;

INSERT INTO `log_dataTypes` (`id`, `titel`, `user_id`)
VALUES
	(3,'NAW gegevens',14),
	(4,'Locatie',14),
	(5,'Bank gegevens',14),
	(6,'Auto gegevens',14),
	(7,'Account gegevens',14);

/*!40000 ALTER TABLE `log_dataTypes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table log_locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_locations`;

CREATE TABLE `log_locations` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_locations_companies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_locations_companies`;

CREATE TABLE `log_locations_companies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(255) DEFAULT NULL,
  `location_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_locations_datatypes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_locations_datatypes`;

CREATE TABLE `log_locations_datatypes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datatype_id` int(255) DEFAULT NULL,
  `location_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_users`;

CREATE TABLE `log_users` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `email` char(255) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `log_users` WRITE;
/*!40000 ALTER TABLE `log_users` DISABLE KEYS */;

INSERT INTO `log_users` (`id`, `email`, `createdAt`)
VALUES
	(14,'0887267@hr.nl','2016-03-10 22:01:30'),
	(15,'wesleylgr33@gmail.com','2016-03-10 22:38:34');

/*!40000 ALTER TABLE `log_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
