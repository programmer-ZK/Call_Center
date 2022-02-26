/*
SQLyog Ultimate - MySQL GUI v8.2 
MySQL - 5.6.16 : Database - zong_radio
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zong_radio` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `zong_radio`;

/*Table structure for table `hourly_usage_report` */

DROP TABLE IF EXISTS `hourly_usage_report`;

CREATE TABLE `hourly_usage_report` (
  `hu_id` int(11) NOT NULL AUTO_INCREMENT,
  `hour` varchar(255) DEFAULT '0',
  `mous` varchar(255) DEFAULT '0',
  `created` date DEFAULT NULL,
  PRIMARY KEY (`hu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `hourly_usage_report` */

/*Table structure for table `ivr_revenue` */

DROP TABLE IF EXISTS `ivr_revenue`;

CREATE TABLE `ivr_revenue` (
  `ivr_revenue_id` int(11) NOT NULL AUTO_INCREMENT,
  `total_calls` varchar(255) DEFAULT '0',
  `total_mous` varchar(255) DEFAULT '0',
  `avg_duration` varchar(255) DEFAULT '0',
  `unique_callers` varchar(255) DEFAULT '0',
  `revenue` varchar(255) DEFAULT '0',
  `created` date DEFAULT NULL,
  PRIMARY KEY (`ivr_revenue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ivr_revenue` */

/*Table structure for table `obd_report` */

DROP TABLE IF EXISTS `obd_report`;

CREATE TABLE `obd_report` (
  `obd_report_id` int(11) NOT NULL AUTO_INCREMENT,
  `total_calls` varchar(255) DEFAULT '0',
  `answered_calls` varchar(255) DEFAULT '0',
  `total_sub_requests` varchar(255) DEFAULT '0',
  `created` date DEFAULT NULL,
  PRIMARY KEY (`obd_report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `obd_report` */

/*Table structure for table `radio_daily_report` */

DROP TABLE IF EXISTS `radio_daily_report`;

CREATE TABLE `radio_daily_report` (
  `du_id` int(11) NOT NULL AUTO_INCREMENT,
  `fm100_mous` varchar(0) DEFAULT NULL,
  `fm91_mous` varchar(0) DEFAULT NULL,
  `created` date DEFAULT NULL,
  PRIMARY KEY (`du_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `radio_daily_report` */

/*Table structure for table `subscription_revenue` */

DROP TABLE IF EXISTS `subscription_revenue`;

CREATE TABLE `subscription_revenue` (
  `sub_revenue_id` int(11) NOT NULL AUTO_INCREMENT,
  `active_subscribers` varchar(255) DEFAULT '0',
  `new_sub` varchar(255) DEFAULT '0',
  `new_charged_sub` varchar(255) DEFAULT '0',
  `out_of_grace_charged_sub` varchar(255) DEFAULT '0',
  `charged_renewal` varchar(255) DEFAULT '0',
  `out_of_grace_renewal` varchar(255) DEFAULT '0',
  `total_charged` varchar(255) DEFAULT '0',
  `revenue` varchar(255) DEFAULT '0',
  `unsub` varchar(255) DEFAULT '0',
  `failed_sub` varchar(255) DEFAULT '0',
  `failed_removed` varchar(255) DEFAULT '0',
  `low_balance_sub` varchar(255) DEFAULT '0',
  `created` date DEFAULT NULL,
  PRIMARY KEY (`sub_revenue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `subscription_revenue` */

/*Table structure for table `tv_dailly_usage_report` */

DROP TABLE IF EXISTS `tv_dailly_usage_report`;

CREATE TABLE `tv_dailly_usage_report` (
  `du_id` int(11) NOT NULL AUTO_INCREMENT,
  `8xm_mous` varchar(255) DEFAULT '0',
  `aaj_mous` varchar(255) DEFAULT '0',
  `apna_mous` varchar(255) DEFAULT '0',
  `dawn_mous` varchar(255) DEFAULT '0',
  `express_mous` varchar(255) DEFAULT '0',
  `news_one_mous` varchar(255) DEFAULT '0',
  `play_tv_mous` varchar(255) DEFAULT '0',
  `tv_one_mouse` varchar(255) DEFAULT '0',
  `created` date DEFAULT NULL,
  PRIMARY KEY (`du_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tv_dailly_usage_report` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
