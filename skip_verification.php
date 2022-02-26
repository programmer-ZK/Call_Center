
<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "skip_verification";
	$page_title = "skip_verification";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "skip_verification";
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
function form_validate(){

	var reason 	= this.document.getElementById('reason');
	var remarks	= this.document.getElementById('remarks');

	var flag = true;
	var err_msg = '';
	
	if(reason.value == ''){
		err_msg+= 'Missing Reason\n';
		this.document.getElementById('reason_error').style.display="";
	}
	if(remarks.value == ''){
		err_msg+= 'Missing Remarks\n';
		this.document.getElementById('remarks_error').style.display="";
	}
	if(err_msg == '' && IsEmpty(err_msg)){
		return true;
	}
	else{
		return false;
	}
}
</script>


<?php
	
	$customer_id	= $_REQUEST['customer_id'];
	$account_no		= $_REQUEST['account_no'];
	$unique_id 		= $_REQUEST["unique_id"];
	$caller_id 		= $_REQUEST["caller_id"];
	$reason 		= $_REQUEST['reason'];
	$remarks 		= $_REQUEST['remarks'];
	
	$reason_error = "display:none;";
	$remarks_error = "display:none;";
	
if(isset($_REQUEST['skip']) || isset($_REQUEST['skip'])){
        $flag = true;
         if($_REQUEST['reason'] == '-1'){
			$reason_error = "display:inline;";
			$flag = false;
         }
		 if($_REQUEST['remarks'] == ''){
			$remarks_error = "display:inline;";
			$flag = false;
         }
		 if($flag == true)
         {
		 	$human_verify->skip_human_verify($unique_id, $caller_id, $customer_id, $account_no, $reason, $remarks, $_SESSION[$db_prefix.'_UserId']);
			$_SESSION[$db_prefix.'_GM'] = "Skip Verification Authenticated Successfully";
			$_SESSION[$db_prefix.'_UserVerification'] = "yes";
			$_SESSION[$db_prefix.'_SkipVerification'] = "yes";
			header ("Location: customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile");
			exit;
		}
}
?>
        <div class="box">
        	<h4 class="white">Skip Verification</h4>
        	<div class="box-container">   
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return form_validate(this);">
					<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" />
					<input type="hidden" id="account_no" name="account_no" value="<?php echo $account_no; ?>" />
					<fieldset>
						<legend>Fieldset Title</legend>
						<ol>
							<li><label class="field-title">Reason <em>*</em>:</label>
							<label>
								<select name="reason" id="reason" class="txtbox-short">
									<option value="-1">Please Select</option>
									<option value="handling_ticket">Handling Ticket</option>
									<option value="ic_internal">IC/Internal</option>
									<option value="ubl">UBL</option>
									<option value="distributor">Distributor</option>																												
								</select>
								<span id="reason_error" class="form-error-inline" style="<?php echo($reason_error); ?>">Insert Reason</span>
							</label>
							<span class="clearFix">&nbsp;</span>
							</li>
							<li class="even">
								<label class="field-title">Description/Remarks <em>*</em>:</label>
								<label>
									<textarea name="remarks" id="remarks" rows="3" cols="5"></textarea>
									<span id="remarks_error" class="form-error-inline" style="<?php echo($remarks_error); ?>">Insert Remarks</span>
								</label>
								<span class="clearFix">&nbsp;</span>
							</li>
						</ol>
					</fieldset>
					<p class="align-right">
						<a id="btn_verify" class="button" href="javascript:document.xForm.submit();" onclick="javascript:document.xForm.submit();"><span>Submit</span></a>
						<input type="hidden" value="skip" id="skip" name="skip" />	
					</p>
					<span class="clearFix">&nbsp;</span>
				</form>
			</div>
        </div>
<?php include($site_admin_root."includes/footer.php"); ?>