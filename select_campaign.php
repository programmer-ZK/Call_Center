	
	<?php include_once("includes/config.php"); ?>
	<?php
		$page_name = "campaign";
		$page_title = "Campaign List";
					$page_level = "2";
			$page_group_id = "1";
		$page_menu_title = "Campaign List";
	?>
	
	<?php include_once($site_root."includes/check.auth.php"); ?>
		<?php include_once("classes/campaign.php");
			  $campaign = new campaign();
	
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
	
	
	<script type="text/javascript">
	function show(id)
	{
	alert(document.getElementById(id+'body').innerHTML);
	}
	</script>

	<?php  
	
	$total_records_count = $campaign->get_links_counts($recStartFrom, $page_records_limit, $field, $order, $cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id);
	
	include_once("includes/paging.php");
	
		//	$rs = $campaign->get_records($recStartFrom, $page_records_limit, $field, $order, $cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id);
		$rs = $campaign->get_list($_SESSION[$db_prefix.'_UserId']);


	?>
	
<form name="listings" id="listings" action="campaign.php" method="post" onSubmit="javascript:return Confirmation(this);" >
	
	<!-- -------------------- -->	
	<div id="mid-col" class="mid-col">
	<div class="box">
	<h4 class="white"><?php echo($page_title)." ".$t_type; ?></h4>
	<div class="box-container">     		
	<table class="table-short">
	<thead>
	<tr >
	<td colspan="12" class="paging"><?php echo($paging_block);?></td>
	</tr>
	<tr>
							
						<td class="col-head2">Campaign Name</td>
							
						<td class="col-head2">Campaign Nature</td>
									
						<td class="col-head2">Investment Scheme </td>   
						                     				
						<td class="col-head2">Start Date </td> 
										
						<td class="col-head2">&nbsp;&nbsp; End Date</td>    	
								
						<td class="col-head2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Staff id</td>
				
						<td class="col-head">Show</td>
			
									<!--<td class="col-head2">Caller List</td>-->
						
	
	</tr>
	</thead>
	
	<tfoot>
	<tr>
							
	<td colspan="5">
	<div class="align-right">
							
	</div>
	</td>
	
					
	<input type="hidden" value="CREATE CAMPAIGN " id="create_campaign" name="create_campaign"/>
	</tr>
	
	</tfoot>
	<tbody>
	<?php 
					 $counter=0;
					 
								while(!$rs->EOF){
					 $ab= explode(",",$rs->fields["agent"]);
                                        //   print_r($ab);
							 ?>
					
					<tr class="odd">
					<?if(in_array($_SESSION[$db_prefix.'_UserId'], $ab)){//echo "farhan";?>
				
					<td class="col-first"><?php echo $rs->fields["campaign_name"]; ?> </td>
					<td class="col-first"><?php echo $rs->fields["campaign_nature"];  ?> </td>
						
					<td class="col-first"><?php echo $rs->fields["investment_scheme"];  ?> </td>
						<td class="col-first"><?php echo $rs->fields["start_datetime"];  ?>
						</td>
						
						
						<td class="col-first"><?php echo $rs->fields["end_datetime"];  ?> 
						</td>	   
						
						<td class="col-first">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rs->fields["staff_id"];  ?> </td>

  						 <td class="row-nav"> <a href="out_campaign.php?campaign_id=<?php echo $rs->fields["campaign_id"]; ?>" class="table-edit-link"></a></td>
                              		
									  
					 <?php }
					 $counter++;
									$rs->MoveNext();
								}
							?>
	
	
						</tr>
					</tbody>
				</table>  	
			</div><!-- end of div.box-container -->
			</div> <!-- end of div.box -->
	</div><!-- end of div#mid-col -->
	<!-- --------------------- -->
	</form>
	
	<?php include($site_admin_root."includes/footer.php"); ?>
