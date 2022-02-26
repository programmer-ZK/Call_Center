<?php
$iurl = "customer_detail.php?customer_id=".$tools_admin->encryptId($_REQUEST["customer_id"])."&account_no=".$tools_admin->encryptId($_REQUEST["account_no"])."&tab="; 
?>
 <div class="box" >  <!--id="mid-tab" -->
        <ul class="tab-menu">
                  <li><a href="<?php echo $iurl;?>profile">Profile</a></li>
		  		  <li><a href="<?php echo $iurl;?>contact">Contacts</a></li>
                  <li><a href="<?php echo $iurl;?>account">Account</a></li>
              	  <li><a href="<?php echo $iurl;?>balance">Balance</a></li>
				  <li><a href="<?php echo $iurl;?>beneficiary">Beneficiary</a></li>
  		  		  <li><a href="<?php echo $iurl;?>nominee">Nominee</a></li>
  		  		  <li><a href="<?php echo $iurl;?>jointholder">Joint Holder</a></li>
				  <li><a href="<?php echo $iurl;?>user_ptransaction">Pending Trans</a></li>
				  <li><a href="<?php echo $iurl;?>user_etransaction">Executed Trans</a></li>
  				  <li><a href="<?php echo $iurl;?>reg_history">Reg History</a></li>
  				  <li><a href="<?php echo $iurl;?>pin_history">Pin History</a></li>	
				   <li><a href="<?php echo $iurl;?>statement_link">Statement Link</a></li>	
				  			  
		</ul>
			<?php if($_REQUEST["tab"] ==  "profile") { ?>
			<div class="box-container" id="profile"><?php include($site_root."includes/user_profile.php"); ?></div>
			<?php } else if($_REQUEST["tab"] ==  "contact") { ?>
			<div class="box-container" id="contact"><?php include($site_root."includes/user_icontacts.php"); ?></div>			
			<?php } else if($_REQUEST["tab"] ==  "account") { ?>			
			<div class="box-container" id="account"><?php include($site_root."includes/user_account.php"); ?></div>
			<?php } else if($_REQUEST["tab"] ==  "balance") { ?>			
			<div class="box-container" id="balance"><?php include($site_root."includes/user_balance.php"); ?></div>			
			<?php } else if($_REQUEST["tab"] ==  "beneficiary") { ?>			
			<div class="box-container" id="beneficiary"><?php include($site_root."includes/user_beneficiary.php"); ?></div>
			<?php } else if($_REQUEST["tab"] ==  "nominee") { ?>			
			<div class="box-container" id="nominee"><?php include($site_root."includes/user_nominee.php"); ?></div>
			<?php } else if($_REQUEST["tab"] ==  "jointholder") { ?>			
			<div class="box-container" id="jointholder"><?php include($site_root."includes/user_jointholder.php"); ?></div>
			<?php } else if($_REQUEST["tab"] ==  "user_ptransaction") { ?>			
			<div class="box-container" id="user_ptransaction"><?php include($site_root."includes/user_ptransactions.php"); ?></div>
			<?php } else if($_REQUEST["tab"] ==  "user_etransaction") { ?>			
			<div class="box-container" id="user_etransaction"><?php  include($site_root."includes/user_etransactions.php"); ?></div>
			<?php } else if($_REQUEST["tab"] ==  "reg_history") { ?>			
			<div class="box-container" id="reg_history"><?php  include($site_root."includes/user_registertion_history.php"); ?></div>			
			<?php } else if($_REQUEST["tab"] ==  "pin_history") { ?>			
			<div class="box-container" id="pin_history"><?php  include($site_root."includes/user_pin_history.php"); ?></div>						
			<?php } else if($_REQUEST["tab"] ==  "statement_link") { ?>
			<div class="box-container" id="statement_link"><?php  include($site_root."includes/statement_link.php"); ?></div>	
			<? } ?>
			
			
</div>
