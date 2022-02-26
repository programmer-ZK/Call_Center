<?php include_once("includes/config.php"); ?>
<?php
		$page_name = "campaign";
		$page_title = "Campaign List";
		$page_level = "2";
		$page_group_id = "1";
		$page_menu_title = "Campaign List";
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
	
	<script type="text/javascript">
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}

function show(id)
	{
	//alert(id);
	alert(document.getElementById(id+'body').innerHTML);
	}
	
	
 
	
	
</script>
<?php  
	
	$total_records_count = $campaign->get_links_counts($recStartFrom, $page_records_limit, $field, $order, $cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id);
	//echo $total_records_count;exit;
	include_once("includes/paging.php");
	
			$rs = $campaign->get_records($recStartFrom, $page_records_limit, $field, $order, $cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id);
		//	echo $rs->fields['campaign_id'];exit;
		
		

	?>
	
<form name="listings" id="listings" action="campaign.php" method="post" onSubmit="javascript:return Confirmation(this);" >
	



<!-- -------------------- -->
<div class="col" id="col" >

<div class="box">
      		<h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">     		
      		<table class="table-short">
      			<thead>
				<tr >
	                        <td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
      				<tr>
						<td class="col-head2">Name</td>
							
					<!--	<td>Campaign Nature</td>
									
						<td class="col-head2">Investment Scheme </td>  
						-->
						<td class="col-head2">Validity</td>
						                     				
					<!--	<td class="col-head2">Start Date </td> 
										
						<td class="col-head2">End Date</td>    	
								
						<td class="col-head2">Staff id</td>-->
						
						<!--<td class="col-head2">Progress</td>-->
					<td class="col-head2">Script</td>
					<!--	<td class="col-head2">Report</td>-->
						
						<td class="col-head2">Edit</td>
						<td class="col-head2">Status</td>
						<td class="col-head2">Delete</td>
	

				</tr>
      			</thead>

      			<tfoot>
      				<tr>
      					
	
	</td>
	<div class="align-right"><br/>
	<td colspan="6"><br/><div class="align-right"><a href="campaign_new.php" name="add_campaign" id="add_campaign" class="button"><span>CreateCampaign</span></a> </div></td>						
	
					
	<input type="hidden" value="CREATE CAMPAIGN " id="add" name="add"/>
      				</tr>

      			</tfoot>
      			<tbody>
				 <?php
			             $counter=0;
					 
								while(!$rs->EOF){ $a =$rs->fields["campaign_id"];
								 $campaign_status=$rs->fields["campaign_status"];
								//echo $a;exit;
								 ?>
	
					<tr class="odd">
				
					<td class="col-first"><?php echo $rs->fields["campaign_name"]; ?> </td>
			<!--		<td class="col-first"><?php echo $rs->fields["campaign_nature"];  ?> </td>
						
					<td class="col-first"><?php echo $rs->fields["investment_scheme"];  ?> </td>-->
						<td class="col-first"><?php  
						
						
						$days= $campaign->timeremaining($rs->fields["campaign_id"]);
						$num=$campaign->campaign_status($rs->fields["campaign_id"]);
						$numbers = $num->fields['numbers'];
						if ($days<=0 && $numbers==0)
						{echo 'Completed';}
						else if ($days<=0 && $numbers!=0)
						{echo 'Delayed';}
						else 
						{ echo $days .' days';}
						
						?> </td>
					
					<!--	<td class="col-first"><?php echo $rs->fields["start_datetime"];  ?>
						</td>
						
						
						<td class="col-first"><?php echo $rs->fields["end_datetime"];  ?> 
						</td>	   
						
						<td class="col-first"><?php echo $rs->fields["staff_id"];  ?> </td>	  -->
						
						<!--<td class="col-first"><?php $ab= unserialize($rs->fields["agent"]);$b=implode(',',$ab);echo $b; //echo $rs->fields["agent"];  ?> -->
						</td>
						
					<!--	<td class="col-first"><?php
					
				 //echo $campaign->count_caller_id($rs->fields["campaign_id"])  ;
						//$result = mysql_query("select count(caller_id) from cc_campaign_detail where  	campaign_id= '$a'"); $count = mysql_result($result,0);echo $count;  
					?> 
						</td>-->
						
						
					<!--	<td class="row-nav"><a href="JavaScript:newPopup('caller_list.php?campaign_id=<?php echo $tools_admin->encryptId($rs->fields["campaign_id"]); ?>');" >View</a> </td>-->
						
					<!--	<td class="row-nav"> <a href="campaign_progress.php?campaign_id=<?php //echo $tools_admin->encryptId($rs->fields["campaign_id"]); ?>">View</a></td>-->
				<!--	<td class="row-nav"><a href="JavaScript:newPopup('campaign_script.php?campaign_id=<?php //echo 'waleed';//$tools_admin->encryptId($rs->fields["campaign_id"]); ?>');" >View</a> </td>-->
							
						<!--	
							<td class="row-nav"> <a href="campaign_analytics.php?campaign_id=<?php //echo $tools_admin->encryptId($rs->fields["campaign_id"]); ?>">View Details</a></td>-->
							
							<td class="row-nav"><div id="<?php echo $counter.'body'; ?>" style="display:none;"><?php echo $rs->fields["campaign_script"]; ?> </div><a href="" id="<?php echo $counter; ?>"  name="link"  onclick="show(this.id);">Read</a> </td>
							
							
							
								<!--<td class="row-nav"> <a href="campaign_reports.php?campaign_id=<?php //echo $tools_admin->encryptId($rs->fields["campaign_id"]);?>">Report</a></td>-->
							<!--	<td class="row-nav"> <a href="campaign_email.php?campaign_id=<?php echo $tools_admin->encryptId($rs->fields["campaign_id"]); ?>">Email</a></td>-->
							
					<td class="row-nav"> <a href="campaign_edit.php?campaign_id=<?php echo $tools_admin->encryptId($rs->fields["campaign_id"]); ?>" class="table-edit-link"></a></td>
                              		
						
						
						  <td class="row-nav">
						  
<select id="select" name="select" onchange="javascript:showStatus(this.value,'<?php echo $a; ?>');"  >
 <option value="">Please Select</option>
  <option value="Postponed/Hold" <?php if($campaign_status == 'Postponed/Hold') { ?> selected="selected" <? } ?>>Postponed/Hold</option>

  <option value="Cancelled"   <?php if($campaign_status == 'Cancelled') { ?> selected="selected" <? } ?>>Cancelled</option>

</select>
</td>
						    <td class="row-nav">
						  
                                         <?php //if(!empty($rs->fields["status"])){ ?>
                                         <a href="campaign_delete.php?campaign_id=<?php echo $tools_admin->encryptId($rs->fields["campaign_id"]); ?>" class="table-delete-link" alt = "Delete"></a>
                                         <?php //} else {?> &nbsp;
                                         <?php  //} ?>

                                </td>
						
						
						
						
						
									  
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
	<script language="javascript">
    

        function showStatus(str,b){//alert(str);alert(b);
            if (str=="")
              {
              document.getElementById("txtHint").innerHTML="";
              return;
              }
            if (window.XMLHttpRequest)
              {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","getcampaign.php?q="+str+"&x="+b,true);
            xmlhttp.send();
            alert('Status Changed');
            
        }
</script>
