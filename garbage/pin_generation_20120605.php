<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "pin_genration.php";
        $page_level = "2";
        $page_group_id = "1";
        $page_title = "Pin Processing";
        $page_menu_title = "Pin Processing";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
		
        include_once("classes/user_pin.php");
        $user_pin = new user_pin();
		
		
		$unique_id		= $_SESSION['unique_id'];
		$caller_id		= $_SESSION['caller_id'];
		
		//$unique_id		= '123464';
		//$caller_id		= '02348876609';		
		
		$customer_id	= $_REQUEST['customer_id'];
		$account_no		= $_REQUEST['account_no'];
		

		if($_REQUEST['action'] == "pgen"){
			$user_pin->insert_user_pin_process($unique_id,$caller_id,$account_no,$customer_id,$_SESSION[$db_prefix.'_UserId']);
			$user_pin->update_user_status($unique_id,$caller_id,3,201,$_SESSION[$db_prefix.'_UserId']);  // from talking to pin genration
		}
		else if($_REQUEST['action'] == "pres"){
			$user_pin->insert_user_pin_reset($unique_id,$caller_id,$account_no,$customer_id,$_SESSION[$db_prefix.'_UserId']);
			$user_pin->update_user_status($unique_id,$caller_id,3,401,$_SESSION[$db_prefix.'_UserId']);  // from talking to pin genration
		}
		else if($_REQUEST['action'] == "pver"){
			$user_pin->insert_user_pin_verfiy($unique_id,$caller_id,$account_no,$customer_id,$_SESSION[$db_prefix.'_UserId']);
			$user_pin->update_user_status($unique_id,$caller_id,3,301,$_SESSION[$db_prefix.'_UserId']);  // from talking to pin verify
		}
		else if($_REQUEST['action'] == "pchn"){
			$user_pin->insert_user_pin_change($unique_id,$caller_id,$account_no,$customer_id,$_SESSION[$db_prefix.'_UserId']);
			$user_pin->update_user_status($unique_id,$caller_id,3,501,$_SESSION[$db_prefix.'_UserId']);  // from talking to pin verify
		}
	/*
		$caller_id = '02348876609';		
		$method = 'GetContactDetail';
		$params = array('AccessKey' => $access_key,'CallerId' => $caller_id, 'Channel' => $channel);
		$rs1 = $soap_client->call_soap_method($method,$params);
	*/
		
?>

<?php include($site_root."includes/header.php"); ?>
      	<div class="box">
		<h4 class="white"><?php echo($page_title); ?></h4>
        	<div class="box-container">
			<form action="" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
			<?php if($_REQUEST['action'] == "pgen")
	   	  { 
						$_SESSION[$db_prefix.'_Page'] = "customer_detail.php?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no)."&tab=profile&action=success_pgen";
			?>
				<h3>Please Transfer the call to 5001 for Pin Generation </h3>
				
	<?php } 
		  else if($_REQUEST['action'] == "pres")
		  { 
						$_SESSION[$db_prefix.'_Page'] = "customer_detail.php?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no)."&tab=profile&action=success_pres";
			?>
				<h3>Please Transfer the call to 5003 for Pin Reset </h3>
			<?php 
		  }
		  else if($_REQUEST['action'] == "pver")
		  { 
		  	$_SESSION[$db_prefix.'_Page'] = "customer_detail.php?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no)."&tab=profile&action=success_pver";
		  ?>
				
				<h3>Please Transfer the call to 5002 for Pin Verification </h3>
			<?php 
		  } 
		  else if($_REQUEST['action'] == "pchn")
		  { 
		  	$_SESSION[$db_prefix.'_Page'] = "customer_detail.php?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no)."&tab=profile&action=success_pchn";
		  
		  ?>
			
				<h3>Please Transfer the call to 5004 for Pin change </h3>
			<?php 
		  } ?>
			
			<?php if(empty($caller_id)){ ?>
			<?php } else { ?>
			<a href="customer_detail.php?customer_id=<?php echo $_REQUEST['customer_id'];  ?>&account_no=<?php echo $_REQUEST['account_no'];  ?>&tab=profile" class="table-edit-link">Please Click Here to go User Profile</a>
			<?php } ?>
			<br /> 
			<?php $_SESSION[$db_prefix.'_FPage'] = "customer_detail.php?customer_id=".$_REQUEST['customer_id']."&account_no=".$_REQUEST['account_no']."&action=cancel_".$_REQUEST['action']."&tab=profile"; ?>
			<a class="button" href="customer_detail.php?customer_id=<?php echo $_REQUEST['customer_id']; ?>&account_no=<?php echo $_REQUEST['account_no'];  ?>&action=cancel_<?php echo $_REQUEST['action']; ?>&tab=profile" onclick=""><span>Back</span></a>
			</form>
			</div>
      	</div> 
<?php include($site_root."includes/footer.php"); ?>      
