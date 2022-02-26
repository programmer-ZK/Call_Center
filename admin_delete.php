<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "admin_delete";
	$page_title = "Delete Admin User";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Admin Delete";
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
	$admin_id 		= 	$tools_admin->decryptId($_REQUEST['admin_id']);
	$rsAdmin  		= 	$admin->get_admin_by_id($admin_id);
	if($rsAdmin->EOF){
		$_SESSION[$db_prefix.'_EM'] = "Admin panel user deletion rejected or not found.";
		header ("Location: admin_list.php");
		exit();
	}
	$full_name 		= 	$rsAdmin->fields['full_name'];

	if(isset($_REQUEST["yes"]) && !empty($_REQUEST["yes"])){
		$admin->delete_admin_user($admin_id);
		$_SESSION[$db_prefix.'_SM'] = "[".$full_name."] for admin panel inactive successfully.";
		header ("Location: admin_list.php");
		exit();
	}
	if(isset($_REQUEST["no"]) && !empty($_REQUEST["no"])){
		$_SESSION[$db_prefix.'_SM'] = "[".$full_name."] for admin panel deletion cancelled.";
		header ("Location: admin_list.php");
		exit();
	}
?>
<form name="listings" id="listings" action="<?php echo($page_name);?>.php" method="post" >
	<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $tools_admin->encryptId($admin_id); ?>" />
<div id="mid-col" class="mid-col">
<div class="box">
                <h4 class="white">Are you sure you want to delete <?php echo $full_name;  ?>  record?</h4>
        <div class="box-container" >
		<br />
		<div style="float:right;">
		<input type="submit" id="yes" name="yes" value="Yes"  class="buttonstyle"/>
        <input type="submit" id="no" name="no" value="No"  class="buttonstyle"/> </div>
		<br />
		<br />
    </div>
	</div>
	</div>
	
</form>
<?php include($site_root."includes/footer.php"); ?>
