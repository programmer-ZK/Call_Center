<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "customer_detail.php";
	$page_title = "Customer Detail";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Customer Detail";
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
?>
<?php include($site_root."includes/header.php"); ?>
<?php 

if($_REQUEST['action'] == "cancel_pgen"){
	$user_pin->update_user_status($unique_id,$caller_id,201,3,$_SESSION[$db_prefix.'_UserId']);  // from pin genration to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-200",3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"200",3,$_SESSION[$db_prefix.'_UserId']); 
	$user_pin->user_pin_process_fail($unique_id,$caller_id,$account_no,$customer_id,$_SESSION[$db_prefix.'_UserId']);
}

else if($_REQUEST['action'] == "cancel_pres"){
	$user_pin->update_user_status($unique_id,$caller_id,401,3,$_SESSION[$db_prefix.'_UserId']);  // from pin genration to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-400",3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"400",3,$_SESSION[$db_prefix.'_UserId']); 
	$user_pin->user_pin_reset_fail($unique_id,$caller_id,$account_no,$customer_id,$_SESSION[$db_prefix.'_UserId']);
}
else if($_REQUEST['action'] == "cancel_pchn"){
	$user_pin->update_user_status($unique_id,$caller_id,501,3,$_SESSION[$db_prefix.'_UserId']);  // from pin genration to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-500",3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"500",3,$_SESSION[$db_prefix.'_UserId']); 
	$user_pin->update_user_status($unique_id,$caller_id,601,3,$_SESSION[$db_prefix.'_UserId']);  // from pin genration to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-600",3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"600",3,$_SESSION[$db_prefix.'_UserId']); 
	$user_pin->user_pin_change_fail($unique_id,$caller_id,$account_no,$customer_id,$_SESSION[$db_prefix.'_UserId']);
}
else if($_REQUEST['action'] == "cancel_pver"){
	$user_pin->update_user_status($unique_id,$caller_id,301,3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-300",3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"300",3,$_SESSION[$db_prefix.'_UserId']);
	$user_pin->user_pin_process_fail($unique_id,$caller_id,$account_no,$customer_id,$_SESSION[$db_prefix.'_UserId']);
}
else if($_REQUEST['action'] == "success_pver"){
	$user_pin->update_user_status($unique_id,$caller_id,300,3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-300",3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	//header ("Location: ".$_SESSION[$db_prefix.'_Page']."?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no));
	//header ("Location: ".$_SESSION[$db_prefix.'_Page']);
	//exit();	
}
else if($_REQUEST['action'] == "success_pres"){
	$user_pin->update_user_status($unique_id,$caller_id,400,3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-400",3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	//header ("Location: ".$_SESSION[$db_prefix.'_Page']."?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no));
	//header ("Location: ".$_SESSION[$db_prefix.'_Page']);
	//exit();	
}
else if($_REQUEST['action'] == "success_pchn"){
	$user_pin->update_user_status($unique_id,$caller_id,500,3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-500",3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,600,3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-600",3,$_SESSION[$db_prefix.'_UserId']);  // from pin verfication to talking
	//header ("Location: ".$_SESSION[$db_prefix.'_Page']."?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no));
	//header ("Location: ".$_SESSION[$db_prefix.'_Page']);
	//exit();	
}
else if($_REQUEST['action'] == "success_pgen"){
	$user_pin->update_user_status($unique_id,$caller_id,200,3,$_SESSION[$db_prefix.'_UserId']);  // from pin generation to talking
	$user_pin->update_user_status($unique_id,$caller_id,"-200",3,$_SESSION[$db_prefix.'_UserId']);  // from pin generation to talking
	//header ("Location: ".$_SESSION[$db_prefix.'_Page']."?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no));
	//exit();
}


include($site_root."includes/middle_tab.php");

?>

<?php include($site_root."includes/footer.php"); ?> 
