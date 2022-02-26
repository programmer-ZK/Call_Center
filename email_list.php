<?php include_once("includes/config.php"); ?>
<?php
		$page_name = "Email List";
		$page_title = "Email List";
		$page_level = "0";
		$page_group_id = "0";
		$page_menu_title = "Email List";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admins = new admin();		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
include_once("classes/tools.php");
	$tools = new tools();
	include_once("classes/email.php");
	$email = new email();
		
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
	
	$total_records_count = $email->get_links_counts($recStartFrom, $page_records_limit, $field, $order,$to,$bcc, $subject, $body,$datetime,$staff_id);
	
	include_once("includes/paging.php");
	
			$rs = $email->get_records($recStartFrom, $page_records_limit, $field, $order,$to,$bcc, $subject, $body,$datetime,$staff_id);

	?>
	
<form name="listings" id="listings" action="email_list.php" method="post" onSubmit="javascript:return Confirmation(this);" >
	



<!-- -------------------- -->
<div class="col" id="col" >

<div class="box">
      		<h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">  
		
				
				
				
				
				
				
				
				
				
				
				
		<? if (!isset($_REQUEST['email_id'])){ ?>
      		<table class="table-short">
      			<thead>
				<tr >
	                        <td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
      				<tr>
						<td class="col-head2">To</td>
						<td class="col-head2">Subject</td>
						<td class="col-head2">Sender Name</td>
						<td class="col-head2">DateTime</td>
						<td class="col-head2">Details</td>

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
		
								while(!$rs->EOF){ $rs->fields["id"]; 
								?>
	
					<tr class="odd">
				
					<td class="col-first"><?php echo $rs->fields["to_address"]; ?> </td>
			<!--	<td class="col-first"><?php //echo $rs->fields["bcc"];  ?> </td>-->
						
					<td class="col-first"><?php echo $rs->fields["subject_of_email"];  ?> </td>
					<td class="col-first"><?php //echo $staff_id;
			$abc= $email->get_agents_name($rs->fields["staff_id"]);
					echo $abc->fields['full_name'];
			 ?> </td>
					
			<!--<td class="col-first"><div id="<?php //echo $counter.'body'; ?>" style="display:none;"><?php //echo $rs->fields["body"]; ?> </div><?php //echo substr($rs->fields["body"],0,10); echo '...'; ?><br /><a href="email_list.php" id="<?php //echo $counter; ?>"  name="link"  onclick="show(this.id);">Read More</a> </td>-->
									
		
		
					<td class="col-first"><?php echo $rs->fields["sending_datetime"];
						?> </td>
					
						<td class="col-first">
<a href="" onclick="javascript:void window.open('email_details.php?email_id=<?=$rs->fields["id"]; ;?>','1357026860088','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">View</a>
</td>
					 <?php
						 $counter++;
									$rs->MoveNext();
								}
							?>


      				</tr>
      			</tbody>
      		</table>  	<? } ?>
      	</div><!-- end of div.box-container -->
      	</div> <!-- end of div.box -->
</div><!-- end of div#mid-col -->
</div> <!-- full-col-center end -->
<!-- --------------------- -->

</form>

	<?php include($site_admin_root."includes/footer.php"); ?>