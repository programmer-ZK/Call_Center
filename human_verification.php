
<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "human_verification.php";
	$page_title = "human verification";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "human_verification";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>


<?php
		include_once('lib/nusoap.php');

	    include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
		
		include_once("classes/human_verify.php");
        $human_verify = new human_verify();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function chk_nic()
{
	value = document.getElementById("nic").value;
	
	
	//alert(document.getElementById("nic_org").value);
	if(value != "")
	{
		if(document.getElementById("nic_org").value == value || document.getElementById("customerid_org").value == value || document.getElementById("gcnic_org").value == value )
		{
			//alert('OK');
			this.document.getElementById('nic_org_error_s').style.display="";
			this.document.getElementById('nic_org_error_e').style.display="none";
			this.document.getElementById('label1').style.visibility="visible";
			this.document.getElementById('label2').style.visibility="visible";
			this.document.getElementById('label3').style.visibility="visible";
			this.document.getElementById('label4').style.visibility="visible";
			this.document.getElementById('label5').style.visibility="visible";
			this.document.getElementById('label6').style.visibility="visible";
			this.document.getElementById('label7').style.visibility="visible";
			this.document.getElementById('label10').style.visibility="visible";
			this.document.getElementById('label11').style.visibility="visible";
		}
		else{
			this.document.getElementById('nic_org_error_e').style.display="";
			this.document.getElementById('nic_org_error_s').style.display="none";
			this.document.getElementById('label1').style.visibility="hidden";
			this.document.getElementById('label2').style.visibility="hidden";
			this.document.getElementById('label3').style.visibility="hidden";
			this.document.getElementById('label4').style.visibility="hidden";
			this.document.getElementById('label5').style.visibility="hidden";
			this.document.getElementById('label6').style.visibility="hidden";
			this.document.getElementById('label7').style.visibility="hidden";
			this.document.getElementById('label10').style.visibility="hidden";
			this.document.getElementById('label11').style.visibility="hidden";
		
		}
	}
	else
	{
		this.document.getElementById('nic_org_error_e').style.display="";
		this.document.getElementById('nic_org_error_s').style.display="none";
		this.document.getElementById('label1').style.visibility="hidden";
		this.document.getElementById('label2').style.visibility="hidden";
		this.document.getElementById('label3').style.visibility="hidden";
		this.document.getElementById('label4').style.visibility="hidden";
		this.document.getElementById('label5').style.visibility="hidden";
		this.document.getElementById('label6').style.visibility="hidden";
		this.document.getElementById('label7').style.visibility="hidden";
		this.document.getElementById('label10').style.visibility="hidden";
		this.document.getElementById('label11').style.visibility="hidden";
	}
}

function chk_box(id)
{

	//alert(id);
	//alert(this.document.getElementById(id).checked);
	if(this.document.getElementById(id).checked){
		this.document.getElementById('confirm'+id).style.display="";
	}else{
		this.document.getElementById('confirm'+id).style.display="none";
	}
	
	bool = 0;
	for(i = 1 ;i<= 11; i++ )
	{
		if(this.document.getElementById(i).checked){
			bool=bool+1;
		}
		else{
			
		}
	}
	
	if(bool >= 4){

		this.document.getElementById('btn_verify').style.visibility="visible";
	}
	else{
		this.document.getElementById('btn_verify').style.visibility="hidden";
	}
}
</script>
<script type="text/javascript">
function human_validate(){

		nic = this.document.getElementById(nic_org).value;
		id = this.document.getElementById(customerid_org).value;
		if(this.document.getElementById(1).checked){
			name = "Name;"
		}
		if(this.document.getElementById(2).checked){
			residence = "Residence No";
		}
		if(this.document.getElementById(3).checked){
			cnic_exp = "CNIC Exp Date";
		}
		if(this.document.getElementById(4).checked){
			father_name = "Father Name";
		}
		if(this.document.getElementById(5).checked){
			mobile_no = "Mobile No";
		}
		if(this.document.getElementById(6).checked){
			dob = "Date Of Birth";
		}
		if(this.document.getElementById(7).checked){
			address = "Address";
		}
		return false;
}
</script>


