<?php
error_reporting(0);
ob_start();
session_start();
date_default_timezone_set('Asia/Karachi');
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
/* Company Configuration */
$company_name 	= "OutSource";
$crm_name	= "Kababjees";
$support_email  = "";

/* End Company Configuration */

/* NO OF USERS TO LOGIN AT SAME TIME */
$limit_of_login_users = '500';


/* Url & Directory Variables*/
$host			= $_SERVER['SERVER_NAME'];
$folder			= "/";
$site_url		= "http://".$host.$folder;
$site_root      	= $_SERVER["DOCUMENT_ROOT"]."/Octopus".$folder;
$asterisk_path 		= $site_root."asterisk_conf/";
define('IMG_PATH',"http://".$_SERVER['SERVER_NAME'].'/'.'Octopus'.'/images/');
/* End Url & Directory Variables*/

$current_session_id = session_id();

/*  Admin Id */
$ADMIN_ID1 = 9030;
$ADMIN_ID2 = 9035;
$ADMIN_ID3 = 9036;
$ADMIN_ID4 = 9037;
$ADMIN_ID5 = 9039;



/* For admin */
$global_page_count_limit_for_admin 	= 10;
$page_records_limit 			= 25;
$db_export				= $site_root."tmp/";
/* For admin End*/

/* DB CONNECTION 		*/
include_once("includes/mailserver_info.php");
include_once("includes/db_info.php");
include_once("classes/database.php");
if (!$db_conn->Connect($db_server,$db_user,$db_pass,$db_name)){
    echo('Failed to connect to db.');
	exit();
}
/* Web Service Info */

//M3tech Testing Server
/* Web Service Info End */

//require($site_root."includes/visitor_tracking.php");

/* PDF file generation using FPDF library */
require("lib/fpdf/fpdf.php");
require("classes/pdfgen.php");
include_once($site_root.'/mpdf/mpdf.php');

//require_once ('lib/jpgraph/src/jpgraph.php');
//require_once ('lib/jpgraph/src/jpgraph_line.php');
	

?>
