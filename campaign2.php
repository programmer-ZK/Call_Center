	
	
	
	
	<?php include_once("includes/config.php"); ?>
	<?php
		$page_name = "campaign";
		$page_title = "Campaign List";
			
		$page_menu_title = "Campaign List";
	?>
	
	<?php include_once($site_root."includes/check.auth.php"); ?>
		<?php include_once("classes/campaign.php");
			  $campaign = new campaign();
	
	 	?>	
		
	<?php
	$campaign = $_REQUEST['campaign'];

	?>
	
	
	
	<?php 	
		
			include_once("classes/tools_admin.php");
			$tools_admin = new tools_admin();
			
			include_once("classes/templates.php");
			$templates = new templates();
		?>
		<?php include($site_root."includes/header.php"); ?>
		
	<?php 
	include_once("classes/campaign.php");
			  $campaign = new campaign();
			  
	
	 	?>	
	
	


	<?php  
			
	$total_records_count = $campaign->get_links_counts($recStartFrom, $page_records_limit, $field, $order, $cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id);
	
	include_once("includes/paging.php");
	
			$rs = $campaign->get_records($recStartFrom, $page_records_limit, $field, $order, $cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id);

	?>
	
<form name="listings" id="listings" action="campaign2.php" method="post" onsubmit="javascript:return Confirmation(this);" >
	
	<!-- -------------------- -->	
	<div id="mid-col" class="mid-col">
	<div class="box">
	<h4 class="white"><?php echo($page_title)." ".$t_type; ?></h4>
	<div class="box-container">     		
	<table class="table-short">
	<thead>
	<tr >
	<td colspan="12" class="paging"></td>
	</tr>
	<tr>
							
						<td class="col-head2">Campaign Name</td>
							
						<td class="col-head2">Campaign Nature</td>
									
						<td class="col-head2">Investment Scheme </td>   
						                     				
						<td class="col-head2">Start Date </td> 
										
						<td class="col-head2">&nbsp;&nbsp; End Date</td>    	
								
						<td class="col-head2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Staff id</td>
			
									<td class="col-head">Edit</td>
									
									<td class="col-head">Delete</td>
						
	
	</tr>
	</thead>
	
	<tfoot>
	<tr>
							
	<td colspan="5">
	<div class="align-right">
							
	</div>
	</td>
	
	<td colspan="5"><div class="align-right"><a href="campaign_new2.php?campaign=<?php echo $campaign; ?>" name="add_campaign" id="add_campaign" class="button"><span>AddCampaign</span></a> </div></td>
					
	<input type="hidden" value="ADD CAMPAIGN " id="add" name="add"/>
	</tr>
	
	</tfoot>
	<tbody>
	<?php 
					 $counter=0;
					 
								while(!$rs->EOF){ ?>
	
					<tr class="odd">
				
					<td class="col-first"><?php echo $rs->fields["campaign_name"]; ?> </td>
					<td class="col-first"><?php echo $rs->fields["campaign_nature"];  ?> </td>
						
					<td class="col-first"><?php echo $rs->fields["investment_scheme"];  ?> </td>
					<td class="col-first"><?php echo $rs->fields["start_datetime"];  ?>
					</td>
						
						
					<td class="col-first"><?php echo $rs->fields["end_datetime"];  ?> 
					</td>	   
					
					<td class="col-first">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rs->fields["staff_id"];  ?> </td>	  
						
				 	<td class="row-nav"> <a href="campaign_new2.php?campaign=<?php echo $campaign; ?>&campaign_id=<?php echo $tools_admin->encryptId($rs->fields["campaign_id"]); ?>" class="table-edit-link"></a></td>
                    <td class="row-nav">
                    <?php if(!empty($rs->fields["status"])){ ?>
                    <a href="campaign_delete.php?campaign_id=<?php echo $tools_admin->encryptId($rs->fields["campaign_id"]); ?>&campaign=<?php echo $campaign; ?>" class="table-delete-link" alt = "Delete"></a> 
				
                     <?php  } else {?> &nbsp;
                     <?php  } ?>					  
					 <?php
					 $counter++;
									$rs->MoveNext();
								}
							?>
	
	
						</tr>
					</tbody>
				</table>  	
			</div>
			</div> 
	</div>
	</form>
	
	<?php include($site_admin_root."includes/footer.php"); ?>
