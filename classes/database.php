<?php
	include ("db/adodb.inc.php");
	$dbdriver = 'mysql';
	$db_conn = ADONewConnection($dbdriver);
	$db_conn->debug = false;
?>
