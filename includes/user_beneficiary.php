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
		
		$method = 'GetProfileBeneficiary';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel);
		$rs2 = $soap_client->call_soap_method($method,$params);
		//print_r($rs2); exit;
?>

 <div class="box">
                <h4 class="white" style="margin-top: 70px;"><?php echo("Bank Detail"); ?> <!--<a href="#" class="heading-link">Bank Detail</a>--></h4>
        <div class="box-container">
                <table class="table-short">
                        <thead>
                                <tr>
						<th >Name</th>
						<th >Gender</th>
						<th >CNIC</th>
						<th >PassportNo</th>
						<!-- <th >CNIC</th>
						<th >PassportNo</th>
						<th >FatherHusbandName</th>
						<th >GuardianName</th>
						<th >GuardianCNIC</th>
						<th >MaritalStatus</th>
						<th >Occupation</th>
						<th >Religion</th>
						<th >Mobile</th>
						<th >OfficeTel</th>
						<th >ResTel</th>
						<th >Email</th>
						<th >PostalCode</th>
						<th >City</th>
						<th >Country</th>
						<th >Relationship</th> -->
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
//                        echo count($rs2) ; exit;
//                                        echo $rs2[0]["BranchName"]; echo "sadsdsdsd"; exit;
                        while($count != count($rs2)){ ?>

                                <tr class="odd">
                                        <td class="col-first"><?php  echo $rs2[$count]["Name"]; ?></td>
                                        <td class="col-first"><?php  echo $rs2[$count]["Gender"]; ?> </td>
		                        		<td class="col-first"><?php  echo $rs2[$count]["CNIC"]; ?> </td>
                                        <td class="col-first"><?php  echo $rs2[$count]["PassportNo"]; ?> </td>
<!--					<td class="col-first"><?php  //echo $rs2[$count]["BranchCode"]; ?> </td>
                                         <td class="row-nav"><a href="customer_detail.php?customer_id=<?php //echo $tools_admin->encryptId($rs1[$count]["CustomerId"]); ?>&account_no=<?php //echo $tools_admin->encryptId($rs1[$count]["AccountNo"]); ?>" class="table-edit-link">View</a> </td> -->
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

