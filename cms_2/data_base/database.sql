/*
SQLyog Ultimate - MySQL GUI v8.2 
MySQL - 5.6.16 : Database - osticket
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`osticket` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `osticket`;

/*Table structure for table `ost__search` */

DROP TABLE IF EXISTS `ost__search`;

CREATE TABLE `ost__search` (
  `object_type` varchar(8) NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  `title` text,
  `content` text,
  PRIMARY KEY (`object_type`,`object_id`),
  FULLTEXT KEY `search` (`title`,`content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost__search` */

insert  into `ost__search`(`object_type`,`object_id`,`title`,`content`) values ('H',1,'osTicket Installed!','Thank you for choosing osTicket. Please make sure you join the osTicket forums and our mailing list to stay up to date on the latest news, security alerts and updates. The osTicket forums are also a great place to get assistance, guidance, tips, and help from other osTicket users. In addition to the forums, the osTicket wiki provides a useful collection of educational materials, documentation, and notes from the community. We welcome your contributions to the osTicket community. If you are looking for a greater level of support, we provide professional services and commercial support with guaranteed response times, and access to the core development team. We can also help customize osTicket or even add new features to the system to meet your unique needs. If the idea of managing and upgrading this osTicket installation is daunting, you can try osTicket as a hosted service at http://www.supportsystem.com/ -- no installation required and we can import your data! With SupportSystem\'s turnkey infrastructure, you get osTicket at its best, leaving you free to focus on your customers without the burden of making sure the application is stable, maintained, and secure. Cheers, - osTicket Team http://osticket.com/ PS. Don\'t just make customers happy, make happy customers!'),('H',2,'test subject aka Issue Summary','test ticket body, aka Issue Details'),('H',3,'test subject aka Issue Summary','test ticket body, aka Issue Details'),('H',4,'test subject aka Issue Summary','test ticket body, aka Issue Details'),('H',6,'test subject aka Issue Summary','test ticket body, aka Issue Details'),('O',1,'osTicket','420 Desoto Street\nAlexandria, LA 71301\n(318) 290-3674\nhttp://osticket.com\nNot only do we develop the software, we also use it to manage support for osTicket. Let us help you quickly implement and leverage the full potential of osTicket\'s features and functionality. Contact us for professional support or visit our website for documentation and community support.'),('T',1,'200787 osTicket Installed!',''),('T',2,'789251 test subject aka Issue Summary','test subject aka Issue Summary'),('T',3,'153823 test subject aka Issue Summary','test subject aka Issue Summary\n01/01/1970'),('T',4,'882134 test subject aka Issue Summary','test subject aka Issue Summary\n01/01/1970'),('T',5,'394452 test subject aka Issue Summary','test subject aka Issue Summary'),('U',1,'osTicket Support','support@osticket.com'),('U',2,'Hafeez',''),('U',3,'Hyder',''),('U',4,'Junaid',''),('U',5,'Junaid',''),('U',6,'hameed','');

/*Table structure for table `ost_api_key` */

DROP TABLE IF EXISTS `ost_api_key`;

CREATE TABLE `ost_api_key` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `ipaddr` varchar(64) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  `can_create_tickets` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `can_exec_cron` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `notes` text,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apikey` (`apikey`),
  KEY `ipaddr` (`ipaddr`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ost_api_key` */

insert  into `ost_api_key`(`id`,`isactive`,`ipaddr`,`apikey`,`can_create_tickets`,`can_exec_cron`,`notes`,`updated`,`created`) values (1,1,'127.0.0.1','73D26BD41B7377DD0F721091A283D822',1,1,'this is just for testing purpose','2015-10-13 11:14:06','2015-10-13 11:14:06'),(2,1,'::1','1F942DABB09E790C3B4732CC207A4E9D',1,1,'','2015-10-13 13:14:42','2015-10-13 13:14:42');

/*Table structure for table `ost_attachment` */

DROP TABLE IF EXISTS `ost_attachment`;

CREATE TABLE `ost_attachment` (
  `object_id` int(11) unsigned NOT NULL,
  `type` char(1) NOT NULL,
  `file_id` int(11) unsigned NOT NULL,
  `inline` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`file_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_attachment` */

insert  into `ost_attachment`(`object_id`,`type`,`file_id`,`inline`) values (1,'C',2,0),(8,'T',1,1),(9,'T',1,1),(10,'T',1,1),(11,'T',1,1),(12,'T',1,1),(13,'T',1,1);

/*Table structure for table `ost_canned_response` */

DROP TABLE IF EXISTS `ost_canned_response`;

CREATE TABLE `ost_canned_response` (
  `canned_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `isenabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL DEFAULT '',
  `response` text NOT NULL,
  `lang` varchar(16) NOT NULL DEFAULT 'en_US',
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`canned_id`),
  UNIQUE KEY `title` (`title`),
  KEY `dept_id` (`dept_id`),
  KEY `active` (`isenabled`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ost_canned_response` */

insert  into `ost_canned_response`(`canned_id`,`dept_id`,`isenabled`,`title`,`response`,`lang`,`notes`,`created`,`updated`) values (1,0,1,'What is osTicket (sample)?','osTicket is a widely-used open source support ticket system, an attractive alternative to higher-cost and complex customer support systems - simple, lightweight, reliable, open source, web-based and easy to setup and use.','en_US','','2015-10-12 13:33:50','2015-10-12 13:33:50'),(2,0,1,'Sample (with variables)','Hi %{ticket.name.first}, <br /><br /> Your ticket #%{ticket.number} created on %{ticket.create_date} is in %{ticket.dept.name} department.','en_US','','2015-10-12 13:33:51','2015-10-12 13:33:51');

/*Table structure for table `ost_config` */

DROP TABLE IF EXISTS `ost_config`;

CREATE TABLE `ost_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `namespace` varchar(64) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `namespace` (`namespace`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

/*Data for the table `ost_config` */

insert  into `ost_config`(`id`,`namespace`,`key`,`value`,`updated`) values (1,'core','admin_email','hafeezullah.msc@gmail.com','2015-10-12 13:33:55'),(2,'core','helpdesk_url','http://localhost/osticket/','2015-10-12 13:33:55'),(3,'core','helpdesk_title','OS TICKET','2015-10-12 13:33:55'),(4,'core','schema_signature','b26f29a6bb5dbb3510b057632182d138','2015-10-12 13:33:55'),(5,'dept.1','assign_members_only','','2015-10-12 13:33:40'),(6,'dept.2','assign_members_only','','2015-10-12 13:33:40'),(7,'dept.3','assign_members_only','','2015-10-12 13:33:40'),(8,'sla.1','transient','0','2015-10-12 13:33:41'),(9,'list.1','configuration','{\"handler\":\"TicketStatusList\"}','2015-10-12 13:33:43'),(10,'core','time_format','h:i A','2015-10-12 13:33:46'),(11,'core','date_format','m/d/Y','2015-10-12 13:33:46'),(12,'core','datetime_format','m/d/Y g:i a','2015-10-12 13:33:46'),(13,'core','daydatetime_format','D, M j Y g:ia','2015-10-12 13:33:46'),(14,'core','default_timezone_id','21','2015-10-12 14:03:22'),(15,'core','default_priority_id','2','2015-10-12 13:33:47'),(16,'core','enable_daylight_saving','0','2015-10-12 13:33:47'),(17,'core','reply_separator','-- reply above this line --','2015-10-12 13:33:47'),(18,'core','isonline','1','2015-10-12 13:33:47'),(19,'core','staff_ip_binding','0','2015-10-12 13:33:47'),(20,'core','staff_max_logins','4','2015-10-12 13:33:47'),(21,'core','staff_login_timeout','2','2015-10-12 13:33:47'),(22,'core','staff_session_timeout','30','2015-10-12 13:33:47'),(23,'core','passwd_reset_period','0','2015-10-12 13:33:47'),(24,'core','client_max_logins','4','2015-10-12 13:33:47'),(25,'core','client_login_timeout','2','2015-10-12 13:33:47'),(26,'core','client_session_timeout','30','2015-10-12 13:33:47'),(27,'core','max_page_size','25','2015-10-12 13:33:47'),(28,'core','max_open_tickets','0','2015-10-12 13:33:47'),(29,'core','autolock_minutes','3','2015-10-12 13:33:47'),(30,'core','default_smtp_id','0','2015-10-12 13:33:47'),(31,'core','use_email_priority','0','2015-10-12 13:33:47'),(32,'core','enable_kb','0','2015-10-12 13:33:47'),(33,'core','enable_premade','1','2015-10-12 13:33:47'),(34,'core','enable_captcha','0','2015-10-12 13:33:47'),(35,'core','enable_auto_cron','0','2015-10-12 13:33:47'),(36,'core','enable_mail_polling','0','2015-10-12 13:33:47'),(37,'core','send_sys_errors','1','2015-10-12 13:33:47'),(38,'core','send_sql_errors','1','2015-10-12 13:33:47'),(39,'core','send_login_errors','1','2015-10-12 13:33:47'),(40,'core','save_email_headers','1','2015-10-12 13:33:48'),(41,'core','strip_quoted_reply','1','2015-10-12 13:33:48'),(42,'core','ticket_autoresponder','0','2015-10-12 13:33:48'),(43,'core','message_autoresponder','0','2015-10-12 13:33:48'),(44,'core','ticket_notice_active','1','2015-10-12 13:33:48'),(45,'core','ticket_alert_active','1','2015-10-12 13:33:48'),(46,'core','ticket_alert_admin','1','2015-10-12 13:33:48'),(47,'core','ticket_alert_dept_manager','1','2015-10-12 13:33:48'),(48,'core','ticket_alert_dept_members','0','2015-10-12 13:33:48'),(49,'core','message_alert_active','1','2015-10-12 13:33:48'),(50,'core','message_alert_laststaff','1','2015-10-12 13:33:48'),(51,'core','message_alert_assigned','1','2015-10-12 13:33:48'),(52,'core','message_alert_dept_manager','0','2015-10-12 13:33:48'),(53,'core','note_alert_active','0','2015-10-12 13:33:48'),(54,'core','note_alert_laststaff','1','2015-10-12 13:33:48'),(55,'core','note_alert_assigned','1','2015-10-12 13:33:48'),(56,'core','note_alert_dept_manager','0','2015-10-12 13:33:48'),(57,'core','transfer_alert_active','0','2015-10-12 13:33:48'),(58,'core','transfer_alert_assigned','0','2015-10-12 13:33:48'),(59,'core','transfer_alert_dept_manager','1','2015-10-12 13:33:48'),(60,'core','transfer_alert_dept_members','0','2015-10-12 13:33:48'),(61,'core','overdue_alert_active','1','2015-10-12 13:33:48'),(62,'core','overdue_alert_assigned','1','2015-10-12 13:33:48'),(63,'core','overdue_alert_dept_manager','1','2015-10-12 13:33:48'),(64,'core','overdue_alert_dept_members','0','2015-10-12 13:33:48'),(65,'core','assigned_alert_active','1','2015-10-12 13:33:49'),(66,'core','assigned_alert_staff','1','2015-10-12 13:33:49'),(67,'core','assigned_alert_team_lead','0','2015-10-12 13:33:49'),(68,'core','assigned_alert_team_members','0','2015-10-12 13:33:49'),(69,'core','auto_claim_tickets','1','2015-10-12 13:33:49'),(70,'core','show_related_tickets','1','2015-10-12 13:33:49'),(71,'core','show_assigned_tickets','1','2015-10-12 13:33:49'),(72,'core','show_answered_tickets','0','2015-10-12 13:33:49'),(73,'core','hide_staff_name','0','2015-10-12 13:33:49'),(74,'core','overlimit_notice_active','0','2015-10-12 13:33:49'),(75,'core','email_attachments','1','2015-10-12 13:33:49'),(76,'core','number_format','######','2015-10-12 13:33:49'),(77,'core','sequence_id','0','2015-10-12 13:33:49'),(78,'core','log_level','2','2015-10-12 13:33:49'),(79,'core','log_graceperiod','12','2015-10-12 13:33:49'),(80,'core','client_registration','public','2015-10-12 13:33:49'),(81,'core','max_file_size','1048576','2015-10-12 13:33:49'),(82,'core','landing_page_id','1','2015-10-12 13:33:49'),(83,'core','thank-you_page_id','2','2015-10-12 13:33:49'),(84,'core','offline_page_id','3','2015-10-12 13:33:49'),(85,'core','system_language','en_US','2015-10-12 13:33:50'),(86,'mysqlsearch','reindex','0','2015-10-12 14:03:23'),(87,'core','default_email_id','1','2015-10-12 13:33:55'),(88,'core','alert_email_id','2','2015-10-12 13:33:55'),(89,'core','default_dept_id','1','2015-10-12 13:33:55'),(90,'core','default_sla_id','1','2015-10-12 13:33:55'),(91,'core','default_template_id','1','2015-10-12 13:33:55'),(92,'core','name_format','full','2015-10-12 14:03:22'),(93,'pwreset','JR9ngOwcYBxXL1a=Id80nmSsjpCrHbgBZFjPtv8i2Aqsf8v5','5','2015-10-13 18:52:22'),(94,'pwreset','n_04wbq4P2sARn0VFaMl9HEDlbo4IlHXKGW5bSXdxtV0GpZ4','6','2015-10-13 19:08:04');

/*Table structure for table `ost_content` */

DROP TABLE IF EXISTS `ost_content`;

CREATE TABLE `ost_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL DEFAULT '0',
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` varchar(32) NOT NULL DEFAULT 'other',
  `name` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `lang` varchar(16) NOT NULL DEFAULT 'en_US',
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `ost_content` */

insert  into `ost_content`(`id`,`content_id`,`isactive`,`type`,`name`,`body`,`lang`,`notes`,`created`,`updated`) values (1,1,1,'landing','Landing','<h1>Welcome to the Support Center</h1> <p> In order to streamline support requests and better serve you, we utilize a support ticket system. Every support request is assigned a unique ticket number which you can use to track the progress and responses online. For your reference we provide complete archives and history of all your support requests. A valid email address is required to submit a ticket. </p>','en_US','The Landing Page refers to the content of the Customer Portal\'s initial view. The template modifies the content seen above the two links <strong>Open a New Ticket</strong> and <strong>Check Ticket Status</strong>.','2015-10-12 13:33:49','2015-10-12 13:33:49'),(2,2,1,'thank-you','Thank You','<div>%{ticket.name},\n<br>\n<br>\nThank you for contacting us.\n<br>\n<br>\nA support ticket request has been created and a representative will be\ngetting back to you shortly if necessary.</p>\n<br>\n<br>\nSupport Team\n</div>','en_US','This template defines the content displayed on the Thank-You page after a\nClient submits a new ticket in the Client Portal.','2015-10-12 13:33:49','2015-10-12 13:33:49'),(3,3,1,'offline','Offline','<div><h1>\n<span style=\"font-size: medium\">Support Ticket System Offline</span>\n</h1>\n<p>Thank you for your interest in contacting us.</p>\n<p>Our helpdesk is offline at the moment, please check back at a later\ntime.</p>\n</div>','en_US','The Offline Page appears in the Customer Portal when the Help Desk is offline.','2015-10-12 13:33:49','2015-10-12 13:33:49'),(4,4,1,'registration-staff','Welcome to osTicket','<h3><strong>Hi %{recipient.name.first},</strong></h3> <div> We\'ve created an account for you at our help desk at %{url}.<br /> <br /> Please follow the link below to confirm your account and gain access to your tickets.<br /> <br /> <a href=\"%{link}\">%{link}</a><br /> <br /> <em style=\"font-size: small\">Your friendly Customer Support System<br /> %{company.name}</em> </div>','en_US','This template defines the initial email (optional) sent to Agents when an account is created on their behalf.','2015-10-12 13:33:50','2015-10-12 13:33:50'),(5,5,1,'pwreset-staff','osTicket Staff Password Reset','<h3><strong>Hi %{staff.name.first},</strong></h3> <div> A password reset request has been submitted on your behalf for the helpdesk at %{url}.<br /> <br /> If you feel that this has been done in error, delete and disregard this email. Your account is still secure and no one has been given access to it. It is not locked and your password has not been reset. Someone could have mistakenly entered your email address.<br /> <br /> Follow the link below to login to the help desk and change your password.<br /> <br /> <a href=\"%{link}\">%{link}</a><br /> <br /> <em style=\"font-size: small\">Your friendly Customer Support System</em> <br /> <img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" alt=\"Powered by osTicket\" width=\"126\" height=\"19\" style=\"width: 126px\" /> </div>','en_US','This template defines the email sent to Staff who select the <strong>Forgot My Password</strong> link on the Staff Control Panel Log In page.','2015-10-12 13:33:50','2015-10-12 13:33:50'),(6,6,1,'banner-staff','Authentication Required','','en_US','This is the initial message and banner shown on the Staff Log In page. The first input field refers to the red-formatted text that appears at the top. The latter textarea is for the banner content which should serve as a disclaimer.','2015-10-12 13:33:50','2015-10-12 13:33:50'),(7,7,1,'registration-client','Welcome to %{company.name}','<h3><strong>Hi %{recipient.name.first},</strong></h3> <div> We\'ve created an account for you at our help desk at %{url}.<br /> <br /> Please follow the link below to confirm your account and gain access to your tickets.<br /> <br /> <a href=\"%{link}\">%{link}</a><br /> <br /> <em style=\"font-size: small\">Your friendly Customer Support System <br /> %{company.name}</em> </div>','en_US','This template defines the email sent to Clients when their account has been created in the Client Portal or by an Agent on their behalf. This email serves as an email address verification. Please use %{link} somewhere in the body.','2015-10-12 13:33:50','2015-10-12 13:33:50'),(8,8,1,'pwreset-client','%{company.name} Help Desk Access','<h3><strong>Hi %{user.name.first},</strong></h3> <div> A password reset request has been submitted on your behalf for the helpdesk at %{url}.<br /> <br /> If you feel that this has been done in error, delete and disregard this email. Your account is still secure and no one has been given access to it. It is not locked and your password has not been reset. Someone could have mistakenly entered your email address.<br /> <br /> Follow the link below to login to the help desk and change your password.<br /> <br /> <a href=\"%{link}\">%{link}</a><br /> <br /> <em style=\"font-size: small\">Your friendly Customer Support System <br /> %{company.name}</em> </div>','en_US','This template defines the email sent to Clients who select the <strong>Forgot My Password</strong> link on the Client Log In page.','2015-10-12 13:33:50','2015-10-12 13:33:50'),(9,9,1,'banner-client','Sign in to %{company.name}','To better serve you, we encourage our Clients to register for an account.','en_US','This composes the header on the Client Log In page. It can be useful to inform your Clients about your log in and registration policies.','2015-10-12 13:33:50','2015-10-12 13:33:50'),(10,10,1,'registration-confirm','Account registration','<div><strong>Thanks for registering for an account.</strong><br/> <br /> We\'ve just sent you an email to the address you entered. Please follow the link in the email to confirm your account and gain access to your tickets. </div>','en_US','This templates defines the page shown to Clients after completing the registration form. The template should mention that the system is sending them an email confirmation link and what is the next step in the registration process.','2015-10-12 13:33:50','2015-10-12 13:33:50'),(11,11,1,'registration-thanks','Account Confirmed!','<div> <strong>Thanks for registering for an account.</strong><br /> <br /> You\'ve confirmed your email address and successfully activated your account. You may proceed to open a new ticket or manage existing tickets.<br /> <br /> <em>Your friendly support center</em><br /> %{company.name} </div>','en_US','This template defines the content displayed after Clients successfully register by confirming their account. This page should inform the user that registration is complete and that the Client can now submit a ticket or access existing tickets.','2015-10-12 13:33:50','2015-10-12 13:33:50'),(12,12,1,'access-link','Ticket [#%{ticket.number}] Access Link','<h3><strong>Hi %{recipient.name.first},</strong></h3> <div> An access link request for ticket #%{ticket.number} has been submitted on your behalf for the helpdesk at %{url}.<br /> <br /> Follow the link below to check the status of the ticket #%{ticket.number}.<br /> <br /> <a href=\"%{recipient.ticket_link}\">%{recipient.ticket_link}</a><br /> <br /> If you <strong>did not</strong> make the request, please delete and disregard this email. Your account is still secure and no one has been given access to the ticket. Someone could have mistakenly entered your email address.<br /> <br /> --<br /> %{company.name} </div>','en_US','This template defines the notification for Clients that an access link was sent to their email. The ticket number and email address trigger the access link.','2015-10-12 13:33:50','2015-10-12 13:33:50');

/*Table structure for table `ost_department` */

DROP TABLE IF EXISTS `ost_department`;

CREATE TABLE `ost_department` (
  `dept_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tpl_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sla_id` int(10) unsigned NOT NULL DEFAULT '0',
  `email_id` int(10) unsigned NOT NULL DEFAULT '0',
  `autoresp_email_id` int(10) unsigned NOT NULL DEFAULT '0',
  `manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dept_name` varchar(128) NOT NULL DEFAULT '',
  `dept_signature` text NOT NULL,
  `ispublic` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `group_membership` tinyint(1) NOT NULL DEFAULT '0',
  `ticket_auto_response` tinyint(1) NOT NULL DEFAULT '1',
  `message_auto_response` tinyint(1) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`dept_id`),
  UNIQUE KEY `dept_name` (`dept_name`),
  KEY `manager_id` (`manager_id`),
  KEY `autoresp_email_id` (`autoresp_email_id`),
  KEY `tpl_id` (`tpl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `ost_department` */

insert  into `ost_department`(`dept_id`,`tpl_id`,`sla_id`,`email_id`,`autoresp_email_id`,`manager_id`,`dept_name`,`dept_signature`,`ispublic`,`group_membership`,`ticket_auto_response`,`message_auto_response`,`updated`,`created`) values (1,0,0,0,0,0,'Support','Support Department',1,1,1,1,'2015-10-12 13:33:40','2015-10-12 13:33:40'),(2,0,1,0,0,0,'Sales','Sales and Customer Retention',1,1,1,1,'2015-10-12 13:33:40','2015-10-12 13:33:40'),(3,0,0,0,0,0,'Maintenance','Maintenance Department',0,0,1,1,'2015-10-12 13:33:40','2015-10-12 13:33:40');

/*Table structure for table `ost_draft` */

DROP TABLE IF EXISTS `ost_draft`;

CREATE TABLE `ost_draft` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) unsigned NOT NULL,
  `namespace` varchar(32) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `extra` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `ost_draft` */

insert  into `ost_draft`(`id`,`staff_id`,`namespace`,`body`,`extra`,`created`,`updated`) values (1,0,'ticket.client.kmoijj3n9u55','',NULL,'2015-10-12 13:53:27','2015-10-12 14:23:20'),(2,1,'ticket.response.1','',NULL,'2015-10-12 15:16:10','2015-10-12 15:16:20'),(3,1,'ticket.note.1','',NULL,'2015-10-12 15:16:10','2015-10-12 15:16:20'),(4,0,'ticket.client.t87befstsks2','',NULL,'2015-10-12 15:20:58',NULL),(5,1,'email.diag','',NULL,'2015-10-12 16:49:50','2015-10-12 16:50:00'),(6,0,'ticket.client.4362775ive87','',NULL,'2015-10-12 16:50:45','2015-10-12 16:50:55'),(7,0,'ticket.client.ffb9gjn8p3s7','',NULL,'2015-10-12 19:09:30','2015-10-12 19:40:20'),(8,0,'ticket.client.ahgel3asu4e7','',NULL,'2015-10-13 10:53:01','2015-10-13 10:53:11'),(9,1,'ticket.response.2','',NULL,'2015-10-13 13:16:46','2015-10-13 13:24:10'),(10,1,'ticket.note.2','',NULL,'2015-10-13 13:16:46','2015-10-13 13:24:10'),(11,0,'ticket.client.onapqdj5ubr6','',NULL,'2015-10-13 13:22:43','2015-10-13 13:25:36'),(12,1,'ticket.note.3','',NULL,'2015-10-13 13:24:56','2015-10-13 13:25:05'),(13,1,'ticket.response.3','',NULL,'2015-10-13 13:24:56','2015-10-13 13:25:05'),(14,1,'ticket.response.4','',NULL,'2015-10-13 13:31:41','2015-10-13 13:31:51'),(15,1,'ticket.note.4','',NULL,'2015-10-13 13:31:41','2015-10-13 13:31:51'),(16,1,'ticket.note.5','',NULL,'2015-10-13 14:32:35','2015-10-13 14:32:45'),(17,1,'ticket.response.5','',NULL,'2015-10-13 14:32:35','2015-10-13 14:32:44'),(18,0,'ticket.client.2vd7n434tdh6','',NULL,'2015-10-13 18:13:58','2015-10-13 18:14:08');

/*Table structure for table `ost_email` */

DROP TABLE IF EXISTS `ost_email`;

CREATE TABLE `ost_email` (
  `email_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `noautoresp` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `priority_id` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `dept_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `topic_id` int(11) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `userid` varchar(255) NOT NULL,
  `userpass` varchar(255) CHARACTER SET ascii NOT NULL,
  `mail_active` tinyint(1) NOT NULL DEFAULT '0',
  `mail_host` varchar(255) NOT NULL,
  `mail_protocol` enum('POP','IMAP') NOT NULL DEFAULT 'POP',
  `mail_encryption` enum('NONE','SSL') NOT NULL,
  `mail_port` int(6) DEFAULT NULL,
  `mail_fetchfreq` tinyint(3) NOT NULL DEFAULT '5',
  `mail_fetchmax` tinyint(4) NOT NULL DEFAULT '30',
  `mail_archivefolder` varchar(255) DEFAULT NULL,
  `mail_delete` tinyint(1) NOT NULL DEFAULT '0',
  `mail_errors` tinyint(3) NOT NULL DEFAULT '0',
  `mail_lasterror` datetime DEFAULT NULL,
  `mail_lastfetch` datetime DEFAULT NULL,
  `smtp_active` tinyint(1) DEFAULT '0',
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` int(6) DEFAULT NULL,
  `smtp_secure` tinyint(1) NOT NULL DEFAULT '1',
  `smtp_auth` tinyint(1) NOT NULL DEFAULT '1',
  `smtp_spoofing` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`email_id`),
  UNIQUE KEY `email` (`email`),
  KEY `priority_id` (`priority_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `ost_email` */

insert  into `ost_email`(`email_id`,`noautoresp`,`priority_id`,`dept_id`,`topic_id`,`email`,`name`,`userid`,`userpass`,`mail_active`,`mail_host`,`mail_protocol`,`mail_encryption`,`mail_port`,`mail_fetchfreq`,`mail_fetchmax`,`mail_archivefolder`,`mail_delete`,`mail_errors`,`mail_lasterror`,`mail_lastfetch`,`smtp_active`,`smtp_host`,`smtp_port`,`smtp_secure`,`smtp_auth`,`smtp_spoofing`,`notes`,`created`,`updated`) values (1,0,2,1,0,'hafeez@convexinteractive.com','Support','','',0,'','POP','NONE',NULL,5,30,NULL,0,0,NULL,NULL,0,'',NULL,1,1,0,NULL,'2015-10-12 13:33:54','2015-10-12 13:33:54'),(2,0,2,1,0,'alerts@convexinteractive.com','osTicket Alerts','','',0,'','POP','NONE',NULL,5,30,NULL,0,0,NULL,NULL,0,'',NULL,1,1,0,NULL,'2015-10-12 13:33:54','2015-10-12 13:33:54'),(3,0,2,1,0,'noreply@convexinteractive.com','','','',0,'','POP','NONE',NULL,5,30,NULL,0,0,NULL,NULL,0,'',NULL,1,1,0,NULL,'2015-10-12 13:33:54','2015-10-12 13:33:54');

/*Table structure for table `ost_email_account` */

DROP TABLE IF EXISTS `ost_email_account`;

CREATE TABLE `ost_email_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `protocol` varchar(64) NOT NULL DEFAULT '',
  `host` varchar(128) NOT NULL DEFAULT '',
  `port` int(11) NOT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `options` varchar(512) DEFAULT NULL,
  `errors` int(11) unsigned DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `lastconnect` timestamp NULL DEFAULT NULL,
  `lasterror` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_email_account` */

/*Table structure for table `ost_email_template` */

DROP TABLE IF EXISTS `ost_email_template`;

CREATE TABLE `ost_email_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tpl_id` int(11) unsigned NOT NULL,
  `code_name` varchar(32) NOT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `template_lookup` (`tpl_id`,`code_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `ost_email_template` */

insert  into `ost_email_template`(`id`,`tpl_id`,`code_name`,`subject`,`body`,`notes`,`created`,`updated`) values (1,1,'ticket.autoresp','Support Ticket Opened [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name.first},</strong></h3> <p> A request for support has been created and assigned #%{ticket.number}. A representative will follow-up with you as soon as possible. You can <a href=\"%%7Brecipient.ticket_link%7D\">view this ticket\'s progress online</a>. </p> <br /><div style=\"color:rgb(127, 127, 127)\"> Your %{company.name} Team, <br /> %{signature} </div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small\"><em>If you wish to provide additional comments or information regarding the issue, please reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login to your account</span></a> for a complete archive of your support requests.</em></div> ',NULL,'2015-10-12 13:33:51','2015-10-12 13:33:51'),(2,1,'ticket.autoreply','Re: %{ticket.subject} [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name.first},</strong></h3> A request for support has been created and assigned ticket <a href=\"%%7Brecipient.ticket_link%7D\">#%{ticket.number}</a> with the following automatic reply <br /><br /> Topic: <strong>%{ticket.topic.name}</strong> <br /> Subject: <strong>%{ticket.subject}</strong> <br /><br /> %{response} <br /><br /><div style=\"color:rgb(127, 127, 127)\">Your %{company.name} Team,<br /> %{signature}</div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small\"><em>We hope this response has sufficiently answered your questions. If you wish to provide additional comments or informatione, please reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login to your account</span></a> for a complete archive of your support requests.</em></div> ',NULL,'2015-10-12 13:33:51','2015-10-12 13:33:51'),(3,1,'message.autoresp','Message Confirmation',' <h3><strong>Dear %{recipient.name.first},</strong></h3> Your reply to support request <a href=\"%%7Brecipient.ticket_link%7D\">#%{ticket.number}</a> has been noted <br /><br /><div style=\"color:rgb(127, 127, 127)\"> Your %{company.name} Team,<br /> %{signature} </div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small;text-align:center\"> <em>You can view the support request progress <a href=\"%%7Brecipient.ticket_link%7D\">online here</a></em> </div> ',NULL,'2015-10-12 13:33:51','2015-10-12 13:33:51'),(4,1,'ticket.notice','%{ticket.subject} [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name.first},</strong></h3> Our customer care team has created a ticket, <a href=\"%%7Brecipient.ticket_link%7D\">#%{ticket.number}</a> on your behalf, with the following details and summary: <br /><br /> Topic: <strong>%{ticket.topic.name}</strong> <br /> Subject: <strong>%{ticket.subject}</strong> <br /><br /> %{message} <br /><br /> If need be, a representative will follow-up with you as soon as possible. You can also <a href=\"%%7Brecipient.ticket_link%7D\">view this ticket\'s progress online</a>. <br /><br /><div style=\"color:rgb(127, 127, 127)\"> Your %{company.name} Team,<br /> %{signature}</div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small\"><em>If you wish to provide additional comments or information regarding the issue, please reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login to your account</span></a> for a complete archive of your support requests.</em></div> ',NULL,'2015-10-12 13:33:51','2015-10-12 13:33:51'),(5,1,'ticket.overlimit','Open Tickets Limit Reached',' <h3><strong>Dear %{ticket.name.first},</strong></h3> You have reached the maximum number of open tickets allowed. To be able to open another ticket, one of your pending tickets must be closed. To update or add comments to an open ticket simply <a href=\"%%7Burl%7D/tickets.php?e=%%7Bticket.email%7D\">login to our helpdesk</a>. <br /><br /> Thank you,<br /> Support Ticket System',NULL,'2015-10-12 13:33:51','2015-10-12 13:33:51'),(6,1,'ticket.reply','Re: %{ticket.subject} [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name},</strong></h3> %{response} <br /><br /><div style=\"color:rgb(127, 127, 127)\"> Your %{company.name} Team,<br /> %{signature} </div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small;text-align:center\"><em>We hope this response has sufficiently answered your questions. If not, please do not send another email. Instead, reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\" style=\"color:rgb(84, 141, 212)\">login to your account</a> for a complete archive of all your support requests and responses.</em></div> ',NULL,'2015-10-12 13:33:52','2015-10-12 13:33:52'),(7,1,'ticket.activity.notice','Re: %{ticket.subject} [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name.first},</strong></h3> <div> <em>%{poster.name}</em> just logged a message to a ticket in which you participate. </div> <br /> %{message} <br /><br /><hr /> <div style=\"color:rgb(127, 127, 127);font-size:small;text-align:center\"> <em>You\'re getting this email because you are a collaborator on ticket <a href=\"%%7Brecipient.ticket_link%7D\" style=\"color:rgb(84, 141, 212)\">#%{ticket.number}</a>. To participate, simply reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\" style=\"color:rgb(84, 141, 212)\">click here</a> for a complete archive of the ticket thread.</em> </div> ',NULL,'2015-10-12 13:33:52','2015-10-12 13:33:52'),(8,1,'ticket.alert','New Ticket Alert',' <h2>Hi %{recipient.name},</h2> New ticket #%{ticket.number} created <br /><br /><table><tbody> <tr> <td> <strong>From</strong>: </td> <td> %{ticket.name} &lt;%{ticket.email}&gt; </td> </tr> <tr> <td> <strong>Department</strong>: </td> <td> %{ticket.dept.name} </td> </tr> </tbody></table> <br /> %{message} <br /><br /><hr /> <div>To view or respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\">login</a> to the support ticket system</div> <em style=\"font-size:small\">Your friendly Customer Support System</em> <br /><a href=\"http://osticket.com/\"><img width=\"126\" height=\"19\" style=\"width:126px\" alt=\"Powered By osTicket\" src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" /></a> ',NULL,'2015-10-12 13:33:52','2015-10-12 13:33:52'),(9,1,'message.alert','New Message Alert',' <h3><strong>Hi %{recipient.name},</strong></h3> New message appended to ticket <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> <br /><br /><table><tbody> <tr> <td> <strong>From</strong>: </td> <td> %{ticket.name} &lt;%{ticket.email}&gt; </td> </tr> <tr> <td> <strong>Department</strong>: </td> <td> %{ticket.dept.name} </td> </tr> </tbody></table> <br /> %{message} <br /><br /><hr /> <div>To view or respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login</span></a> to the support ticket system</div> <em style=\"color:rgb(127,127,127);font-size:small\">Your friendly Customer Support System</em><br /><img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" alt=\"Powered by osTicket\" width=\"126\" height=\"19\" style=\"width:126px\" /> ',NULL,'2015-10-12 13:33:52','2015-10-12 13:33:52'),(10,1,'note.alert','New Internal Activity Alert',' <h3><strong>Hi %{recipient.name},</strong></h3> An agent has logged activity on ticket <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> <br /><br /><table><tbody> <tr> <td> <strong>From</strong>: </td> <td> %{note.poster} </td> </tr> <tr> <td> <strong>Title</strong>: </td> <td> %{note.title} </td> </tr> </tbody></table> <br /> %{note.message} <br /><br /><hr /> To view/respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\">login</a> to the support ticket system <br /><br /><em style=\"font-size:small\">Your friendly Customer Support System</em> <br /><img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" alt=\"Powered by osTicket\" width=\"126\" height=\"19\" style=\"width:126px\" /> ',NULL,'2015-10-12 13:33:52','2015-10-12 13:33:52'),(11,1,'assigned.alert','Ticket Assigned to you',' <h3><strong>Hi %{assignee.name.first},</strong></h3> Ticket <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> has been assigned to you by %{assigner.name.short} <br /><br /><table><tbody> <tr> <td> <strong>From</strong>: </td> <td> %{ticket.name} &lt;%{ticket.email}&gt; </td> </tr> <tr> <td> <strong>Subject</strong>: </td> <td> %{ticket.subject} </td> </tr> </tbody></table> <br /> %{comments} <br /><br /><hr /> <div>To view/respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login</span></a> to the support ticket system</div> <em style=\"font-size:small\">Your friendly Customer Support System</em> <br /><img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" alt=\"Powered by osTicket\" width=\"126\" height=\"19\" style=\"width:126px\" /> ',NULL,'2015-10-12 13:33:52','2015-10-12 13:33:52'),(12,1,'transfer.alert','Ticket #%{ticket.number} transfer - %{ticket.dept.name}',' <h3>Hi %{recipient.name},</h3> Ticket <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> has been transferred to the %{ticket.dept.name} department by <strong>%{staff.name.short}</strong> <br /><br /><blockquote> %{comments} </blockquote> <hr /> <div>To view or respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\">login</a> to the support ticket system. </div> <em style=\"font-size:small\">Your friendly Customer Support System</em> <br /><a href=\"http://osticket.com/\"><img width=\"126\" height=\"19\" alt=\"Powered By osTicket\" style=\"width:126px\" src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" /></a> ',NULL,'2015-10-12 13:33:52','2015-10-12 13:33:52'),(13,1,'ticket.overdue','Stale Ticket Alert',' <h3> <strong>Hi %{recipient.name}</strong>,</h3> A ticket, <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> is seriously overdue. <br /><br /> We should all work hard to guarantee that all tickets are being addressed in a timely manner. <br /><br /> Signed,<br /> %{ticket.dept.manager.name} <hr /> <div>To view or respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login</span></a> to the support ticket system. You\'re receiving this notice because the ticket is assigned directly to you or to a team or department of which you\'re a member.</div> <em style=\"font-size:small\">Your friendly <span style=\"font-size:smaller\">(although with limited patience)</span> Customer Support System</em><br /><img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" height=\"19\" alt=\"Powered by osTicket\" width=\"126\" style=\"width:126px\" /> ',NULL,'2015-10-12 13:33:52','2015-10-12 13:33:52');

/*Table structure for table `ost_email_template_group` */

DROP TABLE IF EXISTS `ost_email_template_group`;

CREATE TABLE `ost_email_template_group` (
  `tpl_id` int(11) NOT NULL AUTO_INCREMENT,
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL DEFAULT '',
  `lang` varchar(16) NOT NULL DEFAULT 'en_US',
  `notes` text,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tpl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ost_email_template_group` */

insert  into `ost_email_template_group`(`tpl_id`,`isactive`,`name`,`lang`,`notes`,`created`,`updated`) values (1,1,'osTicket Default Template (HTML)','en_US','Default osTicket templates','2015-10-12 13:33:51','2015-10-12 13:33:51');

/*Table structure for table `ost_faq` */

DROP TABLE IF EXISTS `ost_faq`;

CREATE TABLE `ost_faq` (
  `faq_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ispublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `keywords` tinytext,
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`faq_id`),
  UNIQUE KEY `question` (`question`),
  KEY `category_id` (`category_id`),
  KEY `ispublished` (`ispublished`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_faq` */

/*Table structure for table `ost_faq_category` */

DROP TABLE IF EXISTS `ost_faq_category`;

CREATE TABLE `ost_faq_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ispublic` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(125) DEFAULT NULL,
  `description` text NOT NULL,
  `notes` tinytext NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `ispublic` (`ispublic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_faq_category` */

/*Table structure for table `ost_faq_topic` */

DROP TABLE IF EXISTS `ost_faq_topic`;

CREATE TABLE `ost_faq_topic` (
  `faq_id` int(10) unsigned NOT NULL,
  `topic_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`faq_id`,`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_faq_topic` */

/*Table structure for table `ost_file` */

DROP TABLE IF EXISTS `ost_file`;

CREATE TABLE `ost_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ft` char(1) NOT NULL DEFAULT 'T',
  `bk` char(1) NOT NULL DEFAULT 'D',
  `type` varchar(255) CHARACTER SET ascii NOT NULL DEFAULT '',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `key` varchar(86) CHARACTER SET ascii NOT NULL,
  `signature` varchar(86) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `attrs` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ft` (`ft`),
  KEY `key` (`key`),
  KEY `signature` (`signature`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ost_file` */

insert  into `ost_file`(`id`,`ft`,`bk`,`type`,`size`,`key`,`signature`,`name`,`attrs`,`created`) values (1,'T','D','image/png',9452,'b56944cb4722cc5cda9d1e23a3ea7fbc','gjMyblHhAxCQvzLfPBW3EjMUY1AmQQmz','powered-by-osticket.png',NULL,'2015-10-12 13:33:45'),(2,'T','D','text/plain',24,'kfD3zMWtx86n3ccfeGGNagoRoTDtol7o','MWtx86n3ccfeGGNafaacpitTxmJ4h3Ls','osTicket.txt',NULL,'2015-10-12 13:33:50');

/*Table structure for table `ost_file_chunk` */

DROP TABLE IF EXISTS `ost_file_chunk`;

CREATE TABLE `ost_file_chunk` (
  `file_id` int(11) NOT NULL,
  `chunk_id` int(11) NOT NULL,
  `filedata` longblob NOT NULL,
  PRIMARY KEY (`file_id`,`chunk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_file_chunk` */

insert  into `ost_file_chunk`(`file_id`,`chunk_id`,`filedata`) values (1,0,'âPNG\r\n\Z\n\0\0\0\rIHDR\0\0\0⁄\0\0\0(\0\0\0òG‰…\0\0\nCiCCPICC profile\0\0x⁄ùSwXì˜>ﬂ˜eVBÿ±ólÅ\0\"#¨»Y¢í\0aÑ@≈Öà\nVúHUƒÇ’\nHùà‚†(∏gAäàZãU\\8Ó‹ßµ}zÔÌÌ˚◊˚ºÁúÁ¸ŒyœÄ&ëÊ¢j\09RÖ<:ÿèOHƒ…ΩÄH‡ ÊÀ¬g≈\0\0yx~t∞?¸Øo\0\0p’.$«·ˇÉ∫P&W\0 ë\0‡\"ÁêR\0».T»\0»\0∞S≥d\n\0î\0\0ly|B\"\0™\r\0ÏÙI>\0ÿ©ì‹\0ÿ¢©\0ç\0ô(G$@ª\0`UÅR,¿¬\0†¨@\".¿ÆÄY∂2GÄΩ\0véXê@`\0ÄôB,Ã\0 8\0CÕ L†0“ø‡©_pÖ∏H\0¿ÀïÕóK“3∏ï–\ZwÚ‡‚!‚¬l±Ba)f	‰\"úóõ#HÁLŒ\0\0\Z˘—¡˛8?êÁÊ‰·ÊfÁlÔÙ≈¢˛ko\">!Òﬂ˛ºå\0NœÔ⁄_ÂÂ÷p«∞uøk©[\0⁄V\0hﬂ˘]3€	†Z\n–z˘ãy8¸@û°P»<\nÌ%b°Ω0„ã>ˇ3·o‡ã~ˆ¸@˛€z\0qö@ô≠¿£É˝qanvÆRéÁÀB1n˜Á#˛«Ö˝é)—‚4±\\,äÒXâ∏P\"M«yπRëD!…ï‚È2Òñ˝	ìw\r\0¨ÜO¿N∂µÀl¿~ÓãX“v\0@~Û-å\Zë\0g42y˜\0\0ìø˘è@+\0Õó§„\0\0ºË\\®îL∆\0\0D†Å*∞A¡¨¿ú¡º¿aD@$¿<B‰Ä\n°ñAT¿:ÿµ∞\Z†ö·¥¡18\rÁ‡\\ÅÎp`û¬ºÜ	A»a!:àbéÿ\"Œôé\"aH4íÄ§ ÈàQ\"≈»r§©Bjë]H#Ú-r9ç\\@˙ê€» 2ä¸äºG1îÅ≤Q‘u@π®\Zä∆†s—t4]Äñ¢k—\Z¥=Ä∂¢ß—KËut\0}äécÄ—1fåŸa\\åáE`âX\Z&«cÂX5Vè5cX7v¿ûaÔ$ãÄÏ^Ñ¬lÇêêGXLXC®%Ï#¥∫W	ÉÑ1¬\'\"ì®O¥%z˘ƒxb:±êXF¨&Ó!!û%^\'_ìH$…í‰N\n!%ê2IIkH€H-§S§>“iúL&Îêm…ﬁ‰≤Ä¨ óë∑êêOí˚…√‰∑:≈à‚L	¢$R§îJ5e?Â•ü2Bô†™QÕ©û‘™à:üZIm†vP/Sá©4uö%ÕõCÀ§-£’–öigi˜h/Èt∫	›ÉEó–ó“kËÈÁÈÉÙw\rÜ\rÉ«Hb(k{ß∑/ôL¶”óô»T0◊2ôgòòoUX*ˆ*|ë ï:ïVï~ïÁ™TUsU?’y™T´U´^V}¶FU≥P„©	‘´’©Uª©6ÆŒRwRèPœQ_£æ_˝Ç˙c\r≤ÜÖF†ÜH£Tc∑∆ç!∆2eÒXB÷rVÎ,kòMb[≤˘ÏLv˚v/{LSCs™f¨fëfùÊqÕ∆±‡9ŸúJŒ!Œ\rŒ{--?-±÷j≠f≠~≠7⁄z⁄æ⁄bÌrÌÌÎ⁄Ôupù@ù,ùı:m:˜u	∫6∫Q∫Ö∫€uœÍ>”cÎyÈ	ı ıÈ›—GımÙ£ıÍÔ÷Ô—7046êl18cÃêcËkòi∏—Ñ·®Àh∫ëƒh£—I£\'∏&Óág„5x>f¨ob¨4ﬁe‹k<abi2€§ƒ§≈‰æ)Õîköf∫—¥”tÃÃ»,‹¨ÿ¨…Ïé9’úkûaæŸº€¸çÖ•Eú≈Jã6ã«ñ⁄ñ|ÀñMñ˜¨òV>VyVıV◊¨I÷\\Î,Îm÷WlPWõõ:õÀ∂®≠õ≠ƒvõmﬂ‚è)“)ıSn⁄1Ï¸Ï\nÏöÏÌ9ˆaˆ%ˆmˆœÃ÷;t;|rtuÃvlpºÎ§·4√©ƒ©√ÈWgg°sùÛ5¶KêÀóvóSmßäßnüzÀïÂ\ZÓ∫“µ”ı£õªõ‹≠Ÿm‘›Ã=≈}´˚M.õ…]√=ÔAÙ˜X‚qÃ„ùßõß¬ÛêÁ/^v^Y^˚ΩO≥ú&û÷0m»€ƒ[‡ΩÀ{`:>=e˙ŒÈ>∆>üzüáæ¶æ\"ﬂ=æ#~÷~ô~¸û˚;˙À˝è¯ø·yÚÒN`¡ÂΩÅ\ZÅ≥kô•5çª/>B	\rYrìo¿Ú˘c3‹g,ö— ùZ˙0Ã&L÷éÜœﬂ~o¶˘LÈÃ∂à‡Glà∏iô˘})*2™.ÍQ¥Stqt˜,÷¨‰Y˚gΩéÒè©åπ;€j∂rvg¨jlRlcÏõ∏Ä∏™∏Åxá¯EÒót$	Ìâ‰ƒÿƒ=â„sÁlö3ú‰öTñtcÆÂ‹¢πÊÈŒÀûw<Y5Yê|8Öòó≤?ÂÉ BP/OÂßnMÚÑõÖOEæ¢ç¢Q±∑∏J<íÊùVïˆ8›;}C˙hÜOFu∆3	OR+yëíπ#ÛMVD÷ﬁ¨œŸqŸ-9îúîú£R\riñ¥+◊0∑(∑Of++ì\r‰yÊm ìá ˜‰#˘sÛ€lÖL—£¥RÆPL/®+x[[x∏HΩHZ‘3ﬂf˛Í˘#Ç|Ωê∞P∏∞≥ÿ∏xYÒ‡\"øEª#ãSw.1]R∫dxi“}ÀhÀ≤ñ˝P‚XRUÚjy‹ÚéRÉ“••C+ÇW4ï©î…ÀnÆÙZπcaïdUÔjó’[V*ï_¨p¨®Æ¯∞F∏Ê‚WN_’|ıym⁄⁄ﬁJ∑ ÌÎHÎ§În¨˜YøØJΩjA’–Ü\r≠ÒçÂ_mJﬁt°zjıéÕ¥Õ Õ5a5Ì[Ã∂¨€Ú°6£ˆzù]ÀV˝≠´∑æŸ&⁄÷ø›w{ÛÉ;ﬁÔîÏºµ+xWkΩE}ın“ÓÇ›è\Zb∫øÊ~›∏GwO≈ûè{•{ˆEÔÎjtol‹Øøø≤	mR6çH:pÂõÄo⁄õÌöwµpZ*¬AÂ¡\'ﬂ¶|{„PË°Œ√‹√Õﬂô∑ıÎHy+“:øu¨-£m†=°ΩÔËå£ù^Gæ∑ˇ~Ô1„cu«5èWû†ù(=Ò˘‰Çì„ßdßûùN?=‘ô‹y˜L¸ôk]Q]ΩgCœû?tÓL∑_˜…ÛﬁÁè]ºpÙ\"˜b€%∑K≠=Æ=G~p˝·HØ[oÎe˜ÀÌW<ÆtÙMÎ;—Ô”˙j¿’s◊¯◊.]üyΩÔ∆Ï∑n&›∏%∫ı¯vˆÌw\nÓL‹]zèxØ¸æ⁄˝Í˙Í¥˛±e¿m‡¯`¿`œ√YÔ	áû˛îˇ”á·“GÃG’#F#çèù\r\ZΩÚdŒì·ß≤ßœ ~VˇyÎs´Áﬂ˝‚˚KœX¸ÿ˘ãœøÆy©ÛrÔ´©Ø:«#«ºŒy=Ò¶¸≠Œ€}Ô∏Ô∫ﬂ«Ωô(¸@˛PÛ—˙c«ß–O˜>Á|˛¸/˜ÑÛ˚Ä9%\0\0\0tEXtSoftware\0Adobe ImageReadyq…e<\0\0(iTXtXML:com.adobe.xmp\0\0\0\0\0<?xpacket begin=\"Ôªø\" id=\"W5M0MpCehiHzreSzNTczkc9d\"?> <x:xmpmeta xmlns:x=\"adobe:ns:meta/\" x:xmptk=\"Adobe XMP Core 5.6-c014 79.156797, 2014/08/20-09:53:02        \"> <rdf:RDF xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"> <rdf:Description rdf:about=\"\" xmlns:xmp=\"http://ns.adobe.com/xap/1.0/\" xmlns:xmpMM=\"http://ns.adobe.com/xap/1.0/mm/\" xmlns:stRef=\"http://ns.adobe.com/xap/1.0/sType/ResourceRef#\" xmp:CreatorTool=\"Adobe Photoshop CC 2014 (Macintosh)\" xmpMM:InstanceID=\"xmp.iid:6E2C95DEA67311E4BDCDDF91FAF94DA5\" xmpMM:DocumentID=\"xmp.did:6E2C95DFA67311E4BDCDDF91FAF94DA5\"> <xmpMM:DerivedFrom stRef:instanceID=\"xmp.iid:CFA74E4FA67111E4BDCDDF91FAF94DA5\" stRef:documentID=\"xmp.did:CFA74E50A67111E4BDCDDF91FAF94DA5\"/> </rdf:Description> </rdf:RDF> </x:xmpmeta> <?xpacket end=\"r\"?>ã˛ˆ \0\0IDATx⁄Ï]	úS’’?/{2…dfÄaqê]67–œ≠(*®-\nˆÛ≥∂.ı+÷÷Ö∫ nµJ¡≠ˆSãR¥’:VDT§,e—2®lÇ†¨ÇÏã3Ã¬Líó˜›õ¸osÊNí…PqÃ˘˝$ìó˜Óª˜¸œ˘üsÔª1ÜNY96§⁄t“ÿÓÔS±/Qƒ˝]k~K°ìÖÓzõ–Ìç>É%4ﬂ§“5∫˙≠<≤Ÿ,≤ÕclmYÛŒ íÑû\'Ù«BØhÙ∑£BÛLZ∏ﬁM?õ§∞\0]sôG÷>æ◊‚Z(4W®]h\r\"“æ&F4ô]ç˛∂?JKD$˙F>Yd-}QäZY†eÂª)≠Ñû*tÄ–”Ñ∂Í‡$ªâ\r	=(tï–ÈBg	=ê¡πÌ¯_Ç¥¢—îQ\0m∆VÌ+≥SèvaäDõW«gÅˆ˝êéBØ˙øBªe¯ùﬁBØ∫LËH°“õ#tÛªB«	˝mFWí\0;t» _éŸÏ@ñÕ—öøxÑﬁ.t!ø[Œ!#‡\\°˜„|…‰Wàí:˜ÿ\rG≥†I≥∑9Èâ“* ç6ÀÅ»≠˘Jk°SÖ˛AËqG¿Nçº\09ù§õEBÔMπ~-4?Ìôù’~„†Iã}‘&∑yÂeYÍÿ¸Â°o\nÌuÑœ{.rªΩBk∏÷iv?äó˙LG∑¥—îµj»-+ﬂëQÊï£\02%>‰|ô Ô(^Õõíﬂ\nÍXËè∆r≥ÊT“œR«Ê-í*ˆˇñÆ-„—R°ÀÖV±øÀBIÀ:G TÃ#˛…5i˛\ZE\"FÛîlD;Ê\\_‰pæ˝sj dÒëìıB\"tá–B)Ù2‰wﬂƒÔœäª˜`îÊ≠Ù–§ï^ö∂—MnA!çÊ<¨YÀ>Üºû•íÌßêˆ\n´ktıMÊJw%˘ªú<.ˇ›¬√BøU\\GÒBI?Á¶ì]\0Ão∆–ÙÂ^˝Ù•∫eFê&.˜ë◊aë«a5Ô±Õö˜±#“£o>§ê=L^´—˛]Féû⁄ﬂJÖN\0ÉGπ˘„ÖæVá\Z˙¢!q#!≈ñ€È¿6=XÍß9õ\\T2»Ô≤®{´ôc—Êç≥,–é)zak≥l¥˙@1ıœﬂ{ù°Ñ^£˝MFî°_b’Ê(7˝9°£≠ë+\'J´÷{hÒónÍê°[\\ÙhiµÛGc41\'\'±MÎ˚1∂é≥œ>;k·«êLõøåﬁ‹›ã˙∑ÿ$‹|∆~,äó›ïîxﬂ ∂l⁄‚(4W.”\ZAj’à¬rù‚„sr…Wùµ…M–Wîr›\"zµhû´>≤Ì;ôßYîÁ™äE,è0ﬁå\\æ\\1ÔbÔ∫ØÂ\"·\'Ñæë¡xÀ¸Íu–LYÃ»£x9ﬂ)¥˘^[\0õPÙXVÁÇNX·•ÕªùT(\"Yè∂âuãﬂWêeÅvä›àRUÿC55AÚÿCô–GY6?ëΩˇ@Ë´⁄1kÑVS|Ç9ù»IÓX Ë£ƒ*êrD \"ÄˆL°ÉÑŒé=*@4È´=N wZjâ9æ%p…ˆ %aÌÒ~è–yBeÅñïò¯Ìµ¥¢¢\rïÏÏK√;HTÎoË+É)æQ…_≈∏t°‘ÎâcIÏUû»±B\"îV⁄™»Vg>L vW¶S‚1õ|ÚXª∂Óp—∞…y¥Ì†ùZx£rR≠≈\'∑#†∞)˝≈WöH™[ ‘çˆ ∫±	›(#Ú=B2ä˚C°€≤@ÀJL,H$À›µ(ÒüN)2ö©∞\'øõ‰òÆ\Zµ‘/*œ\'rZüKD‹˚Vù((ﬂ’g	å≤≈õ{Ä∆Pì]aY« πjﬂä=B≥ù\n\"4~nÄVnwR˜∂ëXéFÒUˇrQsŒêJd‰‹\ZzæÙ7\"‡y°7e©cVéä∏™È˝Ω›Ë‰‡Í%îB˛T`ÀÖSÚO–;]NNy±Xﬁz7‚∂s¥—}ÛÙ‰á~j/®ﬂ¨\rn™¥∑“F√z◊–»*àƒfñ€âÊ¥å5)◊‹EûË°EK|Ù÷j∑4»˘4\rI.Ú¬ñîx∂Õ€ƒ.åj¿6à®GJéG_˜Ü”òëZz1`Nx„Pä„<8¶^˛»$6ìv‘hUYı\nÏçG∂‰Ûjrﬁ¨/^ÔDé•ã§a›Sö£€öIm¬∑Lúï\Z˚^ fùùZÀÜA36∫ck†Â{,\Z9†R‹±@WµQ%†∞Z‰dÛ∑◊„WmˆÜoûñ\'rKä«JˆäˆU0√7YﬁßD~&*ØÿÚ—ˇïá1~ˇÈÖ&=PH:	Ô«eÅ÷∞»Å~πè|‘d4≈ü:Ê“á‚Î\n€„ò{é‘≈£T«π+h≤,Ûãà÷9ww™Õz‰¸X\0Øø˝“Â-áKÄÃN/R€ÕœÃÃ\r›3-HÖÅh+üapymv+“ g…ß•7∑ÚE#Û∂:ÈÍí*πÚÄ€ÍZ;x˘◊ŒÅw…*âØKq®8W‡QÄÃÄ»∂<{Xû&ù“£îxPTRœ;Pƒë ¸#úóõö≤%¬∑\'Ì»H/ºdÅñ¢&AÒy©¯?ôï†≤ÂLj»á6·ê=\"≤9°t9\Z_®ª2I$€ı\0ÈKÌ,⁄-\"Ÿh≤û˘g.›˛v∞∞8ﬂº…aã=®Ÿû]MV*D-z≤c0:Úz7yﬂ…£GœØ(/y=ø|“ß^[π”∫∂ca‰qÅ>—∫Qjã–«)æbDóØŸkyÉüJ@„˝÷còÂ§Kñ∑°†£leh\rKÑ—≈)®„Axn˝vçF8\rìJ∂ùBww*%Gl^ÕñÃã*˘D˚LV‹˛Ü™ ó)Q”x¿Ê1◊NTÒ7oÊù—.ﬂ|ŒeßS¢VÏ>^Ñ—»¸ËB/ë\Zé“Ω«ÕqSEﬁˆ≈>;-ﬁÓ41˙tØˆ°¶iD≈Áìç8Uî}\'—\"ÙOBœzùñ#ÒúÕ≈ﬁw¢¯ñv8;πÑÏI∫F>»:‘π≥„∞Ä‚O4DÂÂ≥róÇ÷·å∆S›mÚ.¶¯F!%¶8‰äõI¨Çy\"˙∫ìÜßã·Ñe€*H‡NE√f£t5≈ÁK#¡ÆLíõB‚Á≈E¡3„Ÿ6Pï†À˝$äV72ˆ„;‹ËP\"1˙√ì»π†˘‡Úƒ°⁄πÉ‘\\y®’ ‰(™rˇ\"™W≤>ùïÉ™›z˙SÒ}ãÍ|?Aü»6N£¯äyŒãp9H´í\0¢≠äƒ6¬1ã6 ßP‘Z}iÕ\"ßç≤R7≈%íﬁOﬁËƒç˚Ì—ãkCU!j/@61‡≤z	 \'Ûâ[Ñ~•Âw◊£˙7V\0q_Æ+ˆ}Íòo^e4\"6∂âéΩ¬®ÙsÑ˛∂Ù!≈◊\\r‚ kûJN≠TÚó$@ìQ˜N™øÆS…˘†•ÈÊÃ$yZ(_ı:Î{È¿‰W,î§\r∑/Éπuπ\Zs÷xÜÁ—∞qhËÿÊÇÁ´–.üﬁ}	ûäãÏg(æb[\Z÷sL7„¸RF°‰+Ø%°(¡ﬂG√8\"4§rÅÍ)⁄5V¬Ç6IèŸFı\r:Ô XR>9±⁄Q;G)⁄¥ÔÔ¶¯¿^ñ”L»∞R∆#ãÃ”.c‡/¬†ı¿5/d‘Izf9π,ÁõÊ}Og+>{8æ≤æxqÔ*ÍÓ¿kπÇ^ﬂZ`5¢ rπu¿‹u˙∫ †æË\"íIêÕE[uTã\\µ\n—qå»ﬂfÂ∫-Èœµ‚Õ∫/I4%8¥{0∆7\"W+k†´ºTÖåGa_ÈdC:∂ˆ®2Ÿ∆·∏ﬂv\0›YÏÛµ»-ª£ﬂ{¿∂˙0«üNÏ6V˝Ò¬‡˚!1˝öyàö\0@ÅLFôyË@:ˆ:xÊ:¨/+Eü√Æu.^f=0	≤W»V\"bÖ¶K–5¨3G†ÌÑht∏#¿+¡ı>?˜‡«Ω=Çˆò0é}0ûŒt†…º◊¥u\r˛Và∂ 9¨)åft—º~;ºûWü9Xt»t∆ä#)\n6Ex˝9r¢Û·8∏ºÎ_KÄÃ•gËëóÊD˚äúÏ¨öø+	»∏º\nêÏ·Z≠Ù˛uöÔ-@ﬂG›L Ú©¢›M\Z»¬`“Ò^NÒ\rÇ^F•»´	«›»ﬁœ` #∏ŒbLÂFD⁄~îx÷é@7üÑ”:…€˛!lÚ1¿l\Zóï\'˛9@p)ãb·PbNÊUPÆÛq¨‚¨˜Ò˛tÄË8ùí\"ñ\'™\r\\&!¬™≤∑„&OGG◊Çbﬁnf`] 0ÁËN=m?ëœkı¬Î€XÔF$?µ±2¸bP\n±¡ÿïp∂0òÎ{ıEAohøå|ÆÍd˘YÎ∑E,«qjQeò0◊ÌT`“ÀK|4bf.‰D…fãıáå⁄o≥ËûN‘D¯√Å™“˝=l,uŸÅ1π\\£§çïvﬂUããºÓP∞öw¿BÆG_˚)1ß\0ªNüo©∞Å°ñ•CÿÁƒ∆Á&“Å˚ÿÁóÅÕ<Pq~ˇ6™Æ≤ùcmZòû¿Êb>∆	î\\£UÜÒ£ˇÇ\' ¯y¯>!‹∂Fæ‰G¥,ÕG‰≤ MO…f  uQÁÏ¿’‡˝nx™©àä™HrL<‹4ä?f/Â†qR¶ÉÍJ øç…§%e\"£â»2és!÷ßå!®Ø\'Û~ÀÎp\r#JeÂπ+R=uùÀ˙m£^JæÇUí|®≤ FÔopìCºˆ˙(h_oI3ôÃ]puB4˚+Æq.¢÷Cóç∂I[ŸIMõgTm(ã¸FÚáFúg/\"ÍXñ∑ÆAˇ]ôØ\03#∞®)IŒ5„≠rÿ¨¿c”®} ™„G⁄˚Ö@©@Qæ|\0∫¬E(àNëûÂwîÿÃ•˛uDŒK\0ñ˛h‘*‰Y™C•.É1€‡UrX4<ûy¢≈Ãê;≤»˘_Bø@áD1p~mxﬁVÀﬁØËªg¥5ZeÚ+x–„‡H∂Ã\'√P\rDÈæ¨üÎÄlw≠ü˙ˆPÕÃd˘xÏ>]h˜¸≠Bã∞õ’Gºæ‘GØ≠R∑¬à|»“`˝úÈèQÏÅÍv¢€”†¿BøÜC,EÓ∂àRO¯g*µ˜/6Ú˚9†p™8!ƒ≠åÊÏîØ†q\"BZ45xH2≈¢-G:†ôI83%©æ’$ÒÇ|ôãaY€\0<‹¥§ZΩ»W≥õÿ0Ï&™—ÊœaTnÕ‡Uπÿ√¢”Ztöù¶ep™\Zÿ‘i#EøôåF®6Œ˝È*€Ì\\ÁÛoæ≠&H\'	ê=–c6πm\"ƒ∂6®WÈ∆‹JVQSq*Í≤®bßì¶,ÛQõ†©ûd∂±{Œ4“{r≤± u!∆≤Ë◊F°n£¶-ËµíÃñ7aÆÌL≠∏ëÉÍ7i@„{PûLÈñÆ%$ê¬(–Ù\'q˚∞c∂Ä√w`ûî`@˘à5	¥eˆ¿∞‘„\Zó≤»Ú9¿f’£°öóV%ıÆØ¢ìùM(ñ√´˙qŒa˙Ísæﬂ˜QÄË®w^Àìw“\nRZ0«≤ãEÕO‡tn`≈á≈Ëó∏eY=ﬁm.˘˜í\'2_™˝CN`∆Æä(!ñk«˚M–ƒç˚4uùõ∫%º4)±èH¶[¯–/™;ı˝}\\å˛8õ*‰X¸å‘=Mwh\r\Zt\n—\\\'\"‹\n∆ÑÏZ~M3µÅ-9Ÿ8⁄R8â§gÜ_@uWN¿Ê4∫≤Íìöœπõ5b5ÀÛT^RcSVhßb‡>b\0#‰èÿ5:°,˚wÃcTß®Pmaù◊˘¢˙º\'¶ ˛E	e0√X‘éBIãFx\\yæï¿UÏı\"≠8°ré„ı[¸ÑEﬁr:!5àdIAñ«hÌ\'Z4Wt∞∂Å∂ØgŒ4ÈÜ≤ˆv‰<«Q˝]à-Ùˇ\\‚ÿA(5`m,Ø	Áöå¬âíV®\Z˙XdØ—*¶ÁPbéı<¶B%+˚#c.V*†ÈÌPéîò,V’ôy(:å\0∞F#\"|Fu7Üô¡™l+\0(øñ¥Ô≈ÄÙbÛü≤ÇÃ`x⁄óPR˝7’ù*)˘.^U(Ë\\éŒúä˜;Ü∂ËÑ´P–ô\0Éyó\Z¿ôÍ«ÒË¸\0àjÀÏ8ôß˝\Z«–Ûìﬁ›yŸdÖQÊe©üÆZÛ	∆EO¿∑˝€h¬u)à––Óµ¥hª3∂!õ[SUƒ\'®·_åàq¸¢ı«(.˝îROØB—bÚ∫Wõ—∂hÔØ‘ãG\r»N´÷¿)ûŒÓÈ|V¶F¸hˇ¡&D]ÓÙÍE4 kèy6hw‚ı†=ﬂ‡ƒ?D©Ω\'õ≥πïu¸b-·Ts˚òGï≤îy≠yà¨`8ó¢ﬂ«<Ö\na+V¬\rh˜2	Ûxö´1◊—ñMAºÅyó)lﬁk$∏¸≥¨Hë√yô7¸˝t\r¢ïjÀHÙ/6-”J¿u&<}\"¢Qƒïn@{≥jK\Zµ.`-N±B⁄ÜÈö”´hµM/^ïÇù\\ﬂÄ1vS√/GJPî!Ω6#¢Ω£9∂:Cb˝±ˆÄÊDƒçR›_Ã9ç¯ÜC\rã˛SU]SE4;ºÚ–B™oØ\"¢(˘¯˜Px)\'åÂÃµp ≤‘	ﬁù”ú{àPÔ4	˛Â0,@:—LïçÅ\\j’_˘g˘08Ç0Ócã\"!‹Î,x77ÆÒ\Z\nùùd˚\"~Åh‡ÉÁìÁ∫˘ﬁ~Pï9I∏˝,FSÁ‘;km@F2?\n%˚5z|:˙∏5h–DÌ€CÿtG¬TETìÂ}-˛ÀqzÁ{\n•˚iIÓ≥Qø3˛#ÊÃdt˛-∆!ŸDWD“#w#e&∞ö\ZÒ¿QND˚wÅïÄ›îjÌq≤¢‘{p§£kõß£+‹è{gZ«´r–•l´¡\"¸lém$l€p$I?Ä1ª`<…¯À:$ìÍÏBiÊbñBìùc]öŒ›Äk8qç∞vçCîdíWìËxUﬁ\'πyûø¿°¨†QíÈ.à=oÖÅ3µÅVÖò %ñ˛|Fı◊=äV +≠û$ãE\'^9Oı7KÌœLıÉËΩ≤ZÖ‰»´≥IŒ4x¯áa∞œ¬Aï·>Œƒgù–è∑≥≥æ\0`_c:\Z¡ò\rF¥(D‰ù~@3—∑3)±æS:∏ﬂ _?µÄì\\®M)Ë¥Ó8÷~x/∆Ô¡∆F!’PnÈp/ÿΩÂÿ%h[p›ãXes,⁄æƒë¢\nieêL”ò…D˜ÅJKKrè÷uîAò)J¿w\"ˆd¥±˛Ú•x^∂Ã‚W»˚\np”…Ê$π∆\0D˜(¢-ã]ù]¢”:ÜhkπùÁiÑ¸d3˛ø™èÒ+Ó;ÿﬂUn˛4\nK…∂P(P«h˝Î◊\n;^ª∆≤î,]|ûÑXæÀ´±Tw	Vû∆ﬁv\0ºu™øè‡æûbS(¡’ŸñZ?=g`xí⁄—°5¿MY9\ZíÉ\\SÅl3®e:Y	jÊBn©v°J5ós˚z“ùS–∆.\'‘“%õjhÃúÄ\0Z=_\Z¢Û•òˆh`oe[ö‚∫À)Ò#Ò2ßi∞ÏùüM…7◊ôébV˜ı´ÑN@tÚS˝_]äÎ˝ˇwfHuÕôHe¶„m–Èˇ€Hk ZµD€Ω¯Ó\'(òùÉäπNTªÁ|_;Á\"¥ÎVJLç…îiæÒÚÀ/˜Bhå†ë≥∏8‚\"©∆/·!w¬˚öÏ¿Î F5Â¸vT!+Q¡≠/AìFO“ò“Í4õCü\Zp0jCï\nJÃ\'6∏£Qö~‘7vD3/ÿB5®™’@€Z p…„À˛_Ä\0≥‡Øòs]J˝\0\0\0\0IENDÆB`Ç'),(2,0,'Canned Attachments Rock!');

/*Table structure for table `ost_filter` */

DROP TABLE IF EXISTS `ost_filter`;

CREATE TABLE `ost_filter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `execorder` int(10) unsigned NOT NULL DEFAULT '99',
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` int(11) unsigned NOT NULL DEFAULT '0',
  `match_all_rules` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stop_onmatch` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reject_ticket` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `use_replyto_email` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `disable_autoresponder` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `canned_response_id` int(11) unsigned NOT NULL DEFAULT '0',
  `email_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status_id` int(10) unsigned NOT NULL DEFAULT '0',
  `priority_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `team_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sla_id` int(10) unsigned NOT NULL DEFAULT '0',
  `form_id` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ext_id` varchar(11) DEFAULT NULL,
  `target` enum('Any','Web','Email','API') NOT NULL DEFAULT 'Any',
  `name` varchar(32) NOT NULL DEFAULT '',
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `target` (`target`),
  KEY `email_id` (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ost_filter` */

insert  into `ost_filter`(`id`,`execorder`,`isactive`,`status`,`match_all_rules`,`stop_onmatch`,`reject_ticket`,`use_replyto_email`,`disable_autoresponder`,`canned_response_id`,`email_id`,`status_id`,`priority_id`,`dept_id`,`staff_id`,`team_id`,`sla_id`,`form_id`,`topic_id`,`ext_id`,`target`,`name`,`notes`,`created`,`updated`) values (1,99,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,NULL,'Email','SYSTEM BAN LIST','Internal list for email banning. Do not remove','2015-10-12 13:33:43','2015-10-12 13:33:43');

/*Table structure for table `ost_filter_rule` */

DROP TABLE IF EXISTS `ost_filter_rule`;

CREATE TABLE `ost_filter_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filter_id` int(10) unsigned NOT NULL DEFAULT '0',
  `what` varchar(32) NOT NULL,
  `how` enum('equal','not_equal','contains','dn_contain','starts','ends','match','not_match') NOT NULL,
  `val` varchar(255) NOT NULL,
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `notes` tinytext NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filter` (`filter_id`,`what`,`how`,`val`),
  KEY `filter_id` (`filter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ost_filter_rule` */

insert  into `ost_filter_rule`(`id`,`filter_id`,`what`,`how`,`val`,`isactive`,`notes`,`created`,`updated`) values (1,1,'email','equal','test@example.com',1,'','2015-10-12 13:33:43','2015-10-12 13:33:43');

/*Table structure for table `ost_form` */

DROP TABLE IF EXISTS `ost_form`;

CREATE TABLE `ost_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(8) NOT NULL DEFAULT 'G',
  `deletable` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL,
  `instructions` varchar(512) DEFAULT NULL,
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `ost_form` */

insert  into `ost_form`(`id`,`type`,`deletable`,`title`,`instructions`,`notes`,`created`,`updated`) values (1,'U',1,'Contact Information',NULL,NULL,'2015-10-12 13:33:41','2015-10-12 13:33:41'),(2,'T',1,'Ticket Details','Please Describe Your Issue','','2015-10-12 13:33:42','2015-10-12 19:16:40'),(3,'C',1,'Company Information','Details available in email templates',NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(4,'O',1,'Organization Information','Details on user organization',NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(5,'L1',1,'Ticket Status Properties','Properties that can be set on a ticket status.',NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(6,'G',1,'User Ticket','Go green',NULL,'2015-10-12 19:36:18','2015-10-12 19:36:18');

/*Table structure for table `ost_form_entry` */

DROP TABLE IF EXISTS `ost_form_entry`;

CREATE TABLE `ost_form_entry` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) unsigned NOT NULL,
  `object_id` int(11) unsigned DEFAULT NULL,
  `object_type` char(1) NOT NULL DEFAULT 'T',
  `sort` int(11) unsigned NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entry_lookup` (`object_type`,`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `ost_form_entry` */

insert  into `ost_form_entry`(`id`,`form_id`,`object_id`,`object_type`,`sort`,`created`,`updated`) values (1,4,1,'O',1,'2015-10-12 13:33:43','2015-10-12 13:33:43'),(2,3,NULL,'C',1,'2015-10-12 13:33:55','2015-10-12 13:33:55'),(3,1,1,'U',1,'2015-10-12 13:33:56','2015-10-12 13:33:56'),(4,2,1,'T',1,'2015-10-12 13:33:57','2015-10-12 13:33:57'),(5,1,2,'U',1,'2015-10-13 13:16:27','2015-10-13 13:16:27'),(6,2,2,'T',1,'2015-10-13 13:16:28','2015-10-13 13:16:28'),(7,2,3,'T',1,'2015-10-13 13:24:38','2015-10-13 13:24:38'),(8,2,4,'T',1,'2015-10-13 13:31:09','2015-10-13 13:31:09'),(9,2,5,'T',1,'2015-10-13 14:32:09','2015-10-13 14:32:09'),(10,1,3,'U',1,'2015-10-13 17:39:39','2015-10-13 17:39:39'),(11,1,4,'U',1,'2015-10-13 18:51:54','2015-10-13 18:51:54'),(12,1,5,'U',1,'2015-10-13 18:52:21','2015-10-13 18:52:21'),(13,1,6,'U',1,'2015-10-13 19:08:03','2015-10-13 19:08:03');

/*Table structure for table `ost_form_entry_values` */

DROP TABLE IF EXISTS `ost_form_entry_values`;

CREATE TABLE `ost_form_entry_values` (
  `entry_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `value` text,
  `value_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`entry_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_form_entry_values` */

insert  into `ost_form_entry_values`(`entry_id`,`field_id`,`value`,`value_id`) values (1,28,'420 Desoto Street\nAlexandria, LA 71301',NULL),(1,29,'3182903674',NULL),(1,30,'http://osticket.com',NULL),(1,31,'Not only do we develop the software, we also use it to manage support for osTicket. Let us help you quickly implement and leverage the full potential of osTicket\'s features and functionality. Contact us for professional support or visit our website for documentation and community support.',NULL),(2,23,'OS TICKET',NULL),(2,24,NULL,NULL),(2,25,NULL,NULL),(2,26,NULL,NULL),(3,3,NULL,NULL),(3,4,NULL,NULL),(4,20,'osTicket Installed!',NULL),(4,22,NULL,2),(5,3,'123456333',NULL),(5,4,NULL,NULL),(6,20,'test subject aka Issue Summary',NULL),(6,22,NULL,2),(7,20,'test subject aka Issue Summary',NULL),(7,22,NULL,2),(8,20,'test subject aka Issue Summary',NULL),(8,22,NULL,2),(9,20,'test subject aka Issue Summary',NULL),(9,22,NULL,2),(10,3,'5435343453',NULL),(10,4,'Test',NULL),(11,3,'3322769257',NULL),(11,4,NULL,NULL),(12,3,'3322769257X0101',NULL),(12,4,NULL,NULL),(13,3,'3322769257X92',NULL),(13,4,NULL,NULL);

/*Table structure for table `ost_form_field` */

DROP TABLE IF EXISTS `ost_form_field`;

CREATE TABLE `ost_form_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) unsigned NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `label` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `edit_mask` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `configuration` text,
  `sort` int(11) unsigned NOT NULL,
  `hint` varchar(512) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `ost_form_field` */

insert  into `ost_form_field`(`id`,`form_id`,`type`,`label`,`required`,`private`,`edit_mask`,`name`,`configuration`,`sort`,`hint`,`created`,`updated`) values (1,1,'text','Email Address',1,0,15,'email','{\"size\":40,\"length\":64,\"validator\":\"email\"}',1,NULL,'2015-10-12 13:33:41','2015-10-12 13:33:41'),(2,1,'text','Full Name',1,0,15,'name','{\"size\":40,\"length\":64}',2,NULL,'2015-10-12 13:33:41','2015-10-12 13:33:41'),(3,1,'phone','Phone Number',0,0,0,'phone',NULL,3,NULL,'2015-10-12 13:33:41','2015-10-12 13:33:41'),(4,1,'memo','Internal Notes',0,1,0,'notes','{\"rows\":4,\"cols\":40}',4,NULL,'2015-10-12 13:33:41','2015-10-12 13:33:41'),(20,2,'text','Issue Summary',1,0,15,'subject','{\"size\":40,\"length\":50}',1,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(21,2,'thread','Issue Details',1,0,15,'message',NULL,2,'Details on the reason(s) for opening the ticket.','2015-10-12 13:33:42','2015-10-12 13:33:42'),(22,2,'priority','Priority Level',0,0,3,'priority','{\"prompt\":\"\",\"default\":\"\"}',3,NULL,'2015-10-12 13:33:42','2015-10-12 19:16:31'),(23,3,'text','Company Name',1,0,3,'name','{\"size\":40,\"length\":64}',1,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(24,3,'text','Website',0,0,0,'website','{\"size\":40,\"length\":64}',2,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(25,3,'phone','Phone Number',0,0,0,'phone','{\"ext\":false}',3,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(26,3,'memo','Address',0,0,0,'address','{\"rows\":2,\"cols\":40,\"html\":false,\"length\":100}',4,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(27,4,'text','Name',1,0,15,'name','{\"size\":40,\"length\":64}',1,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(28,4,'memo','Address',0,0,0,'address','{\"rows\":2,\"cols\":40,\"length\":100,\"html\":false}',2,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(29,4,'phone','Phone',0,0,0,'phone',NULL,3,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(30,4,'text','Website',0,0,0,'website','{\"size\":40,\"length\":0}',4,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(31,4,'memo','Internal Notes',0,0,0,'notes','{\"rows\":4,\"cols\":40}',5,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(32,5,'state','State',1,0,63,'state','{\"prompt\":\"State of a ticket\"}',1,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(33,5,'memo','Description',0,0,15,'description','{\"rows\":2,\"cols\":40,\"html\":false,\"length\":100}',3,NULL,'2015-10-12 13:33:42','2015-10-12 13:33:42'),(34,0,'datetime','Date Time',0,0,0,'','{\"time\":false,\"gmt\":false,\"min\":null,\"max\":null,\"future\":true}',4,NULL,'2015-10-12 19:32:08','2015-10-12 19:33:59'),(35,6,'bool','Gender',0,0,0,'gender',NULL,1,NULL,'2015-10-12 19:36:18','2015-10-13 14:30:49'),(36,0,'datetime','Date Time',0,0,0,'datetime',NULL,4,NULL,'2015-10-13 13:20:47','2015-10-13 13:33:23');

/*Table structure for table `ost_group_dept_access` */

DROP TABLE IF EXISTS `ost_group_dept_access`;

CREATE TABLE `ost_group_dept_access` (
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `group_dept` (`group_id`,`dept_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_group_dept_access` */

insert  into `ost_group_dept_access`(`group_id`,`dept_id`) values (1,1),(2,1),(3,1),(1,2),(2,2),(3,2),(1,3),(2,3),(3,3);

/*Table structure for table `ost_groups` */

DROP TABLE IF EXISTS `ost_groups`;

CREATE TABLE `ost_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `group_name` varchar(50) NOT NULL DEFAULT '',
  `can_create_tickets` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `can_edit_tickets` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `can_post_ticket_reply` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `can_delete_tickets` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_close_tickets` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `can_assign_tickets` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `can_transfer_tickets` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `can_ban_emails` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_manage_premade` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_manage_faq` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_view_staff_stats` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `group_active` (`group_enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `ost_groups` */

insert  into `ost_groups`(`group_id`,`group_enabled`,`group_name`,`can_create_tickets`,`can_edit_tickets`,`can_post_ticket_reply`,`can_delete_tickets`,`can_close_tickets`,`can_assign_tickets`,`can_transfer_tickets`,`can_ban_emails`,`can_manage_premade`,`can_manage_faq`,`can_view_staff_stats`,`notes`,`created`,`updated`) values (1,1,'Lion Tamers',1,1,1,1,1,1,1,1,1,1,0,'System overlords. These folks (initially) have full control to all the departments they have access to.','2015-10-12 13:33:44','2015-10-12 13:33:44'),(2,1,'Elephant Walkers',1,1,1,1,1,1,1,1,1,1,0,'Inhabitants of the ivory tower','2015-10-12 13:33:44','2015-10-12 13:33:44'),(3,1,'Flea Trainers',1,1,1,0,1,1,1,0,0,0,0,'Lowly staff members','2015-10-12 13:33:44','2015-10-12 13:33:44');

/*Table structure for table `ost_help_topic` */

DROP TABLE IF EXISTS `ost_help_topic`;

CREATE TABLE `ost_help_topic` (
  `topic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ispublic` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `noautoresp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `flags` int(10) unsigned DEFAULT '0',
  `status_id` int(10) unsigned NOT NULL DEFAULT '0',
  `priority_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `team_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sla_id` int(10) unsigned NOT NULL DEFAULT '0',
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `form_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sequence_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `topic` varchar(32) NOT NULL DEFAULT '',
  `number_format` varchar(32) DEFAULT NULL,
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`topic_id`),
  UNIQUE KEY `topic` (`topic`,`topic_pid`),
  KEY `topic_pid` (`topic_pid`),
  KEY `priority_id` (`priority_id`),
  KEY `dept_id` (`dept_id`),
  KEY `staff_id` (`staff_id`,`team_id`),
  KEY `sla_id` (`sla_id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `ost_help_topic` */

insert  into `ost_help_topic`(`topic_id`,`topic_pid`,`isactive`,`ispublic`,`noautoresp`,`flags`,`status_id`,`priority_id`,`dept_id`,`staff_id`,`team_id`,`sla_id`,`page_id`,`form_id`,`sequence_id`,`sort`,`topic`,`number_format`,`notes`,`created`,`updated`) values (1,0,1,1,0,0,0,2,1,0,0,0,0,0,0,2,'General Inquiry','','Questions about products or services','2015-10-12 13:33:43','2015-10-12 13:33:43'),(2,0,1,1,0,0,0,1,1,0,0,0,0,0,0,1,'Feedback','','Tickets that primarily concern the sales and billing departments','2015-10-12 13:33:43','2015-10-12 13:33:43'),(10,0,1,1,0,0,0,2,1,0,0,0,0,0,0,3,'Report a Problem','','Product, service, or equipment related issues','2015-10-12 13:33:43','2015-10-12 13:33:43'),(11,10,1,1,0,0,0,3,1,0,0,1,0,0,0,4,'Access Issue','','Report an inability access a physical or virtual asset','2015-10-12 13:33:43','2015-10-12 13:33:43');

/*Table structure for table `ost_list` */

DROP TABLE IF EXISTS `ost_list`;

CREATE TABLE `ost_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_plural` varchar(255) DEFAULT NULL,
  `sort_mode` enum('Alpha','-Alpha','SortCol') NOT NULL DEFAULT 'Alpha',
  `masks` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(16) DEFAULT NULL,
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ost_list` */

insert  into `ost_list`(`id`,`name`,`name_plural`,`sort_mode`,`masks`,`type`,`notes`,`created`,`updated`) values (1,'Ticket Status','Ticket Statuses','SortCol',13,'ticket-status','Ticket statuses','2015-10-12 13:33:42','2015-10-12 13:33:42');

/*Table structure for table `ost_list_items` */

DROP TABLE IF EXISTS `ost_list_items`;

CREATE TABLE `ost_list_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` int(11) DEFAULT NULL,
  `status` int(11) unsigned NOT NULL DEFAULT '1',
  `value` varchar(255) NOT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '1',
  `properties` text,
  PRIMARY KEY (`id`),
  KEY `list_item_lookup` (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_list_items` */

/*Table structure for table `ost_note` */

DROP TABLE IF EXISTS `ost_note`;

CREATE TABLE `ost_note` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned DEFAULT NULL,
  `staff_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ext_id` varchar(10) DEFAULT NULL,
  `body` text,
  `status` int(11) unsigned NOT NULL DEFAULT '0',
  `sort` int(11) unsigned NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ext_id` (`ext_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_note` */

/*Table structure for table `ost_organization` */

DROP TABLE IF EXISTS `ost_organization`;

CREATE TABLE `ost_organization` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `manager` varchar(16) NOT NULL DEFAULT '',
  `status` int(11) unsigned NOT NULL DEFAULT '0',
  `domain` varchar(256) NOT NULL DEFAULT '',
  `extra` text,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ost_organization` */

insert  into `ost_organization`(`id`,`name`,`manager`,`status`,`domain`,`extra`,`created`,`updated`) values (1,'osTicket','',0,'',NULL,'2015-10-12 13:33:43',NULL);

/*Table structure for table `ost_plugin` */

DROP TABLE IF EXISTS `ost_plugin`;

CREATE TABLE `ost_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `install_path` varchar(60) NOT NULL,
  `isphar` tinyint(1) NOT NULL DEFAULT '0',
  `isactive` tinyint(1) NOT NULL DEFAULT '0',
  `version` varchar(64) DEFAULT NULL,
  `installed` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_plugin` */

/*Table structure for table `ost_sequence` */

DROP TABLE IF EXISTS `ost_sequence`;

CREATE TABLE `ost_sequence` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `flags` int(10) unsigned DEFAULT NULL,
  `next` bigint(20) unsigned NOT NULL DEFAULT '1',
  `increment` int(11) DEFAULT '1',
  `padding` char(1) DEFAULT '0',
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ost_sequence` */

insert  into `ost_sequence`(`id`,`name`,`flags`,`next`,`increment`,`padding`,`updated`) values (1,'General Tickets',1,1,1,'0','0000-00-00 00:00:00');

/*Table structure for table `ost_session` */

DROP TABLE IF EXISTS `ost_session`;

CREATE TABLE `ost_session` (
  `session_id` varchar(255) CHARACTER SET ascii NOT NULL DEFAULT '',
  `session_data` blob,
  `session_expire` datetime DEFAULT NULL,
  `session_updated` datetime DEFAULT NULL,
  `user_id` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'osTicket staff/client ID',
  `user_ip` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `updated` (`session_updated`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ost_session` */

insert  into `ost_session`(`session_id`,`session_data`,`session_expire`,`session_updated`,`user_id`,`user_ip`,`user_agent`) values ('0poattlc5c929aonapqdj5ubr6','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"c681205492e2acabf906883c2562e5d1b9352291\";s:4:\"time\";i:1444725436;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:30:\"/osticket/scp/apikeys.php?id=1\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"7c2079e4612267c550fc0f2bb664d70b:1444725435:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";cfg:list.1|a:0:{}lastcroncall|i:1444725436;::Q|s:4:\"open\";search_14d8edbcd9a8bd7e4d842e77cb9e8817|s:2071:\"SELECT ticket.ticket_id,tlock.lock_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id  ,user.name ,email.address as email, dept.dept_name, status.state  ,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.created  ,IF(ticket.duedate IS NULL,IF(sla.id IS NULL, NULL, DATE_ADD(ticket.created, INTERVAL sla.grace_period HOUR)), ticket.duedate) as duedate  ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.closed, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date  ,ticket.created as ticket_created, CONCAT_WS(\" \", staff.firstname, staff.lastname) as staff, team.name as team  ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(\" \", staff.lastname, staff.firstname)) as assigned  ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(\" / \", ptopic.topic, topic.topic)) as helptopic  ,cdata.priority as priority_id, cdata.subject, pri.priority_desc, pri.priority_color  FROM ost_ticket ticket  LEFT JOIN ost_ticket_status status\n            ON (status.id = ticket.status_id)  LEFT JOIN ost_user user ON user.id = ticket.user_id LEFT JOIN ost_user_email email ON user.id = email.user_id LEFT JOIN ost_department dept ON ticket.dept_id=dept.dept_id  LEFT JOIN ost_ticket_lock tlock ON (ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW()\n               AND tlock.staff_id!=1)  LEFT JOIN ost_staff staff ON (ticket.staff_id=staff.staff_id)  LEFT JOIN ost_team team ON (ticket.team_id=team.team_id)  LEFT JOIN ost_sla sla ON (ticket.sla_id=sla.id AND sla.isactive=1)  LEFT JOIN ost_help_topic topic ON (ticket.topic_id=topic.topic_id)  LEFT JOIN ost_help_topic ptopic ON (ptopic.topic_id=topic.topic_pid)  LEFT JOIN ost_ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id)  LEFT JOIN ost_ticket_priority pri ON (pri.priority_id = cdata.priority)  WHERE (   ( ticket.staff_id=1 AND status.state=\"open\")  OR ticket.dept_id IN (1,2,3) ) AND status.state IN (\n                \'open\' )  AND ticket.isanswered=0  ORDER BY pri.priority_urgency ASC, effective_date DESC, ticket.created DESC LIMIT 0,25\";cfg:dept.1|a:0:{}','2015-10-14 13:37:16','2015-10-13 13:37:16','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('1pe0lhf0famot5ffb9gjn8p3s7','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"3a139448f00cff6f38e66f8f0f406183d9712bd5\";s:4:\"time\";i:1444660820;}TZ_OFFSET|s:3:\"5.0\";TZ_DST|s:1:\"0\";cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:22:\"/osticket/scp/logs.php\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"1d7f65dcb001720e29b9be37c91cdf12:1444660796:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";cfg:list.1|a:0:{}lastcroncall|i:1444660582;cfg:dept.1|a:0:{}','2015-10-13 19:40:20','2015-10-12 19:40:20','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('5n3dl7ad3pe5euahgel3asu4e7','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"f645dec7d2efa8a9be4e36ad2da6edbe1111c236\";s:4:\"time\";i:1444718145;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}cfg:list.1|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:14:\"/osticket/scp/\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"6a46160a2564f5300def9a5324843eb5:1444718145:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";::Q|s:4:\"open\";search_14d8edbcd9a8bd7e4d842e77cb9e8817|s:2071:\"SELECT ticket.ticket_id,tlock.lock_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id  ,user.name ,email.address as email, dept.dept_name, status.state  ,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.created  ,IF(ticket.duedate IS NULL,IF(sla.id IS NULL, NULL, DATE_ADD(ticket.created, INTERVAL sla.grace_period HOUR)), ticket.duedate) as duedate  ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.closed, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date  ,ticket.created as ticket_created, CONCAT_WS(\" \", staff.firstname, staff.lastname) as staff, team.name as team  ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(\" \", staff.lastname, staff.firstname)) as assigned  ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(\" / \", ptopic.topic, topic.topic)) as helptopic  ,cdata.priority as priority_id, cdata.subject, pri.priority_desc, pri.priority_color  FROM ost_ticket ticket  LEFT JOIN ost_ticket_status status\n            ON (status.id = ticket.status_id)  LEFT JOIN ost_user user ON user.id = ticket.user_id LEFT JOIN ost_user_email email ON user.id = email.user_id LEFT JOIN ost_department dept ON ticket.dept_id=dept.dept_id  LEFT JOIN ost_ticket_lock tlock ON (ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW()\n               AND tlock.staff_id!=1)  LEFT JOIN ost_staff staff ON (ticket.staff_id=staff.staff_id)  LEFT JOIN ost_team team ON (ticket.team_id=team.team_id)  LEFT JOIN ost_sla sla ON (ticket.sla_id=sla.id AND sla.isactive=1)  LEFT JOIN ost_help_topic topic ON (ticket.topic_id=topic.topic_id)  LEFT JOIN ost_help_topic ptopic ON (ptopic.topic_id=topic.topic_pid)  LEFT JOIN ost_ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id)  LEFT JOIN ost_ticket_priority pri ON (pri.priority_id = cdata.priority)  WHERE (   ( ticket.staff_id=1 AND status.state=\"open\")  OR ticket.dept_id IN (1,2,3) ) AND status.state IN (\n                \'open\' )  AND ticket.isanswered=0  ORDER BY pri.priority_urgency ASC, effective_date DESC, ticket.created DESC LIMIT 0,25\";lastcroncall|i:1444716892;cfg:dept.1|a:0:{}','2015-10-14 11:35:45','2015-10-13 11:35:45','1','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('dp6am3gpr5j6l4d9au4klf3577','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"8f455b30b78e1a11b1fb3235f06adf5541f4b7e4\";s:4:\"time\";i:1444728765;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:28:\"/osticket/scp/forms.php?id=6\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"b992e94baac3cedbe541c5124069415e:1444728741:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";cfg:list.1|a:0:{}lastcroncall|i:1444728742;cfg:dept.1|a:0:{}::Q|s:4:\"open\";search_14d8edbcd9a8bd7e4d842e77cb9e8817|s:2071:\"SELECT ticket.ticket_id,tlock.lock_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id  ,user.name ,email.address as email, dept.dept_name, status.state  ,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.created  ,IF(ticket.duedate IS NULL,IF(sla.id IS NULL, NULL, DATE_ADD(ticket.created, INTERVAL sla.grace_period HOUR)), ticket.duedate) as duedate  ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.closed, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date  ,ticket.created as ticket_created, CONCAT_WS(\" \", staff.firstname, staff.lastname) as staff, team.name as team  ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(\" \", staff.lastname, staff.firstname)) as assigned  ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(\" / \", ptopic.topic, topic.topic)) as helptopic  ,cdata.priority as priority_id, cdata.subject, pri.priority_desc, pri.priority_color  FROM ost_ticket ticket  LEFT JOIN ost_ticket_status status\n            ON (status.id = ticket.status_id)  LEFT JOIN ost_user user ON user.id = ticket.user_id LEFT JOIN ost_user_email email ON user.id = email.user_id LEFT JOIN ost_department dept ON ticket.dept_id=dept.dept_id  LEFT JOIN ost_ticket_lock tlock ON (ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW()\n               AND tlock.staff_id!=1)  LEFT JOIN ost_staff staff ON (ticket.staff_id=staff.staff_id)  LEFT JOIN ost_team team ON (ticket.team_id=team.team_id)  LEFT JOIN ost_sla sla ON (ticket.sla_id=sla.id AND sla.isactive=1)  LEFT JOIN ost_help_topic topic ON (ticket.topic_id=topic.topic_id)  LEFT JOIN ost_help_topic ptopic ON (ptopic.topic_id=topic.topic_pid)  LEFT JOIN ost_ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id)  LEFT JOIN ost_ticket_priority pri ON (pri.priority_id = cdata.priority)  WHERE (   ( ticket.staff_id=1 AND status.state=\"open\")  OR ticket.dept_id IN (1,2,3) ) AND status.state IN (\n                \'open\' )  AND ticket.isanswered=0  ORDER BY pri.priority_urgency ASC, effective_date DESC, ticket.created DESC LIMIT 0,25\";','2015-10-14 14:32:45','2015-10-13 14:32:45','1','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('lo7lj7m650ga7o2vd7n434tdh6','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"8ef5b509cee75fc406ba44cf5fbf6bc9ca2a0029\";s:4:\"time\";i:1444742065;}TZ_OFFSET|s:3:\"5.0\";TZ_DST|s:1:\"0\";cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:1:{s:4:\"dest\";s:27:\"/osticket/scp/dashboard.php\";}}_auth|a:2:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}s:4:\"user\";a:1:{s:7:\"strikes\";i:1;}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"85c74de8bb75963d3074f028928a26c6:1444740881:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";cfg:list.1|a:0:{}orgs_qs_180d0b948d6d46c8d9f1a7524ef0e9d5|s:578:\"SELECT org.*\n            ,COALESCE(team.name,\n                    IF(staff.staff_id, CONCAT_WS(\" \", staff.firstname, staff.lastname), NULL)\n                    ) as account_manager , count(DISTINCT user.id) as users  FROM ost_organization org LEFT JOIN ost_staff staff ON (\n           LEFT(org.manager, 1) = \"s\" AND staff.staff_id = SUBSTR(org.manager, 2)) LEFT JOIN ost_team team ON (\n           LEFT(org.manager, 1) = \"t\" AND team.team_id = SUBSTR(org.manager, 2))  LEFT JOIN ost_user user ON (user.org_id = org.id)   WHERE 1  GROUP BY org.id ORDER BY org.name ASC  LIMIT 0,25\";lastcroncall|i:1444740881;users_qs_ce746b0b7166d4b0f070e09225bd7f27|s:504:\"SELECT user.*, email.address as email, org.name as organization\n          , account.id as account_id, account.status as account_status , count(DISTINCT ticket.ticket_id) as tickets  FROM ost_user user LEFT JOIN ost_user_email email ON (user.id = email.user_id) LEFT JOIN ost_organization org ON (user.org_id = org.id) LEFT JOIN ost_user_account account ON (account.user_id = user.id)  LEFT JOIN ost_ticket ticket ON (ticket.user_id = user.id)  WHERE 1  GROUP BY user.id ORDER BY user.name ASC  LIMIT 0,25\";cfg:staff.2|a:0:{}cfg:staff.3|a:0:{}','2015-10-14 18:14:25','2015-10-13 18:14:25','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('oqhvdbubf186th3doan91vrhp6','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"2e16c6338c0039debb3ffdb1b879ae8528b1716f\";s:4:\"time\";i:1444745271;}TZ_OFFSET|s:3:\"5.0\";TZ_DST|s:1:\"0\";cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:14:\"/osticket/scp/\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:2:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}s:4:\"user\";a:1:{s:7:\"strikes\";i:1;}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"9f56624b925f7ea17e04d2501e560e1c:1444743738:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";::Q|s:4:\"open\";search_14d8edbcd9a8bd7e4d842e77cb9e8817|s:2071:\"SELECT ticket.ticket_id,tlock.lock_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id  ,user.name ,email.address as email, dept.dept_name, status.state  ,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.created  ,IF(ticket.duedate IS NULL,IF(sla.id IS NULL, NULL, DATE_ADD(ticket.created, INTERVAL sla.grace_period HOUR)), ticket.duedate) as duedate  ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.closed, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date  ,ticket.created as ticket_created, CONCAT_WS(\" \", staff.firstname, staff.lastname) as staff, team.name as team  ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(\" \", staff.lastname, staff.firstname)) as assigned  ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(\" / \", ptopic.topic, topic.topic)) as helptopic  ,cdata.priority as priority_id, cdata.subject, pri.priority_desc, pri.priority_color  FROM ost_ticket ticket  LEFT JOIN ost_ticket_status status\n            ON (status.id = ticket.status_id)  LEFT JOIN ost_user user ON user.id = ticket.user_id LEFT JOIN ost_user_email email ON user.id = email.user_id LEFT JOIN ost_department dept ON ticket.dept_id=dept.dept_id  LEFT JOIN ost_ticket_lock tlock ON (ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW()\n               AND tlock.staff_id!=1)  LEFT JOIN ost_staff staff ON (ticket.staff_id=staff.staff_id)  LEFT JOIN ost_team team ON (ticket.team_id=team.team_id)  LEFT JOIN ost_sla sla ON (ticket.sla_id=sla.id AND sla.isactive=1)  LEFT JOIN ost_help_topic topic ON (ticket.topic_id=topic.topic_id)  LEFT JOIN ost_help_topic ptopic ON (ptopic.topic_id=topic.topic_pid)  LEFT JOIN ost_ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id)  LEFT JOIN ost_ticket_priority pri ON (pri.priority_id = cdata.priority)  WHERE (   ( ticket.staff_id=1 AND status.state=\"open\")  OR ticket.dept_id IN (1,2,3) ) AND status.state IN (\n                \'open\' )  AND ticket.isanswered=0  ORDER BY pri.priority_urgency ASC, effective_date DESC, ticket.created DESC LIMIT 0,25\";cfg:list.1|a:0:{}lastcroncall|i:1444743738;client:lang|N;cfg:pwreset|a:0:{}','2015-10-14 19:08:04','2015-10-13 19:08:04','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('pn48pbd3bf88dgkmoijj3n9u55','cfg:core|a:2:{s:9:\"tz_offset\";s:4:\"-5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"6bb3dcaaa779587fecb471b3987882ba1c73d520\";s:4:\"time\";i:1444641966;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}cfg:list.1|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:26:\"/osticket/scp/settings.php\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:2:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}s:4:\"user\";N;}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"b6ce6d544ebfb9a53e7f08c4758b3ab3:1444641937:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";lastcroncall|i:1444641966;cfg:dept.1|a:0:{}::Q|s:4:\"open\";search_14d8edbcd9a8bd7e4d842e77cb9e8817|s:2071:\"SELECT ticket.ticket_id,tlock.lock_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id  ,user.name ,email.address as email, dept.dept_name, status.state  ,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.created  ,IF(ticket.duedate IS NULL,IF(sla.id IS NULL, NULL, DATE_ADD(ticket.created, INTERVAL sla.grace_period HOUR)), ticket.duedate) as duedate  ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.closed, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date  ,ticket.created as ticket_created, CONCAT_WS(\" \", staff.firstname, staff.lastname) as staff, team.name as team  ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(\" \", staff.lastname, staff.firstname)) as assigned  ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(\" / \", ptopic.topic, topic.topic)) as helptopic  ,cdata.priority as priority_id, cdata.subject, pri.priority_desc, pri.priority_color  FROM ost_ticket ticket  LEFT JOIN ost_ticket_status status\n            ON (status.id = ticket.status_id)  LEFT JOIN ost_user user ON user.id = ticket.user_id LEFT JOIN ost_user_email email ON user.id = email.user_id LEFT JOIN ost_department dept ON ticket.dept_id=dept.dept_id  LEFT JOIN ost_ticket_lock tlock ON (ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW()\n               AND tlock.staff_id!=1)  LEFT JOIN ost_staff staff ON (ticket.staff_id=staff.staff_id)  LEFT JOIN ost_team team ON (ticket.team_id=team.team_id)  LEFT JOIN ost_sla sla ON (ticket.sla_id=sla.id AND sla.isactive=1)  LEFT JOIN ost_help_topic topic ON (ticket.topic_id=topic.topic_id)  LEFT JOIN ost_help_topic ptopic ON (ptopic.topic_id=topic.topic_pid)  LEFT JOIN ost_ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id)  LEFT JOIN ost_ticket_priority pri ON (pri.priority_id = cdata.priority)  WHERE (   ( ticket.staff_id=1 AND status.state=\"open\")  OR ticket.dept_id IN (1,2,3) ) AND status.state IN (\n                \'open\' )  AND ticket.isanswered=0  ORDER BY pri.priority_urgency ASC, effective_date DESC, ticket.created DESC LIMIT 0,25\";users_qs_ce746b0b7166d4b0f070e09225bd7f27|s:504:\"SELECT user.*, email.address as email, org.name as organization\n          , account.id as account_id, account.status as account_status , count(DISTINCT ticket.ticket_id) as tickets  FROM ost_user user LEFT JOIN ost_user_email email ON (user.id = email.user_id) LEFT JOIN ost_organization org ON (user.org_id = org.id) LEFT JOIN ost_user_account account ON (account.user_id = user.id)  LEFT JOIN ost_ticket ticket ON (ticket.user_id = user.id)  WHERE 1  GROUP BY user.id ORDER BY user.name ASC  LIMIT 0,25\";','2015-10-13 14:26:06','2015-10-12 14:26:06','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('soq780ulvrnp584362775ive87','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"74478dd5a12aa0fd3605660af8d9b65e663c2991\";s:4:\"time\";i:1444650833;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:28:\"/osticket/scp/helptopics.php\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"3e1283bcc068093b39c44d3cf950ee9d:1444650833:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";cfg:dept.1|a:0:{}cfg:list.1|a:0:{}','2015-10-13 16:53:53','2015-10-12 16:53:53','1','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('t1u5240rrv4jpe7t5jmtlfllk3','cfg:core|a:1:{s:9:\"tz_offset\";s:3:\"5.0\";}csrf|a:2:{s:5:\"token\";s:40:\"d170905110ff761c0016d914c7f6d9ff3c088296\";s:4:\"time\";i:1444652632;}TZ_OFFSET|s:3:\"5.0\";TZ_DST|s:1:\"0\";cfg:mysqlsearch|a:0:{}cfg:list.1|a:0:{}','2015-10-13 17:23:52','2015-10-12 17:23:52','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('u2r718kdvscv56jjvq1eu0e830','cfg:core|a:1:{s:9:\"tz_offset\";s:3:\"5.0\";}csrf|a:2:{s:5:\"token\";s:40:\"891d01e4bcd2a33003b61cf5440af04dc0a9a2b0\";s:4:\"time\";i:1444745792;}TZ_OFFSET|s:3:\"5.0\";TZ_DST|s:1:\"0\";cfg:mysqlsearch|a:0:{}cfg:list.1|a:0:{}','2015-10-14 19:16:32','2015-10-13 19:16:32','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36'),('vn8umfvmpit58st87befstsks2','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"d6a0606851533da8c6b57296127f1240c0d0af4b\";s:4:\"time\";i:1444645586;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:23:\"/osticket/scp/index.php\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"784f7a6a86d3b57bfd0547267ae5b553:1444645586:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";::Q|s:4:\"open\";search_14d8edbcd9a8bd7e4d842e77cb9e8817|s:2071:\"SELECT ticket.ticket_id,tlock.lock_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id  ,user.name ,email.address as email, dept.dept_name, status.state  ,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.created  ,IF(ticket.duedate IS NULL,IF(sla.id IS NULL, NULL, DATE_ADD(ticket.created, INTERVAL sla.grace_period HOUR)), ticket.duedate) as duedate  ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.closed, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date  ,ticket.created as ticket_created, CONCAT_WS(\" \", staff.firstname, staff.lastname) as staff, team.name as team  ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(\" \", staff.lastname, staff.firstname)) as assigned  ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(\" / \", ptopic.topic, topic.topic)) as helptopic  ,cdata.priority as priority_id, cdata.subject, pri.priority_desc, pri.priority_color  FROM ost_ticket ticket  LEFT JOIN ost_ticket_status status\n            ON (status.id = ticket.status_id)  LEFT JOIN ost_user user ON user.id = ticket.user_id LEFT JOIN ost_user_email email ON user.id = email.user_id LEFT JOIN ost_department dept ON ticket.dept_id=dept.dept_id  LEFT JOIN ost_ticket_lock tlock ON (ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW()\n               AND tlock.staff_id!=1)  LEFT JOIN ost_staff staff ON (ticket.staff_id=staff.staff_id)  LEFT JOIN ost_team team ON (ticket.team_id=team.team_id)  LEFT JOIN ost_sla sla ON (ticket.sla_id=sla.id AND sla.isactive=1)  LEFT JOIN ost_help_topic topic ON (ticket.topic_id=topic.topic_id)  LEFT JOIN ost_help_topic ptopic ON (ptopic.topic_id=topic.topic_pid)  LEFT JOIN ost_ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id)  LEFT JOIN ost_ticket_priority pri ON (pri.priority_id = cdata.priority)  WHERE (   ( ticket.staff_id=1 AND status.state=\"open\")  OR ticket.dept_id IN (1,2,3) ) AND status.state IN (\n                \'open\' )  AND ticket.isanswered=0  ORDER BY pri.priority_urgency ASC, effective_date DESC, ticket.created DESC LIMIT 0,25\";cfg:list.1|a:0:{}lastcroncall|i:1444645114;cfg:dept.1|a:0:{}users_qs_ce746b0b7166d4b0f070e09225bd7f27|s:504:\"SELECT user.*, email.address as email, org.name as organization\n          , account.id as account_id, account.status as account_status , count(DISTINCT ticket.ticket_id) as tickets  FROM ost_user user LEFT JOIN ost_user_email email ON (user.id = email.user_id) LEFT JOIN ost_organization org ON (user.org_id = org.id) LEFT JOIN ost_user_account account ON (account.user_id = user.id)  LEFT JOIN ost_ticket ticket ON (ticket.user_id = user.id)  WHERE 1  GROUP BY user.id ORDER BY user.name ASC  LIMIT 0,25\";','2015-10-13 15:26:26','2015-10-12 15:26:26','1','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');

/*Table structure for table `ost_sla` */

DROP TABLE IF EXISTS `ost_sla`;

CREATE TABLE `ost_sla` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_priority_escalation` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `disable_overdue_alerts` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `grace_period` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ost_sla` */

insert  into `ost_sla`(`id`,`isactive`,`enable_priority_escalation`,`disable_overdue_alerts`,`grace_period`,`name`,`notes`,`created`,`updated`) values (1,1,1,0,48,'Default SLA','','2015-10-12 13:33:41','2015-10-12 13:33:41');

/*Table structure for table `ost_staff` */

DROP TABLE IF EXISTS `ost_staff`;

CREATE TABLE `ost_staff` (
  `staff_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `timezone_id` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(32) NOT NULL DEFAULT '',
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `passwd` varchar(128) DEFAULT NULL,
  `backend` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(24) NOT NULL DEFAULT '',
  `phone_ext` varchar(6) DEFAULT NULL,
  `mobile` varchar(24) NOT NULL DEFAULT '',
  `signature` text NOT NULL,
  `notes` text,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `isvisible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `onvacation` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `assigned_only` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `show_assigned_tickets` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `daylight_saving` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `change_passwd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `max_page_size` int(11) unsigned NOT NULL DEFAULT '0',
  `auto_refresh_rate` int(10) unsigned NOT NULL DEFAULT '0',
  `default_signature_type` enum('none','mine','dept') NOT NULL DEFAULT 'none',
  `default_paper_size` enum('Letter','Legal','Ledger','A4','A3') NOT NULL DEFAULT 'Letter',
  `created` datetime NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `passwdreset` datetime DEFAULT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `username` (`username`),
  KEY `dept_id` (`dept_id`),
  KEY `issuperuser` (`isadmin`),
  KEY `group_id` (`group_id`,`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `ost_staff` */

insert  into `ost_staff`(`staff_id`,`group_id`,`dept_id`,`timezone_id`,`username`,`firstname`,`lastname`,`passwd`,`backend`,`email`,`phone`,`phone_ext`,`mobile`,`signature`,`notes`,`isactive`,`isadmin`,`isvisible`,`onvacation`,`assigned_only`,`show_assigned_tickets`,`daylight_saving`,`change_passwd`,`max_page_size`,`auto_refresh_rate`,`default_signature_type`,`default_paper_size`,`created`,`lastlogin`,`passwdreset`,`updated`) values (1,1,1,8,'admin0101','hafeez','ullah','$2a$08$cdA5iPK21vpUyn6GxS0n6.Fh7dq7pkyaxzrXZfsrLPAiNpB3Hf5/C',NULL,'hafeezullah.msc@gmail.com','',NULL,'','',NULL,1,1,1,0,0,0,0,0,25,0,'none','Letter','2015-10-12 13:33:54','2015-10-13 18:38:23',NULL,'0000-00-00 00:00:00'),(2,2,3,21,'Shoaib','Shoaib','Ahsan','$2a$08$5Oqbo3Y1pJumy6zbNO/Fs.iwc4acbDv146L8Wqxl8crPeyWEYveoW','local','hyader@convexinteractive.com','(332) 276-9257','92','(332) 276-9257','','This is test agent',1,0,1,0,0,0,0,0,0,0,'none','Letter','2015-10-13 17:52:37',NULL,NULL,'2015-10-13 17:52:37'),(3,2,3,21,'jamal','Jamal','Hyder','$2a$08$izYturbLSfo5zkIbjDZMXuPLy7G2gI2mF/9GmfpkdXnen9cLPsFCe','','jamal@convexinteractive.com','','','','','',1,0,1,0,0,0,0,1,0,0,'none','Letter','2015-10-13 17:54:41',NULL,NULL,'2015-10-13 17:54:41');

/*Table structure for table `ost_syslog` */

DROP TABLE IF EXISTS `ost_syslog`;

CREATE TABLE `ost_syslog` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` enum('Debug','Warning','Error') NOT NULL,
  `title` varchar(255) NOT NULL,
  `log` text NOT NULL,
  `logger` varchar(64) NOT NULL,
  `ip_address` varchar(64) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_type` (`log_type`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `ost_syslog` */

insert  into `ost_syslog`(`log_id`,`log_type`,`title`,`log`,`logger`,`ip_address`,`created`,`updated`) values (1,'Debug','osTicket installed!','Congratulations osTicket basic installation completed!\n\nThank you for choosing osTicket!','','::1','2015-10-12 13:33:58','2015-10-12 13:33:58'),(2,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:34:11','2015-10-13 11:34:11'),(3,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:35:50','2015-10-13 11:35:50'),(4,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:37:02','2015-10-13 11:37:02'),(5,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:40:29','2015-10-13 11:40:29'),(6,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:40:32','2015-10-13 11:40:32'),(7,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:40:32','2015-10-13 11:40:32'),(8,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:40:32','2015-10-13 11:40:32'),(9,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:40:33','2015-10-13 11:40:33'),(10,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:42:56','2015-10-13 11:42:56'),(11,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:42:58','2015-10-13 11:42:58'),(12,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:48:54','2015-10-13 11:48:54'),(13,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 11:49:45','2015-10-13 11:49:45'),(14,'Warning','API Error (401)','Valid API key required *[73D26BD41B7377DD0F721091A283D822]* ','','::1','2015-10-13 12:05:16','2015-10-13 12:05:16'),(15,'Warning','Invalid CSRF Token __CSRFToken__','Invalid CSRF token [f645dec7d2efa8a9be4e36ad2da6edbe1111c236] on http://localhost/osticket/scp/apikeys.php?id=1','','::1','2015-10-13 12:52:00','2015-10-13 12:52:00'),(16,'Warning','API Unexpected Data','gender: Unexpected data received in API request','','::1','2015-10-13 14:32:09','2015-10-13 14:32:09');

/*Table structure for table `ost_team` */

DROP TABLE IF EXISTS `ost_team`;

CREATE TABLE `ost_team` (
  `team_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(10) unsigned NOT NULL DEFAULT '0',
  `isenabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `noalerts` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(125) NOT NULL DEFAULT '',
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `name` (`name`),
  KEY `isnabled` (`isenabled`),
  KEY `lead_id` (`lead_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ost_team` */

insert  into `ost_team`(`team_id`,`lead_id`,`isenabled`,`noalerts`,`name`,`notes`,`created`,`updated`) values (1,0,1,0,'Level I Support','Tier 1 support, responsible for the initial iteraction with customers','2015-10-12 13:33:43','2015-10-12 13:33:43');

/*Table structure for table `ost_team_member` */

DROP TABLE IF EXISTS `ost_team_member`;

CREATE TABLE `ost_team_member` (
  `team_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`team_id`,`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_team_member` */

/*Table structure for table `ost_ticket` */

DROP TABLE IF EXISTS `ost_ticket`;

CREATE TABLE `ost_ticket` (
  `ticket_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(20) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_email_id` int(11) unsigned NOT NULL DEFAULT '0',
  `status_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sla_id` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `team_id` int(10) unsigned NOT NULL DEFAULT '0',
  `email_id` int(11) unsigned NOT NULL DEFAULT '0',
  `flags` int(10) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(64) NOT NULL DEFAULT '',
  `source` enum('Web','Email','Phone','API','Other') NOT NULL DEFAULT 'Other',
  `isoverdue` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isanswered` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `duedate` datetime DEFAULT NULL,
  `reopened` datetime DEFAULT NULL,
  `closed` datetime DEFAULT NULL,
  `lastmessage` datetime DEFAULT NULL,
  `lastresponse` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `user_id` (`user_id`),
  KEY `dept_id` (`dept_id`),
  KEY `staff_id` (`staff_id`),
  KEY `team_id` (`team_id`),
  KEY `status_id` (`status_id`),
  KEY `created` (`created`),
  KEY `closed` (`closed`),
  KEY `duedate` (`duedate`),
  KEY `topic_id` (`topic_id`),
  KEY `sla_id` (`sla_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket` */

insert  into `ost_ticket`(`ticket_id`,`number`,`user_id`,`user_email_id`,`status_id`,`dept_id`,`sla_id`,`topic_id`,`staff_id`,`team_id`,`email_id`,`flags`,`ip_address`,`source`,`isoverdue`,`isanswered`,`duedate`,`reopened`,`closed`,`lastmessage`,`lastresponse`,`created`,`updated`) values (1,'200787',1,0,1,1,1,1,0,0,0,0,'::1','Web',0,0,NULL,NULL,NULL,'2015-10-12 13:33:57',NULL,'2015-10-12 13:33:57','2015-10-12 13:33:57'),(2,'789251',2,0,1,1,1,1,0,0,0,0,'::1','API',0,0,NULL,NULL,NULL,'2015-10-13 13:16:28',NULL,'2015-10-13 13:16:28','2015-10-13 13:16:28'),(3,'153823',2,0,1,1,1,1,0,0,0,0,'::1','API',0,0,NULL,NULL,NULL,'2015-10-13 13:24:37',NULL,'2015-10-13 13:24:37','2015-10-13 13:24:38'),(4,'882134',2,0,1,1,1,1,0,0,0,0,'::1','API',0,0,NULL,NULL,NULL,'2015-10-13 13:31:09',NULL,'2015-10-13 13:31:09','2015-10-13 13:31:10'),(5,'394452',2,0,1,1,1,1,0,0,0,0,'::1','API',0,0,NULL,NULL,NULL,'2015-10-13 14:32:09',NULL,'2015-10-13 14:32:09','2015-10-13 14:32:09');

/*Table structure for table `ost_ticket__cdata` */

DROP TABLE IF EXISTS `ost_ticket__cdata`;

CREATE TABLE `ost_ticket__cdata` (
  `ticket_id` int(11) unsigned NOT NULL DEFAULT '0',
  `subject` mediumtext,
  `priority` mediumtext,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket__cdata` */

insert  into `ost_ticket__cdata`(`ticket_id`,`subject`,`priority`) values (1,'osTicket Installed!','2'),(2,'test subject aka Issue Summary','2'),(3,'test subject aka Issue Summary','2'),(4,'test subject aka Issue Summary','2'),(5,'test subject aka Issue Summary','2');

/*Table structure for table `ost_ticket_attachment` */

DROP TABLE IF EXISTS `ost_ticket_attachment`;

CREATE TABLE `ost_ticket_attachment` (
  `attach_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) unsigned NOT NULL DEFAULT '0',
  `file_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ref_id` int(11) unsigned NOT NULL DEFAULT '0',
  `inline` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`attach_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `ref_id` (`ref_id`),
  KEY `file_id` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket_attachment` */

/*Table structure for table `ost_ticket_collaborator` */

DROP TABLE IF EXISTS `ost_ticket_collaborator`;

CREATE TABLE `ost_ticket_collaborator` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `ticket_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `role` char(1) NOT NULL DEFAULT 'M',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `collab` (`ticket_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket_collaborator` */

/*Table structure for table `ost_ticket_email_info` */

DROP TABLE IF EXISTS `ost_ticket_email_info`;

CREATE TABLE `ost_ticket_email_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) unsigned NOT NULL,
  `email_mid` varchar(255) NOT NULL,
  `headers` text,
  PRIMARY KEY (`id`),
  KEY `email_mid` (`email_mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket_email_info` */

/*Table structure for table `ost_ticket_event` */

DROP TABLE IF EXISTS `ost_ticket_event`;

CREATE TABLE `ost_ticket_event` (
  `ticket_id` int(11) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(11) unsigned NOT NULL,
  `team_id` int(11) unsigned NOT NULL,
  `dept_id` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `state` enum('created','closed','reopened','assigned','transferred','overdue') NOT NULL,
  `staff` varchar(255) NOT NULL DEFAULT 'SYSTEM',
  `annulled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `timestamp` datetime NOT NULL,
  KEY `ticket_state` (`ticket_id`,`state`,`timestamp`),
  KEY `ticket_stats` (`timestamp`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket_event` */

insert  into `ost_ticket_event`(`ticket_id`,`staff_id`,`team_id`,`dept_id`,`topic_id`,`state`,`staff`,`annulled`,`timestamp`) values (1,0,0,1,1,'created','SYSTEM',0,'2015-10-12 13:33:57'),(2,0,0,1,1,'created','SYSTEM',0,'2015-10-13 13:16:29'),(3,0,0,1,1,'created','SYSTEM',0,'2015-10-13 13:24:39'),(4,0,0,1,1,'created','SYSTEM',0,'2015-10-13 13:31:10'),(5,0,0,1,1,'created','SYSTEM',0,'2015-10-13 14:32:10');

/*Table structure for table `ost_ticket_lock` */

DROP TABLE IF EXISTS `ost_ticket_lock`;

CREATE TABLE `ost_ticket_lock` (
  `lock_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `expire` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`lock_id`),
  UNIQUE KEY `ticket_id` (`ticket_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket_lock` */

/*Table structure for table `ost_ticket_priority` */

DROP TABLE IF EXISTS `ost_ticket_priority`;

CREATE TABLE `ost_ticket_priority` (
  `priority_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `priority` varchar(60) NOT NULL DEFAULT '',
  `priority_desc` varchar(30) NOT NULL DEFAULT '',
  `priority_color` varchar(7) NOT NULL DEFAULT '',
  `priority_urgency` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ispublic` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`priority_id`),
  UNIQUE KEY `priority` (`priority`),
  KEY `priority_urgency` (`priority_urgency`),
  KEY `ispublic` (`ispublic`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket_priority` */

insert  into `ost_ticket_priority`(`priority_id`,`priority`,`priority_desc`,`priority_color`,`priority_urgency`,`ispublic`) values (1,'low','Low','#DDFFDD',4,1),(2,'normal','Normal','#FFFFF0',3,1),(3,'high','High','#FEE7E7',2,1),(4,'emergency','Emergency','#FEE7E7',1,1);

/*Table structure for table `ost_ticket_status` */

DROP TABLE IF EXISTS `ost_ticket_status`;

CREATE TABLE `ost_ticket_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `state` varchar(16) DEFAULT NULL,
  `mode` int(11) unsigned NOT NULL DEFAULT '0',
  `flags` int(11) unsigned NOT NULL DEFAULT '0',
  `sort` int(11) unsigned NOT NULL DEFAULT '0',
  `properties` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `state` (`state`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket_status` */

insert  into `ost_ticket_status`(`id`,`name`,`state`,`mode`,`flags`,`sort`,`properties`,`created`,`updated`) values (1,'Open','open',3,0,1,'{\"description\":\"Open tickets.\"}','2015-10-12 13:33:43','0000-00-00 00:00:00'),(2,'Resolved','closed',1,0,2,'{\"allowreopen\":true,\"reopenstatus\":0,\"description\":\"Resolved tickets\"}','2015-10-12 13:33:43','0000-00-00 00:00:00'),(3,'Closed','closed',3,0,3,'{\"allowreopen\":true,\"reopenstatus\":0,\"description\":\"Closed tickets. Tickets will still be accessible on client and staff panels.\"}','2015-10-12 13:33:44','0000-00-00 00:00:00'),(4,'Archived','archived',3,0,4,'{\"description\":\"Tickets only adminstratively available but no longer accessible on ticket queues and client panel.\"}','2015-10-12 13:33:44','0000-00-00 00:00:00'),(5,'Deleted','deleted',3,0,5,'{\"description\":\"Tickets queued for deletion. Not accessible on ticket queues.\"}','2015-10-12 13:33:44','0000-00-00 00:00:00');

/*Table structure for table `ost_ticket_thread` */

DROP TABLE IF EXISTS `ost_ticket_thread`;

CREATE TABLE `ost_ticket_thread` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `ticket_id` int(11) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `thread_type` enum('M','R','N') NOT NULL,
  `poster` varchar(128) NOT NULL DEFAULT '',
  `source` varchar(32) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `body` mediumtext NOT NULL,
  `format` varchar(16) NOT NULL DEFAULT 'html',
  `ip_address` varchar(64) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `staff_id` (`staff_id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `ost_ticket_thread` */

insert  into `ost_ticket_thread`(`id`,`pid`,`ticket_id`,`staff_id`,`user_id`,`thread_type`,`poster`,`source`,`title`,`body`,`format`,`ip_address`,`created`,`updated`) values (1,0,1,0,1,'M','osTicket Support','Web','osTicket Installed!',' <p> Thank you for choosing osTicket. </p> <p> Please make sure you join the <a href=\"http://osticket.com/forums\">osTicket forums</a> and our <a href=\"http://osticket.com/updates\">mailing list</a> to stay up to date on the latest news, security alerts and updates. The osTicket forums are also a great place to get assistance, guidance, tips, and help from other osTicket users. In addition to the forums, the osTicket wiki provides a useful collection of educational materials, documentation, and notes from the community. We welcome your contributions to the osTicket community. </p> <p> If you are looking for a greater level of support, we provide professional services and commercial support with guaranteed response times, and access to the core development team. We can also help customize osTicket or even add new features to the system to meet your unique needs. </p> <p> If the idea of managing and upgrading this osTicket installation is daunting, you can try osTicket as a hosted service at <a href=\"http://www.supportsystem.com\">http://www.supportsystem.com/</a> -- no installation required and we can import your data! With SupportSystem\'s turnkey infrastructure, you get osTicket at its best, leaving you free to focus on your customers without the burden of making sure the application is stable, maintained, and secure. </p> <p> Cheers, </p> <p> -<br /> osTicket Team http://osticket.com/ </p> <p> <strong>PS.</strong> Don\'t just make customers happy, make happy customers! </p> ','html','::1','2015-10-12 13:33:57','0000-00-00 00:00:00'),(2,0,2,0,2,'M','Hafeez','API','test subject aka Issue Summary','test ticket body, aka Issue Details','text','::1','2015-10-13 13:16:28','0000-00-00 00:00:00'),(3,0,3,0,2,'M','Hafeez','API','test subject aka Issue Summary','test ticket body, aka Issue Details','text','::1','2015-10-13 13:24:38','0000-00-00 00:00:00'),(4,0,4,0,2,'M','Hafeez','API','test subject aka Issue Summary','test ticket body, aka Issue Details','text','::1','2015-10-13 13:31:09','0000-00-00 00:00:00'),(5,0,4,0,0,'N','SYSTEM','','File Import Error','file.txt: Unable to save file','html','::1','2015-10-13 13:31:09','0000-00-00 00:00:00'),(6,0,5,0,2,'M','Hafeez','API','test subject aka Issue Summary','test ticket body, aka Issue Details','text','::1','2015-10-13 14:32:09','0000-00-00 00:00:00'),(7,0,5,0,0,'N','SYSTEM','','File Import Error','file.txt: Unable to save file','html','::1','2015-10-13 14:32:09','0000-00-00 00:00:00');

/*Table structure for table `ost_timezone` */

DROP TABLE IF EXISTS `ost_timezone`;

CREATE TABLE `ost_timezone` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `offset` float(3,1) NOT NULL DEFAULT '0.0',
  `timezone` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `ost_timezone` */

insert  into `ost_timezone`(`id`,`offset`,`timezone`) values (1,-12.0,'Eniwetok, Kwajalein'),(2,-11.0,'Midway Island, Samoa'),(3,-10.0,'Hawaii'),(4,-9.0,'Alaska'),(5,-8.0,'Pacific Time (US & Canada)'),(6,-7.0,'Mountain Time (US & Canada)'),(7,-6.0,'Central Time (US & Canada), Mexico City'),(8,-5.0,'Eastern Time (US & Canada), Bogota, Lima'),(9,-4.0,'Atlantic Time (Canada), Caracas, La Paz'),(10,-3.5,'Newfoundland'),(11,-3.0,'Brazil, Buenos Aires, Georgetown'),(12,-2.0,'Mid-Atlantic'),(13,-1.0,'Azores, Cape Verde Islands'),(14,0.0,'Western Europe Time, London, Lisbon, Casablanca'),(15,1.0,'Brussels, Copenhagen, Madrid, Paris'),(16,2.0,'Kaliningrad, South Africa'),(17,3.0,'Baghdad, Riyadh, Moscow, St. Petersburg'),(18,3.5,'Tehran'),(19,4.0,'Abu Dhabi, Muscat, Baku, Tbilisi'),(20,4.5,'Kabul'),(21,5.0,'Ekaterinburg, Islamabad, Karachi, Tashkent'),(22,5.5,'Bombay, Calcutta, Madras, New Delhi'),(23,6.0,'Almaty, Dhaka, Colombo'),(24,7.0,'Bangkok, Hanoi, Jakarta'),(25,8.0,'Beijing, Perth, Singapore, Hong Kong'),(26,9.0,'Tokyo, Seoul, Osaka, Sapporo, Yakutsk'),(27,9.5,'Adelaide, Darwin'),(28,10.0,'Eastern Australia, Guam, Vladivostok'),(29,11.0,'Magadan, Solomon Islands, New Caledonia'),(30,12.0,'Auckland, Wellington, Fiji, Kamchatka');

/*Table structure for table `ost_user` */

DROP TABLE IF EXISTS `ost_user`;

CREATE TABLE `ost_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(10) unsigned NOT NULL,
  `default_email_id` int(10) NOT NULL,
  `status` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `org_id` (`org_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `ost_user` */

insert  into `ost_user`(`id`,`org_id`,`default_email_id`,`status`,`name`,`created`,`updated`) values (1,1,1,0,'osTicket Support','2015-10-12 13:33:56','2015-10-12 13:33:58'),(2,0,2,0,'Hafeez','2015-10-13 13:16:27','2015-10-13 13:16:27'),(3,0,3,0,'Hyder','2015-10-13 17:39:39','2015-10-13 17:39:39'),(5,0,5,0,'Junaid','2015-10-13 18:52:21','2015-10-13 18:52:21'),(6,0,6,0,'hameed','2015-10-13 19:08:03','2015-10-13 19:08:03');

/*Table structure for table `ost_user_account` */

DROP TABLE IF EXISTS `ost_user_account`;

CREATE TABLE `ost_user_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `status` int(11) unsigned NOT NULL DEFAULT '0',
  `timezone_id` int(11) NOT NULL DEFAULT '0',
  `dst` tinyint(1) NOT NULL DEFAULT '1',
  `lang` varchar(16) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `passwd` varchar(128) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
  `backend` varchar(32) DEFAULT NULL,
  `registered` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ost_user_account` */

insert  into `ost_user_account`(`id`,`user_id`,`status`,`timezone_id`,`dst`,`lang`,`username`,`passwd`,`backend`,`registered`) values (1,5,0,21,1,NULL,NULL,'$2a$08$9ZyMRuIuIU/WTw6zgs/J2O9sQ240jxARfdToo2mcRwfmDn.peKb76',NULL,'2015-10-13 18:52:22'),(2,6,0,21,1,NULL,NULL,'$2a$08$Bz7AlnPEsxYEGzKJSg1ip.2gJQuIq2XtpfcwON.HDq6hmdbdnbGFG',NULL,'2015-10-13 19:08:04');

/*Table structure for table `ost_user_email` */

DROP TABLE IF EXISTS `ost_user_email`;

CREATE TABLE `ost_user_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `address` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address` (`address`),
  KEY `user_email_lookup` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `ost_user_email` */

insert  into `ost_user_email`(`id`,`user_id`,`address`) values (1,1,'support@osticket.com'),(2,2,'hafeez@gmail.com'),(3,3,'hyder@convexinteractive.com'),(5,5,'junaid@gmail.com'),(6,6,'hameed@gmail.com');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
