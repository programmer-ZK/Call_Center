<?php include_once("includes/config.php"); ?>
<?php
		$page_name = "SHORT MESSAGING SERVICE";
		$page_title = "SHORT MESSAGING SERVICE";
		$page_level = "0";
		$page_group_id = "0";
		$page_menu_title = "SHORT MESSAGING SERVICE";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admins = new admin();		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
include_once("classes/tools.php");
	$tools = new tools();
	
	include_once("classes/sms.php");
	$sms = new sms();	
?>	
<?php include($site_root."includes/header.php"); ?>
	
	<script type="text/javascript">
	function show(id)
	{
	//alert(id);
	alert(document.getElementById(id+'body').innerHTML);
	}
	</script>
<?php  
	
	$total_records_count = $sms->get_links_counts($recStartFrom, $page_records_limit, $field, $order,$to,$bcc, $subject, $body,$datetime,$staff_id);
	
	include_once("includes/paging.php");
	
			$rs = $sms->get_records($recStartFrom, $page_records_limit, $field, $order,$to,$bcc, $subject, $body,$datetime,$staff_id);

	?>
	
<form name="listings" id="listings" action="sms_list.php" method="post" onSubmit="javascript:return Confirmation(this);" >
	



<!-- -------------------- -->
<div class="col" id="col" >

<div class="box">
      		<h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">  
		
		<table class="table-short">


	
		</table>
	
	
      		<table class="table-short">
      			<thead>
				<tr >
	                        <td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
      				<tr>
						<td class="col-head2">Number</td>
		
						<td class="col-head2">Message</td>
						<td class="col-head2">DateTime</td>
	

				</tr>
      			</thead>

      			<tfoot>
      				<tr>
      					
	
	</td>
	<div class="align-right">

      				</tr>

      			</tfoot>
      			<tbody>
				 <?php
			            $counter=0;
		
								while(!$rs->EOF){ $rs->fields["sms_id"]; 
								?>
	
					<tr class="odd">
				
					<td class="col-first"><?php echo $rs->fields["number"]; ?> </td>
		
									
		<td class="col-first"><?php echo $rs->fields["body"]; ?> </td>
		
					<td class="col-first"><?php echo $rs->fields["sending_datetime"];
						?> </td>
					
						
					 <?php
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
</div> <!-- full-col-center end -->
<!-- --------------------- -->

</form>

	<?php include($site_admin_root."includes/footer.php"); ?>