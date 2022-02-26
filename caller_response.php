
<?php include_once("includes/config.php"); ?>
<?php
		$page_name = "Caller Response";
		$page_title = "Caller Response";
		$page_level = "1";
		$page_group_id = "1";
		$page_menu_title = "Caller Response";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admins = new admin();	
	include_once("classes/agent.php");
	$agent = new agent();		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
	include_once("classes/campaign.php");
	$campaign = new campaign();
?>	
<?php include($site_root."includes/header.php"); ?>

<?php

$campaign_id			=	$_REQUEST['campaign_id'];
$attempts				=	$_REQUEST['attempts'];

$campaignid				=	$campaign->id_get2($campaign_id);
	
	
?>

	
<div>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Caller Response Report</div>
<div class="box">
<h4 class="white">
	 	<?php 	
	echo "View By Campaign:";
		?>
		<td><?php  
echo "<select name='campaign_id' id='campaign_id'>";
while(!$campaignid->EOF){

    echo "<option value='".$campaignid->fields['campaign_id']."'>".$campaignid->fields["campaign_name"]."</option>";
	$campaignid->MoveNext();
	}
echo "</select>";?>

<?php  
echo "<select name='attempts' id='attempts'>";
 echo "<option value='all'>All</option>";
  echo "<option value='0'>0</option>";
	  echo "<option value='1'>1</option>";
	    echo "<option value='2'>2</option>";
  echo "<option value='3'>3</option>";
echo "</select>";?>



<a class="button" href="javascript:document.xForm.submit();" onClick="javascript:return msg_validate('xForm');" ><span>Show</span></a>

				
			
				
				<input type="hidden" value="Show" id="show" name="show"/>
				
</td>
</h4>

</div>
</form>
<br/>
<?php

if ((isset($_POST['show']))||(isset($_GET['campaign_id'])))
{
$campaign_id			=	$_REQUEST['campaign_id'];
$attempts				=	$_REQUEST['attempts'];
//echo $campaign_id.'-'.$attempts	;exit;
$total_records_count = $agent->get_count_numbers($campaign_id,$recStartFrom, $page_records_limit, $field, $order,$attempts);
//echo $total_records_count;exit;
	include_once("includes/paging.php");

$rs = $agent->get_numbers($campaign_id,$recStartFrom, $page_records_limit, $field, $order,$attempts);
		
?>
	
<!-- -------------------- -->
<div class="full-col-center" id="full-col-center" >
<div id="full-col" class="full-col">
<div class="box">
  	
      		<h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">
                <table class="table-long">
      			<thead>
				<tr >
	
	                        <td colspan="12" class="paging"><?php echo($paging_block);?></td>
						
        		        </tr>
    			<tr>
						<td class="col-head">Name</td>
						<td class="col-head">ID/CNIC</td>
						<td class="col-head">Contact#1</td>  
						<td class="col-head">Contact#2</td>
						<td class="col-head">Contact#3</td> 
						<td class="col-head">City</td>    	
						<td class="col-head">IC</td>
						<td class="col-head">Source</td>
						<td class="col-head">Attempts</td>
						<td class="col-head">IVR FeedBack</td>
						<td class="col-head">Call FeedBack</td>
						<td class="col-head">Agent Name</td>

				
	

				</tr>
      			</thead>

      			<tfoot>
      				<tr>
      					
	
	</td>
	<div class="align-right"><br/>
	
      				</tr>

      			</tfoot>
      			<tbody>
				 <?php
			    
					 
								while(!$rs->EOF){ ?>
	
					<tr class="odd">
					
					
				
					<td class="col-first"><?php echo $rs->fields["name"]; ?></td>
					<td class="col-first"><?php echo $rs->fields["cnic"]; ?></td>
					<td class="col-first"><?php echo $rs->fields["caller_id"]; ?></td>
					<td class="col-first"><?php echo $rs->fields["caller_id2"]; ?></td>
					<td class="col-first"><?php echo $rs->fields["caller_id3"]; ?></td>
					<td class="col-first"><?php echo $rs->fields["city"]; ?></td>
					<td class="col-first"><?php echo $rs->fields["ic"]; ?></td>
					<td class="col-first"><?php echo $rs->fields["source"]; ?></td>
					<td class="col-first"><?php echo $rs->fields["attempts"]; ?></td>
					<td class="col-first"><?php
					$result0 =$agent->campaign_number_feedback($rs->fields["unique_id"]);
					
					 echo $result0->fields['rank'] ; ?></td>
<td class="col-first"><?php
					$result1 =$agent->call_number_feedback($rs->fields["unique_id"]);
					
					 echo $result1->fields['workcodes'] ; ?></td>
					
					<td class="col-first"><?php 
					$result = $agent->agents_name($rs->fields["staff_id"]);
					echo $result->fields['full_name']; ?></td>
					
				
				

									  
					 <?php
									$rs->MoveNext();
								}
							?>


      				</tr></div>
			
      			</tbody>
      		</table>  	
      	</div><!-- end of div.box-container -->
      	</div> <!-- end of div.box -->
</div><!-- end of div#mid-col -->
</div> <!-- full-col-center end -->
</div>
<!-- --------------------- --><br/>




</form>


<form name="xForm2" id="xForm2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">

	<a onClick="getHtml4Excel()"  href="exporting_new.php?campaign_id=<?=$campaign_id   ;?>&attempts=<?=$attempts   ;?>"class="button" >
	 <span>Export EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>

</form> 
<? } ?>
</div>

	<?php include($site_admin_root."includes/footer.php"); ?>