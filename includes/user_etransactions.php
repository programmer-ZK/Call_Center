<?php //include_once("includes/config.php"); ?>
<?php
       /* $page_name = "index";
        $page_level = "1";
        $page_group_id = "1";
        $page_title = "user_etransactions.php";
        $page_menu_title = "Executed Transactions";*/
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

		$method = 'GetTransHistoryExecuting';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel, 'NoOfTransaction' => '5'); //$caller_id
		$rsET = $soap_client->call_soap_method($method,$params); 
?>
<div class="box">
	<h4 class="white" style="margin-top: 70px;"><?php echo "Executed Transactions"; ?> </h4>
	<div class="box-container">
	      		<table class="table-short">
      			<thead>
      				<tr>	
					<th >RecNo</th>
					<th >Fund Code</th>
					<!--<th >Transaction No</th>-->
					<th >Transaction Type</th>
					<th >Flag</th>
					<th >Transaction Date</th>
					<th >Action</th>
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
                	while($count != count($rsET)){ ?>

      				<tr class="odd">
      					<!--<td class="col-chk"><input type="checkbox" /></td>-->
      					<td class="col-first"><?php  echo $rsET[$count]["RecNo"]; ?></td>
      					<td class="col-first"><?php echo $rsET[$count]["FundCode"]; ?></td>
						<!--<td class="col-first"><?php // echo $rsET[$count]["TransactionNo"]; ?></td>-->
						<td class="col-first"><?php echo $rsET[$count]["TransactionType"]; ?> </td>
	                    <td class="col-first"><?php echo $rsET[$count]["Flag"]; ?> </td>
						<td class="col-first"><?php echo $rsET[$count]["TransactionDate"]; ?> </td>
      					<td class="row-nav"><a href="executing_trans.php?customer_id=<?php echo $customer_id; ?>&account_no=<?php echo $account_no."&tt=".$rsET[$count]["TransactionType"]."&tid=".$rsET[$count]["TransactionNo"]; ?>" class="table-edit-link">View</a> </td>
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
