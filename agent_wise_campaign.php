			<?php include_once("includes/config.php"); ?>
			<?php
				$page_name = "agent_wise_campaign_reports.php";
				$page_title = "Agent Wise Campaign Report";
				$page_level = "2";
				$page_group_id = "1";
				$page_menu_title = "Agent Wise Campaign Report";
			?>
			<?php include_once($site_root."includes/check.auth.php"); ?>
			<?php 	
				include_once("classes/tools_admin.php");
				$tools_admin = new tools_admin();
				include_once("classes/templates.php");
				$templates = new templates();
				include_once("classes/agent.php");
				$agent = new agent();
				
				include_once("classes/user_tools.php");		
				$user_tools = new user_tools();
				include_once("classes/reports.php");
				$reports = new reports();
				include_once("classes/campaign.php");
				$campaign = new campaign();
			
			?>
	

<script>

function getvalues() {

var fdate = document.getElementById("fdate").value;
var search_keyword = document.getElementById("agent_id").value;
var tdate = document.getElementById("tdate").value;

if (fdate == null || search_keyword == 0 || search_keyword == null || tdate == null){

alert("Please select valid values!");
return false;
}


}
</script>
<script type="text/javascript">


function getHtml4Excel()
{
document.getElementById("gethtml1").value = document.getElementById("agent_pd_report").innerHTML;
}


</script>
	
	<?php 		include($site_root."includes/header.php"); ?>	
	   
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
	$db_export_fix = $site_root."download/agent_wise_campaign_report.xls";
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