<?php
	$rst = $tools_admin->get_caller_id($_SESSION[$db_prefix.'_UserId']); 
	
	$_SESSION[$db_prefix.'_UserPinVerification'] = false;
	$_SESSION[$db_prefix.'_UserVerification'] = "no";

	$customer_id	= $_REQUEST['customer_id'];
	$account_no		= $_REQUEST['account_no'];
	$hname 			= $_REQUEST['hname'];
		
	$unique_id 			= $rst->fields["unique_id"];
	$caller_id 			= $rst->fields["caller_id"];
	

	$name 				= $_REQUEST['1'];
	$residence 			= $_REQUEST['2'];
	$cnic_exp 			= $_REQUEST['3']; 
	$father_name 	  	= $_REQUEST['4']; 
	$mobile_no 			= $_REQUEST['5'];
	$dob 				= $_REQUEST['6'];
	$address 			= $_REQUEST['7']; 
	$secret_word 		= $_REQUEST['6'];
	$mother_m_name 		= $_REQUEST['7']; 
	
if(isset($_REQUEST['verify']) || isset($_REQUEST['verify']))
{
		$human_verify->insert_human_verify($unique_id, $caller_id, $customer_id, $account_no, $name, $residence, $cnic_exp, $father_name, $mobile_no, $dob, $address, $secret_word, $mother_m_name,1,$_SESSION[$db_prefix.'_UserId']);
		;
		
		$_SESSION[$db_prefix.'_GM'] = "Verification of ['".$hname."'] is Successfull";
		$_SESSION[$db_prefix.'_UserVerification'] = "yes";
		$_SESSION[$db_prefix.'_SkipVerification'] = "no";
		//$_SESSION[$db_prefix.'_customer_id'] = $customer_id;
		//$_SESSION[$db_prefix.'_account_no'] = $account_no;
		header ("Location: customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile");
		exit;
}
?>
<?php		
		
		$method = 'GetProfile';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		$rs = $soap_client->call_soap_method($method,$params);

		
		$ID = $rs[0]["CustomerId"]; 
		$Name = $rs[0]["Name"]; 
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
		$RegistrationDate = $rs[0]["RegistrationDate"];
		$StatementName = $rs[0]["StatementName"];
		$StatementDays = $rs[0]["StatementDays"];
		$IsZakatDeducted = $rs[0]["IsZakatDeducted"];
		$IsJumboCertificate = $rs[0]["IsJumboCertificate"];
		$IsCertificate = $rs[0]["IsCertificate"];
		$IsResident = $rs[0]["IsResident"];
		$IsBonus = $rs[0]["IsBonus"];
		$IsDividend = $rs[0]["IsDividend"];
		$IsMuslim = $rs[0]["IsMuslim"];
		$SigningDetail = $rs[0]["SigningDetail"];
		$IsFlexibleReturn = $rs[0]["IsFlexibleReturn"];
		$IsAllowSMS = $rs[0]["IsAllowSMS"];
		$IsHoldMail = $rs[0]["IsHoldMail"];
		$isDuplicateNIC = $rs[0]["isDuplicateNIC"];
		$isDeath = $rs[0]["isDeath"];
		$CategoryType = $rs[0]["CategoryType"];
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
		$Gcnic= $rs[0]["Gcnic"];
		$SecretWord = $rs[0]["SecretWord"];
		$MotherMaidenName = $rs[0]["MotherMaidenName"];
		
		/************************ Contact Details ******************************************/
		 //$caller_id = '02135622755';
		//if(!empty($caller_id)){
			$method = 'GetContactDetail';
			$params = array('AccessKey' => $access_key,'CallerId' => '', 'Channel' => $channel, 'CustomerId' => $ID, 'AccountNo'=> $AccountNumber);
			$rs1 = $soap_client->call_soap_method($method,$params); 	
			//print_r($rs1); exit;
		//}
		
		/************************* End *****************************************************/
