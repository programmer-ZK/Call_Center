<?php //include_once("includes/config.php"); ?>
<?php
        /*$page_name = "index";
        $page_level = "1";
        $page_group_id = "1";
        $page_title = "user_ptransactions.php";
        $page_menu_title = "Pending Transactions";*/
?>

<?php //include_once($site_root."includes/check.auth.php"); ?>
<?php
        include_once('lib/nusoap.php');
		
        include_once($site_root."classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once($site_root."classes/soap_client.php");
        $soap_client = new soap_client();
?>
<?php //include($site_root."includes/header.php"); ?>

<?php
		$account_no 				= $_REQUEST['account_no'];
		$customer_id 				= $_REQUEST['customer_id'];
		$method = 'GetTransHistoryPending';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel, 'Type1'=> 'CT'); //$caller_id
		
		$rsCT = $soap_client->call_soap_method($method,$params); 
		//print_r($rsCT); exit;
		$method = 'GetTransHistoryPending';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel, 'Type1'=> 'RT'); //$caller_id
		
		$rsRT = $soap_client->call_soap_method($method,$params); 
		
?>
<div class="box" style="">
	<h4 class="white" style="margin-top: 70px;"><?php echo "Conversion Transaction"; ?> <a href="" class="heading-link"><?php //if(empty($caller_id)) echo "No Calls"; elseif(empty($rsCT[0]["CustomerId"])) echo "UnRegister No."; else echo "Users List"; ?></a></h4>
	<div class="box-container">
	      		<table class="table-short">
      			<thead>
      				<tr>	
					<th >ID</th>
					<th >Trans. Nature</th>
					<!--<th >From Fund</th>
					<th >From Unit Type</th>
					<th >To Fund</th>
					<th >To UnitType</th>
					<th >Units</th>
					<th >Amount</th>
					<th >Percentage</th>-->
					<th >CreatedOn</th>
					<th >Status</th>
				<!--	<th >Reason</th>
					<th >From Fund Type</th>
					<th >To Fund Type</th>-->
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
                	while($count != count($rsCT)){ ?>

      				<tr class="odd">
      					<!--<td class="col-chk"><input type="checkbox" /></td>-->
      					<td class="col-first"><?php  echo $rsCT[$count]["Code"]; ?></td>
      					<td class="col-first"><?php echo $rsCT[$count]["TransactionNature"]; ?></td>
<!--					<td class="col-first"><?php //echo $rsCT[$count]["FromFund"]; ?></td>
						<td class="col-first"><?php //echo $rsCT[$count]["FromUnitType"]; ?> </td>
	                    <td class="col-first"><?php //echo $rsCT[$count]["ToFund"]; ?> </td>
						<td class="col-first"><?php //echo $rsCT[$count]["ToUnitType"]; ?> </td>
						<td class="col-first"><?php // echo $rsCT[$count]["Units"]; ?> </td>
						<td class="col-first"><?php //echo $rsCT[$count]["Amount"]; ?> </td>
						<td class="col-first"><?php //echo $rsCT[$count]["Percentage"]; ?> </td>-->
						<td class="col-first"><?php echo $rsCT[$count]["CreatedOn"]; ?> </td>
						<td class="col-first"><?php echo $rsCT[$count]["Status"]; ?> </td>
					<!--<td class="col-first"><?php //echo $rsCT[$count]["Reason"]; ?> </td>
						<td class="col-first"><?php //echo $rsCT[$count]["FromFundType"]; ?> </td>
						<td class="col-first"><?php //echo $rsCT[$count]["ToFundType"]; ?> </td>-->
      					<td class="row-nav"><a href="pending_transCT.php?customer_id=<?php echo $customer_id; ?>&account_no=<?php echo $account_no."&tt=".$rsCT[$count]["Code"]."&tid=".$rsCT[$count]["id"]."&iscancel=".$rsCT[$count]["CancelAllowed"]; ?>" class="table-edit-link">View</a> </td>
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
			</div>
			<br />
			<br />
			<br />
			<h4 class="white"><?php echo "Redemption Transaction"; ?> <a href="#" class="heading-link"><?php //if(empty($caller_id)) echo "No Calls"; elseif(empty($rsRT[0]["CustomerId"])) echo "UnRegister No."; else echo "Users List"; ?></a></h4>
	<div class="box-container">
			
			<table class="table-short">
      			<thead>
      				<tr>	
					<th >ID</th>
					<th >Fund Name</th>
					<th >Unit Type</th>
				<!--	<th >Amount</th>
					<th >Percentage</th>
					<th >ModeOfPayment</th>
					<th >BankAccountNo</th>
					<th >AccountTitle</th>
					<th >BranchName</th>
					<th >BranchCode</th>-->
					<th >Created On</th>
					<th >Bank Name</th>
					<th >Status</th>
				<!--	<th >Reason</th>
					<th >InvestmentCategory</th>-->
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
                	while($count != count($rsRT)){ ?>

      				<tr class="odd">
      					<!--<td class="col-chk"><input type="checkbox" /></td>-->
      					<td class="col-first"><?php  echo $rsRT[$count]["Code"]; ?></td>
      					<td class="col-first"><?php echo $rsRT[$count]["FundName"]; ?></td>
						<td class="col-first"><?php echo $rsRT[$count]["UnitTypeName"]; ?></td>
<!--						<td class="col-first"><?php //echo $rsRT[$count]["Amount"]; ?> </td>
	                    <td class="col-first"><?php //echo $rsRT[$count]["Percentage"]; ?> </td>
						<td class="col-first"><?php //echo $rsRT[$count]["ModeOfPayment"]; ?> </td>
						 <td class="col-first"><?php // echo $rsRT[$count]["BankAccountNo"]; ?> </td>
						<td class="col-first"><?php //echo $rsRT[$count]["AccountTitle"]; ?> </td>
						 <td class="col-first"><?php //echo $rsRT[$count]["BranchName"]; ?> </td>
						<td class="col-first"><?php //echo $rsRT[$count]["BranchCode"]; ?> </td>-->
						<td class="col-first"><?php echo $rsRT[$count]["CreatedOn"]; ?> </td>
						<td class="col-first"><?php echo $rsRT[$count]["BankName"]; ?> </td>
						<!--<td class="col-first"><?php //echo $rsRT[$count]["Status"]; ?> </td>
						<td class="col-first"><?php //echo $rsRT[$count]["Reason"]; ?> </td>
						<td class="col-first"><?php //echo $rsRT[$count]["InvestmentCategory"]; ?> </td>-->
      					<td class="row-nav"><a href="pending_transRT.php?customer_id=<?php echo $customer_id; ?>&account_no=<?php echo $account_no."&tt=".$rsRT[$count]["Code"]."&tid=".$rsRT[$count]["id"]."&iscancel=".$rsRT[$count]["CancelAllowed"]; ?>" class="table-edit-link">View</a> </td>
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
			
	
	</div>
</div> 
<?php // include($site_root."includes/footer.php"); ?>      
