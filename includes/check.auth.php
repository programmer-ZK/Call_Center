<?php
include_once("classes/admin.php");
$admin = new admin();

if ($_SESSION['admin_login'] <> "true") {
	header("Location: login.php");
} else {
	$rs_agent_name = $admin->get_agent_name($_SESSION[$db_prefix . '_UserId']);
	// echo $_SESSION[$db_prefix . '_UserPassword'];
	// echo "<br>";
	// echo $rs_agent_name->fields["password"];
	if ($rs_agent_name->fields["password"] != $_SESSION[$db_prefix . '_UserPassword']) {
		header("Location: logout.php");
	}
}
?>
<?php

include_once("classes/security.php");
$security = new security();
$page_id = $security->check_page_info($page_title, $page_name, $page_level, $page_menu_title, $page_group_id);
//echo $page_name; exit;
/*if($page_name!="index" || $page_name!="login"  || $page_name!="logout" || $page_name!="admin_change_password"){
		if($security->get_page_privilege_by_group($_SESSION[$db_prefix.'_AdminGroup_ID'], $page_id)!="1"){
			header("Location: auth.php");
			exit();
		}
		$rsPage=NULL;
	}
	*/

?>
