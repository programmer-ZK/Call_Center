		
		<?php include_once("includes/config.php"); ?>
		<?php
			$page_name = "campaign_reports.php";
			$page_title = "Campaign Report";
			$page_level = "2";
			$page_group_id = "1";
			$page_menu_title = "Campaign Report ";
		?>
		<?php include_once($site_root."includes/check.auth.php"); ?>
		<?php 	
			include_once("classes/tools_admin.php");
			$tools_admin = new tools_admin();
			include_once("classes/templates.php");
			$templates = new templates();
			include_once("classes/campaign.php");
			$campaign = new campaign();
		?>
		<?php include($site_root."includes/header.php"); ?>
	
		
	
		<?php
		
					$campaign_id 				= $tools_admin->encryptId($_REQUEST['campaign_id']);
					$id=$_GET['campaign_id'];
				
					
		
					
				if(isset($campaign_id) && !empty($campaign_id))
				{
				$rsAdmin	=	$campaign->get_campaign_by_id($campaign_id);
				if($rsAdmin->EOF){
				$_SESSION[$db_prefix.'_RM'] = "Admin panel user updation rejected or not found.";
				header ("Location: admin.php");
				exit();
				}		
				$campaign_id		 		= $rsAdmin->fields['campaign_id'];	
				$cname		 				= $rsAdmin->fields['campaign_name'];
				$cnature 					= $rsAdmin->fields['campaign_nature'];
				$file						= $rsAdmin->fields['title'];
				$start_datetime 			= $rsAdmin->fields['start_datetime'];
				$end_datetime 				= $rsAdmin->fields['end_datetime'];
				$ischeme 					= $rsAdmin->fields['investment_scheme'];
				$campaign_script 			= $rsAdmin->fields['campaign_script'];
				}	


$b=$campaign->campaign_progress($campaign_id);
		?>
		
				<div class="box">      
				<h4 class="white">Campaign Reports</h4>
				<div class="box-container">
				<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
				<input type="hidden" id="campaign_id" name="campaign_id" value="<?php echo $tools_admin->encryptId($campaign_id); ?>"/>
				
				<h3>Report</h3>
			
				<fieldset>
				<legend>Fieldset Title</legend>
				<ol>
					<li class="even"><label class="field-title">Campaign Name:</label> <label><input  style="border: none" class="txtbox-short"  readonly="readonly"   readonly="readonly" name="cname" id="cname" value="<?php echo  $cname; ?>" ></label><span class="clearFix">&nbsp;</span></li>
					
					<li class="odd"><label class="field-title">Campaign Nature:</label> <label><input name="cnature" id="cnature" style="border: none" class="txtbox-short"  readonly="readonly"  value="<?php echo $cnature ; ?>" ><span class="clearFix">&nbsp;</span></li>
					
							

	
<br/>
													
				<li class="even"><label class="field-title">Start Date:</label> <label><input style="border: none"   name="fdate" id="fdate"  value="<?php echo $start_datetime ; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown',true,'24',true)"></label><span class="clearFix">&nbsp;</span></li>
				
			<li class="odd"><label class="field-title">End Date:</label> <label><input style="border: none"   name="fdate" id="fdate"  value="<?php echo $end_datetime ; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown',true,'24',true)"></label><span class="clearFix">&nbsp;</span></li>
				

			
					<li class="even"><label class="field-title">Total Numbers:</label> <label><input  style="border: none"  readonly="readonly"  value="<?php   echo $campaign->total_numbers($campaign_id) ; ?>"></label><!--<a href="JavaScript:newPopup('caller_list.php?campaign_id=<?php echo $id;?>');" >View</a>--><span class="clearFix">&nbsp;</span></li>
					
		<?php $result=$campaign->Number_of_days_hours($campaign_id);
		$query=$campaign->count_agents($campaign_id);
		 ?>
					
						<li class="odd"><label class="field-title">Number of Days and Hours:</label> <label><input  style="border: none"  readonly="readonly"  value="<?php   echo $result->fields["tRec1"].'days & ';echo $result->fields["tRec"].'hours';  ?>"></label><span class="clearFix">&nbsp;</span></li>
					
					
					<li class="even"><label class="field-title">Number of Agents:</label> <label><input  style="border: none"  readonly="readonly"  value="<?php   echo $query->fields["count_agents"];  ?>"></label><span class="clearFix">&nbsp;</span></li>
					
				
				<?php 

		
 	$rs=$campaign->campaign_progress($campaign_id);
 	for($i=0;$i< $rs->RecordCount();$i++)
		{

		?>
		<li class="odd"><label class="field-title">Name of Agent:</label> <label><input  style="border: none"  readonly="readonly"  value="<?php  echo  $rs->fields["full_name"]; ?>"></label><span class="clearFix">&nbsp;</span></li>
			
			<?   			$rs->MoveNext();
	}
	$sql=$campaign->no_of_calls($campaign_id);
	
	//echo $sql;
			?>
			<li class="even"><label class="field-title">Total Number of Attempts:</label> <label><input  style="border: none"  readonly="readonly"  value="<?php if ($sql==0){echo '0';}else {echo $sql;}; ?>"></label><span class="clearFix">&nbsp;</span></li>
				 <?php  $count=$campaign->total_hours($campaign_id);?>
				 <li class="odd"><label class="field-title">Total talk Time:</label> <label><input  style="border: none"  readonly="readonly"  value="<?php echo $count->fields["tRec"] ?>"></label><span class="clearFix">&nbsp;</span></li>
				 
										
				</ol>
				</fieldset>
				<p class="align-right">
				<?php   if(isset($campaign_id) && !empty($campaign_id)){
				?>
				<a class="button" href="campaign.php" ><span>Back</span></a>
				
				<?php }
				else  {						
				?>
				<?php } ?>					
				</p>
				<span class="clearFix">&nbsp;</span>		
				</form>
				</div>
				</div>
				<?php include($site_root."includes/footer.php"); ?> 
