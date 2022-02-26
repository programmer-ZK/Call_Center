<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "call_center_report.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Call Center Report";
        $page_menu_title = "Call Center Report";
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
   
<!--<meta http-equiv="refresh" content="2">-->

<?php
	


if(isset($_REQUEST['search_date']))
{
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
	
$nature_of_calls = $reports->nature_of_calls($fdate, $tdate);
$drop_calls = $reports->drop_calls($fdate, $tdate);
$off_time_calls = $reports->off_time_calls($fdate, $tdate);
$total_talk_time = $reports->total_talk_time($fdate, $tdate);
$busy_time = $reports->busy_time($fdate, $tdate);
$avg_busy_time = $reports->avg_busy_time($fdate, $tdate);
$average_queue_time = $reports->average_queue_time($fdate, $tdate);
$avg_total_talk_time =  $reports->avg_total_talk_time($fdate, $tdate);
$pin_report = $reports->pin_report($fdate, $tdate);
$trans_report = $reports->trans_report($fdate, $tdate);
	
?>

<?php	

	$recStartFrom = 0;
	$field = empty($_REQUEST["field"])?"staff_updated_date":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"asc":$_REQUEST["order"];
	$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order,'','');
	$groups = $reports->get_evaluation_groups();
	
	$evaluated_call_counts = $reports->get_evaluated_calls_count($search_keyword,$fdate,$tdate);
	
?>

<?php 
/************************* Export to Excel ******************/
if(isset($_REQUEST['export']))
{
	
	$stringData			= trim($_REQUEST['stringData']);
	$stringData = str_replace('<tag1>',null,$stringData);
	$stringData = str_replace('</tag1>',null,$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);
	$stringData = str_replace('<tag3>',null,$stringData);
	$stringData = str_replace('</tag3>',null,$stringData);
	$stringData = str_replace('<tag1a>',null,$stringData);
	$stringData = str_replace('</tag1a>',null,$stringData);
	
	//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
	$db_export_fix = $site_root."download/Call_Center_Report.csv";
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
	
}

if(isset($_REQUEST['export_pdf']))
{
								
	$stringData			= trim($_REQUEST['stringData']);
	//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
	$db_export_fix = $site_root."download/Call_Center_Report.csv";
	//echo $stringData; exit;
	 
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
								
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'Call_Center_Report.pdf', 'D', 160, 16, 1);
	exit();
}
/******************************************************************************/	
$stringData	 = '';
?>


