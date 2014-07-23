# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.27)
# Database: simple_secure_login
# Generation Time: 2013-02-03 21:31:33 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table members
# ------------------------------------------------------------

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(128) DEFAULT NULL,
  `lastname` varchar(128) DEFAULT NULL,
  `username` varchar(42) NOT NULL DEFAULT '',
  `password` varchar(52) NOT NULL DEFAULT '',
  `is_admin` int(11) NOT NULL DEFAULT '0',
  `email` varchar(128) NOT NULL DEFAULT '',
  `user_group` int(1) DEFAULT '0' COMMENT '0=member;1=sales;2=delivery;',
  `forgot_hash` varchar(128) DEFAULT NULL,
  `redirect` varchar(128) NOT NULL DEFAULT 'protected.php',
  `status` int(11) DEFAULT '0' COMMENT '0=awaiting activation;1=activated;2=moderator;3=admin;4=banned;',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;

INSERT INTO `members` (`id`, `firstname`, `lastname`, `username`, `password`, `is_admin`, `email`, `user_group`, `forgot_hash`, `redirect`, `status`)
VALUES
	(1,'John','Crossley','admin','4352438e244d99d1e16bcc21b9ed9347807ed6b7',1,'hello@phpcodemonkey.com',0,NULL,'protected.php',3);

/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `allow_registration` int(1) DEFAULT '1',
  `paypal_email` varchar(128) DEFAULT 'john@suburbanarctic.com',
  `redirect_location` varchar(128) DEFAULT 'protected.php',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `allow_registration`, `paypal_email`, `redirect_location`)
VALUES
	(1,1,'john@suburbanarctic.com','protected.php');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
