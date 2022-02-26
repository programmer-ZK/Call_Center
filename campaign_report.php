	<?php include_once("includes/config.php"); ?>
		<?php
			$page_name = "campaign_report.php";
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
			include_once("classes/campaign.php");
                        $campaign = new campaign();

			include_once("classes/agent.php");
			$agent = new agent();
		?>
	
	
		
	
	

<?php

	
	include_once("classes/reports.php");
	$reports = new reports();
?>	
<?php include($site_root."includes/header.php");  ?>	
<!--<meta http-equiv="refresh" content="2">-->

<html>
<head>
<script type="text/javascript">
function getHtml4Excel()
{
document.getElementById("gethtml1").value = document.getElementById("agent_pd_report").innerHTML;
}

</script>
</head>
<body>


<?php 
/************************* Export to Excel ******************/
if(isset($_REQUEST['export']))
{
	
	/*$stringData	= trim($_REQUEST['stringData']);*/
	$stringData	= trim($_REQUEST['gethtml1']);
	$stringData = preg_replace('/Â/','',$stringData);
	$stringData = preg_replace('/<form name="xForm" (.*)>/isU', '', $stringData);
	$stringData = preg_replace('/<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<form name="xForm2" (.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<form name="xForm3" (.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData); 
	
	$stringData = str_replace('<tag1>',null,$stringData);//'<div style="border:2px solid #000000;background-color:#F2F2F2; margin-top:10px;margin-bottom:10px;">'
	$stringData = str_replace('</tag1>',null,$stringData);//'</div>'
	//$stringData = str_replace(' ','<br>',$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);
	$stringData = str_replace('<tag3>',null,$stringData);
	$stringData = str_replace('</tag3>',null,$stringData);
	
	//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
	$db_export_fix = $site_root."download/Campaign_Report.xls";
	//echo $stringData; exit;
	shell_exec("echo '<html><body>".$stringData."</html></body>' > ".$db_export_fix);
		
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

if(isset($_REQUEST['export_pdf']))
{
								
	$stringData			= trim($_REQUEST['stringData']);
	$db_export_fix = $site_root."download/Campaign_Report.csv";
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
	ob_end_clean();
	$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'Productivity_Records.pdf', 'D', 160, 16, 1);
	exit();
}
///******************************************************************************/	
$stringData	 = '';
?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Campaign Report</div>
<div> 
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="GET" class="middle-forms cmxform" name="xForm" id="xForm">
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
<a class="button" href="javascript:document.xForm.submit();" onClick="javascript:return msg_validate('xForm');" ><span>Show</span></a>
				<input type="hidden" value="Show" id="show" name="show"/>
</td>
</h4>

</div>
	</h4>
	
	<br />
	<? if (isset($_REQUEST['show']))
{

$campaign_id 			=  	$_REQUEST['select'];
$campaign_data			=	$new_campaign->campaign_data($campaign_id);
$agents_name			=	$new_campaign->campaign_progress($campaign_id);
$associated_agents		=	$new_campaign->associated_agents($campaign_id);
$numbers_count			=	$new_campaign->total_numbers($campaign_id);
$questions_count		=	$new_campaign->total_questions_new($campaign_id);

 $days= $campaign->timeremaining($campaign_id);
 $num=$campaign->campaign_status($campaign_id);
 $numbers = $num->fields['numbers'];
//echo $rs->fields["campaign_id"];

?>

<div id="agent_pd_report">

	<div id="mid-col" class="mid-col">
	<div class="box">

	<?php $break = 0; ?>

	<h4 class="white">
	 	<?php 	 
	echo "Campaign Details";
		//echo $campaign_id;
		?>
	</h4>
	<div class="box-container"  >  		
				<table class="table-short">
					<thead>
					
					
						<tr>
							  <td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
						
						<tr class="odd">
						<td class="col-first">Campaign Name :</td>
						<td class="col-first"><? echo $campaign_data->fields['campaign_name']; ?></td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						</tr>
				
						<tr class="odd">
						<td class="col-first">Campaign Nature :</td>
						<td class="col-first"><? echo $campaign_data->fields['campaign_nature']; ?></td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						</tr>
						
						
						
						<tr class="odd">
						<td class="col-first">Campaign Current Status :</td>
						<td class="col-first"><? 
 if ($campaign_data->fields['campaign_status'] != '')
{
echo $campaign_data->fields['campaign_status']; }
else if ($days<=0 && $numbers==0)
                                                {echo 'Completed';}
                                                else if ($days<=0 && $numbers!=0)
                                                {echo 'Delayed';}
else if ($campaign_data->fields['campaign_status'] == '') {echo "ACTIVE";}
else
{
echo $campaign_data->fields['campaign_status']; }?></td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						</tr>
						
						<tr class="odd">
						<td class="col-first">Associated Agents :</td>
						<td class="col-first"><? echo $associated_agents->fields['tRec']; ?></td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						</tr>
						
						
   						<? while (!$agents_name->EOF){ ?>
						<tr class="odd">
						<td class="col-first">Agent & status :</td>
						<td class="col-first"><?php echo  $agents_name->fields["full_name"];?>  </td>
						<td class="col-first"><?php  $ans=$agents_name->fields["status"];
							if ($ans==1)
								{
								echo 'Active';
								}
							else
								{
								echo 'Not Active';
								} ?>
						</td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						</tr><?php $agents_name->MoveNext(); } ?>
						
						
	
						<tr class="odd">
						<td class="col-first">Start Date Time & End Date Time :</td>
						<td class="col-first"><?php echo $campaign_data->fields['st'] ;?></td>
						<td class="col-first"><?php echo $campaign_data->fields['et'] ;?></td>
						<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td>
						</tr>
						<tr class="odd">
						<td class="col-first">Total numbers :</td>
						
						<td class="col-first"><?php echo $numbers_count->fields['trec'] ;?>
						</td>	
						
					
						<td class="col-first" style="padding-left:10px">
							&nbsp
						</td>
						
						<!--<td class="col-first">
					<a href="caller_list.php?campaign_id=<?php echo $campaign_id;?>">View</a></td>-->
						<td class="col-first" style="padding-left:10px">
							&nbsp
						</td>
						</tr>
						
						
						<tr class="odd">
						<td class="col-first">Duration in days :</td>
							
						<td class="col-first"><?php echo $campaign_data->fields['no_of_days'] ;?>
						</td>	
						<td class="col-first" style="padding-left:10px">
							&nbsp
						</td>
						<td class="col-first" style="padding-left:10px">
							&nbsp
						</td>
						</tr>
						
						
						<tr class="odd">
						<td class="col-first">Total Question :</td>
						
						<td class="col-first"><?php echo $questions_count->fields['trec'] ;?>
						</td>	
						<td class="col-first" style="padding-left:10px">
							&nbsp
						</td>
							<td class="col-first" style="padding-left:10px">
							&nbsp
						</td>
						</tr>
	
					</tbody></thead>
				</table>
				</div>
					
		<br />
	<h4 class="white">
	 	<?php 	
	echo "Call Durations";?>
	</h4>
	<? 
$agent_wisetime_time	=	$new_campaign->agent_wisetime_time($agent_id,$sdate,$edate,$campaign_id);$on_hold				=	$new_campaign->agent_wisetime_time_hold($agent_id,$sdate,$edate,$campaign_id);
$no_of_calls			=	$new_campaign->no_of_calls($agent_id,$sdate,$edate,$campaign_id);


$no_of_callsnew			=	$new_campaign->no_of_callsnew($agent_id,$sdate,$edate,$campaign_id);

$busy_query				=	$new_campaign->agent_wisetime_busy_time($agent_id,$sdate,$edate,$campaign_id);


?>
	<div class="box-container"  >  		
				<table class="table-short">
					<thead>
						<tr>
							  <td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
      				</thead>
					<tbody>
					<tr class="odd">
				<td class="col-first">Number of Attempts :</td>
				<td class="col-first"><?php	echo $no_of_callsnew->fields["count_no_of_calls"];?> 
				 </td>
				<td class="col-first" style="padding-left:10px"> &nbsp </td>	
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Total Talk Time:</td>
				<td class="col-first">
				<?php if( $agent_wisetime_time->fields["agent_time"]==''){echo '00:00:00';}else {echo $agent_wisetime_time->fields["agent_time"]; } ?></td>
				
				<td class="col-first" style="padding-left:10px"> &nbsp </td>
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Average Talk Time:</td>
				<!--<td class="col-first">
				<?php //if( $agent_wisetime_time->fields["avg_agent_time"]==''){echo '00:00:00';}else {echo $agent_wisetime_time->fields["avg_agent_time"]; } ?></td>-->
				<td class="col-first">
				<?php 
				
				function time_to_sec($time) {
    $hours = substr($time, 0, -6);
    $minutes = substr($time, -5, 2);
    $seconds = substr($time, -2);

    return $hours * 3600 + $minutes * 60 + $seconds;
}
				//echo (time_to_sec($agent_wisetime_time->fields["agent_time"]));
				echo gmdate("H:i:s", (time_to_sec($agent_wisetime_time->fields["agent_time"])/$no_of_calls->fields["count_no_of_calls"])); ?></td>
				
				<td class="col-first" style="padding-left:10px"> &nbsp </td>
	</tr>
					
						
	<tr class="odd">
				<td class="col-first">Total Hold Time:</td>
				<td class="col-first">
				<?php if( $on_hold->fields["on_hold"]==''){echo '00:00:00';}else {echo $on_hold->fields["on_hold"]; } ?>		</td>
				
				<td class="col-first" style="padding-left:10px">&nbsp </td>					
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Average Hold Time:</td>
				<td class="col-first">
				<?php //if( $on_hold->fields["on_hold_avg"]==''){echo '00:00:00';}else {echo $on_hold->fields["on_hold_avg"]; }
				
					echo gmdate("H:i:s", (time_to_sec($on_hold->fields["on_hold_avg"])/$no_of_calls->fields["count_no_of_calls"]));
				
				
				 ?></td>	
				
				<td class="col-first" style="padding-left:10px"> &nbsp </td>					
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Total Busy Time:</td>
				<td class="col-first">
				<?php 
				
					 if( $busy_query->fields['busy_duration']==''){echo '00:00:00';}else {echo $busy_query->fields['busy_duration']; } 
				
				
				 ?></td>	
				
				<td class="col-first" style="padding-left:10px"> &nbsp </td>					
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Average Busy Time:</td>
				<td class="col-first">
				<?php //if( $on_hold->fields["on_hold_avg"]==''){echo '00:00:00';}else {echo $on_hold->fields["on_hold_avg"]; }
				
					echo gmdate("H:i:s", (time_to_sec($busy_query->fields['busy_duration'])/$no_of_calls->fields["count_no_of_calls"]));
				
				
				 ?></td>	
				
				<td class="col-first" style="padding-left:10px"> &nbsp </td>					
	</tr>
					
					
					</tbody>
				</table>
				</div>
	<br/>
	<!-- CALL DURATIONS-->
	
		<h4 class="white">
	 	<?php 	
	echo "Campaign Analytics";
		
		?>	
	</h4>
	
	<div class="box-container"  >  		
				<table class="table-short">
					<thead>
					</thead>
					<tr class="odd">
				<td class="col-first">Call status</td>
				<td class="col-first">Numbers</td>
<td class="col-first" style="padding-left:10px">&nbsp </td>						
	</tr>
	<?php 
	
$call_statuses 			=	$new_campaign->call_statuses($agent_id,$sdate,$edate,$campaign_id);
			while(!$call_statuses->EOF){?>
			<tr class="odd">									
<td class="col-first"><?php echo  $call_statuses->fields["call_status"]; ?>  </td>
<td class="col-first"><?php  echo $call_statuses->fields["call_status_count"];?>
		 	</td>
		 	<td class="col-first" style="padding-left:10px">
							 &nbsp
						</td> </tr>
		 
		
		 <?php $call_statuses->MoveNext(); } ?>
					<tbody></tbody></table>
				
			
			
   
    <br />
	
	
	
	
	</div>
	
	</div>
	
	</div>
	
	
					</tr>
					</tbody>
				</table>
			</form>	
   	</div>
      <form name="xForm2" id="xForm2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; margin-top:10px; ">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();"class="button" >
	 <span>Export EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>
  </div>
</form>





    <form name="xForm3" id="xForm3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; margin-top:10px;">
	<a  href="new_campaign.php?campaign_id=<?php echo $campaign_id;?>"class="button" >
	 <span>Export Campaign Summary</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  
  </div>
</form>
	<?
} ?>
</div>



<?php include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
