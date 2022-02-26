/*Table structure for table `cit__search` */


CREATE TABLE `cit__search` (
  `object_type` varchar(8) NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  `title` text,
  `content` text,
  PRIMARY KEY (`object_type`,`object_id`),
  FULLTEXT KEY `search` (`title`,`content`)
) ENGINE=MyISAM; DEFAULT CHARSET=utf8;

/*Data for the table `cit__search` */

insert  into `cit__search`(`object_type`,`object_id`,`title`,`content`) values ('H',1,'Ticket Installed!','Thank you for choosing osTicket. Please make sure you join the osTicket forums and our mailing list to stay up to date on the latest news, security alerts and updates. The osTicket forums are also a great place to get assistance, guidance, tips, and help from other osTicket users. In addition to the forums, the osTicket wiki provides a useful collection of educational materials, documentation, and notes from the community. We welcome your contributions to the osTicket community. If you are looking for a greater level of support, we provide professional services and commercial support with guaranteed response times, and access to the core development team. We can also help customize osTicket or even add new features to the system to meet your unique needs. If the idea of managing and upgrading this osTicket installation is daunting, you can try osTicket as a hosted service at http://www.supportsystem.com/ -- no installation required and we can import your data! With SupportSystem\'s turnkey infrastructure, you get osTicket at its best, leaving you free to focus on your customers without the burden of making sure the application is stable, maintained, and secure. Cheers, - osTicket Team http://osticket.com/ PS. Don\'t just make customers happy, make happy customers!'),('O',1,'osTicket','420 Desoto Street\nAlexandria, LA 71301\n(318) 290-3674\nhttp://osticket.com\nNot only do we develop the software, we also use it to manage support for osTicket. Let us help you quickly implement and leverage the full potential of osTicket\'s features and functionality. Contact us for professional support or visit our website for documentation and community support.'),('T',1,'784308 osTicket Installed!',''),('U',1,'osTicket Support','support@osticket.com'),('U',2,'Javad Ahmed','hafeez@convexinteractive.com'),('U',3,'Salman','Convex interactive Pvtsalman@gmail.com'),('U',8,'Saeed','Convexsaeed@gmail.com');

/*Table structure for table `cit_api_key` */


