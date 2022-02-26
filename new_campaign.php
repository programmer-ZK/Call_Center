	<?php include_once("includes/config.php"); ?>
		<?php
			$page_name = "new_campaign.php";
			$page_title = "Campaign Report";
			$page_level = "0";
			$page_group_id = "0";
			$page_menu_title = "Campaign Report ";
		?>
		<?php include_once($site_root."includes/check.auth.php"); ?>
		<?php 	
			include_once("classes/tools_admin.php");
			$tools_admin = new tools_admin();
			include_once("classes/templates.php");
			$templates = new templates();
			include_once("classes/new_campaign.php");
			$new_campaign = new new_campaign();
			include_once("classes/agent.php");
			$agent = new agent();
			
			include_once("classes/campaign.php");
			$campaign = new campaign();
			
			
		?>
	
	
		
	
	

<?php

	
	include_once("classes/reports.php");
	$reports = new reports();
?>	
<?php include($site_root."includes/header.php");  ?>	
<!--<meta http-equiv="refresh" content="2">-->

<html>

<body>


<?php  $today =date("YmdHms");


/************************* Export to Excel ******************/
if(isset($_REQUEST['campaign_id']))
{$today =date("YmdHms");
	//echo $_REQUEST['select'];exit;
	$rs = $new_campaign->campaign_export_fw($_REQUEST['campaign_id'],$today);
	$rs2 = $new_campaign->questions($_REQUEST['campaign_id']);
	
	$days2= $campaign->timeremaining($_REQUEST['campaign_id']);
$num2=$campaign->campaign_status($_REQUEST['campaign_id']);
$numbers2 = $num2->fields['numbers'];
	
	
	
	
	
$campaign_data			=	$new_campaign->campaign_data($_REQUEST['campaign_id']);
$agents_name			=	$new_campaign->campaign_progress($_REQUEST['campaign_id']);
$associated_agents		=	$new_campaign->associated_agents($_REQUEST['campaign_id']);
$numbers_count			=	$new_campaign->total_numbers($_REQUEST['campaign_id']);
$questions_count		=	$new_campaign->total_questions_new($_REQUEST['campaign_id']);
$no_of_calls			=	$new_campaign->no_of_calls($agent_id,$sdate,$edate,$_REQUEST['campaign_id']);
$query=$agent->campaign_questions_second($_REQUEST['campaign_id']);
	//echo $rs2->fields['questions'];
	//exit;
	//$db_export = $site_root."download/Call_Records_".$today.".csv";
	$db_export_server = $site_root."download/Campaign_Report.csv";
	
$db_export_fix = $site_root."download/Campaign_Report_".$today.".csv";






//f ($campaign_data->fields['campaign_status']){$status = "ACTIVE";}
//else {$status = $campaign_data->fields['campaign_status'];}
if (($campaign_data->fields['campaign_status'] == '') && ($days2<=0) && ($numbers2!=0)){$status = "Delayed";}
else if (($days2<=0) && ($numbers2==0) && ($campaign_data->fields['campaign_status'] == '')){$status = "Completed";}
else if ($campaign_data->fields['campaign_status'] != ''){$status = $campaign_data->fields['campaign_status'];}

else {$status = "Active";}

	$heading = "CAMPAIGN NAME ,".$campaign_data->fields['campaign_name'].
	"\rCAMPAIGN NATURE ,". $campaign_data->fields['campaign_nature'].
	"\rCAMPAIGN CURRENT STATUS ,".$status .
	"\rNUMBER OF ASSOCIATED AGENTS ,".$associated_agents->fields['tRec'].
	"\rCAMPAIGN START DATE TIME ,".$campaign_data->fields['st'].
	"\rCAMPAIGN END DATE TIME,".$campaign_data->fields['et'].
	"\rTOTAL NUMBERS,".$numbers_count->fields['trec'].	
	"\rDURATION IN DAYS,".$campaign_data->fields['no_of_days'].
	"\rTOTAL QUESTIONS,".$questions_count->fields['trec'].	
	"\r"
	 ;
//	 while (!$query->EOF){ 
//	 $heading .="QUESTION RESPONSES ,". $query->fields["question"].'-'.$query->fields["answer"].'-'.$query->fields["tRec"]."\n"
//	 ;
//	 $query->MoveNext(); }
	 
	$heading .= "\r\r\nNAME, CNIC , CALLER ID , STATUS , AMOUNT , CITY , IC , SOURCE , OTHER , ATTEMPTS , CALL DATE TIME , CUSTOMER ID , ACCOUNT NUMBER , WORKCODES , AGENT NAME , DETAIL ,".$rs2->fields['questions']."\r\n";
	shell_exec("echo '".$heading."' > ".$db_export_fix);
	shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	unlink($db_export_server);
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
	$rs = $new_campaign->campaign_export_fw($_REQUEST['select']);
	
	//$db_export = $site_root."download/Call_Records_".$today.".csv";
	$db_export_server = $site_root."download/Campaign_Report_".$today.".csv";
	//$db_export_fix = $site_root."download/Campaign_Report.csv";
	$db_export_fix = $site_root."download/Campaign_Report.csv";
	$heading = "<tag1>Campaign Report</tag1>\r\n";
	$heading .= "<tag2>NAME</tag2>,<tag2>CNIC</tag2>,<tag2>CALLER ID</tag2>,<tag2>CALLER ID2</tag2>,<tag2>CALLER ID3</tag2>,<tag2>CITY</tag2>,<tag2>IC</tag2>,<tag2>SOURCE</tag2>,<tag2>OTHER</tag2>,,<tag2>ATTEMPTS</tag2>,<tag2>WORKCODES</tag2>,<tag2>AGENT NAME</tag2>,<tag2>DETAIL</tag2>";
	shell_exec("echo '".$heading."' > ".$db_export_fix);
	shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	
	exit();
}
///******************************************************************************/	
$stringData	 = '';
?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Campaign Report</div>
<div> 
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="POST" class="middle-forms cmxform" name="xForm" id="xForm">
<div class="box">
<h4 class="white">
	 	<?php 	
	echo "Search By Campaign Name:";
		?>
		<td><?php  $campaignid					=	$new_campaign->id_get();
echo "<select name='select' id='select'>";
while(!$campaignid->EOF){
    echo "<option value='".$campaignid->fields['campaign_id']."'>".$campaignid->fields["campaign_name"]."</option>";
	$campaignid->MoveNext();
	}
echo "</select>";?>
<a href="javascript:document.xForm.submit();"class="button" >
	 <span>Export EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
	  
</td>
</h4>

</div>
	</h4>
	
	<br />
	
				</table>
			</form>	
   	</div>
    <!--  <form name="xForm2" id="xForm2" action="<?php //echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; ">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();"class="button" >
	 <span>Export EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>
  </div>
</form>-->

</div>



<?php include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
