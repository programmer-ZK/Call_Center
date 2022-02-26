<?php include_once("includes/config.php"); ?>
<?php include_once("classes/admin.php"); 
	$admin = new admin(); 
	global $admin;
?>
<?php
        $page_name = "logout";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "logout";
        $page_menu_title = "logout";

?>
<?php
	
	//echo $_SESSION[$db_prefix.'_UserId']; exit;
	$admin->usr_logout($_SESSION[$db_prefix.'_UserEmail'] , $_SESSION[$db_prefix.'_UserId']) ;
	
	session_destroy();
	header("Location: login.php");
	exit();
?>
