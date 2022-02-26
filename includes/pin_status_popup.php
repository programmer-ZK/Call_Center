<?php 	
	include_once("classes/user_pin.php");
	$user_pin = new user_pin();

				
	$rst = $tools_admin->get_caller_id($_SESSION[$db_prefix.'_UserId']); 

	$id 				= $rst->fields["id"];
	$unique_id 			= $rst->fields["unique_id"];
	$caller_id 			= $rst->fields["caller_id"];
	$status 			= $rst->fields["status"];
	$update_datetime	= $rst->fields["update_datetime"];
	$minutes			= $rst->fields["minutes"];
	$seconds			= $rst->fields["seconds"];
	
	$_SESSION['unique_id'] = $unique_id;
	$_SESSION['caller_id'] = $caller_id;

	if($status == "-5" ){
		$status_str = "Pin Generated Successfully";
		$user_pin->update_user_status($unique_id,$caller_id,'-5',3,$_SESSION[$db_prefix.'_UserId']);
	}
	else if($status == "-6" ){
		$user_pin->update_user_status($unique_id,$caller_id,'-6',3,$_SESSION[$db_prefix.'_UserId']);
		$status_str = "Pin Verify Successfully";	
	}
	else 
		$status_str = "";		

?>


<?php if(!empty($caller_id) && !empty($status_str)) { $ispopupshow = 1; ?>
	<?php include($site_root."includes/popup.php"); ?>
<?php }else { ?>

<?php } ?>