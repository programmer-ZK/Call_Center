<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "ivr_service_request.php";
	$page_title = "IVR Service Request";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "IVR Service Request";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	$customer_id = $tools_admin->decryptId($_REQUEST['customer_id']);
	$account_no	 = $tools_admin->decryptId($_REQUEST['account_no']);
	
	//$rst = $tools_admin->get_caller_id($_SESSION[$db_prefix.'_UserId']); 
	//$caller_id 			= $rst->fields["caller_id"];
	
	include_once("classes/registration.php");
	$registration = new registration();
	
	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
?>

<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function check(button) {
/*	alert(button.checked);
	if (button.checked == true){
		button.checked=false;
	}
	else{
		button.checked=true;
	}
*/
}
</script>
<?php
		//echo $caller_id; exit;
		$residence_error = "display:none;";
		$office_error = "display:none;";
		$mobile_error = "display:none;";
		
		if(isset($_REQUEST['update']) || isset($_REQUEST['update']))
		{
			$residence 		= $_REQUEST['residence'];
			$office		 	= $_REQUEST['office'];
			$mobile		 	= $_REQUEST['mobile'];
			
			/*
			$is_residence 	= empty($_REQUEST['residence'])?'no':'yes';
			$is_office		= empty($_REQUEST['office'])?'no':'yes';
			$is_mobile		= empty($_REQUEST['mobile'])?'no':'yes';
			*/
			
			$is_residence 	= $_REQUEST['isregisteredResTel'];
			$is_office		= $_REQUEST['isregisteredOffTel'];
			$is_mobile		= $_REQUEST['isregisteredMobileTrans'];
						


			$method = 'SetContactRegistration';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Residence' => $residence,'Office' => $office,'Mobile' => $mobile,'IsResidenceRegister' => $is_residence,'IsOfficeRegister' => $is_office,'IsMobileTransRegister' => $is_mobile,'IsMobileSmsRegister' => '', 'CallerId' => $caller_id, 'OperatingType' => $_SESSION[$db_prefix.'_OperatingTypeCode'],'CategoryType' => $_SESSION[$db_prefix.'_CategoryType'],'SigningDetail' => $_SESSION[$db_prefix.'_SigningDetail'], 'CallLogId' => $unique_id);
			//print_r($params);exit;
			
			$trans_id = $soap_client->call_soap_method_2($method,$params);
			
			$registration->set_ivr_registration($unique_id, $caller_id,$account_no, $customer_id, $residence, $is_residence, $office, $is_office, $mobile, $is_mobile, $_SESSION[$db_prefix.'_UserId'], '1', $trans_id);
			
			$_SESSION[$db_prefix.'_GM'] = "IVR service registration successfully. Having Transaction ID ['".$trans_id."']";
			header ("Location: customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile");
			exit();
		}
		
		//$caller_id = '02348876609';
		$method = 'GetContactDetail';
		$params = array('AccessKey' => $access_key,'CallerId' => $caller_id,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		
		$rs1 = $soap_client->call_soap_method($method,$params);
	
	    $count = 0;
		
		
		while($count != count($rs1)){
			/*if($rs1[$count]["isregisteredResTel"] == "Y"){
				$checked_str ="checked=\"checked\"";		
			}
			else{
				$checked_str ="";					
			}*/
			if(!empty($rs1[$count]["Residence"]))
			{
			$reg_status = $rs1[$count]["isregisteredResTel"]=='Y'?'Registered':'Unregistered';
			$residence_html .= $rs1[$count]["Residence"].'&nbsp;<input type="hidden" id="residence" name="residence" value="'.$rs1[$count]["Residence"].'" /> <select name="isregisteredResTel" id="isregisteredResTel"><option value="">No Change</option><option value="Register">Register</option><option value="Unregister">Unregister</option></select> &nbsp; ('.$reg_status.')'.'<br />';
			}
			/*if($rs1[$count]["isregisteredOffTel"] == "Y"){
				$checked_str ="checked=\"checked\"";		
			}
			else{
				$checked_str ="";					
			}*/	
			if(!empty($rs1[$count]["Office"]))
			{			
			$reg_status = $rs1[$count]["isregisteredOffTel"]=='Y'?'Registered':'Unregistered';	
			$office_html .= $rs1[$count]["Office"].'&nbsp; <input type="hidden" id="office" name="office" value="'.$rs1[$count]["Office"].'" /><select name="isregisteredOffTel" id="isregisteredOffTel"><option value="">No Change</option><option value="Register">Register</option><option value="Unregister">Unregister</option></select> &nbsp; ('.$reg_status.')'.'<br />';
			}
			/*if($rs1[$count]["isregisteredMobileTrans"] == "Y"){
				$checked_str ="checked=\"checked\"";		
			}
			else{
				$checked_str ="";					
			}*/
			if(!empty($rs1[$count]["Mobile"]))
			{			
			$reg_status = $rs1[$count]["isregisteredMobileTrans"]=='Y'?'Registered':'Unregistered';
			$mobile_html .= $rs1[$count]["Mobile"].'&nbsp; <input type="hidden" id="mobile" name="mobile" value="'.$rs1[$count]["Mobile"].'" /><select name="isregisteredMobileTrans" id="isregisteredMobileTrans"><option value="">No Change</option><option value="Register">Register</option><option value="Unregister">Unregister</option></select> &nbsp; ('.$reg_status.')'.'<br />';
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
								<label class="field-title">Residence <em>*</em>:</label>
								<label>
									<?php echo $residence_html;?>
									<span id="remarks_error" class="form-error-inline" style="<?php echo($residence_error); ?>">Insert Residence</span>
								</label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li class="even">
								<label class="field-title">Office <em>*</em>:</label>
								<label>
									<?php echo $office_html;?>
									<span id="remarks_error" class="form-error-inline" style="<?php echo($office_error); ?>">Insert Office</span>
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
