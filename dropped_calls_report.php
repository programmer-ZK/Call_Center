<?php include_once("includes/config.php"); ?>
<?php //echo "farhan";exit();
        $page_name = "dropped_calls_report.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Dropped Calls Report";
        $page_menu_title = "Dropped Calls Report";
		"";
//echo "farhan";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
<?php //ob_start(); ?>
<?php //include($site_root."includes/make_page_url.php"); ?>
<?php //include($site_root."includes/visitor_tracking.php"); ?>

<?php
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/reports.php");
	$reports = new reports();
?>
<?php include($site_root."includes/iheader.php");?>
<html>
<head>
<!--<link href="css/style.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript">
function getHtml4Excel()
{
//var x;
//x=document.getElementsByTagName("html")[0].innerHTML;
//x=document.documentElement.innerHTML;
document.getElementById("gethtml1").value = document.getElementsByTagName("body")[0].innerHTML;
//alert(document.documentElement.innerHTML);
}
function getHtml4Pdf()
{
//var x;
//x=document.getElementsByTagName("html")[0].innerHTML;
//x=document.documentElement.innerHTML;
document.getElementById("gethtml2").value = document.getElementsByTagName("body")[0].innerHTML;
//alert(document.documentElement.innerHTML);
}
/*function reloadPage()
{
alert("asdasd");
window.location.reload();
}*/

