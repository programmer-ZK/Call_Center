<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "index";
        $page_level = "2";
        $page_group_id = "1";
        $page_title = "pending_transCT.php";
        $page_menu_title = "Pending Transactions";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	$customer_id = $_REQUEST['customer_id'];
	$account_no	 = $_REQUEST['account_no'];
	$tt		=$_REQUEST['tt'];
	$tid		=$_REQUEST['tid'];
	$iscancel  =$_REQUEST['iscancel'];
 	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
	$cancelStyle = "display:none";
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
		$params = array('AccessKey' => $access_key, 'Channel' => $channel ,'AccountNo' => $account_no,'CustomerId' => $customer_id, 'Code'=> $tt); //$caller_id
		
		$rs = $soap_client->call_soap_method($method,$params); 
		
		$ID				 	= $rs[0]["id"]; 
		$TransType 			= $rs[0]["TransType"]; 
		$TransactionNature 	= $rs[0]["TransactionNature"];
		$FromFund 			= $rs[0]["FromFundName"];
		$FromUnitType 		= $rs[0]["FromUnitTypeName"];
		$ToFund 			= $rs[0]["ToFundName"];
		$ToUnitType 		= $rs[0]["ToUnitTypeName"];
		$Units 				= $rs[0]["Units"]; 
		$Amount 			=  $rs[0]["Amount"]; 
		$Percentage 		=  $rs[0]["Percentage"];
		$CreatedOn 			=  date( 'y-m-d', strtotime($rs[0]["CreatedOn"]));			  
		$Status 			= $rs[0]["Status"];
		$Reason 			= $rs[0]["Reason"];
		$FromFundType 		= $rs[0]["FromFundType"];
		$ToFundType			= $rs[0]["ToFundType"];			  
	

		if($TransactionNature == 1)
		{
			$TransactionNature = "Fund To Fund";	
		}
		elseif($TransactionNature == "2")
                {
			$TransactionNature = "Fund To Plan";
                }
		elseif($TransactionNature == "3")
                {
			$TransactionNature = "Plan To Plan";
                }
		elseif($TransactionNature == "4")
                {
			$TransactionNature = "Plan To Fund";
                }
		//echo $Percentage; exit;
		if($Percentage == 1){
			$RValueType = "&nbsp; Units";	
		}
		elseif($Percentage == "2"){
			$LValueType = "Rs. &nbsp; ";
        }
		elseif($Percentage == "3"){
			$RValueType = "&nbsp; %";
		}

				
?>

        <div class="box">
        <h4 class="white" >Pending Conversion Transactions</h4>
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
												<label><?php echo $TransType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Transaction Nature :</label>
												<label><?php echo $TransactionNature; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">From Fund :</label>
												<label><?php echo $FromFund; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">From  UnitType :</label>
												<label><?php echo $FromUnitType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">To Fund :</label>
												<label><?php echo $ToFund; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">To Unit Type :</label>
												<label><?php echo $ToUnitType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
<!--										<li >
												<label class="field-title">Units :</label>
												<label><?php echo $Units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>-->
											<li >
												<label class="field-title">Value :</label>
												<label><?php echo $LValueType . $Amount . $RValueType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
<!--										<li >
												<label class="field-title">Percentage :</label>
												<label><?php echo $Percentage; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li> -->
											
											<li class="even">
												<label class="field-title">CreatedOn :</label>
												<label><?php echo $CreatedOn; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Status :</label>
												<label><?php echo $Status; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Reason :</label>
												<label><?php echo $Reason; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<!--<li >
												<label class="field-title">From Fund Type :</label>
												<label><?php echo $FromFundType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">To Fund Type :</label>
												<label><?php echo $ToFundType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>-->
																																																																							
										</ol>
                                </fieldset>
                            <p class="align-right">
				<a class="button" href="<?php echo "customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile"; ?>" onclick=""><span>Back</span></a>
				<?php 
						if($iscancel == "1")
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
