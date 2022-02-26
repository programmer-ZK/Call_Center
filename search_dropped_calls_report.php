<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "search_dropped_calls_report.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Dropped Calls Report";
        $page_menu_title = "Droped Calls Report";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/reports.php");
	$reports = new reports();
?>	
<?php include($site_root."includes/header.php"); ?>	

<script type="text/javascript" language="javascript1.2">
function getvalues() {

	var fdate = document.getElementById("fdate").value;
	var tdate = document.getElementById("tdate").value;
	
	if (fdate == null || tdate == null){
	
		alert("Please select valid values!");
		return false;
	}
	else{
	
		return popitup('dropped_calls_report.php?fdate='+fdate+'&tdate='+tdate);
	}

}

function popitup(url) {
	newwindow=window.open(url,'name','height=660,width=1024,scrollbars=1');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
   
<!--<meta http-equiv="refresh" content="2">-->
<?php

	
if(isset($_REQUEST['search_date']))
{
//echo "asdasdas";exit;
	//$keywords			= $_REQUEST['keywords'];
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	
if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"]))
{	
				//$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
				
}	
		
}else
{
	$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
	$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];
	//$keywords 		= empty($_REQUEST["keywords"])?"":$_REQUEST["keywords"];
	$search_keyword = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];
	
}

?>

<?php 
/************************* Export to Excel ******************/
/*if(isset($_REQUEST['export']))
{
	
	$stringData			= trim($_REQUEST['stringData']);
	//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
	$db_export_fix = $site_root."download/Productivity_Report.csv";
	//echo $stringData; exit;
	 
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
		
		 ob_end_clean();
	header('Content-disposition: attachment; filename='.basename($db_export_fix));
	header('Content-type: text/csv');
	readfile($db_export_fix);
    if(file_exists($db_export_fix) && !empty($file_name)){
     unlink($db_export_fix);
     }
     exit();
		 
		 
		 
		 
   /* header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-type: application/force-download");
    //header("Content-Type: text/csv");
    
	//echo $db_export; exit;
    header("Content-Disposition: attachment; filename=".basename($db_export_fix).";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($db_export_fix));
    readfile(trim($db_export_fix));
    if(file_exists($db_export_fix) && !empty($file_name)){
     unlink($db_export_fix);
     }
     exit();*/
	
/*}

if(isset($_REQUEST['export_pdf']))
{
								
	$stringData			= trim($_REQUEST['stringData']);
	//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
	$db_export_fix = $site_root."download/Productivity_Report.csv";
	//echo $stringData; exit;
	 
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
								
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	$tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 10, 'Productivity_Records.pdf', 'D', 60, 7, 1);
	exit();
}*/
/******************************************************************************/	
//$stringData	 = '';
?>


<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Dropped Calls Detail Report</div>
<div>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">

<div id="mid-col" class="mid-col">
	<div class="box">
	 
	<h4 class="white">
	<table>
		<tr>
			<td style="padding-right:5px">
				From Date :
			</td>
			<td>
	 			<label>
				<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo $fdate; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown')">
				</label>
			</td>
			<!--<td style="padding-left:20px">
				<label>
				
				<?php //echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name","",false,"form-select",$search_keyword,"Agent"," designation = 'Agents' "); ?>
				</label>
			</td>-->
			
		</tr>
		<tr>
			<td style="padding-top:10px">
				To Date :
			</td>
			<td>
	 			<label>
				<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo $tdate; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('tdate','yyyyMMdd', 'dropdown')">
				</label>
			</td>
			<td>
				<a class="button" href="" onClick="javascript:return getvalues();" >
		 		<span>Search</span>
		 		</a>
				<input type="hidden" value="Search >>" id="search_date" name="search_date" />
			</td>
		</tr>
	</table>
	
	</h4>
	</div>
</div>
	
</form>
</div>

<?php include($site_admin_root."includes/footer.php"); ?>