
<?php
		
		$method = 'GetFundBalanceSummary';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id,'FundCode' => $fundcode,'Type1' => $fundcode);
		$rs3 = $soap_client->call_soap_method($method,$params);
		
		$TotalInvestment  = $rs3[0]["TotalInvestment"]; 
		$TotalRedemption  = $rs3[0]["TotalRedemption"]; 
		$TotalProfitDistribution  = $rs3[0]["TotalProfitDistribution"];
		$TotalConversion  = $rs3[0]["TotalConversion"];
		$TotalHoldings  = $rs3[0]["TotalHoldings"];
?>

        <div class="box">
        <h4 class="white">Balance Summary</h4>
        <div class="box-container">
                <form action="" method="post" class="middle-forms">

                                <fieldset>
                                        <legend>Fieldset Title</legend>
										<ol>											
											<li class="even">
												<label class="field-title">Total Investment <em>*</em>:</label> 
												<label><?php echo $TotalInvestment; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">TotalRedemption <em>*</em>:</label>
												<label><?php echo $TotalRedemption; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Total Profit Distribution <em>*</em>:</label>
												<label><?php echo $TotalProfitDistribution; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Total Conversion <em>*</em>:</label>
												<label><?php echo $TotalConversion; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Total Holdings <em>*</em>:</label>
												<label><?php echo $TotalHoldings; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>																																																																												
										</ol>
                                </fieldset>
                                <span class="clearFix">&nbsp;</span>
                </form>
        </div>
        </div>
