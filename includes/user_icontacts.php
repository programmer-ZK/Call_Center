<?php 
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
?>

<?php
		
		$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
		$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
		
		$method = 'GetContactDetail';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel, 'CallerId'=> ''); 
		$rs1 = $soap_client->call_soap_method($method,$params); 
		
		

?>

 <div class="box">
                <h4 class="white" style="margin-top: 70px;"><?php echo("Contact Detail"); ?> <!--<a href="#" class="heading-link">Bank Detail</a>--></h4>
        <div class="box-container">
      		<table class="table-short">
      			<thead>
      				<tr>	
						<!--<th>&nbsp;</th>	-->
						<th >Customer ID</th>
						<th >Account No</th>
						<th >Residence</th>
						<th >Office</th>
						<th >Mobile</th>
      				</tr>
      			</thead>
      			<tfoot><!--
      				<tr>
      					<td class="col-chk"><input type="checkbox" /></td>
      					<td colspan="4"><div class="align-right"><select class="form-select"><option value="option1">Bulk Options</option>
      					<option value="option2">Delete All</option></select>
      					<a href="#" class="button"><span>perform action</span></a></div></td>
      				</tr> -->
      			</tfoot>
      			<tbody>
			<?php
	                $count = 0;
                	while($count != count($rs1)){ 
					
						if($rs1[$count]["isregisteredResTel"] == "Y")
						{
							$checked_str_r ="checked=\"checked\"";		
						}
						else
						{
							$checked_str_r ="";					
						}
						if($rs1[$count]["isregisteredOffTel"] == "Y")
						{
							$checked_str_o ="checked=\"checked\"";		
						}
						else
						{
							$checked_str_o ="";					
						}	
						if($rs1[$count]["isregisteredMobileTrans"] == "Y")
						{
							$checked_str_m ="checked=\"checked\"";		
						}
						else
						{
							$checked_str_m ="";					
						}
						
						if($rs1[$count]["isregisteredMobileSMS"] == "Y")
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
								<?php  echo $rs1[$count]["CustomerId"]; ?>
						</td>
      					<td class="col-first">
							<?php echo $rs1[$count]["AccountNo"]; ?>
						</td>
						<td class="col-first">
							<input type="radio" name="residence" id="residence" value="<?php echo $rs1[$count]["Residence"]; ?>" <?php echo $checked_str_r; ?> disabled="disabled"/>
							<?php echo $rs1[$count]["Residence"]; ?> 
						</td>
	                    <td class="col-first">
							<input type="radio" name="office" id="office" value="<?php echo $rs1[$count]["Office"]; ?>" <?php echo $checked_str_o; ?> disabled="disabled"/>
							<?php echo $rs1[$count]["Office"]; ?> 
						</td>
						<td class="col-first">
							<input type="radio" name="mobile" id="mobile" value="<?php echo $rs1[$count]["Mobile"]; ?>"  <?php echo $checked_str_m; ?> disabled="disabled"/>
							<?php echo $rs1[$count]["Mobile"]; ?> 
							<br />
							<input type="radio" name="mobile_sms" id="mobile_sms" value="<?php echo $rs1[$count]["Mobile"]."_sms"; ?>"  <?php echo $checked_str_sms; ?> disabled="disabled"/>
							SMS
						</td>

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
				<tr> 
				 <td colspan="12" class="paging"><b>Registered for Tele Transact Services "<input type="radio" name="dumy" id="dumy" value="dumy"  checked="checked" disabled="disabled"/>"</b></td>
         	        </tr>

			<tr> 
				 <td colspan="12" class="paging"><?php echo($paging_block);?></td>
         	        </tr>

      			</tbody>
      		</table>
        </div>
        </div> 
