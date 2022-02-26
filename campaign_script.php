<?php include_once("includes/config.php"); ?>
<?php
		$page_name = "campaign";
		$page_title = "Campaign Script";
		$page_level = "2";
		$page_group_id = "1";
		$page_menu_title = "Campaign Script";
?>
<?php include($site_root."includes/iheader.php"); ?>
<?php include_once($site_root."includes/check.auth.php"); ?>

		<?php include_once($site_root."includes/check.auth.php"); ?>
		
		<?php include_once("classes/campaign.php");
			  $campaign = new campaign();
	 	?>	
		<?php 	
		
			include_once("classes/tools_admin.php");
			$tools_admin = new tools_admin();
		?>
		
				
		
<?php  
	
			$campaign_id = $_GET['campaign_id'];
			$campaign_sel = "campaign_id = " . $campaign_id;
			//$rs = $campaign->get_records($recStartFrom, $page_records_limit, $field, $order, $cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id);
			$rs1 = $tools_admin->select('campaign_script','campaign',$campaign_sel);
	?>		
		


	

	
      		
        
      		<table class="table-short">
      			<thead>
				<tr >
	                        <td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
      				<tr>
						<td >Campaign Script</td>
							
					

				</tr>
      			</thead>

      			
      			<tbody>	
						
					<td class="row-nav"><?php echo $rs1; ?></td>
				</tbody>		


</table>


	<?php include($site_root."includes/ifooter.php"); ?>