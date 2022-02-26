<?php
// Getting the information
$ipaddress = $_SERVER['REMOTE_ADDR'];
$page = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
if(!empty($_SERVER['QUERY_STRING'])){
	$page .= "?{$_SERVER['QUERY_STRING']}";
}
$referrer = $_SERVER['HTTP_REFERER'];
$datetime = date("Y-m-d H:i:s");
$useragent = $_SERVER['HTTP_USER_AGENT'];
$remotehost = ""; // @getHostByAddr($ipaddress);

//$sqlVisitorTracking = "insert into `".$db_prefix."_visitor_tracking` (`ipaddress`, `referrer`, `datetime`, `useragent`, `remotehost`,`page`) values ('".$ipaddress."', '".$referrer."', '".$datetime."', '".$useragent."', '".$remotehost."', '".$page."');";
//$db_conn->Execute($sqlVisitorTracking);

// Create log line
$logline = $ipaddress . '|' . $referrer . '|' . $datetime . '|' . $useragent . '|' . $remotehost . '|' . $page . "\n";

// Write to log file:
$logfile = $site_root.'server_log/visitor_log_'.date("dmY").'.txt';
// Open the log file in "Append" mode
if (!$handle = fopen($logfile, 'a+')) {
    die("Failed to open log file1");
}
// Write $logline to our logfile.
if (fwrite($handle, $logline) === FALSE) {
    die("Failed to write to log file");
}
fclose($handle);

?>
