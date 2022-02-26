<?php include_once("includes/config.php"); ?>
<?php
		$page_name = "campaign Analytics";
		$page_title = "Campaign Analytics";
		$page_level = "2";
		$page_group_id = "1";
		$page_menu_title = "Campaign Analytics";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admins = new admin();		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
	include_once("classes/campaign.php");
			  $campaign = new campaign();
?>	
<?php include($site_root."includes/header.php"); ?>	


	<?php
		
$campaign_id 				= $tools_admin->encryptId($_REQUEST['campaign_id']);

?>
<div class="box">      
				<h4 class="white">Campaign Analytics</h4>
				<div class="box-container">
				<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
				<input type="hidden" id="campaign_id" name="campaign_id" value="<?php echo $tools_admin->encryptId($campaign_id); ?>"/>
				
				<!--<h3>View Campaign Analytics</h3>-->
				<fieldset>
				<legend>Fieldset Title</legend><ol>
				<li class="even">
				<h3>View Campaign Analytics</h3></li>
	<li class="odd">
	<h3>Campaign Statistics</h3>
				<?php $a=$campaign->campaign_statistics($campaign_id);
	while(!$a->EOF){
				?>
				  <li class="even"><label class="field-title">Call Status:</label> <label><input class="txtbox-short" value="<?php echo  $a->fields["call_status"]; ?>" ></label> <label><input class="txtbox-short" value="<?php echo $a->fields["call_status_count"]; ?>" ></label><span class="clearFix">&nbsp;</span></li>
				
				 <?
				//echo $a->fields["call_status"] ;echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$a->fields["call_status_count"].'<br/>' ;
				
						$a->MoveNext();
				}		
						?>
			</li></ol>
		
				<ol><li class="odd">
	<h3>Campaign Duration</h3>
		
<?php $rs=$campaign->Number_of_days_hours($campaign_id);?>
 <li class="even"><label class="field-title">Active Days:</label> <label><input class="txtbox-short" value="<?php echo  $rs->fields["tRec1"]; ?>" ></label><span class="clearFix">&nbsp;</span></li>
  <li class="even"><label class="field-title">Active Hours:</label> <label><input class="txtbox-short" value="<?php echo $rs->fields["tRec"]; ?>" ></label><span class="clearFix">&nbsp;</span></li>
<? 
//echo '<br/>Active Number of days  :'.$rs->fields["tRec1"].'<br/>';
//echo 'Active Number of Hours  :'.$rs->fields["tRec"].'<br/>';
	
		
		$query=$campaign->campaign_duration($campaign_id);
	
		while (!$query->EOF)
		{ ?>
		
		<li class="even"><label class="field-title">Calls To:</label><label><input class="txtbox-short" value="<?php echo $query->fields["full_name"]; ?>" ></label> <label><input class="txtbox-short" value="<?php echo $query->fields["count_full_name"]; ?>" ></label><span class="clearFix">&nbsp;</span></li>
		
		<?
		
		//echo 'Number of Calls to '.$query->fields["full_name"] ;echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$query->fields["count_full_name"].'<br/>' ;
		
		$query->MoveNext();
		}
		?>
				<?php 
			//$count=$campaign->call_durations($campaign_id);	
			$count=$campaign->total_hours($campaign_id);
//echo $count->fields["tRec"];exit;

?>
 <li class="even"><label class="field-title">Number of Hours Spent on Connecting Calls:</label><label><input class="txtbox-short" value="<?php echo $count->fields["tRec"]; ?>" ></label><span class="clearFix">&nbsp;</span></li>
 <?
//echo 'Total Number of Hours spent on connecting calls :'.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$count->fields["tRec"].'<br/>';
				?>
			</li></ol>
			
			
	<ol><li class="odd">
	<h3>Call Durations</h3>
	
			<li class="even"><label class="field-title">Avergae Time Spent on Calls:</label><label><input class="txtbox-short" value="<?php echo $count->fields["avg_time"]; ?>" ></label><span class="clearFix">&nbsp;</span></li>	
				<?php 

// echo '<br/>Average Time spent on calls :'.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$count->fields["avg_time"].'<br/>';
 



$sql_query=$campaign->agent_wisetime($campaign_id);
while (!$sql_query->EOF)
		{
		?>
		
		<li class="even"><label class="field-title">Agent Average Time Spent on Call:</label><label><input class="txtbox-short" value="<?php echo $sql_query->fields["full_name"]; ?>" ></label><label><input class="txtbox-short" value="<?php echo$sql_query->fields["agent_time"]; ?>" ></label><span class="clearFix">&nbsp;</span></li>
		
		<?
		//echo $sql_query->fields["full_name"].' average time spent on call : '. $sql_query->fields["agent_time"].'<br/>' ;
		
		$sql_query->MoveNext();
		}
		
		$query=$campaign->hold_time($campaign_id);

?>
<li class="even"><label class="field-title">Average on-call Hold Time:</label><label><input class="txtbox-short" value="<?php if ($query->fields["on_hold"]!=NULL){echo $query->fields["on_hold"];}else {echo '00:00:00';} ?>" ></label><span class="clearFix">&nbsp;</span></li>
<?
		//echo 'Average on-call hold time:'.$rs->fields["on_hold"].'<br/>';
				
				
			?><?php 	
		$sql_query=$campaign->agent_wise($campaign_id);
		
while (!$sql_query->EOF)
		{
		?>
		<li class="even"><label class="field-title">Agent wise on-call Hold Time:</label><label><input class="txtbox-short" value="<?php echo $sql_query->fields["full_name"]; ?>" ></label><label><input class="txtbox-short" value="<?php echo $sql_query->fields["time"]; ?>" ></label><span class="clearFix">&nbsp;</span></li>
		
		<?
		
		$sql_query->MoveNext();
		}		
		?>	
			</li></ol>
			
			
			
					<p class="align-right">
					<a class="button" href="campaign.php" ><span>Back</span></a>
		
	</p>
			
				
 </fieldset>
			
				</form>
				</div>
				</div>
				<?php include($site_root."includes/footer.php"); ?> 
