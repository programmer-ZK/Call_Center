<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "admin_groups_delete";
	$page_title = "Admin Group Delete";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Admin Group Delete";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php include($site_root."includes/header.php"); ?>
<?php
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();

	include_once("classes/admin.php");
	$admin = new admin();
?>

<?php
	$group_id 	= 	$tools_admin->decryptId($_REQUEST['group_id']);
	$rsAdmin	=	$admin->get_admin_group_by_id($group_id);
	if($rsAdmin->EOF){
		$_SESSION[$db_prefix.'_EM'] = "Admin group deletion rejected or not found.";
		header ("Location: admin_groups_list.php");
		exit();
	}
	$group_name = 	$rsAdmin->fields['group_name'];

	if(isset($_REQUEST["yes"]) && !empty($_REQUEST["yes"])){
		$admin->delete_admin_groups($group_id);
		$_SESSION[$db_prefix.'_SM'] = "[".$group_name."] for admin group inactive successfully.";
		header ("Location: admin_groups_list.php");
		exit();
	}
	if(isset($_REQUEST["no"]) && !empty($_REQUEST["no"])){
		$_SESSION[$db_prefix.'_EM'] = "[".$group_name."] for admin group deletion cancelled.";
		header ("Location: admin_groups_list.php");
		exit();
	}
?>
<form name="listings" id="listings" action="<?php echo($page_name);?>.php" method="post" >
	<input type="hidden" id="group_id" name="group_id" value="<?php echo $tools_admin->encryptId($group_id); ?>" />
    <div>Are you sure you want to delete this record?</div>
    <div >
    <br />
        <div  ><input type="submit" id="yes" name="yes" value="Yes"  class="buttonstyle"/></div>
        <div ><input type="submit" id="no" name="no" value="No" class="buttonstyle"/></div>
    </div>
</form>
<?php include($site_root."includes/footer.php"); ?>