?>

        <div class="box">
        <h4 class="white">Verification</h4>
        <div class="box-container">
               
					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return human_validate(this);">
					<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
					<input type="hidden" id="account_no" name="account_no" value="<?php echo $account_no; ?>">
					<input type="hidden" id="hname" name="hname" value="<?php echo $Name; ?>">
					
                                <fieldset>
                                        <legend>Fieldset Title</legend>
										<ol>
											<li >
												<label class="field-title">
												CNIC / Customer ID <em>*</em>:</label>
												<label><input name="nic" id="nic" class="txtbox-short" value=""  onchange="" maxlength="15">
												<a id="check_nic"  class="button"  onclick="javascript:chk_nic();"><span>Verify</span></a>
												<input type="hidden" id="nic_org" name="nic_org" value="<?php echo $CNIC; ?>"  />
												<input type="hidden" id="customerid_org" name="customerid_org" value="<?php echo $ID; ?>"  />
												<input type="hidden" id="gcnic_org" name="gcnic_org" value="<?php echo $Gcnic; ?>"  />
												<span id="nic_org_error_s" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												<span id="nic_org_error_e" class="form-error-inline" title = "Un Successfull" style="display:none;"></span>
												</label>
												
												
												 
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even"> 
												<label class="field-title">	Name <em>*</em>:</label>
												<label id="label1" style="visibility:hidden"><input type="checkbox" name="1" id="1" onchange="javascript:chk_box(this.id)" value="<?php echo $Name; ?> " <?php echo (empty($Name)?"disabled='disabled'":""); ?> /><?php echo $Name; ?></label>
												<span id="confirm1" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">	Residence <em>*</em>:</label>
												<label ><table id="label2" style="visibility:hidden">
											<tr><td>
												<input type="checkbox" name="2" id="2" onchange="javascript:chk_box(this.id)"   value="<?php echo $rs1[0]["Residence"]; ?> " <?php echo (empty($rs1[0]["Residence"])?"disabled='disabled'":""); ?>>
												</td>
												<?php
												$count = 0;

												while($count != count($rs1)){ ?>
											<td>
												<?php echo $rs1[$count]["Residence"]; ?>
												&nbsp;&nbsp;,&nbsp;&nbsp;
												</td>
												<?php
												$count++;
												}
												?>
												<td>
												<span id="confirm2" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												</td>
												</tr>
												</table>
												
												</label>
												
												<span class="clearFix">&nbsp;</span>
											</li>
											
											<li class="even">
												<label  class="field-title">
												CNIC Exp Date <em>*</em>:</label>
												<label id="label3" style="visibility:hidden"><input type="checkbox" name="3" id="3" onchange="javascript:chk_box(this.id)"  value="<?php echo $CNICExpiryDate; ?> " <?php echo (empty($CNICExpiryDate)?"disabled='disabled'":""); ?> /><?php echo $CNICExpiryDate; ?></label>
												<span id="confirm3" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												 
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">
												Father Name <em>*</em>:</label>
												<label id="label4" style="visibility:hidden"><input type="checkbox" name="4" id="4"  onchange="javascript:chk_box(this.id)"  value="<?php echo $FatherName; ?> " <?php echo (empty($FatherName)?"disabled='disabled'":""); ?> /><?php echo $FatherName; ?></label>
												 <span id="confirm4" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">
												Mobile :</label>
												<label > <table id="label5" style="visibility:hidden">
												<tr><td>
												<input type="checkbox" name="5" id="5"  onchange="javascript:chk_box(this.id)" value="<?php echo $rs1[0]["Mobile"]; ?> " <?php echo (empty($rs1[0]["Mobile"])?"disabled='disabled'":""); ?> />
												</td>
												<?php
												$count = 0;

												while($count != count($rs1)){ ?>
												<td>
												
												<?php echo $rs1[$count]["Mobile"]; ?>
												&nbsp;&nbsp;,&nbsp;&nbsp;
												</td>
												<?php
												$count++;
												}
												?>
												<td>
												<span id="confirm5" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												</td>
												</tr>
												</table>
												
												</label>
												
												<span class="clearFix">&nbsp;</span>
											</li>
											<li > 
												<label class="field-title">
												DOB <em>*</em>:</label>
												<label id="label6" style="visibility:hidden"><input type="checkbox" name="6" id="6" onchange="javascript:chk_box(this.id)" value="<?php echo $DOB; ?> " <?php echo (empty($DOB)?"disabled='disabled'":""); ?> /><?php echo $DOB; ?></label>
												<span id="confirm6" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												<span class="clearFix">&nbsp;</span>
											</li>
											<!--<li class="even">
												<label class="field-title">Occupation <em>*</em>:</label>
												<label><?php //echo $Occupation; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Account Number <em>*</em>:</label>
												<label><?php //echo $AccountNumber; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li> 
											
											<li class="even">
												<label class="field-title">Contact Numbers <em>*</em>:</label>
												<label><?php //echo $ContactNumbers; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Email Addresses <em>*</em>:</label>
												<label><?php //echo $Email; ?></label>
												
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Postal Address <em>*</em>:</label>
												<label><?php //echo $PostalAddress; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">City <em>*</em>:</label>
												<label><?php //echo $CityName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Country <em>*</em>:</label>
												<label><?php //echo $CountryName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Title Code <em>*</em>:</label>
												<label><?php //echo $TitleCode; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>-->
											
											<li class="even">
												<label class="field-title">
												Address <em>*</em>:</label>
												<label id="label7" style="visibility:hidden"><input type="checkbox" name="7" id="7" onchange="javascript:chk_box(this.id)"  value="<?php echo $Address; ?> " <?php echo (empty($Address)?"disabled='disabled'":""); ?> /><?php echo $Address; ?></label>
												 <span id="confirm7" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">
												 Secret Word <em>*</em>:</label>
												<label id="label10" style="visibility:hidden"><input type="checkbox" name="10" id="10" onchange="javascript:chk_box(this.id)"  value="<?php echo $SecretWord; ?> " <?php echo (empty($SecretWord)?"disabled='disabled'":""); ?> /><?php echo $SecretWord; ?></label>
												 <span id="confirm10" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												<span class="clearFix">&nbsp;</span>
											</li>	
											<li class="even">
												<label class="field-title">
												 Mother MaidenName <em>*</em>:</label>
												<label id="label11" style="visibility:hidden"><input type="checkbox" name="11" id="11" onchange="javascript:chk_box(this.id)"  value="<?php echo $MotherMaidenName; ?> " <?php echo (empty($MotherMaidenName)?"disabled='disabled'":""); ?> /><?php echo $MotherMaidenName; ?> <?php echo $MotherMaidenName; ?></label>
												 <span id="confirm11" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												<span class="clearFix">&nbsp;</span>
											</li>		
											<li >
												<label class="field-title">
												Email <em>*</em>:</label>
												<label id="label8" ><input type="checkbox" name="8" id="8" onchange="javascript:chk_box(this.id)"  value="<?php echo $Email; ?> " <?php echo (empty($Email)?"disabled='disabled'":""); ?> /><?php echo $Email; ?></label>
												 <span id="confirm8" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												<span class="clearFix">&nbsp;</span>
											</li>											
											<li class="even">
												<label class="field-title">
												Zakat Status <em>*</em>:</label>
												<label id="label9" ><input type="checkbox" name="9" id="9" onchange="javascript:chk_box(this.id)"  value="<?php echo $IsZakatDeducted; ?> " <?php echo empty($IsZakatDeducted)?'disabled="disabled"':''; ?> /><?php echo $IsZakatDeducted; ?></label>
												 <span id="confirm9" class="form-confirm-inline" title = "Successfull" style="display:none;"></span>
												<span class="clearFix">&nbsp;</span>
											</li>	
																				
											<!--<li >
												<label class="field-title">Registration Date <em>*</em>:</label>
												<label><?php //echo $RegistrationDate; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">Statement Frequency <em>*</em>:</label>
												<label><?php //echo $StatementName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title">Education <em>*</em>:</label>
												<label><?php //echo $EducationName; ?></label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li class="even">
												<label class="field-title">SubAgentEmail <em>*</em>:</label>
												<label><?php //echo $SubAgentEmail; ?>i</label>
												<span class="clearFix">&nbsp;</span>
											</li>											-->
										</ol>
                                </fieldset>
                                <p class="align-right">
									<a id="btn_skip" class="button" href="skip_verification.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" onclick="location.href('skip_verification.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>');"><span>Skip</span></a>
									<input type="hidden" value="skip" id="skip" name="skip" />
						
									<a id="btn_verify" style="visibility:hidden" class="button" href="javascript:document.xForm.submit();" onclick="javascript:return human_validate('xForm');"><span>Verified</span></a>
									<input type="hidden" value="verify" id="verify" name="verify" />	
								</p>
                                <span class="clearFix">&nbsp;</span>
                </form>
        </div>
        </div>

<?php include($site_admin_root."includes/footer.php"); ?>

