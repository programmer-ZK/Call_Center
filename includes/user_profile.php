<?php 
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
?>

<?php
		/* N@e3M BhunD
			$rst = $tools_admin->get_caller_id($_SESSION[$db_prefix.'_UserId']); 
			$caller_id 			= $rst->fields["caller_id"];
		*/
	


		$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
		$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
		
		$method = 'GetProfile';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		$rs = $soap_client->call_soap_method($method,$params); //print_r($params); exit;
		
		$ID = $rs[0]["CustomerId"]; 
		$Name = $rs[0]["Name"]; $_SESSION[$db_prefix.'_CustomerName'] = $rs[0]["Name"];
		$Gender = $rs[0]["Gender"];
		$CNIC = $rs[0]["NICNo"];
		$CNICExpiryDate = date( 'y-m-d', strtotime($rs[0]["CNICExpiry"]));
		$FatherName = $rs[0]["FHName"];
		$MaritalStatus = $rs[0]["MaritalName"];
		$DOB = date( 'y-m-d', strtotime($rs[0]["DateOfBirth"])); 
		$Occupation =  $rs[0]["OccupationName"]; 
		$AccountNumber =  $rs[0]["AccountNumber"];
		$TitleCode =  $rs[0]["TitleCode"];			  
		$Email = $rs[0]["Email"];
		$CityName = $rs[0]["CityName"];
		$CountryName = $rs[0]["CountryName"];
		$Address = $rs[0]["Address"];			  
		$RegistrationDate = date( 'y-m-d', strtotime($rs[0]["RegistrationDate"]));
		$StatementName = $rs[0]["StatementName"];
		$StatementDays = $rs[0]["StatementDays"];
		$IsZakatDeducted = $rs[0]["IsZakatDeducted"];
		$IsJumboCertificate = $rs[0]["IsJumboCertificate"];
		$IsCertificate = $rs[0]["IsCertificate"];
		$IsResident = $rs[0]["IsResident"];
		$IsBonus = $rs[0]["IsBonus"];
		$IsDividend = $rs[0]["IsDividend"];
		$IsMuslim = $rs[0]["IsMuslim"];
		$SigningDetail = $rs[0]["SigningDetail"]; $_SESSION[$db_prefix.'_SigningDetail'] = $rs[0]["SigningDetail"];
		$IsFlexibleReturn = $rs[0]["IsFlexibleReturn"];
		$IsAllowSMS = $rs[0]["IsAllowSMS"];
		$IsHoldMail = $rs[0]["IsHoldMail"];
		$isDuplicateNIC = $rs[0]["isDuplicateNIC"];
		$isDeath = $rs[0]["isDeath"];
		$CategoryType = $rs[0]["CategoryType"];  $_SESSION[$db_prefix.'_CategoryType'] = $rs[0]["CategoryType"];
		$EducationName = $rs[0]["EducationName"];
		$NationalityName = $rs[0]["NationalityName"];
		$SubCat = $rs[0]["SubCat"];
		$CurrencyName = $rs[0]["CurrencyName"];
		$IssuePlace = $rs[0]["IssuePlace"];
		$Validity= $rs[0]["Validity"];
		$GCNICExpiry= date( 'y-m-d', strtotime($rs[0]["GCNICExpiry"]));
		$isHoldEmail= $rs[0]["isHoldEmail"];
		$isCGTExempted= $rs[0]["isCGTExempted"];
		$SubAgentName= $rs[0]["SubAgentName"];
		$SubAgentEmail= $rs[0]["SubAgentEmail"];
		$CompanyExecutive= $rs[0]["CompanyExecutive"];
		$AccountType= $rs[0]["AccountType"];
		$IsZakatDeducted= $rs[0]["IsZakatDeducted"];
		$Gcnic= $rs[0]["Gcnic"];
		$GCNICExpiry= date( 'y-m-d', strtotime($rs[0]["GCNICExpiry"]));
		$OperatingTypeCode1= $rs[0]["OperatingTypeCode1"]; $_SESSION[$db_prefix.'_OperatingTypeCode'] = $rs[0]["OperatingTypeCode"];
		
		
		$method = 'IsPinExists';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		$isPinGenerated = $soap_client->call_soap_method_2($method,$params);
		
		$_SESSION[$db_prefix.'_isPinGenerated'] = $isPinGenerated;
		
		
		$method = 'GetContactDetail';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $AccountNumber,'CustomerId' => $ID, 'CallerId'=> $caller_id );
		$rs2 = $soap_client->call_soap_method($method,$params);	
		
		//echo "Caller ID --> ".$caller_id;
		//print_r($rs2); 
		
		$tcustomer_id			= $rs2[0]["CustomerId"]; //AccountNo
		$taccount_no			= $rs2[0]["AccountNo"];
		$isregistered_restel  	= $rs2[0]["isregisteredResTel"];
		$isregistered_offtel	= $rs2[0]["isregisteredOffTel"];	
		$isregistered_mobiletrans = $rs2[0]["isregisteredMobileTrans"];
		$residence				= str_replace("-", "", $rs2[0]["Residence"]);
		$office					= str_replace("-","",$rs2[0]["Office"]);		
		$mobile					= str_replace("-","",$rs2[0]["Mobile"]);
		

		if(empty($caller_id))
		{
			$_SESSION['ValidUser'] = 0;
		}
		else
		{
			if(empty($tcustomer_id) && empty($taccount_no))
			{
				$_SESSION['ValidUser'] = 0;
			}
			else
			{
				//check if this number is registered for IVR banking
				if(($isregistered_restel=="Y" && $caller_id == $residence) || ($isregistered_offtel =="Y" && $caller_id == $office)  || ($isregistered_mobiletrans =="Y" && $caller_id == $mobile))
				{
					$_SESSION['ValidUser'] = 1;
					$_SESSION[$db_prefix.'_isEnableTransaction'] = 1;
				}
				else
				{
					$_SESSION['ValidUser'] = 1;
					$_SESSION[$db_prefix.'_isEnableTransaction'] = 0;
				}
			}
		}
		//echo $_SESSION[$db_prefix.'_isRegisteredUser']; exit;
		
		
