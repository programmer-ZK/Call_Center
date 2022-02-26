<?php include_once($site_root."includes/config.php"); ?>
<?php
   		$page_name = "index";
        $page_level = "2";
        $page_group_id = "1";
        $page_title = "pending_transRT.php";
        $page_menu_title = "Pending Transactions";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	$customer_id = 	$_REQUEST['customer_id'];
	$account_no	 = 	$_REQUEST['account_no'];
	$tt			 =	$_REQUEST['tt'];
	$tid		 =	$_REQUEST['tid'];

 	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
?>
<?php include($site_root."includes/header.php"); ?>

<?php

		if(isset($_REQUEST['cancel']) || isset($_REQUEST['cancel']))
		{
			$method = 'SetTransactionCancel';
			$params = array('AccessKey' => $access_key, 'Channel' => $channel ,'AccountNo' => $account_no,'CustomerId' => $customer_id, 'TransactionId'=> $_REQUEST['cancel']); //$caller_id
			//print_r($params);
			$rs = $soap_client->call_soap_method_2($method,$params);
			//echo $rs; exit;
			if($rs == 1)
			{
				$_SESSION[$db_prefix.'_GM'] = "Cancel Transaction Successfull. ID: ['".$_REQUEST['cancel']."']";
				header ("Location: customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile");
			}
			else
			{
				$_SESSION[$db_prefix.'_RM'] = "Cancel Transaction Fail. ID: ['".$_REQUEST['cancel']."']";
				header ("Location: customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile");
			}
		}
                $method = 'GetTransactionDetail';
                $params = array('AccessKey' => $access_key, 'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id, 'Code'=> $tt); //$caller_id
	//print_r($params); exit;
		$rs = $soap_client->call_soap_method($method,$params); 
		
		$ID 				= $rs[0]["id"]; 
		$TransactionType 	= $rs[0]["TransactionType"]; 
		$FundCode 			= $rs[0]["FundName"];
		$UnitType 			= $rs[0]["UnitTypeName"];
		$Amount 			= $rs[0]["Amount"];
		$Percentage 		= $rs[0]["Percentage"];
		$ModeOfPayment	 	= $rs[0]["ModeOfPayment"];
		$BankAccountNo 		= $rs[0]["BankAccountNo"]; 
		$AccountTitle 		=  $rs[0]["AccountTitle"]; 
		$BranchName 		=  $rs[0]["BranchName"];
		$BranchCode 		=  $rs[0]["BranchCode"];			  
		$CreatedOn 			= date( 'y-m-d', strtotime($rs[0]["CreatedOn"]));
		$BankName 			= $rs[0]["BankName"];
		$Status 			= $rs[0]["Status"];
		$Reason 			= $rs[0]["Reason"];	
		$InvestmentCategory = $rs[0]["InvestmentCategory"];
			
			  
		if($ModeOfPayment == 1){
			$ModeOfPayment = "Cheque";
		}
		elseif($ModeOfPayment == "2"){
			$ModeOfPayment = "Pay order";
		}
		elseif($ModeOfPayment == "3"){
			$ModeOfPayment = "Online";
		}
		
		if($Percentage == 1){
			$RValueType = "Unit";	
		}
		elseif($Percentage == "2"){
			$LValueType = "Rs. ";
        }
		elseif($Percentage == "3"){
			$RValueType = "%";
		}
?>

        <div class="box">
        <h4 class="white" >Pending Redemption Transactions</h4>
        <div class="box-container">
               	<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms" name="xForm" id="xForm" onsubmit="">

                                <fieldset>
                                        <legend>Fieldset Title</legend>
										<ol>
											<li class="even">
												<label class="field-title">ID :</label> 
												<label><?php echo $ID; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Trans Type :</label>
												<label><?php echo $TransactionType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Fund Name :</label>
												<label><?php echo $FundCode; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Unit Type :</label>
												<label><?php echo $UnitType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Value :</label>
												<label><?php echo $LValueType . $Amount . $RValueType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Mode Of Payment :</label>
												<label><?php echo $ModeOfPayment; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Bank Account No :</label>
												<label><?php echo $BankAccountNo; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Account Title :</label>
												<label><?php echo $AccountTitle; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Branch Name :</label>
												<label><?php echo $BranchName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Branch Code :</label>
												<label><?php echo $BranchCode; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li> 
											
											<li class="even">
												<label class="field-title">Created On :</label>
												<label><?php echo $CreatedOn; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Bank Name :</label>
												<label><?php echo $BankName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Status :</label>
												<label><?php echo $Status; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Reason :</label>
												<label><?php echo $Reason; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Investment Category :</label>
												<label><?php echo $InvestmentCategory; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
																																																																							
										</ol>
                                </fieldset>
                            <p class="align-right">
									<a class="button" href="<?php echo "customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile"; ?>" onclick=""><span>Back</span></a>
									<?php 
						if($Status == "Pending")
						{
						?>
				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Cancel Transaction</span></a>
				<input type="hidden" value="<?php echo $tt; ?>" id="cancel" name="cancel" />
				<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
				<input type="hidden" id="account_no" name="account_no" value="<?php echo $account_no; ?>">
				<?php 	
						}
				?>
								</p>
                                <span class="clearFix">&nbsp;</span>
                </form>
        </div>
        </div>
<?php include($site_root."includes/footer.php"); ?> 
