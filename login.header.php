<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>

<?php include_once("classes/admin.php");
require 'PHPMailer-master/PHPMailerAutoload.php';
$admin = new admin();
global $admin;
?>
<?php
$page_name = "login";
$page_level = "0";
$page_group_id = "0";
$page_title = "login";
$page_menu_title = "login";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo "Bahria ODN" ?></title>
	<style type="text/css">
		html,
		body {
			background: url(images/bg_login.png) no-repeat left top;
			background-size: 100% 100%;
			height: 100%;
		}

		div#distance {
			margin-bottom: -10em;
			width: 1px;
			height: 50%;
			float: left;
		}

		div#container {
			width: 980px;
			position: relative;
			/*min-height: 100%;*/
			height: auto !important;
			height: 100%;
			margin: 0 auto;
			text-align: center;
		}

		body {
			margin: 0;
			padding: 0;
			font-family: Helvetica, Arial, Tahoma, serif;
			font-size: 9pt;
		}

		h1 {
			font-size: 250%;
			text-transform: uppercase;
			letter-spacing: -1px;
			font-weight: bold;
			/*width: 450px;*/
			margin: 0 0 35px 0;
			padding: 0;
		}

		h1 a {
			color: #fff;
			text-decoration: none;
		}

		h1 a:hover {
			color: #ccc;
		}

		fieldset,
		form {
			margin: 0;
			padding: 0;
			border: 0;
			outline: 0;
			width: 100%;
			float: left;
		}

		fieldset h2 {
			display: inline-block;
			width: 225px;
			margin: 0;
			font-size: 22px;
			color: #fff;
			background: #b5824f;
			/* background: url(images/bg_active.png) repeat; */
			padding: 8px 0;
			-webkit-box-shadow: inset 0px 5px 10px 2px rgba(0, 0, 0, 0.5);
			-moz-box-shadow: inset 0px 5px 10px 2px rgba(0, 0, 0, 0.5);
			box-shadow: inset 0px 5px 10px 2px rgba(0, 0, 0, 0.5);
			border-radius: 10px 10px 0px 0px;
			-moz-border-radius: 10px 10px 0px 0px;
			-webkit-border-radius: 10px 10px 0px 0px;
		}

		ol {
			margin: 0;
			padding: 0;
			list-style: none;
			color: #111111;
			width: 330px;
			float: left;
			padding: 30px;
			background: #e1e1e1;
			border: solid 1px #fff;
			-webkit-box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.75);
			-moz-box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.75);
			box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.75);
			border-radius: 5px 5px 5px 5px;
			-moz-border-radius: 5px 5px 5px 5px;
			-webkit-border-radius: 5px 5px 5px 5px;
		}

		ol li {
			float: left;
			margin-bottom: 15px;
			width: 100%;
		}

		ol li:last-child {
			margin-bottom: 0px;
		}

		label {
			display: block;
		}

		label.txt-field {
			width: 100%;
			/*height: 21px;
		background: url(images/bg-loginboxes.gif) no-repeat;*/
			float: left;
		}

		label.txt-field input {
			/*border: none;
		background: none;*/
			padding: 10px;
			outline: none;
			width: 308px;
			float: left;
		}

		label.remember {
			color: #111111;
			float: left;
			width: 150px;
			text-align: left;
		}

		a.forgot {
			color: #111111;
			float: right;
			text-align: left;
			margin-top: 3px;
		}

		div.align-right {
			float: left;
			width: 100%;
			margin-top: 20px;
		}

		#login {
			/*float: right;*/
			background: none;
			border: none;
			width: 58%;
			border-radius: 0px 0px 10px 10px;
			background: #b5824f;
			/*  background: url(images/login_bg_btn.png) no-repeat; */
			color: #fff;
			height: 47px;
			background-size: 100%;
			font-size: 22px;
			font-weight: bold;
			-webkit-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.3);
			-moz-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.3);
			box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.3);
		}

		#login:hover {}

		.main_header {
			background: #b5824fbf;
			/* background: #fff; */
			/*background:#0c3779;*/
			width: 100%;
			display: inline-block;
			border-top: solid 12px #b5824f;
			border-bottom: solid 5px #b5824f;
			/*-webkit-box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.3);
		-moz-box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.3);
		box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.3);*/
		}

		div#header {
			padding-top: 20px;
		}

		/** logo, which is a typographical h1 element (you can edit this part if you want to replace with your logo graphic) **/
		div#header h1 {
			font-size: 250%;
			text-transform: uppercase;
			letter-spacing: -1px;
			font-weight: bold;
			float: left;
			/** mac safari & firefox hack height: 39px;*/
		}

		div#header h1 a {
			color: #fff;
			text-decoration: none;
		}

		div#header h1 a:hover {
			color: #ccc;
		}

		div#footer-wrap {
			/*background: url(images/footer_bg.jpg) left top no-repeat;*/
			background: #b5824fbf;
			height: 87px;
			background-size: 100%;
			position: absolute;
			width: 100%;
			bottom: 0px;
			color: #ccc;
		}

		div#footer {
			width: 1300px;
			margin: 0 auto;
		}

		.right-foot a {
			color: #ccc;
		}

		div#footer-top {
			color: #f2f2f2;
		}

		div#footer-top h4 {
			color: #fff;
			text-transform: uppercase;
			margin: 5px 0;
			font-size: 120%;
			font-weight: bold;
		}

		div#footer-top a {
			color: #adc3d3;
			font-weight: bold;
			font-size: 0.9em;
			text-decoration: none;
		}

		div#footer-top a:hover {
			color: #fff;
		}

		div#footer-top h2 {
			font-size: 160%;
			text-transform: uppercase;
			padding-top: 10px;
			padding-right: 10px;
			font-weight: bold;
		}

		div#footer-top h2 a {
			color: #a1a5a6;
		}

		div#footer-top h2 a:hover {
			color: #c7cdcf;
		}

		div#footer-bottom {
			margin-top: 25px;
			float: left;
			margin-right: 120px;
		}

		div#footer-bottom p {
			color: #fff;
			font-size: 14px;
			float: left;
			margin-top: 10px;
			line-height: 10px;
			margin-left: 170px;
		}

		div#footer-bottom p a {
			color: #ccc;
			text-decoration: none;
			float: left;
			margin-top: -10px;
			margin-left: 10px;
		}

		div#footer-bottom p a+a {
			margin-top: 1px;
		}

		div#footer-bottom p span {
			float: left;
		}

		div#footer-bottom p a img {
			float: left;
		}

		#form-container {
			display: inline-block;
			width: 392px;
			margin: 50px 0 0;
		}

		.login_logo {
			display: inline-block;
		}
	</style>
</head>

<body>