<?php
	
	/*$count = $user_pin->user_pin_verify_check($unique_id,$caller_id,$account_no,$customer_id,$staff_id);
	if($count > 0){
		$_SESSION[$db_prefix.'_UserPinVerification'] = true;
	}*/
?>
<?php // echo "Caller id-> ".$customer_id." account no --> ".$account_no." user verification --> ".$_SESSION[$db_prefix.'_UserVerification']." Is register user --> ".$_SESSION['ValidUser'];?>

<?php if(!empty($customer_id) && !empty($account_no) && strtoupper($_SESSION[$db_prefix.'_UserVerification']) == strtoupper("yes") && $_SESSION['ValidUser'] == 1 && strtoupper($_SESSION[$db_prefix.'_SkipVerification']) != strtoupper("yes")){ ?>

<div class="box">
  <h4 class="light-blue rounded_by_jQuery_corners" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Tele & SMS Transact</h4>
  <div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
    <ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
	
	  <?php 
	 /* echo $_SESSION[$db_prefix.'_CategoryType'];
	  echo $_SESSION[$db_prefix.'_SigningDetail'];
	  echo $_SESSION[$db_prefix.'_OperatingTypeCode'];
	  exit;*/
	  
	  if((strtoupper($_SESSION[$db_prefix.'_CategoryType']) == strtoupper("Individual")) && (strtoupper($_SESSION[$db_prefix.'_SigningDetail']) == strtoupper("Single")) || (strtoupper($_SESSION[$db_prefix.'_SigningDetail']) == strtoupper("Joint") && (strtoupper($_SESSION[$db_prefix.'_OperatingTypeCode']) <> strtoupper("Jointly")))){ 
	  
	  //Check if session variable for transaction menu is enable
	  if($_SESSION[$db_prefix.'_isEnableTransaction'] == 1 && !empty($_SESSION[$db_prefix.'_isPinGenerated']))
	  { ?>
      <li class="ui-accordion-li-fix"> <a href="redemption_new.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Redemption Add</a> </li>	 
	  
  <li class="ui-accordion-li-fix"> <a href="redemption_new2.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Redemption Add New</a> </li>

      <li class="ui-accordion-li-fix"> <a href="conversion_new.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Conversion Add</a> </li>
	  
	  <?php } 
	 
	  ?>	  
	  
	 <li class="ui-accordion-li-fix"> <a href="sms_service_request.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>SMS Service Request</a> </li>	  
	 
	 <li class="ui-accordion-li-fix"> <a href="ivr_service_request.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>IVR Service Request</a> </li>	
	 	 	 	  
	  <?php 
			/*$method = 'IsPinExists';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
			$isPinGenerated = $soap_client->call_soap_method_2($method,$params);*/
	  ?>
      <?php if(empty($_SESSION[$db_prefix.'_isPinGenerated']))
	   {?>
	  <li class="ui-accordion-li-fix"> <a href="pin_generation.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>&action=pgen" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Pin Generation</a> </li>
	  
  <?php } else 
  		{ ?>
	  
	 <!-- <li class="ui-accordion-li-fix"> <a href="pin_generation.php?customer_id=<?php //echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php //echo $tools_admin->encryptId($account_no); ?>&action=pver" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Pin Generated : <?php //echo ($count > 0)?"Yes":"No";?></a> </li>-->
	  <li class="ui-accordion-li-fix"> <a href="pin_generation.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>&action=pres" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Pin Reset </a> </li>
	  <li class="ui-accordion-li-fix"> <a href="pin_generation.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>&action=pchn" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Pin Change </a> </li>
	  
	   <li class="ui-accordion-li-fix"> <a href="profile_update.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Profile Update</a> </li>




	  
	  
	  
  <?php }
  
   }
   ?>
    </ul>
  </div>
</div>
<?php } else{ ?>

<?php } ?>
