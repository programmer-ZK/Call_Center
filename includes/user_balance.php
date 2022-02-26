<?php 
        include_once("lib/nusoap.php");

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
?>
<script language="javascript1.2" type="text/javascript">
function open_window(){
	var rnd = Math.random();
	var value = '001';
    var url="window_view.php?page=user_fund_balance_summary&param_1=fund&param_2="+value;
	newwindow=window.open(url,'name','height=500,width=300');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
<?php
		
		$customer_id	= $_REQUEST['customer_id'];
		$account_no		= $_REQUEST['account_no'];
		
		$method = 'GetBalanceDetail';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel,'Type1' => 'Fund','AvailableHolding'=> '', 'TransactionType'=>'');
		$rs2 = $soap_client->call_soap_method($method,$params); 


?>

 <div class="box">
                <h4 class="white" style="margin-top: 70px;"><?php echo("User Balance | Funds"); ?> </h4>
        <div class="box-container">
                <table class="table-short">
                        <thead>
						<tr>
							
							<th>Fund Name</th>
							<th>Available Holding</th>
							<th>Total Units</th>
							<th>NAV</th>
							<th>Investment Amount</th>
							<th>Statement</th>
						</tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tbody>
                        <?php
                        $count = 0;
                        while($count != count($rs2)){ ?>
                                <tr class="odd">
									
									<td class="col-first"><?php  echo $rs2[$count]["FundName"]; ?> </td>
									<td class="col-first"><?php  echo round($rs2[$count]["AvailableHolding"],4); ?> </td>
									<td class="col-first"><?php  echo round($rs2[$count]["TotalUnits"],4); ?> </td>
									<td class="col-first"><?php  echo round($rs2[$count]["Nav"],4); ?> </td>
									<td class="col-first"><?php  echo round($rs2[$count]["InvestmentAmount"],4); ?> </td>
									<td class="col-first"><a href="#" onClick="javascript:window.open('window_view.php?page=get_fund_balance_summary&param_1=fund&customer_id=<?php echo $customer_id;?>&account_no=<?php echo $account_no;?>&param_2=<?php echo $rs2[$count]["FundCode"];?>','','location=0,status=0,scrollbars=1,width=450,height=600');">View</a> </td>
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
		
		 
<?php

		$customer_id	= $_REQUEST['customer_id'];
		$account_no	= $_REQUEST['account_no'];

		
		$method = 'GetBalanceDetail';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel,'Type1' => 'Plan','AvailableHolding'=> '', 'TransactionType'=>'');
		$rs2 = $soap_client->call_soap_method($method,$params); 
