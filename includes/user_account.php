<?php 
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();

	
?>

<?php
		#CustomerId AccountNo BranchName BankName BankAccountNo BankAccountTitle BranchCode 
		$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
		$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);

		$method = 'GetBankDetail';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		$rs2 = $soap_client->call_soap_method($method,$params);		
		
		//$rs2 = $soap_client->get_account_details($account_no,$customer_id);
?>

 <div class="box">
                <h4 class="white" style="margin-top: 70px;"><?php echo("Bank Detail"); ?> <!--<a href="#" class="heading-link">Bank Detail</a>--></h4>
        <div class="box-container">
                <table class="table-short">
                        <thead>
                                <tr>
										<th >Branch Name</th>
										<th >Bank Name</th>
										<th >Bank Acc No</th>
										<th >Bank Acc Title</th>
										<th >Branch Code</th>
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
						//print_r($rs2);
                        //echo count($rs2) ; exit;
//                                        echo $rs2[0]["BranchName"]; echo "sadsdsdsd"; exit;
                        while($count != count($rs2)){ ?>

                                <tr class="odd">
                                        <td class="col-first"><?php  echo $rs2[$count]["BranchName"]; ?></td>
                                        <td class="col-first"><?php  echo $rs2[$count]["BankName"]; ?> </td>
		                        <td class="col-first"><?php  echo $rs2[$count]["BankAccountNo"]; ?> </td>
                                        <td class="col-first"><?php  echo $rs2[$count]["AccountTitle"]; ?> </td>
					<td class="col-first"><?php  echo $rs2[$count]["BranchCode"]; ?> </td>
<!--                                         <td class="row-nav"><a href="customer_detail.php?customer_id=<?php //echo $tools_admin->encryptId($rs1[$count]["CustomerId"]); ?>&account_no=<?php //echo $tools_admin->encryptId($rs1[$count]["AccountNo"]); ?>" class="table-edit-link">View</a> </td> -->
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

