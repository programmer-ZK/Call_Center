<?php
ob_start();
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
/* Company Configuration */
$company_name 	= "M3techCC";
$crm_name	= "UBL Fund Managers";
$support_email  = "";

/* End Company Configuration */




/* Url & Directory Variables*/
$host			= $_SERVER['SERVER_NAME'];
$folder			= "/";
$site_url		= "http://".$host.$folder;
$site_root      	= $_SERVER["DOCUMENT_ROOT"]."/".$folder;
$asterisk_path 		= $site_root."asterisk_conf/";

/* End Url & Directory Variables*/

$current_session_id = session_id();

/*  Admin Id */
$ADMIN_ID1 = 9030;
$ADMIN_ID2 = 9035;
$ADMIN_ID3 = 9036;
$ADMIN_ID4 = 9037;
$ADMIN_ID5 = 9039;
$ADMIN_ID6 = 9070;


/* For admin */
$global_page_count_limit_for_admin 	= 10;
$page_records_limit 			= 30;
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
//$web_service_ip = "http://10.4.29.224:82/";
//$web_service_ip = "http://10.4.29.214:82/";
$web_service_ip = "http://10.4.29.214:8040/";
$web_service_url = $web_service_ip."Service.asmx?wsdl";
$access_key= 'd@h-33';
$channel='IVR';
/* Web Service Info End */

require($site_root."includes/visitor_tracking.php");

/* PDF file generation using FPDF library */
require("lib/fpdf/fpdf.php");
require("classes/pdfgen.php");

require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_line.php');

?>
