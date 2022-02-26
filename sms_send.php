	
	<?php include_once("includes/config.php"); ?>
	<?php
		$page_name = "sms_send.php";
		$page_title = "SHORT MESSAGING SERVICE";
	$page_level = "0";
		$page_group_id = "0";
		$page_menu_title = "SHORT MESSAGING SERVICE";
	?>
	<?php include_once($site_root."includes/check.auth.php"); ?>
	
	<?php 	
	
	include_once("classes/tools.php");
	$tools = new tools();
	
		include_once("classes/tools_admin.php");
		$tools_admin = new tools_admin();
		
		include_once("classes/sms.php");
		$sms = new sms();
		
	$customer_id = $tools_admin->decryptId($_REQUEST['customer_id']);
	$account_no	 = $tools_admin->decryptId($_REQUEST['account_no']);
	
	include_once("classes/registration.php");
	$registration = new registration();
	
	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
	?>
	<?php include($site_root."includes/header.php"); ?>
	<script type="text/javascript">

	
	function msg_validate(){
	
		
			var body    = this.document.getElementById('wysiwyg');
		
			var number    = this.document.getElementById('title');
			
		
	
		var flag = true;
			var err_msg = '';
	
	if(number.value == ''){
					err_msg+= 'Enter Recipient Number\n';
					this.document.getElementById('number_error').style.display="";
			}
	
		 if(body.value == ''){
					err_msg+= 'Enter Message\n';
					this.document.getElementById('body_error').style.display="";
			}
	
	
			if(err_msg == '' && IsEmpty(err_msg)){
					return true;
			}
			else{
					return false;
			}
	}
	
	</script>
	<?php //echo'waleed';exit;
		
		//$method = 'SetSendSMS';
	//	$params = array('AccessKey' => $access_key,'Channel' => $channel,'CustomerId' => $customer_id,'AccountNo' => $account_no,'MobileNo' => $mobile_no,'SMSText' => $SMSText);
	
		$rs1 = $soap_client->call_soap_method($method,$params);
?>
	<?php
	
	
		$number	 				= $_REQUEST['number'];
		$body	 				= $_REQUEST['body'];
		
	
		
		$body_error	 			= "display:none;";
		$number_error	    		= "display:none;";
		
	
	if(isset($_POST['send']) ){
	 
		$flag = true;
		 if($number == ''){
				$number_error = "display:inline;";
				$flag = false;
		 }
		
		
	     if($flag == true){
	//write your code for sendnd and saving in database here
	
		$number		 			= $_REQUEST['number'];
		$body	 				= $_REQUEST['body'];		
//echo $customer_id .$account_no.	$number.$body;exit;
	
			$method = 'SetSendSMS';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'CustomerId' => $customer_id,'AccountNo' => $account_no,'MobileNo' => $number,'SMSText' => $body);
			
			
			$trans_id = $soap_client->call_soap_method_2($method,$params);
			
//			$sms->sms_save($number,$body,$datetime,$_SESSION[$db_prefix.'_UserId']);
			
			$_SESSION[$db_prefix.'_GM'] = "SMS send  successfully.";
			header ("Location: index.php");
			exit();			
		}		
		
		
		
	}
				
	?>
	
	
	<div class="box">      
	<h4 class="white">SHORT MESSAGING SERVICE(SMS)</h4>
	<div class="box-container">
			
	<form action="sms_send.php" method="post" class="middle-forms cmxform" name="xForm" id="xForm" enctype="multipart/form-data">
	
	
	<h3>SHORT MESSAGING SERVICE(SMS)</h3>
				
	<fieldset>
	<legend>Fieldset Title</legend>
	<ol>						
	
	<li class="even"><label class="field-title">Number <em>*</em>:</label> <label><input name="number" id="number" class="txtbox-short"><span class="form-error-inline" id="number_error" title="Please Insert Recipient Number"  style="<?php echo($number_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
	 <li class="odd"><label class="field-title">Your Messagae<em>*</em>:</label><label> 
<textarea id="<?php echo"wysiwyg"; ?>" name ="body" rows="7" cols="25" ></textarea>
																					
																							
<span class="form-error-inline" id="body_error" title="Please Insert Body"   style="<?php echo($body_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>



	 </ol><!-- end of form elements -->
	 </fieldset>
	 <p class="align-right">
			<a class="button" href="index.php" ><span>Back</span></a>
	
<a class="button" href="javascript:document.xForm.submit();"  onClick="javascript:return msg_validate('xForm');"><span>Send</span></a>
				<input type="hidden" name="send" id="send" >
								
	
	  </p>
	  <span class="clearFix">&nbsp;</span>
	  </form>
	  </div>
	  </div>
	  <?php
	  ?>
	  <?php include($site_root."includes/footer.php"); ?> 


