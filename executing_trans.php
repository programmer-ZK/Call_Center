<?php include_once($site_root."includes/config.php"); ?>
<?php
       $page_name = "index";
        $page_level = "2";
        $page_group_id = "1";
        $page_title = "executing_trans.php";
        $page_menu_title = "Executed Transactions";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	$customer_id = $_REQUEST['customer_id'];
	$account_no	 = $_REQUEST['account_no'];

 	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
?>
<?php include($site_root."includes/header.php"); ?>
<?php


		$method = 'GetExecutedTransactionDetail';
		$params = array('AccessKey' => $access_key,'TransactionNo' => $_REQUEST['tid'],'TransactionType' => $_REQUEST['tt'],'Channel' => $channel); //$caller_id
		$rs = $soap_client->call_soap_method($method,$params); 
		
		$ID 				= $rs[0]["RecNo"]; 
		$FundCode 			= $rs[0]["FundCode"]; 
		$TransactionNo 		= $rs[0]["TransactionNo"];
		$TransactionType 	= $rs[0]["TransactionType"];
		$Flag 				= $rs[0]["Flag"];
		$TransactionDate 	= $rs[0]["TransactionDate"];
		$UnitTypeCode 		= $rs[0]["UnitTypeCode"];
		$SubAgentCode 		= $rs[0]["SubAgentCode"]; 
		$Units 				= $rs[0]["Units"]; 
		$NetUnits 			=  $rs[0]["NetUnits"];
		$Nav 				=  $rs[0]["Nav"];			  
		$NavLoad 			= $rs[0]["NavLoad"];
		$Amount 			= $rs[0]["Amount"];
		$Charges 			= $rs[0]["Charges"];
		$NetAmount 			= $rs[0]["NetAmount"];		
		$Status 			= $rs[0]["Status"];
		$ExecutionDate 		= $rs[0]["ExecutionDate"];
		$PlanCode 			= $rs[0]["PlanCode"];	
		$ValueDate 			= $rs[0]["ValueDate"];
		$ZakatAmount 		= $rs[0]["ZakatAmount"];
		$CGTPercentage 		= $rs[0]["CGTPercentage"];	
		$CGTAmount 			= $rs[0]["CGTAmount"];	  
		
		
?>

        <div class="box">
        <h4 class="white" >Executing Transaction Details</h4>
        <div class="box-container">
                <form action="" method="post" class="middle-forms">

                                <fieldset>
                                        <legend>Fieldset Title</legend>
										<ol>			
											<li class="even">
												<label class="field-title">ID <em>*</em>:</label> 
												<label><?php echo $ID; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">FundCode <em>*</em>:</label>
												<label><?php echo $FundCode; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">TransactionNo <em>*</em>:</label>
												<label><?php echo $TransactionNo; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">TransactionType <em>*</em>:</label>
												<label><?php echo $TransactionType; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Flag <em>*</em>:</label>
												<label><?php echo $Flag; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">TransactionDate <em>*</em>:</label>
												<label><?php echo $TransactionDate; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">UnitTypeCode <em>*</em>:</label>
												<label><?php echo $UnitTypeCode; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">SubAgentCode <em>*</em>:</label>
												<label><?php echo $SubAgentCode; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Units <em>*</em>:</label>
												<label><?php echo $Units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">NetUnits <em>*</em>:</label>
												<label><?php echo $NetUnits; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li> 
											
											<li class="even">
												<label class="field-title">Nav <em>*</em>:</label>
												<label><?php echo $Nav; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">NavLoad <em>*</em>:</label>
												<label><?php echo $NavLoad; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Amount <em>*</em>:</label>
												<label><?php echo $Amount; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Charges <em>*</em>:</label>
												<label><?php echo $Charges; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">NetAmount <em>*</em>:</label>
												<label><?php echo $NetAmount; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
												<li >
												<label class="field-title">Status <em>*</em>:</label>
												<label><?php echo $Status; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">ExecutionDate <em>*</em>:</label>
												<label><?php echo $ExecutionDate; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">PlanCode <em>*</em>:</label>
												<label><?php echo $PlanCode; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">ValueDate <em>*</em>:</label>
												<label><?php echo $ValueDate; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
												<li >
												<label class="field-title">ZakatAmount <em>*</em>:</label>
												<label><?php echo $ZakatAmount; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">CGTPercentage <em>*</em>:</label>
												<label><?php echo $CGTPercentage; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">CGTAmount <em>*</em>:</label>
												<label><?php echo $CGTAmount; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											
																																																																							
										</ol>
                                </fieldset>
                           <p class="align-right">
									<a class="button" href="<?php echo "customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=user_etransaction"; ?>" onclick=""><span>Back</span></a>
								</p>
                                <span class="clearFix">&nbsp;</span>
                </form>
        </div>
        </div>
		<?php include($site_root."includes/footer.php"); ?> 