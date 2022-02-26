<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "sms_service_request.php";
	$page_title = "SMS Service Request";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "SMS Service Request";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	$customer_id = $tools_admin->decryptId($_REQUEST['customer_id']);
	$account_no	 = $tools_admin->decryptId($_REQUEST['account_no']);
	
	include_once("classes/registration.php");
	$registration = new registration();
	
	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
?>

<?php include($site_root."includes/header.php"); ?>

<?php
		
		$method = 'GetContactDetail';
		$params = array('AccessKey' => $access_key,'CallerId' => $caller_id,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		
		$rs1 = $soap_client->call_soap_method($method,$params);
?>

<?php
		$mobile_error = "display:none;";
		
		if(isset($_REQUEST['update']) || isset($_REQUEST['update'])){

			$mobile		 	= $_REQUEST['mobile'];
			/*$is_mobile	= empty($_REQUEST['mobile'])?0:1;*/
			$is_mobile		= $_REQUEST['IsMobileSmsRegister'];			

			$method = 'SetContactRegistration';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Residence' => '','Office' => '','Mobile' => $mobile,'IsResidenceRegister' => '','IsOfficeRegister' => '','IsMobileTransRegister' => '','IsMobileSmsRegister' => $is_mobile, 'CallerId' => $caller_id, 'OperatingType' => $_SESSION[$db_prefix.'_OperatingTypeCode'],'CategoryType' => $_SESSION[$db_prefix.'_CategoryType'],'SigningDetail' => $_SESSION[$db_prefix.'_SigningDetail'], 'CallLogId' => $unique_id);
			
			
			$trans_id = $soap_client->call_soap_method_2($method,$params);
			
			$registration->set_sms_registration($unique_id, $caller_id,$account_no, $customer_id, $mobile, $is_mobile, $_SESSION[$db_prefix.'_UserId'], 1, $trans_id);
			
			$_SESSION[$db_prefix.'_GM'] = "SMS service registration successfully. Having Transaction ID ['".$trans_id."']";
			header ("Location: customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile");
			exit();			
		}		
		
		
		$method = 'GetContactDetail';
		$params = array('AccessKey' => $access_key,'CallerId' => $caller_id,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		
		$rs1 = $soap_client->call_soap_method($method,$params);
	
	    $count = 0;
		while($count != count($rs1)){
			/*
			if($rs1[$count]["isregisteredResTel"] == "Y"){
				$checked_str ="checked=\"checked\"";		
			}
			else{
				$checked_str ="";					
			}
			$mobile_html .= '<input type="checkbox" name="mobile" id="mobile" value="'.$rs1[$count]["Mobile"].'"'.$checked_str.' /> '.$rs1[$count]["Mobile"].'<br />';*/
			if(!empty($rs1[$count]["Mobile"]))
			{
			$reg_status = $rs1[$count]["isregisteredMobileTrans"]=='Y'?'Registered':'Unregistered';
			$mobile_html .= $rs1[$count]["Mobile"].'&nbsp; <input type="hidden" id="mobile" name="mobile" value="'.$rs1[$count]["Mobile"].'" /><select name="IsMobileSmsRegister" id="IsMobileSmsRegister"><option value="">No Change</option><option value="Register">Register</option><option value="Unregister">Unregister</option></select> &nbsp; ('.$reg_status.')'.'<br />';
			}
			$count++;
		}

				
?>
<div class="box">
        	<h4 class="white"><?php echo($page_title); ?> <!--<a href="#" class="heading-link">Registration</a>--></h4>
        	<div class="box-container">   
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return form_validate(this);">
					<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" />
					<input type="hidden" id="account_no" name="account_no" value="<?php echo $account_no; ?>" />
					<fieldset>
						<legend>Fieldset Title</legend>
						<ol>
							<li >
								<label class="field-title">Customer ID <em>*</em>:</label>
								<label>
									<?php echo $customer_id;?>
								</label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li class="even">
								<label class="field-title">Account No <em>*</em>:</label>
								<label>
									<?php echo $account_no;?>
								</label>
								<span class="clearFix">&nbsp;</span>
							</li>						
							<li >
								<label class="field-title">Mobile <em>*</em>:</label>
								<label>
									<?php echo $mobile_html;?>
									<span id="remarks_error" class="form-error-inline" style="<?php echo($mobile_error); ?>">Insert Mobile</span>
								</label>
								<span class="clearFix">&nbsp;</span>
							</li>														
						</ol>
					</fieldset>
					<p class="align-right">
						<a id="btn_verify" class="button" href="javascript:document.xForm.submit();" onclick="javascript:document.xForm.submit();"><span>Submit</span></a>
						<a class="button" href="<?php echo "customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile"; ?>" onclick=""><span>Back</span></a>
						<input type="hidden" value="update" id="update" name="update" />	
					</p>
					<span class="clearFix">&nbsp;</span>
				</form>
			</div>
        </div>
		<?php include($site_root."includes/footer.php"); ?> 
