<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "redemption_new.php";
	$page_title = "Add/Update Redemption";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Redemption";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	$customer_id = $_REQUEST['customer_id'];
	$account_no	 = $_REQUEST['account_no'];
	
	include_once("classes/transactions.php");
	$transactions = new transactions();
	
	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$sOap_client = new soap_client();
?>

<?php include($site_root."includes/iheader.php"); ?>



<?php
	
	$account_no 				= $_REQUEST['account_no'];
	$customer_id 				= $_REQUEST['customer_id'];
	$solution_type 				= $_REQUEST['solution_type'];
	$types_of_units 			= $_REQUEST['types_of_units'];
	$unit_value 				= $_REQUEST['Unit']; 
	$unit_rdio			  		= $_REQUEST['unit_rdio'];
	$modeofpayment 	  			= $_REQUEST['modeofpayment']; 
	$bank_account_no 			= $_REQUEST['bank_account_no'];
	$bank_account_title 		= $_REQUEST['bank_account_title']; 
	$bank_branch_name 	  		= $_REQUEST['bank_branch_name']; 
	$bank_branch_code 			= $_REQUEST['bank_branch_code'];
	$bank_name 	  				= $_REQUEST['bank_name'];
	$city_name					= $_REQUEST['city_name'];
	$type1						= $_REQUEST['type1'];

	

?>

      	<div class="box">      
      		<h4 class="white"><?php echo $page_menu_title ;?></h4>
        <div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
		<!--<input type="hidden" id="customer_id_h" name="customer_id_h" value="<?php // echo customer_id); ?>">
		<input type="hidden" id="account_no_h" name="account_no_h" value="<?php //echo account_no); ?>">-->
		<input type="hidden" id="account_no" name="account_no" value="<?php echo $account_no; ?>">
		<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
<li class="even">
                            <label class="field-title">Account No <em>*</em>:</label>
                            <label>
          <input name="account_no" id="account_no" class="txtbox-long" value="<?php echo $account_no; ?>" disabled="disabled">
          </label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Customer ID <em>*</em>:</label>
                            <label>
          <input name="customer_id" id="customer_id" class="txtbox-long" value="<?php echo $customer_id; ?>" disabled="disabled">
          </label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title">Solution Type <em>*</em>:</label>
                            <label><input name="type1" id="type1" class="txtbox-long" value="<?php echo $type1." - ".$solution_type; ?>" disabled="disabled">
							
       
       </label>
                            <span  class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Types of Units <em>*</em>:</label>
                            <label id="types_of_units_label"><input name="types_of_units" id="types_of_units" class="txtbox-long" value="<?php echo $types_of_units; ?>" disabled="disabled">
          					
         </label>
                            <span  class="clearFix">&nbsp;</span></li>
							
<li class="even">
								<label class="field-title">Amount / Value <em>*</em>:</label>
								<label ><input name="unit_value" id="unit_value" class="txtbox-long" value="<?php echo $unit_value." -- ".$unit_rdio; ?>" disabled="disabled">
								 </label>
								<span class="clearFix">&nbsp;</span></li>
<!--<li class="even">
								
							
							</li>-->

							
<li >
                            <label class="field-title">Mode of Payment <em>*</em>:</label>
                            <label><input name="modeofpayment" id="modeofpayment" class="txtbox-long" value="<?php echo $modeofpayment; ?>" disabled="disabled">
         </label>
                            <span  class="clearFix">&nbsp;</span></li>
							
							
							
							<div id="city_name_div">
								<li class="even">
                            <label class="field-title"> City Name<em>*</em>:</label>
                            <label><input name="city_name" id="city_name" class="txtbox-long" value="<?php echo $city_name; ?>" disabled="disabled">
         					
								</label>
                            <span class="clearFix">&nbsp;</span></li>
							</div>
							
						<div id="bank_detail_div"  >
							
						
							
							
													
							<li >
                            <label class="field-title"> Bank Account No<em>*</em>:</label>
                            <label><input name="bank_account_no" id="bank_account_no" class="txtbox-long" value="<?php echo $bank_account_no; ?>" disabled="disabled">
         </label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title"> Bank Account Title<em>*</em>:</label>
                            <label><input name="bank_account_title" id="bank_account_title" class="txtbox-long" value="<?php echo $bank_account_title; ?>" disabled="disabled">
         </label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title"> Bank Branch Name<em>*</em>:</label>
                            <label><input name="bank_branch" id="bank_branch" class="txtbox-long" value="<?php echo $bank_branch_name; ?>" disabled="disabled">
          </label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title"> Bank Name<em>*</em>:</label>
                            <label><input name="bank_name" id="bank_name" class="txtbox-long" value="<?php echo $bank_name; ?>" disabled="disabled">
         </label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title"> Bank Branch Code<em>*</em>:</label>
                            <label><input name="bank_branch_code" id="bank_branch_code" class="txtbox-long" value="<?php echo $bank_branch_code; ?>" disabled="disabled">
          </label>
                            <span class="clearFix">&nbsp;</span></li>
      					
					</div>
						</ol>
      				</fieldset> 
      				<p class="align-right">
					<?php   if(isset($admin_id) && !empty($admin_id)){?>
						<a class="button" href="javascript:document.xForm.submit();"  ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<input onclick="closeAndSubmit();" type="button" name="SubmitButton" value="Confirm / Add">
									<input onclick="javascript:window.close();" type="button" name="Cancel" value="Cancel">
               				<?php    }?>					
					<!--<input type="image" src="images/bt-send-form.gif" />-->
				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div>
      	</div>
	<script type="text/javascript">
	function closeAndSubmit() {
	if (window.opener &&!window.opener.closed) {
		window.opener.document.xForm.submit();
		window.close();
	}
	}
	
	</script> 
<?php include($site_root."includes/ifooter.php"); ?> 