?>

 <div class="box">
                <h4 class="white"><?php echo("User Balance | Plans"); ?> </h4>
        <div class="box-container">
                <table class="table-short">
                        <thead>
						<tr>
							
							<th>Plan Name</th>
							<th>Available Holding</th>
						
							<th>Total Units</th>
							<th>NAV</th>
							<th>Investment Amount</th>
							<th></th>
						</tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tbody>
                        <?php
                        $count = 0;
                        while($count != count($rs2)){ ?>
                                <tr class="odd">
									
									<td class="col-first"><?php  echo $rs2[$count]["FundName"]; ?> </td>
								<td class="col-first"><?php  echo round($rs2[$count]["AvailableHolding"],4); ?> </td>

									<td class="col-first"><?php  echo round($rs2[$count]["TotalUnits"],4); ?> </td>
									<td class="col-first"><?php  echo round($rs2[$count]["Nav"],4); ?> </td>
									<td class="col-first"><?php  echo round($rs2[$count]["InvestmentAmount"],4); ?> </td>
									<td class="col-first"><a href="#" onClick="javascript:window.open('window_view.php?page=get_fund_balance_summary&param_1=plan&customer_id=<?php echo $customer_id;?>&account_no=<?php echo $account_no;?>&param_2=<?php echo $rs2[$count]["PlanCode"];?>','','location=0,status=0,scrollbars=1,width=450,height=600');">View</a> </td>
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

<?php
		
		
		$method = 'GetBalanceSummary';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		$rs3 = $soap_client->call_soap_method($method,$params); //print_r($rs3); exit;
		
		$TotalInvestment   					= //number_format($rs3[0]["Column1"];, 4); //
		round($rs3[0]["Column1"],4); 
		$TotalInvestment_units	 	 		= $rs3[0]["TotalUnits"];
		
		$TotalRedemption   					= //number_format($rs3[1]["Column1"];, 4); //
		round($rs3[1]["Column1"],4); 
		$TotalRedemption_units 		 		= $rs3[1]["TotalUnits"];
		 
		$TotalProfitDistribution   			= //number_format($rs3[2]["Column1"];, 4); //
		round($rs3[2]["Column1"],4); 
		$TotalProfitDistribution_units  	= $rs3[2]["TotalUnits"];
		
		$TotalConversionIn  				= //number_format($rs3[3]["Column1"];, 4); //
		round($rs3[3]["Column1"],4);
		$TotalConversionIn_units  			= $rs3[3]["TotalUnits"];
		
		$TotalConversionOut   				=// number_format($rs3[4]["Column1"];, 4); //
		round($rs3[4]["Column1"],4);
		$TotalConversionOut_units  			= $rs3[4]["TotalUnits"];
		
		$TotalTransferIn 					= //number_format($rs3[5]["Column1"];, 4); //
		round($rs3[5]["Column1"],4);
		$TTotalTransferIn_units 	 		= $rs3[5]["TotalUnits"];
		
		$TotalTransferOut   				= //number_format($rs3[6]["Column1"];, 4); //
		round($rs3[6]["Column1"],4);
		$TotalTransferOut_units  			= $rs3[6]["TotalUnits"];
		
		$TotalHoldings    					= //number_format($rs3[7]["Column1"];, 4); //
		round($rs3[7]["Column1"],4);
		$TotalHoldings_units  				= $rs3[7]["TotalUnits"];
?>

        <div class="box">
        <h4 class="white">Balance Summary</h4>
        <div class="box-container">
                <form action="" method="post" class="middle-forms">

                                <fieldset>
                                        <legend>Fieldset Title</legend>
										<ol>											
											<li class="even">
												<label class="field-title">Total Investment (Rs.) :</label> 
												<label><?php echo $TotalInvestment; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Total Invt. Units :</label> 
												<label><?php echo $TotalInvestment_units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Total Redemption (Rs.) :</label>
												<label><?php echo $TotalRedemption; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Total Red. Units :</label>
												<label><?php echo $TotalRedemption_units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Total Prof. Dist(Rs.) :</label>
												<label><?php echo $TotalProfitDistribution; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Total Prof. Dist. Units:</label>
												<label><?php echo $TotalProfitDistribution_units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Total Conversion In (Rs.) :</label>
												<label><?php echo $TotalConversionIn; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Total Conv. In Units :</label>
												<label><?php echo $TotalConversionIn_units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Total Conv. Out (Rs.):</label>
												<label><?php echo $TotalConversionOut; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>	
											<li class="even">
												<label class="field-title">Total Conv. Out Units:</label>
												<label><?php echo $TotalConversionOut_units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>	
											
											<li class="even">
												<label class="field-title">Total Transfer In (Rs.) :</label>
												<label><?php echo $TotalTransferIn; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Total Transfer In Units:</label>
												<label><?php echo $TotalTransferIn_units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Total Transfer Out (Rs.) :</label>
												<label><?php echo $TotalTransferOut; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Total Transfer Out Units :</label>
												<label><?php echo $TotalTransferOut_units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Total Holdings (Rs.):</label>
												<label><?php echo $TotalHoldings; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>	
											<li class="even">
												<label class="field-title">Total Holdings Units:</label>
												<label><?php echo $TotalHoldings_units; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>																																																																				
										</ol>
                                </fieldset>
                              
                                <span class="clearFix">&nbsp;</span>
                </form>
        </div>
        </div>