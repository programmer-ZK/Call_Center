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
		
		$method = 'GetJointHolder';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel);
		$rs1 = $soap_client->call_soap_method($method,$params); 

?>

 <div class="box">
                <h4 class="white" style="margin-top: 70px;"><?php echo("Join Holder Detail"); ?> <!--<a href="#" class="heading-link">Join Holder Detail</a>--></h4>
        <div class="box-container">
      		<table class="table-short">
      			<thead>
      				<tr>
						<th >Name</th>
						<th >FHName</th>
						<th >ResTel</th>
						<th >OffTel</th>
						<th >Email</th>
						<th >NICNo</th>
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
                	while($count != count($rs1)){ ?>

      				<tr class="odd">
      					<td class="col-first"><?php  echo $rs1[$count]["Name"]; ?></td>
      					<td class="col-first"><?php echo $rs1[$count]["FHName"]; ?></td>
						<td class="col-first"><?php echo $rs1[$count]["ResTel"]; ?> </td>
	                    <td class="col-first"><?php echo $rs1[$count]["OffTel"]; ?> </td>
						<td class="col-first"><?php echo $rs1[$count]["Email"]; ?> </td>
						<td class="col-first"><?php echo $rs1[$count]["NICNo"]; ?> </td>
      				</tr>
			 <?php
                        $count++;
                }
                ?>
			<tr> 
				 <td colspan="12" class="paging"><?php echo($paging_block);?></td>
         	        </tr>

      			</tbody>
      		</table>
        </div><!-- end of div.box-container -->
        </div> <!-- end of div.box -->
