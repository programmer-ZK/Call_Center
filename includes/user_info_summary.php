<?php if(!empty($customer_id) && !empty($account_no) && $_SESSION[$db_prefix.'_UserVerification'] == "yes"){ ?>
<div class="box">
  <h4 class="light-blue rounded_by_jQuery_corners" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">User Summary</h4>
  <div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
    <ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
     
<!--	 <li class="ui-accordion-li-fix"> <a href="user_etransactions.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Executed Transaction</a> </li>	
	 
	 <li class="ui-accordion-li-fix"> <a href="user_ptransactions.php?customer_id=<?php echo $tools_admin->encryptId($customer_id); ?>&account_no=<?php echo $tools_admin->encryptId($account_no); ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Pending Transaction</a> </li>	-->
	 	 	  
	  <?php 
			$method = 'IsPinExists';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
			$isPinGenerated = $soap_client->call_soap_method_2($method,$params);
			
			$method = 'GetContactRegisteredInfo';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
			$contactRegInfo = $soap_client->call_soap_method($method,$params);
			
	  ?>
       <li class="ui-accordion-li-fix"> <a href="" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span> Name: &nbsp;<?php echo $_SESSION[$db_prefix.'_CustomerName']; ?></a> </li>
	  
	  <li class="ui-accordion-li-fix"> <a href="" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span> Account No: &nbsp;<?php echo $account_no; ?></a> </li>	
	    <li class="ui-accordion-li-fix"> <a href="" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Customer Id: &nbsp;<?php echo $customer_id; ?></a> </li>	
		<li class="ui-accordion-li-fix"> <a href="" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Operating Type: &nbsp;<?php echo $_SESSION[$db_prefix.'_OperatingTypeCode']; ?></a> </li>	
		
		<?php if(empty($isPinGenerated)){?>
	  <li class="ui-accordion-li-fix"><a href="" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" > <span class="ui-icon ui-icon-triangle-1-s"></span>NO PIN GENERATED </a></li>
	  <?php } else { ?>
	  <li class="ui-accordion-li-fix"><a href="" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" > <span class="ui-icon ui-icon-triangle-1-s"></span> PIN GENERATED : Yes |  <?php echo $isPinGenerated; ?> </a></li>
	  <?php } ?>
	  <br />
	  <?php
	
	           $count = 0;
			  
               	//while($count != count($contactRegInfo))
				//{ ?>
				<li class="ui-accordion-li-fix">
					<?php 
						if(empty($contactRegInfo[$count]["ModifiedOn"]))
						{
							$contactregrnfo = " ";
						}
						else
						{
							$contactregrnfo = $contactRegInfo[$count]["ModifiedOn"];
						}
					if(!empty($contactRegInfo[$count]["IsMobileTransRegister"]))
					{
							  $regtype = "Mobile Register";
							  if($contactRegInfo[$count]["Status"] == "Executed")
							  {
							  	$isregistered= empty($contactRegInfo[$count]["IsMobileTransRegister"])?'NO':'YES';
							  }else
							  {
							  	$isregistered='NO';
							  }
							  
							  $status = $contactRegInfo[$count]["Status"];
						 ?>
						
						<a href="registeration_detail.php?regtype=<?php echo $regtype; ?>&isregistered=<?php echo $isregistered; ?>&status=<?php echo $status; ?>&date=<?php echo $contactregrnfo; ?>&account_no=<?php echo $account_no; ?>&customer_id=<?php echo $customer_id; ?>&tid=<?php echo $contactRegInfo[$count]["Id"]; ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" > <span class="ui-icon ui-icon-triangle-1-s"></span> IVR-Reg-Mob :  <?php echo $isregistered." | ".$contactregrnfo; ?> </a>
					<?php }
					if(!empty($contactRegInfo[$count]["IsResidenceRegister"]))
					{
						 	  $regtype = "Residence Register";
							   if($contactRegInfo[$count]["Status"] == "Executed")
							  {
							  	$isregistered= empty($contactRegInfo[$count]["IsResidenceRegister"])?'NO':'YES';
							  }else
							  {
							  	$isregistered='NO';
							  }
							  
							  $status = $contactRegInfo[$count]["Status"];
					?>
					
						<a href="registeration_detail.php?regtype=<?php echo $regtype; ?>&isregistered=<?php echo $isregistered; ?>&status=<?php echo $status; ?>&date=<?php echo $contactregrnfo; ?>&account_no=<?php echo $account_no; ?>&customer_id=<?php echo $customer_id; ?>&tid=<?php echo $contactRegInfo[$count]["Id"]; ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" > <span class="ui-icon ui-icon-triangle-1-s"></span> IVR-Reg-Res :  <?php echo $isregistered." | ".$contactregrnfo; ?> </a>
					<?php }
					if(!empty($contactRegInfo[$count]["IsOfficeRegister"]))
					{ 
						 	  $regtype = "Office Register";
							   if($contactRegInfo[$count]["Status"] == "Executed")
							  {
							  	$isregistered= empty($contactRegInfo[$count]["IsOfficeRegister"])?'NO':'YES';
							  }else
							  {
							  	$isregistered='NO';
							  }
							  
							  $status = $contactRegInfo[$count]["Status"];
					?>
						<a href="registeration_detail.php?regtype=<?php echo $regtype; ?>&isregistered=<?php echo $isregistered; ?>&status=<?php echo $status; ?>&date=<?php echo $contactregrnfo; ?>&account_no=<?php echo $account_no; ?>&customer_id=<?php echo $customer_id; ?>&tid=<?php echo $contactRegInfo[$count]["Id"]; ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" > <span class="ui-icon ui-icon-triangle-1-s"></span> IVR-Reg-Off :  <?php echo $isregistered." | ".$contactregrnfo; ?> </a>
					<?php }
					if(!empty($contactRegInfo[$count]["IsMobileSmsRegister"]))
					{ 
							  $regtype = "SMS Register";
							   if($contactRegInfo[$count]["Status"] == "Executed")
							  {
							  	$isregistered= empty($contactRegInfo[$count]["IsMobileSmsRegister"])?'NO':'YES';
							  }else
							  {
							  	$isregistered='NO';
							  }
							  
							  $status = $contactRegInfo[$count]["Status"];
					?>
						<a href="registeration_detail.php?regtype=<?php echo $regtype; ?>&isregistered=<?php echo $isregistered; ?>&status=<?php echo $status; ?>&date=<?php echo $contactregrnfo; ?>&account_no=<?php echo $account_no; ?>&customer_id=<?php echo $customer_id; ?>&tid=<?php echo $contactRegInfo[$count]["Id"]; ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" > <span class="ui-icon ui-icon-triangle-1-s"></span> SMS-Reg-Mob :  <?php echo $isregistered." | ".$contactregrnfo; ?> </a>
					<?php } ?>
						</li>
               	<?php  //$count++;
                //}
                ?>
	  
    </ul>
  </div>
</div>
<?php } else{ ?>

<?php } ?>
