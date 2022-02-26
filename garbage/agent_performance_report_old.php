<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "agent_performance_report.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Agent Performance Report";
        $page_menu_title = "Agent Performance Report";
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
	
	$stringData	= trim($_REQUEST['stringData']);
	$stringData = str_replace('<tag1>',null,$stringData);
	$stringData = str_replace('</tag1>',null,$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);
	$stringData = str_replace('<tag3>',null,$stringData);
	$stringData = str_replace('</tag3>',null,$stringData);
	
	//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
	$db_export_fix = $site_root."download/Agent_Performance_Report.csv";
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
	$db_export_fix = $site_root."download/Agent_Performance_Report.csv";
	//echo $stringData; exit;
	 
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
								
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'Agent_Performance_Report.pdf', 'D', 160, 16, 1);
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
			<td style="padding-left:20px">
				<label>
				<!--$table,$combo_id="id",$value_feild="id",$text_feild="title",$combo_selected="",$disabled,$class="",$onchange="",$title="",$condtion=''-->
				<?php echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name","",false,"form-select",$search_keyword,"Agent"," designation = 'Agents' "); ?>
				</label>
			</td>
			
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
	<h4 class="white"><?php 
	$rs_agent_name = $admin->get_agent_name($search_keyword);
	$avg_evaluator =  $reports->get_evaluator_count($search_keyword,$fdate,$tdate);
	echo "Agent Performance Report  <br> Agent Name - ".$rs_agent_name->fields["full_name"]." <br> Date: ".$fdate." - ".$tdate." <br> Average Evaluator Per Call: ".$avg_evaluator; 
	$stringData .= "<tag1>Agent Performance Report</tag1>\r\n<tag3>Agent Name - ".$rs_agent_name->fields["full_name"]."</tag3>\r\n<tag3>Date: ".$fdate." - ".$tdate."</tag3>\r\n<tag3>Average Evaluator Per Call: ".$avg_evaluator."</tag3>\r\n";
	//$stringData .= "Agent Productivity Report\r\n";
	//$stringData .= "Agent Name - ".$rs_agent_name->fields["full_name"]." \r\nDate: ".$fdate."\r\n";
	?></h4>
	<br />
	
	 <h4 class="white"><?php 
		
		echo "Call Summary";
		$stringData .= "<tag1>Call Summary</tag1>\r\n"; 
		//$stringData .= "Work Times\r\n";
		?></h4>
	<div class="box-container"  >  		
				<table class="table-short">
					<thead>
						<tr>
							<td colspan="12" class="paging"><?php //echo($paging_block);?></td>
						</tr>
						<tr><?php $stringData .= "<tag2>Call Type</tag2>,<tag2>Call Taken</tag2>,<tag2>Evaluated</tag2>\r\n"; ?>
							<td class="col-head2">Call Type</td>
							<td class="col-head2" style="padding-left:10px">Call Taken </td>
							<td class="col-head2" style="padding-left:10px">Evaluated </td>
							
							
						</tr>
					</thead>
					<?php // $stringData .= "Login Time, Log Out Time, Time Difference\r\n";  ?>
					<tbody>
						<tr class="odd">
						<?php $stringData .= "Incoming,".$evaluated_call_counts->fields['UN_InBound'].",".$evaluated_call_counts->fields['InBound']."\r\n"; ?>
							<td class="col-first">Incoming </td>
							<td class="col-first" style="padding-left:10px"><?php echo($evaluated_call_counts->fields["UN_InBound"]); ?> </td>
							<td class="col-first" style="padding-left:10px"><?php echo($evaluated_call_counts->fields["InBound"]); ?> </td>				
						</tr>
						<tr class="odd">
						<?php $stringData .= "Outgoing,".$evaluated_call_counts->fields['UN_OutBound'].",".$evaluated_call_counts->fields['OutBound']."\r\n"; ?>
							<td class="col-first">Outgoing </td>
							<td class="col-first" style="padding-left:10px"><?php echo($evaluated_call_counts->fields["UN_OutBound"]); ?> </td>
							<td class="col-first" style="padding-left:10px"><?php echo($evaluated_call_counts->fields["OutBound"]); ?> </td>				
						</tr>
					
					<tr class="odd">
					<?php 
					$EV = $evaluated_call_counts->fields["InBound"] + $evaluated_call_counts->fields["OutBound"];
					$NONEV = $evaluated_call_counts->fields["UN_InBound"] + $evaluated_call_counts->fields["UN_OutBound"];
					
					$total = ($EV / $NONEV) * 100;
					
					$stringData .= "Total :,".$NONEV.",".round($total,2)."\r\n"; 
					?>
						<td class="col-first">Total :</td>
						<td class="col-first" style="padding-left:10px">
						<?php 	
							echo $NONEV;
						?>
						</td>
						<td class="col-first" style="padding-left:10px">
						<?php 
							echo round($total,2);
						?>
						</td>
					</tr>
					</tbody>
				</table>
					
		</div>
		<br />
	
	
	<table>
	

	<?php while(!$groups->EOF)
	{ 
		$questions = $reports->get_evaluation_group_question($search_keyword,$fdate,$tdate); ?>
		<?php if($break < 1){?>
			<tr><td>
		<?php $break++;} else {?>
			<td>
		<?php $break = 0;} ?>
		


	   <h4 class="white"><?php 
		
		echo $groups->fields["group_name"];
		$stringData .= "<tag1>".$groups->fields['group_name']."</tag1>\r\n"; 
		//$stringData .= "Work Times\r\n";
		?></h4>
			<div class="box-container"  >  		
				<table class="table-short">
					<thead>
						<tr>
							<td colspan="12" class="paging"><?php echo($paging_block);?></td>
						</tr>
						<tr>
						<?php $stringData .= "<tag2>Questions</tag2>,<tag2>Marks %</tag2>\r\n"; ?>
							<td class="col-head2">Questions</td>
							<td class="col-head2" style="padding-left:100px">Marks %</td>
							
							
						</tr>
					</thead>
					<?php // $stringData .= "Login Time, Log Out Time, Time Difference\r\n";  ?>
					<tbody>
					<?php 
					$count = 0;
					$percentage = 0;
					while(!$questions->EOF){ 
						
						
						if($groups->fields["id"] == $questions->fields["Qgroup"]){
						$count++;
						$percentage = $percentage + $questions->fields["Percent"];
					?>
						<tr class="odd">
						<?php $stringData .= trim($questions->fields['question_code']).",".$questions->fields['Percent']."\r\n"; ?>
							<td class="col-first"><?php echo $questions->fields["question_code"]; ?> </td>
							<td class="col-first" style="padding-left:100px"><?php echo($questions->fields["Percent"]); ?> </td>
							<!--<td class="col-first"><?php// $A=$rs_w_t->fields["duration"]; echo($rs_w_t->fields["duration"]); ?> </td>-->				
							
						</tr>
					<?php 
						}else{}
					//$stringData .= $rs_w_t->fields["login_time"].", ".$rs_w_t->fields["logout_time"].", ".$rs_w_t->fields["duration"]."\r\n";
					
					$questions->MoveNext();	} ?>
					<tr class="odd" style="font:bold; color:#0033FF">
					<?php $stringData .= "Average:,".round($percentage/$count)."\r\n"; ?>
						<td class="col-first">
							<font color="#0000FF" > Average: </font>
						</td>
						<td class="col-first" style="padding-left:100px">
							<font color="#0000FF" > <?php echo round($percentage/$count); ?> </font>
						</td>
					</tr>
					</tbody>
				</table>
					
		</div>
			<br />
	
		<?php $groups->MoveNext();?>


		<?php if($break < 1){?>
			</td></tr>
		<?php $break++;} else {?>
			</td>
		<?php $break = 0;}

	} ?>
	
	</table>
   
   	</div>
      

	</div>
	
</form>



<form action="<? //echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2">

	<div style="float:right">
		 <a class="button" href="javascript:document.xForm2.submit();" >
		 <span>Export EXCEL</span>
		 </a>
		<input type="hidden" value="export >>" id="export" name="export" />
		
		<input type="hidden" value="<?php echo $stringData; ?>" id="stringData"		name="stringData" />
		

	</div>
</form>

<form action="<? //echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">

	<div style="float:right">
		 <a class="button" href="javascript:document.xForm3.submit();" >
		 <span>Export PDF</span>
		 </a>
		<input type="hidden" value="exportpdf" id="export_pdf" name="export_pdf" />
		
		<input type="hidden" value="<?php echo $stringData; ?>" id="stringData"		name="stringData" />
		

	</div>
</form>

</div>

<?php include($site_admin_root."includes/footer.php"); ?>
