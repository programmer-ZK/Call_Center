<?php include_once("includes/config.php"); ?>
<?php  
        $page_name = "monthly-stats.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Monthly Stats";
        $page_menu_title = "Monthly Stats";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
	include_once("classes/admin.php");
	$admin = new admin();

	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
?>	
<?php include($site_root."includes/header.php"); ?>	
<!--<meta http-equiv="refresh" content="2">-->

<style>
#right-col{
display:none;
}
</style>
<?php
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
	
	//$total_records_count = $admin->get_records_count($txtSearch);
	//include_once("includes/paging.php");
	$recStartFrom = 0;
	$field = empty($_REQUEST["field"])?"staff_updated_date":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"asc":$_REQUEST["order"];
	//$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>

<?php
	
	
if(isset($_REQUEST['search_date']))
{
    $month = $_REQUEST['month'];
	$monthArray = explode('/',$month);

	$monthNumber = $monthArray[0];
	$rs = $admin->get_agents_monthly_stats($month);  
	
//	echo "&nbsp;&nbsp;From: <b>".$_REQUEST["fdate"]." ".$_REQUEST['static_stime']."</b> ";
//	echo "To: <b>".$_REQUEST["tdate"]." ".$_REQUEST['static_etime']."</b><br>";
	
		//echo "&nbsp;&nbsp;From: <b>".$_REQUEST["fdate"]." ".$static_stime."</b> ";
	//echo "To: <b>".$_REQUEST["tdate"]." ".$static_etime."</b><br>";	
	
			//if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"]))
			//{	
				//$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
				
			//}	
		
}/*else
{
	$monthNumber = date('n');
	$month	= date('n/Y');
}*/
	
	
/************************* Export to Excel ******************/
if(isset($_REQUEST['export']))
{
   //print_r($_REQUEST);
   //die;
	$stringData	= trim($_REQUEST['stringData']);
	$stringData = str_replace('<tag1>',null,$stringData);
	$stringData = str_replace('</tag1>',null,$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);
	
	

	$db_export_fix = $site_root."download/Monthly_Records.csv";
	//echo $stringData; exit;
	shell_exec("echo '".$stringData."' > ".$db_export_fix);
		
	ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-type: application/force-download");
    //header("Content-Type: text/csv");
    
	//echo $db_export; exit;
    header("Content-Disposition: attachment; filename=".basename($db_export_fix).";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($db_export_fix));
    readfile($db_export_fix);
    if(file_exists($db_export_fix) && !empty($file_name)){
     unlink($db_export_fix);
     }
     exit();
	
}

if(isset($_REQUEST['export_pdf']))
{
								
	$stringData			= $_REQUEST['stringData'];
	$db_export_fix = $site_root."download/Daily_Records.csv";
	//echo $stringData; exit;
	shell_exec("echo '".$stringData."' > ".$db_export_fix);
								
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	$tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 12, 'Daily_Records.pdf', 'D', 40, 10, 1);
	exit();
}

/******************************************************************************/	
	
	
?>
<style>
div#mid-col{ float:none !important;; margin: 0 auto !important;}
</style>
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Monthly Incoming Calls Summery </div>

<div>
<form action="<?php  echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" >
<div class="box">
<?php  include($site_admin_root."includes/month_search_bar.php"); 
$stringData	 = '';
?>
</div>
	<br />
	<?php 
	
	$year =  strstr($month, '/');
	$monthNum = strtok($month, '/');;
    $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
	$year1 = str_replace("/","",$year);

	$stringData .= "<tag1> ".$monthName.'-'.$year1 ." Calls Stats</tag1>\r\n";
	//include($site_admin_root."queue_wait_stats.php"); 
	include($site_admin_root."queue_monthly_stats.php"); 
	
	//$stringData .= "\r\n\r\n";
	/*$stringData .= "<tag1>Drop Calls Stats</tag1>\r\n";
	?>
	<br />
	<?php include($site_admin_root."drop_call_stats.php"); 
	//$stringData .= "\r\n\r\n";
	$stringData .= "<tag1>Off Time Calls Stats</tag1>\r\n";
	?>
	<br />
	<?php include($site_admin_root."off-time-stats.php");*/ ?>
	

</form>
<form action="<?php  echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2">

	<div style="float:right">
			 <a class="button" href="javascript:document.xForm2.submit();" >
			 <span>Export EXCEL</span>
			 </a>
			<input type="hidden" value="export >>" id="export" name="export" />
			
			<input type="hidden" value="<?php echo $stringData; ?>" id="stringData"		name="stringData" />
			<!--<input type="hidden" value="<?php //echo $stringDataHeader; ?>" id="stringDataHeader"		name="stringDataHeader" />-->

	</div>
</form>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">

	<div style="float:right">
			 <a class="button" href="javascript:document.xForm3.submit();" >
			 <span>Export PDF</span>
			 </a>
			<input type="hidden" value="exportpdf" id="export_pdf" name="export_pdf" />
			
			<input type="hidden" value="<?php echo $stringData; ?>" id="stringData"		name="stringData" />
			<!--<input type="hidden" value="<?php //echo $stringDataHeader; ?>" id="stringDataHeader"		name="stringDataHeader" />-->

	</div>
</form>
</div>
<?php include($site_admin_root."includes/footer.php"); ?>
