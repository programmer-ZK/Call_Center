<?php 
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();

		include_once("classes/user_tools.php");		
		$user_tools = new user_tools(); 		
		
?>

<?php
		
		$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
		$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
		
		$method = 'GetContactRegisteredInfo';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel); 
		$rs1 = $soap_client->call_soap_method($method,$params);
		//print sizeof($rs1); exit;

?>

 <div class="box">
                <h4 class="white" style="margin-top: 70px;"><?php echo("Contact Detail"); ?></h4>
        <div class="box-container">
      		<table class="table-short">
      			<thead>
      				<tr>
						<th >ID</th>
						<th >Channel</th>
						<th >Modified On</th>
						<th >Status</th>
						<th >CallLogId</th>
						<!--
						<th >Reason</th>
						<th >Residence</th>
						<th >Office</th>
						<th >Mobile</th>
						-->
						<th></th>						
      				</tr>
      			</thead>
      			<tfoot><!--
      				<tr>
      					<td class="col-chk"><input type="checkbox" /></td>
      					<td colspan="4"><div class="align-right"><select class="form-select"><option value="option1">Bulk Options</option><option value="option2">Delete All</option></select>
      					<a href="#" class="button"><span>perform action</span></a></div></td>
      				</tr> -->
      			</tfoot>
      			<tbody>
			<?php
	                $count = 0;
					//print count($rs1)."yahya";exit;
                	while($count != count($rs1)){ 
					
						if(ucwords($rs1[$count]["IsResidenceRegister"]) == "YES")
						{
							$checked_str_r ="checked=\"checked\"";		
						}
						else
						{
							$checked_str_r ="checked=\"checked\"";			
						}
						if(ucwords($rs1[$count]["IsOfficeRegister"]) == "YES")
						{
							$checked_str_o ="checked=\"checked\"";		
						}
						else
						{
							$checked_str_o ="";					
						}	
						if(ucwords($rs1[$count]["IsMobileTransRegister"]) == "YES")
						{
							$checked_str_m ="checked=\"checked\"";		
						}
						else
						{
							$checked_str_m ="";					
						}
						
						if(ucwords($rs1[$count]["IsMobileSmsRegister"]) == "YES")
						{
							$checked_str_sms ="checked=\"checked\"";	
						}
						else
						{
							$checked_str_sms ="";			
						}
					
					?>

      				<tr class="odd">
      					<!--<td class="col-chk"><input type="checkbox" /></td>-->
      					<td class="col-first">
							<?php  echo $rs1[$count]["Id"]; ?>
						</td>
      					<td class="col-first">
							<?php echo $rs1[$count]["Channel"]; ?>
						</td>
      					<td class="col-first">
							<?php echo $rs1[$count]["ModifiedOn"]; ?>
						</td>
						<td class="col-first">
							<?php echo substr($rs1[$count]["Status"],0,3); ?>
						</td>
						<td class="col-first">
							<?php echo $rs1[$count]["CallLogId"]; ?>
						</td>																		
<!--						<td class="col-first">
							<input type="radio" name="residence" id="residence" value="<?php //echo $rs1[$count]["Residence"]; ?>" <?php //echo $checked_str_r; ?> disabled="disabled"/>
							<?php //echo $rs1[$count]["Residence"]; ?> 
						</td>
	                    <td class="col-first">
							<input type="radio" name="office" id="office" value="<?php //echo $rs1[$count]["Office"]; ?>" <?php //echo $checked_str_o; ?> disabled="disabled"/>
							<?php //echo $rs1[$count]["Office"]; ?> 
						</td>
						<td class="col-first">
							<input type="radio" name="mobile" id="mobile" value="<?php //echo $rs1[$count]["Mobile"]; ?>"  <?php //echo $checked_str_m; ?> disabled="disabled"/>
							<?php //echo $rs1[$count]["Mobile"]; ?> 
							<br />
							<input type="radio" name="mobile_sms" id="mobile_sms" value="<?php //echo $rs1[$count]["Mobile"]."_sms"; ?>"  <?php //echo $checked_str_sms; ?> disabled="disabled"/>
							SMS
						</td>
-->
						<td class="row-nav"><a href="registeration_detail.php?customer_id=<?php echo $customer_id; ?>&account_no=<?php echo $account_no."&tid=".$rs1[$count]["Id"]; ?>" class="table-edit-link">View</a> </td>

      				</tr>
			 <?php
                        $count++;
                }
                ?>
				
				<tr> 
				<?php 
						if($rs1[0]["IsMobileSmsRegister"] == "Y")
						{ ?>
							 <td colspan="12" class="paging"><b>Number Registered for SMS Services :<?php echo $rs1[0]["Mobile"]; ?> </b></td>	
						<?php }
						else
						{
											
						}
				?>
				
         	        </tr>
<!--					<tr> 
				 <td colspan="12" class="paging"><b>Registered for Tele Transact Services "<input type="radio" name="dumy" id="dumy" value="dumy"  checked="checked" disabled="disabled"/>"</b></td>
         	        </tr>
					<tr> 
				 <td colspan="12" class="paging"><?php echo($paging_block);?></td>
         	        </tr>-->

      			</tbody>
      		</table>
        </div>
        </div> 