</script>
</head>
<body>  
<?php	
/************************* Export to Excel ******************/
if(isset($_REQUEST['export']))
{
	
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	$stringData	= $_REQUEST['gethtml1'];
	$stringData = preg_replace('/Â/','',$stringData);
	$stringData = preg_replace('/<form(.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData); 
	$stringData = preg_replace('/EXPORT DOC/', '', $stringData); 
	//echo $stringData."asdasd";exit;
	/*$stringData = str_replace('<tag1>',null,$stringData);
	$stringData = str_replace('</tag1>',null,$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);*/

	$db_export_fix = $site_root."download/dropped_calls_report.xls";
	//echo $stringData; exit;
	shell_exec("echo '".$stringData."' > ".$db_export_fix);
		
	ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    //header("Content-type: application/force-download");
    //header("Content-Type: text/csv");
	header("Content-Type: application/ms-excel");
    
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
/************************* Export to Pdf ******************/
if(isset($_REQUEST['export_pdf']))
{
	
/*	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	$stringData	= $_REQUEST['gethtml2'];
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	//echo $stringData;exit;
	ob_end_clean();
	$content = "<page>".$stringData."</page>"; 
	
    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('L','A4','en');
	$html2pdf->pdf->SetDisplayMode('fullwidth');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Agent_Performance_Weekly_Report.pdf', 'D');*/
	
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	$stringData	= $_REQUEST['gethtml2'];
	$stringData = preg_replace('/Â/','',$stringData);
	$stringData = preg_replace('/<form(.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData); 
	$stringData = preg_replace('/EXPORT DOC/', '', $stringData); 
	//echo $stringData."asdasd";exit;
	/*$stringData = str_replace('<tag1>',null,$stringData);
	$stringData = str_replace('</tag1>',null,$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);*/

	$db_export_fix = $site_root."download/dropped_calls_report.doc";
	//echo $stringData; exit;
	shell_exec("echo '".$stringData."' > ".$db_export_fix);
		
	ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    //header("Content-type: application/force-download");
    header("Content-Type: application/ms-word");
    
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
	$total_records_count = $reports->get_drop_calls_records_count($fdate, $tdate);
	//echo $total_records_count;exit;
	
	include_once("includes/paging.php");
	$get_agent_list = $reports->get_agent_list();
	$get_dropped_calls_details = $reports->get_dropped_calls_details($fdate, $tdate, $recStartFrom, $page_records_limit);//exit();
	$drop_calls = $reports->drop_calls2($fdate, $tdate);
	//$count_online_agents = $reports->count_online_agents($fdate, $tdate);
	$avg_waiting_time = $reports->avg_waiting_time($fdate, $tdate);
?>


<?php 	
//		echo  "<div><div id='mid-col' class='mid-col'><div class='box' style='width:930px'><h4 class='white'>Dropped-Calls Detailed Report</h4><div class='box-container' > <table style=' border-style:solid; width:290; background-color:#E8E8DD;' class='table-short' >	<tbody><tr><td style='padding-top:10'><h3 class='aaa' style='color:#000000;font-size:12px;'  >From Date:&nbsp;".$fdate."</h3><h3 class='aaa' style='color:#000000;font-size:12px;' >To Date:&nbsp;".$tdate."</h3><h3 class='aaa' style='color:#000000;font-size:12px;' >No. of Dropped Calls:&nbsp;".$drop_calls->fields['drop_calls']."</h3><h3 class='aaa' style='color:#000000;font-size:12px;' >Average Waiting Time:&nbsp;".$avg_waiting_time ->fields['avg_wait_time']."</h3></td></tr></tbody></table></div><br><span id='paging_block' style='padding:10px'>".$paging_block."</span><div class='box-container'  > <table class='table-short' style=' width:920px; border:solid'><thead><tr><td class='col-head2'></td><td class='col-head2'></td>";
  echo  "<div><div id='mid-col' class='mid-col'><div class='box' style='width:930px'><h4 class='white'>Dropped-Calls Detailed Report</h4><div class='box-container' > <table style=' border-style:solid; width:290; background-color:#E8E8DD;' class='table-short' >      <tbody><tr><td style='padding-top:10'><h3 class='aaa' style='color:#000000;font-size:12px;'  >From Date:&nbsp;".$fdate."</h3><h3 class='aaa' style='color:#000000;font-size:12px;' >To Date:&nbsp;".$tdate."</h3><h3 class='aaa' style='color:#000000;font-size:12px;' >No. of Dropped Calls:&nbsp;".$total_records_count."</h3><h3 class='aaa' style='color:#000000;font-size:12px;' >Average Waiting Time:&nbsp;".$avg_waiting_time ->fields['avg_wait_time']."</h3></td></tr></tbody></table></div><br><span id='paging_block' style='padding:10px'>".$paging_block."</span><div class='box-container'  > <table class='table-short' style=' width:920px; border:solid'><thead><tr><td class='col-head2'></td><td class='col-head2'></td>";
									
	    $i=0;
			 while(!$get_agent_list->EOF){
									echo  "<td class='col-head2'><b>".strtoupper($get_agent_list->fields['full_name'])."</b></td>";
  									 $agent_id[$i] = $get_agent_list->fields['admin_id'];
									 $get_agent_list->MoveNext(); 
									$i++;
			} 
										
		echo  "</tr></thead><tbody>";
							
		$j=1; 
			while(!$get_dropped_calls_details->EOF){
							echo  "<tr>
							<td id='col1' style='padding-top:0;'>
							<table style='width:140px;'><tr><td style='font-size:11px;'><b>Call Tracking ID</b></td></tr><tr><td style='font-size:11px;'><b>Call Time</b></td></tr><tr><td style='font-size:11px;'><b>Call Wait Time</b></td></tr><tr><td style='font-size:11px;'><b>Agent Status</b></td></tr><tr><td style='font-size:11px;'><b>Agent Status Duration</b></td></tr><tr><td style='font-size:11px;'><b>Call Status</b></td></tr><tr><td style='font-size:11px;'><b>Abondened</b></td></tr>
							</table>
							</td>
							<td id='col2'>
							<table style='width:140px;'><tr><td style='font-size:11px;'>".$get_dropped_calls_details->fields['unique_id']."&nbsp;</td></tr><tr><td style='font-size:11px;'>".$get_dropped_calls_details->fields['call_datetime']."&nbsp;</td></tr><tr><td style='font-size:11px;'>".$get_dropped_calls_details->fields['WAIT_IN_QUEUE']."</td></tr><tr><td style='font-size:11px;border-top:none;'>&nbsp;</td></tr><tr><td style='font-size:11px;border-top:none;'>&nbsp;</td></tr><tr><td style='font-size:11px;border-top:none;'>&nbsp;</td></tr><tr><td style='font-size:11px;border-top:none;'>&nbsp;</td></tr>
							</table>
							</td>";

									//print_r($agent_id);exit;
								
									$i=0; $online_agent_count=0; 
									while(!empty($agent_id[$i]))
									{ 
									
																		
									$agent_login_status = $reports->agent_login_status($get_dropped_calls_details->fields['call_datetime'],$agent_id[$i]);
						
						$arr_agent_login_status = explode("|",$agent_login_status);
									//echo "Agent id: ".$agent_id[$i]." Status: ".$arr_agent_login_status[0];
									//echo " time: ".$arr_agent_login_status[1]."<br><br>";
									
									if ($arr_agent_login_status[0] > 0)								
									{
										//echo "<br>login status".$agent_login_status."-".$agent_id[$i]."<br><br>";
										$agent_status_details = $reports->agent_status_details($fdate, $tdate, $get_dropped_calls_details->fields['call_datetime'], $get_dropped_calls_details->fields['UPDATE_DATETIME'], $agent_id[$i]); 
										//echo "status_details: ".$agent_status_details->RecordCount()."<br><br>";
										$get_agent = $reports->get_agent($agent_id[$i],$get_dropped_calls_details->fields['call_datetime'],$get_dropped_calls_details->fields['UPDATE_DATETIME'],$get_dropped_calls_details->fields['unique_id']);
																	
										if($agent_status_details->fields["AGENT_STATUS"] == 1 || $agent_status_details->RecordCount() == 0){
											
											//if($get_agent->fields["agent_count"] == 0)
//											{
//												$str ="Offline..";
//												$str_call ="-";
//												
//											}
//											else
//											{
											
												if($get_agent->fields["busy"] == 0){$str_call ="Free";}
												else if($get_agent->fields["busy"] == 1){$str_call ="On Call";}
												else if($get_agent->fields["busy"] == 2){$str_call ="Ringing";}
												
												else if($get_agent->fields["busy"] == 3){$str_call ="Busy";}
												else{$str_call ="-";}
												$str ="Online";
												$online_agent_count++;
											//}
										}
										else if($agent_status_details->fields["AGENT_STATUS"] == 2){
											$str ="Namaz Break";
											$str_call ="-";	
										}
										else if($agent_status_details->fields["AGENT_STATUS"] == 3){
											$str ="Lunch Break";
											$str_call ="-";	
										}
										else if($agent_status_details->fields["AGENT_STATUS"] == 4){
											$str ="Tea Break";
											$str_call ="-";	
										}
										else if($agent_status_details->fields["AGENT_STATUS"] == 5){
											$str ="Break";
											$str_call ="-";	
										}
										else if($agent_status_details->fields["AGENT_STATUS"] == 6){
											$str ="Assignment";
											$str_call ="-";	
										}
										else if($agent_status_details->fields["AGENT_STATUS"] == 0){
												$str ="Offline";
												$str_t_duration = '';
												$str_call ="-";	
										}
										else {
												$str ="Unknown";
										}
										$position = strpos($agent_status_details->fields["status_duration"], "-");
										
										if ($position === false)
										{//echo $position;
    										
											//$status_duration = !empty($agent_status_details->fields['status_duration'])?$agent_status_details->fields['status_duration']:"-";
											if(!empty($agent_status_details->fields['status_duration']))
											{
												$status_duration = $agent_status_details->fields['status_duration'];
											}
											else
											{
												$agent_status_details_negative = $reports->agent_status_details_negative($fdate, $tdate, $get_dropped_calls_details->fields['call_datetime'], $get_dropped_calls_details->fields['UPDATE_DATETIME'], $agent_id[$i]); 
											//$status_duration = "-- 0 --";
												$position = strpos($agent_status_details_negative->fields['status_duration'], "-");
										
												if ($position === false)
												{
													$status_duration = $agent_status_details_negative->fields['status_duration'];
												}
												else
												{
													$status_duration = "-";
												}
													//if(empty($agent_status_details_negative->fields['status_duration'])){echo "<br>";}
											}
										}
										else
										{
										//echo "-- 1 <br>";
											$agent_status_details_negative = $reports->agent_status_details_negative($fdate, $tdate, $get_dropped_calls_details->fields['call_datetime'], $get_dropped_calls_details->fields['UPDATE_DATETIME'], $agent_id[$i]); 
											//$status_duration = "-- 0 --";
											//$status_duration = $agent_status_details_negative->fields['status_duration'];
											$position = strpos($agent_status_details_negative->fields['status_duration'], "-");
										
												if ($position === false)
												{
													$status_duration = $agent_status_details_negative->fields['status_duration'];
												}
												else
												{
													$status_duration = "-";
												}
										}	
										
										$is_abandonned = $reports->is_abandonned($get_dropped_calls_details->fields['unique_id'],$agent_id[$i]);
										if($is_abandonned > 0){$is_abandonned_r = "YES(".$is_abandonned.")";}
										else{$is_abandonned_r = "-";}
									}
									else{
									 $str = "Offline";
									 $status_duration = "-";
									 $is_abandonned_r = "-";
									 $str_call ="-";	
									}
									

									echo  "<td id='col3'><table style='width:100px;'><tr><td style='font-size:11px;border-top:none;'>&nbsp;</td></tr><tr><td style='font-size:11px;border-top:none;'>&nbsp;</td></tr><tr><td style='font-size:11px;border-top:none;'>&nbsp;</td></tr><tr><td style='font-size:11px;'>".$str."&nbsp;</td></tr><tr><td style='font-size:11px;'>".$status_duration."&nbsp;</td></tr><tr><td style='font-size:11px;'>".$str_call."&nbsp;</td></tr><tr><td style='font-size:11px;'>".$is_abandonned_r."&nbsp;</td></tr></table></td>";
									
									$i++;
									
									}



									echo "</tr><tr><td style='font-size:11px;'><b>Number of Agents Online:</b>&nbsp;".$online_agent_count."</td></tr><tr><td style='font-size:11px;'>&nbsp;</td></tr>";
									
									$get_dropped_calls_details->MoveNext();
								}
		
						echo  "</tbody></table>";
						echo  "<span id='paging_block' style='padding:10px'>".$paging_block."</span>";
						//$paging_block ="";
					echo  "</div></div></div></div>";
	
	
	/*$db_export_fix = $site_root."download/DroppedCalls.xls";

	echo $db_export_fix;
	
	
	echo shell_exec("echo '".trim($html2)."' > ".$db_export_fix); 
		
    ob_end_clean();
	header('Content-disposition: attachment; filename='.basename($db_export_fix));
	header('Content-type: text/csv');
	readfile($db_export_fix);*/
	
	 ?>
<!--<textarea id="ta" name="ta">tyt</textarea>-->

<!--<button onClick="myFunction()">Get HTML</button>-->

</body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onSubmit="">

  <div style="float:left;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>
	  <input type="hidden" value="<?php echo $agent_id; ?>" id="search_keyword" name="search_keyword" />
	  <input type="hidden" value="<?php echo $edate; ?>" 	id="tdate" 	name="tdate" />
	  <input type="hidden" value="<?php echo $sdate; ?>" 	id="fdate" 	name="fdate" />
  </div>
  <!--<input type="submit" onClick="myFunction()" value="Export" />-->
</form>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2" onSubmit="">

  <div style="float:left; margin-left:10px;">
	<a onClick="getHtml4Pdf()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT DOC</span>
	</a>
	  <input type="hidden" value="export_pdf" id="export_pdf" name="export_pdf" />
  	  <input type="hidden" id="gethtml2" name="gethtml2"/>
	  <input type="hidden" value="<?php echo $agent_id; ?>" id="search_keyword" name="search_keyword" />
	  <input type="hidden" value="<?php echo $edate; ?>" 	id="tdate" 	name="tdate" />
	  <input type="hidden" value="<?php echo $sdate; ?>" 	id="fdate" 	name="fdate" />
  </div>
  <!--<input type="submit" onClick="myFunction()" value="Export" />-->
</form>
</html>
<?php ob_flush();?>
<?php //include($site_admin_root."includes/ifooter.php"); ?>
