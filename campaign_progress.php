		
		<?php include_once("includes/config.php"); ?>
		<?php
			$page_name = "campaign_progress.php";
			$page_title = "Campaign Progress";
			$page_level = "2";
			$page_group_id = "1";
			$page_menu_title = "Campaign Progress ";
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
					if(isset($campaign_id) && !empty($campaign_id))
				{
				$rsAdmin	=	$campaign->get_campaign_by_id($campaign_id);
				if($rsAdmin->EOF){
				$_SESSION[$db_prefix.'_RM'] = "Admin panel user updation rejected or not found.";
				header ("Location: admin.php");
				exit();
				}			
				$cname		 				= $rsAdmin->fields['campaign_name'];
				$cnature 					= $rsAdmin->fields['campaign_nature'];
				$file						= $rsAdmin->fields['title'];
				$start_datetime 			= $rsAdmin->fields['start_datetime'];
				$end_datetime 				= $rsAdmin->fields['end_datetime'];
				$ischeme 					= $rsAdmin->fields['investment_scheme'];
			 	$campaign_script 			= $rsAdmin->fields['campaign_script'];}
					?>
		
				<div class="box">      
				<h4 class="white">Campaign Progress</h4>
				<div class="box-container">
				<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
				<input type="hidden" id="campaign_id" name="campaign_id" value="<?php echo $tools_admin->encryptId($campaign_id); ?>"/>
				
				<h3>Progress</h3>
			
				<fieldset>
				<legend>Fieldset Title</legend>
				<ol>
					<li class="even"><label class="field-title">Campaign Name <em>*</em>:</label> <label><input  style="border: none"  readonly="readonly" name="cname" id="cname" maxlength="30" value="<?php echo  $cname; ?>" ></label><span class="clearFix">&nbsp;</span></li>
					
					
		
														

	<?php 

	
	
	

		
 	$rs=$campaign->campaign_progress($campaign_id);
 	for($i=0;$i< $rs->RecordCount();$i++)
		{

		?>
			<li class="even">	<label class="field-title">Agent Name & Status:</label><label><input style="border: none"  readonly="readonly"  value="<?php echo  $rs->fields["full_name"];
				 ?>" ><input style="border: none"  readonly="readonly"  value="<?php $ans=$rs->fields["status"];
		
		if ($ans==1)
		{
		echo 'Active';
		}
		else
		{
		echo 'Not Active';
		}
				 ?>" >
				 
				 
				 
				 
				 
				 </label><span class="clearFix">&nbsp;</span></li>
				
				
				<?Php  	
				$rs->MoveNext();
	}
	

	?>		

													
				<li class="even"><label class="field-title">Start Date:</label> <label><input style="border: none"   name="fdate" id="fdate"  value="<?php echo $start_datetime ; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown',true,'24',true)"></label><span class="clearFix">&nbsp;</span></li>
			
				<li class="even"><label class="field-title">Total Numbers:</label> <label><input  style="border: none"  readonly="readonly"  value="<?php  echo $campaign->total_numbers($campaign_id) ; ?>"></label><span class="clearFix">&nbsp;</span></li>
 												
				</ol>
				</fieldset>
				<p class="align-right">
				<?php   if(isset($campaign_id) && !empty($campaign_id)){
				?>
				<a class="button" href="campaign.php" ><span>Back</span></a>
				<a class="button" href="campaign_analytics.php?campaign_id=<?php echo $campaign_id; ?>" ><span>View Campaign Analytics</span></a>
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
