<?php ob_start(); ?>
<?php include($site_root."includes/make_page_url.php"); ?>
<?php include($site_root."includes/visitor_tracking.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $crm_name;?></title>
<!--    <link href="css/reset.css" rel="stylesheet" type="text/css" />-->
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/screen.css" rel="stylesheet" type="text/css" />
    <link href="js/jquery.wysiwyg.css" rel="stylesheet" type="text/css" />
    <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox.css" />
    <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox-custom.css" />
	<script src="js/datetimepicker_css.js"></script>
	<style type="text/css">
	        div.wysiwyg ul.panel li {padding:0px !important;}
			div#content {padding-top: 40px;} 
    </style>
    
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.colorbox-min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.js"></script>
    <script type="text/javascript" src="js/jquery.corners.min.js"></script>
    <script type="text/javascript" src="js/bg.pos.js"></script>
    <script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
    <script src="js/tabs.pack.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/cleanity.js"></script>
<style>
	#navlist li
	{
	display: inline;
	list-style-type: none;
	padding-right: 20px;
	}
</style>
</head>

<body style="background:none;">
<div id="container">

<!--    <div id="header">
      <div id="top">
      <h1><a href="index.php"><?php echo $crm_name; ?></a></h1>
      <p id="userbox">Hello <strong><?php echo $_SESSION[$db_prefix.'_UserName']; ?></strong> &nbsp;| &nbsp;<a href="admin_change_password.php">Settings</a> &nbsp;| &nbsp;<a href="logout.php">Logout</a> <br />
      <small>Last Login: <?php echo $_SESSION[$db_prefix.'_LLoginTime'];  ?></small></p>
      <span class="clearFix">&nbsp;</span>
      </div>
    </div>-->

<div id="content">
    
  <div id="mid-col">
 	 <?php // include($site_root."includes/message_panel.php"); ?>

<?php 
$static_time_array = array('00:00:00','01:00:00','02:00:00','03:00:00','04:00:00','05:00:00','06:00:00','07:00:00','08:00:00','09:00:00','10:00:00','11:00:00','12:00:00','13:00:00','14:00:00','15:00:00','16:00:00','17:00:00','18:00:00','19:00:00','20:00:00','21:00:00','22:00:00','23:00:00');
$static_hours_array = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
$static_minutes_array = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59');
?>