?>

        <div class="box">
        <h4 class="white" style="margin-top: 70px;">Customer Detail</h4>
        <div class="box-container">
                <form action="" method="post" class="middle-forms">
                                <fieldset>
                                        <legend>Fieldset Title</legend>
										<ol>
											<li >
												<label class="field-title">Pin Generated :</label>
												<label><?php //echo empty($isPinGenerated)?"No":"Yes"; 
												if(empty($isPinGenerated))
														{
															echo "NO";
														}
														else{
															echo "YES";
														}
												
												?></label> &nbsp;
<!--												<?php
												if(empty($isPinGenerated)){?>
												<a href="pin_generation.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" class="table-edit-link">Go To Pin Generation</a>
												<?php } ?>-->
												<span class="clearFix">&nbsp;</span>
						
											</li>										
											<li class="even">
												<label class="field-title">ID :</label> 
												<label><?php echo $ID; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Name :</label>
												<label><?php echo $Name; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Gender :</label>
												<label><?php echo $Gender; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">CNIC :</label>
												<label><?php echo $CNIC; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">CNIC Expiry Date :</label>
												<label><?php echo $CNICExpiryDate; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Father Name :</label>
												<label><?php echo $FatherName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Marital Status :</label>
												<label><?php echo $MaritalStatus; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">DOB :</label>
												<label><?php echo $DOB; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Occupation :</label>
												<label><?php echo $Occupation; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Account Number :</label>
												<label><?php echo $AccountNumber; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li> 
											
<!--										<li class="even">
												<label class="field-title">Contact Numbers :</label>
												<label><?php echo $ContactNumbers; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>-->
											<li class="even">
												<label class="field-title">Email Addresses :</label>
												<label><?php echo $Email; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
<!--											<li class="even">
												<label class="field-title">Postal Address :</label>
												<label><?php echo $PostalAddress; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>-->
											<li >
												<label class="field-title">City :</label>
												<label><?php echo $CityName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Country :</label>
												<label><?php echo $CountryName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Title Code :</label>
												<label><?php echo $TitleCode; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											
											<li class="even">
												<label class="field-title">Address :</label>
												<label><?php echo $Address; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Registration Date :</label>
												<label><?php echo $RegistrationDate; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Statement Frequency :</label>
												<label><?php echo $StatementName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">SubAgentName :</label>
												<label><?php echo $SubAgentName; ?>i</label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Hold SMS :</label>
												<label><?php //echo empty($IsAllowSMS)?"Yes":"No";
												if($IsAllowSMS == "false")
														{
															echo "NO";
														}
														else{
															echo "YES";
														}
												 ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Hold Email :</label>
												<label><?php //echo empty($isHoldEmail)?"Yes":"No"; 
												if($isHoldEmail == "false")
														{
															echo "NO";
														}
														else{
															echo "YES";
														}
												
												?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Hold Physical :</label>
												<label><?php //echo empty($IsHoldMail)?"Yes":"No";
												if($IsHoldMail == "false")
														{
															echo "NO";
														}
														else{
															echo "YES";
														}
												
												 ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Zakat Status :</label>
												<label><?php //echo empty($IsZakatDeducted)?"Yes":"No"; 
												if($IsZakatDeducted == "false")
												{
													echo "NO";
												}
												else{
													echo "YES";
												}
												?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Guardian CNIC :</label>
												<label><?php echo $Gcnic; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Guardian CNIC Exp :</label>
												<label><?php echo $GCNICExpiry; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li><li >
												<label class="field-title">Operating Type:</label>
												<label><?php echo $OperatingTypeCode1; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>				
											</ol>
                                </fieldset>
                           <!-- <p class="align-right">
									<input type="image" src="images/bt-send-form.gif" />
								</p>-->
                                <span class="clearFix">&nbsp;</span>
                </form>
        </div>
        </div>