CREATE TABLE `cit_api_key` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_api_key` */

/*Table structure for table `cit_attachment` */


CREATE TABLE `cit_attachment` (
  `object_id` int(11) unsigned NOT NULL,
  `type` char(1) NOT NULL,
  `file_id` int(11) unsigned NOT NULL,
  `inline` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`file_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_attachment` */

insert  into `cit_attachment`(`object_id`,`type`,`file_id`,`inline`) values (1,'C',2,0),(8,'T',1,1),(9,'T',1,1),(10,'T',1,1),(11,'T',1,1),(12,'T',1,1),(13,'T',1,1);

/*Table structure for table `cit_canned_response` */



CREATE TABLE `cit_canned_response` (
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

/*Data for the table `cit_canned_response` */

insert  into `cit_canned_response`(`canned_id`,`dept_id`,`isenabled`,`title`,`response`,`lang`,`notes`,`created`,`updated`) values (1,0,1,'What is osTicket (sample)?','osTicket is a widely-used open source support ticket system, an attractive alternative to higher-cost and complex customer support systems - simple, lightweight, reliable, open source, web-based and easy to setup and use.','en_US','','2015-10-19 11:40:17','2015-10-19 11:40:17'),(2,0,1,'Sample (with variables)','Hi %{ticket.name.first}, <br /><br /> Your ticket #%{ticket.number} created on %{ticket.create_date} is in %{ticket.dept.name} department.','en_US','','2015-10-19 11:40:17','2015-10-19 11:40:17');

/*Table structure for table `cit_config` */



CREATE TABLE `cit_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `namespace` varchar(64) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `namespace` (`namespace`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

/*Data for the table `cit_config` */

insert  into `cit_config`(`id`,`namespace`,`key`,`value`,`updated`) values (1,'core','admin_email','hafeez@convexinteractive.com','2015-10-19 11:40:22'),(2,'core','helpdesk_url','http://localhost/crm/','2015-10-29 16:14:26'),(3,'core','helpdesk_title','Tickets','2015-10-19 11:40:22'),(4,'core','schema_signature','b26f29a6bb5dbb3510b057632182d138','2015-10-19 11:40:22'),(5,'dept.1','assign_members_only','','2015-10-19 11:40:06'),(6,'dept.2','assign_members_only','','2015-10-19 11:40:07'),(7,'dept.3','assign_members_only','','2015-10-19 11:40:07'),(8,'sla.1','transient','0','2015-10-19 11:40:07'),(9,'list.1','configuration','{\"handler\":\"TicketStatusList\"}','2015-10-19 11:40:09'),(10,'core','time_format','h:i A','2015-10-19 11:40:12'),(11,'core','date_format','m/d/Y','2015-10-19 11:40:12'),(12,'core','datetime_format','m/d/Y g:i a','2015-10-19 11:40:13'),(13,'core','daydatetime_format','D, M j Y g:ia','2015-10-19 11:40:13'),(14,'core','default_timezone_id','21','2015-10-29 16:16:29'),(15,'core','default_priority_id','2','2015-10-19 11:40:13'),(16,'core','enable_daylight_saving','0','2015-10-19 11:40:13'),(17,'core','reply_separator','-- reply above this line --','2015-10-19 11:40:13'),(18,'core','isonline','1','2015-10-19 11:40:13'),(19,'core','staff_ip_binding','0','2015-10-19 11:40:13'),(20,'core','staff_max_logins','4','2015-10-19 11:40:13'),(21,'core','staff_login_timeout','2','2015-10-19 11:40:13'),(22,'core','staff_session_timeout','30','2015-10-19 11:40:13'),(23,'core','passwd_reset_period','0','2015-10-19 11:40:13'),(24,'core','client_max_logins','4','2015-10-19 11:40:13'),(25,'core','client_login_timeout','2','2015-10-19 11:40:14'),(26,'core','client_session_timeout','30','2015-10-19 11:40:14'),(27,'core','max_page_size','25','2015-10-19 11:40:14'),(28,'core','max_open_tickets','0','2015-10-19 11:40:14'),(29,'core','autolock_minutes','3','2015-10-19 11:40:14'),(30,'core','default_smtp_id','0','2015-10-19 11:40:14'),(31,'core','use_email_priority','0','2015-10-19 11:40:14'),(32,'core','enable_kb','0','2015-10-19 11:40:14'),(33,'core','enable_premade','1','2015-10-19 11:40:14'),(34,'core','enable_captcha','0','2015-10-19 11:40:14'),(35,'core','enable_auto_cron','0','2015-10-19 11:40:14'),(36,'core','enable_mail_polling','0','2015-10-19 11:40:14'),(37,'core','send_sys_errors','1','2015-10-19 11:40:14'),(38,'core','send_sql_errors','1','2015-10-19 11:40:14'),(39,'core','send_login_errors','1','2015-10-19 11:40:14'),(40,'core','save_email_headers','1','2015-10-19 11:40:14'),(41,'core','strip_quoted_reply','1','2015-10-19 11:40:14'),(42,'core','ticket_autoresponder','0','2015-10-19 11:40:14'),(43,'core','message_autoresponder','0','2015-10-19 11:40:14'),(44,'core','ticket_notice_active','1','2015-10-19 11:40:14'),(45,'core','ticket_alert_active','1','2015-10-19 11:40:14'),(46,'core','ticket_alert_admin','1','2015-10-19 11:40:14'),(47,'core','ticket_alert_dept_manager','1','2015-10-19 11:40:14'),(48,'core','ticket_alert_dept_members','0','2015-10-19 11:40:14'),(49,'core','message_alert_active','1','2015-10-19 11:40:14'),(50,'core','message_alert_laststaff','1','2015-10-19 11:40:14'),(51,'core','message_alert_assigned','1','2015-10-19 11:40:14'),(52,'core','message_alert_dept_manager','0','2015-10-19 11:40:14'),(53,'core','note_alert_active','0','2015-10-19 11:40:15'),(54,'core','note_alert_laststaff','1','2015-10-19 11:40:15'),(55,'core','note_alert_assigned','1','2015-10-19 11:40:15'),(56,'core','note_alert_dept_manager','0','2015-10-19 11:40:15'),(57,'core','transfer_alert_active','0','2015-10-19 11:40:15'),(58,'core','transfer_alert_assigned','0','2015-10-19 11:40:15'),(59,'core','transfer_alert_dept_manager','1','2015-10-19 11:40:15'),(60,'core','transfer_alert_dept_members','0','2015-10-19 11:40:15'),(61,'core','overdue_alert_active','1','2015-10-19 11:40:15'),(62,'core','overdue_alert_assigned','1','2015-10-19 11:40:15'),(63,'core','overdue_alert_dept_manager','1','2015-10-19 11:40:15'),(64,'core','overdue_alert_dept_members','0','2015-10-19 11:40:15'),(65,'core','assigned_alert_active','1','2015-10-19 11:40:15'),(66,'core','assigned_alert_staff','1','2015-10-19 11:40:15'),(67,'core','assigned_alert_team_lead','0','2015-10-19 11:40:15'),(68,'core','assigned_alert_team_members','0','2015-10-19 11:40:15'),(69,'core','auto_claim_tickets','1','2015-10-19 11:40:15'),(70,'core','show_related_tickets','1','2015-10-19 11:40:15'),(71,'core','show_assigned_tickets','1','2015-10-19 11:40:15'),(72,'core','show_answered_tickets','0','2015-10-19 11:40:15'),(73,'core','hide_staff_name','0','2015-10-19 11:40:15'),(74,'core','overlimit_notice_active','0','2015-10-19 11:40:15'),(75,'core','email_attachments','1','2015-10-19 11:40:15'),(76,'core','number_format','######','2015-10-19 11:40:15'),(77,'core','sequence_id','0','2015-10-19 11:40:15'),(78,'core','log_level','2','2015-10-19 11:40:15'),(79,'core','log_graceperiod','12','2015-10-19 11:40:16'),(80,'core','client_registration','public','2015-10-19 11:40:16'),(81,'core','max_file_size','1048576','2015-10-19 11:40:16'),(82,'core','landing_page_id','1','2015-10-19 11:40:16'),(83,'core','thank-you_page_id','2','2015-10-19 11:40:16'),(84,'core','offline_page_id','3','2015-10-19 11:40:16'),(85,'core','system_language','en_US','2015-10-19 11:40:17'),(86,'mysqlsearch','reindex','0','2015-10-19 11:40:57'),(87,'core','default_email_id','1','2015-10-19 11:40:21'),(88,'core','alert_email_id','2','2015-10-19 11:40:21'),(89,'core','default_dept_id','1','2015-10-19 11:40:21'),(90,'core','default_sla_id','1','2015-10-19 11:40:21'),(91,'core','default_template_id','1','2015-10-19 11:40:21'),(92,'core','name_format','full','2015-10-29 16:14:26');

/*Table structure for table `cit_content` */



CREATE TABLE `cit_content` (
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

/*Data for the table `cit_content` */

insert  into `cit_content`(`id`,`content_id`,`isactive`,`type`,`name`,`body`,`lang`,`notes`,`created`,`updated`) values (1,1,1,'landing','Landing','<h1>Welcome to the Support Center</h1> <p> In order to streamline support requests and better serve you, we utilize a support ticket system. Every support request is assigned a unique ticket number which you can use to track the progress and responses online. For your reference we provide complete archives and history of all your support requests. A valid email address is required to submit a ticket. </p>','en_US','The Landing Page refers to the content of the Customer Portal\'s initial view. The template modifies the content seen above the two links <strong>Open a New Ticket</strong> and <strong>Check Ticket Status</strong>.','2015-10-19 11:40:16','2015-10-19 11:40:16'),(2,2,1,'thank-you','Thank You','<div>%{ticket.name},\n<br>\n<br>\nThank you for contacting us.\n<br>\n<br>\nA support ticket request has been created and a representative will be\ngetting back to you shortly if necessary.</p>\n<br>\n<br>\nSupport Team\n</div>','en_US','This template defines the content displayed on the Thank-You page after a\nClient submits a new ticket in the Client Portal.','2015-10-19 11:40:16','2015-10-19 11:40:16'),(3,3,1,'offline','Offline','<div><h1>\n<span style=\"font-size: medium\">Support Ticket System Offline</span>\n</h1>\n<p>Thank you for your interest in contacting us.</p>\n<p>Our helpdesk is offline at the moment, please check back at a later\ntime.</p>\n</div>','en_US','The Offline Page appears in the Customer Portal when the Help Desk is offline.','2015-10-19 11:40:16','2015-10-19 11:40:16'),(4,4,1,'registration-staff','Welcome to osTicket','<h3><strong>Hi %{recipient.name.first},</strong></h3> <div> We\'ve created an account for you at our help desk at %{url}.<br /> <br /> Please follow the link below to confirm your account and gain access to your tickets.<br /> <br /> <a href=\"%{link}\">%{link}</a><br /> <br /> <em style=\"font-size: small\">Your friendly Customer Support System<br /> %{company.name}</em> </div>','en_US','This template defines the initial email (optional) sent to Agents when an account is created on their behalf.','2015-10-19 11:40:16','2015-10-19 11:40:16'),(5,5,1,'pwreset-staff','osTicket Staff Password Reset','<h3><strong>Hi %{staff.name.first},</strong></h3> <div> A password reset request has been submitted on your behalf for the helpdesk at %{url}.<br /> <br /> If you feel that this has been done in error, delete and disregard this email. Your account is still secure and no one has been given access to it. It is not locked and your password has not been reset. Someone could have mistakenly entered your email address.<br /> <br /> Follow the link below to login to the help desk and change your password.<br /> <br /> <a href=\"%{link}\">%{link}</a><br /> <br /> <em style=\"font-size: small\">Your friendly Customer Support System</em> <br /> <img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" alt=\"Powered by osTicket\" width=\"126\" height=\"19\" style=\"width: 126px\" /> </div>','en_US','This template defines the email sent to Staff who select the <strong>Forgot My Password</strong> link on the Staff Control Panel Log In page.','2015-10-19 11:40:16','2015-10-19 11:40:16'),(6,6,1,'banner-staff','Authentication Required','','en_US','This is the initial message and banner shown on the Staff Log In page. The first input field refers to the red-formatted text that appears at the top. The latter textarea is for the banner content which should serve as a disclaimer.','2015-10-19 11:40:16','2015-10-19 11:40:16'),(7,7,1,'registration-client','Welcome to %{company.name}','<h3><strong>Hi %{recipient.name.first},</strong></h3> <div> We\'ve created an account for you at our help desk at %{url}.<br /> <br /> Please follow the link below to confirm your account and gain access to your tickets.<br /> <br /> <a href=\"%{link}\">%{link}</a><br /> <br /> <em style=\"font-size: small\">Your friendly Customer Support System <br /> %{company.name}</em> </div>','en_US','This template defines the email sent to Clients when their account has been created in the Client Portal or by an Agent on their behalf. This email serves as an email address verification. Please use %{link} somewhere in the body.','2015-10-19 11:40:17','2015-10-19 11:40:17'),(8,8,1,'pwreset-client','%{company.name} Help Desk Access','<h3><strong>Hi %{user.name.first},</strong></h3> <div> A password reset request has been submitted on your behalf for the helpdesk at %{url}.<br /> <br /> If you feel that this has been done in error, delete and disregard this email. Your account is still secure and no one has been given access to it. It is not locked and your password has not been reset. Someone could have mistakenly entered your email address.<br /> <br /> Follow the link below to login to the help desk and change your password.<br /> <br /> <a href=\"%{link}\">%{link}</a><br /> <br /> <em style=\"font-size: small\">Your friendly Customer Support System <br /> %{company.name}</em> </div>','en_US','This template defines the email sent to Clients who select the <strong>Forgot My Password</strong> link on the Client Log In page.','2015-10-19 11:40:17','2015-10-19 11:40:17'),(9,9,1,'banner-client','Sign in to %{company.name}','To better serve you, we encourage our Clients to register for an account.','en_US','This composes the header on the Client Log In page. It can be useful to inform your Clients about your log in and registration policies.','2015-10-19 11:40:17','2015-10-19 11:40:17'),(10,10,1,'registration-confirm','Account registration','<div><strong>Thanks for registering for an account.</strong><br/> <br /> We\'ve just sent you an email to the address you entered. Please follow the link in the email to confirm your account and gain access to your tickets. </div>','en_US','This templates defines the page shown to Clients after completing the registration form. The template should mention that the system is sending them an email confirmation link and what is the next step in the registration process.','2015-10-19 11:40:17','2015-10-19 11:40:17'),(11,11,1,'registration-thanks','Account Confirmed!','<div> <strong>Thanks for registering for an account.</strong><br /> <br /> You\'ve confirmed your email address and successfully activated your account. You may proceed to open a new ticket or manage existing tickets.<br /> <br /> <em>Your friendly support center</em><br /> %{company.name} </div>','en_US','This template defines the content displayed after Clients successfully register by confirming their account. This page should inform the user that registration is complete and that the Client can now submit a ticket or access existing tickets.','2015-10-19 11:40:17','2015-10-19 11:40:17'),(12,12,1,'access-link','Ticket [#%{ticket.number}] Access Link','<h3><strong>Hi %{recipient.name.first},</strong></h3> <div> An access link request for ticket #%{ticket.number} has been submitted on your behalf for the helpdesk at %{url}.<br /> <br /> Follow the link below to check the status of the ticket #%{ticket.number}.<br /> <br /> <a href=\"%{recipient.ticket_link}\">%{recipient.ticket_link}</a><br /> <br /> If you <strong>did not</strong> make the request, please delete and disregard this email. Your account is still secure and no one has been given access to the ticket. Someone could have mistakenly entered your email address.<br /> <br /> --<br /> %{company.name} </div>','en_US','This template defines the notification for Clients that an access link was sent to their email. The ticket number and email address trigger the access link.','2015-10-19 11:40:17','2015-10-19 11:40:17');

/*Table structure for table `cit_department` */


CREATE TABLE `cit_department` (
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

/*Data for the table `cit_department` */

insert  into `cit_department`(`dept_id`,`tpl_id`,`sla_id`,`email_id`,`autoresp_email_id`,`manager_id`,`dept_name`,`dept_signature`,`ispublic`,`group_membership`,`ticket_auto_response`,`message_auto_response`,`updated`,`created`) values (1,0,0,0,0,0,'Support','Support Department',1,1,1,1,'2015-10-19 11:40:06','2015-10-19 11:40:06'),(2,0,1,0,0,0,'Sales','Sales and Customer Retention',1,1,1,1,'2015-10-19 11:40:07','2015-10-19 11:40:07'),(3,0,0,0,0,0,'Maintenance','Maintenance Department',0,0,1,1,'2015-10-19 11:40:07','2015-10-19 11:40:07');

/*Table structure for table `cit_draft` */



CREATE TABLE `cit_draft` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) unsigned NOT NULL,
  `namespace` varchar(32) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `extra` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `cit_draft` */

insert  into `cit_draft`(`id`,`staff_id`,`namespace`,`body`,`extra`,`created`,`updated`) values (1,1,'ticket.staff.response','',NULL,'2015-10-19 11:44:01','2015-11-02 15:47:02'),(2,1,'ticket.staff.note','',NULL,'2015-10-19 11:44:01','2015-11-02 15:47:02'),(3,1,'ticket.staff','',NULL,'2015-10-19 11:44:01','2015-11-02 15:47:02'),(4,2,'ticket.staff','',NULL,'2015-10-21 15:18:54','2015-10-21 15:19:03'),(5,2,'ticket.staff.note','',NULL,'2015-10-21 15:18:54','2015-10-21 15:19:03'),(6,2,'ticket.staff.response','',NULL,'2015-10-21 15:18:54','2015-10-21 15:19:03');

/*Table structure for table `cit_email` */


CREATE TABLE `cit_email` (
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

/*Data for the table `cit_email` */

insert  into `cit_email`(`email_id`,`noautoresp`,`priority_id`,`dept_id`,`topic_id`,`email`,`name`,`userid`,`userpass`,`mail_active`,`mail_host`,`mail_protocol`,`mail_encryption`,`mail_port`,`mail_fetchfreq`,`mail_fetchmax`,`mail_archivefolder`,`mail_delete`,`mail_errors`,`mail_lasterror`,`mail_lastfetch`,`smtp_active`,`smtp_host`,`smtp_port`,`smtp_secure`,`smtp_auth`,`smtp_spoofing`,`notes`,`created`,`updated`) values (1,0,2,1,0,'tickets@gmail.com','Support','','',0,'','POP','NONE',NULL,5,30,NULL,0,0,NULL,NULL,0,'',NULL,1,1,0,NULL,'2015-10-19 11:40:21','2015-10-19 11:40:21'),(2,0,2,1,0,'alerts@gmail.com','osTicket Alerts','','',0,'','POP','NONE',NULL,5,30,NULL,0,0,NULL,NULL,0,'',NULL,1,1,0,NULL,'2015-10-19 11:40:21','2015-10-19 11:40:21'),(3,0,2,1,0,'noreply@gmail.com','','','',0,'','POP','NONE',NULL,5,30,NULL,0,0,NULL,NULL,0,'',NULL,1,1,0,NULL,'2015-10-19 11:40:21','2015-10-19 11:40:21');

/*Table structure for table `cit_email_account` */



CREATE TABLE `cit_email_account` (
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

/*Data for the table `cit_email_account` */

/*Table structure for table `cit_email_template` */



CREATE TABLE `cit_email_template` (
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

/*Data for the table `cit_email_template` */

insert  into `cit_email_template`(`id`,`tpl_id`,`code_name`,`subject`,`body`,`notes`,`created`,`updated`) values (1,1,'ticket.autoresp','Support Ticket Opened [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name.first},</strong></h3> <p> A request for support has been created and assigned #%{ticket.number}. A representative will follow-up with you as soon as possible. You can <a href=\"%%7Brecipient.ticket_link%7D\">view this ticket\'s progress online</a>. </p> <br /><div style=\"color:rgb(127, 127, 127)\"> Your %{company.name} Team, <br /> %{signature} </div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small\"><em>If you wish to provide additional comments or information regarding the issue, please reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login to your account</span></a> for a complete archive of your support requests.</em></div> ',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(2,1,'ticket.autoreply','Re: %{ticket.subject} [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name.first},</strong></h3> A request for support has been created and assigned ticket <a href=\"%%7Brecipient.ticket_link%7D\">#%{ticket.number}</a> with the following automatic reply <br /><br /> Topic: <strong>%{ticket.topic.name}</strong> <br /> Subject: <strong>%{ticket.subject}</strong> <br /><br /> %{response} <br /><br /><div style=\"color:rgb(127, 127, 127)\">Your %{company.name} Team,<br /> %{signature}</div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small\"><em>We hope this response has sufficiently answered your questions. If you wish to provide additional comments or informatione, please reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login to your account</span></a> for a complete archive of your support requests.</em></div> ',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(3,1,'message.autoresp','Message Confirmation',' <h3><strong>Dear %{recipient.name.first},</strong></h3> Your reply to support request <a href=\"%%7Brecipient.ticket_link%7D\">#%{ticket.number}</a> has been noted <br /><br /><div style=\"color:rgb(127, 127, 127)\"> Your %{company.name} Team,<br /> %{signature} </div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small;text-align:center\"> <em>You can view the support request progress <a href=\"%%7Brecipient.ticket_link%7D\">online here</a></em> </div> ',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(4,1,'ticket.notice','%{ticket.subject} [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name.first},</strong></h3> Our customer care team has created a ticket, <a href=\"%%7Brecipient.ticket_link%7D\">#%{ticket.number}</a> on your behalf, with the following details and summary: <br /><br /> Topic: <strong>%{ticket.topic.name}</strong> <br /> Subject: <strong>%{ticket.subject}</strong> <br /><br /> %{message} <br /><br /> If need be, a representative will follow-up with you as soon as possible. You can also <a href=\"%%7Brecipient.ticket_link%7D\">view this ticket\'s progress online</a>. <br /><br /><div style=\"color:rgb(127, 127, 127)\"> Your %{company.name} Team,<br /> %{signature}</div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small\"><em>If you wish to provide additional comments or information regarding the issue, please reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login to your account</span></a> for a complete archive of your support requests.</em></div> ',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(5,1,'ticket.overlimit','Open Tickets Limit Reached',' <h3><strong>Dear %{ticket.name.first},</strong></h3> You have reached the maximum number of open tickets allowed. To be able to open another ticket, one of your pending tickets must be closed. To update or add comments to an open ticket simply <a href=\"%%7Burl%7D/tickets.php?e=%%7Bticket.email%7D\">login to our helpdesk</a>. <br /><br /> Thank you,<br /> Support Ticket System',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(6,1,'ticket.reply','Re: %{ticket.subject} [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name},</strong></h3> %{response} <br /><br /><div style=\"color:rgb(127, 127, 127)\"> Your %{company.name} Team,<br /> %{signature} </div> <hr /> <div style=\"color:rgb(127, 127, 127);font-size:small;text-align:center\"><em>We hope this response has sufficiently answered your questions. If not, please do not send another email. Instead, reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\" style=\"color:rgb(84, 141, 212)\">login to your account</a> for a complete archive of all your support requests and responses.</em></div> ',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(7,1,'ticket.activity.notice','Re: %{ticket.subject} [#%{ticket.number}]',' <h3><strong>Dear %{recipient.name.first},</strong></h3> <div> <em>%{poster.name}</em> just logged a message to a ticket in which you participate. </div> <br /> %{message} <br /><br /><hr /> <div style=\"color:rgb(127, 127, 127);font-size:small;text-align:center\"> <em>You\'re getting this email because you are a collaborator on ticket <a href=\"%%7Brecipient.ticket_link%7D\" style=\"color:rgb(84, 141, 212)\">#%{ticket.number}</a>. To participate, simply reply to this email or <a href=\"%%7Brecipient.ticket_link%7D\" style=\"color:rgb(84, 141, 212)\">click here</a> for a complete archive of the ticket thread.</em> </div> ',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(8,1,'ticket.alert','New Ticket Alert',' <h2>Hi %{recipient.name},</h2> New ticket #%{ticket.number} created <br /><br /><table><tbody> <tr> <td> <strong>From</strong>: </td> <td> %{ticket.name} &lt;%{ticket.email}&gt; </td> </tr> <tr> <td> <strong>Department</strong>: </td> <td> %{ticket.dept.name} </td> </tr> </tbody></table> <br /> %{message} <br /><br /><hr /> <div>To view or respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\">login</a> to the support ticket system</div> <em style=\"font-size:small\">Your friendly Customer Support System</em> <br /><a href=\"http://osticket.com/\"><img width=\"126\" height=\"19\" style=\"width:126px\" alt=\"Powered By osTicket\" src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" /></a> ',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(9,1,'message.alert','New Message Alert',' <h3><strong>Hi %{recipient.name},</strong></h3> New message appended to ticket <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> <br /><br /><table><tbody> <tr> <td> <strong>From</strong>: </td> <td> %{ticket.name} &lt;%{ticket.email}&gt; </td> </tr> <tr> <td> <strong>Department</strong>: </td> <td> %{ticket.dept.name} </td> </tr> </tbody></table> <br /> %{message} <br /><br /><hr /> <div>To view or respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login</span></a> to the support ticket system</div> <em style=\"color:rgb(127,127,127);font-size:small\">Your friendly Customer Support System</em><br /><img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" alt=\"Powered by osTicket\" width=\"126\" height=\"19\" style=\"width:126px\" /> ',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(10,1,'note.alert','New Internal Activity Alert',' <h3><strong>Hi %{recipient.name},</strong></h3> An agent has logged activity on ticket <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> <br /><br /><table><tbody> <tr> <td> <strong>From</strong>: </td> <td> %{note.poster} </td> </tr> <tr> <td> <strong>Title</strong>: </td> <td> %{note.title} </td> </tr> </tbody></table> <br /> %{note.message} <br /><br /><hr /> To view/respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\">login</a> to the support ticket system <br /><br /><em style=\"font-size:small\">Your friendly Customer Support System</em> <br /><img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" alt=\"Powered by osTicket\" width=\"126\" height=\"19\" style=\"width:126px\" /> ',NULL,'2015-10-19 11:40:18','2015-10-19 11:40:18'),(11,1,'assigned.alert','Ticket Assigned to you',' <h3><strong>Hi %{assignee.name.first},</strong></h3> Ticket <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> has been assigned to you by %{assigner.name.short} <br /><br /><table><tbody> <tr> <td> <strong>From</strong>: </td> <td> %{ticket.name} &lt;%{ticket.email}&gt; </td> </tr> <tr> <td> <strong>Subject</strong>: </td> <td> %{ticket.subject} </td> </tr> </tbody></table> <br /> %{comments} <br /><br /><hr /> <div>To view/respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login</span></a> to the support ticket system</div> <em style=\"font-size:small\">Your friendly Customer Support System</em> <br /><img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" alt=\"Powered by osTicket\" width=\"126\" height=\"19\" style=\"width:126px\" /> ',NULL,'2015-10-19 11:40:19','2015-10-19 11:40:19'),(12,1,'transfer.alert','Ticket #%{ticket.number} transfer - %{ticket.dept.name}',' <h3>Hi %{recipient.name},</h3> Ticket <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> has been transferred to the %{ticket.dept.name} department by <strong>%{staff.name.short}</strong> <br /><br /><blockquote> %{comments} </blockquote> <hr /> <div>To view or respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\">login</a> to the support ticket system. </div> <em style=\"font-size:small\">Your friendly Customer Support System</em> <br /><a href=\"http://osticket.com/\"><img width=\"126\" height=\"19\" alt=\"Powered By osTicket\" style=\"width:126px\" src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" /></a> ',NULL,'2015-10-19 11:40:19','2015-10-19 11:40:19'),(13,1,'ticket.overdue','Stale Ticket Alert',' <h3> <strong>Hi %{recipient.name}</strong>,</h3> A ticket, <a href=\"%%7Bticket.staff_link%7D\">#%{ticket.number}</a> is seriously overdue. <br /><br /> We should all work hard to guarantee that all tickets are being addressed in a timely manner. <br /><br /> Signed,<br /> %{ticket.dept.manager.name} <hr /> <div>To view or respond to the ticket, please <a href=\"%%7Bticket.staff_link%7D\"><span style=\"color:rgb(84, 141, 212)\">login</span></a> to the support ticket system. You\'re receiving this notice because the ticket is assigned directly to you or to a team or department of which you\'re a member.</div> <em style=\"font-size:small\">Your friendly <span style=\"font-size:smaller\">(although with limited patience)</span> Customer Support System</em><br /><img src=\"cid:b56944cb4722cc5cda9d1e23a3ea7fbc\" height=\"19\" alt=\"Powered by osTicket\" width=\"126\" style=\"width:126px\" /> ',NULL,'2015-10-19 11:40:19','2015-10-19 11:40:19');

/*Table structure for table `cit_email_template_group` */


CREATE TABLE `cit_email_template_group` (
  `tpl_id` int(11) NOT NULL AUTO_INCREMENT,
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL DEFAULT '',
  `lang` varchar(16) NOT NULL DEFAULT 'en_US',
  `notes` text,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tpl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `cit_email_template_group` */

insert  into `cit_email_template_group`(`tpl_id`,`isactive`,`name`,`lang`,`notes`,`created`,`updated`) values (1,1,'osTicket Default Template (HTML)','en_US','Default osTicket templates','2015-10-19 11:40:18','2015-10-19 11:40:18');

/*Table structure for table `cit_faq` */


CREATE TABLE `cit_faq` (
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

/*Data for the table `cit_faq` */

/*Table structure for table `cit_faq_category` */



CREATE TABLE `cit_faq_category` (
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

/*Data for the table `cit_faq_category` */

/*Table structure for table `cit_faq_topic` */


CREATE TABLE `cit_faq_topic` (
  `faq_id` int(10) unsigned NOT NULL,
  `topic_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`faq_id`,`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_faq_topic` */

/*Table structure for table `cit_file` */


CREATE TABLE `cit_file` (
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

/*Data for the table `cit_file` */

insert  into `cit_file`(`id`,`ft`,`bk`,`type`,`size`,`key`,`signature`,`name`,`attrs`,`created`) values (1,'T','D','image/png',9452,'b56944cb4722cc5cda9d1e23a3ea7fbc','gjMyblHhAxCQvzLfPBW3EjMUY1AmQQmz','powered-by-osticket.png',NULL,'2015-10-19 11:40:12'),(2,'T','D','text/plain',24,'u4N4aMWtx86n3ccfeGGNagoRoTDtol7o','MWtx86n3ccfeGGNafaacpitTxmJ4h3Ls','osTicket.txt',NULL,'2015-10-19 11:40:17');

/*Table structure for table `cit_file_chunk` */


CREATE TABLE `cit_file_chunk` (
  `file_id` int(11) NOT NULL,
  `chunk_id` int(11) NOT NULL,
  `filedata` longblob NOT NULL,
  PRIMARY KEY (`file_id`,`chunk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_file_chunk` */

insert  into `cit_file_chunk`(`file_id`,`chunk_id`,`filedata`) values (1,0,'�PNG\r\n\Z\n\0\0\0\rIHDR\0\0\0�\0\0\0(\0\0\0�G��\0\0\nCiCCPICC profile\0\0xڝSwX��>��eVB��l�\0\"#��Y��\0a�@Ņ�\nV�HUĂ�\nH���(�gA��Z�U\\8�ܧ�}z�����������y��&��j\09R�<:��OH�ɽ�H� ���g�\0\0�yx~t�?��o\0\0p�.$�����P&W\0 �\0�\"��R\0�.T�\0�\0�S�d\n\0�\0\0ly|B\"\0�\r\0��I>\0ة��\0آ�\0�\0�(G$@�\0`U�R,��\0��@\".���Y�2G��\0v�X�@`\0��B,�\0 8\0C� L�0ҿ�_p��H\0�˕͗K�3���\Zw����!��l�Ba)f	�\"���#H�L�\0\0\Z����8?������f�l��Ţ�k�o\">!�����\0N���_���p��u�k�[\0�V\0h��]3�	�Z\n�z��y8�@��P�<\n�%b��0�>�3�o��~��@��z�\0q�@������qanv�R���B1n��#�ǅ��)��4�\\,��X��P\"M�y�R�D!ɕ��2���	�w\r\0��O�N���l�~��X�v\0@~�-�\Z�\0g42y�\0\0����@+\0͗��\0\0��\\��L�\0\0D��*�A�������aD@$�<B�\n��AT�:���\Z�����18\r��\\��p`����	A�a!:�b��\"���\"aH4��� �Q\"��r��Bj�]H#�-r9�\\@���� 2����G1���Q�u@��\Z�Ơs�t4]���k�\Z�=�����K�ut\0}��c��1f��a\\��E`�X\Z&�c�X5V�5cX7v��a�$���^��l���GXLXC�%�#��W	��1�\'\"��O�%z��xb:��XF�&�!!�%^\'_�H$ɒ�N\n!%�2IIkH�H-�S�>�i�L&�m������ �����O�����:ň�L	�$R��J5e?���2B���Qͩ����:�ZIm�vP/S��4u�%͛Cˤ-��Кigi�h/�t�	݃E�З�k�����w\r�\r��Hb(k{��/�L�ӗ��T0�2�g��oUX*�*|���:�V�~��TUsU?�y�T�U�^V}�FU�P�	��թU��6��RwR�P�Q_��_���c\r���F��H�Tc���!�2e�XB�rV�,k�Mb[���Lv�v/{LSCs�f�f�f��q�Ʊ��9ٜJ�!�\r�{--?-��j�f�~�7�zھ�b�r�����up�@�,��:m:�u	�6�Q����u��>�c�y�	������G�m��������7046�l18c�̐c�k�i������h���h��I�\'�&�g�5x>f�ob�4�e�k<abi2ۤĤ��)͔k�f�Ѵ�t���,ܬج��9՜k�a�ټ�����E��J�6�ǖږ|��M����V>VyV�V׬I�\\�,�m�WlPW��:�˶�����v�m���)�)�Sn�1���\n���9�a�%�m����;t;|rtu�vlp���4éĩ��Wgg�s��5�K���v�Sm���n�z˕�\Z�ҵ������ܭ�m���=�}��M.��]�=�A���X�q�㝧�����/^v^Y^��O��&��0m���[��{`:>=e���>�>�z�����\"�=�#~�~�~���;�������y��N`����\Z��k��5��/>B	\rYr�o���c3�g,����Z�0�&L�����~o��L�̶��Gl��i��})*2�.�Q�Stqt�,֬�Y�g��񏩌�;�j�rvg�jlRlc웸�����x��E�t$	�����=��s�l�3��T�tc��ܢ����˞w<Y5Y�|8����?� BP/O�nM򄛅OE����Q���J<��V��8�;}C�h�OFu�3	OR+y���#�MVD�ެ��q�-9�����R\ri��+�0�(�Of++�\r�y�m������#�s��l�Lѣ�R�PL/�+x[[x�H�HZ�3�f���#�|���P���ظxY��\"�E�#�Sw.1]R�dxi��}�h˲��P�XRU�jy��R�ҥ�C+�W4�����n��Z�ca�dU�j��[V*�_�p�����F���WN_�|�ym���J����H��n��Y��J�jA�І�\r���_mJ�t�zj��ʹ���5a5�[̶���6��z�]�V������&�ֿ�w{��;��켵+xWk�E}�n��ݏ\Zb���~ݸGwOŞ�{�{�E��jtolܯ���	mR6�H:p囀oڛ�w�pZ*�A��\'ߦ|{�P������ߙ���Hy+�:�u�-�m�=���茣�^G���~�1�cu�5�W���(=��䂓�d���N?=ԙ�y�L��k]Q]�gCϞ?t�L�_�����]�p�\"�b�%�K�=�=G~p��H�[o�e���W<�t�M�;����j��s���.]�y�����n&��%���v��w\n�L�]z�x�����������e�m��`�`��Y�	�����Ӈ��G�G�#F#���\r\Z��dΓ᧲���~V�y�s������K�X�����Ͽ�y��r﫩�:�#���y=�����}���ǽ�(�@�P���cǧ�O�>�|��/�����9%\0\0\0tEXtSoftware\0Adobe ImageReadyq�e<\0\0(iTXtXML:com.adobe.xmp\0\0\0\0\0<?xpacket begin=\"﻿\" id=\"W5M0MpCehiHzreSzNTczkc9d\"?> <x:xmpmeta xmlns:x=\"adobe:ns:meta/\" x:xmptk=\"Adobe XMP Core 5.6-c014 79.156797, 2014/08/20-09:53:02        \"> <rdf:RDF xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"> <rdf:Description rdf:about=\"\" xmlns:xmp=\"http://ns.adobe.com/xap/1.0/\" xmlns:xmpMM=\"http://ns.adobe.com/xap/1.0/mm/\" xmlns:stRef=\"http://ns.adobe.com/xap/1.0/sType/ResourceRef#\" xmp:CreatorTool=\"Adobe Photoshop CC 2014 (Macintosh)\" xmpMM:InstanceID=\"xmp.iid:6E2C95DEA67311E4BDCDDF91FAF94DA5\" xmpMM:DocumentID=\"xmp.did:6E2C95DFA67311E4BDCDDF91FAF94DA5\"> <xmpMM:DerivedFrom stRef:instanceID=\"xmp.iid:CFA74E4FA67111E4BDCDDF91FAF94DA5\" stRef:documentID=\"xmp.did:CFA74E50A67111E4BDCDDF91FAF94DA5\"/> </rdf:Description> </rdf:RDF> </x:xmpmeta> <?xpacket end=\"r\"?>����\0\0IDATx��]	�S��?/{2�df�aq�]67�ϭ(*�-\n��.�+�օ� n�J���S�R��:VDT�,e�2�l�����3��L���ݛ�os�N��Pq���$���������s�1�NY96��t����S�/Q��]k~K����z���>�%4ߤ�5���<��,��clmY������\'��B�h���B�LZ��M?���\0]s�G�>���Z(4W�]h\r\"Ҿ&F4�]���?JKD$�F>Yd-}Q�ZY�e�)���*t��ӄ���$��\r	=(t���Bg	=�����_���єQ\0m�V�+�S�va�D�W�g�����B���B�e���B��L�H���#t�B�	�mFW�\0;t� _���@��њ�x��.t!�[�!#�\\���|��W��:��\rG��I��9��*ʍ6ˁ���Jk�S��A�qG�N��\09���EB�M�~-4?홝�~�I�}�&�y�eY�����o\n�u��{.r��Bk��iv?���LG��є�j�-+��Q散\02%>�|���(^����\n�X��r��T��R��-�*����-��R�˅V���BI�:G�T�#��5i�\ZE\"F��lD;�\\_�p��sj�d��B\"t��B)�2�w���ϊ��`���Ф�^���MnA!��<�Y�>�������\n�kt�M�Jw%���<.����B�U\\G�BI?禓]\0�o����^����eF�&.���a��a5�͚��#ңo>��=L^���]F����J�N\0�G��ㅾV�\Z��!q#!�����6=X�9�\\T2�ﲨ{��c�捳,Ў)zak�l��@1���{���^��MF��_b��(7�9����+\'J��{h�n��[\\�hi��Gc41\'\'�M��1����>;k�ǐL�����݋���$�|�~�,��ݕ�x� �l��(4W.�\ZAjՈ�r���sr�W���M�W�r�\"z�h��>��;��Y�窊E,�0ތ\\�\\1�b����\"�\'����x���u�LY�ȣx9�)��^[\0�P�XV��NX�ͻ�T(\"Y���u��W�e�v�݈RU�C55A��C��GY6?���@��1k�VS|�9��I�X���*�rD�\"��L���Ύ=*@4�=N�wZj�9�%p���%a��~��yBe��������\r���K�;HT�o�+�)�Q�_Ÿt����cI�U�ȱB\"�Vڪ�Vg>L�vW�S�1�|�X���pѰ�y��Zx�rR��\'�#��)��W�H�[ ԍ����	�(#�=B2��C�۲@�JL,H$�ݵ(��N)2���\'��䘮\Z��/*��\'rZ�KD��V�((��g	��ś{��P�]aY� �jߊ=B��\n\"4~n�VnwR���X�F�U�rQsΐJd��\Zz��7\"�y�7e�cV������������%�B�T`��S�O�;]NNy�X�z7�s��}���~j/�߬\rn����F�z���*��f�ۉ洌5)��E��EK|��j�4��4\rI.��x����.�j�6��GJ�G_��Ә�Zz1`Nx�P��<8�^��$6�v�hUY�\n�G���jrެ/^�D����a�S��ۚIm·L��\Z�^ f��Z��A36�ck��{,\Z9�Rܱ@W�Q%��Z�d���Wm��o��\'rK��J���U0�7YާD~&*�������1~��&=PH:	��e�ְȁ~��|�d4ş:�҇��\n��{��ţTǹ+h�,��9ww��z��X\0�����-�K��N/R������\r�3-H��h+�apymv+��gɧ�7��E#�:��*����Z;x��΁w�*��Kq�8W�Q���ȶ<�{X�&�ң�xPTR�;Pđ �#�����%·\'��H/�d���&A�y��?�����Ljȇ6�=\"�9�t9\Z_��2I$��\0�K�,�-\"�h���g.��v��8߼�a�=�ٞ]MV*D-z�c0:�z7y�ɣGϯ(/y=�|ҧ^[�Ӻ�ca�q�>ѺQj���)�bD���ky��J@���c��K�����leh\rK���)��Axn�v�F8\r�J��Bww*%Gl^͖̋*�D�LV���� �)Q�x��1�NT�7o��.�|�e�S�V�>^�����B/�\Z�ҽ��qSE���>;-��41�t����iD�瓍8U�}\'�\"�OB�z��#����w���v8;���I�F>�:Թ�㰀�O4D��r�����S�m�.��F!%�8䊛I��y\"�������e�*H�NE�f�t5��K#��L��B���E�3��6P����$�V72��;��P\"1�Óȹ������ڹ��\\y�� �(�r�\"�W�>�����z�S�}��|?A��6N���y΋p9H��\0����6�1�6ʧP�Z}i�\"���R7�%��O��č��ыkCU!j/@61�z	�\'�[�~��wף�7V\0q_�+�}�o^e4\"6����¨�s����!��\\r��k�JN�T�$@�Q�N���S�������$yZ(_�:�{���W,��\r�/��u�\Zs�x��Ѱqh�����.��}	����g(�b[\Z�s�L7��RF��+�%�(��G�8\"�4�r��)�5V��6I��F�\r:� XR>9��Q;G)ڴ����^��LȰR�#���.c�/ ��5/d�Izf9�,��}Og+>{8���xq�*���k��^�Z`5��r�u��u��ʠ��\"�I��E[uT�\\�\n�q���f�-�ϵ�ͺ/I4%8�{0�7\"W+k���T��Ga_�dC:���2����v\0�Y���-���{���0ǟN�6V�����!1��y��\0@�LF�y�@:�:x�:�/+E�îu.^f=0	�W�V\"b��K�5�3G��ht�#�+��>?��ǽ=���0�}0��t�ɼ��u\r�V���9�)�ftѼ~;��W�9Xt�tƊ#)\n6Ex�9r���8���_K���g����D�������+	ȸ�\n���Z���u��-@�G��L���M\Z��`��^N�\r�^F�ȫ	�����` #��bL�FD�~�x֎@7���:���!l�1�l\Z��\'�9@p)�b�PbN�UP��q�����t��8��\"�\'�\r\\&!ª���&OGGׂb�nf`]�0��N=m?��k����X�F$?��2�bP\n��ؕp�0��{�EAoh��|��d�Y�E,�qjQe�0��T`��K|4bf.�D�f�����o��N�D�Á���=l,uف1�\\����v�U����P��w�B�G_�)1�\0�N�o������C�����&ҁ��痁�<Pq~�6����cmZ����b>�	�\\�U�����\' �y�>!ܶF��G�,�G���MO�f �uQ������nx�����H�rL<�4�?f/��qR���Jʿ�ɤ%e\"���2�s!֧�!��\'�~��p\r#Je�+R=u���m�^J��U�|���F�op�C���(h_oI3��]puB4�+�q.��C���I[�IM�gTm(��F�F�g/\"�X���A��]��\03#��)I�5�r���cӨ}ʪ�G���@�@Q�|\0��E(�N���w��̥�uD�K\0��h�*�Y�C�.�1��UrX4<�y��̐;���_B�@�D1p~mx�V�ޯ�g�5Ze�+x���H��\'�P\rD龬��lw����P��d�x�>]h���B����G���G���R�|��`���Q��v���Ӡ�B��C,ERO�g*��/6��9�p�8!ĭ��씯�q\"BZ45xH2Ţ-G:��I83%���$�|��aY�\0<ܴ�Z��W���0�&����aTn��U��â�Zt���ep�\Z��i#E���F�6���*��\\��o��&H\'	�=�c6�m\"Ķ6�W���JVQSq*겨b���,�Q����d��{�4��{r���u!Ʋ��F�n��-赒��7a��L�����7i@�{P�L閮%$��(��\'q��c���w`��`@��5	�e�����\Z����9�fգ���V%������M(�ë�q�a���s���Q��w^��w�\nRZ0ǲ�E�O�tn`Ň�藸eY=�m.���\'2_��CN`Ʈ�(!�k��M�č�4u���%�4)��H�[��/�;��}\\��8�*�X���=Mwh\r\Zt\n�\\\'\"�\nƄ�Z~M3��-9�8�R8��g�_@uWN��4��ꓚϹ�5b5��T^RcSVh�b�>b\0#��5:�,�w�cT��Pma������\'� �E	e0�XԎBI�Fx\\y���U��\"�8�r���[��E�r:!5�dIA��h�\'Z4Wt�����g�4醲�v�<�Q�]�-��\\��A(5`m,�	皌�V�\Z�Xd��*��Pb��<�B%+�#c.V*���P���,Vՙy(:�\0�F#\"|Fu7����l+\0(����ŀ�b�����`xڗPR�7՝*)�.^U(�\\�Μ��;��脫PЙ\0�y�\Z�������\0�j��8���\Z�����y�d�Q�e���Z�	�EO����h�u)���h�3�!�[SU�\'��_��q����(.��RO�B�b�W�Ѷh�ԋG\r�N���)����|V�F�h��&D]���E4 k�y6hw���=���?D��\'����u�b-�Ts��G���y�y��`8����<�\na+V�\rh�2	�x��1�іMA��y�)l�k$����H��y�7��t\r��j�H�/6-�J�u&<}\"�Qĕn@{�j�K\Z�.`-N�Bچ�ӫh�M/^���\\߀1vS�/GJP�!�6#���9�:Cb������DčR�_�9���C\r��SU]SE4;���B�o�\"�(���Px)\'��̵pʲ�	ޝӜ{�P�4	��0,@:�L���\\j�_��g�08�0�c�\"!��,x77��\Z\n��d�\"~�h������~P�9I��,FS��;km@F2?\n%�5z|:��5h�D��C�tG�TET��}-��qz�{\n��iI�Q�3�#��dt�-�!�DWD�#w#e&��\Z��QND�w���ݔj�q���{p��k���+܏{gZǫrХl��\"�l�m$l�p$I?�1�`<���:$���Bi�b�B��c]��݀k8q��v�C�d�W��xU�\'�y�������Q��.�=o��3��V�� %��|F��=�V�+��$�E\'^9O�7K��L��轲Z��ȫ�I�4x��a���A��>��g�Џ����\0`_c:\Z��\rF�(D�~@3ѷ3)��S:�� _?𵀓\\�M)��8�~x/����F!�Pn�p/ؽ��%h[p݋Xes,ھđ�\nie�L���D��JKKr��u�A�)J�w\"�d����x^���W��\np���$��\0D�(�-�]�]��:�hk���i��d3�����+��;��Un�4\nKɶP(P�h���\n;^�Ʋ�,]|��X�˫�Tw	V���v\0�u���ྞbS(��ٖZ?=g`x��ѡ5�MY9\Z��\\S�l3�e:Y	j�Bn�v�J5�s�z��S��.\'��%�jh̜�\0Z=_�\Z���h`oe[���)�#�2�i����M�7י�bV����N@t�S�_]����wfHu͙He��m����Hk Z�D۽��\'(�����NT��|_;�\"��VJL�ɔi����/�Bh�����8�\"��/�!w�������F5��vT!+Q��/A�FOҘ��4�C�\Zp0jC�\nJ�\'6��Q�~�7vD3/�B5���@�Z p����_�\0�௘s]J�\0\0\0\0IEND�B`�'),(2,0,'Canned Attachments Rock!');

/*Table structure for table `cit_filter` */


CREATE TABLE `cit_filter` (
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

/*Data for the table `cit_filter` */

insert  into `cit_filter`(`id`,`execorder`,`isactive`,`status`,`match_all_rules`,`stop_onmatch`,`reject_ticket`,`use_replyto_email`,`disable_autoresponder`,`canned_response_id`,`email_id`,`status_id`,`priority_id`,`dept_id`,`staff_id`,`team_id`,`sla_id`,`form_id`,`topic_id`,`ext_id`,`target`,`name`,`notes`,`created`,`updated`) values (1,99,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,NULL,'Email','SYSTEM BAN LIST','Internal list for email banning. Do not remove','2015-10-19 11:40:09','2015-10-19 11:40:09');

/*Table structure for table `cit_filter_rule` */


CREATE TABLE `cit_filter_rule` (
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

/*Data for the table `cit_filter_rule` */

insert  into `cit_filter_rule`(`id`,`filter_id`,`what`,`how`,`val`,`isactive`,`notes`,`created`,`updated`) values (1,1,'email','equal','test@example.com',1,'','2015-10-19 11:40:09','2015-10-19 11:40:09');

/*Table structure for table `cit_form` */


CREATE TABLE `cit_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(8) NOT NULL DEFAULT 'G',
  `deletable` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL,
  `instructions` varchar(512) DEFAULT NULL,
  `notes` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `cit_form` */

insert  into `cit_form`(`id`,`type`,`deletable`,`title`,`instructions`,`notes`,`created`,`updated`) values (1,'U',1,'Contact Information',NULL,NULL,'2015-10-19 11:40:07','2015-10-19 11:40:07'),(2,'T',1,'Ticket Details','Please Describe Your Issue','This form will be attached to every ticket, regardless of its source.\nYou can add any fields to this form and they will be available to all\ntickets, and will be searchable with advanced search and filterable.','2015-10-19 11:40:08','2015-10-19 11:40:08'),(3,'C',1,'Company Information','Details available in email templates',NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(4,'O',1,'Organization Information','Details on user organization',NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(5,'L1',1,'Ticket Status Properties','Properties that can be set on a ticket status.',NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08');

/*Table structure for table `cit_form_entry` */


CREATE TABLE `cit_form_entry` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) unsigned NOT NULL,
  `object_id` int(11) unsigned DEFAULT NULL,
  `object_type` char(1) NOT NULL DEFAULT 'T',
  `sort` int(11) unsigned NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entry_lookup` (`object_type`,`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `cit_form_entry` */

insert  into `cit_form_entry`(`id`,`form_id`,`object_id`,`object_type`,`sort`,`created`,`updated`) values (1,4,1,'O',1,'2015-10-19 11:40:09','2015-10-19 11:40:09'),(2,3,NULL,'C',1,'2015-10-19 11:40:22','2015-10-19 11:40:22'),(3,1,1,'U',1,'2015-10-19 11:40:23','2015-10-19 11:40:23'),(5,1,2,'U',1,'2015-10-21 14:57:12','2015-10-21 14:57:12'),(6,1,3,'U',1,'2015-10-27 14:19:49','2015-10-27 14:19:49'),(7,1,4,'U',1,'2015-11-04 10:56:28','2015-11-04 10:56:28'),(8,1,6,'U',1,'2015-11-04 11:50:19','2015-11-04 11:50:19'),(9,1,7,'U',1,'2015-11-04 11:52:28','2015-11-04 11:52:28'),(10,1,8,'U',1,'2015-11-04 11:55:38','2015-11-04 11:55:38');

/*Table structure for table `cit_form_entry_values` */


CREATE TABLE `cit_form_entry_values` (
  `entry_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `value` text,
  `value_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`entry_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_form_entry_values` */

insert  into `cit_form_entry_values`(`entry_id`,`field_id`,`value`,`value_id`) values (1,28,'420 Desoto Street\nAlexandria, LA 71301',NULL),(1,29,'3182903674',NULL),(1,30,'http://osticket.com',NULL),(1,31,'Not only do we develop the software, we also use it to manage support for osTicket. Let us help you quickly implement and leverage the full potential of osTicket\'s features and functionality. Contact us for professional support or visit our website for documentation and community support.',NULL),(2,23,'Tickets',NULL),(2,24,NULL,NULL),(2,25,NULL,NULL),(2,26,NULL,NULL),(3,3,NULL,NULL),(3,4,NULL,NULL),(5,3,'3322769257',NULL),(5,4,NULL,NULL),(5,34,NULL,NULL),(6,3,'3322876547',NULL),(6,4,NULL,NULL),(6,34,'Convex interactive Pvt',NULL),(7,3,NULL,NULL),(7,4,NULL,NULL),(7,34,NULL,NULL),(8,3,NULL,NULL),(8,4,NULL,NULL),(8,34,NULL,NULL),(9,3,NULL,NULL),(9,4,NULL,NULL),(9,34,NULL,NULL),(10,3,'3452345645',NULL),(10,4,NULL,NULL),(10,34,'Convex',NULL);

/*Table structure for table `cit_form_field` */


CREATE TABLE `cit_form_field` (
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

/*Data for the table `cit_form_field` */

insert  into `cit_form_field`(`id`,`form_id`,`type`,`label`,`required`,`private`,`edit_mask`,`name`,`configuration`,`sort`,`hint`,`created`,`updated`) values (1,1,'text','Email Address',1,0,15,'email','{\"size\":40,\"length\":64,\"validator\":\"email\"}',1,NULL,'2015-10-19 11:40:07','2015-10-19 11:40:07'),(2,1,'text','Full Name',1,0,15,'name','{\"size\":40,\"length\":64}',2,NULL,'2015-10-19 11:40:07','2015-10-19 11:40:07'),(3,1,'phone','Phone Number',0,0,0,'phone',NULL,3,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(4,1,'memo','Internal Notes',0,1,0,'notes','{\"rows\":4,\"cols\":40}',5,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(20,2,'text','Issue Summary',1,0,15,'subject','{\"size\":40,\"length\":50}',1,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(21,2,'thread','Issue Details',1,0,15,'message',NULL,2,'Details on the reason(s) for opening the ticket.','2015-10-19 11:40:08','2015-10-19 11:40:08'),(22,2,'priority','Priority Level',0,1,3,'priority',NULL,3,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(23,3,'text','Company Name',1,0,3,'name','{\"size\":40,\"length\":64}',1,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(24,3,'text','Website',0,0,0,'website','{\"size\":40,\"length\":64}',2,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(25,3,'phone','Phone Number',0,0,0,'phone','{\"ext\":false}',3,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(26,3,'memo','Address',0,0,0,'address','{\"rows\":2,\"cols\":40,\"html\":false,\"length\":100}',4,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(27,4,'text','Name',1,0,15,'name','{\"size\":40,\"length\":64}',1,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(28,4,'memo','Address',0,0,0,'address','{\"rows\":2,\"cols\":40,\"length\":100,\"html\":false}',2,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(29,4,'phone','Phone',0,0,0,'phone',NULL,3,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(30,4,'text','Website',0,0,0,'website','{\"size\":40,\"length\":0}',4,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(31,4,'memo','Internal Notes',0,0,0,'notes','{\"rows\":4,\"cols\":40}',5,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(32,5,'state','State',1,0,63,'state','{\"prompt\":\"State of a ticket\"}',1,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(33,5,'memo','Description',0,0,15,'description','{\"rows\":2,\"cols\":40,\"html\":false,\"length\":100}',3,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08'),(34,1,'text','Company Name',1,0,0,'company','{\"size\":40,\"length\":64,\"validator\":\"company\"}',4,NULL,'2015-10-19 11:40:08','2015-10-19 11:40:08');

/*Table structure for table `cit_group_dept_access` */


CREATE TABLE `cit_group_dept_access` (
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `group_dept` (`group_id`,`dept_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_group_dept_access` */

insert  into `cit_group_dept_access`(`group_id`,`dept_id`) values (1,1),(2,1),(3,1),(1,2),(2,2),(3,2),(1,3),(2,3),(3,3);

/*Table structure for table `cit_groups` */

CREATE TABLE `cit_groups` (
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

/*Data for the table `cit_groups` */

insert  into `cit_groups`(`group_id`,`group_enabled`,`group_name`,`can_create_tickets`,`can_edit_tickets`,`can_post_ticket_reply`,`can_delete_tickets`,`can_close_tickets`,`can_assign_tickets`,`can_transfer_tickets`,`can_ban_emails`,`can_manage_premade`,`can_manage_faq`,`can_view_staff_stats`,`notes`,`created`,`updated`) values (1,1,'Lion Tamers',1,1,1,1,1,1,1,1,1,1,0,'System overlords. These folks (initially) have full control to all the departments they have access to.','2015-10-19 11:40:11','2015-10-19 11:40:11'),(2,1,'Elephant Walkers',1,1,1,1,1,1,1,1,1,1,0,'Inhabitants of the ivory tower','2015-10-19 11:40:12','2015-10-19 11:40:12'),(3,1,'Flea Trainers',1,1,1,0,1,1,1,0,0,0,0,'Lowly staff members','2015-10-19 11:40:12','2015-10-19 11:40:12');

/*Table structure for table `cit_help_topic` */

CREATE TABLE `cit_help_topic` (
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

/*Data for the table `cit_help_topic` */

insert  into `cit_help_topic`(`topic_id`,`topic_pid`,`isactive`,`ispublic`,`noautoresp`,`flags`,`status_id`,`priority_id`,`dept_id`,`staff_id`,`team_id`,`sla_id`,`page_id`,`form_id`,`sequence_id`,`sort`,`topic`,`number_format`,`notes`,`created`,`updated`) values (1,0,1,1,0,0,0,2,1,0,0,0,0,0,0,2,'General Inquiry','','Questions about products or services','2015-10-19 11:40:09','2015-10-19 11:40:09'),(2,0,1,1,0,0,0,1,1,0,0,0,0,0,0,1,'Feedback','','Tickets that primarily concern the sales and billing departments','2015-10-19 11:40:09','2015-10-19 11:40:09'),(10,0,1,1,0,0,0,2,1,0,0,0,0,0,0,3,'Report a Problem','','Product, service, or equipment related issues','2015-10-19 11:40:09','2015-10-19 11:40:09'),(11,10,1,1,0,0,0,3,1,0,0,1,0,0,0,4,'Access Issue','','Report an inability access a physical or virtual asset','2015-10-19 11:40:09','2015-10-19 11:40:09');

/*Table structure for table `cit_list` */


CREATE TABLE `cit_list` (
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

/*Data for the table `cit_list` */

insert  into `cit_list`(`id`,`name`,`name_plural`,`sort_mode`,`masks`,`type`,`notes`,`created`,`updated`) values (1,'Ticket Status','Ticket Statuses','SortCol',13,'ticket-status','Ticket statuses','2015-10-19 11:40:08','2015-10-19 11:40:08');

/*Table structure for table `cit_list_items` */


CREATE TABLE `cit_list_items` (
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

/*Data for the table `cit_list_items` */

/*Table structure for table `cit_note` */


CREATE TABLE `cit_note` (
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

/*Data for the table `cit_note` */

/*Table structure for table `cit_organization` */


CREATE TABLE `cit_organization` (
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

/*Data for the table `cit_organization` */

insert  into `cit_organization`(`id`,`name`,`manager`,`status`,`domain`,`extra`,`created`,`updated`) values (1,'osTicket','',0,'',NULL,'2015-10-19 11:40:09',NULL);

/*Table structure for table `cit_plugin` */


CREATE TABLE `cit_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `install_path` varchar(60) NOT NULL,
  `isphar` tinyint(1) NOT NULL DEFAULT '0',
  `isactive` tinyint(1) NOT NULL DEFAULT '0',
  `version` varchar(64) DEFAULT NULL,
  `installed` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_plugin` */

/*Table structure for table `cit_sequence` */


CREATE TABLE `cit_sequence` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `flags` int(10) unsigned DEFAULT NULL,
  `next` bigint(20) unsigned NOT NULL DEFAULT '1',
  `increment` int(11) DEFAULT '1',
  `padding` char(1) DEFAULT '0',
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `cit_sequence` */

insert  into `cit_sequence`(`id`,`name`,`flags`,`next`,`increment`,`padding`,`updated`) values (1,'General Tickets',1,1,1,'0','0000-00-00 00:00:00');

/*Table structure for table `cit_session` */


CREATE TABLE `cit_session` (
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

/*Data for the table `cit_session` */

insert  into `cit_session`(`session_id`,`session_data`,`session_expire`,`session_updated`,`user_id`,`user_ip`,`user_agent`) values ('13od8cibge86a7m3grviglms97','cfg:core|a:1:{s:9:\"tz_offset\";s:3:\"5.0\";}csrf|a:2:{s:5:\"token\";s:40:\"c109db0ba0df0e5c61dacd4405175db2f561aa0d\";s:4:\"time\";i:1446620719;}TZ_OFFSET|s:3:\"5.0\";TZ_DST|s:1:\"0\";cfg:mysqlsearch|a:0:{}','2015-11-05 12:05:19','2015-11-04 12:05:19','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36'),('k3t4v4tt1d2uss77hc1d37ffm6','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"02a0730bfa01190e83459da4fd4f35950a945235\";s:4:\"time\";i:1446473599;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:21:\"/crm/h-users.php?id=3\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"15e7881926f2bf26f344785a91f21693:1446473599:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";cfg:list.1|a:0:{}lastcroncall|i:1446473599;users_qs_ce746b0b7166d4b0f070e09225bd7f27|s:504:\"SELECT user.*, email.address as email, org.name as organization\n          , account.id as account_id, account.status as account_status , count(DISTINCT ticket.ticket_id) as tickets  FROM ost_user user LEFT JOIN ost_user_email email ON (user.id = email.user_id) LEFT JOIN ost_organization org ON (user.org_id = org.id) LEFT JOIN ost_user_account account ON (account.user_id = user.id)  LEFT JOIN ost_ticket ticket ON (ticket.user_id = user.id)  WHERE 1  GROUP BY user.id ORDER BY user.name ASC  LIMIT 0,25\";','2015-11-03 19:13:19','2015-11-02 19:13:19','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36'),('kg3uhq9v5l973heog6ns7rfn17','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"a05333caba37d0988a047e422cb852aec85e631f\";s:4:\"time\";i:1446464041;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:5:\"/crm/\";s:3:\"msg\";s:23:\"Authentication Required\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"b59e4c81b18db89f5c769bd94a0601f4:1446464041:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";::Q|s:4:\"open\";search_14d8edbcd9a8bd7e4d842e77cb9e8817|s:2071:\"SELECT ticket.ticket_id,tlock.lock_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id  ,user.name ,email.address as email, dept.dept_name, status.state  ,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.created  ,IF(ticket.duedate IS NULL,IF(sla.id IS NULL, NULL, DATE_ADD(ticket.created, INTERVAL sla.grace_period HOUR)), ticket.duedate) as duedate  ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.closed, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date  ,ticket.created as ticket_created, CONCAT_WS(\" \", staff.firstname, staff.lastname) as staff, team.name as team  ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(\" \", staff.lastname, staff.firstname)) as assigned  ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(\" / \", ptopic.topic, topic.topic)) as helptopic  ,cdata.priority as priority_id, cdata.subject, pri.priority_desc, pri.priority_color  FROM ost_ticket ticket  LEFT JOIN ost_ticket_status status\n            ON (status.id = ticket.status_id)  LEFT JOIN ost_user user ON user.id = ticket.user_id LEFT JOIN ost_user_email email ON user.id = email.user_id LEFT JOIN ost_department dept ON ticket.dept_id=dept.dept_id  LEFT JOIN ost_ticket_lock tlock ON (ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW()\n               AND tlock.staff_id!=1)  LEFT JOIN ost_staff staff ON (ticket.staff_id=staff.staff_id)  LEFT JOIN ost_team team ON (ticket.team_id=team.team_id)  LEFT JOIN ost_sla sla ON (ticket.sla_id=sla.id AND sla.isactive=1)  LEFT JOIN ost_help_topic topic ON (ticket.topic_id=topic.topic_id)  LEFT JOIN ost_help_topic ptopic ON (ptopic.topic_id=topic.topic_pid)  LEFT JOIN ost_ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id)  LEFT JOIN ost_ticket_priority pri ON (pri.priority_id = cdata.priority)  WHERE (   ( ticket.staff_id=1 AND status.state=\"open\")  OR ticket.dept_id IN (1,2,3) ) AND status.state IN (\n                \'open\' )  AND ticket.isanswered=0  ORDER BY pri.priority_urgency ASC, effective_date DESC, ticket.created DESC LIMIT 0,25\";cfg:list.1|a:0:{}lastcroncall|i:1446464041;users_qs_8a9d374aaadc942553bff597f0bb3ac6|s:505:\"SELECT user.*, email.address as email, org.name as organization\r\n          , account.id as account_id, account.status as account_status , count(DISTINCT ticket.ticket_id) as tickets  FROM ost_user user LEFT JOIN ost_user_email email ON (user.id = email.user_id) LEFT JOIN ost_organization org ON (user.org_id = org.id) LEFT JOIN ost_user_account account ON (account.user_id = user.id)  LEFT JOIN ost_ticket ticket ON (ticket.user_id = user.id)  WHERE 1  GROUP BY user.id ORDER BY user.name ASC  LIMIT 0,25\";users_qs_ce746b0b7166d4b0f070e09225bd7f27|s:504:\"SELECT user.*, email.address as email, org.name as organization\n          , account.id as account_id, account.status as account_status , count(DISTINCT ticket.ticket_id) as tickets  FROM ost_user user LEFT JOIN ost_user_email email ON (user.id = email.user_id) LEFT JOIN ost_organization org ON (user.org_id = org.id) LEFT JOIN ost_user_account account ON (account.user_id = user.id)  LEFT JOIN ost_ticket ticket ON (ticket.user_id = user.id)  WHERE 1  GROUP BY user.id ORDER BY user.name ASC  LIMIT 0,25\";','2015-11-03 16:34:01','2015-11-02 16:34:01','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36'),('n8tln0dkm332sotsede3mnq4p5','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"6113f3f1f1f9b872100f9c38e3148e621ec7fc43\";s:4:\"time\";i:1446616589;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:25:\"/crm/scp/h-users.php?id=4\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"864e857d97a182120081e7e6ff0904c6:1446616588:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";cfg:list.1|a:0:{}lastcroncall|i:1446616589;','2015-11-05 10:56:29','2015-11-04 10:56:29','0','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36'),('q42nfifce4h1ubuvc1tbbjotl3','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"139fa995033748bd6cb16b3b0d09f56602037be1\";s:4:\"time\";i:1446621857;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"bf637a227e90aace36602360a734b030:1446621835:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";::Q|s:4:\"open\";search_14d8edbcd9a8bd7e4d842e77cb9e8817|s:2071:\"SELECT ticket.ticket_id,tlock.lock_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id  ,user.name ,email.address as email, dept.dept_name, status.state  ,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.created  ,IF(ticket.duedate IS NULL,IF(sla.id IS NULL, NULL, DATE_ADD(ticket.created, INTERVAL sla.grace_period HOUR)), ticket.duedate) as duedate  ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.closed, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date  ,ticket.created as ticket_created, CONCAT_WS(\" \", staff.firstname, staff.lastname) as staff, team.name as team  ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(\" \", staff.lastname, staff.firstname)) as assigned  ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(\" / \", ptopic.topic, topic.topic)) as helptopic  ,cdata.priority as priority_id, cdata.subject, pri.priority_desc, pri.priority_color  FROM ost_ticket ticket  LEFT JOIN ost_ticket_status status\n            ON (status.id = ticket.status_id)  LEFT JOIN ost_user user ON user.id = ticket.user_id LEFT JOIN ost_user_email email ON user.id = email.user_id LEFT JOIN ost_department dept ON ticket.dept_id=dept.dept_id  LEFT JOIN ost_ticket_lock tlock ON (ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW()\n               AND tlock.staff_id!=1)  LEFT JOIN ost_staff staff ON (ticket.staff_id=staff.staff_id)  LEFT JOIN ost_team team ON (ticket.team_id=team.team_id)  LEFT JOIN ost_sla sla ON (ticket.sla_id=sla.id AND sla.isactive=1)  LEFT JOIN ost_help_topic topic ON (ticket.topic_id=topic.topic_id)  LEFT JOIN ost_help_topic ptopic ON (ptopic.topic_id=topic.topic_pid)  LEFT JOIN ost_ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id)  LEFT JOIN ost_ticket_priority pri ON (pri.priority_id = cdata.priority)  WHERE (   ( ticket.staff_id=1 AND status.state=\"open\")  OR ticket.dept_id IN (1,2,3) ) AND status.state IN (\n                \'open\' )  AND ticket.isanswered=0  ORDER BY pri.priority_urgency ASC, effective_date DESC, ticket.created DESC LIMIT 0,25\";cfg:list.1|a:0:{}lastcroncall|i:1446621836;users_qs_8a9d374aaadc942553bff597f0bb3ac6|s:505:\"SELECT user.*, email.address as email, org.name as organization\r\n          , account.id as account_id, account.status as account_status , count(DISTINCT ticket.ticket_id) as tickets  FROM ost_user user LEFT JOIN ost_user_email email ON (user.id = email.user_id) LEFT JOIN ost_organization org ON (user.org_id = org.id) LEFT JOIN ost_user_account account ON (account.user_id = user.id)  LEFT JOIN ost_ticket ticket ON (ticket.user_id = user.id)  WHERE 1  GROUP BY user.id ORDER BY user.name ASC  LIMIT 0,25\";users_qs_ce746b0b7166d4b0f070e09225bd7f27|s:504:\"SELECT user.*, email.address as email, org.name as organization\n          , account.id as account_id, account.status as account_status , count(DISTINCT ticket.ticket_id) as tickets  FROM ost_user user LEFT JOIN ost_user_email email ON (user.id = email.user_id) LEFT JOIN ost_organization org ON (user.org_id = org.id) LEFT JOIN ost_user_account account ON (account.user_id = user.id)  LEFT JOIN ost_ticket ticket ON (ticket.user_id = user.id)  WHERE 1  GROUP BY user.id ORDER BY user.name ASC  LIMIT 0,25\";','2015-11-05 12:24:17','2015-11-04 12:24:17','1','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36'),('vli3ptblud5hmpnhduf94hrfa0','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"ffe6a2ca077e31720f959f77cb0b1c27fe4722ce\";s:4:\"time\";i:1446471288;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:16:\"/crm/h-users.php\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"36332d0af7d21788631fd047e5714f60:1446471288:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";users_qs_ce746b0b7166d4b0f070e09225bd7f27|s:504:\"SELECT user.*, email.address as email, org.name as organization\n          , account.id as account_id, account.status as account_status , count(DISTINCT ticket.ticket_id) as tickets  FROM ost_user user LEFT JOIN ost_user_email email ON (user.id = email.user_id) LEFT JOIN ost_organization org ON (user.org_id = org.id) LEFT JOIN ost_user_account account ON (account.user_id = user.id)  LEFT JOIN ost_ticket ticket ON (ticket.user_id = user.id)  WHERE 1  GROUP BY user.id ORDER BY user.name ASC  LIMIT 0,25\";lastcroncall|i:1446471279;cfg:list.1|a:0:{}','2015-11-03 18:34:48','2015-11-02 18:34:48','1','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36'),('vn145nbt2gskb9ck7fmb92agp1','cfg:core|a:2:{s:9:\"tz_offset\";s:3:\"5.0\";s:12:\"db_tz_offset\";s:6:\"5.0000\";}csrf|a:2:{s:5:\"token\";s:40:\"341428119f560e79e0216d068e4db794eea7bc35\";s:4:\"time\";i:1446618524;}TZ_OFFSET|s:4:\"-5.0\";TZ_DST|b:0;cfg:mysqlsearch|a:0:{}_staff|a:1:{s:4:\"auth\";a:2:{s:4:\"dest\";s:25:\"/crm/scp/h-users.php?id=4\";s:3:\"msg\";s:23:\"Authentication Required\";}}_auth|a:1:{s:5:\"staff\";a:2:{s:2:\"id\";s:1:\"1\";s:3:\"key\";s:15:\"local:admin0101\";}}cfg:staff.1|a:0:{}:token|a:1:{s:5:\"staff\";s:76:\"e99eeeb879e5793854347d3f625e4e06:1446618522:837ec5754f503cfaaee0929fd48974e7\";}staff:lang|s:5:\"en_US\";cfg:list.1|a:0:{}','2015-11-05 11:28:44','2015-11-04 11:28:44','1','::1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36');

/*Table structure for table `cit_sla` */


CREATE TABLE `cit_sla` (
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

/*Data for the table `cit_sla` */

insert  into `cit_sla`(`id`,`isactive`,`enable_priority_escalation`,`disable_overdue_alerts`,`grace_period`,`name`,`notes`,`created`,`updated`) values (1,1,1,0,48,'Default SLA','','2015-10-19 11:40:07','2015-10-19 11:40:07');

/*Table structure for table `cit_staff` */


CREATE TABLE `cit_staff` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `cit_staff` */

insert  into `cit_staff`(`staff_id`,`group_id`,`dept_id`,`timezone_id`,`username`,`firstname`,`lastname`,`passwd`,`backend`,`email`,`phone`,`phone_ext`,`mobile`,`signature`,`notes`,`isactive`,`isadmin`,`isvisible`,`onvacation`,`assigned_only`,`show_assigned_tickets`,`daylight_saving`,`change_passwd`,`max_page_size`,`auto_refresh_rate`,`default_signature_type`,`default_paper_size`,`created`,`lastlogin`,`passwdreset`,`updated`) values (1,1,1,8,'admin0101','hafeez','Ullah','$2a$08$Vq9nXseAMofnJ4zWftnhDeL7uMiV53mkIX3tV2Lna7hXCS7Tt/bpi',NULL,'hafeez@convexinteractive.com','',NULL,'','',NULL,1,1,1,0,0,0,0,0,25,0,'none','Letter','2015-10-19 11:40:21','2015-11-04 11:44:16',NULL,'0000-00-00 00:00:00'),(2,2,3,8,'javed','Javed','Ahmed','$2a$08$D6tG5f6wpBhVOsqY8P2THuXpCBCXbo0mAZ3F/wFgaddgaEirJfPxi','','javed@gmail.com','','','(332) 276-9257','','',1,0,1,0,1,0,0,0,0,0,'none','Letter','2015-10-21 14:35:49','2015-10-27 12:07:13',NULL,'2015-10-21 14:38:09');

/*Table structure for table `cit_syslog` */


CREATE TABLE `cit_syslog` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `cit_syslog` */

insert  into `cit_syslog`(`log_id`,`log_type`,`title`,`log`,`logger`,`ip_address`,`created`,`updated`) values (1,'Debug','osTicket installed!','Congratulations osTicket basic installation completed!\n\nThank you for choosing osTicket!','','::1','2015-10-19 11:40:25','2015-10-19 11:40:25'),(2,'Warning','Invalid CSRF Token __CSRFToken__','Invalid CSRF token [61d6ceecf1d9204e2e3acdfada1384cec7484df7] on http://localhost/crm/scp/login.php','','::1','2015-10-29 13:36:00','2015-10-29 13:36:00'),(3,'Error','DB Error #1062','[INSERT INTO ost_user_email SET user_id=4, address=\'hafeez@convexinteractive.com\'] Duplicate entry \'hafeez@convexinteractive.com\' for key \'address\'<br /><br /> ---- Backtrace ----<br /> #0 D:\\xampp\\htdocs\\crm\\include\\mysqli.php(177): osTicket-&gt;logDBError(\'DB Error #1062\', \'[INSERT INTO os...\')<br /> #1 D:\\xampp\\htdocs\\crm\\include\\class.client-h.php(19): db_query(\'INSERT INTO ost...\')<br /> #2 D:\\xampp\\htdocs\\crm\\h-account.php(34): ClientInfo_h::addUserH(Array)<br /> #3 {main}','','::1','2015-11-02 15:21:43','2015-11-02 15:21:43'),(4,'Error','DB Error #1062','[INSERT INTO ost_user_email SET user_id=5, address=\'shoaib@convex.com\'] Duplicate entry \'shoaib@convex.com\' for key \'address\'<br /><br /> ---- Backtrace ----<br /> #0 D:\\xampp\\htdocs\\crm-merged\\include\\mysqli.php(177): osTicket-&gt;logDBError(\'DB Error #1062\', \'[INSERT INTO os...\')<br /> #1 D:\\xampp\\htdocs\\crm-merged\\include\\class.client-h.php(19): db_query(\'INSERT INTO ost...\')<br /> #2 D:\\xampp\\htdocs\\crm-merged\\h-account.php(34): ClientInfo_h::addUserH(Array)<br /> #3 {main}','','::1','2015-11-04 11:46:49','2015-11-04 11:46:49');

/*Table structure for table `cit_team` */


CREATE TABLE `cit_team` (
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

/*Data for the table `cit_team` */

insert  into `cit_team`(`team_id`,`lead_id`,`isenabled`,`noalerts`,`name`,`notes`,`created`,`updated`) values (1,0,1,0,'Level I Support','Tier 1 support, responsible for the initial iteraction with customers','2015-10-19 11:40:09','2015-10-19 11:40:09');

/*Table structure for table `cit_team_member` */


CREATE TABLE `cit_team_member` (
  `team_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`team_id`,`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_team_member` */

/*Table structure for table `cit_ticket` */


CREATE TABLE `cit_ticket` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_ticket` */

/*Table structure for table `cit_ticket__cdata` */


CREATE TABLE `cit_ticket__cdata` (
  `ticket_id` int(11) unsigned NOT NULL DEFAULT '0',
  `subject` mediumtext,
  `priority` mediumtext,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_ticket__cdata` */

/*Table structure for table `cit_ticket_attachment` */


CREATE TABLE `cit_ticket_attachment` (
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

/*Data for the table `cit_ticket_attachment` */

/*Table structure for table `cit_ticket_collaborator` */


CREATE TABLE `cit_ticket_collaborator` (
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

/*Data for the table `cit_ticket_collaborator` */

/*Table structure for table `cit_ticket_email_info` */


CREATE TABLE `cit_ticket_email_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) unsigned NOT NULL,
  `email_mid` varchar(255) NOT NULL,
  `headers` text,
  PRIMARY KEY (`id`),
  KEY `email_mid` (`email_mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_ticket_email_info` */

/*Table structure for table `cit_ticket_event` */


CREATE TABLE `cit_ticket_event` (
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

/*Data for the table `cit_ticket_event` */

insert  into `cit_ticket_event`(`ticket_id`,`staff_id`,`team_id`,`dept_id`,`topic_id`,`state`,`staff`,`annulled`,`timestamp`) values (1,0,0,1,1,'created','SYSTEM',0,'2015-10-19 11:40:24'),(1,0,0,1,1,'overdue','SYSTEM',0,'2015-10-21 13:38:34');

/*Table structure for table `cit_ticket_lock` */


CREATE TABLE `cit_ticket_lock` (
  `lock_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `expire` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`lock_id`),
  UNIQUE KEY `ticket_id` (`ticket_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_ticket_lock` */

/*Table structure for table `cit_ticket_priority` */


CREATE TABLE `cit_ticket_priority` (
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

/*Data for the table `cit_ticket_priority` */

insert  into `cit_ticket_priority`(`priority_id`,`priority`,`priority_desc`,`priority_color`,`priority_urgency`,`ispublic`) values (1,'low','Low','#DDFFDD',4,1),(2,'normal','Normal','#FFFFF0',3,1),(3,'high','High','#FEE7E7',2,1),(4,'emergency','Emergency','#FEE7E7',1,1);

/*Table structure for table `cit_ticket_status` */


CREATE TABLE `cit_ticket_status` (
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

/*Data for the table `cit_ticket_status` */

insert  into `cit_ticket_status`(`id`,`name`,`state`,`mode`,`flags`,`sort`,`properties`,`created`,`updated`) values (1,'Open','open',3,0,1,'{\"description\":\"Open tickets.\"}','2015-10-19 11:40:09','0000-00-00 00:00:00'),(2,'Resolved','closed',1,0,2,'{\"allowreopen\":true,\"reopenstatus\":0,\"description\":\"Resolved tickets\"}','2015-10-19 11:40:10','0000-00-00 00:00:00'),(3,'Closed','closed',3,0,3,'{\"allowreopen\":true,\"reopenstatus\":0,\"description\":\"Closed tickets. Tickets will still be accessible on client and staff panels.\"}','2015-10-19 11:40:10','0000-00-00 00:00:00'),(4,'Archived','archived',3,0,4,'{\"description\":\"Tickets only adminstratively available but no longer accessible on ticket queues and client panel.\"}','2015-10-19 11:40:10','0000-00-00 00:00:00'),(5,'Deleted','deleted',3,0,5,'{\"description\":\"Tickets queued for deletion. Not accessible on ticket queues.\"}','2015-10-19 11:40:10','0000-00-00 00:00:00');

/*Table structure for table `cit_ticket_thread` */


CREATE TABLE `cit_ticket_thread` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cit_ticket_thread` */

/*Table structure for table `cit_timezone` */


CREATE TABLE `cit_timezone` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `offset` float(3,1) NOT NULL DEFAULT '0.0',
  `timezone` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `cit_timezone` */

insert  into `cit_timezone`(`id`,`offset`,`timezone`) values (1,-12.0,'Eniwetok, Kwajalein'),(2,-11.0,'Midway Island, Samoa'),(3,-10.0,'Hawaii'),(4,-9.0,'Alaska'),(5,-8.0,'Pacific Time (US & Canada)'),(6,-7.0,'Mountain Time (US & Canada)'),(7,-6.0,'Central Time (US & Canada), Mexico City'),(8,-5.0,'Eastern Time (US & Canada), Bogota, Lima'),(9,-4.0,'Atlantic Time (Canada), Caracas, La Paz'),(10,-3.5,'Newfoundland'),(11,-3.0,'Brazil, Buenos Aires, Georgetown'),(12,-2.0,'Mid-Atlantic'),(13,-1.0,'Azores, Cape Verde Islands'),(14,0.0,'Western Europe Time, London, Lisbon, Casablanca'),(15,1.0,'Brussels, Copenhagen, Madrid, Paris'),(16,2.0,'Kaliningrad, South Africa'),(17,3.0,'Baghdad, Riyadh, Moscow, St. Petersburg'),(18,3.5,'Tehran'),(19,4.0,'Abu Dhabi, Muscat, Baku, Tbilisi'),(20,4.5,'Kabul'),(21,5.0,'Ekaterinburg, Islamabad, Karachi, Tashkent'),(22,5.5,'Bombay, Calcutta, Madras, New Delhi'),(23,6.0,'Almaty, Dhaka, Colombo'),(24,7.0,'Bangkok, Hanoi, Jakarta'),(25,8.0,'Beijing, Perth, Singapore, Hong Kong'),(26,9.0,'Tokyo, Seoul, Osaka, Sapporo, Yakutsk'),(27,9.5,'Adelaide, Darwin'),(28,10.0,'Eastern Australia, Guam, Vladivostok'),(29,11.0,'Magadan, Solomon Islands, New Caledonia'),(30,12.0,'Auckland, Wellington, Fiji, Kamchatka');

/*Table structure for table `cit_user` */


CREATE TABLE `cit_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(10) unsigned NOT NULL,
  `default_email_id` int(10) NOT NULL,
  `status` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `phone` varchar(50) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `org_id` (`org_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `cit_user` */

insert  into `cit_user`(`id`,`org_id`,`default_email_id`,`status`,`name`,`phone`,`created`,`updated`) values (1,1,1,0,'osTicket Support','0','2015-10-19 11:40:23','2015-10-19 11:40:24'),(2,0,2,0,'Javad Ahmed','923322769233','2015-10-21 09:48:07','2015-10-21 15:03:15'),(3,0,3,0,'Salman','0','2015-10-27 14:19:49','2015-10-27 14:32:05'),(4,0,3,0,'Hafeez Ullah','923322769257','2015-11-02 11:21:29','2015-11-02 11:21:42'),(5,0,4,0,'Shoaib','9233227692445','2015-11-04 07:45:12','2015-11-04 07:46:48'),(6,0,6,0,'Haider','923322769986','2015-11-04 07:47:23','2015-11-04 07:48:24'),(7,0,0,0,'','923322439654','2015-11-04 07:51:46','2015-11-04 07:51:46'),(8,0,7,0,'Saeed','923322453456','2015-11-04 07:54:38','2015-11-04 11:56:56');

/*Table structure for table `cit_user_account` */


CREATE TABLE `cit_user_account` (
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `cit_user_account` */

insert  into `cit_user_account`(`id`,`user_id`,`status`,`timezone_id`,`dst`,`lang`,`username`,`passwd`,`backend`,`registered`) values (1,2,0,21,1,NULL,NULL,NULL,NULL,'2015-10-21 12:48:22'),(2,4,0,21,1,NULL,NULL,NULL,NULL,'2015-11-02 15:21:44'),(3,5,0,21,1,NULL,NULL,NULL,NULL,'2015-11-04 11:45:27'),(4,5,0,21,1,NULL,NULL,NULL,NULL,'2015-11-04 11:46:49'),(5,6,0,21,1,NULL,NULL,NULL,NULL,'2015-11-04 11:48:24'),(6,8,0,21,1,NULL,NULL,NULL,NULL,'2015-11-04 11:55:37');

/*Table structure for table `cit_user_email` */


CREATE TABLE `cit_user_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `address` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address` (`address`),
  KEY `user_email_lookup` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `cit_user_email` */

insert  into `cit_user_email`(`id`,`user_id`,`address`) values (1,1,'support@osticket.com'),(2,2,'hafeez@convexinteractive.com'),(3,3,'salman.msc@gmail.com'),(4,5,'shoaib@convex.com'),(6,6,'tickets@gmail.com'),(7,8,'saeed@gmail.com');