<div>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">

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
				<a class="button" href="javascript:document.xForm.submit();" >
		 		<span>Search</span>
		 		</a>
				<input type="hidden" value="Search >>" id="search_date" name="search_date" />
			</td>
		</tr>
	</table>
	
	</h4>
	
	
	<?php $break = 0; ?>
	<br />
	<!--<h4 class="white"><?php 
	//echo "Agent Performance Report  <br> Agent Name - ".$rs_agent_name->fields["full_name"]." <br> Date: ".$fdate." - ".$tdate." <br> Average Evaluator Per Call: ".$avg_evaluator; 
	//$stringData .= "Agent Productivity Report\r\n";
	//$stringData .= "Agent Name - ".$rs_agent_name->fields["full_name"]." \r\nDate: ".$fdate."\r\n";
	?></h4>-->
	<br />
	
	<h4 class="white">
	 	<?php 	
		echo "Nature of Calls";
		$stringData .= "<tag1>Nature of Calls</tag1>\r\n";
		$stringData .= "<tag2>Call Type</tag2>,<tag2>Number of Calls</tag2>,<tag2>Percent</tag2>\r\n"; 
		?>
	</h4>
	<div class="box-container"  >  		
				<table class="table-short">
					<thead>
						<tr>
							<td colspan="12" class="paging"><?php //echo($paging_block);?></td>
						</tr>
						<tr>
							<td class="col-head2">Call Type</td>
							<td class="col-head2" style="padding-left:10px">Number of Calls </td>
							<td class="col-head2" style="padding-left:10px">Percent </td>
							
							
						</tr>
					</thead>
					
					<tbody>
					<?php 
					$t_calls = 0;
					while(!$nature_of_calls->EOF){  
					
						$stringData .= $nature_of_calls->fields['call_type'].",".$nature_of_calls->fields['total_calls'].",".$nature_of_calls->fields['percent']."\r\n";
					?>
						<tr class="odd">
							
							<td class="col-first"><?php 
							$t_calls =  $nature_of_calls->fields["total"];
							echo($nature_of_calls->fields["call_type"]); ?>  </td>
							<td class="col-first" style="padding-left:10px"><?php echo($nature_of_calls->fields["total_calls"]); ?> </td>
							<td class="col-first" style="padding-left:10px"><?php echo(round($nature_of_calls->fields["percent"],2)."%"); ?> </td>				
					</tr>
					<?php $nature_of_calls->MoveNext(); } ?>
					<tr class="odd">
						<td class="col-first">Total :</td>
						<td class="col-first" style="padding-left:10px">
						<?php $stringData .= "Total: ,".$t_calls.",\r\n"; echo($t_calls); ?>
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
					</tr>
					</tbody>
				</table>
				</div>
					
		<br />
	
	<h4 class="white">
	 	<?php 	
		echo "Drop Calls: "; 
		$stringData .= "<tag1a>Drop Calls: ".$drop_calls->fields['drop_calls']."</tag1a>\r\n";
		?>
		
		<?php echo($drop_calls->fields["drop_calls"]); ?>
	</h4>
	
   <br />
	
	<h4 class="white">
	 	<?php 	
		echo "Off Time Calls: "; 
		$stringData .= "<tag1a>Off Time Calls: ".$off_time_calls->fields['off_calls']."</tag1a>\r\n";
		?>
		
		<?php echo($off_time_calls->fields["off_calls"]); ?>
	</h4>
	
   
   <br />
	
	<h4 class="white">
	 	<?php 	
		echo "Total Talk Time"; 
		$stringData .= "<tag1>Total Talk Time</tag1>\r\n";
		$stringData .= "<tag2>Call Type</tag2>,<tag2>Talk Time</tag2>,<tag2>Busy Time</tag2>\r\n";
		?>
	</h4>
	<div class="box-container"  >  		
				<table class="table-short">
					<thead>
						<tr>
							<td colspan="12" class="paging"><?php //echo($paging_block);?></td>
						</tr>
						<tr>
							<td class="col-head2">Call Type</td>
							<!--<td class="col-head2" style="padding-left:10px">Number of Calls </td>-->
							<td class="col-head2" style="padding-left:10px">Talk Time </td>
							<td class="col-head2" style="padding-left:10px">Busy Time </td>
							
							
						</tr>
					</thead>
					
					<tbody>
					<?php 
					$no_calls = 0;
					while(!$total_talk_time->EOF){  
						$stringData .= $total_talk_time->fields['call_type'].",".$total_talk_time->fields['talk_time'].",".$busy_time->fields['busy_time']."\r\n";
					?>
						<tr class="odd">
							
							<td class="col-first"><?php 
							$no_calls =  $total_talk_time->fields["total_time"];
							echo($total_talk_time->fields["call_type"]); ?>  </td>
							<!--<td class="col-first" style="padding-left:10px"><?php //echo($nature_of_calls->fields["no_of_calls"]); ?> </td>-->
							<td class="col-first" style="padding-left:10px"><?php echo($total_talk_time->fields["talk_time"]); ?> </td>	
							<td class="col-first" style="padding-left:10px"><?php echo($busy_time->fields["busy_time"]); ?> </td>				
					</tr>
					<?php 	$total_talk_time->MoveNext(); 
							$busy_time->MoveNext();} ?>
					<tr class="odd">
						<td class="col-first">Total :</td>
						<td class="col-first" style="padding-left:10px">
						<?php $stringData .= "Total: ,".$no_calls.",\r\n"; echo($no_calls); ?>
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
					</tr>
					</tbody>
				</table>
				</div>
				
				 <br />
	
	<h4 class="white">
	 	<?php 	
		echo "AVG Total Talk Time"; 
		$stringData .= "<tag1>AVG Total Talk Time</tag1>\r\n";
		$stringData .= "<tag2>Call Type</tag2>,<tag2>Talk Time</tag2>,<tag2>Busy Time</tag2>\r\n";
		?>
	</h4>
	<div class="box-container"  >  		
				<table class="table-short">
					<thead>
						<tr>
							<td colspan="12" class="paging"><?php //echo($paging_block);?></td>
						</tr>
						<tr>
							<td class="col-head2">Call Type</td>
							<!--<td class="col-head2" style="padding-left:10px">Number of Calls </td>-->
							<td class="col-head2" style="padding-left:10px">Talk Time </td>
							<td class="col-head2" style="padding-left:10px">Busy Time </td>
							
							
						</tr>
					</thead>
					
					<tbody>
					<?php 
					$no_calls = 0;
					while(!$avg_total_talk_time->EOF){ 
						$stringData .= $avg_total_talk_time->fields["call_type"].",".$avg_total_talk_time->fields["talk_time"].",".$avg_busy_time->fields["AvgBusyTime"]."\r\n";
					?>
						<tr class="odd">
							
							<td class="col-first"><?php 
							$no_calls =  $avg_total_talk_time->fields["total_time"];
							echo($avg_total_talk_time->fields["call_type"]); ?>  </td>
							<!--<td class="col-first" style="padding-left:10px"><?php //echo($avg_total_talk_time->fields["no_of_calls"]); ?> </td>-->
							<td class="col-first" style="padding-left:10px"><?php echo($avg_total_talk_time->fields["talk_time"]); ?> </td>	
							<td class="col-first" style="padding-left:10px"><?php echo($avg_busy_time->fields["AvgBusyTime"]); ?> </td>				
					</tr>
					<?php 	$avg_total_talk_time->MoveNext(); 
							$avg_busy_time->MoveNext();} ?>
					<tr class="odd">
						<td class="col-first"></td>
						<td class="col-first" style="padding-left:10px">
						<?php //$stringData .= "Total: ,".$no_calls.",\r\n"; echo($no_calls); ?>
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
					</tr>
					</tbody>
				</table>
				</div>
   
    <br />
	
	<h4 class="white">
	 	<?php 	
		echo "Average Queue Time: "; 
		$stringData .= "<tag1a>Average Queue Time: ".$average_queue_time->fields['avg_queu_time']."</tag1a>\r\n";
		?>
		
		<?php echo($average_queue_time->fields["avg_queu_time"]); ?>
	</h4>
	
	 <br />
	
	<h4 class="white">
	 	<?php 	
		echo "Pins Generated"; 
		$stringData .= "<tag1>Pins Generated</tag1>\r\n";
		$stringData .= "<tag2>Pin Type</tag2>,<tag2>No of Pins</tag2>,<tag2>Percent</tag2>\r\n";
		?>
	</h4>
	<div class="box-container"  >  		
				<table class="table-short">
					<thead>
						<tr>
							<td colspan="12" class="paging"><?php //echo($paging_block);?></td>
						</tr>
						<tr>
							<td class="col-head2">Pin Type</td>
							<!--<td class="col-head2" style="padding-left:10px">Number of Calls </td>-->
							<td class="col-head2" style="padding-left:10px">No of Pins</td>
							<td class="col-head2" style="padding-left:10px">Percent</td>
							
							
						</tr>
					</thead>
					
					<tbody>
					<?php 
					$total = 0;
					while(!$pin_report->EOF){  
						$stringData .= $pin_report->fields['pin_type'].",".$pin_report->fields['no_pins'].",".$pin_report->fields['percent']."\r\n";
					?>
						<tr class="odd">

							<td class="col-first"><?php 
							$total =  $pin_report->fields["total"];
							echo($pin_report->fields["pin_type"]); ?>  </td>
							<td class="col-first" style="padding-left:10px"><?php echo($pin_report->fields["no_pins"]); ?> </td>
							<td class="col-first" style="padding-left:10px"><?php echo($pin_report->fields["percent"]); ?> </td>	
										
					</tr>
					<?php 	$pin_report->MoveNext();} ?>
					<tr class="odd">
						<td class="col-first">Total :</td>
						<td class="col-first" style="padding-left:10px">
						<?php $stringData .= "Total: ,".$total.",\r\n"; echo($total); ?>
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
					</tr>
					</tbody>
				</table>
				</div>
    <br />
	
	<h4 class="white">
	 	<?php 	
		echo "Transactions Executed"; 
		$stringData .= "<tag1>Transactions Executed</tag1>\r\n";
		$stringData .= "<tag2>Transaction Type</tag2>,<tag2>No of Transactions</tag2>,<tag2>Percent</tag2>\r\n";
		?>
	</h4>
	<div class="box-container"  >  		
				<table class="table-short">
					<thead>
						<tr>
							<td colspan="12" class="paging"><?php //echo($paging_block);?></td>
						</tr>
						<tr>
							<td class="col-head2">Transaction Type</td>
							<!--<td class="col-head2" style="padding-left:10px">Number of Calls </td>-->
							<td class="col-head2" style="padding-left:10px">No of Transactions</td>
							<td class="col-head2" style="padding-left:10px">Percent</td>
							
							
						</tr>
					</thead>
					
					<tbody>
					<?php 
					$total = 0;
					while(!$trans_report->EOF){ 
						$stringData .= $trans_report->fields['trans_type'].",".$trans_report->fields['no_trans'].",".$trans_report->fields['percent']."\r\n";
					?>
						<tr class="odd">
							
							<td class="col-first"><?php 
							$total =  $trans_report->fields["total"];
							echo($trans_report->fields["trans_type"]); ?>  </td>
							<td class="col-first" style="padding-left:10px"><?php echo($trans_report->fields["no_trans"]); ?> </td>
							<td class="col-first" style="padding-left:10px"><?php echo($trans_report->fields["percent"]); ?> </td>	
										
					</tr>
					<?php 	$trans_report->MoveNext();} ?>
					<tr class="odd">
						<td class="col-first">Total :</td>
						<td class="col-first" style="padding-left:10px">
						<?php $stringData .= "Total: ,".$total.",\r\n"; echo($total); ?>
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
					</tr>
					</tbody>
				</table>
				</div>
   	
   
   	</div>
      

	</div>
	
</form>

<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2">

	<div style="float:right">
		 <a class="button" href="javascript:document.xForm2.submit();" >
		 <span>Export EXCEL</span>
		 </a>
		<input type="hidden" value="export >>" id="export" name="export" />
		
		<input type="hidden" value="<?php echo $stringData; ?>" id="stringData"	name="stringData" />
		

	</div>
</form>

<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">

	<div style="float:right">
		 <a class="button" href="javascript:document.xForm3.submit();" >
		 <span>Export PDF</span>
		 </a>
		<input type="hidden" value="exportpdf" id="export_pdf" name="export_pdf" />
		
		<input type="hidden" value="<?php echo $stringData; ?>" id="stringData"	name="stringData" />
		

	</div>
</form>

</div>

<?php include($site_admin_root."includes/footer.php"); ?>