<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Agent Wise Campaign Report</div>
	

	<div id="mid-col" class="mid-col">
	<div class="box">
		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
	<div class="box">
	
	<h4 class="white">
	<table>
		<tr>
			<td style="padding-right:5px; color:white;">
				From Date :
			</td>
			<td>
	 			<label>
				<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo $fdate; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown')">
				</label>
			</td>
			<td style="padding-left:20px">
				<label>
	
				<?php 
				echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name","",false,"form-select",$search_keyword,"Agent"," designation = 'Agents' "); ?>
				</label>
			</td>
			
		</tr>
		<tr>
			<td style="padding-top:10px; color:white;">
				To Date :
			</td>
			<td>
	 			<label>
				<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo $tdate; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('tdate','yyyyMMdd', 'dropdown')">
				</label>
			</td>
		</tr><tr>

	<td>
	<?php echo "<select name='select2' id='select2'>";
	?>
		<option value="all">All Campaigns</option>
	<? 
	$campaignfunc			=	$agent->new_campaign($campaign_id);
	while(!$campaignfunc->EOF){
	?>

	<?
		echo 
		"<option value='".$campaignfunc->fields['campaign_id']."'>".$campaignfunc->fields["campaign_name"]."</option>";
		$campaignfunc->MoveNext();
		}
	echo "</select>";?>
	
	</td>
	
	
			
			</tr>
			
			
			
			
			
			
			
			
			<td>
			
	

			
				<a class="button" href="javascript:document.xForm.submit();"  onclick="javascript:return getvalues();">
		 		<span>Search</span>
		 		</a>
				<input type="hidden" value="Search" id="Show" name="Show" />
			</td>
		</tr>
	</table>
	</h4>
	</form>
	</div>
	
	
	
	

	
	
	
	


	</div>
	<?php
	if (isset($_POST['Show']))
	{
	$agent_id				=	$_REQUEST['search_keyword'];
	$campaign_id=$_REQUEST['select2'];
	$sdate = $_POST['fdate'];
	$edate =  $_POST['tdate'];
	//echo $agent_id.$campaign_id.$sdate.$edate.'waleed khan';exit;	
	$agent_wisetime_time=	$agent->agent_wisetime_time($agent_id,$sdate,$edate,$campaign_id);
    $on_hold			=	$agent->agent_wisetime_time_hold($agent_id,$sdate,$edate,$campaign_id);
	$crm				=   $agent->crm_campaign_activity($agent_id,$sdate,$edate,$start_datetime,$end_datetime,$campaign_id);
	$no_of_calls		=   $agent->no_of_calls($agent_id,$sdate,$edate,$campaign_id);
	?><div id="agent_pd_report">	
	
	<div id="mid-col" class="mid-col">
	<div class="box">
	<?php $break = 0; ?>
	
<br/><br/>
	<h4 class="white">
	<?php 	echo "Agent Report :" . $no_of_calls->fields['full_name'];?>
	
			<br/><br/><?php 
			//$campaignfunc			=	$campaign->id_get2($campaign_id);
			//if ($campaign_id != 'all'){
			// echo "Campaign Name:" .$campaignfunc->fields["campaign_name"];
			// }else {echo "ALL CAMPAIGNS";}
			 
			 
			 ?></h4>
			<?php 
			
			$stringData .= "\nAgent Wise Campaign Report".$no_of_calls->fields['full_name']. "Campaign".$campaignfunc->fields["campaign_name"]; 
			?></td>
	<div class="box-container"  >  		
	<table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
	<thead>
	<tr>
	<td colspan="12" class="paging"><?php echo($paging_block);?></td>
	</tr>
	<tr class="odd">
				<td class="col-first">Number of calls :</td>
				<td class="col-first"><?php	echo $no_of_calls->fields["count_no_of_calls"];?> 
				<?php 	$stringData .= "\nNumber of Calls\t".$no_of_calls->fields["count_no_of_calls"]."\n"; ?>
				 </td>
				<td class="col-first" style="padding-left:10px"> &nbsp </td>	
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Total Talk Time:</td>
				<td class="col-first">
				<?php if( $agent_wisetime_time->fields["agent_time"]==''){echo '00:00:00';}else {echo $agent_wisetime_time->fields["agent_time"]; } ?><?php $stringData .= "\nTotal talk Time\t".$agent_wisetime_time->fields["agent_time"]."\n"; ?></td>
				
				<td class="col-first" style="padding-left:10px"> &nbsp </td>
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Average Talk Time:</td>
				<td class="col-first">
				<?php if( $agent_wisetime_time->fields["avg_agent_time"]==''){echo '00:00:00';}else {echo $agent_wisetime_time->fields["avg_agent_time"]; } ?><?php $stringData .= "\nAverage talk Time\t". $agent_wisetime_time->fields["avg_agent_time"]."\n"; ?></td>
				
				<td class="col-first" style="padding-left:10px"> &nbsp </td>
	</tr>
					
						
	<tr class="odd">
				<td class="col-first">Total Hold Time:</td>
				<td class="col-first">
				<?php if( $on_hold->fields["on_hold"]==''){echo '00:00:00';}else {echo $on_hold->fields["on_hold"]; } ?><?php $stringData .= "\nTotal Hold Time\t".$on_hold->fields["on_hold"]."\n"; ?>		</td>
				
				<td class="col-first" style="padding-left:10px">&nbsp </td>					
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Average Hold Time:</td>
				<td class="col-first">
				<?php if( $on_hold->fields["on_hold_avg"]==''){echo '00:00:00';}else {echo $on_hold->fields["on_hold_avg"]; } ?><?php 	$stringData .= "\nAverage Hold Time\t".$on_hold->fields["on_hold_avg"]."\n"; ?>	</td>	
				
				<td class="col-first" style="padding-left:10px"> &nbsp </td>					
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Total Hours spent on campaign</td>
				<td class="col-first">
				<?php if( $crm->fields["time"]==''){echo '00:00:00';}else {echo $crm->fields["time"]; } ?><?php 
	$stringData .= "\nTotal Hours spent on campaign\t".$crm->fields["time"]."\n"; ?></td>
						
				<td class="col-first" style="padding-left:10px">&nbsp </td>
	</tr>
	
	
	<tr class="odd">
				<td class="col-first">Total Days spent on campaign:</td>
				<td class="col-first">
				<?php if( $crm->fields["DAY"]==''){echo '0 Days';}else {echo $crm->fields["DAY"].' Days'; } ?><?php 	$stringData .= "\nTotal Days spent on campaign\t".$crm->fields["DAY"].' Days'."\n"; ?>	</td>
					
				<td class="col-first" style="padding-left:10px">&nbsp </td>
	</tr>
		<?php  
							
							
							

	
	
	


	 ?>			
						
	</tbody>
	</table>
	</div>
	</div>
	</div>
	</tr>
	</tbody>
	</table></div>
	<? 
	} ?>	
	
	
	</div><form name="xForm2" id="xForm2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; ">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();"class="button" >
	 <span>Export EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>
  </div>
</form>


	<?php include($site_admin_root."includes/footer.php"); ?>
