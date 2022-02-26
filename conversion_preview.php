<?php include_once("includes/config.php"); 


	

?>
<?php
	$page_name = "conversion_preview.php";
	$page_title = "Add/Update Conversion Preview";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Conversion Preview";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();

	
	
	include_once("classes/transactions.php");
	$transactions = new transactions();
	
	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
?>
<?php include($site_root."includes/iheader.php"); ?>

<?php
	
	
	$customer_id					= $_REQUEST['customer_id'];
	$account_no						= $_REQUEST['account_no'];
	$transaction_nature 			= $_REQUEST['transaction_nature'];
	$from_fund 						= $_REQUEST['from_fund'];
	$from_unit_type 				= $_REQUEST['from_fund_types_of_units'];
	$to_fund 						= $_REQUEST['to_fund'];
	$to_unit_type 				  	= $_REQUEST['to_fund_types_of_units']; 
	$units 			  				= $_REQUEST['unit_value']; 
	$unit_rdio			  			= $_REQUEST['unit'];

?>

      	<div class="box">      
      		<h4 class="white"><?php echo $page_menu_title ;?></h4>
        <div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
		<input type="hidden" id="id" name="id" value="<?php echo $tools_admin->encryptId($id); ?>">
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
          <!--<span id="account_no_error" class="form-error-inline" title = "Please Insert Account No" style="<?php echo($account_no_error); ?>"></span>--></label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Customer ID <em>*</em>:</label>
                            <label>
          <input name="customer_id" id="customer_id" class="txtbox-long" value="<?php echo $customer_id; ?>" disabled="disabled">
          <!--<span id="	customer_id_error" class="form-error-inline" title = "Pleaes Insert Customer ID"style="<?php echo($customer_id_error); ?>"></span>--></label>
                            <span class="clearFix">&nbsp;</span></li>
                   
                      <li >
                            <label class="field-title">Conversion Type <em>*</em>:</label>
                            <label ><input name="transaction_nature" id="transaction_nature" class="txtbox-long" value="<?php echo $transaction_nature; ?>" disabled="disabled">
                      </label>
                            <span  class="clearFix">&nbsp;</span></li>
                      <li class="even">
                            <label class="field-title">From Fund <em>*</em>:</label>
                            <label id="from_fund_label"><input name="from_fund" id="from_fund" class="txtbox-long" value="<?php echo $from_fund; ?>" disabled="disabled">
                        
                      </label>
                            <span class="clearFix">&nbsp;</span></li>
                      <li id = "from_fund_li">
                            <label class="field-title">From Unit Type <em>*</em>:</label>
                            <label id="from_fund_label2"><input name="from_unit_type" id="from_unit_type" class="txtbox-long" value="<?php echo $from_unit_type; ?>" disabled="disabled">
                        
                        </label>
                            <span class="clearFix">&nbsp;</span></li>
                      <li class="even">
                            <label class="field-title">To Fund <em>*</em>:</label>
                            <label id="to_fund_label"><input name="to_fund" id="to_fund" class="txtbox-long" value="<?php echo $to_fund; ?>" disabled="disabled">
                        
                        </label>
                            <span class="clearFix">&nbsp;</span></li>
                      <li id = "to_fund_li" >
                            <label class="field-title">To Unit Type <em>*</em>:</label>
                            <label id="to_fund_label2"><input name="to_unit_type" id="to_unit_type" class="txtbox-long" value="<?php echo $to_unit_type; ?>" disabled="disabled">
                        
                       <!-- <span id="to_unit_type_error" class="form-error-inline" title = "Please Select To Unite Type" style="<?php echo($to_unit_type_error); ?>"></span>--></label>
                            <span  class="clearFix">&nbsp;</span></li>
							
								<li >
									<label class="field-title">Amount / Value <em>*</em>:</label>
									<label >
									<input name="unit_value" id="unit_value" class="txtbox-long" value="<?php echo $units." ".$unit_rdio; ?>" onchange="" disabled="disabled"></label>
									<span class="clearFix">&nbsp;</span>
								</li>
								
				      
                    </ol>
      				</fieldset> 
      				<p class="align-right">
					<?php   if(isset($admin_id) && !empty($admin_id)){?>
						<a class="button" href="javascript:document.xForm.submit();"  ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    			<!--	<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Add</span></a>-->
									<input onclick="closeAndSubmit();" type="button" name="SubmitButton" value="Confirm / Add">
									<input onclick="javascript:window.close();" type="button" name="Cancel" value="Cancel">
						<!--<input type="hidden" value="CREATE NEW ADMIN >>" id="add" name="add" />-->
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
